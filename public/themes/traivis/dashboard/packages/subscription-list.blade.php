{{-- {{dd($courseSlug)}} --}}
@extends('layouts.admin')

@section('page-header-right')
   

@endsection
@section('content')


    @if (count($packageSubscription) > 0)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                {{-- <th>{{__t('title')}}</th> --}}
                <th>{{ __t('name') }}</th>
                <th>{{ __t('packages') }}</th>
                <th>{{ __t('amount') }}</th>
                <th>{{ __t('payment_method') }}</th>
                <th>{{ __t('status') }}</th>
                <th>{{ __t('currency') }}</th>
                <th>{{ __t('validity') }}</th>
                <th>{{ __t('functionality') }}</th>

            </tr>

            @foreach ($packageSubscription as $key => $packagesList)
                <tr>
                    <td>
                        {{ $key + 1 }}
                    </td>
                    <td>
                        <strong>{{ ucwords($packagesList->name) }}</strong>
                    </td>
                    <td>
                        <strong>
                            @if ($packagesList->packages)
                                {{ $packagesList->packages->title }}
                                 @endif
                        </strong>
                    </td>
                    <td>
                        <strong>{{ $packagesList->total_amount }}</strong>
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{ $packagesList->payment_method }}</strong>
                        </p>
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{ $packagesList->status }}</strong>
                        </p>
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{ $packagesList->currency }}</strong>
                        </p>
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{ $packagesList->month }} month</strong>
                        </p>
                       
                    </td>
                    <td>
                        @if($packagesList->functionality)
                        @foreach ($packagesList->functionality as $packFunctioality) 
                        <p class="mb-3">
                            <strong>@if($packFunctioality->functionality) {{$packFunctioality->functionality->title}}@endif : {{ $packFunctioality->count }}</strong>
                        </p>
                        @endforeach
                       @endif
                    </td>
                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5') !!}
        <div class="no-data-wrap text-center">
            <a href="{{ route('create_package') }}" class="btn btn-lg btn-primary">{{ __t('create_package') }}</a>
        </div>
    @endif

@endsection
