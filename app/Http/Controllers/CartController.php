<?php

namespace App\Http\Controllers;

use App\CouponCode;
use App\Course;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                //return ['success' => 0, 'message' => 'unauthenticated'];
            }
            //return route('login');
        }

        $course_id = $request->course_id;
        $course = Course::find($course_id);
        session()->forget('cart');
        $cartData = (array) session('cart');
        $cartData[$course->id] = [
            'hash'              => str_random(),
            'course_id'         => $course->id,
            'title'             => $course->title,
            'price'             => $course->get_price,
            'original_price'    => $course->price,
            'price_plan'        => $course->price_plan,
            'course_url'        => route('course', $course->slug),
            'thumbnail'      => media_image_uri($course->thumbnail_id)->thumbnail,
            'price_html'      => $course->price_html(false),
        ];
        session(['cart' => $cartData]);

        if ($request->ajax()) {
            return ['success' => 1, 'cart_html' => view_template_part('template-part.minicart')];
        }

        if ($request->cart_btn === 'buy_now') {
            return redirect(route('checkout'));
        }
    }

    /**
     * @param Request $request
     * @return array
     *
     * Remove From Cart
     */
    public function removeCart(Request $request)
    {
        $cartData = (array) session('cart');
        if (array_get($cartData, $request->cart_id)) {
            unset($cartData[$request->cart_id]);
        }
        session(['cart' => $cartData]);
        return ['success' => 1, 'cart_html' => view_template_part('template-part.minicart')];
    }

    public function checkout()
    {

        $user = workForceUserId();
        $count = 1;
        if ($user) {
            foreach (workForceUserId() as $key => $company_user) {
                    $count= count($company_user);
            }
        }
        $title = __('checkout');
        return view(theme('checkout'), compact('title','count'));
    }
    public function couponApply(Request $request)
    {
        
      
        $user = workForceUserId();
        $countUser = 1;
        if ($user) {
            foreach (workForceUserId() as $key => $company_user) {
                $countUser = count($company_user);
            }
        }
        $couponCode = $request->coupon;
        $courseId = $request->courseId;
        $course = Course::find($courseId);
        $salePrice = $course->sale_price * $countUser;
        if(empty($couponCode))
        {
            return response()->json([
                'status'=>true,
                'message'=>"promocode required",
                'newPrice' =>"$".number_format($salePrice,2)
            ],200);
        }
      
        $coupon =  CouponCode::join('biddings','biddings.id','coupon_code.bidding_id')
        ->where([['coupon_code.coupon_code',$couponCode],['biddings.required_course_id',$courseId],['coupon_code.used_status',0]])->first();
        if (empty($coupon)) {
            return response()->json([
                'status' => false,
                'message' => "Invalid Coupon"
            ], 200);
        }
        $appliedCoupon = CouponCode::where('coupon_code',$couponCode)->first();
        // dd($appliedCoupon);
        $appliedCoupon->used_status = 1;
        $appliedCoupon->save();
      
        $discount_percent = (int)$coupon->discount_amount;
        // $newPrice = $salePrice - $discountPrice;
        //  $discount_percent = $checkCoupon->discount ;
            $salePrice = $salePrice - ($discount_percent / 100 * $salePrice);
            $saveAmount =$course->sale_price - $salePrice ;
        // dd($discount_percent,$salePrice,$saveAmount);
    Session::put('new-sale-price',$salePrice);
      
        return response()->json([
            'status' => true,
            'message' => "coupon applied",
            'newPrice' =>"$".number_format($salePrice,2),
            'discount'=>(int)$discount_percent."%",
            'you_save'=>"$".number_format($saveAmount,2),
        ], 200);
    }
}
