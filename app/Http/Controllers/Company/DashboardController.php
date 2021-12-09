<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller
{

    public function index(){
    	if(session()->has('language')){
           $value = Session::get('language');
        }
        return $value;
    }

    public function getComplianceGraphData(Request $request){
        $company_id = Session::get('company_id');

        $data  = CompanyRequiredCourse::leftjoin('required_course_workforces as CW','CW.course_id','company_required_courses.id')
                 ->where('company_id', $company_id)
                 ->where('company_required_courses.status',1)->get();


        $arrChart = array();
        $i = 0;

        foreach($data as $item){
          $total_count    = 0;
          $expired_count  = 0;
          $expiring_count = 0;
          $valid_count    = 0;
          $arrChart[$i]['valid']     = $valid_count;
          $arrChart[$i]['expired']   = $total_count;
          $arrChart[$i]['expiring']  = $expired_count;
          $i++;
        }

        return $arrChart;
      }

}
