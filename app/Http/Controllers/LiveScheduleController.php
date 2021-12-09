<?php

namespace App\Http\Controllers;

use App\Course;
use App\CoursePurchase;
use App\Enroll;
use App\LiveSchedule;
use App\LiveScheduleUser;
use App\RequiredCourseWorkforce;
use App\Section;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LiveScheduleController extends Controller
{
   public function Index($slug)
   {
      $title = __t('Live Schedule');
      $sectionId = [];
      $course = Course::where('slug', $slug)->first();
      $courseId = $course->id;
      $courseSlug = $slug;
      $section = Section::where([['course_id', $courseId], ['section_type', 3]])->get();
      if ($section) {
         foreach ($section as $sections) {
            $sectionId[] = $sections->id;
         }
      }
      $live = LiveSchedule::where(function ($q) use ($sectionId) {
         if ($sectionId != null) {
            $q->whereIn('section_id', $sectionId);
         }
      })
         ->get();
      return view(theme('dashboard.live-schedule.index'), compact('title', 'live', 'courseSlug'));
   }
   public function createForm($slug)
   {
      $title = __t('live_schedule');
      $purchaseUser = [];
      $userName = [];
      $course = Course::where('slug', $slug)->first();
      $courseId = $course->id;
      $section = Section::where('course_id', $courseId)->where('section_type', 3)->get();
      $coursePurchase = Enroll::where('course_id', $courseId)->get();
      if ($coursePurchase) {
         foreach ($coursePurchase as $purchaseUserId) {
            // $requiredWorkForce = RequiredCourseWorkforce::where('course_purchase_id', $purchase->id)->get();
            // if ($requiredWorkForce) {
            // foreach ($purchaseUser as $userId) {
            $purchaseUser[] = $purchaseUserId->user_id;
            // }
            $userName = User::whereIn('id', $purchaseUser)->select('name', 'id')->get();
            // }
            //   dd($userName);

         }
      }


      return view(theme('dashboard.live-schedule.create'), compact('title', 'userName', 'courseId', 'section'));
   }

   public function create(Request $request,$slug)
   {
  $rules = [
      'section'  => 'required',
      'seat_available'  => 'required',
      'max_num_of_participate'  => 'required',
      'event_date_time'  => 'required',
      'expiry_date_time'  => 'required',

  ];

  $this->validate($request, $rules);
//   dd($request->all());

      $courseId =   $request->course_id;
      // dd($courseId);
      $course = Course::find($courseId);

      $employee = $request->employees;
      $seatAvailable = $request->seat_available;
      $participate = $request->max_num_of_participate;
      $zoom = $request->zoom_link;
      $eventTime = $request->event_date_time;
      $expiryTime = $request->expiry_date_time;
      $team = $request->team_link ;
      // DB::beginTransaction();
      // try {
         $live = new LiveSchedule();
         $live->created_by =Auth::user()->id;
         $live->section_id = $request->section;
         $live->seat_available = $seatAvailable;
         $live->max_num_of_participate = isset($participate) ? $participate : "";
         $live->zoom_link = isset($zoom) ? $zoom : "";
         $live->event_date_time = isset($eventTime) ? $eventTime : "";
         $live->expiry_date_time = isset($expiryTime) ? $expiryTime : "";
         $live->team_link = isset($team) ? $team : "";
         $live->save();
         if (is_array($employee)) {
            foreach ($employee as $key => $employeeList) {
               if ($employeeList != '' && $employeeList != 0) {
                  $scheduleUser = new LiveScheduleUser();

                  $scheduleUser->live_schedule_id = $live->id;
                  $scheduleUser->user_id = $employeeList;
                  $scheduleUser->save();
                  //   Notification  section 

                  $user = $employeeList;
                  $notification = "You have a new Live section in  $course->title  course ...Team Link: $live->team_link   ,Please join Befote  $live->expiry_date_time  ";
                  $model_id = $course->id;
                  $model = "live-section";
                  userNotification($user, $notification, $model_id, $model);
               }
            }
         }

         // DB::commit();
      // } catch (Exception $e) {
         // DB::rollBack();
      // }
      return redirect('dashboard/courses/live-schedule/'.$slug );
   }

   public function edit(Request $request, $id)
   {
      $title = __t('live_schedule');
      $purchaseUser = [];
      $userName = [];
      $liveSchedule = LiveSchedule::where('id', $id)->first();
      if (empty($liveSchedule)) {
         return redirect()->back();
      }
      $sectionId = $liveSchedule->section_id;
      $section = Section::where('id', $sectionId)->first();
      $courseId = $section->course_id;
      $section = Section::where('course_id', $courseId)->where('section_type', 3)->get();
      $coursePurchase = Enroll::where('course_id', $courseId)->get();
      if ($coursePurchase) {
         foreach ($coursePurchase as $purchaseUserId) {
            $purchaseUser[] = $purchaseUserId->user_id;
            $userName = User::whereIn('id', $purchaseUser)->select('name', 'id')->get();
         }
      }


      return view(theme('dashboard.live-schedule.edit'), compact('title', 'userName', 'courseId', 'section', 'liveSchedule'));
   }

   public function update(Request $request, $id)
   {
      //   dd($request->all());

      // dd($request->all());
      $employee = $request->employees;
      $seatAvailable = $request->seat_available;
      $participate = $request->max_num_of_participate;
      $zoom = $request->zoom_link;
      $eventTime = $request->event_date_time;
      $expiryTime = $request->expiry_date_time;
      $team = $request->team_link ;

      DB::beginTransaction();
      try {
         $live =  LiveSchedule::find($id);
         $live->section_id = $request->section;
         $live->seat_available = $seatAvailable;
         $live->max_num_of_participate = isset($participate) ? $participate : "";
         $live->zoom_link = isset($zoom) ? $zoom : "";
         $live->event_date_time = isset($eventTime) ? $eventTime : "";
         $live->expiry_date_time = isset($expiryTime) ? $expiryTime : "";
         $live->team_link = isset($team) ? $team : "";
         // $live->user_id = isset($employee) ? $employee : "";
         $live->save();
         if (is_array($employee)) {
            LiveScheduleUser::where('live_schedule_id', $id)->delete();
            foreach ($employee as $key => $employeeList) {
               if ($employeeList != '' && $employeeList != 0) {
                  $scheduleUser = new LiveScheduleUser();
                  $scheduleUser->live_schedule_id = $id;
                  $scheduleUser->user_id = $employeeList;
                  $scheduleUser->save();
               }
            }
         }
         DB::commit();
      } catch (Exception $e) {
         DB::rollBack();
      }
      return redirect()->back();
   }


   //admin view all live schedule

   public function adminLiveIndex()
   {
      $title = __t('live_schedule');
      $live = LiveSchedule::get();
     return view('admin.live-schedule.index',compact('live','title'));
   }
}