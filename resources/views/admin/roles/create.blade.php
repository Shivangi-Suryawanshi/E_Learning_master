@extends('layouts.admin')   




@section('content')
  
          
                <h1><i class="fa fa-plus-circle"></i> Create Role</h1>
                <a href="{{route('create_course')}}" target="_blank" class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="@lang('admin.course_add')"> <i class="la la-plus"></i> </a>

            
            @if(can('browse_roles'))
            <a class="btn btn-success ml-4 bbtn" href="{{url('admin/roles')}}"><i class="fa fa-list"></i>Role Lists</a>
            @endif
            <main class="app-content">
       
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                  
                    <form method="post" id="createrRole" name="createrRole" action="{{url('admin/role/create')}}">
                        <div class="row">
                            <div class="col-lg-6">
                                {{csrf_field()}}
                                <div class="form-group @if($errors->first('display_name')) has-danger @endif">
                                    <label for="display_name">Display name</label>
                                    <input class="form-control @if($errors->first('display_name')) is-invalid @endif" id="display_name" name="display_name" type="text" placeholder="Enter display name" autocomplete="off" value="{{old('display_name')}}">
                                    @if($errors->first('display_name'))
                                        <sapn class="form-control-feedback">{{$errors->first('display_name')}}</sapn>
                                    @endif
                                </div>
                                <div class="form-group @if($errors->first('name')) has-danger @endif">
                                    <label for="name">Role</label>
                                    <input class="form-control @if($errors->first('name')) is-invalid @endif" id="name" type="text" name="name" placeholder="Enter role" autocomplete="off" value="{{old('name')}}">
                                    @if($errors->first('name'))
                                        <sapn class="form-control-feedback">{{$errors->first('name')}}</sapn>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('additional_scripts')
    <!--Notifications Message Section-->
  

    <script>
        $("#createrRole").validate({
            rules: {
                // simple rule, converted to {required:true}
                display_name: "required",
                name: "required",
            }
        });
    </script>
@endsection