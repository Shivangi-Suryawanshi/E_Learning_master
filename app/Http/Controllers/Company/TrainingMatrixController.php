<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CompanyPosition;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\CompanyRequiredCourse;
use Yajra\Datatables\Datatables;
use Session;
use App\CompanyWorkforce;
use App\RequiredCourseWorkforce;
use App\RequiredCourseDepartment;
use App\RequiredCoursePosition;
use App\RequiredCourseProject;
use DB;
use Carbon\Carbon;

class TrainingMatrixController extends Controller
{
  public function index()
  {
  }

  public function matrixStructure()
  {
    return view('company.training-matrix-structure');
  }

  public function getMatrixStructureFn(Request $request)
  {
    $company_id = Session::get('company_id');

    DB::enableQueryLog();

    $data = CompanyRequiredCourse::select(
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
      ->editColumn('type', function ($model) {
        if ($model->type == 1) {
          return "Internal";
        } elseif ($model->type == 2) {
          return "External";
        }
        return  "";
      })

      ->editColumn('department', function ($model) {
        $departments      = $model->required_course_departments;
        $department_names = "";
        if($departments)
        {
        foreach ($departments as $department) {
          $department_names .= isset($department->company_department['en_department']) ? $department->company_department['en_department'] : ""  . "</br>";
        }
        }
        return  $department_names;
      })

      ->editColumn('position', function ($model) {
        $positions      = $model->required_course_positions;
        $position_names = "";
        if($positions)
        {
        foreach ($positions as $position) {
          $position_names .= isset($position->company_position['position_en']) ? $position->company_position['position_en'] :"" . "</br>";
        }
      }
        return  $position_names;
      })

      ->editColumn('project', function ($model) {
        $projects      = $model->required_course_projects;
        $project_names = "";
        if($projects)
        {
         
        foreach ($projects as $project) {
          $project_names .= isset($project->company_project['en_project']) ? $project->company_project['en_project'] :  "". "</br>";
        }
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

          onclick="showEditModal(this)"><i class="fa fa-fw fa-edit"></i></a>
          <a href="javascript:void(0);" class="act-sp" title="Delete" data-id="' . $model->id . '"  onclick="showConfirmModal(this)"><i class="fa fa-fw fa-trash"></i></a>';
      })
      ->rawColumns(['s#', 'course_en', 'validity', 'department', 'position', 'project', 'actions'])
      ->make(true);
  }

  public function saveMatrixStructure(Request $request)
  {
    // dd($request->matrix_id);
    $company_id = Session::get('company_id');

    if ($request->input('course_id') == "") {
      $obj  = new CompanyRequiredCourse();
      $obj->company_id  =  $company_id;
    } else {
      $obj = CompanyRequiredCourse::where('id', $request->input('course_id'))->first();
      $obj->updated_at = now();
      $obj->updated_by = Auth::user()->id;
    }
    $obj->en_course_name =  $request->input('en_course_name');
    $obj->ar_course_name =  $request->input('ar_course_name');
    $obj->validity       =  $request->input('validity');
    $obj->type           =  $request->input('course_type');
    $obj->save();
    $departmentArr =  $request->input('department');
    $positionArr =  $request->input('position');
    $projectArr =  $request->input('project');


    if ($obj->id) {
      $course_id = $obj->id;
      //inserting into relation table
      if ($request->input('course_id') == "") {
        if($departmentArr)
        {
        foreach ($departmentArr as $department) {
          $depObj  = new RequiredCourseDepartment();
          $depObj->course_id = $course_id;
          $depObj->department_id = $department;
          $depObj->status = 1;
          $depObj->created_by = $company_id;
          $depObj->created_at = now();
          $depObj->save();
        }
      }
      if($positionArr)
      {
        foreach ($positionArr as $position) {
          $depObj  = new RequiredCoursePosition();
          $depObj->course_id = $course_id;
          $depObj->position_id = $position;
          $depObj->status = 1;
          $depObj->created_by = $company_id;
          $depObj->created_at = now();
          $depObj->save();
        }
      }
      if($projectArr)
      {
        foreach ($projectArr as $project) {
          $depObj  = new RequiredCourseProject();
          $depObj->course_id = $course_id;
          $depObj->project_id = $project;
          $depObj->status = 1;
          $depObj->created_by = $company_id;
          $depObj->created_at = now();
          $depObj->save();
        }
      }

      } else { //editing relation table
        if ($departmentArr) {
          RequiredCourseDepartment::where('course_id',$course_id)->delete();
          foreach ($departmentArr as $department) {
            $depObj  = new RequiredCourseDepartment();
            $depObj->course_id = $course_id;
            $depObj->department_id = $department;
            $depObj->status = 1;
            $depObj->created_by = $company_id;
            $depObj->created_at = now();
            $depObj->save();
          }
        }
        if ($positionArr) {
          RequiredCoursePosition::where('course_id',$course_id)->delete();
          foreach ($positionArr as $position) {
            $depObj  = new RequiredCoursePosition();
            $depObj->course_id = $course_id;
            $depObj->position_id = $position;
            $depObj->status = 1;
            $depObj->created_by = $company_id;
            $depObj->created_at = now();
            $depObj->save();
          }
        }
        if ($projectArr) {
          RequiredCourseProject::where('course_id',$course_id)->delete();
          foreach ($projectArr as $project) {
            $depObj  = new RequiredCourseProject();
            $depObj->course_id = $course_id;
            $depObj->project_id = $project;
            $depObj->status = 1;
            $depObj->created_by = $company_id;
            $depObj->created_at = now();
            $depObj->save();
          }
        }
      }
    }
    if ($obj->id) {
      return response()->json(['status' => 'success'], 200);
    } else {
      return response()->json(['status' => 'error'], 422);
    }
  }

  public function deleteMatrixStructure(Request $request)
  {
    $obj = CompanyRequiredCourse::where('id', $request->input('course_id'))->first();
    $obj->delete();
    return 1;
  }

  /*TRAINING MATRIX */
  public function trainingMatrix(Request $request)
  {
    $type = $request->contactor ;
    // dd($type);
    $company_id  = Session::get('company_id');
    $userType = Auth::user()->user_type;
    $courses     = CompanyRequiredCourse::leftjoin('users', 'users.id', 'company_required_courses.company_id')
      // ->where('company_required_courses.company_id', $company_id)
      ->where(function ($q) use ($company_id, $userType,$type) {
        if ($userType == "company") {
          if($type != null)
          { 
          $q->where('company_required_courses.company_id', $type);

          }else
          {
            $q->where('company_required_courses.company_id', $company_id);

          }
          // $q->where('company_required_courses.company_id', $company_id);
            // ->orWhere('users.parent_company', $company_id);
        }
        if ($userType == "contractor") {
          $q->where('company_required_courses.company_id', $company_id);
        }
      })
      ->where('company_required_courses.status', 1)->get();
      $contactor= User::where([['parent_company', Auth::user()->id],['user_type','contractor']])->get();;

    return view('company.training-matrix')->with(['courses' => $courses,'type'=>$type,'contactor'=>$contactor]);
  }

  public function getMatrixData(Request $request)
  {
    $company_id = Session::get('company_id');
    $userType = Auth::user()->user_type;
    $type = $request->type;
  
    //$courselist  = CompanyRequiredCourse::where('company_id', $company_id)->get();
    //GETTING THE COURSE COLUMNS
    $data = CompanyRequiredCourse::select(
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
      ->leftjoin('users', 'users.id', 'company_required_courses.company_id')
      ->where('company_required_courses.status', 1)
      ->where('RD.status', 1)
      ->where('RP.status', 1)
      ->where('RJ.status', 1)
      // ->where('company_required_courses.company_id',$company_id)
      ->where(function ($q) use ($company_id, $userType,$type) {
        if ($userType == "company") {
          if($type != null)
          {
            // dd($type);
            $q->where('company_required_courses.company_id', $type);

          }
          else
          {
            $q->where('company_required_courses.company_id', $company_id);

          }
        }
        if ($userType == "contractor") {
          $q->where('company_required_courses.company_id', $company_id);
        }
      });
    //COLUMN FILTER IMPORTANT DONT REMOVE
    // if($request->department!=""){
    //   $data->whereIn('department_id', $request->department);
    // }

    // if($request->position!=""){
    //   $data->whereIn('position_id', $request->position);
    // }

    // if($request->project!=""){
    //   $data->whereIn('project_id', $request->project);
    // }

    $courselist = $data->groupBy('company_required_courses.id')->get();
    //GETTING THE ROWS
    $data = CompanyWorkforce::leftjoin('users as u', 'u.id', 'company_workforce.user_id')
      ->leftjoin('workforce_departments as cd', 'cd.user_id', 'company_workforce.user_id')
      ->leftjoin('workforce_positions as cp', 'cp.user_id', 'company_workforce.user_id')
      ->leftjoin('workforce_projects as cj', 'cj.user_id', 'company_workforce.user_id')
      // ->leftjoin('users as contactorUser','contactorUser.id','company_workforce.company_id')
    // ->leftjoin('users as contactorUser', 'contactorUser.id', 'company_workforce.company_id')

    ;



    if ($request->department != "") {
      $data->whereIn('department_id', $request->department);
    }

    if ($request->position != "") {
      $data->whereIn('position_id', $request->position);
    }

    if ($request->project != "") {
      $data->whereIn('project_id', $request->project);
    }

    $data = $data
      // ->where('company_workforce.company_id',$company_id)
      ->where(function ($q) use ($company_id, $userType,$type) {
        if ($userType == "company") {
          if($type != null)
          {
            // dd($type);
            $q->where('company_workforce.company_id', $type);

          }
          else
          {
            $q->where('company_workforce.company_id', $company_id);

          }
            // ->orWhere('u.parent_company', $company_id);
        }
        if ($userType == "contractor") {
          $q->where('company_workforce.company_id', $company_id);
        }
      })
      ->groupBy('u.id')
      ->orderBy('u.name', 'asc')
      ->get();

    $table =  Datatables::of($data)
      ->addIndexColumn()

      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> ';
      })

      ->editColumn('name', function ($model) {
        return  $model->name;
      })

      ->editColumn('work_id', function ($model) {
        return  $model->work_id;
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
      });

    $i = 1;
    foreach ($courselist as $course) {

      $colArr[$i] = 'nullcol_' . $i;

      $table->editColumn('nullcol_' . $i, function ($model) use ($course, $company_id,$type) {
        $today    = Carbon::now();
        $todayDateFormat = $today->format('Y-m-d');
        DB::enableQueryLog();
        $assignedCourse  = CompanyWorkforce::select(
          'company_workforce.*',
          'w.*',
          'company_workforce.user_id as userid',
          'rc.*',
          'w.id as index_id'
        )
          ->leftjoin('required_course_workforces as w', 'w.user_id', 'company_workforce.user_id')
          ->leftjoin('company_required_courses as rc', 'rc.company_id', 'company_workforce.company_id')
          ->groupBy('company_workforce.user_id')
          ->where('company_workforce.user_id', $model->user_id)
          ->where('w.course_id', $course->id)
          ->where( function ($q) use($type,$company_id)
          {
            if($type != null)
            {
          $q->where('company_workforce.company_id', $type);
            }
            else
            {
              $q ->where('company_workforce.company_id', $company_id);
            }
          })
         
          ->first();

        $label = "";
        $class = "";

        $departments      = $model->workforce_departments;
        $department_names = "";
        if($departments)
        {
        foreach ($departments as $department) {
          if(isset($department->workforce_department_data['en_department']))
          {
          $department_names .= $department->workforce_department_data['en_department'] . " ,";
          }
        }
      }

        $positions      = $model->workforce_positions;
        $position_names = "";
        if($positions)
        {
        foreach ($positions as $position) {
          if(isset($position->workforce_positions_data['position_en']))
          {
          $position_names .= $position->workforce_positions_data['position_en'] . " ,";
          }
        }
      }

        $projects      = $model->workforce_projects;
        $project_names = "";
        if($projects)
        {
          foreach ($projects as $project) {
          if(isset($project->workforce_projects_data['en_project']))
            {
          $project_names .= $project->workforce_projects_data['en_project'] . " ,";
            }
        }
      }

        if ($assignedCourse) {
          $expiry_date = $assignedCourse->expiry_date;
          // $issue_date  = $assignedCourse->issue_date;
          if ($expiry_date) {
            $interval = $today->diff($expiry_date);
            // if ($today->gte($expiry_date)) {
              if ($todayDateFormat >= $expiry_date ) {
             
              $class = "badgeDvred";
            } 
              elseif ($interval->days <= 90) {
                $class = "badgeDvyellow";
              } 
              // if ($interval->days >= 30) {
              //   $class = "badgeDvgreen";
              // } 
              else {
                $class = "badgeDvgreen";
              }
           
            
            $label = $assignedCourse->expiry_date;
          } else {
            $start_date = $assignedCourse->start_date;
            $label = "Assigned" ." " . "<a title=$model->name class='fa fa-user'></a>";
            if ($today->lt($start_date)) {
              $label = "Assigned : U/C";
            }
          }

          return  '<div class="m-1 badgeDv badge-primary ' . $class . '"
            data-id="' . $assignedCourse->index_id . '"
            data-course="' . $course->en_course_name . '"
            data-course-id="' . $course->id . '"
            data-validity="' . $course->validity . '"
            data-user="' . $model->firstname . ' ' . $model->lastname . '"
            data-user-id="' . $model->user_id . '"
            data-department="' . $department_names . '"
            data-position="' . $position_names . '"
            data-project="' . $project_names . '"
            data-issue-date="' . $assignedCourse->issue_date . '"
            data-expiry-date="' . $assignedCourse->expiry_date . '"
            data-start-date="' . $assignedCourse->start_date . '"
            data-course-type="' . $course->type . '"
            data-certificate="' . $assignedCourse->certificate . '"
            data-upload-status="' . $assignedCourse->upload_status . '"
            data-certificate-status="' . $assignedCourse->certificate_status . '"
             onclick="showEditModal(this)">' . $label . '</div>';
        } else {

          $cdepArr = array();
          $course_departments = $course->required_course_departments;
          if($course_departments)
          {
            foreach ($course_departments as $item) {
            array_push($cdepArr, $item->department_id);
          }
        }

          $udepArr = array();
          
          $user_departments   = $model->workforce_departments;
          if($user_departments)
          {
          foreach ($user_departments as $item) {
            array_push($udepArr, $item->department_id);
          }
        }

          if (!count(array_intersect($cdepArr, $udepArr))) {
            $label = 'N/A';
            $class = "badgeDvNa";
          } else {
            $label = 'Assign' . "<a title=$model->name class='fa fa-user'></a>";
            $class = "badgeDvAsg";
          }

          $button = '<div class="m-1 badgeDv badge-primary ' . $class . '"
            data-id=""
            data-course="' . $course->en_course_name . '"
            data-course-id="' . $course->id . '"
            data-validity="' . $course->validity . '"
            data-user="' . $model->firstname . ' ' . $model->lastname . '"
            data-user-id="' . $model->user_id . '"
            data-department="' . $department_names . '"
            data-position="' . $position_names . '"
            data-project="' . $project_names . '"
            data-course-type="' . $course->type . '"
            data-certificate=""
            data-upload-status="0"
            data-certificate-status="0"';
          if ($label != 'N/A') {
            $button .= 'onclick="showNewModal(this)"';
          }
          $button .= '>' . $label . '</div>';
          return $button;
        }
      });
      $i++;
    }

    $tableColumns = ['s#', 'name', 'work_id', 'department', 'position', 'project', 'nullcol_'];
    foreach ($colArr as $key => $val) {
      array_push($tableColumns, $val);
    }
    return $table->rawColumns($tableColumns)
      ->make(true);
  }

  public function assignRequiredCourse(Request $request)
  {
    // dd($request->all());
    // dd($request->all());  
    $company_id  = Session::get('company_id');
    $start = $request->input('start_date');
    // if ($start) {
      if ($request->input('index_id') == "") {
        $obj  = new RequiredCourseWorkforce();
        $obj->course_id =  $request->input('course_id');
        $obj->user_id =  $request->input('user_id');
      } else {
        $obj = RequiredCourseWorkforce::where('id', $request->input('index_id'))->first();
        $obj->updated_at = now();
        $obj->updated_by = $company_id;
      }
      $course_type = $request->input('course_type');

      if ($course_type == 1 | $course_type == 2) {  
        $issue_date  = $request->input('issue_date');
        $expiry_date = $request->input('expiry_date');
        if ($issue_date) {
          $obj->issue_date  = date('Y-m-d', strtotime($issue_date));
        }
        if ($expiry_date) {
          $obj->expiry_date = date('Y-m-d', strtotime($expiry_date));
        }

        $removeImg   = $request->input('removeImg');
        if ($removeImg == 1) {
          $obj->certificate    = "";
        }
        $certificate = $request->file('certificate');
        if ($certificate) {
          $certificate_name  = uniqid() . '.' . $certificate->extension();
          $obj->certificate    = $certificate_name;
          $obj->certificate_status  = 1;
          $obj->upload_status  = 1;
          $certificate->move(public_path('uploads/certificates'), $certificate_name);
        }
      } else {
        $aprove = $request->input('approve');
        if ($aprove == 'on') {
          $obj->certificate_status  = 1;
        }
      }

      $obj->start_date = date('Y-m-d', strtotime($start));

      $obj->save();
    // }
    // dd($obj);
    if ($obj->id) {
      return response()->json(['status' => 'success'], 200);
    } else {
      return response()->json(['status' => 'error'], 422);
    }
  }
}
