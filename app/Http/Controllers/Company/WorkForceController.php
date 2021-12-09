<?php

namespace App\Http\Controllers\Company;

use App\CompanyIndividualRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Session;
use App\User;
use App\CompanyWorkforce;
use App\Functionality;
use App\Subscription;
use App\WorkforcePosition;
use App\WorkforceProject;
use App\WorkforceDepartment;
// use Stripe\Subscription;

class WorkForceController extends Controller
{
  public function index()
  {
    return view('company.workforce');
  }

  public function getWorkforceData(Request $request)
  {


    $company_id = Auth::user()->id;
    $userType = Auth::user()->user_type ;
    // $contractorId = User::where('parent_company',$company_id)->get();
    // $contractorId = $user->id ;
    // dd($user);
    $data = CompanyWorkforce::join('users', 'users.id', 'company_workforce.user_id')
    ->leftjoin('users as contractorUser','contractorUser.id','company_workforce.company_id')
    ->where( function ($q) use($userType,$company_id)
    {
      if($userType == "company")
      {
        $q->where('company_workforce.company_id',$company_id)
        ->orWhere('contractorUser.parent_company',$company_id);
      }
     if($userType == "contractor")
     {
      $q->where('company_workforce.company_id',$company_id) ;
     }
    })
      // ->where('company_workforce.company_id', $company_id)
      ->select('company_workforce.*', 'users.name as name', 'users.email as email',
      'contractorUser.user_type as user_type','contractorUser.name as contractorUserName')
      ->orderBy('users.id', 'desc')
      ->get();
    // dd($data);
    return Datatables::of($data)
      ->addIndexColumn()

      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('fname', function ($model) {
        return  $model->name ;
      })
      ->editColumn('added_by', function ($model) {
       
          return  " <span class='badge badge-danger'> <i class='la la-check-circle'></i>$model->contractorUserName ( $model->user_type)</span>";

      })

      ->editColumn('work_id', function ($model) {
        return  $model->work_id;
      })

      ->editColumn('email', function ($model) {
        return  $model->email;
      })

      ->editColumn('department', function ($model) {

        $departments      = $model->workforce_departments;
        $department_names = "";
        if($departments)
        {
        foreach ($departments as $department) {
          if(isset($department->workforce_department_data['en_department']))
            {
          $department_names .= $department->workforce_department_data['en_department'] . "</br>";
            }
        }
           }

        return  $department_names;
      })

      ->editColumn('position', function ($model) {
        $positions      = $model->workforce_positions;
        $position_names = "";
        if($positions)
        {
          foreach ($positions as $position) {
            if(isset($position->workforce_positions_data['position_en']))
            {
          $position_names .= $position->workforce_positions_data['position_en'] . "</br>";
            }
          }
        }
        return  $position_names;
      })

      ->editColumn('project', function ($model) {
        $projects      = $model->workforce_projects;
        $project_names = "";
        if($projects)
        {
          
          foreach ($projects as $project) {
            if(isset($project->workforce_projects_data['en_project']))
            {
          $project_names .= $project->workforce_projects_data['en_project'] . "</br>";
            }
        }
      }

        return  $project_names;
      })

      ->editColumn('actions', function ($model) {
        return '<a href="javascript:void(0);" class="act-sp" title="Edit"
            data-id="' . $model->user_id . '"
            data-fname="' . $model->name . '"
            data-lname="' . $model->lastname . '"
            data-email="' . $model->email . '"
            data-work-id="' . $model->work_id . '"
            data-password="******"
            onclick="showEditModal(this)"><i class="fa fa-fw fa-edit"></i></a>
            <a href="javascript:void(0);" class="act-sp" title="Delete" data-id="' . $model->user_id . '"  onclick="showConfirmModal(this)"><i class="fa fa-fw fa-trash"></i></a>';
      })

      ->rawColumns(['s#', 'fname', 'added_by','work_id', 'email', 'department', 'position', 'project', 'actions'])
      ->make(true);
  }

  public function addWorkforceFn(Request $request)
  {
    // start package subscription in work force
    // dd($request->all());
    $company_id = Session::get('company_id');
    if(Auth::user()->user_type == "company")
    {
    $functionality = Functionality::where('slug', 'workforce-user')->first();
    $checkUserSubscription = Subscription::join(
      'subscription_functionalities',
      'subscription_functionalities.subscription_id',
      'subscriptions.id'
    )
      ->where([
        ['subscriptions.user_id', Auth::user()->id],
        ['subscription_functionalities.functionality_id', $functionality->id]
      ])->first();
      if($checkUserSubscription != null  && $checkUserSubscription->count > 0)
      {
      $companyWorkForceCount = CompanyWorkforce::where('company_id',$company_id)->get()->count();
      if($checkUserSubscription != null)
      {
      if($checkUserSubscription->count == $companyWorkForceCount)
      {
        return response()->json([
          'status' => 'false',
          'message' => "You subscription limit is exceed...plese renew package",
          // 'data' => $checkUserSubscription
        ], 200);
      }
    }
    else{
      return response()->json([
        'status' => 'false',
        'message' => "can 't add workforce ...please subscribe package",
        // 'data' => $checkUserSubscription
      ], 200);
    }
  }
  }
    // end package subscription in work force
  

    
    $user_id    = $request->input('user_id');
    $email      = $request->input('email');

    if ($user_id == "") {
      $user_save  = $this->checkCompanyCanAddUser($email, $company_id);
      if ($user_save != 'duplicate' && $user_save != 'type_mismatch') {
        if ($user_save == 'new') {
          //frst save in user table
          $user  = new User();
          $user->name = $request->input('fname') . " " . $request->input('lname');
          $user->email  = $request->input('email');
          $user->password  = bcrypt($request->password);
          // $user->role   = 6;
          $user->user_type   = "student";
          $user->active_status = 0;
          $user->save();
          $user_id = $user->id;
        } else {
          //set user id = user_save
          $user_id = $user_save;
        }
      } else {
        return response()->json(['status' => $user_save], 200);
      }
      $obj  = new CompanyWorkforce();
      $obj->user_id    = $user_id;
      $obj->company_id = $company_id;
      $obj->status = 2;
      $obj->created_by = Auth::user()->id;
    } else {
      $user    = User::where('id', $user_id)->first();
      $user->name = $request->input('fname') . " " . $request->input('lname');
      $user->email = $request->input('email');
      if ($request->input('password' != null && $request->input('password') != "******")) {
        $user->password = bcrypt($request->password);
      }
      $user->save();

      $obj  = CompanyWorkforce::where('user_id', $user_id)->first();
      $obj->updated_at = now();
      $obj->updated_by = Auth::user()->id;
    }

    $obj->work_id  = $request->input('work_id');
    $obj->save();

    if ($user_id != "") {
      $delObj  = WorkforcePosition::where('user_id', $user_id)->delete();
      $delObj  = WorkforceDepartment::where('user_id', $user_id)->delete();
      $delObj  = WorkforceProject::where('user_id', $user_id)->delete();
    }

    $positionArr = $request->input('position');
    if ($positionArr) {
      foreach ($positionArr as $position) {
        $relObj  = new WorkforcePosition();
        $relObj->user_id = $user_id;
        $relObj->position_id = $position;
        $relObj->status = 1;
        $relObj->created_by = $company_id;
        $relObj->created_at = now();
        $relObj->save();
      }
    }

    $departmentArr =  $request->input('department');
    if ($departmentArr) {
      foreach ($departmentArr as $department) {
        $depObj  = new WorkforceDepartment();
        $depObj->user_id = $user_id;
        $depObj->department_id = $department;
        $depObj->status = 1;
        $depObj->created_by = $company_id;
        $depObj->created_at = now();
        $depObj->save();
      }
    }

    $projectArr =  $request->input('project');
    if ($projectArr) {
      foreach ($projectArr as $project) {
        $prObj  = new WorkforceProject();
        $prObj->user_id = $user_id;
        $prObj->project_id = $project;
        $prObj->status = 1;
        $prObj->created_by = $company_id;
        $prObj->created_at = now();
        $prObj->save();
      }
    }

    if ($obj->id) {
      if ($request->input('user_id') != null) {
        $message = " You have sucessfully updated";
      } else {
        $message = "You have sucessfully added";
      }
      //code for email verification
      return response()->json(['status' => 'success', 'message' => $message], 200);
    } else {
      return response()->json(['status' => 'error'], 422);
    }
  }

  public function checkCompanyCanAddUser($email, $company_id = null)
  {
    $user = User::where('email', $email)->first();
    if ($user) {
      if ($user->role == 6) {
        $workforce = CompanyWorkforce::where('company_id', $company_id)
          ->where('user_id', $user->id)
          ->first();
        if ($workforce) {
          return 'duplicate'; //'company_already_have_this_emplyee-duplicate_entry';
        }
        return $user->id; //user_exit_only_in_user_table
      } else {
        return 'type_mismatch'; //'usertype_mismatch';
      }
    } else {
      return 'new'; //'user_not_exist'
    }
  }

  public function userEmailCheck(Request $request)
  {
    $id = $request->id;

    $authUser = Auth::user()->id;
    $email = $request->input('email');
    $isExist = User::join('company_workforce', 'company_workforce.user_id', 'users.id')
      ->where([['users.email', $email], ['company_workforce.company_id', $authUser]])
      ->where(function ($q) use ($id) {
        if ($id != null) {
          $q->where('users.id', '!=', $id);
        }
      })->first();
    if ($isExist) {
      return response()->json(false);
    } else {
      return response()->json(true);
    }
  }
  public function requestForm()
  {
   
   return view('company.request-individual.create');
  }

  public function searchIndidual(Request $request)
  {
    $rules = [
      'search' => 'required|email'
  ];
  $this->validate($request, $rules);
  $search = $request->search;
 
  $user = User::where([['email', $search],['user_type', 'student']])->first();

  $checkAlreadyCompanyUser = CompanyWorkforce::where('user_id',$user->id)->first();
  if ($user && isset($checkAlreadyCompanyUser->company_id) == false ) {


    $companyRequest = CompanyIndividualRequest::where([['company_user_id',Auth::user()->id],['individual_user_id',$user->id]])->first();
      $view = view('company.request-individual.search-result', compact('user','companyRequest'));
      $html = $view->render();
      return response()->json([
          'html' => $html,
          'status' => true,

      ], 200);
  }else {
      return response()->json([
          'message' => no_data(null, null, 'my-5'),
          'status' => false
      ], 200);
  }
  }

  public function individualStatus(Request $request)
  {
    $id = $request->id;
    $auth = Auth::user();
    $individual = new  CompanyIndividualRequest();
    $individual->company_user_id = Auth::user()->id;
    $individual->individual_user_id = $id;
    $individual->request_status = 0;
    $individual->save();
    //notification to requested trainer
    $user = $id ;
    $notification = "You have new  request from company $auth->name " ;
    $model = "request-to-another-individual";
    $model_id = $individual->id ;
    userNotification($user, $notification, $model_id, $model) ;
   

    return response()->json([
        'status' => true,
        'message' => "successfull requested"
    ], 200);
  }
}
