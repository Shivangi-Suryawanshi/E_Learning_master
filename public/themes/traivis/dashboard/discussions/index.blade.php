@extends(theme('dashboard.layouts.dashboard'))

<style>

    .fs18 {font-size: 18px !important;}

    </style>


@section('content')

<div class="page-header">
    <h5 class="page-header-left mt5"> Discussions </h5>
    <hr>
</div>

    @php
        $discussions = $auth_user->instructor_discussions()->with('course', 'content')->orderBy('replied', 'asc')->orderBy('updated_at', 'desc')->paginate(20);
//   $courseId = [];
//         if($type == "discution_type" && Auth::user()->user_type == "trainer")
//     {
//         $courseList = App\Course::where('user_id',Auth::user()->id)->get();
//         if($courseList)
//         {
//             foreach ($courseList as $key => $listCourse) {
//                 $courseId[] =$listCourse->id ;
//             }
//         }
        
//     }
    // dd($courseId);
    @endphp

    @if($discussions->count())
        @foreach($discussions as $discussion)
            <div class="discussion-single-wrap border p-3 mb-4 {{$discussion->replied ? 'bg-light-success' : 'bg-white' }} ">
                <div class="discussion-user d-flex mb-4">
                    <div class="reviewed-user-photo">
                        {{-- <a href="{{route('profile', $discussion->user->id)}}">
                            {!! $discussion->user->get_photo !!}
                        </a> --}}
                    </div>
                    <div class="discussion-detials">
                       @if($discussion->user) <a><h4>{!! $discussion->user->name !!}</h4></a>@endif
                        <p class="text-muted mb-0 fs18">
                            <small>{{$discussion->created_at->diffForHumans()}}</small>
                        </p>
                        <p class="text-muted fs18">
                            <a href="{{$discussion->course->url}}" class="text-info fs18" target="_blank">
                                {{$discussion->course->title}}
                            </a>
                            <i class="la la-arrow-right"></i> {{$discussion->content->title}}
                        </p>

                        <a href="{{route('discussion_reply', $discussion->id)}}" class="mb-4 d-block">
                            <h5> <i class="la la-question-circle-o"></i> {{$discussion->title}}</h5>
                        </a>
                        <a href="{{route('discussion_reply', $discussion->id)}}" class="btn btn-primary btn-sm">View Question</a>
                    </div>
                </div>
            </div>

        @endforeach

    @else
        {!! no_data() !!}
    @endif


    {!! $discussions->links() !!}


@endsection
