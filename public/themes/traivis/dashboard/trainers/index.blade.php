
{{-- {{dd($courseSlug)}} --}}
@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex p-2">
        <h4 class="flex-grow-1">{{__t('trainers')}} </h4>
        <a href="{{ url('/register?type=trainer') }}" class="btn btn-primary">{{__t('create_trainer')}}</a>
      &nbsp;  <a href="{{ route('request_trainer') }}" class="btn btn-primary">{{__t('request_trainer')}}</a>

    </div>

    @if(count($trainer) > 0)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                <th>{{__t('name')}}</th>
                <th>{{__t('email')}}</th>
                {{-- <th>{{__t('action')}}</th> --}}
            </tr>

            @foreach($trainer as $key => $trainerList)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>

                        <strong>{{ucwords($trainerList->name)}}</strong>

                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{ucwords($trainerList->email)}}</strong>
                        </p>
                    </td>

                    {{-- <td>
                        <p class="mb-3">

                            <a href="{{url('dashboard/packages/edit', $trainerList->id)}}" class="font-weight-bold mr-3" ><i class="la la-edit"></i> {{__t('edit ')}} </a>
                        </p>
                    </td> --}}

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
        <div class="no-data-wrap text-center">
            {{-- <a href="{{route('create_course')}}" class="btn btn-lg btn-primary">{{__t('create_course')}}</a> --}}
        </div>
    @endif

@endsection
