@extends('layouts.admin')   



@section('content')
<main class="app-content">
    <div class="app-title ">
        <div>
            <h1><i class="fa fa-clone"></i> Modules</h1>
        </div>
        {{--@if(can('add_module'))--}}
<!--       <a class="btn btn-primary" href="{{url('module/create')}}" role="button"><i class="fa fa-plus-circle"></i>Create Module</a>-->
        {{--@endif--}}
       <a class="btn btn-primary text-right" href="{{url('admin/module/create')}}" role="button"><i class="fa fa-plus-circle"></i>Create Module</a>

    </div>
    {{-- @if(can('browse_module')) --}}
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Module Name</th>
                            <th>Perifix</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($modules as $module)
                        <tr>
                            <td>{{$module->name}}</td>
                            <td>{{$module->perifix}}</td>
                            <td>{{date('d M Y h:i A',strtotime($module->created_at))}}</td>
                            <td>
                               {{-- @if(can('edit_module')) --}}
                               <a href="{{url('admin/module/edit/'.$module->id)}}" title="Edit Module"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               {{-- @endif --}}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- @else
        
    @endif --}}
</main>
@endsection


