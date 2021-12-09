
{{-- {{dd($courseSlug)}} --}}
@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex p-2">
        <h4 class="flex-grow-1">{{__t('purchased_student')}} </h4>
      
    </div>

    @if(count($student) > 0)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                <th>{{__t('purchased_course')}}</th>
                <th>{{__t('name')}}</th>
                <th>{{__t('email')}}</th>
                
                {{-- <th>{{__t('action')}}</th> --}}
            </tr>

            @foreach($student as $key => $studentPortal)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>@if($studentPortal->course) {{$studentPortal->course->title}} @endif</td>
                    <td>

                        @if($studentPortal->user)<strong>{{ucwords($studentPortal->user->name)}}</strong> @endif

                    </td>
                    <td>
                        <p class="mb-3">
                            @if($studentPortal->user) <strong>{{$studentPortal->user->email}}</strong> @endif
                        </p>
                    </td>

                 

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
