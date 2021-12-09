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
use App\CompanyPosition;
use App\CompanyProject;
use App\CompanyPurchaseTemporary;
use App\CoursePurchase;
use App\RequiredCourseDepartment;
use PDF;
use DateTime;
use Carbon\Carbon;

class ProgressGraphController extends Controller
{
    public function index(){

    }

	  public function progressTable(){
    	return view('company.progress-report');
    }

    public function getProgressData(Request $request){
      // dd( date('Y-m-d', strtotime("+90 days")));
      $ninteenDay = date('Y-m-d', strtotime("+90 days"));
      $company_id = Session::get('company_id');
      $today    = Carbon::now();
      $todayDateFormat = $today->format('Y-m-d');
      DB::enableQueryLog();

      $data = CompanyWorkforce::select('company_workforce.user_id','u.name')
        ->leftjoin('users as u','u.id','company_workforce.user_id')
        ->where('company_workforce.company_id',$company_id)
        ->orderBy('u.name','asc')->get();

        //print_r($data[0]->assigned_courses);exit;
      return Datatables::of($data)
      ->addIndexColumn()
      ->editColumn('s#', function ($model) {
        return '<span class="si_no"></span> '; })

      ->editColumn('name', function ($model) {
        return  $model->name; })

      ->editColumn('department_course', function ($model) {
          $departments = $model->workforce_departments;
          $total_count = 0; $dcount=0;
          foreach($departments as $dept){
            $dcount   = $dept->total_courses()->count();
            $total_count   += $dcount;
          }
          return $total_count;
        })

      ->editColumn('assigned_course', function ($model) {
        $assigned_count = $model->assigned_courses()->count();
        return  $assigned_count; })

        ->editColumn('expired_course', function ($model) use($todayDateFormat) {
          $expirdCount = $model->assigned_courses()->where('expiry_date', '<=' , $todayDateFormat)->count();
          return  $expirdCount; })

          ->editColumn('close_to_expire', function ($model) use($todayDateFormat,$today , $ninteenDay) {
            // $requiredCourseExpiredDate = RequiredCourseWorkforce::where('user_id',$model->user_id)->first();

            // $interval = $today->diff($requiredCourseExpiredDate);
            // if($todayDateFormat >= $requiredCourseExpiredDate) 
            // {

            // }
            $closedExpirdCount = $model->assigned_courses()
            ->whereBetween('expiry_date',[ $today ,$ninteenDay ])->get()->count();
            return  $closedExpirdCount;
           })

      ->editColumn('completion_percentage', function ($model) {
        $sum = 0;
        $assigned_count = 0;
        foreach($model->assigned_courses as $course){
          if($course['upload_status'] == 1){
            $sum++;
          }
          $assigned_count++;
        }
        if($sum!=0){
            $percent = $sum/$assigned_count*100;
        }else{
          $percent = 0;
        }
        return  $percent."%"; })

      ->rawColumns(['s#','name','department_course','assigned_course','expired_course','close_to_expire','completion_percentage'])
      ->make(true);
    }

	  public function graphs(){
    	return view('company.graphs');
    }

    public function getGraph1Data(Request $request){
      $company_id = Session::get('company_id');
      
      //$category = 'CompanyDepartment';

      $data = CompanyDepartment::select('company_departments.id','company_departments.en_department'
      ,'company_departments.ar_department')
        ->where('company_departments.status',1)
        ->where('company_departments.company_id',$company_id)
        ->orderBy('company_departments.en_department','asc')->get();

      $arrChart = array();
      $i = 0;

      foreach($data as $item){
        $total_count   = 0;
        $expired_count = 0;
        $valid_count   = 0;

        $arrChart[$i]['category'] = $item->en_department;
        $courses = $item->total_courses;
// dd($item->total_courses);
          foreach($courses as $course){
            // dd($course);
            // dd($course->expired_courses);
            $expired = $course->expired_courses;
            $valid = $course->valid_courses;
            if($expired){
            //  dd($expired);
              $expired_count = $expired->count();
            }
            if($valid)
            {
              $valid_count = $valid->count();
            }
            
            $total_count++;
          }
          $arrChart[$i]['total']   = $total_count;
          $arrChart[$i]['expired'] = $expired_count;
          $arrChart[$i]['valid']   = $valid_count;
          $i++;
      }

      return $arrChart;
    }

    public function getGraph2Data(Request $request){
      $company_id = Session::get('company_id');
      //DB::enableQueryLog();
      $data = CompanyRequiredCourse::select('expiry_date')
              ->leftjoin('required_course_workforces as W','W.course_id','company_required_courses.id')
              ->where('company_required_courses.company_id',$company_id)
              ->where('W.certificate_status','!=',2)
              ->where('W.status',1)
              ->where('company_required_courses.status',1)
              ->get();

      $total = count($data);
      $expired_count = 0;
      $about_expiry  = 0;
      $valid_count   = 0;
      $today    = Carbon::now();
      $arrChart = array();
      $i = 0;

      foreach($data as $date){
          $interval = $today->diff($date->expiry_date);
          if($interval->days>=30){
            $valid_count++;
          }elseif($interval->days<=0){
            $expired_count++;
          }else{
            $about_expiry++;
          }
      }
      $valid_percent   = 0;
      $expired_percent = 0;
      $about_expiry_percent = 0;

      //find %
      if($total!=0){
        $valid_percent   = $valid_count/$total*100;
        $expired_percent = $expired_count/$total*100;
        $about_expiry_percent = $about_expiry/$total*100;
      }

      $arrChart[0]['category'] = 'Valid';
      $arrChart[0]['percent']  = $valid_percent;

      $arrChart[1]['category'] = 'Expired';
      $arrChart[1]['percent']  = $expired_percent;

      $arrChart[2]['category'] = 'Close to expire';
      $arrChart[2]['percent']  = $about_expiry_percent;

      return $arrChart;
    }

    public function getGraph3Data(Request $request){
      $company_id = Session::get('company_id');
      $data = CompanyWorkforce::select('company_workforce.user_id','u.name')
        ->leftjoin('users as u','u.id','company_workforce.user_id')
        ->where('company_workforce.company_id',$company_id)
        ->orderBy('u.name','asc')->get();

      $arrChart = array();
      $i = 0;
      foreach($data as $item){
        $assigned_count = $item->assigned_courses()->count();
        $arrChart[$i]['name']    =  $item->name;
        $arrChart[$i]['courses'] =  $assigned_count;
        $arrChart[$i]['color']   =  "#4775d1";
        $arrChart[$i]['bullet']  =  env('ASSET_URL')."/users/assets/avatars/user-placeholder.png";
        $i++;
      }
      return $arrChart;
    }

    public function getGraph4Data($category,$search_id){
      $company_id = Session::get('company_id');
      $arrChart   = array();
      $i = 0;
      $total = 0;
      $expired_count = 0;
      $about_expiry  = 0;
      $valid_count   = 0;

      if($category==1){ //department
        $data = RequiredCourseWorkforce::select('required_course_workforces.expiry_date')
                ->leftjoin('workforce_departments as WD','WD.user_id','required_course_workforces.user_id')
                ->where('WD.department_id',$search_id)
                ->where('WD.status',1)
                ->where('required_course_workforces.status',1)->get();
      }

      if($category==4){ //courses
        $data = RequiredCourseWorkforce::select('required_course_workforces.expiry_date')
                ->where('course_id',$search_id)
                ->where('status',1)->get();
      }

      $today    = Carbon::now();
      foreach($data as $date){
        if($today->gte($date->expiry_date)){
          $expired_count++;
        }else{
          $interval = $today->diff($date->expiry_date);
          if($interval->days>=30){
            $valid_count++;
          }else{
            $about_expiry++;
          }
        }
      }

      $arrChart[0]['type']    =  'Valid';
      $arrChart[0]['certificates']  =  $valid_count;
      $arrChart[0]['color']   =  "#59b300";

      $arrChart[1]['type']    =  'About to Expire';
      $arrChart[1]['certificates']  =  $about_expiry;
      $arrChart[1]['color']   =  "#ffc34d";

      $arrChart[2]['type']    =  'Expired';
      $arrChart[2]['certificates']  =  $expired_count;
      $arrChart[2]['color']   =  "#ff6666";
      return $arrChart;

    }
//Graphs of First Set
public function getGraph02Data(Request $request){
  
  $company_id = Session::get('company_id');
  $arrChart   = array();
  $today = Carbon::now();
  $todayDateFormat = $today->format('Y-m-d');
  $i = 0;
  $total = 0;
  $courses = CompanyRequiredCourse::where('company_id',$company_id)->get();

  foreach($courses as $course){
    $expired_count = 0;
    $data = RequiredCourseWorkforce::select('required_course_workforces.expiry_date')
            ->where('required_course_workforces.status',1)
            ->where('required_course_workforces.course_id',$course->id)
            ->where('required_course_workforces.expiry_date', '<=' , $todayDateFormat)->count();
    
    // foreach($data as $date){
    //   if($today->gte($date->expiry_date)){
    //      $expired_count++;
        
    //   }
    // }
   
    $arrChart[$i]['count'] = $data;
    $arrChart[$i]['course']  = $course->en_course_name;
    $i++;
  }
  // dd($arrChart);
  return $arrChart;
}


public function getGraph03Data(Request $request){
  $company_id = Session::get('company_id');
  $arrChart   = array();
  $i = 0;
  $total = 0;
  $projects = CompanyProject::where('company_id',$company_id)->get();

  foreach($projects as $project){
    $expired_count = 0;
    $data = RequiredCourseWorkforce::select('required_course_workforces.expiry_date')
            ->leftjoin('workforce_projects as WD','WD.user_id','required_course_workforces.user_id')
            ->where('WD.project_id',$project->id)
            ->where('WD.status',1)
            ->where('required_course_workforces.status',1)->get();
    $today    = Carbon::now();
    foreach($data as $date){
      if($today->gte($date->expiry_date)){
         $expired_count++;
      }
    }
    $arrChart[$i]['count'] = $expired_count;
    $arrChart[$i]['project']  = $project->en_project;
    $i++;
  }
  return $arrChart;
}

public function dowloadExpiredTotalCerrtificate()
{
  return view('company.download-graph.expiredTotalCerit');
//   $pdf = PDF::loadView('company.download-graph.expiredTotalCerit');
//   $pdf->setOptions(['enable-javascript', true]);
//         $pdf->setOptions(['javascript-delay', 5000]);
//         $pdf->setOptions(['enable-smart-shrinking', true]);
//         $pdf->setOptions(['no-stop-slow-scripts', true]);
// return $pdf->download('expiredTotalCerit.pdf');
}

public function dowloadExpiredCerrtificate()
{
  return view('company.download-graph.dowloadExpiredCerrtificate');

}

public function dowloadExpiredCerrtificateProject()
{
  return view('company.download-graph.dowloadExpiredCerrtificateProject');

}

public function downloadCostSpend()
{
  return view('company.download-graph.downloadCostSpend');

}

public function courseDepartment()
{
  return view('company.download-graph.courseDepartment');

}

public function certificateStatus()
{
  return view('company.download-graph.certificateStatus');

}

public function getGraph04Data1()
{

  $project = CompanyProject::where('company_id',Auth::user()->id)->get();
  $projectName = 0;
  $i =0 ;
  if ($project)
  {
    foreach($project as $key => $projectList)
    {
      $amount = CoursePurchase::
       join('company_required_courses','company_required_courses.id','course_purchases.course_id')
      ->join('required_course_projects','required_course_projects.course_id','course_purchases.course_id')
      ->where('required_course_projects.project_id',$projectList->id)
      ->sum('course_purchases.total_price');

      $arrChart[$i]['country'] = $projectList->en_project;
      $arrChart[$i]['visits']  = $amount;
      $i++;
    }
   
  }
 

return $arrChart;
}

public function getGraph04Data2()
{

  $project = CompanyDepartment::where('company_id',Auth::user()->id)->get();
  $companyCourse = CompanyRequiredCourse::where('company_id',Auth::user()->id)->get();
  $amounts = 0 ;
  $i =0 ;
  if ($project)
  {
    foreach($project as $key => $projectList)
    {
     
      $amount = CoursePurchase::
       join('company_required_courses','company_required_courses.id','course_purchases.course_id')
      ->join('required_course_departments','required_course_departments.course_id','course_purchases.course_id')
      ->where('required_course_departments.department_id',$projectList->id)
      ->sum('course_purchases.total_price');
      $arrChart[$i]['country'] = $projectList->en_department;
      $arrChart[$i]['visits']  =  $amount;
      $i++;
    }
   
  }
return $arrChart;
}

public function getGraph04Data3()
{

  $project = CompanyPosition::where('company_id',Auth::user()->id)->get();
  $projectName = 0;
  $i =0 ;
  if ($project)
  {
    foreach($project as $key => $projectList)
    {

      $amount = CoursePurchase::
       join('company_required_courses','company_required_courses.id','course_purchases.course_id')
      ->join('required_course_positions','required_course_positions.course_id','course_purchases.course_id')
      ->where('required_course_positions.position_id',$projectList->id)
      ->sum('course_purchases.total_price');

      $arrChart[$i]['country'] = $projectList->position_en;
      $arrChart[$i]['visits']  = $amount;
      $i++;
    }
   
  }
return $arrChart;
}

}
