<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubContractorController extends Controller
{
  public function index(Request $request)
  {
    return view('company.subcontractor.index');
  }
  public function getContractorData()
  {
    $data = User::where([['parent_company', Auth::user()->id],['user_type','contractor']])->get();;
    return DataTables::of($data)
      ->addIndexColumn()

      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('fname', function ($model) {
        return   $model->name ;
      })
      ->editColumn('view_matrix', function ($model) {
        return  "<a href='training-matrix?type=$model->id' class='btn btn-primary'> View</a></td>";
      })
      ->editColumn('email', function ($model) {
        return  $model->email;
      })
      ->rawColumns(['s#', 'fname', 'view_matrix','email'])
      ->make(true);
  }

  public function projectManagerIndex()
  {
    return view('company.projectManger.index');
  }

  public function getProjectManagerData()
  {
    $data = User::where([['parent_company', Auth::user()->id],['user_type','project-manager']])->get();;
    return DataTables::of($data)
      ->addIndexColumn()

      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('fname', function ($model) {
        return  $model->name;
      })
      ->editColumn('email', function ($model) {
        return  $model->email;
      })
      ->rawColumns(['s#', 'fname', 'email'])
      ->make(true);
  }
}
