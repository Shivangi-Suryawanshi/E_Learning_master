@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    {{-- <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('coupons')}} </h4>
        <a href="{{route('create_coupon')}}" class="btn btn-warning">{{__t('create_coupon')}}</a>
    </div> --}}

    @if($coupons->count())
        <table class="table table-bordered bg-white">

            <tr>
                <th>SL</th>
                <th>{{__t('title')}}</th>
                {{-- <th>{{__t('course')}}</th> --}}
                <th>{{__t('coupon_code')}}</th>
                <th>{{__t('discount_amount')}}</th>
                <th>{{__t('valid_from')}}</th>
                <th>{{__t('valid_to')}}</th>
            </tr>
            {{-- [
                "5"
            ] --}}
            @foreach($coupons as $key=> $coupon)
                <tr>   
                    <td>{{$key+1}}</td>            
                    <td>
                        <p class="mb-3">
                            <strong>{{$coupon->title}}</strong>                          
                        </p>
                    </td>
                    {{-- <td>@if($coupon->couponCourse){{$coupon->couponCourse->title}} @endif</td> --}}
                    <td>{!! $coupon->coupon_code !!}</td>
                    <td>{!! $coupon->discount_amount !!}</td>
                    <td>{!! Carbon\Carbon::parse($coupon->valid_from)->format('d-M-Y') !!}</td>
                    <td>{!! Carbon\Carbon::parse($coupon->valid_to)->format('d-M-Y') !!}</td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
        <div class="no-data-wrap text-center">
            <a href="{{route('create_coupon')}}" class="btn btn-lg btn-warning">{{__t('create_coupon')}}</a>
        </div>
    @endif

@endsection
