@extends('layouts.website')


@section('content')

    @if (cart()->count)

        <div class="checkout-page-wrap py-5">

            <div class="container">
                <div class="row">

                    <div class="col-md-10">

                        <div class="section-order-summery-wrap mb-5">

                            <div class="about-text">
                                <h3 class="mb-4">{{ __t('order_summery') }}</h3>
                            </div>

                            <div class="checkout-section order-summery-wrap bg-white p-4">
                                @php($cart = cart())
                                    @if ($cart->count)

                                        <div class="order-summery-courses-wrap">
                                            @foreach ($cart->courses as $cart_course)
                                                <div class="order-summery-course-item border-bottom pb-3 mb-3">


                                                    <div class="order-summery-course-thumbnail mr-2">
                                                        <a href="{{ array_get($cart_course, 'course_url') }}" class="">
                                                            <img src="{{ array_get($cart_course, 'thumbnail') }}"
                                                                class="img-fluid img-thumbnail" />
                                                        </a>
                                                    </div>


                                                    <a href="{{ array_get($cart_course, 'course_url') }}"
                                                        class="d-block d-flex">
                                                        <h5 class="order-summery-course-title flex-grow-1 mt10">
                                                            {{ $cart_course['title'] }}</h5>
                                                        <input type="text" id="course-id" hidden
                                                            value="{{ $cart_course['course_id'] }}">
                                                        <div class="order-summery-course-info ">
                                                            <div class="order-summery-course-price">
                                                                <h5> {!! price_format(array_get($cart_course, 'price')) !!} </h5>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if ($cart->enable_charge_fees)

                                            <div class="order-summery-fees-wrap d-flex border-bottom mb-3">
                                                <h5 class="flex-grow-1">
                                                    {!! $cart->fees_name !!}
                                                    Discount ({!! $cart->fees_type === 'percent' ? $cart->fees_amount . '%' : '' !!})
                                                </h5>
                                                <strong>+ {!! price_format($cart->fees_total) !!}</strong>
                                            </div>

                                        @endif

                                        <div class="order-summery-total-wrap d-flex">
                                            <h5 class="flex-grow-1">{{ __t('count') }}</h5>
                                            <strong>{{ $count }}</strong>
                                        </div>

                                        <br>

                                        <div class="order-summery-total-wrap d-flex">
                                            <input type="text" class="form-control" id="coupon" placeholder="coupon code">

                                            &nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-primary apc" id="apply-coupon"> Apply Coupon </a>
                                        </div>
                                        <div class="order-summery-total-wrap d-flex">
                                            <span id="error-message" style="color: red;"></span>
                                        </div>
                                        <div class="order-summery-total-wrap d-flex">
                                            <span id="coupon-appied" style="color: green;"></span>
                                        </div>
                                        <br>
                                        <div class="display-discount" style="display: none;">
                                        <div class="order-summery-total-wrap d-flex "  >
                                            <h5 class="flex-grow-1 "  >Discount</h5>
                                            <strong class="new-price fs18b discount"></strong>

                                        </div>
                                    </div>
                                        <br>
                                        <div class="display-you-save" style="display: none;">
                                        <div class="order-summery-total-wrap d-flex " >
                                            <h5 class="flex-grow-1 ">You Save</h5>
                                            <strong class="new-price fs18b you_save"></strong>

                                        </div>
                                        <br>
                                        </div>
                                        
                                     
                                        <div class="order-summery-total-wrap d-flex">
                                            <h5 class="flex-grow-1">{{ __t('total') }}</h5>
                                            <strong class="new-price fs18b">{!! price_format($cart->total_amount * $count) !!}</strong>

                                        </div>

                                    @endif
                                </div>

                            </div>


                            <div class="section-account-information-wrap mb-5">

                                <div class="about-text">
                                    <h3>{{ __t('account_information') }}</h3>
                                </div>

                                <div class="checkout-section order-account-information-wrap bg-white p-4 mt-3">
                                    <p class="checkout-logged-email d-flex">
                                        <i class="la la-user pblu"></i>

                                        <span class="mr-2"> {{ __t('logged_in_as') }} </span>
                                        <strong class="flex-grow-1">{{ $auth_user->name }}</strong>

                                        <a class="lbtn" href="{{ route('logout') }}" {{-- onclick="event.preventDefault(); document.getElementById('logout-form').submit();" --}}>
                                            <i class="la la-sign-out"></i>
                                            {{ __t('logout') }}
                                        </a>
                                    </p>

                                    <p class="checkout-logged-email">
                                        <i class="la la-envelope pblu2"></i> {{ __t('email') }}
                                        <strong>{{ $auth_user->email }}</strong>
                                    </p>
                                    @if (company_user())
                                        <p class="ccheckout-section">

                                            <i class="la la-envelope pblu2"></i> {{ __t('users') }} <strong>
                                                @foreach (company_user() as $key => $company_user)
                                                    @foreach ($company_user as $company_user_name)
                                                        {{ $company_user_name }} ,
                                                    @endforeach

                                                @endforeach

                                            </strong>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            @include(theme('template-part.gateways.available-gateways'))

                            <div class="checkout-agreement-wrap mt-4 text-center text-muted">
                                <p class="agreement-text"> {{ __t('agreement_text') }}
                                    <strong>{{ get_option('site_name') }}'s</strong>
                                    {{-- <a href="{{route('post_proxy', get_option('terms_of_use_page'))}}">
                                    {{__t('terms_of_use')}}
                                </a> &amp; --}}
                                    <a href="{{ URL::to('/privacy-policy') }}">
                                        {{ __t('privacy_policy') }}
                                    </a>
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        @else
            <div class="text-center my-5">
                <h2 class="mb-4 mt-5"><i class="la la-frown"></i> {{ __t('nothing_to_checkout') }} </h2>
                <a href="{{ route('home') }}" class="btn btn-lg btn-warning mb-5"> <i class="la la-home"></i>
                    {{ __t('go_to_home') }}</a>
            </div>
        @endif

    @endsection

@section('page-js')
    @include(theme('template-part.gateways.gateway-js'))
    <script>
        $('#apply-coupon').on('click', function() {
            var coupon = $('#coupon').val();
            var courseId = $('#course-id').val();

            $.ajax({
                url:"coupon-apply",
                type:"POST",
                data: {coupon:coupon,courseId:courseId, _token: "{{ csrf_token() }}"},
                success:function(data)
                {
                    $('#coupon-appied').html('');
                    $('#error-message').html('')
                    if(data.status == true)
                    {
                   

                    var newPrice = data.newPrice ;
                   
                    $('.new-price').html(newPrice);
                    $('.new-price').val(newPrice);

                    $('.display-discount').show();
                    $('.display-you-save').show();
                    $('.discount').html(data.discount);
                    $('.you_save').html(data.you_save);
                    $('#coupon-appied').html(data.message);
                    // $('.new-price').html(newPrice);
                    }
                    if (data.status == false) {
                        $('#error-message').html('')
                        var message = data.message;
                        $('#error-message').html(message);
                    }
                },
                error: function(data) {

                }
            });
        });

    </script>
@endsection
