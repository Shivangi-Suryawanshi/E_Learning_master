@extends('company.layouts.app-company')
@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('users/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .mb15 {
            margin-bottom: 15px;
        }

        .mt20 {
            margin-top: 20px;
        }

    </style>
@endsection
@section('content')



    <div class="page-content">
        <div id="app">
            <main class="">



                <div class="alert alert-success msgalt" id="successMsg" style="display:none;">
                    <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a><span
                        id='insSuccess'></span>
                </div>



                <div class="container">
                    <div class="panel panel-light h-auto">



                        <div class="panel-body">
                            <form name="" id="companyReg" enctype="multipart/form-data" method="POST"
                                action="{{ URL('company/update-profile') }}" class="form-horizontal"
                                @submit.prevent="onSubmit">




                                <div class="container">

                                    <div class="row">
                                        <div class="col-md-12">

                                            <ul class="nav nav-tabs tabs-underlined" id="custom-tabs-list" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tab-1" data-toggle="tab"
                                                        href="#custom-tab-content-1" role="tab"
                                                        aria-controls="custom-tab-content-1"
                                                        aria-selected="true">English</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tab-2" data-toggle="tab"
                                                        href="#custom-tab-content-2" role="tab"
                                                        aria-controls="custom-tab-content-2"
                                                        aria-selected="false">Arabic</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <input type="hidden" id="def_lan" name="def_lan" value="en">
                                        <input type="hidden" id="companyId" name="companyId" value="{{ $company->id }}">
                                        <div class="col-lg-12">
                                            {{ csrf_field() }}





                                            <div class="tab-content p-4" id="custom-tabs-content">
                                                <div class="tab-pane fade active show" id="custom-tab-content-1"
                                                    role="tabpanel" aria-labelledby="custom-tab-1">


                                                    <div class="['form-group', errors.company_name_en ? 'has-error' : '']"
                                                        style="margin-bottom:15px;">
                                                        <label for="company_name_en">{{ __t('company_name_en') }}</label>
                                                        <input id="company_name_en" name="company_name_en"
                                                            value="{{ $company->en_company_name }}" autofocus="autofocus"
                                                            class="form-control" type="text" v-model="form.company_name_en">

                                                        <!-- <span v-if="errors.company_name_en" :class="['label label-danger']">@{{ errors . company_name_en[0] }}</span> -->
                                                        <span class="text-danger">
                                                            <strong id="company_name_enerror"
                                                                style="color: #d00505;"></strong>
                                                        </span>
                                                    </div>



                                                    <div class="form-group @if ($errors->
                                                        first('description')) has-danger @endif
                                                        not-external">
                                                        <label for="description">{{ __t('about_name_en') }}</label>
                                                        <textarea class="form-control @if ($errors->first('description')) is-invalid @endif" name="abt_company_en" id="abt_company_en" rows="3">{{ $company->en_about_company }}</textarea>
                                                        @if ($errors->first('description'))
                                                            <span
                                                                class="form-control-feedback">{{ $errors->first('description') }}</span>
                                                        @endif
                                                    </div>


                                                </div>






                                                <div class="tab-pane fade" id="custom-tab-content-2" role="tabpanel"
                                                    aria-labelledby="custom-tab-2">
                                                    <div :class="['form-group', errors.company_name_ar ? 'has-error' : '']"
                                                        style="margin-bottom:15px;">
                                                        <label for="company_name_ar">{{ __t('company_name_ar') }}</label>
                                                        <input id="company_name_ar" name="company_name_ar"
                                                            value="{{ $company->ar_company_name }}" autofocus="autofocus"
                                                            class="form-control" type="text" v-model="form.company_name_ar">
                                                        <span class="text-danger">
                                                            <strong id="company_name_arerror"
                                                                style="color: #d00505;"></strong>
                                                        </span>


                                                        <!-- <span v-if="errors.company_name_ar" :class="['label label-danger']">@{{ errors . company_name_ar[0] }}</span> -->
                                                    </div>

                                                    <div class="form-group @if ($errors->
                                                        first('abt_company_ar')) has-danger @endif
                                                        not-external">
                                                        <label for="abt_company_ar">{{ __t('about_name_ar') }}</label>
                                                        <textarea class="form-control @if ($errors->first('abt_company_ar')) is-invalid @endif" name="abt_company_ar" id="abt_company_ar" rows="3">{{ $company->en_about_company }}</textarea>
                                                        @if ($errors->first('abt_company_ar'))
                                                            <span
                                                                class="form-control-feedback">{{ $errors->first('abt_company_ar') }}</span>
                                                        @endif
                                                    </div>


                                                </div>

                                            </div>



                                            <div class="row">
                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('name')) has-error @endif">

                                                        <img class="profile_pic" name="profile_pic" id="profile_pic"
                                                            width="150" height="auto" src="@if ($company->logo) {!!
                                                        asset('uploads/company_logos/' . $company->logo) !!}
                                                    @else {!! asset('admin/img/administrator.png') !!} @endif">
                                                        <label class="lc">{{ __t('upload_logo') }}</label>
                                                        <div class="form-group">

                                                            <input type="file" name="profile_file" id="profile_file"
                                                                class="profile_file form-textbox" accept="image/*" capture
                                                                style="display:none">


                                                            <span id="upfile1" class="btn btn-primary"><i
                                                                    class="fa fa-upload"
                                                                    aria-hidden="true"></i>{{ __t('select_logo') }} </span>

                                                        </div>
                                                        <span
                                                            class="help-block required">{{ $errors->first('name') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('address')) has-danger @endif
                                                        not-external">
                                                        <label for="description">{{ __t('company_address') }}</label>
                                                        <textarea class="form-control @if ($errors->first('address')) is-invalid @endif" name="address" id="address" rows="3">{{ $company->address }}</textarea>

                                                    </div>
                                                </div>


                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('role')) has-error @endif">
                                                        <label for="naame">{{ __t('country') }}</label>
                                                        <select name="country" class="form-control">
                                                            @foreach ($countries as $country)
                                                                <option @if ($company->country_id == $country->id) selected @endif
                                                                    value="{{ $country->id }}">{{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span
                                                            class="help-block required">{{ $errors->first('country') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('pre_language')) has-error @endif">
                                                        <label for="naame">{{ __t('prefered_language') }}</label>
                                                        <select name="pre_language[]"
                                                            class="form-control js-example-basic-multiple"
                                                            multiple="multiple">
                                                            @foreach ($all_languages as $language)
                                                                <option @if (in_array($language->id, $companyLanguages)) selected="" @endif
                                                                    value="{{ $language->id }}">
                                                                    {{ $language->en_language }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span
                                                            class="help-block required">{{ $errors->first('pre_language') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('role')) has-error @endif">
                                                        <label for="naame">{{ __t('industry') }}</label>
                                                        <select name="industry[]"
                                                            class="form-control js-example-basic-multiple"
                                                            multiple="multiple">
                                                            @foreach ($industries as $industry)
                                                                <option @if (in_array($industry->id, $companyIndustries)) selected="" @endif
                                                                    value="{{ $industry->id }}">
                                                                    {{ $industry->en_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span
                                                            class="help-block required">{{ $errors->first('industry') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('role')) has-error @endif">
                                                        <label for="naame">{{ __t('occupation') }}</label>
                                                        <select name="occupation[]"
                                                            class="form-control js-example-basic-multiple"
                                                            multiple="multiple">
                                                            @foreach ($occupations as $occupation)
                                                                <option @if (in_array($occupation->id, $companyOccupations)) selected="" @endif
                                                                    value="{{ $occupation->id }}">
                                                                    {{ $occupation->en_occupation }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span
                                                            class="help-block required">{{ $errors->first('occupation') }}</span>
                                                    </div>
                                                </div>



                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('website')) has-danger @endif">
                                                        <label for="company_name_en"><b>{{ __t('website') }}</b></label>
                                                        <input class="form-control @if ($errors->first('website')) is-invalid @endif" id="website" name="website" type="text"
                                                        placeholder="Enter Website" autocomplete="off"
                                                        value="{{ $company->website }}">
                                                        @if ($errors->first('website'))
                                                            <span
                                                                class="form-control-feedback">{{ $errors->first('website') }}</span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('role')) has-error @endif">
                                                        <label for="naame">{{ __t('newsletter_status') }}</label>
                                                        <select name="newsletter" class="form-control">
                                                            <option value="">Select</option>
                                                            <option @if ($company->newsletter_status == 1) selected @endif value="1">
                                                                {{ __t('subscribe') }}</option>
                                                            <option @if ($company->newsletter_status == 0) selected @endif value="0">
                                                                {{ __t('unsubscribe') }}</option>

                                                        </select>
                                                        <span
                                                            class="help-block required">{{ $errors->first('newsletter') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt20 mb15">
                                                    <div>
                                                        <h1 class="panel-title">{{ __t('contact_person') }}</h1>
                                                        <hr>

                                                    </div>
                                                </div>



                                                <div class="col-md-6 mb15">
                                                    <div :class="['form-group', errors.cfirstname ? 'has-error' : '']">
                                                        <label for="cfirstname">{{ __t('first_name') }}</label>

                                                        <input id="cfirstname" name="cfirstname"
                                                            value="{{ $contact_details->contact_first_name }}"
                                                            autofocus="autofocus" class="form-control" type="text"
                                                            v-model="form.cfirstname">
                                                        <!-- <span v-if="errors.firstname" :class="['label label-danger']">@{{ errors . firstname[0] }}</span> -->
                                                        <span class="text-danger">
                                                            <strong id="cfirstnameerror" style="color: #d00505;"></strong>
                                                        </span>

                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div :class="['form-group', errors.clastname ? 'has-error' : '']">
                                                        <label for="clastname">{{ __t('last_name') }}</label>
                                                        <input id="clastname" name="clastname"
                                                            value="{{ $contact_details->contact_last_name }}"
                                                            autofocus="autofocus" class="form-control" type="text"
                                                            v-model="form.clastname">

                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div class="form-group">
                                                        <label for="">{{ __t('gender') }}</label>
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div
                                                                    class="custom-control custom-radio custom-radio-inverse-2 d-block mb-2">
                                                                    <input type="radio" @if ($contact_details->gender == '2') checked="" @endif
                                                                        name="gender" class="custom-control-input"
                                                                        id="custom-radio-inverse-2-1" value="2">
                                                                    <label class="custom-control-label"
                                                                        for="custom-radio-inverse-2-1">Male</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 ">
                                                                <div
                                                                    class="custom-control custom-radio custom-radio-inverse-2 d-block mb-2">
                                                                    <input type="radio" @if ($contact_details->gender == '1') checked="" @endif
                                                                        name="gender" class="custom-control-input"
                                                                        id="custom-radio-inverse-2-2" value="1">
                                                                    <label class="custom-control-label"
                                                                        for="custom-radio-inverse-2-2">Female</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div class="form-group">
                                                        <label for="">{{ __t('dob') }}</label>
                                                        <input type="date" name="dob" class="form-control"
                                                            value="@if ($contact_details->dob) {{ Carbon\Carbon::parse($contact_details->dob)->format('d-m-Y') }} @endif">
                                                    </div>
                                                </div>


                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('position')) has-danger @endif">
                                                        <label for="position"><b>{{ __t('position') }} </b></label>
                                                        <input class="form-control @if ($errors->first('position')) is-invalid @endif" id="position" name="position" type="text"
                                                        placeholder="Enter Position Name" autocomplete="off"
                                                        value="{{ $contact_details->position }}">
                                                        @if ($errors->first('position'))
                                                            <span
                                                                class="form-control-feedback">{{ $errors->first('position') }}</span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-md-6 mb15">
                                                    <div :class="['form-group', errors.cemail ? 'has-error' : '']">
                                                        <label for="cemail"><b>{{ __t('email') }}</b></label>
                                                        <input id="cemail" name="cemail"
                                                            value="{{ $contact_details->email_id }}"
                                                            autofocus="autofocus" class="form-control" type="text"
                                                            v-model="form.cemail">
                                                        <!-- <span v-if="errors.email" :class="['label label-danger']">@{{ errors . email[0] }}</span> -->
                                                        <span class="text-danger">
                                                            <strong id="cemailerror" style="color: #d00505;"></strong>
                                                        </span>

                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb15">
                                                    <div class="form-group @if ($errors->
                                                        first('cphone')) has-danger @endif">
                                                        <label for="cphone"><b> {{ __t('phone') }}</b></label>
                                                        <input type="text" name="cphone"
                                                            value="{{ $contact_details->phone }}"
                                                            class="form-control @if ($errors->first('cphone')) is-invalid @endif" placeholder="Phone*">
                                                        <span class="text-danger">
                                                            <strong id="cphoneerror" style="color: #d00505;"></strong>
                                                        </span>
                                                    </div>
                                                </div>






                                                <input type="text " hidden value="{{ $id }}" class="userId">
                                                <div class="col-md-12 mb15" align="left">
                                                    <div class="tile-footer">
                                                        <i data-id="1" class="btn btn-primary status-change">Accept </i>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb15" align="right">
                                                    <div class="tile-footer">
                                                        <i data-id="0" class="btn btn-success status-change"> Reject </i>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>


                            </form>


                        </div>
                    </div>
                </div>


            </main>
        </div>
    @endsection
    @section('additional_scripts')
        <script src="{{ asset('users/js/pages/form/extended/select2.js') }}"></script>
        <script src="{{ asset('users/vendor/select2/select2.full.min.js') }}"></script>
        <script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
       $('.js-example-basic-multiple').select2();
  });
  
  </script>
  {{--<script>
    $("#profile_file").change(function(){
      readURL(this);
    });
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
  
        reader.onload = function (e) {
          $('#profile_pic').attr('src', e.target.result);
        }
  
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#upfile1").click(function () {
      $("#profile_file").trigger('click');
    });
  
    $("#custom-tab-1").click(function () {
        $('#def_lan').val('en');
  });
  $("#custom-tab-2").click(function () {
      $('#def_lan').val('ar');
  });
  </script>
  <script>
    $(document).ready(function(){
    
     $('#companyReg').on('submit', function(event){
      event.preventDefault();
      $.ajax({
       url:"{{URL('company/update-profile')}}",
       method:"POST",
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
        if(data.status==true)
        {
    
         $('#successMsg').css('display','block');
         $('#insSuccess').html(data.message);
          // $("#companyReg").trigger("reset");
             $('html, body').animate({
            scrollTop: $("#app").offset().top
        }, 2000);
        }
        if(data.errors) {
    
            
            console.log(data.errors);
    
            if(data.errors.firstname){
      $( '#firstnameerror' ).html( data.errors.firstname[0] );
    }
    else
    {
      $( '#firstnameerror' ).hide();    
    }
    
    if(data.errors.company_name_en){
      $( '#company_name_enerror' ).html( data.errors.company_name_en[0] );
    }
    else
    {
      $( '#company_name_enerror' ).hide();    
    }
    
    if(data.errors.company_name_ar){
     
      $( '#company_name_arerror' ).html( data.errors.company_name_ar[0] );
    }
    else
    {
      $( '#company_name_arerror' ).hide();    
    }
    
    if(data.errors.email){
      $( '#emailerror' ).html( data.errors.email[0] );
    }
    else
    {
      $( '#emailerror' ).hide();    
    }
    if(data.errors.password){
      $( '#passworderror' ).html( data.errors.password[0] );
    }
    else
    {
      $( '#passworderror' ).hide();
    }
    if(data.errors.password_confirmation){
      $( '#password_confirmation' ).html( data.errors.password_confirmation[0] );
    }
    else
    {
      $( '#password_confirmation' ).hide();
    }
    
    
    }
    $('html, body').animate({
            scrollTop: $("#app").offset().top
        }, 2000);
       }
      })
     });
    
    });
    </script> --}}

        {{-- accept --}}
        <script>
            $('.status-change').on('click', function() {
                var url = ROOT_URL + "admin/company-status-change";
                var id = $('.userId').val();
                var status = $(this).data('id')
                console.log(id, status);
                $.ajax({
                    url: url,
                    type: "post",

                    data: {
                        id: id,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#successMsg').css('display', 'block');
                        $('#insSuccess').html(data.message);
                        $('html, body').animate({
                            scrollTop: $("#app").offset().top
                        }, 2000);
                    },
                    error: function(data) {

                    }
                })
            });

        </script>
    @endsection
