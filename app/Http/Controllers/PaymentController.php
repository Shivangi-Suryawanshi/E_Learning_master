<?php

namespace App\Http\Controllers;

use App\Course;
use App\Enroll;
use App\Mail\UserRegistrationMail;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function index(Request $request){
        $ids = $request->bulk_ids;

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            // dd($request->bulk_action_btn, $request->status, $ids);
            foreach ($ids as $id) {
                $paymentStatus =   Payment::find($id)->save_and_sync(['status' => $request->status]);
                // Notification section 
                $enroll = Enroll::where('payment_id', $id)->first();
                $courseId =   $enroll->course_id;
                $course = Course::find($courseId);
                $user = $paymentStatus->user_id;
           
                if($request->status != "success")
                {
                    $notification = "Super Admin change status Your Purchased $course->title course status  $request->status";
                    $model = "course-purchase-status-change";
                }
                else
                {
                    $notification = "Super Admin Successfully approved $course->title course. Continue learning";
                    $model = "course-purchase-success";
                }
              
                $model_id = $id;
                $courses['name']  =$paymentStatus->name ;  
                $courses['status'] = $paymentStatus->status ;
                $courses ['course'] = $course->title ;
                $courses['email'] = $paymentStatus->email ;
                $courses['date'] = $paymentStatus->created_at->format('M d Y') ;
                $courses['time'] = $paymentStatus->created_at->format('h:i') ;


                userNotification($user, $notification, $model_id, $model);
        //    dd($courses['name']);
        Mail::to($courses['email'])->queue(new UserRegistrationMail('course-confirmation', $courses));

            }



            return back()->with('success', __a('bulk_action_success'));
        }
        //Delete
        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)){
            if(config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

            foreach ($ids as $id){
                Payment::find($id)->delete_and_sync();
            }
            return back()->with('success', __a('bulk_action_success'));
        }
        //END Bulk Actions

        $title = __a('payments');

        $payments = Payment::query();
        if ($request->q){
            $payments = $payments->where(function($q)use($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%");
            });
        }
        if ($request->filter_status){
            $payments = $payments->where('status', $request->filter_status);
        }
        $payments = $payments->orderBy('id', 'desc')->paginate(20);

        return view('admin.payments.payments', compact('title', 'payments'));
    }

    public function view($id){
        $title = __a('payment_details');
        $payment = Payment::find($id);
        return view('admin.payments.payment_view', compact('title', 'payment'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Delete the Payment
     */
    public function delete($id){
        if(config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

        $payment = Payment::find($id);
        if ($payment){
            $payment->delete_and_sync();
        }
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Update the payment status, and it's related data
     */

    public function updateStatus(Request $request, $id){
        $payment = Payment::find($id);
        if ($payment){
            $payment->status = $request->status;
            $payment->save_and_sync();
        }

        return back()->with('success', __a('success'));
    }

    public function PaymentGateways(){
        $title = __a('payment_settings');
        return view('admin.payments.gateways.payment_gateways', compact('title'));
    }

    public function PaymentSettings(){
        $title = __a('payment_settings');
        return view('admin.payments.gateways.payment_settings', compact('title'));
    }

    public function thankYou(){
        $title = __t('payment_thank_you');
        return view(theme('payment-thank-you'), compact('title'));
    }

}

