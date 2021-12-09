@extends('layouts.admin')




@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-lock"></i> Roles</h1>
            </div>
            {{-- <p class="bs-component text-right">
            
                <a class="btn btn-primary" href="{{url('admin/role/create')}}" role="button">
                    <i class="fa fa-plus-circle"></i>
                    Create Role
                </a>
              
            </p> --}}
        </div>
        @if(can('browse_roles'))
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>Role name</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->display_name}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{date('d M Y h:i A',strtotime($role->created_at))}}</td>
                                <td>
                                    {{-- @if(can('edit_roles')) --}}
                                    <a href="{{url('admin/role/edit/'.$role->id)}}" title="Edit Role"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
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
        @else
           @include('no-permission')
        @endif
    </main>
@endsection

