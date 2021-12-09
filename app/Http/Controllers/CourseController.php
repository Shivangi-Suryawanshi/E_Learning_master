<?php

namespace App\Http\Controllers;

use App\AssignmentSubmission;
use App\Attachment;
use App\Category;
use App\Course;
use App\Activity;
use App\Review;
use App\Section;
use App\Content;
use App\CourseAssignTrainer;
use App\CoursePurchase;
use App\Industry;
use App\InstructorTrainer;
use App\LiveSchedule;
use App\Mail\UserRegistrationMail;
use App\Occupation;
use App\RequiredCourseWorkforce;
use App\Skill;
use App\User;
use App\VimeoVideo;
use App\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    /**
     * @return string
     *
     * View Course
     */

    public function view($slug)
    {
        // Session::push('company.users', 'employeexs');

        $course = Course::whereSlug($slug)->with('sections', 'sections.items', 'sections.items.attachments')->first();

        if (!$course) {
            abort(404);
        }

        $user = Auth::user();

        // if ($course->status != 1) {
        //     if (!$user || !$user->isInstructorInCourse($course->id)) {
        //         abort(404);
        //     }
        // }
        $title = $course->title;

        $isEnrolled = false;
        if (Auth::check()) {
            $user = Auth::user();

            $enrolled = $user->isEnrolled($course->id);
            if ($enrolled) {
                $isEnrolled = $enrolled;
            }
        }
        return view(theme('course'), compact('course', 'title', 'isEnrolled'));
    }

    /**
     * @param $slug
     * @param $lecture_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * View lecture in full width mode.
     */
    public function lectureView($slug, $lecture_id)
    {
        $lecture = Content::find($lecture_id);
        $course = $lecture->course;
        $title = $lecture->title;

        $isEnrolled = false;

        $isOpen = (bool) $lecture->is_preview;


        $user = Auth::user();

        if ($course->paid && $user) {
            $isEnrolled = $user->isEnrolled($course->id);
            if ($course->paid && $isEnrolled) {
                $isOpen = true;
            }
        } elseif ($course->free) {
            if ($course->require_enroll && $user) {
                $isEnrolled = $user->isEnrolled($course->id);
                if ($isEnrolled) {
                    $isOpen = true;
                }
            } elseif ($course->require_login) {
                if ($user)
                    $isOpen = true;
            } else {
                $isOpen = true;
            }
        }

        if ($lecture->drip->is_lock) {
            $isOpen = false;
        }

        return view(theme('lecture'), compact('course', 'title', 'isEnrolled', 'lecture', 'isOpen'));
    }

    public function assignmentView($slug, $assignment_id)
    {
        $assignment = Content::find($assignment_id);
        $course = $assignment->course;
        $title = $assignment->title;
        $has_submission = $assignment->has_submission;

        $isEnrolled = false;
        if (Auth::check()) {
            $user = Auth::user();
            $isEnrolled = $user->isEnrolled($course->id);
        }

        return view(theme('assignment'), compact('course', 'title', 'isEnrolled', 'assignment', 'has_submission'));
    }

    public function assignmentSubmitting(Request $request, $slug, $assignment_id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $assignment = Content::find($assignment_id);

        $submission = $assignment->has_submission;
        if ($submission) {
            if ($submission->status === 'submitting') {

                $submission->text_submission = clean_html($request->assignment_text);
                $submission->status = 'submitted';
                $submission->save();
                complete_content($assignment, $user);

                /**
                 * Save Attachments if any
                 *
                 * @todo, check attachment size, if exceed, delete those attachments
                 */
                $attachments = array_filter((array) $request->assignment_attachments);
                if (is_array($attachments) && count($attachments)) {
                    foreach ($attachments as $media_id) {
                        $hash = strtolower(str_random(13) . substr(time(), 4) . str_random(13));
                        Attachment::create(['assignment_submission_id' => $submission->id, 'user_id' => $user_id, 'media_id' => $media_id, 'hash_id' => $hash]);
                    }
                }
            }
        } else {
            $course = $assignment->course;
            $data = [
                'user_id' => $user_id,
                'course_id' => $course->id,
                'assignment_id' => $assignment_id,
                'status' => 'submitting',
            ];
            AssignmentSubmission::create($data);
        }

        return redirect()->back();
    }


    public function create()
    {

        $title = __t('create_new_course');
        $categories = Category::parent()->get();
        $industries = Industry::get();
        $occupations = Occupation::get();
        $skills = Skill::get();
        $trainer = User::join('instructor_trainers','instructor_trainers.trainer_user_id','users.id')
        ->where([['instructor_trainers.instructor_user_id',Auth::user()->id],['instructor_trainers.request_status',1]])
        ->select('users.id as id','users.name as name')->get();
        $vimeoTitle = VimeoVideo::where('created_by',Auth::user()->id)
        ->where('status',1)
        ->orderby('id','desc')->get();
        return view(theme('dashboard.courses.create_course'), compact('title', 'categories', 'industries', 'occupations', 'skills','trainer','vimeoTitle'));
    }

    public function store(Request $request)
    {
// dd($request->all());
        $rules = [
            'title' => 'required',
            'category_id' => 'required',
            'topic_id' => 'required',
            'available_student'=>'numeric|nullable'
        ];

        $this->validate($request, $rules);

        $user_id = Auth::user()->id;
        $slug = unique_slug($request->title);
        $now = Carbon::now()->toDateTimeString();

        $category = Category::find($request->category_id);
        $data = [
            'user_id'           => $user_id,
            'title'             => clean_html($request->title),
            'slug'              => $slug,
            'short_description' => clean_html($request->short_description),
            'price_plan'        => 'free',
            'category_id'       => $request->topic_id,
            'parent_category_id' => $category->category_id,
            'second_category_id' => $category->id,
            'thumbnail_id'      => $request->thumbnail_id,
            'level'             => $request->level,
            'last_updated_at'   => $now,
            'available_student'=> $request->available_student
        ];

        /**
         * save video data
         */
        $video_source = $request->input('video.source');
        if ($video_source === '-1') {
            $data['video_src'] = null;
        } else {
            $data['video_src'] = json_encode($request->video);
        }

        $course = Course::create($data);

        $now = Carbon::now()->toDateTimeString();
        if ($course) {
            if ($request->skills) {
                if (count($request->skills) > 0) {
                    foreach ($request->skills as $skill) {
                        $skills = new \App\CourseSkill();
                        $skills->course_id = $course->id;
                        $skills->skill_id = $skill;
                        $skills->save();
                    }
                }
            }
            if ($request->occupation) {
                if (count($request->occupation) > 0) {
                    foreach ($request->occupation as $occupation) {
                        $occupations = new \App\CourseOccupation();
                        $occupations->course_id = $course->id;
                        $occupations->occupation_id = $occupation;
                        $occupations->save();
                    }
                }
            }
            if ($request->industry) {
                if (count($request->industry) > 0) {
                    foreach ($request->industry as $industry) {
                        $industries = new \App\CourseIndustry();
                        $industries->course_id = $course->id;
                        $industries->industry_id = $industry;
                        $industries->save();
                    }
                }   
            }

            if (isset($request->trainer) && Auth::user()->user_type == "instructor" || isset($request->trainer) && Auth::user()->user_type == "admin") {
            //  dd($request->trainer);
                if (count($request->trainer) > 0) {
                    foreach ($request->trainer as $trainer) {
                        $industries = new CourseAssignTrainer();
                        $industries->course_id = $course->id;
                        // $industries->assigned_by = Auth::user()->id ;
                        $industries->trainer_user_id = $trainer;
                        $industries->save();
                        $auth = Auth::user() ;
                        //notification to trainer
                        $notifi = new UserNotification();
                        $notifi->notifiable_user_id = $trainer;
                        $notifi->notification = "You have a new course $course->title Assigned By $auth->name ";
                        $notifi->model_id = $course->id;
                        $notifi->model = "course_assigned_to_trainer";
                        $notifi->save();
                        // DB::table('course_user')->insert(
                        //     ['course_id' => $course->id, 'user_id' => $trainer]
                        // );
                    }
                }
            }


            $course->instructors()->attach($user_id, ['added_at' => $now]);
        }
       
        $user = Auth::user()->id ;
        $notification = "You have successfully added $course->title ";
        $model_id =$course->id;
        $model = "course-added";
        userNotification($user, $notification, $model_id, $model);


        return redirect(route('edit_course_information', $course->id));
    }

    public function information($course_id)
    {
        $title = __t('information');
        $course = Course::find($course_id);
    
        // dd($course->i_am_instructor,$course);
   
        if (!$course || !$course->i_am_instructor || !Auth::user()->user_type == 'trainer') {
            // abort(404);
            return redirect()->back();
        }
        $categories = Category::parent()->get();
        $topics = Category::whereCategoryId($course->second_category_id)->get();
        $industries = \App\Industry::get();
        $occupations = \App\Occupation::get();
        $skills = \App\Skill::get();
        $selSkills = \App\CourseSkill::where('course_id', $course->id)->pluck('skill_id')->toArray();
        $selOccupations = \App\CourseOccupation::where('course_id', $course->id)->pluck('occupation_id')->toArray();
        $selIndustries = \App\CourseIndustry::where('course_id', $course->id)->pluck('industry_id')->toArray();

        $trainer = User::join('instructor_trainers','instructor_trainers.trainer_user_id','users.id')
        ->select('users.id as id','users.name as name')
        ->where([['instructor_trainers.instructor_user_id',Auth::user()->id],['instructor_trainers.request_status',1]])->get();
        $vimeoTitle = VimeoVideo::where('created_by',Auth::user()->id)
        ->where('status',1)
        ->orderby('id','desc')->get();
        return view(theme('dashboard.courses.information'), compact('title', 'course', 'categories', 'topics', 'skills', 'occupations', 'industries', 'selSkills', 'selOccupations', 'selIndustries','trainer','vimeoTitle'));
    }

    public function informationPost(Request $request, $course_id)
    {
        // dd($request->all());
        $rules = [
            'title'             => 'required|max:120',
            'short_description' => 'max:220',
            'category_id'       => 'required',
            'topic_id'       => 'required',
            'available_student'=>'numeric|nullable'
        ];
        $this->validate($request, $rules);

        $course = Course::find($course_id);
        if (!$course || !$course->i_am_instructor) {
            abort(404);
        }
        $category = Category::find($request->category_id);

        $data = [
            'title'             => clean_html($request->title),
            'short_description' => clean_html($request->short_description),
            'description'       => clean_html($request->description),
            'benefits'          => clean_html($request->benefits),
            'requirements'      => clean_html($request->requirements),
            'thumbnail_id'      => $request->thumbnail_id,
            'category_id'       => $request->topic_id,
            'parent_category_id' => $category->category_id,
            'second_category_id' => $category->id,
            'level'             => $request->level,
            'available_student'=> $request->available_student
        ];
        /**
         * save video data
         */
        $video_source = $request->input('video.source');
        if ($video_source === '-1') {
            $data['video_src'] = null;
        } else {
            $data['video_src'] = json_encode($request->video);
        }

        $course->update($data);

        if (isset($request->skills) && count($request->skills) > 0) {
            if ($request->get('skills')) {
                $chkInd = \App\CourseSkill::where('course_id', $course->id)->get();
                if (count($chkInd) > 0) {
                    \App\CourseSkill::where('course_id', $course->id)->delete();
                }
                foreach ($request->skills as $skill) {
                    $skills = new \App\CourseSkill();
                    $skills->course_id = $course->id;
                    $skills->skill_id = $skill;
                    $skills->save();
                }
            }
        }
        if (isset($request->occupation) &&  count($request->occupation) > 0) {
            if ($request->get('occupation')) {
                $chkOcc = \App\CourseOccupation::where('course_id', $course->id)->get();
                if (count($chkOcc) > 0) {
                    \App\CourseOccupation::where('course_id', $course->id)->delete();
                }
                foreach ($request->occupation as $occupation) {
                    $occupations = new \App\CourseOccupation();
                    $occupations->course_id = $course->id;
                    $occupations->occupation_id = $occupation;
                    $occupations->save();
                }
            }
        }
        if (isset($request->industry) &&  count($request->industry) > 0) {
            if ($request->get('industry')) {
                $chkInd = \App\CourseIndustry::where('course_id', $course->id)->get();
                if (count($chkInd) > 0) {
                    \App\CourseIndustry::where('course_id', $course->id)->delete();
                }
                foreach ($request->industry as $industry) {
                    $industries = new \App\CourseIndustry();
                    $industries->course_id = $course->id;
                    $industries->industry_id = $industry;
                    $industries->save();
                    
                }
            }
        }
        if (isset($request->trainer) && Auth::user()->user_type == "instructor" || Auth::user()->user_type == "admin") {
           if($request->trainer != null)
           {
            if (count($request->trainer) > 0  ) {
                $chkcourse = CourseAssignTrainer::where('course_id', $course_id)->get();
                if (count($chkcourse) > 0) {
                    CourseAssignTrainer::where('course_id', $course_id)->delete();
                }
                foreach ($request->trainer as $trainer) {
                  
                    $industries = new CourseAssignTrainer();
                    $industries->course_id = $course->id;
                    $industries->trainer_user_id = $trainer;
                    $industries->save();
                    // notification to assigned trainer 
                    $authUser =Auth::user();
                    $userTrainer = $trainer;
                    $notificationTrainer = "You have a new $course->title course assigned by $authUser->name";
                    $model_ids =$course->id;
                    $models = "course-added-to-trainer";
                    userNotification($userTrainer, $notificationTrainer, $model_ids, $models);

                    //store course_user table in
                    // DB::table('course_user')->insert(
                    //     ['course_id' => $course->id, 'user_id' => $trainer]
                    // );
                    
                }
            }
        }
        }

        if ($request->save === 'save_next')
            return redirect(route('edit_course_curriculum', $course_id));
        return redirect()->back();
    }

    public function curriculum($course_id)
    {

        $title = __t('curriculum');
        $course = Course::find($course_id);
        if (!$course || !$course->i_am_instructor) {
            abort(404);
        }

        return view(theme('dashboard.courses.curriculum'), compact('title', 'course'));
    }


    public function newSection($course_id)
    {
        $title = __t('curriculum');
        $course = Course::find($course_id);
        return view(theme('dashboard.courses.new_section'), compact('title', 'course'));
    }

    public function newSectionPost(Request $request, $course_id)
    {
        // dd($request->all());
        $rules = [
            'section_name' => 'required',
            'section_type' => 'required'
        ];
        $this->validate($request, $rules);

        Section::create(
            [
                'course_id' => $course_id,
                'section_name' => clean_html($request->section_name),
                'section_type' => $request->section_type
            ]
        );
        return redirect(route('edit_course_curriculum', $course_id));
    }

    /**
     * @param Request $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     *
     * Update the section
     */
    public function updateSection(Request $request, $id)
    {

        $rules = [
            'section_name' => 'required',
            'section_type' => 'required'
        ];
        $this->validate($request, $rules);

        Section::whereId($id)->update(['section_name' => clean_html($request->section_name), 'section_type' => $request->section_type]);
        // return redirect()->back();
    }

    public function deleteSection(Request $request)
    {
        if (config('app.is_demo')) return ['success' => false, 'msg' => __t('demo_restriction')];

        $section = Section::find($request->section_id);
        $course = $section->course;

        Content::query()->where('section_id', $request->section_id)->delete();
        $section->delete();
        $course->sync_everything();

        return ['success' => true];
    }

    public function newLecture(Request $request, $course_id)
    {
        $rules = [
            'title' => 'required'
        ];

        $validation = Validator::make($request->input(), $rules);

        if ($validation->fails()) {
            $errors = $validation->errors()->toArray();

            $error_msg = "<div class='alert alert-danger mb-3'>";
            foreach ($errors as $error) {
                $error_msg .= "<p class='m-0'>{$error[0]}</p>";
            }
            $error_msg .= "</div>";

            return ['success' => false, 'error_msg' => $error_msg];
        }

        $user_id = Auth::user()->id;

        $lesson_slug = unique_slug($request->title, 'Content');
        $sort_order = next_curriculum_item_id($course_id);

        $data = [
            'user_id'       => $user_id,
            'course_id'     => $course_id,
            'section_id'    => $request->section_id,
            'title'         => clean_html($request->title),
            'slug'          => $lesson_slug,
            'text'          => clean_html($request->description),
            'item_type'     => 'lecture',
            'status'        => 1,
            'sort_order'   => $sort_order,
            'is_preview'    => $request->is_preview,
        ];

        $lecture = Content::create($data);
        $lecture->save_and_sync();

        return ['success' => true, 'item_id' => $lecture->id];
    }

    public function loadContents(Request $request)
    {
        $section = Section::find($request->section_id);

        $html = view_template_part('dashboard.courses.section-items', compact('section'));

        return ['success' => true, 'html' => $html];
    }

    public function updateLecture(Request $request, $course_id, $item_id)
    {
        $rules = [
            'title' => 'required'
        ];
        $validation = Validator::make($request->input(), $rules);

        if ($validation->fails()) {
            $errors = $validation->errors()->toArray();
            $error_msg = "<div class='alert alert-danger mb-3'>";
            foreach ($errors as $error) {
                $error_msg .= "<p class='m-0'>{$error[0]}</p>";
            }
            $error_msg .= "</div>";
            return ['success' => false, 'error_msg' => $error_msg];
        }

        $user_id = Auth::user()->id;

        $lesson_slug = unique_slug($request->title, 'Content', $item_id);
        $data = [
            'title'         => clean_html($request->title),
            'slug'          => $lesson_slug,
            'text'          => clean_html($request->description),
            'is_preview'    => clean_html($request->is_preview),
        ];

        /**
         * save video data
         */
        $video_source = $request->input('video.source');
        if ($video_source === '-1') {
            $data['video_src'] = null;
        } else {
            $data['video_src'] = json_encode($request->video);
        }

        $item = Content::find($item_id);
        $item->save_and_sync($data);

        /**
         * Save Attachments if any
         */
        $attachments = array_filter((array) $request->attachments);
        if (is_array($attachments) && count($attachments)) {
            foreach ($attachments as $media_id) {
                $hash = strtolower(str_random(13) . substr(time(), 4) . str_random(13));
                Attachment::create(['belongs_course_id' => $item->course_id, 'content_id' => $item->id, 'user_id' => $user_id, 'media_id' => $media_id, 'hash_id' => $hash]);
            }
        }

        return ['success' => true];
    }


    public function editItem(Request $request)
    {
        
        $item_id = $request->item_id;
        $item = Content::find($item_id);
        $vimeoTitle = VimeoVideo::where('created_by',Auth::user()->id)
        ->where('status',1)
        ->orderby('id','desc')->get();
        $form_html = '';

        if ($item->item_type === 'lecture') {
            $form_html = view_template_part('dashboard.courses.edit_lecture_form', compact('item','vimeoTitle'));
        } elseif ($item->item_type === 'quiz') {
            $form_html = view_template_part('dashboard.courses.quiz.edit_quiz', compact('item','vimeoTitle'));
        } elseif ($item->item_type === 'assignment') {
            $form_html = view_template_part('dashboard.courses.edit_assignment_form', compact('item','vimeoTitle'));
        }

        return ['success' => true, 'form_html' => $form_html];
    }

    public function deleteItem(Request $request)
    {
        $item_id = $request->item_id;
        Content::destroy($item_id);
        return ['success' => true];
    }

    public function pricing($course_id)
    {
        $title = __t('course_pricing');
        $course = Course::find($course_id);
        if (!$course || !$course->i_am_instructor) {
            abort(404);
        }

        return view(theme('dashboard.courses.pricing'), compact('title', 'course'));
    }

    public function pricingSet(Request $request,  $course_id)
    {

        if ($request->price_plan == 'paid') {
            $rules = [
                'price' => 'required|numeric',
            ];
            if ($request->sale_price) {
                $rules['sale_price'] = 'numeric';
            }
            $this->validate($request, $rules);
        }

        $course = Course::find($course_id);
        if (!$course || !$course->i_am_instructor) {
            abort(404);
        }

        $data = [
            'price_plan'        => $request->price_plan,
            'cert_accr'        => $request->cert_accr,
            'price'             => clean_html($request->price),
            'sale_price'        => clean_html($request->sale_price),
            'require_login'     => $request->require_login,
            'require_enroll'    => $request->require_enroll,
        ];

        $course->update($data);

        return back();
    }

    public function drip($course_id)
    {
        $title = __t('drip_content');
        $course = Course::find($course_id);
        if (!$course || !$course->i_am_instructor) {
            abort(404);
        }

        return view(theme('dashboard.courses.drip'), compact('title', 'course'));
    }
    public function dripPost(Request $request, $course_id)
    {

        $sections = $request->section;
        if($sections)
        {   
        foreach ($sections as $sectionId => $section) {
            Section::whereId($sectionId)->update(array_except($section, 'content'));

            $contents = array_get($section, 'content');
            if($contents)
            {
            foreach ($contents as $contentId => $content) {
                Content::whereId($contentId)->update(array_except($content, 'content'));
            }
        }
        }
    }
        return back()->with('success', __t('drip_preference_saved'));
    }



    public function publish($course_id)
    {
       
        $title = __t('publish_course');
        $course = Course::find($course_id);
        if (!$course || !$course->i_am_instructor) {
            abort(404);
        }

        return view(theme('dashboard.courses.publish'), compact('title', 'course'));
    }

    public function publishPost(Request $request, $course_id)
    {
        
        $course = Course::find($course_id);
        if (!$course || !$course->i_am_instructor) {
            abort(404);
        }
        if ($request->publish_btn == 'publish') {
            if (get_option("lms_settings.instructor_can_publish_course")) {
                $course->status = 1;
            } else {
                $course->status = 2;
            }
        } elseif ($request->publish_btn == 'unpublish') {
            $course->status = 4;
        }
        $course->save();
        if($course->status == 2)
        {

        //admin notification
        $user = 1;
        $notification = Auth::user()->name ." ". " added new course";
        $model_id = $course_id ;
        $model = "course_created";
        //created user 
        $createdUser =Auth::user()->id ;
        $createdNotifi = "You have created new". " " . $course->title . " course" ;
        
        userNotification($user, $notification, $model_id, $model);
        userNotification($createdUser, $createdNotifi, $model_id, $model);
        }
        return back();
    }


    /**
     * Course Free Enroll
     */

    public function freeEnroll(Request $request)
    {
        $course_id = $request->course_id;
       
        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $user = Auth::user();
        $course = Course::find($course_id);
            if($course->available_student > 0 && $course->available_student != null)
            {
                $degreesOne = (int)$course->available_student - 1 ;
                // dd($degreesOne);
              Course::find($course_id)
               ->update([
                   'available_student'=>$degreesOne,
               ]);
            }
            // dd('jk');
        $isEnrolled = $user->isEnrolled($course_id);

        if (!$isEnrolled) {
            $carbon = Carbon::now()->toDateTimeString();
            $user->enrolls()->attach($course_id, ['status' => 'success', 'enrolled_at' => $carbon]);
            $user->enroll_sync();

            //Activity 
            $report = new Activity();
            $report->user_id = $user->id;
            $report->activity = $user->name . ' purchased the course ' . $course->title;
            $report->type = 'purchase';
            $report->course_id = $course->id;
            $report->ip = $request->getClientIp();
            $report->save();

            $coursePostUser = \App\User::find($course->user_id);

            $report = new Activity();
            $report->user_id = $coursePostUser->id;
            $report->activity = $user->name . ' purchased the course ' . $course->title;
            $report->type = 'purchase';
            $report->course_id = $course->id;
            $report->ip = $request->getClientIp();
            $report->save();
        }

        return redirect(route('course', $course->slug));
    }

    /**
     * Content Complete, such as Lecture
     * return to next after complete
     * stay current page if there is no next.
     */
    public function contentComplete($content_id)
    {
        $content = Content::find($content_id);
        $user = Auth::user();

        complete_content($content, $user);

        $go_content = $content->next;
        if (!$go_content) {
            $go_content = $content;
        }


        return redirect(route('single_' . $go_content->item_type, [$go_content->course->slug, $go_content->id]));
    }

    public function complete(Request $request, $course_id)
    {
        // dd($request->all());
        $course = Course::find($course_id);
        $user = Auth::user();
        $user->complete_course($course_id);
        Mail::to($user->email)->queue(new UserRegistrationMail('complete-course', $course));
        // admin notification 
        $user = 1;
        $notification = Auth::user()->name ." ". " complete " . " ". $course->title ." " . "course";
        $model_id = $course_id ;
        $model = "course_complete";
        //created user 
        $createdUser =Auth::user()->id ;
        $createdNotifi = "You have  completed ". " " . $course->title . " course" ;
        
        userNotification($user, $notification, $model_id, $model);
        userNotification($createdUser, $createdNotifi, $model_id, $model);

        return back();
    }

    public function attachmentDownload($hash)
    {
        $attachment = Attachment::whereHashId($hash)->first();
        if (!$attachment ||  !$attachment->media) {
            abort(404);
        }

        /**
         * If Assignment Submission Attachment, download it right now
         */
        if ($attachment->assignment_submission_id) {
            if (Auth::check()) {
                return $this->forceDownload($attachment->media);
            }
            abort(404);
        }

        $item = $attachment->belongs_item;

        if ($item && $item->item_type === 'lecture' && $item->is_preview) {
            return $this->forceDownload($attachment->media);
        }

        if (!Auth::check()) {
            abort(404);
        }
        $user = Auth::user();

        $course = $attachment->course;

        if (!$user->isEnrolled($course->id)) {
            abort(404);
        }

        return $this->forceDownload($attachment->media);
    }

    public function forceDownload($media)
    {
        $source = get_option('default_storage');
        $slug_ext = $media->slug_ext;

        if (substr($media->mime_type, 0, 5) == 'image') {
            $slug_ext = 'images/' . $slug_ext;
        }

        $path = '';
        if ($source == 'public') {
            $path = ROOT_PATH . "/uploads/{$slug_ext}";
        } elseif ($source == 's3') {
            $path = \Illuminate\Support\Facades\Storage::disk('s3')->url("uploads/" . $slug_ext);
        }

        return response()->download($path);
    }

    public function writeReview(Request $request, $id)
    {
        if ($request->rating_value < 1) {
            return back();
        }
        if (!$id) {
            $id = $request->course_id;
        }

        $user = Auth::user();

        $data = [
            'user_id'       => $user->id,
            'course_id'     => $id,
            'review'        => clean_html($request->review),
            'rating'        => $request->rating_value,
            'status'        => 1,
        ];

        $review = has_review($user->id, $id);
        if (!$review) {
            $review = Review::create($data);
        }
        $review->save_and_sync($data);

        return back();
    }

    /**
     * My Courses page from Dashboard
     */

    public function myCourses(Request $request)
    {
        
        $liveSchedule = $request->type;
        $assignedType = $request->assigned_type ;
        $title = __t('my_courses');
        return view(theme('dashboard.my_courses'), compact('title', 'liveSchedule','assignedType'));
    }

    public function myCoursesReviews()
    {
        $title = __t('my_courses_reviews');
        return view(theme('dashboard.my_courses_reviews'), compact('title'));
    }
    public function assignedCourse()
    {
        $title = __t('assinged_course');
        $assignedCourse = Course::join('course_assign_trainers','course_assign_trainers.course_id','courses.id')
        ->where('trainer_user_id',Auth::user()->id)
        ->select('courses.id as id','courses.title as title','courses.slug as slug','courses.status as courseStatus',
        'course_assign_trainers.id as course_assign_id','courses.user_id as user_id' ,'course_assign_trainers.status as status'
        )->latest('course_assign_trainers.created_at')->get();
        // dd($assignedCourse);
        return view(theme('dashboard.assinged_course'), compact('title','assignedCourse'));
    }
    public function statusChangesAssignedCourse(Request $request)
    {
        $id = $request->id ;
        $status = $request->status ;
        $assigned = CourseAssignTrainer::find($id);
        $course = Course::find($assigned->course_id);
        $course->accepted_trainer_id = Auth::user()->id ;
        $course->save();
     

        $auth = Auth::user();
        if($status == "accept")
        {
        $assigned->status = 2 ;
        $assigned->save();
        DB::table('course_user')->insert(
            ['course_id' => $course->id, 'user_id' => $assigned->trainer_user_id]
        );
         //notification to trainer
         $notifi = new UserNotification();
         $notifi->notifiable_user_id = $course->user_id;
         $notifi->notification = " $auth->name accepted $course->title course ";
         $notifi->model_id = $assigned->id;
         $notifi->model = "accepted_course";
         $notifi->save();
        }
        if($status == "reject")
        {
            $assigned->status = 1 ;
            $assigned->save();

            $notifi = new UserNotification();
            $notifi->notifiable_user_id = $course->user_id;
            $notifi->notification = " $auth->name rejected $course->title course ";
            $notifi->model_id = $assigned->id;
            $notifi->model = "rejected_course";
            $notifi->save();
        }
        // $assigned->save();
    }
    public function requestTrainer(Request $request)
    {
        $title = __t('Request');
        $requestTrainer = InstructorTrainer::join('users','users.id','instructor_trainers.trainer_user_id')
        ->select('instructor_trainers.*')
        ->where('instructor_trainers.trainer_user_id',Auth::user()->id)->get();
        // dd($requestTrainer);
        return view(theme('dashboard.request-trainer'), compact('title','requestTrainer'));
    }

    public function statusChageTrainingcenter(Request $request)
    {
        $status = $request->status ;
        $id = $request->id ;
        $auth = Auth::user();
        $reqTrainer = InstructorTrainer::find($id);
        if($status == "accept")
        {
        $reqTrainer->request_status = 1 ;
        $reqTrainer->save();
         //notification to trainer
         $notifi = new UserNotification();
         $notifi->notifiable_user_id = 1;
         $notifi->notification = " $auth->name accepted Your Request as trainer ";
         $notifi->model_id = $reqTrainer->id;
         $notifi->model = "accepted_training";
         $notifi->save();
        }
        if($status == "reject")
        {
            $reqTrainer->request_status = 2 ;
            $reqTrainer->save();

            $notifi = new UserNotification();
            $notifi->notifiable_user_id = 1;
            $notifi->notification = " $auth->name rejected Your Request as trainer ";
            $notifi->model_id = $reqTrainer->id;
            $notifi->model = "rejected_training";
            $notifi->save();
        }
    }
}
