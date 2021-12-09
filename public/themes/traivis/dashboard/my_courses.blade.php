@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex p-2">
        @if (isset($assignedType))
            <h4 class="flex-grow-1">{{ __t('assinged_course') }} </h4>
        @else
            <h4 class="flex-grow-1">{{ __t('my_courses') }} </h4>

        @endif
        {{-- <a href="{{url('dashboard/my-courses?type=live-schedule')}}" class="btn btn-primary">{{__t('live_schedule')}}</a> --}}
        &nbsp;
        @if (isset($assignedType) == false)
            <a href="{{ route('create_course') }}" class="btn btn-primary">{{ __t('create_course') }}</a>
        @endif
    </div>


    @if (isset($assignedType) ? $auth_user->trainerAssignedCourse->count() : $auth_user->courses->count())
        @php
            $courseLoop = isset($assignedType) ? $auth_user->trainerAssignedCourse : $auth_user->courses;
        @endphp
        <table class="table table-bordered bg-white">

            <tr>
                <th>{{ __t('thumbnail') }}</th>
                <th>{{ __t('title') }}</th>
                <th>{{ __t('price') }}</th>
            </tr>

            @foreach ($courseLoop as $course)
                {{-- @php
                $accepted_trainer_id[]= $course->accepted_trainer_id ;
                // dd($accepted_trainer_id);
            @endphp --}}
                <tr>
                    <td>
                        <img src="{{ $course->thumbnail_url }}" width="80" />
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{ $course->title }}</strong>
                            {!! $course->status_html() !!}
                        </p>
                        @if (Auth::user()->user_type == 'trainer')
                            @if ($course->accepted_trainer_id)
                            @if($course->author)
                                <p>Assigned By : {{ ucwords($course->author->name) }}</p>
                                @endif
                            @endif
                        @endif
                        <p class="m-0 text-muted">
                            @php
                                $lectures_count = $course->lectures->count();
                                $assignments_count = $course->assignments->count();
                                $quizzes_count = $course->quizzes->count();
                            @endphp

                            <span class="course-list-lecture-count">{{ $lectures_count }} {{ __t('lectures') }}</span>

                            @if ($assignments_count)
                                , <span class="course-list-assignment-count">{{ $assignments_count }}
                                    {{ __t('assignments') }}</span>
                            @endif
                            @if ($quizzes_count)
                                , <span class="course-list-quiz-count">{{ $quizzes_count }}
                                    {{ __t('quizzes') }}</span>
                            @endif
                        </p>

                        <div class="courses-action-links mt-1">
                            <a href="{{ route('edit_course_information', $course->id) }}" class="font-weight-bold mr-3">
                                <i class="la la-pencil-square-o"></i> {{ __t('edit') }}
                            </a>

                            @if ($course->status == 1)
                                <a href="{{ route('course', $course->slug) }}" class="font-weight-bold mr-3"
                                    target="_blank"><i class="la la-eye"></i> {{ __t('view') }} </a>
                            @else
                                <a href="{{ route('course', $course->slug) }}" class="font-weight-bold mr-3"
                                    target="_blank"><i class="la la-eye"></i> {{ __t('preview') }} </a>
                            @endif
                            {{-- @if ($course->coursePurchaseEmployee)
                            @if ($course->coursePurchaseEmployee->coursePurchaseWorkforces) --}}
                            @if ($course->liveSection)
                                @if ($course->enroll)
                                    <a href="{{ url('dashboard/courses/live-schedule', $course->slug) }}"
                                        class="font-weight-bold mr-3" target="_blank"><i class="la la-eye"></i>
                                        {{ __t('live_schedule') }} </a>
                                @endif
                            @endif
                            {{-- @endif --}}
                            @php do_action('my_courses_list_actions_after', $course); @endphp

                        </div>
                    </td>
                    <td>{!! $course->price_html() !!}</td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5') !!}
        <div class="no-data-wrap text-center">
            <a href="{{ route('create_course') }}" class="btn btn-lg btn-primary">{{ __t('create_course') }}</a>
        </div>
    @endif

@endsection
