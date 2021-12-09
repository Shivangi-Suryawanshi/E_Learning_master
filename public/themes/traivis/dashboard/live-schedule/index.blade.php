
{{-- {{dd($courseSlug)}} --}}
@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('live_schedule')}} </h4>
        <a href="{{route('create_live_schedule',$courseSlug)}}" class="btn btn-primary">{{__t('create_live_schedule')}}</a>
    </div>

    @if($live)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                <th>{{__t('section')}}</th>
                <th>{{__t('event_date_time')}}</th>
                <th>{{__t('expiry_date_time')}}</th>
                <th>{{__t('action')}}</th>
            </tr>

            @foreach($live as $key => $schedule)
                <tr>
                    <td>
                        {{$key+1}}
                    </td>
                    <td>
                        @if($schedule->section)
                        <strong>{{$schedule->section->section_name}}</strong>
                        @endif
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{$schedule->event_date_time}}</strong>
                        </p>
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{$schedule->expiry_date_time}}</strong>
                        </p>
                    </td>
                    <td>
                        <p class="mb-3">
                            <a href="{{url('dashboard/courses/live-schedule/edit', $schedule->id)}}" class="font-weight-bold mr-3" ><i class="la la-edit"></i> {{__t('edit ')}} </a>

                        </p>
                    </td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
        <div class="no-data-wrap text-center">
            <a href="{{route('create_course')}}" class="btn btn-lg btn-primary">{{__t('create_course')}}</a>
        </div>
    @endif

@endsection
