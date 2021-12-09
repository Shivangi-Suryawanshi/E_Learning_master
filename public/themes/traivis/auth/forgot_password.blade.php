@extends('layouts.website')

<!-- Main Content -->
@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">

                <div class="card-body p-5">

                    <h3 class="mb-4">{{__t('reset_your_password')}}</h3>

                    @if(Session::get('message'))
                    <div class="error" align="center" style="color: #02430a;font-weight: bold;">
                                {!! Session::get('message') !!} </div>
    @endif   
    @if(Session::get('error'))
    <div class="error" align="center" style="color: #bb0101;font-weight: bold;">
                {!! Session::get('error') !!} </div>
@endif   

                    <form action="" class="form-horizontal" method="POST">
                        @csrf

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class=" control-label">E-Mail Address</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>


                    <p class="text-muted">Not registered? <a href="{{route('register')}}">Sign Up</a></p>

                </div>


            </div>
        </div>
    </div>
</div>

@endsection
