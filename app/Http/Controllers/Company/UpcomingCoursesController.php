<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Session;
use DB;
use App\User;
use App\CompanyWorkforce;
use App\CompanyRequiredCourse;
use App\RequiredCourseWorkforce;
use App\CompanyDepartment;
use App\RequiredCourseDepartment;
use DateTime;
use Carbon\Carbon;

class UpcomingCoursesController extends Controller
{
   
	  public function upcomingCourses(){
    	return view('company.upcoming-courses');
    }

    public function getUpcomingCoursesData(Request $request){
      $company_id = Session::get('company_id');
      $data = CompanyWorkforce::leftjoin('users as u','u.id','company_workforce.user_id')
        ->leftjoin('workforce_departments as cd','cd.user_id','company_workforce.user_id')
        ->leftjoin('workforce_positions as cp','cp.user_id','company_workforce.user_id')
        ->leftjoin('workforce_projects as cj','cj.user_id','company_workforce.user_id')
        ->leftjoin('required_course_workforces as CW','CW.user_id','company_workforce.user_id')
        ->leftjoin('company_required_courses as RC','RC.id','CW.course_id');

        if($request->employee!=""){
            $data->whereIn('company_workforce.user_id', $request->employee);
        }
        if($request->department!=""){
            $data->whereIn('department_id', $request->department);
        }
        if($request->position!=""){
            $data->whereIn('position_id', $request->position);
        }
        if($request->project!=""){
            $data->whereIn('project_id', $request->project);
        }
        if($request->course!=""){
            $data->whereIn('CW.course_id', $request->course);
        }
        if($request->type!=""){
            $data->where('RC.type', $request->type);
        }

        $data = $data->where('RC.company_id',$company_id)
                ->orderBy('u.name','asc')
                ->groupBy('CW.id')
                ->get();

      return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> '; })
    
      ->editColumn('name', function ($model) {
        return  $model->name; })

      ->editColumn('emp_no', function ($model) {
          return $model->work_id; })
 
      ->editColumn('departments', function ($model) {
        $departments      = $model->workforce_departments;
        $department_names = "";
        if($departments)
        {
        foreach($departments as $department){
          $department_names .= isset($department->workforce_department_data['en_department']) ? $department->workforce_department_data['en_department'] : ""."</br>";
        }
      }
        return  $department_names; })

      ->editColumn('positions', function ($model) {
        $positions      = $model->workforce_positions;
        $position_names = "";
        if($positions)
        {
        foreach($positions as $position){
          $position_names .= isset($position->workforce_positions_data['position_en']) ? $position->workforce_positions_data['position_en'] : ""."</br>";
        }
      }
        return  $position_names; })

      ->editColumn('projects', function ($model) {
        $projects      = $model->workforce_projects;
        $project_names = "";
        if($projects)
        {
        foreach($projects as $project){
          $project_names .= isset($project->workforce_projects_data['en_project']) ? $project->workforce_projects_data['en_project'] : ""."</br>";
        }
      }
        return  $project_names; })
  
      ->editColumn('course', function ($model) {
         return  $model->en_course_name; })
      
      ->editColumn('type', function ($model) {
          $type = $model->type;
          if($type == 1){
            $type_label = "Internal";
          }else{
            $type_label = "External";
          }
          return  $type_label; })
        
      ->editColumn('start_date', function ($model) {
            return  $model->start_date; })
          
      ->rawColumns(['s#','name','emp_no','departments','positions','projects','course','type','start_date'])
      ->make(true);
    }


}
