<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CompanyPosition;
use Illuminate\Support\Facades\Auth;
use App\User;
use Yajra\Datatables\Datatables;
use Session;
use App\CompanyDepartment;
use App\CompanyProject;
use App\CompanyWorkforce;
use App\WorkforceDepartment;
use App\WorkforcePosition;
use App\WorkforceProject;

class SettingsController extends Controller
{
  public function index()
  {
  }
  /* COMPANY POSITIONS */
  public function positions()
  {
    return view('company.positions');
  }

  public function getPositionsFn(Request $request)
  {
    $company_id = Session::get('company_id');
    $userType = Auth::user()->user_type;
    // dd($userType);
    $data = CompanyPosition::select('id', 'company_id', 'position_en', 'position_ar')
      ->where(function ($q) use ($userType, $company_id) {
        if ($userType == "company") {
          $q->where('company_id', $company_id);
        }
        if ($userType == "contractor") {
          $q->where('company_id', Auth::user()->parent_company);
        }
      })

      ->orderBy('id', 'desc')->get();

    return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('title_en', function ($model) {
        return  $model->position_en;
      })

      ->editColumn('title_ar', function ($model) {
        return  $model->position_ar;
      })

      ->editColumn('actions', function ($model) use ($userType) {
        if ($userType == "company") {
          return '<a href="javascript:void(0);" class="act-sp" title="Edit" data-id="' . $model->id . '" data-en="' . $model->position_en . '" data-ar="' . $model->position_ar . '" onclick="showEditModal(this)"><i class="fa fa-fw fa-edit"></i></a>
        <a href="javascript:void(0);" class="act-sp" title="Delete" data-id="' . $model->id . '"  onclick="showConfirmModal(this)"><i class="fa fa-fw fa-trash"></i></a>';
        } else {
          return "no permission";
        }
      })
      ->rawColumns(['s#', 'title_en', 'title_ar', 'actions'])
      ->make(true);
  }

  public function saveCompanyPosition(Request $request)
  {
    $company_id = Session::get('company_id');
    if ($request->input('position_id') == "") {
      $obj  = new CompanyPosition();
      $obj->company_id  =  $company_id;
    } else {
      $obj = CompanyPosition::where('id', $request->input('position_id'))->first();
      $obj->updated_at = now();
      $obj->updated_by = $company_id;
    }
    $obj->position_en =  $request->input('position_en');
    $obj->position_ar =  $request->input('position_ar');
    $obj->save();
    if ($obj->id) {
      return response()->json(['status' => 'success'], 200);
    } else {
      return response()->json(['status' => 'error'], 422);
    }
  }

  public function deletePosition(Request $request)
  {
    $positionId = $request->position_id;
    if ($positionId) {
      CompanyPosition::find($positionId)->delete();
    }
    $userId = $request->input('userId');
    if ($userId) {
      User::find($userId)->delete();
      CompanyWorkforce::where('user_id', $userId)->delete();
      WorkforceDepartment::where('user_id', $userId)->delete();
      WorkforcePosition::where('user_id', $userId)->delete();
      WorkforceProject::where('user_id', $userId)->delete();

      return 1;
    }
  }

  /* COMPANY DEPARTMENTS */
  public function departments()
  {
    return view('company.departments');
  }

  public function getDepartmentsFn(Request $request)
  {
    $userType = Auth::user()->user_type;
    $company_id = Session::get('company_id');
    $data = CompanyDepartment::select('id', 'company_id', 'en_department', 'ar_department')
    ->where(function ($q) use ($userType, $company_id) {
      if ($userType == "company") {
        $q->where('company_id', $company_id);
      }
      if ($userType == "contractor") {
        $q->where('company_id', Auth::user()->parent_company);
      }
    })
      ->orderBy('id', 'desc')->get();

    return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('title_en', function ($model) {
        return  $model->en_department;
      })

      ->editColumn('title_ar', function ($model) {
        return  $model->ar_department;
      })

      ->editColumn('actions', function ($model) use($userType){
        if($userType == "company")
        {
        return '<a href="javascript:void(0);" class="act-sp" title="Edit" data-id="' . $model->id . '" data-en="' . $model->en_department . '" data-ar="' . $model->ar_department . '" onclick="showEditModal(this)"><i class="fa fa-fw fa-edit"></i></a>
        <a href="javascript:void(0);" class="act-sp" title="Delete" data-id="' . $model->id . '"  onclick="showConfirmModal(this)"><i class="fa fa-fw fa-trash"></i></a>';
      } else {
        return "no permission";
      }
      })
      ->rawColumns(['s#', 'title_en', 'title_ar', 'actions'])
      ->make(true);
  }

  public function saveCompanyDepartment(Request $request)
  {
    $company_id = Session::get('company_id');
    if ($request->input('department_id') == "") {
      $obj  = new CompanyDepartment();
      $obj->company_id  =  $company_id;
    } else {
      $obj = CompanyDepartment::where('id', $request->input('department_id'))->first();
      $obj->updated_at = now();
      $obj->updated_by = $company_id;
    }
    $obj->en_department =  $request->input('department_en');
    $obj->ar_department =  $request->input('department_ar');
    $obj->save();
    if ($obj->id) {
      return response()->json(['status' => 'success'], 200);
    } else {
      return response()->json(['status' => 'error'], 422);
    }
  }

  public function deleteDepartment(Request $request)
  {
    $obj = CompanyDepartment::where('id', $request->input('department_id'))->first();
    $obj->delete();
    return 1;
  }

  /* COMPANY PROJECTS */

  public function projects()
  {
    return view('company.projects');
  }

  public function getProjectsFn(Request $request)
  {
    $company_id = Session::get('company_id');
    $userType = Auth::user()->user_type;
    
    $data = CompanyProject::select('id', 'company_id', 'en_project', 'ar_project')
    ->where(function ($q) use ($userType, $company_id) {
      if ($userType == "company") {
        $q->where('company_id', $company_id);
      }
      if ($userType == "contractor") {
        $q->where('company_id', Auth::user()->parent_company);
      }
    })
      ->orderBy('id', 'desc')->get();

    return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('title_en', function ($model) {
        return  $model->en_project;
      })

      ->editColumn('title_ar', function ($model) {
        return  $model->ar_project;
      })

      ->editColumn('actions', function ($model) use($userType) {
        if($userType == "company")
        {
        return '<a href="javascript:void(0);" class="act-sp" title="Edit" data-id="' . $model->id . '" data-en="' . $model->en_project . '" data-ar="' . $model->ar_project . '" onclick="showEditModal(this)"><i class="fa fa-fw fa-edit"></i></a>
        <a href="javascript:void(0);" class="act-sp" title="Delete" data-id="' . $model->id . '"  onclick="showConfirmModal(this)"><i class="fa fa-fw fa-trash"></i></a>';
      } else {
        return "no permission";
      }
      })
      ->rawColumns(['s#', 'title_en', 'title_ar', 'actions'])
      ->make(true);
  }


  public function saveCompanyProject(Request $request)
  {
    $company_id = Session::get('company_id');
    if ($request->input('project_id') == "") {
      $obj  = new CompanyProject();
      $obj->company_id  =  $company_id;
    } else {
      $obj = CompanyProject::where('id', $request->input('project_id'))->first();
      $obj->updated_at = now();
      $obj->updated_by = $company_id;
    }
    $obj->en_project =  $request->input('project_en');
    $obj->ar_project =  $request->input('project_ar');
    $obj->save();
    if ($obj->id) {
      return response()->json(['status' => 'success'], 200);
    } else {
      return response()->json(['status' => 'error'], 422);
    }
  }

  public function deleteProject(Request $request)
  {
    $obj = CompanyProject::where('id', $request->input('project_id'))->first();
    $obj->delete();
    return 1;
  }
}
