<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CompanyWorkforce;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;

class RequiredCourseController extends Controller
{
    public function index(){
    	
    }
    
	public function bulkAssignCourses(){
    	return view('company.bulk-assign-courses');
    }




}
