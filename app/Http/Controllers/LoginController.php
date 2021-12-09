<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Settings;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\EmailTemplates;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\UserRegistrationMail;

class LoginController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    protected $redirectTo;

    public function __construct()
    {
        parent::__construct();
        if (Auth::check()) {
            Redirect::to('/')->send();
        }
    }


    /**
     * Function Usage : Login as admin
     *
     * @param $key
     * @return Redirect
     */
    public function loginasadmin($key)
    {
        // dd('hai');
        $user = \App\User::where('token', '=', $key)->first();

        if ($user) {
            
            Auth::loginUsingId($user->id, true);
            Auth::user()->save();
            $user->token = null;
            $user->save();
            if($user->user_type == "company" || $user->user_type == "contractor")
            {
                return redirect('/company');

            }else
            {
                return redirect('/dashboard');

            }
        }

         return false;
    }

    /**
     * Function Usage : Registration Success
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerSuccess(Request $request)
    {

        if ($request->get('email')) {
            $emailId = $request->get('email');
            $loginMsg = 1;
            return Redirect::to('otp-verification')->with(['emailid' => $emailId, 'loginMsg' => $loginMsg]);
        }

        return view('pages.register-success');
    }

    /**
     * Function Usage : User Account activation success page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accountActiveSuccess()
    {
        if (Session::get('message')) {
            return view('pages.account-active');
        }

        return Redirect::to('login');
    }

    /**
     * Function Usage : To confirm activation token
     *
     * @param $userId
     * @param $confirmationCode
     * @return mixed
     */
    public function confirm($userId, $confirmationCode)
    {
        if (!$confirmationCode) {
            $message = trans('authentication.msg_acivation_code_missing');
            return Redirect::to('login')->with('message', $message);
        }

        $user = User::where(array('id' => $userId, 'activation_token' => $confirmationCode))->first();
        if (!$user) {
            $q = User::where(array('id' => $userId))->first();
            if ($q && $q->active == 1) {
                $message = trans('authentication.msg_account_active');

                return Redirect::to('login')->with('message', $message);
            }

            return Redirect::to('resend-activation');
        } else {
            $user->active = 1;
            $user->activation_token = null;
            $user->save();
            $message = trans('authentication.msg_account_verified');
            return redirect(route('account-activated'))->with('message', $message);
        }

        return Redirect::to('login')->with('message', $message);
    }

    /**
     * Function Usage : Check authentication details
     *
     * @param Request $request
     * @return Redirect
     */
    public function doLogin(Request $request)
    {     
        $email = encrypt($request->get('email'));
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true, true)) {

            $row = User::find(Auth::user()->id);
           
            if ($row->active == '0') {
                Auth::logout();
                $message = trans('authentication.msg_account_not_verified');
                return redirect(route('user.login'))->with('errorMsg', $message);
            }
            if ($row->blocked == 1) {
            Auth::logout();
            $errorMsg = "User blocked. Please contact administartor.";
            return redirect(route('user.login'))->with('errorMsg', $errorMsg);
        }
           return redirect()->to('dashboard')->with('user', $row);
        } else {
            $errorMsg = trans('authentication.msg_invalid_usernamr_pass');
            return redirect(route('user.login'))->with('errorMsg', $errorMsg);
        }

      
        if ($request->session()->has('reqUrl')) {
            $domain = Session::get('domain');
            $url = Session::get('reqUrl');
            Session::forget('domain');
            Session::forget('reqUrl');
            return \Redirect::route($url, $domain);
        }

        return redirect()->to('dashboard');
    }

    /**
     * Function Usage : Verify login OTP
     *
     * @return $this|Redirect
     */
    public function loginOtpVarify()
    {
        if (Session::has('log_email')) {
            $email = decrypt(Session::get('log_email'));
            return view('auth.login-otp')->with(['log_email' => encrypt($email)]);
        }

        return redirect(route('user.login'));
    }

    /**
     * Function Usage : Login OTP verification
     *
     * @param Request $request
     * @return mixed
     */
    public function doLoginOtpVarify(Request $request)
    {
        $rules = ['phone_otp' => 'required'];
        $messages = ['phone_otp.required' => trans('authentication.error_otp_required')];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($request->has('log_email')) {

            if ($validator->fails())
                return redirect()->back()->withErrors($validator->errors());
            $email = decrypt($request->get('log_email'));
            $user = User::where(['email' => $email, 'login_otp' => $request->get('phone_otp')])->first();

            if ($user == null) {
                return redirect()->back()->withErrors(['err_message' => trans('authentication.login_valide_otp')]);
            }
            $current_time = Carbon::now();
            $timeDiff = $current_time->diffInMinutes(Session::get('timestamp'));
            if ($timeDiff <= 15) {
                if (Auth::loginUsingId($user->id, true)) {

                    $user = User::find(Auth::id());
                    $user->login_otp = null;
                    $user->save();
                    Session::forget('log_email');
                    Session::forget('timestamp');

                    if ($request->session()->has('reqUrl')) {
                        $domain = Session::get('domain');
                        $url = Session::get('reqUrl');
                        Session::forget('domain');
                        Session::forget('reqUrl');
                        return \Redirect::route($url, $domain);
                    }
                    return redirect()->to('dashboard');
                }
            }
            return redirect()->back()->withErrors(['err_message' => trans('authentication.login_valide_otp')]);
        }
        return redirect()->back()->withErrors(['err_message' => trans('authentication.login_valide_otp')]);
    }

    /**
     * Function Usage : Logout
     *
     * @return mixed
     */
    public function logout()
    {
        \Auth::logout();
        trackActivity('Logged out', 'Login');
        return Redirect::to('/login')->with('message', '', trans('authentication.msg_logged_out'));
    }

    /**
     * Function Usage : Resend activation
     *
     * @param Request $request
     * @return mixed
     */
    public function resend_activation(Request $request)
    {
        $rules = array(
            'email' => 'required|email'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $email = $request->input('email');
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->with('message', trans('authentication.msg_email_not_found'));
            } else {
                $activation_code = $user->set_activation($user->id);
                Mail::to($user->email)->queue(new UserRegistrationMail('resend-activation-user', $user));

                if (count(Mail::failures()) == 0) {
                    $message = trans('authentication.msg_activation_link');
                } else {
                    $message = trans('authentication.msg_error');
                }
                return Redirect::to('resend-activation')->with('message', $message);
            }
        }
        return redirect()->back()->withErrors($validator->errors());
    }

    /**
     * Function Usage : Check OTP
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkOtp()
    {
        return view('auth.otp_verification');
    }

    /**
     * Function Usage : OTP Verification
     *
     * @param Request $request
     * @param $email
     * @return mixed
     */
    public function verifyOtp(Request $request, $email)
    {
        $newemail = decrypt($email);

        $otp = $request->get('phone_otp');
        $rules = ['phone_otp' => 'required'];
        $messages = ['phone_otp.required' => trans('profile.text_otp_required')];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with(['emailid' => $email]);
        }

        if (!$otp) {
            $message = trans('profile.text_otp_missing');
            return Redirect::to('login')->with('message', $message);
        }

        $user = User::where(array('email' => $newemail, 'otp' => $otp))->first();
        if ($user) {
            $user->otp_status = 1;
            $user->otp = null;
            $user->save();

            if ($user->active == 1) {
                $message = trans('authentication.msg_account_verified');
                return redirect(route('account-activated'))->with('message', $message);
            } elseif ($user->otp_status == 1) {
                $message = trans('authentication.msg_otp_verified');
                return redirect(route('account-activated'))->with('message', $message);
            }
        } else {
            $errormessage = trans('profile.text_otp_wrong');
            return redirect()->back()->with(['errormessage' => $errormessage, 'emailid' => $email]);
        }
    }
    /**
     * Function Usage : Forgot password
     *
     */
    public function show_forgot_password() {
        return view('auth.forgot_password');
    }

    public function forgot_password(Request $request) {
        //  die("RESET PASSWORD 1");


        $rules = array(
            'email' => 'required|email'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {

            $user = User::where('email', '=', $request->input('email'));
            if ($user->count() >= 1) {
                $user = $user->first();
                $data = array(
                    'token' => $request->input('_token'),
                    'user_name' => $user->firstname . ' ' . $user->lastname,
                    'to' => $request->input('email')
                );

                Mail::to($user->email)->queue(new UserRegistrationMail('user-password-reset', $data));

                $affectedRows = User::where('email', '=', $user->email)
                        ->update(array('reminder' => $request->input('_token')));

                return Redirect::to('forgot-password')->with('message', trans('authentication.msg_check_email'));
            } else {
                return Redirect::to('forgot-password')->with('message', trans('authentication.msg_wrong_email'));
            }
        } else {
            return Redirect::to('forgot-password')->with('message',  trans('authentication.msg_errors_occured')
                    )->withErrors($validator)->withInput();
        }
    }
       public function reset_password($token = '') {
        // dd('stoiooop');

        if (\Auth::check())
            return Redirect::to('dashboard');

        $user = User::where('reminder', '=', $token);
        if ($user->count() >= 1) {
            return view('auth.reset')->with(array('verCode' => $token));
        } else {
            return Redirect::to('forgot-password')->with('message', trans('authentication.msg_cant_find_reset_code'));
            // return Redirect::to('forgot-password')->with('message', Lang::get('messages.cant_find_your_reset_code'));
        }
    }

    public function doreset(Request $request, $token = '') {
        //  dd('stop');
        $rules = array(
            'password' => 'required|alpha_num|between:6,12|confirmed',
            'password_confirmation' => 'required|alpha_num|between:6,12'
        );

        $messages = array(
            'password.required' => trans('authentication.this_field_is_required'),
            'password.confirmed' => trans('authentication.password_mismatch'),
            'password_confirmation.required' => trans('authentication.this_field_is_required'),
            'password.alpha_num' => trans('authentication.must_be_alpha_numeric'),
            'password.between' => trans('authentication.the_password_bwn_6_and_12_characters'),
            'password_confirmation.required' => trans('authentication.the_password_confirmation_field_is_required'),
            'password_confirmation.between' => trans('authentication.the_password_bwn_6_and_12_characters'),
            'password_confirmation.alpha_num' => trans('authentication.must_be_alpha_numeric'),
        );
        //  $messages = array(
        //     'password.required' => 'This field is Required',
        //     'password.confirmed' => 'Password Mismatch',
        //     'password_confirmation.required' => 'This field is required',
        //     'password.alpha_num' => 'Must be alpha numeric',
        //     'password.between' => 'Password must between 6 and 12 charachters',
        //     'password_confirmation.required' => 'confirmation field is required',
        //     'password_confirmation.between' => 'Password must between 6 and 12 charachters',
        //     'password_confirmation.alpha_num' => 'Must be alpha numeric',
        // );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $user = User::where('reminder', '=', $token);
            if ($user->count() >= 1) {
                $data = $user->get();
                $user = User::find($data[0]->id);
                $user->reminder = '';
                $user->password = \Hash::make($request->input('password'));
                $user->save();
            }

            return Redirect::to('login')->with('message', trans('authentication.msg_password_updated'));
        } else {
            return Redirect::to('password/reset/' . $token)->with('message', trans('authentication.msg_error_occurred')
                    )->withErrors($validator)->withInput();
        }
    }
}