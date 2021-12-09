@extends('layouts.admin')   




@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-pencil-square-o"></i> Edit Module</h1>
            </div>
            @if(can('browse_module'))
            <a class="btn btn-success" href="{{url('admin/module')}}"><i class="fa fa-list"></i>Module Lists</a>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Edit module</h3>
                    <form method="post" action="{{url('admin/module/edit/'.$module->id)}}" id="editModule" name="editModule">
                        <div class="row">
                            <div class="col-lg-6">
                                {{csrf_field()}}
                                <div class="form-group @if($errors->first('name')) has-danger @endif">
                                    <label for="name">Module name</label>
                                    <input class="form-control @if($errors->first('name')) is-invalid @endif" id="name" name="name" type="text" placeholder="Enter module name" required autocomplete="off" value="{{$module->name}}">
                                    @if($errors->first('name'))
                                        <sapn class="form-control-feedback">{{$errors->first('name')}}</sapn>
                                    @endif
                                </div>
                                <div class="form-group @if($errors->first('perifix')) has-danger @endif">
                                    <label for="perifix">Perifix</label>
                                    <input class="form-control @if($errors->first('perifix')) is-invalid @endif" id="perifix" type="text" readonly value="{{$module->perifix}}">
                                    @if($errors->first('perifix'))
                                        <sapn class="form-control-feedback">{{$errors->first('perifix')}}</sapn>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit">Submit</button>
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
        $("#editModule").validate({
            rules: {
                // simple rule, converted to {required:true}
                perifix: "required",
                name: "required",
            }
        });
    </script>
@endsection