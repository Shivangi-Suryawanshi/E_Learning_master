<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Activity;
use Carbon;
use App\CouponCode;
use App\Course;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CouponController extends Controller
{ 
    public function createCoupon()
    {
        $title = __t('Create Coupon');
        $courses = Course::where([['status',1],['price_plan','paid']])->get();
        return view(theme('dashboard.coupons.create'))->with(['courses' => $courses,'title'=>$title]);
    }
    public function saveCoupon(Request $request)
    {
    
        $messages = [
            'promocode.unique' => 'This Coupon Code has already been taken.',
            'promocode.required' => 'This Coupon Code is required',
        ];   

        $v = Validator::make($request->all(), [
            'promocode' => 'required|alpha_num|unique:coupon_code,coupon_code,0,active_status',
            'starts_on' => 'required',
            'ends_on' => 'required',
            'discount_amount' => 'required',
        ], $messages);
        if ($v->passes()) {
            $promo = new CouponCode();
            $promo->title = $request->input('coupon_title');
            $promo->coupon_type = $request->input('coupon_type');
            $promo->courses = json_encode($request->get('courses'));
            $promo->coupon_code = $request->input('promocode');
            $promo->description = $request->input('coupon_description');
            $promo->valid_from = date("Y-m-d", strtotime($request->input('starts_on')));
            $promo->valid_to = date("Y-m-d", strtotime($request->input('ends_on')));
            $promo->discount_amount = $request->input('discount_amount');
            $promo->used_status = $request->get('used_status');
            $promo->active_status = $request->get('active_status');
            $promo->bidding_id = Null;
            $promo->save();            
           
            if ($promo->id) {
                return redirect(route('coupons'));
            } else {
                return redirect()->back()->with('message', 'Failed to save.');
            }
        } else {
            return redirect()->back()->withErrors($v->errors());
        }
    }
    public function index(Request $request) {
        $title = __t('Coupon');
     $code = $request->type ; 
           $coupons = CouponCode::where(function ($q) use($code) {
               if($code != null)
               {
                   $q->where('coupon_code',$code);
               }
           })
           ->get();
           return view(theme('dashboard.coupons.index'))->with([
               'coupons' => $coupons,'title'=>$title
               ]);
       }
}
