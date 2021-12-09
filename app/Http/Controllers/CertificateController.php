<?php

namespace App\Http\Controllers;

use App\Attempt;
use App\CertificateUpload;
use App\CompanyWorkforce;
use App\Complete;
use App\Course;
use App\Mail\UserRegistrationMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class CertificateController extends Controller
{


    public function index()
    {
        $title = __t('company_request');
        // $completeCourse = Course::get();

        $completeCourse = Course::join('completes', 'completes.completed_course_id', 'courses.id')
            ->select(
                'completes.id as id',
                'completes.completed_course_id as completed_course_id',
                'courses.id as id',
                'courses.title as title',
                'completes.user_id as user_id'
            )->whereNull('course_id')
            ->where( function ($q) 
            {
                if(Auth::user()->user_type == "student")
                {
                    $q->where('completes.user_id',Auth::user()->id);
                }else
                {
                    $q->where('courses.user_id',Auth::user()->id);
                }
            })

            ->groupBy('courses.id')->get();

        return view(theme('dashboard.certificate.index'), compact('title', 'completeCourse'));
    }

    public function uploadCertificate(Request $request, $id)
    {
        $title = __t('certificate Upload');
        $course = Course::find($id);
        if (empty($course)) {
            abort(404);
        }
        $completeCourse = Complete::where('completed_course_id', $id)->get();

        return view(theme('dashboard.certificate.upload'), compact('title', 'completeCourse', 'course'));
    }

    public function uploadCertificateCreate(Request $request)
    {
        // dd($request->all());
        $file = $request->file;
        if (empty($file)) {
            return back()->with('error', 'certification required');
        }
        $userId = $request->user_id;

        $checkUserAdminIsCompany  = CompanyWorkforce::
            join('users','users.id','company_workforce.company_id')
            ->where('company_workforce.user_id',$userId)->first(); 
        $completeCourseId = $request->completed_course_id;

        $certi = new CertificateUpload();
        $certi->user_id = $userId;
        if($checkUserAdminIsCompany)
        {
            if($checkUserAdminIsCompany->user_type == "company")
            {
                $certi->status =0 ;

            }
        }
        $certi->course_id = $completeCourseId;
        if ($request->hasFile('file')) {
            $certi->certificate = ImageUploadWithPath($file, 'certificate');
        }
        $certi->save();
        $user = User::find($userId);
        $course = Course::find($completeCourseId);
        $userzz['name'] = $user->name ;
        $userzz['course'] = $course->title ;
        $userzz['email'] = $user->email ;
   
        Mail::to($userzz['email'])->queue(new UserRegistrationMail('certificate-upload', $userzz));

        return back()->with('success', 'You have successfull upload certificate');
    }


    public function certificateView()
    {
        return view('company.certificate-view');
    }

    public function getCertifiedCourse()
    {

        $data = CompanyWorkforce::join('certificate_uploads', 'certificate_uploads.user_id', 'company_workforce.user_id')
            ->join('courses', 'courses.id', 'certificate_uploads.course_id')
            ->where('company_workforce.company_id', Auth::user()->id)
            ->select(
                'company_workforce.user_id as user_id',
                'courses.title as title',
                'certificate_uploads.created_at as created_at',
                'certificate_uploads.certificate as certificate',
                'certificate_uploads.id as certificate_upload_id',
                'certificate_uploads.status as certificate_upload_status'
                
            )->get();

        return DataTables::of($data)

            ->addIndexColumn()
            ->editColumn('s#', function ($model) {
                return '<span class="si_no"></span> ';
            })
            ->editColumn('user', function ($model) {
                if ($model->workforceUser) {
                    return $model->workforceUser->name;
                }
                return  "";
            })

            ->editColumn('course', function ($model) {
                return $model->title ;
            })

            ->editColumn('certificate', function ($model) {
               
                return '<a target ="_blank" href ="/media/certificate/'.$model->certificate.'">'.$model->certificate.'</a>'  ;
            })
            ->editColumn('certified_date', function ($model) {
                return date('Y M d', strtotime($model->created_at));
            })
            ->editColumn('approve', function ($model) {
               
                $approve ="<a data-id=".$model->certificate_upload_id." class='btn btn-primary approve'> Approve </a";
                // dd($model->certificate_upload_status);
                if($model->certificate_upload_status == 1)
                {
                   
                    $approve = "<strong>Approved</strong>" ;
                }
                return $approve ;
            })
            ->rawColumns(['s#', 'user', 'course', 'certificate', 'certified_date','approve'])
            ->make(true);
    }
    public function examResult()
    {
        return view('company.exam-result');
    }

    public function getResult()
    {
        $data = Attempt::join('company_workforce','company_workforce.user_id','attempts.user_id')
        
        ->where([['company_workforce.company_id', Auth::user()->id],
        ['attempts.status','finished'],['attempts.is_reviewed',1]])->get();

    return DataTables::of($data)

        ->addIndexColumn()
        ->editColumn('s#', function ($model) {
            return '<span class="si_no"></span> ';
        })
        ->editColumn('user', function ($model) {
            if ($model->user) {
                return $model->user->name;
            }
            return  "";
        })

        ->editColumn('course', function ($model) {
            if($model->course)
            {
                return $model->course->title ;
            }
            return "" ;
        })
        ->editColumn('passing_percent', function ($model) {
            return $model->passing_percent ;
        })
        ->editColumn('total_score', function ($model) {
           
            return $model->total_scores ;
        })
        ->editColumn('result', function ($model) {
            $passing_percent = (int) $model->quiz->option('passing_score');
            if($model->earned_percent >= $passing_percent)
            {
                return "Passed";
            }
            
            return "Failed";

        })
        ->rawColumns(['s#', 'user', 'course', 'passing_percent','total_score', 'result'])
        ->make(true);
}


public function approveCertificate(Request $request)
{
    $id = $request->id ;
    $certificate = CertificateUpload::find($id);
    $certificate->status = 1;
    $certificate->save();
     return response()->json([
         'status'=>true,
         'message'=>"approved"
     ],200);
}
}
