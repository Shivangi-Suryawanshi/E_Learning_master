<style>
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: inline-block;
        overflow: hidden;
        padding-left: 8px;
        text-overflow: ellipsis;
        height: 40px !important;
        box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
        border: 1px solid #e2e5ec !important;
        white-space: nowrap;
    }

    .select2-container--default .select2-selection--multiple {
        background-color: white;
        border: 1px solid #e2e5ec !important;
        border-radius: 4px;
        cursor: text;
    }



    .pb15 {
        padding-bottom: 30px !important;
        margin-top: 30px;
    }

    .ptab {
        color: #000;
        padding: 10px 20px 10px 10px;
        border-radius: 5px;
        box-shadow: 0px 0 2px 0 #666666;
    }

    #bactive .active {
        box-shadow: 0px 0 7px 0 #666666;
        font-weight: 600;
    }



    .form-control {
        display: block;
        width: 100%;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #e2e5ec !important;
        border-radius: .25rem;
        box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
        box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
        border: 1px solid #e2e5ec !important;
    }


    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 35px;
    }

    .img-thumbnail {
        width: 25% !important;
    }

    .input-group-text {
        background: #000 !important;
        color: #fff !important;
    }

    label {

        font-size: .92rem !important;
        font-weight: 400 !important;
        color: #646c9a !important;
    }

    @media screen and (max-width: 460px) {

        .ptab {
            color: #000;
            padding: 0px 1px 0px 0px;
            border-radius: 0px;
            margin-right: 40px;
            box-shadow: 0px 0 0px 0 #666666;
            ;
        }

        .active {
            font-weight: 600;
            border-bottom: 1px solid #000;
            box-shadow: 0px 0 0px 0 #666666;
        }

    }

    .upload-group input[type="file"] {
        display: none;
    }

    .upload-group .upload-btn span {
        line-height: 38px;
        display: inline-block;
        height: 38px;
        padding: 0 10px;
        background: #000;
        border-radius: 3px;
        color: #fff;
    }

    .upload-group .file-name {
        width: 230px;
        height: 40px;
        border-radius: 3px;
        padding: 0 10px;
        border: 2px solid #ced4da;
    }

</style>

@extends(theme('dashboard.layouts.dashboard'))
<link rel="stylesheet" href="{{ asset('users/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('myadmin/datepicker/css/bootstrap-datepicker.css') }}">
@section('content')

    <div class="dashboard-inline-submenu-wrap mb-4 border-bottom">
        <div class="pb15" id="bactive">
            <a href="{{ route('profile_settings') }}" class="active ptab">Profile Settings</a>
            <a href="{{ route('profile_reset_password') }}" class="ptab">Password Reset</a>
        </div>
    </div>


    <div class="profile-settings-wrap">

        <h5 class="mb-3">&nbsp;&nbsp;Profile Information</h5>

        <form action="{{ URL::to('/dashboard/settings/tr-profile') }}" method="post" enctype="multipart/form-data">
            @csrf

            @php
                $user = $auth_user;
                $countries = countries();
            @endphp


            <div class="profile-basic-info bg-white p-3">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                value="{{ $user->name }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Location of living</label>
                            <select class="form-control" name="country_id">
                                <option value="">Choose...</option>
                                @foreach ($countries as $country)
                                    <option @if (isset($tcUser->country_id) && $tcUser->country_id == $country->id) selected @endif value="{{ $country->id }}">
                                        {!! $country->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>{{ __t('profile_photo') }}</label>
                        {{-- {!! image_upload_form('photo', $user->photo) !!} --}}
                        <div class="choose-img-div">
                            <img class="profile_pic" name="profile_pic" id="profile_pic" width="150" height="auto"
                                src="@if ($user->profile_pic) {!! asset('assets/profile_pics/' . $user->profile_pic) !!}
                        @else
                            {!! asset('assets/images/placeholder-image.png') !!} @endif">
                            <input type="file" name="profile_file" id="profile_file" class="profile_file" accept="image/*"
                                capture style="display:none">
                            <img src="{!! asset('assets/images/file_choose.png') !!}" id="upfile1" class="choose-img" style="cursor:pointer"
                                title="Change Profile Picture" />
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="form-group" style="padding-top:20px;">
                            <label for="inputState">Website URL</label>
                            <input type="text" name="website_url" id="website_url" class="form-control" value="@if ($tcUser && $tcUser->website_url) {{ $tcUser->website_url }} @endif" placeholder="Website URL">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Prefered Teaching Approach</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="">
                                        <input type="radio" @if ($tcUser && $tcUser->teaching_approach == 1) checked @endif name="teaching_approach" value="1">
                                        <label class="" for="custom-radio-2-1"> Online</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="">
                                        <input type="radio" @if ($tcUser && $tcUser->teaching_approach == 2) checked @endif name="teaching_approach" value="2">
                                        <label class="" for="custom-radio-2-2"> Classroom</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="">
                                        <input type="radio" @if ($tcUser && $tcUser->teaching_approach == 3) checked @endif name="teaching_approach" value="3">
                                        <label class="" for="custom-radio-2-2"> Both</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Sandeep added - 24dec2020 -->


                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label>{{ __t('prefered_study_language') }}</label>
                            <select class="form-control" id="prefered_study_language" name="prefered_study_language[]"
                                data-toggle="select2" data-search="true" multiple>
                                @foreach (all_languages() as $language)
                                    <option @if (in_array($language->id, $tcLanguages)) selected="" @endif value="{{ $language->id }}">
                                        {{ $language->en_language }}</option>
                                @endforeach
                            </select>
                        </div>




                    </div>
                    <div class="form-group col-md-6">
                        <label>Accreditations</label>

                        <div class="upload-group choose-img-div">

                            <input type="file" name="accr" id="accr" class="accr">
                            <input class="file-name" type="text" placeholder="Browse" readonly="">
                            <label class="upload-btn" for="accr">
                                <span>Upload File</span>
                            </label>
                            @if ($tcUser && $tcUser->accr) <b>File</b> :
                                {{ $tcUser->accr }}
                            @endif
                            <br>(Note: upload the accreditation certificates in PDF,JPG,PNG or GIF)
                        </div>



                        {{-- {!! image_upload_form('photo', $user->photo) !!} --}}
                        {{-- <div class="choose-img-div">

                            <input type="file" name="accr" id="accr" class="accr">
                            @if ($tcUser && $tcUser->accr) <b>File</b> :
                                {{ $tcUser->accr }} @endif
                            <br>(Note: upload the accreditation certificates in PDF,JPG,PNG or GIF)
                        </div> --}}
                    </div>



                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">Industry *</label>
                            <select id="job_industry" name="job_industry" data-toggle="select2" data-search="true"
                                class="form-control js-example-basic-single">
                                @foreach ($industries as $industry)
                                    <option @if (isset($tcUser->job_industry) && $industry->id == $tcUser->job_industry) selected @endif value="{{ $industry->id }}">
                                        {{ $industry->en_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>




                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">Occupation *</label>
                            <select id="current_occupation" name="current_occupation" data-toggle="select2"
                                data-search="true" class="form-control js-example-basic-single">

                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}">{{ $occupation->en_occupation }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Phone Number* </label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="@if ($tcUser && $tcUser->phone_number) {{ $tcUser->phone_number }} @endif"
                            placeholder="">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Do you want to receive a newsletter?</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="">
                                        <input type="radio" @if ($tcUser && $tcUser->receive_newsletter == 1) checked @endif name="receive_newsletter" value="1">
                                        <label class="" for="custom-radio-2-1"> Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="">
                                        <input type="radio" @if ($tcUser && $tcUser->receive_newsletter == 0) checked @endif name="receive_newsletter" value="0">
                                        <label class="" for="custom-radio-2-2"> No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employment Status</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="">
                                        <input type="radio" @if ($tcUser && $tcUser->employment_status == 1) checked @endif name="employment_status" value="1">
                                        <label class="" for="custom-radio-2-1"> Active</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="">
                                        <input type="radio" @if ($tcUser && $tcUser->employment_status == 0) checked @endif name="employment_status" value="0">
                                        <label class="" for="custom-radio-2-2"> Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>











                    {{-- insta fb linked in
                   twitter --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputState">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">-Select-</option>
                                <option @if ($tcUser && $tcUser->gender == 1) selected @endif value="1">Female
                                </option>
                                <option @if ($tcUser && $tcUser->gender == 2) selected @endif value="2">Male </option>
                                <option @if ($tcUser && $tcUser->gender == 3) selected @endif value="3">I'd rather not
                                    say
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Birthday* </label>
                            <input type="text" name="dob" id="start_date" class="form-control" value="@if ($tcUser && $tcUser->dob) {{ $tcUser->dob }} @endif" placeholder="">
                        </div>
                    </div>




                    <div class="container">
                        <h4 class="my-4">Social Link </h4>



                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Twitter</label>
                                <input type="text" class="form-control" name="social[twitter]" value="@if ($tcUser && $tcUser->twitter) {{ $tcUser->twitter }} @endif"
                                >
                            </div>
                            <div class="form-group col-md-3">
                                <label>Facebook</label>
                                <input type="text" class="form-control" name="social[facebook]" value="@if ($tcUser && $tcUser->facebook) {{ $tcUser->facebook }} @endif" >
                            </div>
                            <div class="form-group col-md-3">
                                <label>Linkedin</label>
                                <input type="text" class="form-control" name="social[linkedin]" value="@if ($tcUser && $tcUser->linkedin) {{ $tcUser->linkedin }} @endif">
                            </div>

                            <div class="form-group col-md-3">
                                <label>Instagram</label>
                                <input type="text" class="form-control" name="social[instagram]" value="@if ($tcUser && $tcUser->instagram) {{ $tcUser->instagram }} @endif" >
                            </div>
                        </div>
                    </div>

                </div> <!-- end added -->
            </div>


    </div>




    <button type="submit" class="btn btn-primary"> Update Profile</button>
    <br><br>
    </form>


    </div>
    </div>


@endsection


@section('page-js')
    <script src="{{ asset('assets/js/filemanager.js') }}"></script>
    <script>
        $("#profile_file").change(function() {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profile_pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#upfile1").click(function() {
            $("#profile_file").trigger('click');
        });

    </script>
    <script src="{{ asset('users/js/pages/form/extended/select2.js') }}"></script>
    <script src="{{ asset('users/vendor/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $('.js-example-basic-multiple').select2();
        });

    </script>
    <script src="{{ asset('myadmin/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#start_date').datepicker({
                'todayHighlight': true,
                dateFormat: 'Y-m-d',
                clearBtn: true,
                autoclose: true,
            });
        });

    </script>


    <script>
        $(document).ready(function() {
            $("input:file").on("change", function() {
                var target = $(this);
                var relatedTarget = target.siblings(".file-name");
                var fileName = target[0].files[0].name;
                relatedTarget.val(fileName);
            });
        });

    </script>


@endsection
