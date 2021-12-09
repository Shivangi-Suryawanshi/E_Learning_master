@extends(theme('dashboard.layouts.dashboard'))


@section('content')

<div class="page-header">
    <h5 class="page-header-left mt5"> My quiz attempts </h5>
    <hr>
</div>

    @php
        $attempts = $auth_user->my_quiz_attempts()->with('user', 'quiz', 'course')->orderBy('ended_at', 'desc')->get();
    @endphp

    @if( $attempts->count())

        <table class="table table-bordered bg-white table-striped">

            <tr>
                <th>#</th>
                <th>{{__t('details')}}</th>
            </tr>

            @foreach($attempts as $attempt)

                <tr>
                    <td>#</td>
                    <td>
                        <p class="mb-3">{{$attempt->user->name}}</p>
                        @if($attempt->quiz)
                        <h6 class="text-muted">
                            <strong>{{__t('quiz')}} : </strong> <a href="{{$attempt->quiz->url}}">{{$attempt->quiz->title}}</a>
                        </h6>
                        @endif
                        @if($attempt->course)
                        <h6 class="mb-0 text-muted">
                            <strong>{{__t('course')}} : </strong> <a href="{{$attempt->course->url}}">{{$attempt->course->title}}</a>
                        </h6>
                        @endif
                    </td>
                </tr>

            @endforeach

        </table>

    @else
        {!! no_data() !!}
    @endif

@endsection
