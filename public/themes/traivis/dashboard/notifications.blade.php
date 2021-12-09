@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('notifications')}} </h4>
    </div>

    @if($getNotifications->count())
        <table class="table table-bordered bg-white">

            <tr>
              <th>Sl</th>
                <th>{{__t('activity')}}</th>
                <th>{{__t('date')}}</th>
                {{-- <th>{{__t('action')}}</th> --}}
            </tr>

            @foreach($getNotifications as $key => $notification)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>                    
                         {{ $notification->notification }}            
                    </td>
                    <td>{{ Carbon\Carbon::parse($notification->created_at)->format('Y M d') }}</td>
                    {{-- <td>                    
                        <a href="{{ URL::to('dashboard/notification/'.$notification->id) }}" class="font-weight-bold mr-3"><i class="la la-eye"></i> {{__t('view')}} </a>          
                   </td> --}}

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
        <div class="no-data-wrap text-center">
            <a href="{{route('create_course')}}" class="btn btn-lg btn-warning">{{__t('create_course')}}</a>
        </div>
    @endif

@endsection
