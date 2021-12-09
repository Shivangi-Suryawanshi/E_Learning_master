
{{-- {{dd($courseSlug)}} --}}
@extends('layouts.admin')

@section('page-header-right')
<a href="{{route('create_package')}}"  class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="{{__t('create_package')}}"> <i class="la la-plus"></i> </a>

@endsection
@section('content')
   

    @if(count($packages) > 0)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                <th>{{__t('title')}}</th>
                <th>{{__t('description')}}</th>
                <th>{{__t('action')}}</th>
            </tr>

            @foreach($packages as $key => $packagesList)
                <tr>
                    <td>
                        {{$key+1}}
                    </td>
                    <td>
                       
                        <strong>{{$packagesList->title}} @if($packagesList->status == 1) <span class='badge badge-success'> <i class='la la-check-circle'></i>Active</span>
                        @else <span class='badge badge-danger'> <i class='la la-check-circle'></i>InActive</span> @endif</strong>
                        
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{$packagesList->description}}</strong>
                        </p>
                    </td>
                    
                    <td>
                        <p class="mb-3">
                            @if($packagesList->status == 1)
                            <a href="{{url('admin/packages/functionality', $packagesList->id)}}" class="font-weight-bold mr-3" ><i class="la la-edit"></i> {{__t('subscription ')}} </a>
                            @endif
                            <a href="{{url('admin/packages/edit', $packagesList->id)}}" class="font-weight-bold mr-3" ><i class="la la-edit"></i> {{__t('edit ')}} </a>
                        </p>
                    </td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
        <div class="no-data-wrap text-center">
            <a href="{{route('create_package')}}" class="btn btn-lg btn-primary">{{__t('create_package')}}</a>
        </div>
    @endif

@endsection
