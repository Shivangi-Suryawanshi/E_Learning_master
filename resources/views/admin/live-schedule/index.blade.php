@extends('layouts.admin')

@section('page-header-right')
    {{-- <a href="{{route('category_create')}}" class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="@lang('admin.category_add')"> <i class="la la-plus"></i> </a>
    <a href="#" class=" ml-1 btn btn-danger btn_delete" data-toggle="tooltip" title="@lang('admin.delete')"><i class="la la-trash-o"></i> </a> --}}
@endsection

@section('content')
<div class="app-title ">
  

</div>
    <div class="row">
        <div class="col-md-12">
            
            
            <form action="" method="post" enctype="multipart/form-data"> @csrf
                @if($live->count())
                    <table class="table table-bordered admin-categories-list">
                        <thead>
                        <tr>
                           <td>Sl</td>
                            <td><strong>@lang('admin.section')</strong></td>
                            <td><strong>@lang('admin.seat_available')</strong></td>
                            <td><strong>@lang('admin.max_num_of_participate')</strong></td>
                            <td><strong>@lang('admin.zoom_link')</strong></td>
                            <td><strong>@lang('admin.event_date_time')</strong></td>
                            <td><strong>@lang('admin.expiry_date_time')</strong></td>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($live as $key =>$schedule)
                          
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>@if($schedule->section) {{$schedule->section->section_name}} 
                                    @if($schedule->section->course) <br>
                                    <small>course :{{$schedule->section->course->title}}  </small> 
                                     @endif @endif</td>
                                <td>{{$schedule->seat_available}}</td>
                                <td>{{$schedule->max_num_of_participate}}</td>
                                <td>{{$schedule->zoom_link}}</td>
                                <td>{{$schedule->event_date_time}}</td>
                                <td>{{$schedule->expiry_date_time}}</td>
                            </tr>
                            
                          @endforeach
                        </tbody>


                    </table>

                @else

                    {!! no_data() !!}

                @endif

            </form>

           

        </div>

    </div>


@endsection


@section('page-js')
    <script type="text/javascript">
        $(document).on('click', '.btn_delete', function(e){
            e.preventDefault();

            var checked_values = [];
            $('.category_check:checked').each(function(index){
                checked_values.push(this.value);
            });

            if (checked_values.length){
                if ( ! confirm('@lang('admin.deleting_confirm')')){
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{route('delete_category')}}',
                    data: { categories: checked_values, _token: pageData.csrf_token},
                    success: function(data){
                        if (data.success){
                            window.location.reload(true);
                        }
                    }
                });
            }
        });

        $(document).on('change', '#category_check_all', function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
