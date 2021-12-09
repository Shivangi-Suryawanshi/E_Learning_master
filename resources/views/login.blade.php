@extends('layouts.website')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .login-content .login-form {
    text-align: center;
    max-width: 500px !important;
    margin-left: auto;
    margin-right: auto;
}

.raque-nav .navbar .navbar-nav .nav-item a {
    padding-top:10px !important;
}

@media only screen and (max-width: 991px)
{
.hidden-lxs {display:none !important;}
}

    </style>
@section('content')




 <!-- Start Login Area -->
 <section class="login-area">
            <div class="row m-0">
                <div class="col-lg-6 col-md-12 p-0">
                    <div class="register-image hidden-lxs">
                        <img src="assets/img/login.png" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Welcome Back!</h3>
                                    <p>New to Traivis? <a href="{{url('register/student')}}">Sign Up</a></p>

                                    @include('inc.flash_msg')

                                    <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email" class="col-form-label" style="margin-left:18px;"><i class="fa fa-envelope" aria-hidden="true"></i> {{ __('E-Mail Address') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} shadow2" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-md-12 col-form-label"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} shadow2" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group  mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Login') }}
                                        </button>

                                        <a class="btn btn-link" href="{{ route('forgot_password') }}" style="color: #0045ed;">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                </div>
                            </form>

                                </div>
                            </div>
                        </div>


                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>


                    </div>
                </div>
            </div>
        </section>
        <!-- End Login Area -->









                        <div class="col-md-4">

                            <div class="social-login-wrap mb-4 text-center">
                                @if(get_option('social_login.facebook.enable'))
                                    <a href="{{ route('facebook_redirect') }}" class="social-login-item btn-facebook">
                                        <i class="la la-facebook"></i> Facebook
                                    </a>
                                @endif

                                @if(get_option('social_login.google.enable'))
                                    <a href="{{ route('google_redirect') }}" class="social-login-item btn-google">
                                        <i class="la la-google"></i> Google
                                    </a>
                                @endif

                                @if(get_option('social_login.twitter.enable'))
                                    <a href="{{ route('twitter_redirect') }}" class="social-login-item btn-twitter">
                                        <span class="hidden-xs"><i class="la la-twitter"></i> Twitter</span>
                                    </a>
                                @endif

                                @if(get_option('social_login.linkedin.enable'))

                                    @if(get_option('social_login.twitter.enable'))
                                        <a href="{{ route('linkedin_redirect') }}" class="social-login-item btn-linkedin">
                                            <span class="hidden-xs"><i class="la la-linkedin-square"></i> LinkedIn</span>
                                        </a>
                                    @endif
                                @endif

                            </div>

                        </div>



    @if(config('app.is_demo'))
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="demo-credential-box-wrapper">
                    <h4 class="my-4">Demo Login Credential:</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Admin</strong>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">E-Mail: <code>admin@demo.com</code></p>
                                    <p class="m-0">Password: <code>123456</code></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Instructor</strong>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">E-Mail: <code>instructor@demo.com</code></p>
                                    <p class="m-0">Password: <code>123456</code></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Student</strong>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">E-Mail: <code>student@demo.com</code></p>
                                    <p class="m-0">Password: <code>123456</code></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
    @endsection
