<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use App\User;
use App\CompanyPurchaseTemporary;
use App\RequiredCourseWorkforce;
use App\CompanyRequiredCourse;
use App\Course;
use Response;
use App\Bidding;
use App\CompanyWorkforce;
use App\CoursePurchase;
use App\Enroll;
use App\Functionality;
use App\Subscription;
use View;
use DB;
use Yajra\Datatables\Datatables;

class CourseController extends Controller
{
  public function searchCourses()
  {

    return view('company.course-search');
  }

  public function searchCourseItems(Request $request)
  {
    $skip = $request->skip;
    $take = 6;
    //DB::enableQueryLog();
    $arrData = Course::select('courses.*')
      ->leftjoin('course_skills as CS', 'CS.course_id', 'courses.id')
      ->leftjoin('course_occupations as CO', 'CO.course_id', 'courses.id')
      ->leftjoin('course_industries as CI', 'CI.course_id', 'courses.id');

    if ($request->keyword != "") {
      $arrData->where('title', 'like', '%' . $request->keyword . '%');
      //->orWhere('title_ar', 'like', '%' . $request->keyword . '%');
    }

    if ($request->skills != "") {
      $arrData->whereIn('CS.skill_id', $request->skills);
    }

    if ($request->occupation != "") {
      $arrData->whereIn('CO.occupation_id', $request->occupation);
    }

    if ($request->industry != "") {
      $arrData->whereIn('CI.industry_id', $request->industry);
    }

    if ($skip != 0) {
      $arrData->skip($skip);
    }
    $data = $arrData->where('status', 1)
      ->groupBy('courses.id')->take($take)
      ->get();

    /*$query = DB::getQueryLog();
        $query = end($query);
        print_r($query);
        exit;*/
    $countCourse = $data->count();
    $view = View::make('company.course-search-result', ['data' => $data, 'countCourse' => $countCourse]);
    $html = $view->render();
    // return $html;
    return response()->json([
      'html' => $html,
      'countCourse' => $countCourse
    ], 200);
  }

  public function saveCoursePurchaseRelation(Request $request)
  {
    // dd($request->all());

    $company_id  = Session::get('company_id');

    $obj  = new CompanyPurchaseTemporary();
    $obj->company_course_id  =  $request->input('company_course');
    $obj->purchase_course_id =  $request->input('purchase_course_id');
    $employees = $request->input('employees');
    $quantity  = count($employees);
    if (in_array('all', $employees)) {
      $quantity = $quantity - 1;
    }
    $obj->assigned_employees =  implode(',', $employees);
    $obj->unit_price         =  $request->input('unit_price');
    $obj->course_quantity    =  $quantity;
    $obj->save();
    Session::put('temp_course_id', $obj->id);
    $companyUserName = [];
    $companyWorkForseUserId = [];
    $userList = User::whereIn('id', $employees)->get();

    if ($userList) {
      foreach ($userList as  $companyUser) {
        $companyWorkForseUserId[] = $companyUser->id;
        $companyUserName[] = $companyUser->name;
      }
    };

    Session::forget(['company_user']);
    Session::push('company_user', $companyUserName);
    Session::forget(['company_work_force_user_id']);
    Session::push('company_work_force_user_id', $companyWorkForseUserId);

    $data = CompanyPurchaseTemporary::where('id', $obj->id)->first();
    return $data;
  }

  public function coursePayment()
  {
    return view('company.course-payment');
  }

  public function saveCoursePayment(Request $request)
  {
    //TODO 1: PAYMENT SECTION
    $payment_status = 1;
    if ($payment_status == 1) {
      $company_id  = Session::get('company_id');
      $temp_course_id  =  $request->input('temporary_id');
      $tempData = CompanyPurchaseTemporary::where('id', $temp_course_id)->where('status', 1)->first();

      //TODO 2: SAVE IN course_purchases TABLE
      $cpObj   = new CoursePurchase();
      $cpObj->purchase_code =  "";
      $cpObj->course_id =  $tempData->purchase_course_id;
      $cpObj->purchased_by_id   =  $company_id;
      $cpObj->purchased_by_type =  3;
      $cpObj->unit_purchase_price =  $tempData->unit_price;
      $cpObj->total_price =  $request->input('total_price');
      $cpObj->quantity =  $tempData->course_quantity;
      $cpObj->save();

      //TODO 3: SAVE IN course_attendees TABLE

      //SAVE IN company_required_courses
      $obj = CompanyRequiredCourse::where('id', $tempData->company_course_id)->first();
      $obj->purchase_course_id = $tempData->purchase_course_id;
      $obj->updated_at = now();
      $obj->updated_by = Auth::user()->id;
      $obj->save();

      //SAVE IN required_course_workforces
      $users   = $tempData->assigned_employees;
      $userArr = explode(",", $users);
      foreach ($userArr as $user) {
        if ($user != 'all') {
          $obj2   = new RequiredCourseWorkforce();
          $obj2->course_purchase_id =  $cpObj->id;
          $obj2->course_id =  $tempData->company_course_id;
          $obj2->user_id   =  $user;
          $obj2->save();
        }
      }

      //change status in temporary table
      $tempData->status = 0;
      $tempData->save;
      return $cpObj->id;
    }
  }

  //PURCHASED COURSE FUNCTIONALITIES
  public function purchasedCourses()
  {
    return view('company.purchased-courses');
  }

  public function getPurchasedCourses(Request $request)
  {
    $company_id = Session::get('company_id');

    DB::enableQueryLog();

    $data = CoursePurchase::select(
      'courses.title as course_title',
      'courses.slug as slug',
      'course_purchases.course_id as course_id',
      'course_purchases.total_price as total_price',
      'course_purchases.created_at as purchased_date',
      'company_required_courses.en_course_name'
    )
      ->leftjoin('courses', 'courses.id', 'course_purchases.course_id')
      ->leftjoin('company_required_courses', 'company_required_courses.id', 'course_purchases.course_id')
      ->where('course_purchases.purchased_by_id', $company_id)->get();

    return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('external_course', function ($model) {
        return  $model->en_course_name;
      })

      ->editColumn('purchased_course', function ($model) {
        return  $model->course_title;
      })

      ->editColumn('purchase_date', function ($model) {
        return date('Y M d', strtotime($model->purchased_date));
      })
      ->editColumn('spent_amount', function ($model) {
        return "$" . $model->total_price;
      })
      ->editColumn('payment_status', function ($model) {
        if ($model->enrollStatus) {
          return $model->enrollStatus->status;
        }
        return "1";
      })

      ->editColumn('actions', function ($model) {
        $html = '<a href="' . url('courses/' . $model->slug) . '" 
            class="btn btn-primary"><i class="fa fa-pencil-square-o"></i>preview</a>';
        return $html;
      })
      ->rawColumns(['s#', 'course_en', 'validity', 'department', 'position', 'project', 'payment_status', 'actions'])
      ->make(true);
  }


  public function saveBiddingPrice(Request $request)
  {
    // dd($request->all());
    // dd($request->all());
    $rules = [
      // 'course' => 'required',
      // 'course_type'=>'required',
      'employeesCount'=>'required',
      'bidding_price'=>'required'
  ];
  $this->validate($request, $rules);

    $auth = Auth::user();
    if ($auth->user_type == "company") {
      $functionality = Functionality::where('slug', 'bidding')->first();
      $checkUserSubscription = Subscription::join(
        'subscription_functionalities',
        'subscription_functionalities.subscription_id',
        'subscriptions.id'
      )
        ->where([
          ['subscriptions.user_id', Auth::user()->id],
          ['subscription_functionalities.functionality_id', $functionality->id]
        ])->first();
      if ($checkUserSubscription != null  && $checkUserSubscription->count > 0) {
        $companyBiddingCount = Bidding::where('company_id', $auth->id)->get()->count();
        if ($checkUserSubscription != null) {
          if ($checkUserSubscription->count == $companyBiddingCount) {
            return response()->json([
              'status' => false,
              'message' => "Your bidding limit is exceed...plese renew package",
              // 'data' => $checkUserSubscription
            ], 200);
          }
        } else {
          return response()->json([
            'status' => false,
            'message' => "can't bidding now ...please subscribe package",
            // 'data' => $checkUserSubscription
          ], 200);
        }
      }
    }
    // end package subscription in work force
    $auth = Auth::user();
    if (Auth::check()) {
      $bidding = new Bidding();
      $bidding->required_course_id =   $request->get('course') ? $request->get('course') : $request->get('course_id');
      $bidding->course_id =  $request->get('companCourse_id') ? $request->get('companCourse_id') : '';
      $bidding->company_id =  Auth::user()->id;
      $bidding->number_of_employees =  $request->get('employeesCount') ? $request->get('employeesCount') : '';
      $bidding->bidding_price = $request->get('bidding_price') ? $request->get('bidding_price') : '';
      if ($request->hasFile('request_document')) {
        $bidding->request_document = ImageUploadWithPath($request->request_document, 'request_document');
    }
      $bidding->status = 1;
      if ($auth->user_type == "project-manager") {
        $bidding->p_m_request = 1;
      }
      $bidding->created_by = Auth::user()->id;
      $bidding->deadline = $request->get('deadLine') ? $request->get('deadLine') : '';
      $bidding->aditional_info = $request->aditional_info;
      $bidding->course_start_date = $request->course_start_date ;
      $bidding->save();
      // Notification  section 
      if(!$request->types == 1)
      {
      $courseId =   $request->get('course') ? $request->get('course') : $request->get('course_id');
      $course = Course::find($courseId);
      $courseUser = $course->user_id;
      $notification = "You course  $course->title  has a bidding request by $auth->name ";
      $model_id = $bidding->id;
      $model = "biddig-request";
      if ($auth->user_type == "project-manager") {
        $userId =   $auth->parent_company;
        $notifications = "You have a new bidding request by project manager $auth->name";
        $model_ids = $bidding->id;  
        $models = "biddig-request-pm";
        userNotification($userId, $notifications, $model_ids, $models);
      return Response::json(['status' => true, 'bidding' => $bidding, 'message' => 'Please waiting for company admin approvel']);

      }
      if ($auth->user_type == "company") {
      userNotification($courseUser, $notification, $model_id, $model);
      }
    }
      if($request->types == 1)
      {
        // dd('ha');
        return redirect('company/bidding-list');
      }
      return Response::json(['status' => true, 'bidding' => $bidding, 'message' => 'You have successfully bidd']);
    } else {
      return Response::json(['status' => false]);
    }
  }
  public function enrolledCourses(Request $request)
  {
    return view('company.enrolled-course');
  }

  public function getEnrolledCourses()
  {



    $data = Enroll::where([['purchased_by', Auth::user()->id], ['status', 'success']])->orderBy('id', 'DESC')->get();

    return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('work_force', function ($model) {
        if ($model->user) {
          return $model->user->name;
        }
        return "";
      })

      ->editColumn('course', function ($model) {
        if ($model->course) {
          return $model->course->title;
        }
        return "";
      })

      ->editColumn('price', function ($model) {
        return  $model->course_price;
      })
      ->editColumn('status', function ($model) {
        return $model->status;
      })

      ->editColumn('actions', function ($model) {
        if ($model->course) {
          $html = '<a href="' . url('courses/' . $model->course->slug) . '" 
            class="btn btn-primary"><i class="fa fa-pencil-square-o"></i>preview</a>';
          return $html;
        }
        return "";
      })
      ->rawColumns(['s#', 'work_force', 'course', 'price', 'status', 'actions'])
      ->make(true);
  }
}
