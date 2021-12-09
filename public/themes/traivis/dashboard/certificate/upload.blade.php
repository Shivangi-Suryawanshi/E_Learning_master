@extends(theme('dashboard.layouts.dashboard'))

<style>
    .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.upload-btn-wrapper {

    border: 1px solid gray;
    color: gray;
    background-color: white;
    padding: 6px 35px 6px 35px;
    border-radius: 5px;
    font-size: 15px;
    font-weight: bold;

}

.upload-btn-wrapper input[type="file"] {
  font-size: 50px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}

    </style>


@section('content')
    <div class="container-fluid">


        <table class="table table-bordered  table">
            <h4>{{ $course->title }}</h4>
            <tbody>
                <tr>
                    <td>
                        <p class="mb-3">
                        </p>
                        <div class="row">
                            @if ($completeCourse)
                                @foreach ($completeCourse as $courseComplete)

                                <div class="col-md-4">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="course-list-lectures-counts text-muted form-group col-md-8">
                                            @if(Auth::user()->user_type != "student")

                                            <strong title="completed user">
                                                @if ($courseComplete->completedUser)
                                                    {{ ucwords($courseComplete->completedUser->name) }}
                                                @endif
                                            </strong>
                                            @endif
                                            <br><br>
                                            <input type="hidden" value="{{ $courseComplete->user_id }}" name="user_id"
                                                id="">
                                            <input type="hidden" value="{{ $courseComplete->completed_course_id }}"
                                                name="completed_course_id" id="">
                                                @if(Auth::user()->user_type != "student")
                                                <div class="upload-btn-wrapper">
                                                    Choose File
                                            <input type="file" class="form-control" name="file" id="">
                                                </div>
                                                @endif
                                                <br>
                                                {{-- <div class="row">
                                                <div class="col-md-6"> --}}
                                                
                                            @if (count($course->courseCertificate($courseComplete->user_id, $courseComplete->completed_course_id)))

                                                @foreach ($course->courseCertificate($courseComplete->user_id, $courseComplete->completed_course_id) as $keys => $certificate)
                                                    @if($certificate->user_id == Auth::user()->id && $certificate->status == 1)
                                                    <h3>Certificate</h3>
                                               <small>click here to download </small> <a target="_blank" href="{{asset('media/certificate/'.$certificate->certificate)}}">{{$certificate->certificate}} </a>
                                               @endif
                                               @if(Auth::user()->user_type != "student")
                                               <a target="_blank" href="{{asset('media/certificate/'.$certificate->certificate)}}">{{$certificate->certificate}}
                                               @endif
                                               @endforeach
                                                @else
                                                <Strong> Certificate Not Found </Strong>
                                             @endif
                            
                                        {{-- </div>
                                    </div> --}}
                                            <br>
                                            @if(Auth::user()->user_type != "student")
                                            <input type="submit" class="btn btn-primary" value="upload">
                                            @endif
                                        </div>
                                    </form>
                                </div>

                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
@endsection
