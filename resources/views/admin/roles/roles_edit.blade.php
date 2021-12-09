@extends('layouts.admin')   




@section('content')
<div class="page-content">
	<form method="post" action="{{url('role/edit/'.$role->id)}}" name="editRole" id="editRole">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-6">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="display_name">Display name</label>
                                    <input class="form-control" id="display_name" name="display_name" type="text" placeholder="Enter display name" required autocomplete="off" value="{{$role->display_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="name">Role</label>
                                    <input class="form-control" id="name" type="text" name="name" placeholder="Enter role" autocomplete="off" readonly value="{{$role->name}}">
                                </div>
                            </div>
                        </div>
                        <h5>Permission</h5>

                        <div class="animated-checkbox">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <tbody>

                                <?php
                                $role_permissions = (isset($role)) ? $role->permissions->pluck('key')->toArray() : [];
                                ?>
                                @foreach(App\Models\Permission::all()->groupBy('table_name') as $table => $permission)
                                    <tr>
                                        <th>
                                            <label>
                                            <input type="checkbox" id="{{$table}}" class="permission-group">
                                            <span class="label-text">{{ucfirst(str_replace('_',' ', $table))}}</span>
                                            </label>
                                        </th>
                                        @foreach($permission as $perm)
                                            <td>

                                                <label>
                                                    <input type="checkbox" id="permission-{{$perm->id}}" name="permissions[]" class="the-permission" value="{{$perm->id}}" @if(in_array($perm->key, $role_permissions)) checked @endif>
                                                    <span class="label-text">{{ucfirst(str_replace('_', ' ', $perm->key))}}</span>
                                                </label>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
</div>
@endsection
@section('additional_scripts')
<script>
        $("#editRole").validate({
            rules: {
                // simple rule, converted to {required:true}
                display_name: "required",
                name: "required",
            }
        });
    </script>

    <script>
        $('document').ready(function () {

            $('.permission-group').on('change', function(){
                $(this).parents('tr').find(".the-permission").prop('checked', this.checked);
            });

            function parentChecked(){
                $('.permission-group').each(function(){
                    var allChecked = true;
                    $(this).parents('tr').find(".the-permission").each(function(){
                        if(!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function(){
                parentChecked();
            });
        });
    </script>
@endsection
