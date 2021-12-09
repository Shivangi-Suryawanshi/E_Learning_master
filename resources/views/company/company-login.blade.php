@extends('company.layouts.app-company-auth')
@section('additional_styles')
@endsection
@section('content')
@endsection
<div id="loginApp" class="login-page login-page-9">
   <div class="wrapper bgg">
      <div class="panel-body panel-form">
         <div align="center">
            <img src="{!! asset('users/assets/logo.png') !!}">
         </div>
         <h2 class="form-title"><span class="thin">Welcome to</span> Train Eaze</h2>
         <form autocomplete="off" @submit.prevent="onSubmit" v-if="!success" method="post" id="loginForm">
            {{ csrf_field() }}
            <div class="field-group field-group-vertical field-group-vertical-lining field-group-lg">
               <div :class="['form-group', message ? 'has-error' : '']">
                  <span v-if="message" class="label label-danger">@{{ message }}</span>
               </div>
               <div :class="['form-group', errors.email ? 'has-error' : '']">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text bg-white">
                           <svg id="lnr-envelope" class="svg-muted" width="20"
                              style="margin-top: -3px; "
                              viewBox="0 0 1024 1024">
                              <title>envelope</title>
                              <path class="path1"
                                 d="M896 307.2h-819.2c-42.347 0-76.8 34.453-76.8 76.8v460.8c0 42.349 34.453 76.8 76.8 76.8h819.2c42.349 0 76.8-34.451 76.8-76.8v-460.8c0-42.347-34.451-76.8-76.8-76.8zM896 358.4c1.514 0 2.99 0.158 4.434 0.411l-385.632 257.090c-14.862 9.907-41.938 9.907-56.802 0l-385.634-257.090c1.443-0.253 2.92-0.411 4.434-0.411h819.2zM896 870.4h-819.2c-14.115 0-25.6-11.485-25.6-25.6v-438.566l378.4 252.267c15.925 10.618 36.363 15.925 56.8 15.925s40.877-5.307 56.802-15.925l378.398-252.267v438.566c0 14.115-11.485 25.6-25.6 25.6z"></path>
                           </svg>
                        </span>
                     </div>
                     <input type="text" placeholder="Email Address" class="form-control" id="email" name="email"
                        v-model="form.email">
                  </div>
                  <span v-if="errors.email" class="label label-danger">@{{ errors.email }}</span>
               </div>
               <div :class="['form-group', errors.password ? 'has-error' : '']">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text bg-white">
                           <svg id="lnr-lock" class="svg-muted" width="20"
                              style="margin-top: -3px; "
                              viewBox="0 0 1024 1024">
                              <title>lock</title>
                              <path class="path1"
                                 d="M742.4 409.6h-25.6v-76.8c0-127.043-103.357-230.4-230.4-230.4s-230.4 103.357-230.4 230.4v76.8h-25.6c-42.347 0-76.8 34.453-76.8 76.8v409.6c0 42.347 34.453 76.8 76.8 76.8h512c42.347 0 76.8-34.453 76.8-76.8v-409.6c0-42.347-34.453-76.8-76.8-76.8zM307.2 332.8c0-98.811 80.389-179.2 179.2-179.2s179.2 80.389 179.2 179.2v76.8h-358.4v-76.8zM768 896c0 14.115-11.485 25.6-25.6 25.6h-512c-14.115 0-25.6-11.485-25.6-25.6v-409.6c0-14.115 11.485-25.6 25.6-25.6h512c14.115 0 25.6 11.485 25.6 25.6v409.6z"></path>
                           </svg>
                        </span>
                     </div>
                     <input type="password" name="password" id="password" class="form-control"
                        v-model="form.password">
                  </div>
                  <span v-if="errors.password" class="label label-danger">@{{ errors.password }}</span>
               </div>
            </div>
            <div class="form-group">
               <div class="row">
                  <div class="col-md-6 col-xs-12">
                     <div class="custom-control custom-checkbox custom-checkbox-2">
                        <input type="checkbox" class="custom-control-input" id="remember-me">
                        <label class="custom-control-label pt-1" for="remember-me">Remember Me</label>
                     </div>
                  </div>
                  <div class="col-md-6 col-xs-12 d-flex align-items-center justify-content-end">
                     <a href="#">Forgot your password?</a>
                  </div>
               </div>
            </div>
            <div class="form-group form-group-btns text-center">
               <div class="row no-gutters" align="center">
                  <div class="col-md-12">
                     <input type="hidden" id="redirect_type" value="redirect">
                     <button type="submit" name="submit" id="submit"
                        class="btn btn-block btn-lg shadow-sm btn-rounded btn-primary-3d w80">Log In
                     </button>
                     <div class="form-group text-center">
                        Dont have an acount? <a href="#" class="text-danger font-weight-600">Register Now</a>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@section('additional_scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/global-auth.js') }}"></script>
@endsection