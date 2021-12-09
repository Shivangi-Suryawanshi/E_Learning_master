<?php

namespace App\Http\Controllers;

use App\CompanyPurchaseTemporary;
use App\CompanyRequiredCourse;
use App\Course;
use App\CoursePurchase;
use App\UserNotification;
use App\Enroll;
use App\Mail\UserRegistrationMail;
use App\Package;
use App\PackageFunctionality;
use App\Payment;
use App\RequiredCourseWorkforce;
use App\Subscription;
use App\SubscriptionFunctionality;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Stripe\Stripe;

class GatewayController extends Controller
{

    /**
     * @param Request $request
     * @return array
     * @throws \Stripe\Exception\ApiErrorException
     *
     * Stripe Charge
     */
    public function stripeCharge(Request $request)
    {
        // dd($request->all());
        $request->session()->forget('new-sale-price');
        $couponApplyamount = Session::get('new-sale-price');
        $stripeToken = $request->stripeToken;
        $type = $request->type;
        $subAmout = $request->subAmout;
        $packageId = $request->packageId;
        $month = $request->month;
        Stripe::setApiKey(get_stripe_key('secret'));

        // Create the charge on Stripe's servers - this will charge the user's card
        try {
            $cart = cart();
            $amount = $cart->total_amount;
            if(isset($couponApplyamount))
            {
                $amount = $couponApplyamount;
            }
           
            if ($type == "subscription") {
                $request->session()->forget('cart');
                $amount = $subAmout;
            }
            $user = Auth::user();
            // 4242424242424242
            $currency = get_option('currency_sign'); 
            //Orginal
            // $currency = "INR";

            //Charge from card
            // dd($amount,$currency);
            $charge = Charge::create(array(
                "amount"        => get_stripe_amount($amount), // amount in cents, again //Orginal

                "currency"      => $currency,
                "source"        => $stripeToken,
                "description"   => isset($type) ? get_option('site_name') . "'s subscription " : get_option('site_name') . "'s course enrolment"
            ));
            // dd($amount);
            if ($charge->status == 'succeeded') {
                //Save payment into database
              
                if ($type == "subscription") {
                    $data = [
                        'name'              => $user->name,
                        'email'             => $user->email,
                        'user_id'           => $user->id,
                        'amount'            => isset($cart->total_price) ? $cart->total_price : $subAmout,
                        'payment_method'        => 'stripe',
                        'total_amount'      => get_stripe_amount($charge->amount, 'to_dollar'),
    
                        'currency'              => $currency,
                        'charge_id_or_token'    => $charge->id,
                        'description'           => $charge->description,
                        'payment_created'       => $charge->created,
    
                        //Card Info
                        'card_last4'        => $charge->source->last4,
                        'card_id'           => $charge->source->id,
                        'card_brand'        => $charge->source->brand,
                        'card_country'      => $charge->source->US,
                        'card_exp_month'    => $charge->source->exp_month,
                        'card_exp_year'     => $charge->source->exp_year,
                        'status'                    => 'success',

                        'package_id' => $packageId,
                        'month' => $month
                    ];
                    // dd('js');
                    $package = Package::find($packageId);
                    $subscription = Subscription::create($data);
                    $packFunctionality = PackageFunctionality::where('package_id', $packageId)->get();
                    if ($packFunctionality) {
                        foreach ($packFunctionality as $functionality) {
                            $subFunction = new  SubscriptionFunctionality();
                            $subFunction->subscription_id = $subscription->id;
                            $subFunction->functionality_id = $functionality->functionality_id;
                            $subFunction->count = $functionality->count;
                            $subFunction->save();
                        }
                    }
                    //admin notification
                    $auth = Auth::user();
                    $adminnotifi = new UserNotification();
                    $adminnotifi->notifiable_user_id = 1;
                    $adminnotifi->notification = " $auth->name subscribed $package->title package";
                    $adminnotifi->model_id = $subscription->id;
                    $adminnotifi->model = "subscrib";
                    $adminnotifi->save();
                    return ['success' => 1, 'message_html' => $this->subscription_payment_success_html()];
                } else {
                    $courseId = $cart->course_id[0];
                    $courseName = $cart->course_name[0];
                    // dd($cart);
                    // Payment::create_and_sync($data);
                    // store payment details in payment table if workForceUserId
                    $data = [
                        'name'              => $user->name,
                        'email'             => $user->email,
                        'user_id'           => $user->id,
                        'amount'            => isset($subAmout) ? $subAmout : $cart->total_price,
                        'payment_method'        => 'stripe',
                        'total_amount'      => get_stripe_amount($charge->amount, 'to_dollar'),
    
                        'currency'              => $currency,
                        'charge_id_or_token'    => $charge->id,
                        'description'           => $charge->description,
                        'payment_created'       => $charge->created,
    
                        //Card Info
                        'card_last4'        => $charge->source->last4,
                        'card_id'           => $charge->source->id,
                        'card_brand'        => $charge->source->brand,
                        'card_country'      => $charge->source->US,
                        'card_exp_month'    => $charge->source->exp_month,
                        'card_exp_year'     => $charge->source->exp_year,
                        'status'                    => 'success',
                      
                    ];
                    if (workForceUserId()) {
                        foreach (workForceUserId() as $keys => $workForceUserId) {
                            foreach ($workForceUserId as $key => $workForceUserIdList) {
                                $auth = Auth::user();
                                $user = User::find($workForceUserIdList);
                                $data = [
                                    'name'              => $user->name,
                                    'email'             => $user->email,
                                    'user_id'           => $user->id,
                                    'amount'            => isset($cart->total_price) ? $cart->total_price : $subAmout,
                                    'payment_method'        => 'stripe',
                                    'total_amount'      => get_stripe_amount($charge->amount, 'to_dollar'),
                
                                    'currency'              => $currency,
                                    'charge_id_or_token'    => $charge->id,
                                    'description'           => $charge->description,
                                    'payment_created'       => $charge->created,
                
                                    //Card Info
                                    'card_last4'        => $charge->source->last4,
                                    'card_id'           => $charge->source->id,
                                    'card_brand'        => $charge->source->brand,
                                    'card_country'      => $charge->source->US,
                                    'card_exp_month'    => $charge->source->exp_month,
                                    'card_exp_year'     => $charge->source->exp_year,
                                    'status'                    => 'success',
                                  
                                ];
                                // $payments_data = [
                                //     'name'                  => $user->name,
                                //     'email'                 => $user->email,
                                //     'user_id'               => $user->id,
                                //     'amount'                => isset($couponApplyamount) ? $couponApplyamount : $amount,
                                //     'payment_method'        => 'offline',
                                //     'status'                => 'onhold',
                                //     'currency'              => $currency,
                                //     'local_transaction_id'  => $transaction_id,
                                //     'payment_note'          => clean_html($request->payment_note),
                                // ];
                                $payment =   Payment::create_and_sync($data);
                                // update user details in payment table 
                                $paymentUpdate = Payment::find($payment->id);
                                $paymentUpdate->name =$user->name;
                                $paymentUpdate->email = $user->email ;
                                $paymentUpdate->user_id = $user->id ;
                                $paymentUpdate->save();
                                // for notification to store user notification table 
            
                                $notifi = new UserNotification();
                                $notifi->notifiable_user_id = $workForceUserIdList;
                                $notifi->notification = "You have a new Course   $courseName  purchased By  $auth->name  ";
                                $notifi->model_id = $payment->course_id;
                                $notifi->model = "course_purchase_by_company_for_work_forces";
                                $notifi->save();
                            }
                        }
                        $course = Course::find($courseId);
            
                        $courseUser = $course->user_id;
                        $sendUser = User::find($courseUser);
                        //admin notification
                        $adminnotifi = new UserNotification();
                        $adminnotifi->notifiable_user_id = Auth::user()->id;
                        $adminnotifi->notification = "You have successfully purchase Course   $courseName  ";
                        $adminnotifi->model_id = $course->id;
                        $adminnotifi->model = "company_purchase_courses";
                        $adminnotifi->save();
                        // Instructor notification 
                        $instannotifi = new UserNotification();
                        $instannotifi->notifiable_user_id = $courseUser;
                        $instannotifi->notification = "Your Course $courseName  purchased by $sendUser->name ";
                        $instannotifi->model_id = $payment->id;
                        $instannotifi->model = "course_created_user";
                        $instannotifi->save();

                        //
                        // degrees course seat 
                        if($course->available_student > 0 && $course->available_student != null)
                        {
                            $degreesOne = (int)$course->available_student - 1 ;
                           
                          Course::find($courseId)
                           ->update([
                               'available_student'=>$degreesOne,
                           ]);
                        }
                    } else {
                        $payment =   Payment::create_and_sync($data);

                        // $payments_data = [
                        //     'name'                  => $user->name,
                        //     'email'                 => $user->email,
                        //     'user_id'               => $user->id,
                        //     'amount'                => isset($couponApplyamount) ? $couponApplyamount : $amount,
                        //     'payment_method'        => 'offline',
                        //     'status'                => 'onhold',
                        //     'currency'              => $currency,
                        //     'local_transaction_id'  => $transaction_id,
                        //     'payment_note'          => clean_html($request->payment_note),
                        // ];
                        // $payment =    Payment::create_and_sync($payments_data);
                        $notifi = new UserNotification();
                        $notifi->notifiable_user_id = Auth::user()->id;
                        $notifi->notification = "You have purchased New Course  $courseName ..... ";
                        $notifi->model_id = $payment->id;
                        $notifi->model = "individually_purchased";
                        $notifi->save();
            
                        // Instructor notification 
                        $course = Course::find($courseId);
                         // degrees course seat 
                         if($course->available_student > 0 && $course->available_student != null)
                         {
                             $degreesOne = (int)$course->available_student - 1 ;
                            
                           Course::find($courseId)
                            ->update([
                                'available_student'=>$degreesOne,
                            ]);
                         }

                        $userName = User::find($course->user_id);
                        $instannotifi = new UserNotification();
                        $instannotifi->notifiable_user_id = $course->user_id;
                        $instannotifi->notification = "Your Course $courseName  purchased  $userName->name ";
                        $instannotifi->model_id = $payment->id;
                        $instannotifi->model = "course_created_user";
                        $instannotifi->save();
                    }
                }
                $request->session()->forget('cart');

                return ['success' => 1, 'message_html' => $this->payment_success_html()];
            }
        } catch (CardException $e) {
            // The card has been declined
            return ['success' => 0, 'msg' => __t('payment_declined_msg'), 'response' => $e];
        }
    }

    public function payment_success_html()
    {
        $html = ' <div class="payment-received text-center">
                            <h1> <i class="fa fa-check-circle-o"></i> ' . __t('payment_thank_you') . '</h1>
                            <p>' . __t('payment_receive_successfully') . '</p>
                            <a href="' . route('home') . '" class="btn btn-dark">' . __t('home') . '</a>
                        </div>';
        return $html;
    }

    public function subscription_payment_success_html()
    {
        $html = ' <div class="payment-received text-center">
                            <h1> <i class="fa fa-check-circle-o"></i> ' . __t('payment_thank_you') . '</h1>
                            <p>' . __t('subscription_payment_receive_successfully') . '</p>
                            <a href="' . route('add-profile') . '" class="btn btn-dark">' . __t('home') . '</a>
                        </div>';
        return $html;
    }

    public function bankPost(Request $request)
    {
        $cart = cart();
        $couponApplyamount = Session::get('new-sale-price');
        $amount = $cart->total_amount;
        if(isset($couponApplyamount))
        {
            $amount = $couponApplyamount;
        }
        $user = Auth::user();
        $currency = get_option('currency_sign');

        //Create payment in database
        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        $payments_data = [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'user_id'               => $user->id,
            'amount'                => $amount,
            'payment_method'        => 'bank_transfer',
            'status'                => 'pending',
            'currency'              => $currency,
            'local_transaction_id'  => $transaction_id,

            'bank_swift_code'       => clean_html($request->bank_swift_code),
            'account_number'        => clean_html($request->account_number),
            'branch_name'           => clean_html($request->branch_name),
            'branch_address'        => clean_html($request->branch_address),
            'account_name'          => clean_html($request->account_name),
            'iban'                  => clean_html($request->iban),
        ];
        //Create payment and clear it from session
        Payment::create_and_sync($payments_data);

        $request->session()->forget('cart');

        return redirect(route('payment_thank_you_page'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Redirect to PayPal for the Payment
     */
    public function paypalRedirectOld(Request $request)
    {
        // dd('hai');

        if (!session('cart')) {
            return redirect(route('checkout'));
        }

        $cart = cart();
        $couponApplyamount = Session::get('new-sale-price');
        $amount = $cart->total_amount;
        if(isset($couponApplyamount))
        {
            $amount = $couponApplyamount;
        }
        $user = Auth::user();
        $currency = get_option('currency_sign');

        //Create payment in database
        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        $payments_data = [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'user_id'               => $user->id,
            'amount'                => $amount,
            'payment_method'        => 'paypal',
            'status'                => 'initial',
            'currency'              => $currency,
            'local_transaction_id'  => $transaction_id,
        ];
        //Create payment and clear it from session
        $payment = Payment::create_and_sync($payments_data);
        $request->session()->forget('cart');

        // PayPal settings
        $paypal_action_url = "https://www.paypal.com/cgi-bin/webscr";
        if (get_option('enable_paypal_sandbox'))

            $paypal_action_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

        $paypal_email = get_option('paypal_receiver_email');
        $return_url = route('payment_thank_you_page', $transaction_id);
        $cancel_url = route('checkout');
        $notify_url = route('paypal_notify', $transaction_id);

        $item_name = get_option('site_name') . "'s course enrolment";
        // dd($paypal_email,$return_url,$cancel_url,$notify_url);
        $querystring = '';
        // Firstly Append paypal account to querystring
        $querystring .= "?cmd=_xclick&business=" . urlencode($paypal_email) . "&";
        $querystring .= "item_name=" . urlencode($item_name) . "&";
        $querystring .= "amount=" . urlencode($amount) . "&";
        $querystring .= "currency_code=" . urlencode($currency) . "&";
        $querystring .= "item_number=" . urlencode($payment->local_transaction_id) . "&";
        // Append paypal return addresses
        $querystring .= "return=" . urlencode(stripslashes($return_url)) . "&";
        $querystring .= "cancel_return=" . urlencode(stripslashes($cancel_url)) . "&";
        $querystring .= "notify_url=" . urlencode($notify_url);

        // Redirect to paypal IPN
        $URL = $paypal_action_url . $querystring;
        return redirect($URL);
        // return redirect($URL);
    }

    public function payOffline(Request $request)
    {
        $user = workForceUserId();
        $countUser = 1;
        if ($user) {
            foreach (workForceUserId() as $key => $company_user) {
                $countUser = count($company_user);
            }
        }

        $cart = cart();
        // dd($cart);
        $amount = $cart->total_amount;
        $couponApplyamount = Session::get('new-sale-price');
        if(isset($couponApplyamount))
        {
            $amount = $couponApplyamount;
        }
        // dd($couponApplyamount,$amount);
        $courseId = $cart->course_id[0];
        $courseName = $cart->course_name[0];
        $user = Auth::user();
        $currency = get_option('currency_sign');

        //Create payment in database
        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        if (workForceUserId()) {
            foreach (workForceUserId() as $keys => $workForceUserId) {
                foreach ($workForceUserId as $key => $workForceUserIdList) {
                    $auth = Auth::user();
                    $user = User::find($workForceUserIdList);
                    $payments_data = [
                        'name'                  => $user->name,
                        'email'                 => $user->email,
                        'user_id'               => $user->id,
                        'amount'                =>  $amount,
                        'payment_method'        => 'offline',
                        'status'                => 'onhold',
                        'currency'              => $currency,
                        'local_transaction_id'  => $transaction_id,
                        'payment_note'          => clean_html($request->payment_note),
                    ];
                    $payment =   Payment::create_and_sync($payments_data);
                    // for notification to store user notification table 

                    $notifi = new UserNotification();
                    $notifi->notifiable_user_id = $workForceUserIdList;
                    $notifi->notification = "You have a new Course   $courseName  purchased By  $auth->name ....  Please waiting for super admin approvel ";
                    $notifi->model_id = $payment->course_id;
                    $notifi->model = "course_purchase_by_company_for_work_forces";
                    $notifi->save();
                }
            }
            $course = Course::find($courseId);

            $courseUser = $course->user_id;
            //admin notification
            $adminnotifi = new UserNotification();
            $adminnotifi->notifiable_user_id = Auth::user()->id;
            $adminnotifi->notification = "You have successfully purchase Course   $courseName  ";
            $adminnotifi->model_id = $course->id;
            $adminnotifi->model = "company_purchase_courses";
            $adminnotifi->save();
            // Instructor notification 
            $instannotifi = new UserNotification();
            $instannotifi->notifiable_user_id = $courseUser;
            $instannotifi->notification = "Your Course $courseName  purchased by $auth->name ";
            $instannotifi->model_id = $payment->id;
            $instannotifi->model = "course_created_user";
            $instannotifi->save();


             // degrees course seat 
             if($course->available_student > 0 && $course->available_student != null)
             {
                 $degreesOne = (int)$course->available_student - 1 ;
                
               Course::find($courseId)
                ->update([
                    'available_student'=>$degreesOne,
                ]);
             }
        } else {
            $payments_data = [
                'name'                  => $user->name,
                'email'                 => $user->email,
                'user_id'               => $user->id,
                'amount'                => isset($couponApplyamount) ? $couponApplyamount : $amount,
                'payment_method'        => 'offline',
                'status'                => 'onhold',
                'currency'              => $currency,
                'local_transaction_id'  => $transaction_id,
                'payment_note'          => clean_html($request->payment_note),
            ];
            $payment =    Payment::create_and_sync($payments_data);
            $notifi = new UserNotification();
            $notifi->notifiable_user_id = Auth::user()->id;
            $notifi->notification = "You have purchased New Course  $courseName ..... Please waiting for super admin approvel ";
            $notifi->model_id = $payment->id;
            $notifi->model = "individually_purchased";
            $notifi->save();

            // Instructor notification 
            $course = Course::find($courseId);
            $userName = User::find($course->user_id);
            $instannotifi = new UserNotification();
            $instannotifi->notifiable_user_id = $course->user_id;
            $instannotifi->notification = "Your Course $courseName  purchased  $userName->name ";
            $instannotifi->model_id = $payment->id;
            $instannotifi->model = "course_created_user";
            $instannotifi->save();

             // degrees course seat 
             if($course->available_student > 0 && $course->available_student != null)
             {
                 $degreesOne = (int)$course->available_student - 1 ;
                
               Course::find($courseId)
                ->update([
                    'available_student'=>$degreesOne,
                ]);
             }
        Mail::to($user->email)->queue(new UserRegistrationMail('course-purchase', $course));

        }
        //Create payment and clear it from session
        // Payment::create_and_sync($payments_data);



        // course purchase start 

        if (Auth::user()->user_type == "company") {

            $company_id  = Session::get('company_id');
            $temp_course_id  =  Session::get('temp_course_id');
            $tempData = CompanyPurchaseTemporary::where('id', $temp_course_id)->where('status', 1)->first();

            //TODO 2: SAVE IN course_purchases TABLE
            $cpObj   = new CoursePurchase();
            $cpObj->purchase_code =  "";
            $cpObj->course_id =   $tempData->purchase_course_id;
            $cpObj->purchased_by_id   =  $company_id;
            $cpObj->purchased_by_type =  3;
            $cpObj->unit_purchase_price =  $tempData->unit_price;
            $cpObj->total_price =  isset($couponApplyamount) ? $couponApplyamount : $amount * $countUser;
            $cpObj->quantity =  $tempData->course_quantity;
            // $cpObj->purchased_course_id = $tempData->purchase_course_id;
            $cpObj->save();

            //TODO 3: SAVE IN course_attendees TABLE

            //SAVE IN company_required_courses
            $obj = CompanyRequiredCourse::where('id', $tempData->company_course_id)->first();
            $obj->purchase_course_id = $tempData->purchase_course_id;
            $obj->updated_at = now();
            $obj->updated_by = Auth::user()->id;
            $obj->save();

            //SAVE IN required_course_workforces
            $users   = $tempData->assigned_employees;
            $userArr = explode(",", $users);
            foreach ($userArr as $user) {
                if ($user != 'all') {
                    $obj2   = new RequiredCourseWorkforce();
                    $obj2->course_purchase_id =  $cpObj->id;
                    $obj2->course_id =  $tempData->company_course_id;

                    $obj2->user_id   =  $user;
                    $obj2->save();
                }
            }
        }


        $request->session()->forget('temp_course_id');
        $request->session()->forget('company_user');
        $request->session()->forget('cart');
        $request->session()->forget('new-sale-price');

        return redirect(route('payment_thank_you_page'));
    }



    // online payment

    public function paypalRedirect(Request $request)
    {
        $user = workForceUserId();
        $countUser = 1;
        if ($user) {
            foreach (workForceUserId() as $key => $company_user) {
                $countUser = count($company_user);
            }
        }

        $cart = cart();
        // dd($cart);
        $amount = $cart->total_amount;
        $couponApplyamount = Session::get('new-sale-price');
        if(isset($couponApplyamount))
        {
            $amount = $couponApplyamount;
        }
        // dd($couponApplyamount,$amount);
        $courseId = $cart->course_id[0];
        $courseName = $cart->course_name[0];
        $user = Auth::user();
        $currency = get_option('currency_sign');

        //Create payment in database
        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        if (workForceUserId()) {
            foreach (workForceUserId() as $keys => $workForceUserId) {
                foreach ($workForceUserId as $key => $workForceUserIdList) {
                    $auth = Auth::user();
                    $user = User::find($workForceUserIdList);
                    $payments_data = [
                        'name'                  => $user->name,
                        'email'                 => $user->email,
                        'user_id'               => $user->id,
                        'amount'                =>  $amount,
                        'payment_method'        => 'offline',
                        'status'                => 'onhold',
                        'currency'              => $currency,
                        'local_transaction_id'  => $transaction_id,
                        'payment_note'          => clean_html($request->payment_note),
                    ];
                    $payment =   Payment::create_and_sync($payments_data);
                    // for notification to store user notification table 

                    $notifi = new UserNotification();
                    $notifi->notifiable_user_id = $workForceUserIdList;
                    $notifi->notification = "You have a new Course   $courseName  purchased By  $auth->name ....  Please waiting for super admin approvel ";
                    $notifi->model_id = $payment->course_id;
                    $notifi->model = "course_purchase_by_company_for_work_forces";
                    $notifi->save();
                }
            }
            $course = Course::find($courseId);

            $courseUser = $course->user_id;
            //admin notification
            $adminnotifi = new UserNotification();
            $adminnotifi->notifiable_user_id = Auth::user()->id;
            $adminnotifi->notification = "You have successfully purchase    $courseName  Course";
            $adminnotifi->model_id = $course->id;
            $adminnotifi->model = "company_purchase_courses";
            $adminnotifi->save();
            // Instructor notification 
            $instannotifi = new UserNotification();
            $instannotifi->notifiable_user_id = $courseUser;
            $instannotifi->notification = "Your Course $courseName  purchased   $auth->name  ";
            $instannotifi->model_id = $payment->id;
            $instannotifi->model = "course_created_user";
            $instannotifi->save();
            
             // degrees course seat 
             if($course->available_student > 0 && $course->available_student != null)
             {
                 $degreesOne = (int)$course->available_student - 1 ;
                
               Course::find($courseId)
                ->update([
                    'available_student'=>$degreesOne,
                ]);
             };
        } else {
            $payments_data = [
                'name'                  => $user->name,
                'email'                 => $user->email,
                'user_id'               => $user->id,
                'amount'                => isset($couponApplyamount) ? $couponApplyamount : $amount,
                'payment_method'        => 'offline',
                'status'                => 'onhold',
                'currency'              => $currency,
                'local_transaction_id'  => $transaction_id,
                'payment_note'          => clean_html($request->payment_note),
            ];
            $payment =    Payment::create_and_sync($payments_data);
            $notifi = new UserNotification();
            $notifi->notifiable_user_id = Auth::user()->id;
            $notifi->notification = "You have purchased New Course  $courseName ..... Please waiting for super admin approvel ";
            $notifi->model_id = $payment->id;
            $notifi->model = "individually_purchased";
            $notifi->save();

            // Instructor notification 
            $course = Course::find($courseId);
            $userName = User::find($course->user_id);
            $instannotifi = new UserNotification();
            $instannotifi->notifiable_user_id = $course->user_id;
            $instannotifi->notification = "Your Course $courseName  purchased  $userName->name ";
            $instannotifi->model_id = $payment->id;
            $instannotifi->model = "course_created_user";
            $instannotifi->save();
        }
        //Create payment and clear it from session
        // Payment::create_and_sync($payments_data);

        // course purchase start 

        if (Auth::user()->user_type == "company") {

            $company_id  = Session::get('company_id');
            $temp_course_id  =  Session::get('temp_course_id');
            $tempData = CompanyPurchaseTemporary::where('id', $temp_course_id)->where('status', 1)->first();

            //TODO 2: SAVE IN course_purchases TABLE
            $cpObj   = new CoursePurchase();
            $cpObj->purchase_code =  "";
            $cpObj->course_id =  $tempData->purchase_course_id;
            $cpObj->purchased_by_id   =  $company_id;
            $cpObj->purchased_by_type =  3;
            $cpObj->unit_purchase_price =  $tempData->unit_price;
            $cpObj->total_price =  isset($couponApplyamount) ? $couponApplyamount : $amount * $countUser;
            $cpObj->quantity =  $tempData->course_quantity;
            // $cpObj->purchased_course_id = $tempData->purchase_course_id;
            $cpObj->save();

            //TODO 3: SAVE IN course_attendees TABLE

            //SAVE IN company_required_courses
            $obj = CompanyRequiredCourse::where('id', $tempData->company_course_id)->first();
            $obj->purchase_course_id = $tempData->purchase_course_id;
            $obj->updated_at = now();
            $obj->updated_by = Auth::user()->id;
            $obj->save();

            //SAVE IN required_course_workforces
            $users   = $tempData->assigned_employees;
            $userArr = explode(",", $users);
            foreach ($userArr as $user) {
                if ($user != 'all') {
                    $obj2   = new RequiredCourseWorkforce();
                    $obj2->course_purchase_id =  $cpObj->id;
                    $obj2->course_id =  $tempData->company_course_id;

                    $obj2->user_id   =  $user;
                    $obj2->save();
                }
            }
        }
        $request->session()->forget('temp_course_id');
        $request->session()->forget('company_user');
        $request->session()->forget('cart');
        $request->session()->forget('new-sale-price');
        // PayPal settings
        $paypal_action_url = "https://www.paypal.com/cgi-bin/webscr";
        if (get_option('enable_paypal_sandbox'))

            $paypal_action_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

        $paypal_email = get_option('paypal_receiver_email');
        $return_url = route('payment_thank_you_page', $transaction_id);
        $cancel_url = route('checkout');
        $notify_url = route('paypal_notify', $transaction_id);

        $item_name = get_option('site_name') . "'s course enrolment";
        // dd($paypal_email,$return_url,$cancel_url,$notify_url);
        $querystring = '';
        // Firstly Append paypal account to querystring
        $querystring .= "?cmd=_xclick&business=" . urlencode($paypal_email) . "&";
        $querystring .= "item_name=" . urlencode($item_name) . "&";
        $querystring .= "amount=" . urlencode($amount * $countUser) . "&";
        $querystring .= "currency_code=" . urlencode($currency) . "&";
        $querystring .= "item_number=" . urlencode($payment->local_transaction_id) . "&";
        // Append paypal return addresses
        $querystring .= "return=" . urlencode(stripslashes($return_url)) . "&";
        $querystring .= "cancel_return=" . urlencode(stripslashes($cancel_url)) . "&";
        $querystring .= "notify_url=" . urlencode($notify_url);

        // Redirect to paypal IPN
        $URL = $paypal_action_url . $querystring;
        return redirect($URL);
        // return redirect($URL);
    }
}
