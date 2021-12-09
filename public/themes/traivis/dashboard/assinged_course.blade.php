
{{-- {{dd($courseSlug)}} --}}
@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('assinged_course')}} </h4>
       
    </div>

    @if(count($assignedCourse) > 0)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                <th>{{__t('course')}}</th>
                <th>{{__t('assigned_by')}}</th>
                <th>{{__t('action')}}</th>
            </tr>

            @foreach($assignedCourse as $key => $assignedCourseList)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                      
                        <strong>{{ucwords($assignedCourseList->title)}}</strong>&nbsp;   @if($assignedCourseList->courseStatus == 1) <a href="{{url('courses',$assignedCourseList->slug)}}" class="fa fa-eye">  </a>
                     @endif
                    </td>
                    <td>
                        <p class="mb-3">
                            @if($assignedCourseList->author)
                            <strong>Name :{{ucwords($assignedCourseList->author->name)}}</strong>
                           <br>
                            <strong>Email :{{$assignedCourseList->author->email}}</strong>
                           <br>
                           <strong> Role : @if($assignedCourseList->author->user_type == "instructor") Training center  @endif</strong>

                            @endif
                        </p>
                    </td>
                    
                    <td>
                        <p class="mb-3">
                         @if($assignedCourseList->courseStatus == 1)
                            @if($assignedCourseList->status == 1) 
                            <strong>Rejected </strong>
                            @elseif($assignedCourseList->status == 2)
                            <strong> Accepted<strong>
                            @else
                            <a class="btn btn-success status-change" data-id="{{$assignedCourseList->course_assign_id}}" data-content="accept"> Accept </a>
                            <a class="btn btn-danger status-change" data-id="{{$assignedCourseList->course_assign_id}}" data-content="reject"> Reject </a> 
                        @endif
                        @else
                       please Waiting for admin approval
                        @endif
                        </p>
                    </td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
       
    @endif

@endsection
@section('page-js')
    <script>
        $('.status-change').on('click', function()
        {
            var id = $(this).data('id');
            var status = $(this).data('content')
            $.ajax({
                type :"post",
                url: "status-chage-assigned-user",
                data:{id:id,status:status, "_token": "{{ csrf_token() }}",},
                success:function(data)
                {
                     window.location.reload();
                },error:function()
                {

                }
            });
        })
    </script>
@endsection
