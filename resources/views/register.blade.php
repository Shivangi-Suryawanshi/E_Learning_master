@extends('layouts.website')

<style>
    .login-content .login-form {
    text-align: left !important;
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')

 <!-- Start Login Area -->
 <section class="login-area">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
            <div class="row m-0">
                <div class="col-lg-6 col-md-12 p-0">
                    <div class="login-image hidden-lxs">
                        <img src="assets/img/login.png" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="{{ URL::to('/') }}"><img src="{{asset('assets/img/black-logo.png')}}" alt="image"></a>
                                    </div>

                                    <h3>Open up your <br>Traivis Account Now!</h3>
                                    <p>Already Signed Up <a href="{{ URL::to('/login') }}">login</a></p>

                                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{session('error')}}
                    </div>
                @endif
                                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label ml20"><i class="fa fa-user" aria-hidden="true"></i> {{__t('name')}}</label>

                        <div>
                            <input id="name" type="text" class="form-control shadow2" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
</div>

<div class="col-md-6">

                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label ml20"><i class="fa fa-envelope" aria-hidden="true"></i> {{__t('email_address')}}</label>

                        <div>
                            <input id="email" type="email" class="form-control shadow2" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
</div>


<div class="col-md-6">
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label ml20"><i class="fa fa-eye" aria-hidden="true"></i> {{__t('password')}}</label>

                        <div>
                            <input id="password" type="password" class="form-control shadow2" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong style="font-weight: normal;
    color: #be0303;">{!! $errors->first('password') !!}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
</div>

<div class="col-md-6">
        <div class="form-group">
                        <label for="password-confirm" class="control-label ml20"><i class="fa fa-eye" aria-hidden="true"></i> {{__t('confirm_password')}}</label>

                        <div>
                            <input id="password-confirm" type="password" class="form-control shadow2" name="password_confirmation" required>
                        </div>
                    </div>
</div>

                    {{-- <div class="form-group">
                        <label for="password-confirm" class="control-label ml20">{{__t('i_am')}}</label>

                        <div class="col-md-6">
                            <label class="mr-3"><input type="radio" name="user_as" value="student" {{old('user_as') ? (old('user_as') == 'student') ? 'checked' : '' : 'checked' }}> {{__t('student')}} </label>
                            <label><input type="radio" name="user_as" value="instructor" {{old('user_as') == 'instructor' ? 'checked' : ''}} > {{__t('instructor')}} </label>
                        </div>
                    </div> --}}
                    <input type="hidden" name="user_as" value="@if($userType){{ $userType }}@endif"

                    <div class="form-group">
                        <div class="col-md-12" style="margin-bottom:20px;">
                            <button type="submit" class="btn btn-primary btn-block"> {{__t('register')}} </button>
                        </div>
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















                <!-- @if(session('error'))
                    <div class="alert alert-danger">
                        {{session('error')}}
                    </div>
                @endif -->

           
                        
                        

                <!-- <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label ml20"><i class="fa fa-user" aria-hidden="true"></i> {{__t('name')}}</label>

                        <div class="col-md-12">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label ml20"><i class="fa fa-envelope" aria-hidden="true"></i> {{__t('email_address')}}</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label ml20"><i class="fa fa-eye" aria-hidden="true"></i> {{__t('password')}}</label>

                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="control-label ml20"><i class="fa fa-eye" aria-hidden="true"></i> {{__t('confirm_password')}}</label>

                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    {{-- <div class="form-group row ">
                        <label for="password-confirm" class="control-label ml20">{{__t('i_am')}}</label>

                        <div class="col-md-6">
                            <label class="mr-3"><input type="radio" name="user_as" value="student" {{old('user_as') ? (old('user_as') == 'student') ? 'checked' : '' : 'checked' }}> {{__t('student')}} </label>
                            <label><input type="radio" name="user_as" value="instructor" {{old('user_as') == 'instructor' ? 'checked' : ''}} > {{__t('instructor')}} </label>
                        </div>
                    </div> --}}
                    <input type="hidden" name="user_as" value="@if($userType){{ $userType }}@endif"

                    <div class="form-group ">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block"> {{__t('register')}} </button>
                        </div>
                    </div>
                </form> -->

    @endsection
