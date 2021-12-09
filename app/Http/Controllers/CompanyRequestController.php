<?php

namespace App\Http\Controllers;

use App\CompanyIndividualRequest;
use App\CompanyWorkforce;
use App\Enroll;
use App\Payment;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyRequestController extends Controller
{
    public function index()
    {
        $title = __t('certificate');
        $comapanyRequest = CompanyIndividualRequest::where('individual_user_id', Auth::user()->id)->get();
        return view(theme('dashboard.companyRequest.index'), compact('title', 'comapanyRequest'));
    }

    public function statusChangeIndividual(Request $request)
    {
        $id = $request->id;
        
        $status = $request->status;
        $assigned = CompanyIndividualRequest::find($id);


        //   dd($request->all());
        $auth = Auth::user();
        if ($status == "accept") {
            $assigned->request_status = 2;
            $assigned->save();
            if($assigned->company_user_id)
            {
            $addWorkForce  = new CompanyWorkforce();
            $addWorkForce->user_id    = Auth::user()->id;;
            $addWorkForce->company_id = $assigned->company_user_id;
            $addWorkForce->status = 2;
            $addWorkForce->created_by = Auth::user()->id;
            $addWorkForce->save();
            }
            $notifi = new UserNotification();
            $notifi->notifiable_user_id = $assigned->company_user_id;
            $notifi->notification = " $auth->name accepted Your Request ";
            $notifi->model_id = $assigned->id;
            $notifi->model = "accepted_request_by_individual";
            $notifi->save();
        }
        if ($status == "reject") {
            $assigned->request_status = 1;
            $assigned->save();

            $notifi = new UserNotification();
            $notifi->notifiable_user_id = $assigned->company_user_id;
            $notifi->notification = " $auth->name rejected You Request ";
            $notifi->model_id = $assigned->id;
            $notifi->model = "rejected_request_by_individual";
            $notifi->save();
        }
    }

    public function studentPortal()
    {
        $title = __t('purchased_student');

        $student  = Enroll::join('courses','courses.id','enrolls.course_id')
        ->where([['courses.user_id',Auth::user()->id],['enrolls.status','success']])
        ->select('enrolls.*')->get();
        return view(theme('dashboard.student-potal.index'), compact('title', 'student'));
    }
}
