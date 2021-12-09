@extends(theme('dashboard.layouts.dashboard'))


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('courses_has_quiz')}}">{{__t('courses')}}</a></li>
            <li class="breadcrumb-item"> <a href="{{route('courses_quizzes', $quiz->course_id)}}">{{__t('quizzes')}}</a></li>
            <li class="breadcrumb-item"> <a href="{{route('quiz_attempts', $quiz->id)}}">{{__t('quiz_attempts')}} </a> </li>
            <li class="breadcrumb-item active">{{__t('review')}}</li>
        </ol>
    </nav>

    @php
        $attempts = $quiz->attempts()->with('user', 'quiz', 'course')->orderBy('ended_at', 'desc')->get();
    @endphp

    @if( $attempts->count())

        <table class="table table-bordered bg-white table-striped">

            <tr>
                <th>#</th>
                <th>{{__t('quiz_taker')}}</th>
                <th></th>
            </tr>

            @foreach($attempts as $attempt)

                <tr>
                    <td>#</td>
                    <td>
                      @if($attempt->user)  <p class="mb-3">{{$attempt->user->name}}</p> @endif

                      @if($attempt->quiz)  <p class="mb-0 text-muted">
                            <strong>{{__t('quiz')}} : </strong> <a href="{{$attempt->quiz->url}}">{{$attempt->quiz->title}}</a>
                        </p>
                        @endif
                        @if($attempt->course)
                        <p class="mb-0 text-muted">
                            <strong>{{__t('course')}} : </strong> <a href="{{$attempt->course->url}}">{{$attempt->course->title}}</a>
                        </p>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('attempt_detail', $attempt->id)}}" class="btn btn-dark-blue py-0">{{__t('review')}}</a>
                    </td>
                </tr>

            @endforeach

        </table>

    @else
        {!! no_data() !!}
    @endif

@endsection
