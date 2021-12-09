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

</style>

@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="dashboard-inline-submenu-wrap mb-4 border-bottom">
        <div class="pb15" id="acc">
            <a href="{{ route('profile_settings') }}" class="ptab">{{ __t('profile_settings') }}</a>
            <a href="{{ route('profile_reset_password') }}" class="active ptab">{{ __t('reset_password') }}</a>
        </div>
    </div>


    <div class="profile-settings-wrap">


        <form action="{{ route('profile_reset_password') }}" method="post">
            @csrf

            <div class="profile-basic-info bg-white p-3">

                <div class="form-row">
                    <div class="form-group col-md-4 {{ form_error($errors, 'old_password')->class }}">
                        <label>{{ __t('old_password') }}</label>
                        <input type="tel" class="form-control" name="old_password">
                        {!! form_error($errors, 'old_password')->message !!}
                    </div>

                    <div class="form-group col-md-4 {{ form_error($errors, 'new_password')->class }}">
                        <label>{{ __t('new_password') }}</label>
                        <input type="tel" class="form-control" name="new_password">
                        {!! form_error($errors, 'new_password')->message !!}
                    </div>

                    <div class="form-group col-md-4 {{ form_error($errors, 'new_password_confirmation')->class }}">
                        <label>{{ __t('new_password_confirmation') }}</label>
                        <input type="tel" class="form-control" name="new_password_confirmation">
                        {!! form_error($errors, 'new_password_confirmation')->message !!}
                    </div>

                </div>


                <button type="submit" class="btn btn-primary"> Update Profile</button>


            </div>



        </form>


    </div>


@endsection
