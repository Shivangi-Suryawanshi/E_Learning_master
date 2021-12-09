@extends('company.layouts.app-company') @section('additional_styles')
<link
    rel="stylesheet"
    href="{{ asset('users/vendor/select2/select2.min.css') }}"
/>
@endsection @section('content')

<div class="page-content">
    <header>
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-0">Change Password</h1>
            </div>
        </div>
    </header>

    <div class="row">
        <div class="col-md-12" id="addforce">
            <div class="alert alert-success msgalt" style="display: none">
                @if (Session::has('message'))
                <span>{!! Session::get('message') !!}</span>

                @endif ff
            </div>
            <form
                class="h-100"
                @submit.prevent="onSubmit"
                v-if="!success"
                method="post"
                id="compsnyChangePassword"
            >
                {{ csrf_field() }}

                <div class="panel panel-light">
                    <div class="panel-header">
                        <h1 class="panel-title">Enter Details</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Current Password</label>
                                    <input
                                        type="password"
                                        name="current_password"
                                        class="form-control"
                                        tabindex="1"
                                        placeholder="Current Password"
                                        autocomplete="off"
                                        onkeyup="$(this).next('span').html('');"
                                    />
                                    <span class="current_password_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">New Password</label>
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        tabindex="2"
                                        placeholder="New Password"
                                        autocomplete="off"
                                        onkeyup="$(this).next('span').html('');"
                                    />
                                    <span class="password_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        tabindex="3"
                                        placeholder="Confirm Password"
                                        autocomplete="off"
                                        onkeyup="$(this).next('span').html('');"
                                    />
                                    <span
                                        class="password_confirmation_error"
                                    ></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary px-5">
                            Save
                        </button>
                    </div>
                </div>
                <!-- / States -->
            </form>
        </div>
        <!-- .col-md-12 -->
    </div>
</div>

@endsection @section('additional_scripts')

<script type="text/javascript">
    $(".changePasswordbtn").click(function (e) {
        var form = $("#compsnyChangePassword");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: "{!! URL::to('change-password') !!}",
            data: form.serialize(),
            beforeSend: function () {
                jQuery(".c_loading", form).show();
                // $(".msgalt").hide();
            },
            success: function (data) {
                //console.log(data);
                $(".c_error", form).html("");
                if (data.fail) {
                    console.log(data.errors);
                    $.each(data.errors, function (index, value) {
                        var errorDiv = "." + index + "_error";
                        $(errorDiv, form).addClass("c_error");
                        $(errorDiv).empty().append(value);
                    });
                    $(".c_loading", form).hide();
                }
                if (data.success) {
                    $(".c_loading", form).hide();
                    $(".msgalt").show();
                    $("#compsnyChangePassword")[0].reset();
                }
            }, //success
        });
    });
</script>
@endsection
