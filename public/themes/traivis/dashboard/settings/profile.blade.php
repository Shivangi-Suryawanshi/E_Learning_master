<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-top: 3px !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {

        font-size: 1rem;

    }


    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: inline-block;
        overflow: hidden;
        padding-left: 8px;
        text-overflow: ellipsis;
        height: 34px !important;
        box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
        border: 1px solid #e2e5ec !important;
        white-space: nowrap;
        font-size: 1rem;
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

    #acc .active {
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

</style>

@extends(theme('dashboard.layouts.dashboard'))
<link rel="stylesheet" href="{{ asset('users/vendor/select2/select2.min.css') }}">
@section('content')

    <div class="dashboard-inline-submenu-wrap mb-4 border-bottom">
        <div class="pb15" id="acc">
            <a href="{{ route('profile_settings') }}" class="active ptab">Profile Settings</a>
            <a href="{{ route('profile_reset_password') }}" class="ptab">Password Reset</a>
        </div>
    </div>


    <div class="profile-settings-wrap">

        <h5 class="mb-3">&nbsp;&nbsp;Profile Information</h5>

        <form action="" method="post" enctype="multipart/form-data">
            @csrf

            @php
                $user = $auth_user;
                $countries = countries();
            @endphp


            <div class="profile-basic-info bg-white p-3">

                <div class="form-row">
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>{{ __t('name') }}</label>
                        <input type="tel" class="form-control" name="name" value="{{ $user->name }}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>

                    {{-- <div class="form-group col-md-6 {{ $errors->has('job_title') ? ' has-error' : '' }}">
                        <label>{{__t('job_title')}}</label>
                        <input type="text" class="form-control" name="job_title" value="{{$user->job_title}}">
                        @if ($errors->has('job_title'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('job_title') }}</strong></span>
                        @endif
                    </div> --}}

                    <div class="form-group col-md-6">
                        <label>{{ __t('phone') }}</label>
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label>{{ __t('address') }}</label>
                        <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{ __t('address_2') }}</label>
                        <input type="text" class="form-control" name="address_2" value="{{ $user->address_2 }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>{{ __t('city') }}</label>
                        <input type="text" class="form-control" name="city" value="{{ $user->city }}">
                    </div>

                    <div class="form-group col-md-2">
                        <label>{{ __t('zip') }}</label>
                        <input type="text" class="form-control" name="zip_code" value="{{ $user->zip_code }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputState">{{ __t('country') }}</label>

                        <select class="form-control" name="country_id">
                            <option value="">Choose...</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ selected($user->country_id, $country->id) }}>
                                    {!! $country->name !!}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-9">
                        <label>{{ __t('about_me') }}</label>
                        <textarea class="form-control" name="about_me" rows="5">{{ $user->about_me }}</textarea>
                    </div>

                    <div class="form-group col-md-3">
                        <label>{{ __t('profile_photo') }}</label>
                        {{-- {!! image_upload_form('photo', $user->photo) !!} --}}
                        <div class="choose-img-div">
                            <img class="profile_pic" name="profile_pic" id="profile_pic" width="150" height="auto"
                                src="@if ($user->profile_pic) {!! asset('assets/profile_pics/' . $user->profile_pic) !!}
                        @else {!! asset('assets/images/placeholder-image.png') !!} @endif">
                            <input type="file" name="profile_file" id="profile_file" class="profile_file" accept="image/*"
                                capture style="display:none">
                            <img src="{!! asset('assets/images/file_choose.png') !!}" id="upfile1" class="choose-img" style="cursor:pointer"
                                title="Change Profile Picture" />
                        </div>
                    </div>

                </div><br>
                <!-- Sandeep added - 24dec2020 -->
                <div class="form-row">
                    <div class="form-group col-md-12">

                        <h5 class="panel-title">&nbsp;Work Experience and Education </h5>

                        <label> &nbsp;&nbsp;Tell us about your experience and education to get a personalized learning
                            experience with course recommendations.</label>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label>{{ __t('prefered_study_language') }}</label>
                            <select class="form-control" id="prefered_study_language" name="prefered_study_language[]"
                                data-toggle="select2" data-search="true" multiple>
                                @foreach (all_languages() as $language)
                                    <option @if (in_array($language->id, $individualLanguages)) selected="" @endif value="{{ $language->id }}">
                                        {{ $language->en_language }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">{{ __t('highest_level_of_education') }}</label>
                            <select name="highest_degree" id="highest_degree" class="form-control js-example-basic-single">
                                <option value="">-Select-</option>
                                @foreach ($highest_degrees as $highest_degree)
                                    <option @if ($indUser && $indUser->highest_degree_id == $highest_degree->id) selected @endif value="{{ $highest_degree->id }}">
                                        {{ $highest_degree->en_degree }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="">{{ __t('university') }}</label>
                            <input type="text" name="university" id="university" class="form-control"
                                placeholder="University" value="@if ($indUser &&
                                $indUser->university) {{ $indUser->university }} @endif">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">{{ __t('field_or_major') }} </label>
                            <select name="major" id="major" class="form-control">
                                <option value="">-Select-</option>
                                @if ($major_fields)
                                    @foreach ($major_fields as $major)
                                        <option @if ($indUser && $indUser->major_id == $major->id) selected @endif value="{{ $major->id }}">
                                            {{ $major->en_major }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">Employemt Status</label>
                            <select name="employment_status" id="employment_status" class="form-control">
                                <option value="">-Select-</option>
                                <option value="1" @if ($currentJob && $currentJob->employment_status == 1) selected @endif>Currently working</option>
                                <option value="2" @if ($currentJob && $currentJob->employment_status == 2) selected @endif>Worked in past</option>
                                <option value="3" @if ($currentJob && $currentJob->employment_status == 3) selected @endif>Unemployed</option>
                                <option value="4" @if ($currentJob && $currentJob->employment_status == 4) selected @endif>Student</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">Industry *</label>
                            <select id="job_industry" name="job_industry" data-toggle="select2" data-search="true"
                                class="form-control js-example-basic-single">
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->en_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="" style="color: red">Job location</label>
                            {{-- <input type="text" name="current_job_location" id="current_job_location" class="form-control" placeholder="Location of company"> --}}
                            <select class="form-control" name="current_job_location">
                                <option value="">Choose...</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ selected($user->country_id, $country->id) }}>
                                        {!! $country->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="">Employer</label>
                            <input type="text" name="current_employer" id="current_employer" class="form-control"
                                value="@if ($currentJob) {{ $currentJob->employer }} @endif" placeholder="Employer">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">Occupation *</label>
                            <select id="current_occupation" name="current_occupation" data-toggle="select2"
                                data-search="true" class="form-control js-example-basic-single">

                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}">{{ $occupation->en_occupation }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputState">Select your relevant experience level</label>
                            <select name="current_experience_level" id="current_experience_level" class="form-control">
                                <option value="1">Entry-level</option>
                                <option value="2">Intermediate</option>
                                <option value="3">Mid-level</option>
                                <option value="4">Senior or executive-level</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Open to new job opportunities?</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="">
                                        <input type="radio" @if ($indUser && $indUser->new_job_preference == 1) checked @endif name="new_job_preference" value="1">
                                        <label class="" for="custom-radio-2-1"> Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="">
                                        <input type="radio" @if ($indUser && $indUser->new_job_preference == 0) checked @endif name="new_job_preference" value="0">
                                        <label class="" for="custom-radio-2-2"> No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- If yes to new job opportunities show the below section --}}
                    <div class="col-md-6 mb15 newjob hide">
                        <div class="form-group">
                            <label for="inputState" style="color: red;">Prefered Job Location **</label>
                            {{-- <input type="text" name="preferred_location" id="preferred_location" class="form-control" placeholder="Tell us the city, state, or country you want to work in"> --}}
                            <select class="form-control" name="preferred_location">
                                <option value="">Choose...</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ selected($user->country_id, $country->id) }}>
                                        {!! $country->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb15 newjob hide">
                        <div class="form-group">
                            <label for="">Preferred Industry</label>
                            <select id="preferred_industry" name="preferred_industry[]" data-toggle="select2"
                                data-search="true" class="form-control js-example-basic-single" multiple>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}" @if (in_array($industry->id, $individualIndustries)) selected="" @endif>{{ $industry->en_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb15 newjob hide">
                        <div class="form-group">
                            <label for="inputState">Preferred occupation</label>
                            <select id="preferred_occupation" name="preferred_occupation[]" data-toggle="select2"
                                data-search="true" class="form-control js-example-basic-multiple" multiple>
                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}" @if (in_array($occupation->id, $individualOccupation)) selected="" @endif>
                                        {{ $occupation->en_occupation }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb15 newjob hide">
                        <div class="form-group">
                            <label for="">Preferred experience level</label>
                            <select name="preferred_exp_level" id="preferred_exp_level" class="form-control">
                                <option value="1">Entry-level</option>
                                <option value="2">Intermediate</option>
                                <option value="3">Mid-level</option>
                                <option value="4">Senior or executive-level</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mb15">
                        <div class="form-group">
                            <label for="">Skills Wanted</label>
                            <select id="skills_wanted" name="skills_wanted[]" data-toggle="select2" data-search="true"
                                class="form-control js-example-basic-single" multiple>
                                @foreach ($skills as $skill)
                                    <option @if (in_array($skill->id, $individualSkillsWanted)) selected="" @endif value="{{ $skill->id }}">
                                        {{ $skill->en_skill }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mb15">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Career Goals</label>
                            <textarea name="career_goal" id="career_goal" class="form-control" id="" rows="4"
                                placeholder="Tell us what you're looking for next in your career to find new opportunities">@if ($indUser && $indUser->career_goal) {{ $indUser->career_goal }} @endif</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 mb15">
                        <div class="form-group">
                            <label for="">Career Goals Privacy</label>
                            <label for="">(Only me)</label>
                            <input type="checkbox" id="goal_privacy" name="goal_privacy" @if ($indUser && $indUser->goal_privacy == 1) checked @endif
                                value="1">
                        </div>
                    </div>

                </div>


                <div class="panel panel-light h-auto" id="cpe">
                    <div class="panel-header">
                        <h5 class="panel-title">Details About You</h5>

                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <label> Introduce yourself to the Traivis community. Connect with learners like you to grow your
                                network.</label>


                            <div class="tab-pane fade show active" id="user-profile-tab-1" aria-expanded="true">
                                <div class="mx-auto">
                                    <div class="row">
                                        <div class="col-md-12 mb15">
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Tell us about yourself, such as
                                                    what you do, what your interests are, and what you hope to get out of
                                                    your courses.</label>
                                                <textarea name="self_intro" id="self_intro" class="form-control" id=""
                                                    rows="4"
                                                    placeholder="Self introduction">@if ($indUser && $indUser->self_intro) {{ $indUser->self_intro }} @endif</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb15">
                                            <div class="form-group">
                                                <label>Location</label>
                                                {{-- <input type="text" name="living_location" id="living_location" class="form-control" placeholder="Tell us the city, state, or country you currently live in." value="@if ($indUser && $indUser->living_location) {{ $indUser->living_location }} @endif"> --}}
                                                <select class="form-control" name="living_location">
                                                    <option value="">Choose...</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" @if (isset($indUser->living_location)) {{ selected($indUser->living_location, $country->id) }} @endif>
                                                            {!! $country->name !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb15">
                                            <div class="form-group">
                                                <label for="">Top Skills</label>
                                                <select id="top_skills" name="top_skills[]" data-toggle="select2"
                                                    data-search="true" class="form-control js-example-basic-single"
                                                    multiple>
                                                    @foreach ($skills as $skill)
                                                        <option @if (in_array($skill->id, $individualTopSkills)) selected="" @endif
                                                            value="{{ $skill->id }}">{{ $skill->en_skill }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6 mb15">
                                            <div class="form-group">
                                                <label for="inputState">Website URL</label>
                                                <input type="text" name="website_url" id="website_url" class="form-control"
                                                    value="@if ($indUser && $indUser->website_url) {{ $indUser->website_url }} @endif"
                                                placeholder="Website URL">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb15">
                                            <div class="form-group">
                                                <label for="">Phone Number* </label>
                                                <input type="text" name="phone_number" id="phone_number"
                                                    class="form-control" value="@if ($indUser &&
                                                    $indUser->phone_number) {{ $indUser->phone_number }} @endif" placeholder="(for a verification purpose) ">
                                            </div>
                                        </div>
                                        {{-- insta fb linked in
                 twitter --}}
                                        <div class="col-md-6 mb15">
                                            <div class="form-group">
                                                <label for="inputState">Gender</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="">-Select-</option>
                                                    <option @if ($indUser && $indUser->gender == 1) selected @endif value="1">Female </option>
                                                    <option @if ($indUser && $indUser->gender == 2) selected @endif value="2">Male </option>
                                                    <option @if ($indUser && $indUser->gender == 3) selected @endif value="3">I'd rather not say
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb15">
                                            <div class="form-group">
                                                <label for="">Birthday* </label>
                                                <input type="date" name="dob" id="dob" class="form-control"
                                                    placeholder="Month Day Year ">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb15">
                                            <div class="form-group">
                                                <label for="">Personal information privacy* </label>
                                                <label for="">(Only me)</label>
                                                <input type="checkbox" name="personal_privacy" id="personal_privacy"
                                                    value="1">
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb15">
                                            <div class="form-group">
                                                <label for="">Note: Discussion forum posts and peer review submissions will
                                                    always show your name and profile image to other learners in your
                                                    courses. Course ratings and reviews you submit may show your profile
                                                    image to anyone viewing our website.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group text-right">
                                                <input type="hidden" id="user_id" name="user_id" value="">
                                                <input type="hidden" id="individual_id" name="individual_id" value="">
                                                <input type="hidden" id="current_job_id" name="current_job_id" value="">
                                                <input type="hidden" id="preferred_job_id" name="preferred_job_id" value="">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- end added -->


    </div>

    <div class="container">
        <h4 class="my-4">Social Link </h4>


        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Website</label>
                <input type="text" class="form-control" name="social[website]"
                    value="{{ $user->get_option('social.website') }}">
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Twitter</label>
                <input type="text" class="form-control" name="social[twitter]"
                    value="{{ $user->get_option('social.twitter') }}">
            </div>
            <div class="form-group col-md-3">
                <label>Facebook</label>
                <input type="text" class="form-control" name="social[facebook]"
                    value="{{ $user->get_option('social.facebook') }}">
            </div>
            <div class="form-group col-md-3">
                <label>Linkedin</label>
                <input type="text" class="form-control" name="social[linkedin]"
                    value="{{ $user->get_option('social.linkedin') }}">
            </div>
            {{-- <div class="form-group col-md-4">
                    <label>Youtube</label>
                    <input type="text" class="form-control" name="social[youtube]" value="{{$user->get_option('social.youtube')}}" >
                </div> --}}
            <div class="form-group col-md-3">
                <label>Instagram</label>
                <input type="text" class="form-control" name="social[instagram]"
                    value="{{ $user->get_option('social.instagram') }}">
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
@endsection
