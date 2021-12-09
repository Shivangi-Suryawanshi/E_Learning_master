@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/select2/select2.min.css')}}">
@endsection
@section('content')

<div class="page-content">
    <header>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mb-0">Add New Workforce</h1>
                </div>
            </div>
    </header>

    <div class="row">
        <div class="col-md-12" id="addforce">
            <form class="h-100" @submit.prevent="onSubmit" v-if="!success" method="post" id="workforceForm">
                    {{ csrf_field() }}
                <!-- States -->
                <div class="panel panel-light">
                    <div class="panel-header">
                        <h1 class="panel-title">Enter Details</h1>
                    </div>
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Position</label>
                                    <select id="position" name="position[]" data-toggle="select2" data-search="true" class="form-control" multiple>
                                        <?php  echo company_positions(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Project</label>

                                    <select id="project" name="project" data-toggle="select2" data-search="true" class="form-control">
                                        <option value="">-Select-</option>
                                        <?php  echo company_projects(); ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Department</label>

                                    <select id="department" name="department" data-toggle="select2" data-search="true" class="form-control">
                                        <option value="">-Select-</option>
                                        <?php  echo company_departments(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Work Id</label>
                                    <input type="text" id="work_id" name="work_id" class="form-control">
                                </div>

                            </div>



                        </div>

                    </div>

                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                        {{-- <a href="#" class="btn btn-secondary ml-2">Reset</a> --}}
                    </div>
                </div><!-- / States -->

            </form>

        </div><!-- .col-md-12 -->
    </div>
</div>


@endsection
@section('additional_scripts')
<script src="{{asset('users/vendor/select2/select2.full.min.js')}}"></script>
<script src="{{asset('users/js/pages/form/extended/select2.js')}}"></script>
<script src="{{asset('users/vendor/jquery-validate/jquery.validate.min.js')}}"></script>

<script type="text/javascript">
const app2 = new Vue({
        el: '#addforce',
        data: {
            form: {
                name: '',
                email: '',
            },
            errors: [],
            success : false,
        },
        methods : {
            onSubmit: function(e) {
                var formData = new FormData($("#workforceForm")[0]);
                axios.post(COMPANY_URL+'add-workforce', formData,{
                headers: {
                    //'Content-Type': 'application/json',
                    //'X-CSRF-TOKEN': token.content,
                    //'X-Requested-With': 'XMLHttpRequest',
                    Authorization: 'Bearer ' + localStorage.getItem('access_token'),
                }}).then( response => {

                    if(response.data.status == 'success' ){
                      window.location.reload();
                    }else{
                        app.has_error = true;
                        app.error = res.response.data.message;
                    }

                } ).catch((error) => {
                         //this.errors = error.response.data.errors;
                         this.success = false;
                    });
            }
        }
    });


</script>
@endsection

