@extends(theme('dashboard.layouts.dashboard'))


@section('content')
    <div class="container-fluid">
        {{-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('courses_has_quiz') }}">{{ __t('courses') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __t('certificate') }}</li>

            </ol>
        </nav> --}}
        <table class="table table-bordered  table">
            @if(Auth::user()->user_type == "student")
           <strong> <h5>Certificate List</h5> </strong>
            @else
            <strong>   <h5>Certificate Upload</h5>    </strong>
            <br>  
            @endif
            <tbody>
                    @if($completeCourse)
                    @foreach ($completeCourse as $completeCourseItem)
                        <tr>
                            <td>
                                <h4 class="mb-3">
                                   
                                        <a href="">{{ $completeCourseItem->title }}</a>
                                  
                                </h4>
                                <div class="row">
                                    <div class="course-list-lectures-counts text-muted form-group col-md-2">
                                        <strong title="completed user">
                                            <a href="{{route('certificate_upload',$completeCourseItem->completed_course_id)}}" class="btn btn-primary btn-sm">
            @if(Auth::user()->user_type == "student")
           View
            @else 
            Upload Certificate
            @endif
                                            </a>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
            </tbody>
        </table>
    </div>
@endsection
