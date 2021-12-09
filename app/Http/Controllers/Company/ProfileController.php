<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Company;
use Session;
use Response;
use App\CompanyPosition;
use App\CompanyLanguage;
use App\CompanyIndustry;
use App\CompanyOccupation;
use App\Country;
use App\Subscription;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
  public function profileViewPage()
  {
    $subscription = Subscription::where('user_id', Auth::user()->id)->get();
    return view('company.profile-view')->with(['subscription' => $subscription]);
  }

  public function getProfileData()
  {
    $company_id = Session::get('company_id');

    $data = User::select(
      'users.*',
      'cu.*',
      'c.*',
      'ct.*',
      'cd.contact_first_name',
      'cd.contact_last_name',
      'cd.position',
      'cd.gender',
      'cd.dob',
      DB::raw('(CASE 
      WHEN cd.gender = "1" THEN "Female" 
      WHEN cd.gender = "2" THEN "Male" 
      ELSE "Other" 
      END) AS gender'),
      // DB::raw("CASE WHEN cd.gender = 1 THEN 'Female'
      // WHEN cd.gender == 2 THEN 'Male' ELSE 'Bad Day' END"),
      'cd.email_id as contact_email'
    ) 
      ->leftjoin('company_users as cu', 'cu.user_id', 'users.id')
      ->leftjoin('companies as c', 'c.id', 'cu.company_id')
      ->leftjoin('countries as ct', 'ct.id', 'c.country_id')
      ->leftjoin('company_contact_details as cd', 'cd.company_id', 'c.id')
      //->leftjoin('company_positions as cp', 'cp.company_id','c.id')
      ->where('users.id', Auth::user()->id)
      ->first();
    $positions   = CompanyPosition::where('company_id', $company_id)->get();

    $languages   = CompanyLanguage::where('company_id', $company_id)
      ->leftjoin('languages as l', 'l.id', 'language_id')->get();

    $industries  = CompanyIndustry::select('i.en_name as en_industry', 'i.ar_name as ar_industry')
      ->where('company_industries.company_id', $company_id)
      ->leftjoin('industry as i', 'i.id', 'industry_id')->get();

    $occupations = CompanyOccupation::select('occupation.en_occupation as en_occupation', 'occupation.ar_occupation as ar_occupation')
      ->where('company_occupations.company_id', $company_id)
      ->leftjoin('occupation', 'occupation.id', 'company_occupations.occupation_id')->get();

    return response()->json([
      'basic_data' => $data,
      'positions' => $positions,
      'languages' => $languages,
      'industries' => $industries,
      'occupations' => $occupations
    ]);
  }
  public function call()
  {
    $user = User::find(1);
    return response()->json(['name' => $user->firstname, 'email' => $user->email]);
  }


  public function changePassword()
  {
    return view('company.change-password');
  }

  public function updateChangePassword(Request $request)
  {
    $rules = array(
      'current_password' => 'required',
      'password' => 'required|between:6,12|confirmed',
      'password_confirmation' => 'required|between:6,12'
    );
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails())
      return response()->json(array(
        'fail' => true,
        'errors' => $validator->getMessageBag()->toArray()
      ));
    else {

      $user = User::find(Auth::user()->id);
      if (Auth::attempt(['email' => $user->email, 'password' => $request->input('current_password')])) {

        $user->password = \Hash::make($request->input('password'));
        $user->save();

        if ($user->id) {
          return response()->json(array(
            'success' => true
          ));
        }
      } else {
        return response()->json(array(
          'fail' => true,
          'errors' => array('current_password' => 'Incorrect Current password')
        ));
      }
    }
  }

  public function getProfile()
  {
    // dd(new DateTimeZone('Asia/Kolkata'));
    $destinationTimezone = Carbon::now('Asia/Kolkata')->format('g:i a');

    //  dd($destinationTimezone);


    $countries = \App\Country::get();
    $industries = \App\Industry::get();
    $occupations = \App\Occupation::get();
    $all_languages = \App\AllLanguage::where('active', 1)->get();
    $userId = Auth::user()->id;
    $checkCompany = \App\CompanyUser::where('user_id', $userId)->first();
    // $country = Country::get();
    // dd($countries);
    if ($checkCompany) {
      $company = \App\Company::find($checkCompany->company_id);
      $companyLanguages = \App\CompanyLanguage::where('company_id', $company->id)->pluck('language_id')->toArray();
      $companyIndustries = \App\CompanyIndustry::where('company_id', $company->id)->pluck('industry_id')->toArray();
      $companyOccupations = \App\CompanyOccupation::where('company_id', $company->id)->pluck('occupation_id')->toArray();
      $contact_details = \App\CompanyContactDetail::where('company_id', $company->id)->first();
      return view('company.edit-profile')->with([
        'company' => $company,
        'countries' => $countries,
        'industries' => $industries,
        'occupations' => $occupations,
        'all_languages' => $all_languages,
        'contact_details' => $contact_details,
        'companyLanguages' => $companyLanguages,
        'companyIndustries' => $companyIndustries,
        'companyOccupations' => $companyOccupations,
        // 'country'=>$country
      ]);
    } else {
      return view('company.add-profile')->with([
        'countries' => $countries,
        'industries' => $industries,
        'occupations' => $occupations,
        'all_languages' => $all_languages,
        // 'country'=>$country
      ]);
    }
  }

  /**
   * @param Request $request
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function createProfile(Request $request)
  {

    $data = $request->all();
    $countryCode = $request->get('default_timezone');
    $countryTimezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $countryCode);

    // dd($countryTimezone[0]);
    $destinationTimezone = Carbon::now($countryTimezone[0])->format('g:i a');
    //  dd($data);
    if ($request->get('def_lan') == 'en') {
      $rules = array(
        //  'firstname' => 'required|min:2|max:200',   
        'company_name_en' => 'required|min:2|max:200',
        // 'email' => 'required',               

      );
    } else {
      $rules = array(
        //  'firstname' => 'required|min:2|max:200', 
        'company_name_ar' => 'required|min:2|max:200',
        // 'email' => 'required',                

      );
    }
    $validator = Validator::make($data, $rules);
    if ($validator->fails()) {
      return Response::json(['errors' => $validator->errors()]);
    } else {


      $user = User::find(Auth::user()->id);
      $user->profile_completion_status = 1;
      $main_image = $request->file('profile_file');
      if ($main_image) {
        $main_imageName = uniqid() . '.' . $main_image->extension();

        $user->profile_pic = $main_imageName;

        $main_image->move(public_path('uploads/company_logos/'), $main_imageName);
      }
      $user->timezone = $destinationTimezone;
      $user->country = $request->get('default_timezone');
      $user->save();
      if ($user) {
        $company = new Company();
        $company->en_company_name = $request->get('company_name_en');
        $company->ar_company_name = $request->get('company_name_ar');
        $company->en_about_company = $request->get('abt_company_en');
        $company->ar_about_company = $request->get('abt_company_ar');
        $company->address = $request->get('address');
        $company->country_id = $request->get('country');
        $company->newsletter_status = $request->get('newsletter');
        $company->website = $request->get('website');


        // if ($main_image) {
        //   $main_imageName = uniqid() . '.' . $main_image->extension();

        //   $company->logo = $main_imageName;

        //   $main_image->move(public_path('uploads/company_logos/'), $main_imageName);
        // } 
        $company->status = 1;
        $company->save();
        $contact_details = new \App\CompanyContactDetail();
        $contact_details->company_id = $company->id;
        $contact_details->contact_first_name = $request->get('cfirstname');
        $contact_details->contact_last_name = $request->get('clastname');
        $contact_details->gender = $request->get('gender');
        $contact_details->dob = $request->get('dob');
        $contact_details->position = $request->get('position');
        $contact_details->email_id = $request->get('cemail');
        $contact_details->phone = $request->get('cphone');
        $contact_details->save();
        if ($request->get('industry')) {

          foreach ($request->get('industry') as $ind) {
            $industry = new \App\CompanyIndustry();
            $industry->company_id = $company->id;
            $industry->industry_id = $ind;
            $industry->save();
          }
        }
        if ($request->get('occupation')) {
          foreach ($request->get('occupation') as $occ) {
            $occupation = new \App\CompanyOccupation();
            $occupation->company_id = $company->id;
            $occupation->occupation_id = $occ;
            $occupation->save();
          }
        }
        if ($request->get('pre_language')) {
          foreach ($request->get('pre_language') as $prelan) {
            $lan = new \App\CompanyLanguage();
            $lan->company_id = $company->id;
            $lan->language_id = $prelan;
            $lan->save();
          }
        }
      }

      $userInfo = new \App\CompanyUser();
      $userInfo->user_id = Auth::user()->id;
      $userInfo->company_id = $company->id;
      $userInfo->user_role = 2;
      $userInfo->save();



      return response()->json(['status' => true, 'message' => 'New Company added.']);
    }
  }

  public function updateProfile(Request $request)
  {
    // dd('hh');
    $data = $request->all();
    $countryCode = $request->get('default_timezone');
    $countryTimezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $countryCode);

    // dd($countryTimezone[0]);
    $destinationTimezone = Carbon::now($countryTimezone[0])->format('g:i a');
    // dd($destinationTimezone);
    // dd($request->all());
    if ($request->get('def_lan') == 'en') {

      $rules = array(
        // 'firstname' => 'required|min:2|max:200',   
        'company_name_en' => 'required|min:2|max:200',
        // 'email' => 'required',               

      );
    } else {

      $rules = array(
        //'firstname' => 'required|min:2|max:200', 
        'company_name_ar' => 'required|min:2|max:200',
        //'email' => 'required',                

      );
    }

    $validator = Validator::make($data, $rules);

    // if ($validator->fails()) {
    //     return redirect()->back()->withErrors($v->errors())->withInput($request->except('password'));
    // }

    $user = User::find(Auth::user()->id);

    $main_image = $request->file('profile_file');
    if ($main_image) {
      $main_imageName = uniqid() . '.' . $main_image->extension();

      $user->profile_pic = $main_imageName;

      $main_image->move(public_path('uploads/company_logos/'), $main_imageName);
    }
    $user->timezone = $destinationTimezone;
    $user->country = $request->get('default_timezone');
    $user->save();
    $company = Company::find($request->get('companyId'));
    $company->en_company_name = $request->get('company_name_en');
    $company->ar_company_name = $request->get('company_name_ar');
    $company->en_about_company = $request->get('abt_company_en');
    $company->ar_about_company = $request->get('abt_company_ar');
    $company->address = $request->get('address');
    $company->country_id = $request->get('country');
    $company->newsletter_status = $request->get('newsletter');
    $company->website = $request->get('website');
    //   $main_image = $request->file('profile_file');

    // if ($main_image) {
    //   $main_imageName = uniqid() . '.' . $main_image->extension();

    //   $company->logo = $main_imageName;

    //   $main_image->move(public_path('uploads/company_logos/'), $main_imageName);
    // } 
    // $company->status = 1;
    $company->save();


    if ($company) { 

      $contact_details =  \App\CompanyContactDetail::where('company_id', $company->id)->first();
      if ($contact_details) {
        $contact_details->company_id = $company->id;
        $contact_details->contact_first_name = $request->get('cfirstname');
        $contact_details->contact_last_name = $request->get('clastname');
        $contact_details->gender = $request->get('gender');
        $contact_details->dob = $request->get('dob');
        $contact_details->position = $request->get('position');
        $contact_details->email_id = $request->get('cemail');
        $contact_details->phone = $request->get('cphone');
        $contact_details->save();
      }


      $userInfo =  \App\CompanyUser::where('company_id', $company->id)->first();

      if ($userInfo) {

        $getUser = \App\User::find($userInfo->user_id);
      }
      if ($request->get('industry')) {
        $chkInd = \App\CompanyIndustry::where('company_id', $company->id)->get();
        if (count($chkInd) > 0) {
          \App\CompanyIndustry::where('company_id', $company->id)->delete();
        }
        foreach ($request->get('industry') as $ind) {
          $industry = new \App\CompanyIndustry();
          $industry->company_id = $company->id;
          $industry->industry_id = $ind;
          $industry->save();
        }
      }
      if ($request->get('occupation')) {
        $chkOcc = \App\CompanyOccupation::where('company_id', $company->id)->get();
        if (count($chkOcc) > 0) {
          \App\CompanyOccupation::where('company_id', $company->id)->delete();
        }
        foreach ($request->get('occupation') as $occ) {
          $occupation = new \App\CompanyOccupation();
          $occupation->company_id = $company->id;
          $occupation->occupation_id = $occ;
          $occupation->save();
        }
      }
      if ($request->get('pre_language')) {
        $chkLan = \App\CompanyLanguage::where('company_id', $company->id)->get();
        if (count($chkLan) > 0) {
          \App\CompanyLanguage::where('company_id', $company->id)->delete();
        }
        foreach ($request->get('pre_language') as $prelan) {
          $lan = new \App\CompanyLanguage();
          $lan->company_id = $company->id;
          $lan->language_id = $prelan;
          $lan->save();
        }
      }
    }


    return response()->json(['status' => true, 'message' => 'Company details updated.']);
  }
}
