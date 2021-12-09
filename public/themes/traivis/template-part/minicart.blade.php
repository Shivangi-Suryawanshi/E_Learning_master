@php($cart = cart())

<a class="nav-link" href="javascript:;" id="miniCartDropDown">
    <div class="text-center">
        <i class="la la-shopping-cart"></i>
        @if($cart->count)
            <span class="badge badge-pill badge-danger">{{$cart->count}}</span>
        @endif
    </div>
</a>

@if($cart->count)
    <div class="mini-cart-body-wrap">
        <div class="mini-cart-courses-list-wrap">
            @foreach($cart->courses as $cartKey => $cart_course)
                <div class="mini-cart-course-item">
                    <button type="button" class="remove-cart-btn" data-cart-id="{{$cartKey}}">&times;</button>
                    <a href="{{array_get($cart_course, 'course_url')}}" class="d-block p-3 d-flex">

                        <div class="minicart-course-thumbnail mr-2">
                            <img src="{{array_get($cart_course, 'thumbnail')}}" class="img-fluid" />
                        </div>

                        <div class="minicart-course-info flex-grow-1">
                            <p class="mini-cart-course-title mb-1">{{$cart_course['title']}}</p>
                            <div class="mini-cart-course-price">
                                {!! array_get($cart_course, 'price_html') !!}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mini-cart-total-wrap p-4">
            <p class="minicart-total-price">
                Total : <strong>{!! price_format($cart->total_price) !!}</strong>

                @if($cart->total_original_price > 0)
                    <small><s>{!! price_format($cart->total_original_price) !!}</s></small>
                @endif
            </p>
            <a href="{{route('checkout')}}" class="btn btn-block btn-info">{{__t('go_checkout')}}</a>
        </div>
    </div>
@endif
