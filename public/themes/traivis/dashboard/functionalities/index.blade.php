
@extends('layouts.admin')

@section('page-header-right')
<a href="{{route('create_functionality')}}"  class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="{{__t('create_functionality')}}"> <i class="la la-plus"></i> </a>

@endsection
@section('content')
    {{-- <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('functionality')}} </h4>
        <a href="{{route('create_functionality')}}" class="btn btn-primary">{{__t('create_functionality')}}</a>
    </div> --}}

    @if(count($functioalities) > 0)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                <th>{{__t('title')}}</th>
                <th>{{__t('description')}}</th>
                <th>{{__t('action')}}</th>
            </tr>

            @foreach($functioalities as $key => $functioalitiesList)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        <strong>{{$functioalitiesList->title}}</strong>
                        
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{$functioalitiesList->description}}</strong>
                        </p>
                    </td>
                    
                    <td>
                        <p class="mb-3">
                            <a href="{{url('admin/functionality/edit', $functioalitiesList->id)}}" class="font-weight-bold mr-3" ><i class="la la-edit"></i> {{__t('edit ')}} </a>

                        </p>
                    </td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
        <div class="no-data-wrap text-center">
            <a href="{{route('create_functionality')}}" class="btn btn-lg btn-primary">{{__t('create_functionality')}}</a>
        </div>
    @endif

@endsection
