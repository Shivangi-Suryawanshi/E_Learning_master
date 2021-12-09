<?php

namespace App\Http\Controllers\Admin;

use App\Bidding;
use App\CouponCode;
use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bidding\CouponCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Coupon;

class BiddingController extends Controller
{
   public function index()
   {
      $title = __t('Bidding Request');
      $bidding = Bidding::join('courses','courses.id','biddings.required_course_id')
      ->where([['courses.user_id',Auth::user()->id],['p_m_request',0]])->select('biddings.*')
     ->get();
      return view(theme('dashboard.instructor.index'), compact('title', 'bidding'));
   }
   public function acceptRequest(Request $request,$id)
   {
      // $id = $request->biddingId;
      $acceptPrice = $request->accept_price;
      $acceptMessage = $request->accept_message;
      $document = $request->document ;
      // dd($document);
      // $status = 1;
      
      // if ($status == 1) {
      //  dd($acceptPrice);

         $bidding =  Bidding::find($id);
         $bidding->accepatnce_status = 1;
         $bidding->acceptance_price = $acceptPrice;
         $bidding->message = $acceptMessage;
         $bidding->updated_by=Auth::user()->id ;
         if ($request->hasFile('document')) {
            $bidding->document = ImageUploadWithPath($document, 'document');
        }
      //   dd('no');
         $bidding->save();
         // Notification  section 
         $courseId =   $bidding->required_course_id;
         //  dd($courseId);
         $course = Course::find($courseId);
         $user = $bidding->company_id;
         $notification = "Your Bidding Request is acceppted for $course->title .Accepted Price  $bidding->acceptance_price";
         $model_id = $bidding->id;
         $model = "biddig-accept";
         userNotification($user, $notification, $model_id, $model);
return redirect()->back();
         // return response()->json([
         //    'status' => true,
         //    'message' => "successfully accepted"
         // ], 200);
      // } else {
      //    return response()->json([
      //       'status' => false,
      //       'message' => "server error"
      //    ]);
      // }
   }

   public function couponCodeCreate(CouponCreateRequest $request)
   {
      // dd($request->all());
      $biddingChange = Bidding::find($request->biddingId);
      $biddingChange->is_genarate_coupon = 1;
      $biddingChange->save();
      $coupon = new  CouponCode();
      $coupon->title = $request->title;
      $coupon->coupon_code = $request->coupon_code;
      $coupon->discount_amount = $request->discount;
      $coupon->bidding_id = $request->biddingId;
      $coupon->valid_from = $request->validity_from;
      $coupon->valid_to = $request->validity_to;
      $coupon->description = $request->description;
      $coupon->save();
      // Notification  section 
      $coupon = CouponCode::join('biddings', 'biddings.id', 'coupon_code.bidding_id')
         ->select(
            'coupon_code.id as id',
            'biddings.required_course_id as required_course_id',
            'biddings.company_id as company_id',
            'coupon_code.coupon_code as coupon_code',
            'coupon_code.valid_to as valid_to'
         )->first();
      //   Notification  section 
      $courseId =   $coupon->required_course_id;
      $course = Course::find($courseId);
      $user = $coupon->company_id;
      $notification = "Coupon code genarate for $course->title .A new coupon code '  $coupon->coupon_code '  validity  ' $coupon->valid_to '";
      $model_id = $coupon->id;
      $model = "biddig-coupon-code";
      userNotification($user, $notification, $model_id, $model);

      return response()->json([
         'status' => true,
         'message' => "You have successfully coupon genarated"
      ], 200);
   }
}
