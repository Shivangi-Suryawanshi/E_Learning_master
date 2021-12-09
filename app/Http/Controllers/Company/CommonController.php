<?php

namespace App\Http\Controllers\Company;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use App\User;
use App\Company;
use App\RequiredCourseDepartment;
use App\RequiredCoursePosition;
use App\RequiredCourseProject;
use App\CompanyWorkforce;
use App\CompanyPosition;
use App\CompanyDepartment;
use App\CompanyProject;
use App\CompanyLanguage;
use App\CompanyIndustry;
use App\CompanyOccupation;
use App\CompanyRequiredCourse;
use App\Course;
use App\Skill;
use App\Occupation;
use App\Industry;
use App\Section;
use App\WorkforcePosition;
use App\WorkforceProject;
use App\WorkforceDepartment;
use Illuminate\Support\Facades\DB;
use Whoops\Run;

class CommonController extends Controller
{
    //POSITIONS
    public function getPositionsSelected(Request $request)
    {

        $company_id = Session::get('company_id');
        $whose = $request->whose;
        $whose_id = $request->id;
        $userType = Auth::user()->user_type;

        $completeArr  = CompanyPosition::select('id', 'position_en', 'position_ar')
            ->where(function ($q) use ($userType, $company_id) {
                if ($userType == "company") {
                    $q->where('company_id', $company_id);
                }
                if ($userType == "contractor") {
                    $q->where('company_id', Auth::user()->parent_company);
                }
            })->get();

        if ($whose == 'course') {
            $selectedArr  = RequiredCoursePosition::select('course_id', 'position_id')
                ->where('course_id', $whose_id)->where('status', 1)->get();
        }

        if ($whose == 'user') {
            $selectedArr  = WorkforcePosition::select('user_id', 'position_id')
                ->where('user_id', $whose_id)->where('status', 1)->get();
        }

        if ($whose != 'all') {
            $selectedOptions = array();
            $i = 0;
            foreach ($selectedArr as $optn) {
                $selectedOptions[$i] =  $optn->position_id;
                $i++;
            }
        }

        $j = 0;
        $optn_values = array();
        $optn_selects = array();
        $optn_text = array();
        foreach ($completeArr as $option) {
            $selected = "";
            if ($whose != 'all') {
                if (in_array($option->id, $selectedOptions)) {
                    $selected = "selected";
                }
            }
            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            $optn_text[$j]    = $option->position_en;
            $j++;
        }

        return response()->json([
            'optn_values' => $optn_values,
            'optn_selects' => $optn_selects,
            'optn_text' => $optn_text
        ]);
    }


    //DEPARTMENTS
    public function getDepartmentsSelected(Request $request)
    {

        $company_id = Session::get('company_id');
        $userType = Auth::user()->user_type;

        $whose = $request->whose;
        $whose_id = $request->id;

        $completeArr  = CompanyDepartment::select('id', 'en_department', 'ar_department')
            ->where(function ($q) use ($userType, $company_id) {
                if ($userType == "company") {
                    $q->where('company_id', $company_id);
                }
                if ($userType == "contractor") {
                    $q->where('company_id', Auth::user()->parent_company);
                }
            })
            ->get();

        if ($whose == 'course') {
            $selectedArr  = RequiredCourseDepartment::select('course_id', 'department_id')
                ->where('course_id', $whose_id)->where('status', 1)->get();
        }

        if ($whose == 'user') {
            $selectedArr  = WorkforceDepartment::select('user_id', 'department_id')
                ->where('user_id', $whose_id)->where('status', 1)->get();
        }

        if ($whose != 'all') {
            $selectedOptions = array();
            $i = 0;
            foreach ($selectedArr as $optn) {
                $selectedOptions[$i] =  $optn->department_id;
                $i++;
            }
        }

        $j = 0;
        $optn_values = array();
        $optn_selects = array();
        $optn_text = array();
        foreach ($completeArr as $option) {
            $selected = "";
            if ($whose != 'all') {
                if (in_array($option->id, $selectedOptions)) {
                    $selected = "selected";
                }
            }
            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            $optn_text[$j]    = $option->en_department;
            $j++;
        }
        return response()->json([
            'optn_values' => $optn_values,
            'optn_selects' => $optn_selects,
            'optn_text' => $optn_text
        ]);
    }

    //PROJECTS
    public function getProjectsSelected(Request $request)
    {
        $company_id = Session::get('company_id');
        $userType = Auth::user()->user_type;

        $whose = $request->whose;
        $whose_id = $request->id;

        $completeArr  = CompanyProject::select('id', 'en_project', 'ar_project')
            ->where(function ($q) use ($userType, $company_id) {
                if ($userType == "company") {
                    $q->where('company_id', $company_id);
                }
                if ($userType == "contractor") {
                    $q->where('company_id', Auth::user()->parent_company);
                }
            })
            ->get();

        if ($whose == 'course') {
            $selectedArr  = RequiredCourseProject::select('course_id', 'project_id')
                ->where('course_id', $whose_id)->where('status', 1)->get();
        }

        if ($whose == 'user') {
            $selectedArr  = WorkforceProject::select('user_id', 'project_id')
                ->where('user_id', $whose_id)->where('status', 1)->get();
        }

        if ($whose != 'all') {
            $selectedOptions = array();
            $i = 0;
            foreach ($selectedArr as $optn) {
                $selectedOptions[$i] =  $optn->project_id;
                $i++;
            }
        }

        $j = 0;
        $optn_values = array();
        $optn_selects = array();
        $optn_text = array();
        foreach ($completeArr as $option) {
            $selected = "";
            if ($whose != 'all') {
                if (in_array($option->id, $selectedOptions)) {
                    $selected = "selected";
                }
            }
            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            $optn_text[$j]    = $option->en_project;
            $j++;
        }
        return response()->json([
            'optn_values' => $optn_values,
            'optn_selects' => $optn_selects,
            'optn_text' => $optn_text
        ]);
    }

    //COURSES
    public function getCoursesSelected(Request $request)
    {
        $company_id = Session::get('company_id');
        $whose      = $request->whose;
        $whose_id   = $request->id;
        $type       = $request->type;
        $selection  = $request->selection;

        $completeArr  = CompanyRequiredCourse::select('id', 'en_course_name', 'ar_course_name');
        if ($type != "") {
            $completeArr->where('type', $type);
            $completeArr->where('purchase_course_id', 0);
        }

        $completeArr  = $completeArr->where('company_id', $company_id)
            ->where('status', 1)->get();
        if ($whose == 'department') {

            $selectedArr  = RequiredCourseDepartment::select('course_id', 'department_id')
                ->where('department_id', $whose_id)->where('status', 1)->get();
        }

        if ($whose != 'all') {
            $selectedOptions = array();
            $i = 0;
            foreach ($selectedArr as $optn) {
                $selectedOptions[$i] =  $optn->course_id;
                $i++;
            }
        }

        $j = 0;
        $optn_values = array();
        $optn_selects = array();
        $optn_text = array();
        $optn_values = array();
        foreach ($completeArr as $option) {
            $selected = "";
            if ($whose != 'all') {
                if (in_array($option->id, $selectedOptions)) {
                    $selected = "selected";
                }
            }
            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            $optn_text[$j]    = $option->en_course_name;
            $j++;
        }
        if ($optn_values) {
            return response()->json([
                'optn_values' => $optn_values,
                'optn_selects' => $optn_selects,
                'optn_text' => $optn_text
            ]);
        } else {
            return response()->json(['optn_values' => $optn_values]);
        }
    }

    //EMPLOYEES
    public function getEmployees(Request $request)
    {
        $company_id  = Session::get('company_id');

        $departments = $request->departments;
        $positions   = $request->positions;
        $projects    = $request->projects;

        $completeArr = CompanyWorkforce::leftjoin('users as u', 'u.id', 'company_workforce.user_id')
            // ->leftjoin('Workforce_departments as cd','cd.id','company_workforce.user_id')
            // ->leftjoin('Workforce_positions as cp','cp.id','company_workforce.user_id')
            // ->leftjoin('Workforce_projects as cj','cj.id','company_workforce.user_id')
            ->where('company_workforce.company_id', $company_id)
            // ->where( function ($q) use($departments)
            // {
            //     // if($departments != null)
            //     // {
            //     //     $q->where('company_departments');
            //     // }
            // })

            ->orderBy('u.name', 'asc')
            ->get();

        $j = 0;
        foreach ($completeArr as $option) {
            $selected = "";

            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            if ($option->name != null) {
                $optn_text[$j]    = $option->name;
            }

            $j++;
        }
        return response()->json([
            'optn_values' => $optn_values,
            'optn_selects' => $optn_selects,
            'optn_text' => $optn_text
        ]);
    }



    //SKILLS
    public function getSkillsSelected(Request $request)
    {
        //$company_id = Session::get('company_id');
        $whose = $request->whose;
        $whose_id = $request->id;

        $completeArr  = Skill::select('id', 'en_skill', 'ar_skill')->get();

        if ($whose == 'course') {
            // $selectedArr  = RequiredCoursePosition::select('course_id','position_id')
            //                 ->where('course_id',$whose_id)->where('status',1)->get();
        }

        if ($whose != 'all') {
            $selectedOptions = array();
            $i = 0;
            foreach ($selectedArr as $optn) {
                $selectedOptions[$i] =  $optn->position_id;
                $i++;
            }
        }

        $j = 0;
        foreach ($completeArr as $option) {
            $selected = "";
            if ($whose != 'all') {
                if (in_array($option->id, $selectedOptions)) {
                    $selected = "selected";
                }
            }
            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            $optn_text[$j]    = $option->en_skill;
            $j++;
        }
        return response()->json([
            'optn_values' => $optn_values,
            'optn_selects' => $optn_selects,
            'optn_text' => $optn_text
        ]);
    }


    public function getOccupationsSelected(Request $request)
    {
        //$company_id = Session::get('company_id');
        $whose = $request->whose;
        $whose_id = $request->id;

        $completeArr  = Occupation::select('id', 'en_occupation', 'ar_occupation')->get();

        if ($whose == 'course') {
            // $selectedArr  = RequiredCoursePosition::select('course_id','position_id')
            //                 ->where('course_id',$whose_id)->where('status',1)->get();
        }

        if ($whose != 'all') {
            $selectedOptions = array();
            $i = 0;
            foreach ($selectedArr as $optn) {
                $selectedOptions[$i] =  $optn->position_id;
                $i++;
            }
        }

        $j = 0;
        foreach ($completeArr as $option) {
            $selected = "";
            if ($whose != 'all') {
                if (in_array($option->id, $selectedOptions)) {
                    $selected = "selected";
                }
            }
            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            $optn_text[$j]    = $option->en_occupation;
            $j++;
        }
        return response()->json([
            'optn_values' => $optn_values,
            'optn_selects' => $optn_selects,
            'optn_text' => $optn_text
        ]);
    }

    public function getIndustriesSelected(Request $request)
    {
        //$company_id = Session::get('company_id');
        $whose = $request->whose;
        $whose_id = $request->id;

        $completeArr  = Industry::select('id', 'en_name', 'ar_name')->get();

        if ($whose == 'course') {
            // $selectedArr  = RequiredCoursePosition::select('course_id','position_id')
            //                 ->where('course_id',$whose_id)->where('status',1)->get();
        }

        if ($whose != 'all') {
            $selectedOptions = array();
            $i = 0;
            foreach ($selectedArr as $optn) {
                $selectedOptions[$i] =  $optn->position_id;
                $i++;
            }
        }

        $j = 0;
        foreach ($completeArr as $option) {
            $selected = "";
            if ($whose != 'all') {
                if (in_array($option->id, $selectedOptions)) {
                    $selected = "selected";
                }
            }
            $optn_values[$j]  = $option->id;
            $optn_selects[$j] = $selected;
            $optn_text[$j]    = $option->en_name;
            $j++;
        }
        return response()->json([
            'optn_values' => $optn_values,
            'optn_selects' => $optn_selects,
            'optn_text' => $optn_text
        ]);
    }


    public function getCategory()
    {

        $category = Category::select('id', 'category_name')->get();
        $categoryId = [];
        $categoryName = [];
        $optn_selects = [];
        if ($category) {
            foreach ($category as $categoryList) {
                $categoryId[] = $categoryList->id;
                $categoryName[] = $categoryList->category_name;
            }
        }
        return response()->json([
            'optn_values' => $categoryId,
            'optn_selects' => $optn_selects,
            'optn_text' => $categoryName
        ]);
    }

    public function getCategoryCourse(Request $request)
    {
        $id = $request->id ;
        $course = Course::where('category_id',$id)->get();
        $optn_values = [];
        $optn_selects = [];
        $optn_text = [];
        if ($course) {
            foreach ($course as $courses) {
                $optn_text []= $courses->title ;
                $optn_values [] =$courses->id ;
            }
        }
        if ($optn_values) {
            return response()->json([
                'optn_values' => $optn_values,
                'optn_selects' => $optn_selects,
                'optn_text' => $optn_text
            ]);
        } else {
            return response()->json(['optn_values' => $optn_values]);
        }
    }
    public function getCategoryCourseType(Request $request)
    {
        $id =$request->id ;
        $section = Section::where('course_id',$id)
        ->select(
            'id','section_name',DB::raw('(CASE 

            WHEN section_type= "1" THEN "Face to Face" 

            WHEN section_type = "2" THEN "Recoreder" 
            WHEN section_type = "3" THEN "Live" 

            
            END) AS section'))
        
        ->groupBy('course_id')->get();

        $optn_values = [];
        $optn_selects = [];
        $optn_text = [];
        if ($section) {
            foreach ($section as $sections) {
                // dd($sections);
                $optn_text []= $sections->section ;
                $optn_values [] =$sections->id ;
            }
        }

        if ($optn_values) {
            return response()->json([
                'optn_values' => $optn_values,
                'optn_selects' => $optn_selects,
                'optn_text' => $optn_text
            ]);
        } else {
            return response()->json(['optn_values' => $optn_values]);
        }
    }
}
