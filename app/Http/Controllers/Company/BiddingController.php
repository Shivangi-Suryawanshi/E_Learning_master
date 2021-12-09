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
use App\CoursePurchase;
use View;
use DB;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\Facades\DataTables;

class BiddingController extends Controller
{
  public function index()
  {

    return view('company.bidding');
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
      $arrData->where('title_en', 'like', '%' . $request->keyword . '%');
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
      ->take($take)
      ->get();

    /*$query = DB::getQueryLog();
        $query = end($query);
        print_r($query);
        exit;*/

    $view = View::make('company.course-search-result', ['data' => $data]);
    $html = $view->render();
    return $html;
  }

  public function saveCoursePurchaseRelation(Request $request)
  {
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
      'company_required_courses.id as id',
      'company_required_courses.company_id',
      'company_required_courses.en_course_name',
      'company_required_courses.ar_course_name',
      'company_required_courses.type',
      'company_required_courses.validity',
      'company_required_courses.status',

      'RD.course_id',
      'RD.department_id as department_id',
      'RD.status',
      'RP.course_id',
      'RP.position_id as position_id',
      'RP.status',
      'RJ.course_id',
      'RJ.project_id as project_id',
      'RJ.status'
    )

      ->leftjoin('required_course_departments as RD', 'RD.course_id', 'company_required_courses.id')
      ->leftjoin('required_course_positions as RP', 'RP.course_id', 'company_required_courses.id')
      ->leftjoin('required_course_projects as RJ', 'RJ.course_id', 'company_required_courses.id')
      ->where('company_required_courses.status', 1)
      ->where('RD.status', 1)
      ->where('RP.status', 1)
      ->where('RJ.status', 1)
      ->where('company_required_courses.company_id', $company_id);

    if ($request->department != "") {
      $data->whereIn('department_id', $request->department);
    }

    if ($request->position != "") {
      $data->whereIn('position_id', $request->position);
    }

    if ($request->project != "") {
      $data->whereIn('project_id', $request->project);
    }

    $data = $data->groupBy('company_required_courses.id')
      ->orderBy('company_required_courses.id', 'desc')->get();

    // $query = DB::getQueryLog();
    // $query = end($query);
    // print_r($query);
    // exit;

    // if(session()->has('language')){
    //   $language = Session::get('language');
    //   if($language == 'english'){
    //     $prefix = 'en';
    //   }else{
    //     $prefix = 'ar';
    //   }
    // }

    return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('course_name', function ($model) {
        return  $model->en_course_name;
      })

      ->editColumn('validity', function ($model) {
        return  $model->validity;
      })

      ->editColumn('department', function ($model) {
        $departments      = $model->required_course_departments;
        $department_names = "";
        foreach ($departments as $department) {
          $department_names .= $department->company_department['en_department'] . "</br>";
        }
        return  $department_names;
      })

      ->editColumn('position', function ($model) {
        $positions      = $model->required_course_positions;
        $position_names = "";

        foreach ($positions as $position) {
          $position_names .= $position->company_position['position_en'] . "</br>";
        }
        return  $position_names;
      })

      ->editColumn('project', function ($model) {
        $projects      = $model->required_course_projects;
        $project_names = "";
        foreach ($projects as $project) {
          $project_names .= $project->company_project['en_project'] . "</br>";
        }
        return  $project_names;
      })

      ->editColumn('actions', function ($model) {
        return '<a href="javascript:void(0);" class="act-sp" title="Edit"
            data-id="' . $model->id . '"
            data-en-course="' . $model->en_course_name . '"
            data-ar-course="' . $model->ar_course_name . '"
            data-course-type="' . $model->type . '"
            data-validity="' . $model->validity . '"
            data-department="' . $model->department_id . '"
            data-position="' . $model->position_id . '"
            data-project="' . $model->project_id . '"
  
            onclick="showEditModal(this)"><i class="fa fa-fw fa-edit"></i></a>
            <a href="javascript:void(0);" class="act-sp" title="Delete" data-id="' . $model->matrix_id . '"  onclick="showConfirmModal(this)"><i class="fa fa-fw fa-trash"></i></a>';
      })
      ->rawColumns(['s#', 'course_en', 'validity', 'department', 'position', 'project', 'actions'])
      ->make(true);
  }


  public function saveBiddingPrice(Request $request)
  {

    if (Auth::check()) {
      $bidding = new Bidding();
      $bidding->course_id =  $request->get('course_id') ? $request->get('course_id') : '';
      $bidding->company_id =  $request->get('company_id') ? $request->get('company_id') : '';
      $bidding->number_of_employees =  $request->get('employeesCount') ? $request->get('employeesCount') : '';
      $bidding->bidding_price = $request->get('bidding_price') ? $request->get('bidding_price') : '';
      $bidding->status = 1;
      $bidding->created_by = Auth::user()->id;
      $bidding->save();
      $courseId = $request->course_id;
      $course = Course::find($courseId);
      $user = $course->user_id;
      $notification = "You Have successfullya new bidding request $course->title";
      $model_id = $course->id;
      $model = "bidding_request";
      userNotification($user, $notification, $model_id, $model);
      return Response::json(['status' => true, 'bidding' => $bidding, 'message' => "You have successfully requested"]);
    } else {
      return Response::json(['status' => false]);
    }
  }
  public function list()
  {
    return view('company.bidding.index');
  }
  public function getBiddingList()
  {
    $data = Bidding::join('courses', 'courses.id', 'biddings.required_course_id')
      ->select(
        'courses.title as title',
        'biddings.id as id',
        'biddings.bidding_price as bidding_price',
        'biddings.number_of_employees as number_of_employees',
        'biddings.acceptance_price as acceptance_price',
        'biddings.message as message',
        'biddings.document as document',
        'biddings.created_at as created_at',
        'biddings.updated_by as updated_by'
      )
      ->where([['biddings.company_id', Auth::user()->id],
      //  ['biddings.accepatnce_status', 1]
       ])
      ->get();
    return DataTables::of($data)

      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('course', function ($model) {
        return $model->title;
      })
      // ->editColumn('total_employee', function ($model) {
      //   return $model->number_of_employees;
      // })
      ->editColumn('details', function ($model) {
        $date = date('d M Y', strtotime($model->created_at));
        $html = "Submission Date :$date </br>
        Requested Price : $model->bidding_price </br>
        Accepted Price : $model->acceptance_price <br>
        Message : $model->message </br>
        Total Student : $model->number_of_employees 
        ";
        return $html;
        // return date('d M Y', strtotime($model->created_at));
      })
      ->editColumn('instructor_name', function ($model) {
        if($model->instructorName)
        {
          return $model->instructorName->name ;
        }
        return "";
      })
      // ->editColumn('accepted_price', function ($model) {
      //   return $model->acceptance_price;
      // })
      // ->editColumn('message', function ($model) {
      //   return $model->message;
      // })
      ->editColumn('document', function ($model) {
        return '<a target ="_blank" href ="/media/document/'.$model->document.'">'.$model->document.'</a>'  ;

      })
      ->editColumn('promocode', function ($model) {
        if($model->couponCodeCheck)
        {
          return $model->couponCodeCheck->coupon_code . "<br>"."<small>expiry date: </small>" . $model->couponCodeCheck->valid_to;
        }
        return "no promocode";
      })
      ->rawColumns(['s#', 'course', 'details', 'instructor_name','document','promocode'])
      ->make(true);
  }


  public function requestList()
  {
    return view('company.bidding-request-list.index');

  }
  public function requestBiddingList()
  {
    $data = Bidding::join('courses', 'courses.id', 'biddings.required_course_id')
    ->join('users','users.id','biddings.company_id')
    ->select(
      'courses.title as title',
      'biddings.id as id',
      'biddings.bidding_price as bidding_price',
      'biddings.number_of_employees as number_of_employees',
      'biddings.acceptance_price as acceptance_price',
      'biddings.message as message',
      'biddings.document as document',
      'biddings.created_at as created_at',
      'biddings.updated_by as updated_by',
      'biddings.required_course_id as required_course_id',
      'biddings.p_m_request as  p_m_request',
      'users.name as userName'
    )
    ->where([['users.parent_company', Auth::user()->id]])
    ->get();
  return DataTables::of($data)

    ->addIndexColumn()
    ->editColumn('s#', function ($model) {
      return '<span class="si_no"></span> ';
    })

    ->editColumn('course', function ($model) {
      return $model->title;
    })
    // ->editColumn('total_employee', function ($model) {
    //   return $model->number_of_employees;
    // })
    ->editColumn('details', function ($model) {
      $date = date('d M Y', strtotime($model->created_at));
      $html = "Submission Date :$date </br>
      Requested Price : $model->bidding_price </br>
      
      Total Student : $model->number_of_employees  </br>
      Project Manager : $model->userName </br>
      Accepted Price : $model->acceptance_price <br>
      Message : $model->message 
      ";
      return $html;
      // return date('d M Y', strtotime($model->created_at));
    })
    ->editColumn('instructor_name', function ($model) {
      if($model->biddingRequestCourse)
      {
        
        if($model->biddingRequestCourse->author)
        {
          return $model->biddingRequestCourse->author->name ;
        }
       
      }
      return "";
    })
    ->editColumn('status', function ($model) {
      if($model->p_m_request == 0)
      {
        return "Accepted";
      }
      
     $html = "<a class='btn btn-success accept-bidding' data-id='$model->id'  > Accept </a> ";
    //  &nbsp; &nbsp;<a class='btn btn-danger' > Reject </a>" ;
     return $html;

    })
 
    ->rawColumns(['s#', 'course', 'details', 'instructor_name','status'])
    ->make(true);
  }
  public function acceptBiddingRequest(Request $request)
  {
    $id = $request->id;
    if($id)
    {
      $bidding = Bidding::find($id);
      $bidding->p_m_request = 0 ;
      $bidding->save();
    }else
    {
      return response()->json([
        'status'=>false,
        'messgae'=>"server error"
      ],500);
    }
  }
}
