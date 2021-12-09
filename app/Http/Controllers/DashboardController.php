<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Individual;
use App\Individual_Current_Job;
use App\Individual_Preferred_Job;
use App\Individual_Language;
use App\Industry;
use App\Occupation;
use App\AllLanguage;
use App\HighestDegree;
use App\TrainingCenter;
use App\Trainer;
use App\TC_Language;
use App\TR_Language;
use App\Major;
use Carbon\Carbon;
use App\Skill;
use App\IndividualSkillWanted;
use App\IndividualTopSkill;
use App\UserNotification;

class DashboardController extends Controller
{
  // dd('aj');
  public function index(){
    $title = __t('dashboard');

    $user = Auth::user();

    $chartData = null;
    if ($user->isInstructor) {
            /**
             * Format Date Name
             */
            $start_date = date("Y-m-01");
            $end_date = date("Y-m-t");

            $begin = new \DateTime($start_date);
            $end = new \DateTime($end_date . ' + 1 day');
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end);

            $datesPeriod = array();
            foreach ($period as $dt) {
              $datesPeriod[$dt->format("Y-m-d")] = 0;
            }

            /**
             * Query This Month
             */

            $sql = "SELECT SUM(instructor_amount) as total_earning,
            DATE(created_at) as date_format
            from earnings
            WHERE instructor_id = {$user->id} AND payment_status = 'success'
            AND (created_at BETWEEN '{$start_date}' AND '{$end_date}')
            GROUP BY date_format
            ORDER BY created_at ASC ;";
            $getEarnings = DB::select(DB::raw($sql));

            $total_earning = array_pluck($getEarnings, 'total_earning');
            $queried_date = array_pluck($getEarnings, 'date_format');


            $dateWiseSales = array_combine($queried_date, $total_earning);

            $chartData = array_merge($datesPeriod, $dateWiseSales);
            foreach ($chartData as $key => $salesCount) {
              unset($chartData[$key]);
                //$formatDate = date('d M', strtotime($key));
              $formatDate = date('d', strtotime($key));
              $chartData[$formatDate] = $salesCount;
            }
          }

          $getNotifications = UserNotification::where([['notifiable_user_id',Auth::user()->id],['is_read',0]])->limit(5)->latest()->get();

          return view(theme('dashboard.dashboard'), compact('title', 'chartData','getNotifications'));
        }

        public function profileSettings(){

          $title = __t('profile_settings');

          if(Auth::check() && Auth::user()->user_type=='student')
          {


            $individualLanguages = \App\Individual_Language::where('user_id',Auth::user()->id)->pluck('language_id')->toArray();

            $individualSkillsWanted = \App\IndividualSkillWanted::where('user_id',Auth::user()->id)->pluck('skill_id')->toArray();

            $individualTopSkills = \App\IndividualTopSkill::where('user_id',Auth::user()->id)->pluck('skill_id')->toArray();

            $individualIndustries = \App\IndividualIndustry::where('user_id',Auth::user()->id)->pluck('industry_id')->toArray();

            $individualOccupation = \App\IndividualOccupation::where('user_id',Auth::user()->id)->pluck('occupation_id')->toArray();

            $highest_degrees = \App\HighestDegree::get();
            $occupations = \App\Occupation::get();
            $industries = \App\Industry::get();
            $skills          = \App\Skill::get();
            $indUser = \App\Individual::where('user_id',Auth::user()->id)->first();
            $currentJob = \App\Individual_Current_Job::where('user_id',Auth::user()->id)->first();
            $major_fields    = \App\Major::get();

            return view(theme('dashboard.settings.profile'), compact('title','individualLanguages','currentJob','individualOccupation','individualIndustries','industries','individualSkillsWanted','individualTopSkills','highest_degrees','skills','occupations','indUser','major_fields','title'));

          }
          if(Auth::check() && (Auth::user()->user_type=='admin' || Auth::user()->user_type=='instructor'))
          {
            $occupations = \App\Occupation::get();
            $industries = \App\Industry::get();
            $tcUser = \App\TrainingCenter::where('user_id',Auth::user()->id)->first();
            $tcLanguages = \App\TC_Language::where('user_id',Auth::user()->id)->pluck('language_id')->toArray();

            return view(theme('dashboard.settings.tc_profile'), compact('occupations','industries','tcUser','tcLanguages','title'));
          }

           if(Auth::check() && Auth::user()->user_type=='trainer')
          {
            $occupations = \App\Occupation::get();
            $industries = \App\Industry::get();
            $tcUser = \App\Trainer::where('user_id',Auth::user()->id)->first();
            $tcLanguages = \App\TR_Language::where('user_id',Auth::user()->id)->pluck('language_id')->toArray();

            return view(theme('dashboard.settings.tr_profile'), compact('occupations','industries','tcUser','tcLanguages','title'));
          }


        }

        public function profileSettingsPost(Request $request){
          // dd($request);
  // dd($request->input('living_location'));
          $rules = [
            'name'      => 'required',
            'job_title' => 'max:220',
          ];
          $this->validate($request, $rules);

       // $input = array_except($request->input(), ['_token', 'social']);
          $input = array_except($request->input(), ['_token', 'social']);
          $user_id = Auth::user()->id;
          $user = Auth::user();
          $user->update([
           'name'=>$request->input('name'),
           'address' => $request->input('address'),
           'address_2' => $request->input('address_2'),
           'phone' => $request->input('phone'),
           'city' => $request->input('city'),
           'zip_code' => $request->input('zip_code'),
           'country_id' => $request->input('country_id'),
           'about_me' => $request->input('about_me'),

         ], ['_token', 'social']);
          $user->update_option('social', $request->social);

        //code pasted - sandeep - 29/12/2020
          $user    = User::find($user_id);
          $user->name = $request->input('name');
          $profile_pic = $request->file('profile_file');
        //dd($profile_pic);
          if ($profile_pic) {
            $profile_pic_name  = uniqid() . '.' . $profile_pic->extension();
            $user->profile_pic = $profile_pic_name;
            $profile_pic->move(public_path('assets/profile_pics/'), $profile_pic_name);
          }

          $user->save();
          $user_id = $user->id;
          $employment_status  = $request->input('employment_status');
          $new_job_preference = $request->input('new_job_preference');

      //SAVING TO OR UPDATING INDIVIDUALS TABLE
          $checkUser = Individual::where('user_id',$user_id)->first();
          if(!$checkUser){
            $iObj = new Individual();
            $iObj->user_id  =  $user_id;
          }else{
            $iObj = Individual::where('user_id',$user->id)->first();
            $iObj->updated_at = now();
        //$obj->updated_by = Auth::user()->id;
          }
          $iObj->highest_degree_id = $request->input('highest_degree');
          $iObj->university = $request->input('university');
          $iObj->major_id   = $request->input('major');
          $iObj->employment_status  = $request->input('employment_status');
          $iObj->new_job_preference = $request->input('new_job_preference');
          $iObj->career_goal  = $request->input('career_goal');
          $iObj->goal_privacy = $request->input('goal_privacy');
          $iObj->self_intro = $request->input('self_intro');
          $iObj->living_location = $request->input('living_location');
          $iObj->dob = $request->input('dob');
          $iObj->gender = $request->input('gender');
          $iObj->website_url = $request->input('website_url');
          $iObj->phone_number = $request->input('phone_number');
          $iObj->personal_info_privacy = $request->input('goal_privacy');
          $iObj->save();

          if($iObj->id){
            $profile_status = 1;
          }

      // if($employment_status == 1 || $employment_status == 2){
          $profile_status = 0;
          //SAVING TO OR UPDATING CURRENT JOB DETAILS TABLE
          $cObj = Individual_Current_Job::where('user_id',$user->id)->first();
          if(!$cObj){
            $cObj = new Individual_Current_Job();
            $cObj->user_id  =  $user_id;
          }else{
           // $cObj = Individual_Current_Job::where('user_id',$user->id)->first();
            $cObj->updated_at = now();
            //$obj->updated_by = Auth::user()->id;
          }
         // $cObj->job_industry = $request->input('job_industry');
          // $cObj->current_job_location = $request->input('current_job_location');
          // $cObj->current_employer = $request->input('current_employer');
          // $cObj->current_occupation = $request->input('current_occupation');
          // $cObj->current_experience_level  = $request->input('current_experience_level');

          $cObj->country_id  = $request->input('current_job_location');
          $cObj->employer  = $request->input('current_employer');
          $cObj->employment_status  = $request->input('employment_status');
          $cObj->industry_id = $request->input('job_industry');
          $cObj->occupation_id = $request->input('current_occupation');
          $cObj->experience_level_id = $request->input('current_experience_level');
          $cObj->save();
          if($cObj->id){
            $profile_status = 1;
          }

      // }

          if($new_job_preference == 1){
            $profile_status = 0;
          //SAVING TO OR UPDATING PREFERRED JOB DETAILS TABLE
            if($request->input('preferred_job_id')==""){
              $pObj = new Individual_Preferred_Job();
              $pObj->user_id  =  $user_id;
            }else{
              $pObj = Individual_Preferred_Job::where('user_id',$user->id)->first();
              $pObj->updated_at = now();
            //$pObj->updated_by = Auth::user()->id;
            }
            $pObj->location = $request->input('preferred_location');
          //$pObj->industry_id = $request->input('preferred_industry');
         // $pObj->occupation_id = $request->input('preferred_occupation');
            $pObj->preferred_experience_id = $request->input('preferred_exp_level');
            $pObj->save();
            if($pObj->id){
              $profile_status = 1;
            }

          }
          $profile_status = 0;
      //Prefered studying languages

          $chkLangs = Individual_Language::where('user_id',$user->id)->get();

          if(count($chkLangs)>0)
          {
            $lObj = Individual_Language::where('user_id',$user->id)->delete();
          }

          if($request->input('prefered_study_language')){
            foreach($request->input('prefered_study_language') as $lang){
              $lObj = new Individual_Language();
              $lObj->user_id     = $user_id;
              $lObj->language_id = $lang;
              $lObj->save();
            }
          }

     //Prefered Industries

          $chkLangs = \App\IndividualIndustry::where('user_id',$user->id)->get();

          if(count($chkLangs)>0)
          {
           $lObj = \App\IndividualIndustry::where('user_id',$user->id)->delete();
         }

         if($request->input('preferred_industry')){
           foreach($request->input('preferred_industry') as $indus){
             $lObj = new \App\IndividualIndustry();
             $lObj->user_id     = $user_id;
             $lObj->industry_id = $indus;
             $lObj->save();
           }
         }

   //Prefered Occupations

         $chkLangs = \App\IndividualOccupation::where('user_id',$user->id)->get();

         if(count($chkLangs)>0)
         {
           $lObj = \App\IndividualOccupation::where('user_id',$user->id)->delete();
         }

         if($request->input('prefered_study_language')){
           foreach($request->input('prefered_study_language') as $occ){
             $lObj = new \App\IndividualOccupation();
             $lObj->user_id     = $user_id;
             $lObj->occupation_id = $occ;
             $lObj->save();
           }
         }

    // Skills Wanted

         $chkSkills = IndividualSkillWanted::where('user_id',$user->id)->get();

         if(count($chkSkills)>0)
         {
          $lObj = IndividualSkillWanted::where('user_id',$user->id)->delete();
        }
        if($request->input('skills_wanted')){
          foreach($request->input('skills_wanted') as $skill){
            $lObj = new IndividualSkillWanted();
            $lObj->user_id     = $user_id;
            $lObj->skill_id = $skill;
            $lObj->save();
          }
        }

    // End Skills


    // Top Skills

        $chkTopSkills = IndividualTopSkill::where('user_id',$user->id)->get();

        if(count($chkTopSkills)>0)
        {
          $lObj = IndividualTopSkill::where('user_id',$user->id)->delete();
        }
        if($request->input('top_skills')){
          foreach($request->input('top_skills') as $tskill){
            $lObj = new IndividualTopSkill();
            $lObj->user_id     = $user_id;
            $lObj->skill_id = $tskill;
            $lObj->save();
          }
        }

    // End Top Skills

        if(isset($lObj) && $lObj->id){
          $profile_status = 1;
        }

        if($profile_status==1)
        {
      //  $user->profile_status = 1;
          $user->save();
        }
        //end - code pasted -

        return back()->with('success', __t('success'));
      }


      public function tCProfileSettingsPost(Request $request){

    //dd($request->input('dob'));
        $rules = [
          'name'      => 'required',
            'about_me' => 'required',
        ];
        $this->validate($request, $rules);

       // $input = array_except($request->input(), ['_token', 'social']);
        $input = array_except($request->input(), ['_token', 'social']);
        $user_id = Auth::user()->id;
        $user = Auth::user();

           $user    = User::find($user_id);
          $profile_pic = $request->file('profile_file');
        //dd($profile_pic);
          if ($profile_pic) {
            $profile_pic_name  = uniqid() . '.' . $profile_pic->extension();
            $user->profile_pic = $profile_pic_name;
            $profile_pic->move(public_path('assets/profile_pics/'), $profile_pic_name);
          }

          $user->save();

        // dd($user);
        $tc = TrainingCenter::whereUserId($user->id)->first();
        if(!$tc)
        {
         $tc = new TrainingCenter();
        }

       $tc->about_me = $request->get('about_me');
       $tc->website_url = $request->input('website_url');
       $tc->teaching_approach = $request->input('teaching_approach');
       $tc->address = $request->input('address');
       $tc->country_id = $request->input('country_id');
       $tc->current_occupation = $request->input('current_occupation');
       $tc->receive_newsletter = $request->input('receive_newsletter');  
       $accr = $request->file('accr');

          if ($accr) {
            $profile_pic_name2  = uniqid() . '.' . $accr->extension();
            $tc->accr = $profile_pic_name2;
            $accr->move(public_path('assets/profile_accr/'), $profile_pic_name2);
          }
       $tc->bidding_notification = $request->input('bidding_notification');
       $tc->phone_number = $request->input('phone_number');
       $tc->point_of_contact = $request->input('point_of_contact');
       $tc->name = $request->input('name');
       $tc->position = $request->input('position');
       $tc->email = $request->input('email');
       $tc->gender = $request->input('gender');
       $tc->job_industry = $request->input('job_industry');
       $tc->dob = date('Y-m-d',strtotime($request->input('dob')));
       $tc->user_id = $user_id;

       $tc->twitter = $request->social['twitter'];
       $tc->facebook = $request->social['facebook'];
       $tc->linkedin = $request->social['linkedin'];
       $tc->instagram = $request->social['instagram'];

         
       $tc->save();    
     

      $chkLangs = TC_Language::where('user_id',$user->id)->get();

      if(count($chkLangs)>0)
      {
        $lObj = TC_Language::where('user_id',$user->id)->delete();
      }

      if($request->input('prefered_study_language')){
        foreach($request->input('prefered_study_language') as $lang){
          $lObj = new TC_Language();
          $lObj->user_id     = $user_id;
          $lObj->language_id = $lang;
          $lObj->save();
        }
      }

     


    return back()->with('success', __t('success'));
  }


    public function tRProfileSettingsPost(Request $request){
    //dd($request->all());
    
        $rules = [
          'name'      => 'required',
            //'job_title' => 'max:220',
        ];
        $this->validate($request, $rules);

       // $input = array_except($request->input(), ['_token', 'social']);
        $input = array_except($request->input(), ['_token', 'social']);
        $user_id = Auth::user()->id;
        $user = Auth::user();

           $user    = User::find($user_id);
           $user->name = $request->input('name');
          $profile_pic = $request->file('profile_file');

          if ($profile_pic) {
            $profile_pic_name  = uniqid() . '.' . $profile_pic->extension();
            $user->profile_pic = $profile_pic_name;
            $profile_pic->move(public_path('assets/profile_pics/'), $profile_pic_name);
          }

          $user->save();

        // dd($user);
        $tc = Trainer::whereUserId($user->id)->first();
        if(!$tc)
        {
         $tc = new Trainer();
        }



        $accr = $request->file('accr');



          if ($accr) {
            $profile_pic_name2  = uniqid() . '.' . $accr->extension();
            $tc->accr = $profile_pic_name2;
            $accr->move(public_path('assets/profile_accr/'), $profile_pic_name2);
          }

      
       $tc->website_url = $request->input('website_url');
       $tc->teaching_approach = $request->input('teaching_approach');
       
       $tc->country_id = $request->input('country_id');
       $tc->current_occupation = $request->input('current_occupation');
       $tc->receive_newsletter = $request->input('receive_newsletter');   
    
       $tc->phone_number = $request->input('phone_number');
          
       $tc->gender = $request->input('gender');
       $tc->job_industry = $request->input('job_industry');
       $tc->dob = date('Y-m-d',strtotime($request->input('dob')));
       $tc->user_id = $user_id;

       $tc->twitter = $request->social['twitter'];
       $tc->facebook = $request->social['facebook'];
       $tc->linkedin = $request->social['linkedin'];
       $tc->instagram = $request->social['instagram'];
         
       $tc->save();    
     

      $chkLangs = TR_Language::where('user_id',$user->id)->get();

      if(count($chkLangs)>0)
      {
        $lObj = TR_Language::where('user_id',$user->id)->delete();
      }

      if($request->input('prefered_study_language')){
        foreach($request->input('prefered_study_language') as $lang){
          $lObj = new TR_Language();
          $lObj->user_id     = $user_id;
          $lObj->language_id = $lang;
          $lObj->save();
        }
      }

     


    return back()->with('success', __t('success'));
  }

  public function resetPassword(){
    $title = __t('reset_password');
    return view(theme('dashboard.settings.reset_password'), compact('title'));
  }

  public function resetPasswordPost(Request $request){
    if(config('app.is_demo')){
      return redirect()->back()->with('error', 'This feature has been disable for demo');
    }
    $rules = [
      'old_password'  => 'required',
      'new_password'  => 'required|confirmed',
      'new_password_confirmation'  => 'required',
    ];
    $this->validate($request, $rules);

    $old_password = clean_html($request->old_password);
    $new_password = clean_html($request->new_password);

    if(Auth::check()) {
      $logged_user = Auth::user();

      if(Hash::check($old_password, $logged_user->password)) {
        $logged_user->password = Hash::make($new_password);
        $logged_user->save();
        return redirect()->back()->with('success', __t('password_changed_msg'));
      }
      return redirect()->back()->with('error', __t('wrong_old_password'));
    }
  }

  public function enrolledCourses(){
    $title = __t('enrolled_courses');
    return view(theme('dashboard.enrolled_courses'), compact('title'));
  }

  public function myReviews(){
    $title = __t('my_reviews');
    return view(theme('dashboard.my_reviews'), compact('title'));
  }

  public function wishlist(){
    $title = __t('wishlist');
    return view(theme('dashboard.wishlist'), compact('title'));
  }

  public function purchaseHistory(){
    $title = __t('purchase_history');
    return view(theme('dashboard.purchase_history'), compact('title'));
  }

  public function purchaseView($id){
    $title = __a('purchase_view');
    $payment = Payment::find($id);
    return view(theme('dashboard.purchase_view'), compact('title', 'payment'));
  }

    // sandeep added - 11/Jan-2021

  public function notifications()
  {
    $user = Auth::user();

    $getNotifications = UserNotification::where([['notifiable_user_id',Auth::user()->id],['is_read',0]])->get();
    if(Auth::user()->user_type == "company")
    {
      return view('company.notification',compact('getNotifications'));
    }
    return view(theme('dashboard.notifications'), compact('getNotifications'));
  }

  public function view(Request $request)
  {

    $type = $request->type ;
      // dd($type);
    if($type == "company_purchase_courses")
    {
        // dd();
      return redirect('company/purchased-courses');
    }elseif($type == "biddig-request")
    {
      return redirect('dashboard/bidding-request');
    }elseif($type == "course_created_user")
    {
      return redirect('dashboard/my-courses');
    }
    elseif($type == "course-purchase-success")
    {
      return redirect('dashboard/enrolled-courses');

    }
    elseif($type == "company-register")

    {
      return redirect('admin/users?filter_user_group=company');

    }
    elseif($type == "subscrib")
    {
      return redirect('admin/packages/subscription');
    }
    elseif($type == "course_assigned_to_trainer")
    {
      return redirect('dashboard/assingned-courses');

    }
    elseif($type == "request-to-another-individual")
    {
        // dd('hsu');
      return redirect('dashboard/company-request');
    }
    elseif($type == "course-added-to-trainer")
    {
      return redirect('dashboard/assingned-courses');

    }
    else{
      return redirect()->back();
    }
  }


}