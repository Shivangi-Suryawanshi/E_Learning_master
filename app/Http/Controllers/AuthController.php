<?php

namespace App\Http\Controllers;

use App\EmailTemplates;
use App\Functionality;
use App\Http\Middleware\Instructor;
use App\InstructorTrainer;
use App\Mail\SendPasswordResetLink;
use App\Mail\UserRegistrationMail;
use App\Subscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function login()
    {
// dd('hai');
        $title = __t('login');
        return view('login', compact('title'));
    }

    public function loginPost(Request $request)
    {

// dd('ha');
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $this->validate($request, $rules);

        $credential = [
            'email'     => $request->email,
            'password'     => $request->password
        ];

        if (Auth::attempt($credential, $request->remember_me)) {
            $auth = Auth::user();
            // dd($auth);
            if ($request->_redirect_back_to) {
                return redirect($request->_redirect_back_to);
            }
            if ($auth->isAdmin()  || $auth->user_type == 'sub-admin' || $auth == 'trainer') {
// dd('jjjj');
                Session::put('redirect_url', route('dashboard'));
                return redirect()->intended(route('admin'));
            } elseif ($auth->user_type == "company" || $auth->user_type == "contractor" || $auth->user_type == "project-manager") {
                Session::put('company_id', $auth->id);
                Session::put('redirect_url', route('company'));
                return redirect()->intended(route('company'));
            } else {
                Session::put('redirect_url', route('dashboard'));
                return redirect()->intended(route('dashboard'));
            }
        }


        return redirect()->back()->with('error', __t('login_failed'))->withInput($request->input());
    }


    public function register($userType = "student", Request $request)
    {
        
        $type = $request->type;
        $userTypes = array("company", "training-center", "instructor", "student", "sub-admin", "contractor", "trainer", "project-manager");
        if (in_array($userType, $userTypes) || $type) {
            if ($type != null) {
                $userType = $type;
            }
            $title = __t('signup');

            return view('register', compact('title', 'userType'));
        }
        abort(404);
    }

    public function registerPost(Request $request)
    {

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => [
                'required',
                            'min:8',              // must be at least 6 characters in length
                            'regex:/[a-z]/',      // must contain at least one lowercase letter
                            'regex:/[A-Z]/',      // must contain at least one uppercase letter
                            'regex:/[0-9]/',      // must contain at least one digit
                            // 'regex:/[@$!%*#?&]/', // must contain a special character
                        ],
                    ];

                    $messages = [

                   'password.regex' => 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, <br> 1 Lowercase, 1 Numeric and <br> 1 special character',
                    ];

                    $this->validate($request, $rules,$messages);

                    $userTypes = array("company", "instructor", "student", "sub-admin", "contractor", "trainer", "project-manager");

                    $userType = $request->get('user_as');
                    $userRole = "";
                    if ($userType == "sub-admin") {
                        $userRole = 2;
                    } elseif ($userType == "company") {
                        $userRole = 3;
                    } elseif ($userType == "instructor") {
                        $userRole = 4;
                    } elseif ($userType == "student") {
                        $userRole = 6;
                    } elseif ($userType == "contractor") {
                        $userRole = 8;
                    } elseif ($userType == "trainer") {
                        $userRole = 5;
                    } elseif ($userType == "project-manager") {
                        $userRole = 7;
                    }

                    if (in_array($userType, $userTypes)) {
                        if ($userType == "contractor") {
                //if auth user company addeded contractor check package limit 
                            $auth = Auth::user();
                            if ($auth->user_type == "company") {
                                $functionality = Functionality::where('slug', 'contractor')->first();
                                $checkUserSubscription = Subscription::join(
                                    'subscription_functionalities',
                                    'subscription_functionalities.subscription_id',
                                    'subscriptions.id'
                                )
                                ->where([
                                    ['subscriptions.user_id', Auth::user()->id],
                                    ['subscription_functionalities.functionality_id', $functionality->id]
                                ])->first();
                                if ($checkUserSubscription != null  && $checkUserSubscription->count > 0) {
                                    $companyContractorCount = User::where('parent_company', $auth->id)->get()->count();
                                    if ($checkUserSubscription != null) {
                                        if ($checkUserSubscription->count == $companyContractorCount) {
                                            return redirect()->back()->with('message', 'Your contractor limit is exceed...plese renew package');
                                // return response()->json([
                                //   'status' => false,
                                //   'message' => "Your contractor limit is exceed...plese renew package",
                                //   // 'data' => $checkUserSubscription
                                // ], 200);
                                        }
                                    } else {
                                        return redirect()->back()->with('message', "can't add contractor now ...please subscribe package");
                            //   return response()->json([
                            //     'status' => false,
                            //     'message' => "can't add contractor now ...please subscribe package",
                            //     // 'data' => $checkUserSubscription
                            //   ], 200);
                                    }
                                }

                    //end check contractor package

                            }
                        }


                        $user = User::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'user_type' => $request->user_as,
                            'active_status' => 1,
                            'role' => $userRole
                        ]);

            // $sendEmail = 'sandeep@yarddiant.com';
            // $userInfo = \App\User::find(6);
            Mail::to($user->email)->queue(new UserRegistrationMail('register-notification', $user));
                        if (Auth::check()) {
                            if (Auth::user()->user_type == "instructor" || Auth::user()->user_type == "admin") {
                                if ($userType == "trainer") {
                        // dd($userType);
                                    $instructorTrainer = new  InstructorTrainer();
                                    $instructorTrainer->instructor_user_id = Auth::user()->id;
                                    $instructorTrainer->trainer_user_id = $user->id;
                                    $instructorTrainer->save();
                                    // dd($instructorTrainer);
                                    return redirect('dashboard/trainers');
                                }
                            }
                        }
                        if ($user) {
                            if ($userType == "sub-admin") {
                                return redirect('admin/users?filter_user_group=sub-admin');
                            }
                            if ($userType == "contractor") {
                    //if auth user company addeded contractor check package limit 



                    //end check contractor package
                                $contractor = User::find($user->id);
                                $contractor->parent_company = Auth::user()->id;
                                $contractor->verification_status = 1;
                                $contractor->profile_completion_status = 1;
                                $contractor->save();
                                return redirect('company/sub-contractor');
                            }
                            if ($userType == "project-manager") {
                                $contractor = User::find($user->id);
                                $contractor->parent_company = Auth::user()->id;
                                $contractor->verification_status = 1;
                                $contractor->profile_completion_status = 1;
                                $contractor->save();

                                return redirect('company/project-manager');
                            }
                            $this->loginPost($request);
                            if ($userType == "company") {
                    // Notification  section 
                                $user = 1;
                                $notification = "New company admin $request->name registered ";
                                $model_id = Auth::user()->id;
                                $model = "company-register";
                                userNotification($user, $notification, $model_id, $model);
                    // return redirect('company/add-profile');
                                return redirect('company-landing');
                            }
                            if ($userType == "student") {
                                return redirect('dashboard/settings');
                            }
                        }
            // $registrationTemp= EmailTemplates::where('key','Register')->first();

                        return back()->with('error', __t('failed_try_again'))->withInput($request->input());
                    }
        // dd($request->all());
                }

                public function logoutPost()
                {
                    Session::flush();
                    Auth::logout();
                    return redirect('/');
                }

                public function forgotPassword()
                {
                    $title = __t('forgot_password');
                    return view(theme('auth.forgot_password'), compact('title'));
                }

                public function sendResetToken(Request $request)
                {
                    $this->validate($request, ['email' => 'required']);

                    $email = $request->email;


                    $user = User::whereEmail($email)->first();

                    if (!$user) {
                        return back()->with('error', __t('email_not_found'));
                    }

                    $user->reset_token = str_random(32);
        //  $user->token = $request->input('_token');
                    $user->save();

                    $data = array(
                        'token' => $user->reset_token,
                        'user_name' => $user->name,
                        'to' => $request->input('email')
                    );


                    Mail::to($user->email)->queue(new UserRegistrationMail('user-password-reset', $data));
                    return Redirect::to('forgot-password')->with('message', 'Please check your mail!');

        // try {
        //     Mail::to($email)->send(new SendPasswordResetLink($user));
        // } catch (\Exception $e) {
        //     return back()->with('error', $e->getMessage());
        // }
                }

                public function passwordResetForm()
                {
                    $title = __t('reset_your_password');
                    return view(theme('auth.reset_form'), compact('title'));
                }

                public function passwordReset(Request $request, $token)
                {
                    if (config('app.is_demo')) {
                        return redirect()->back()->with('error', 'This feature has been disable for demo');
                    }
                    $rules = [
                        'password'  => 'required|confirmed',
                        'password_confirmation'  => 'required',
                    ];
                    $this->validate($request, $rules);

                    $user = User::whereResetToken($token)->first();
                    if (!$user) {
                        return back()->with('error', __t('invalid_reset_token'));
                    }

                    $user->password = Hash::make($request->password);
                    $user->save();

                    return redirect(route('login'))->with('success', __t('password_reset_success'));
                }

    /**
     * Social Login Settings
     */

    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function redirectTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }
    public function redirectLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function callbackFacebook()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
            $user = $this->getSocialUser($socialUser, 'facebook');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }

    public function callbackGoogle()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            $user = $this->getSocialUser($socialUser, 'google');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }
    public function callbackTwitter()
    {
        try {
            $socialUser = Socialite::driver('twitter')->user();
            $user = $this->getSocialUser($socialUser, 'twitter');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }
    public function callbackLinkedIn()
    {
        try {
            $socialUser = Socialite::driver('linkedin')->user();
            $user = $this->getSocialUser($socialUser, 'linkedin');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }

    public function getSocialUser($providerUser, $provider = '')
    {
        $user = User::whereProvider($provider)->whereProviderUserId($providerUser->getId())->first();

        if ($user) {
            return $user;
        } else {

            $user = User::whereEmail($providerUser->getEmail())->first();
            if ($user) {

                $user->provider_user_id = $providerUser->getId();
                $user->provider = $provider;
                $user->save();
            } else {
                $user = User::create([
                    'email'             => $providerUser->getEmail(),
                    'name'              => $providerUser->getName(),
                    'user_type'         => 'user',
                    'active_status'     => 1,
                    'provider_user_id'  => $providerUser->getId(),
                    'provider'          => $provider,
                ]);
            }

            return $user;
        }
    }
}
