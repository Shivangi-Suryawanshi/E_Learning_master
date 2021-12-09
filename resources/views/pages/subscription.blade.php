@extends('layouts.website')

<style>
.form-control {padding: 15px 0 0 12px !important;}
</style>

@section('content')
   <!-- Start Contact Area -->
    <section class="contact-area pb-100">
        <div class="container">

            <div class="contact-form mt60">

                                      {{-- strip payment  --}}
    @php
    $hasGateways = get_option('enable_stripe') || get_option('enable_paypal') || get_option('bank_gateway.enable_bank_transfer') || get_option('enable_offline_payment');

@endphp


                     @if(get_option('enable_stripe'))
                     <div class="tab-pane fade show active subscrip-strip" id="payment-tab-card" >
                         <div class="stripe-credit-card-form-wrap ml-auto mr-auto">
                             <form action="/charge" method="post" id="payment-form">
                                 <div class="form-group">
                                     <label for="card-element"> <h5>Pay with your Credit or debit card via Stripe</h5></label>
                                     <div id="card-element" class="form-control">
                                         <!-- A Stripe Element will be inserted here. -->
                                     </div>
                                 </div>

                                 <!-- Used to display form errors. -->
                                 <div id="card-errors" class="text-danger mb-3" role="alert"></div>
                                 <input type="text" class="type" value="subscription" hidden id="">
                                 <input type="text" class="subscr-amount" value="{{$packages->sale_price}}" hidden id="">
                                 <input type="text" class="package_id"  hidden value="{{$packages->id}}">
                                 <input type="text" class="month"  hidden value="{{$packages->month}}">


                                 <button type="submit" class="btn btn-primary" id="stripe-payment-form-btn">
                                     <span class="enroll-course-btn-text mr-4 border-right pr-4">{{__t('subscribe')}}</span>
                                     <span class="enroll-course-btn-price new-price">{!! price_format($packages->sale_price) !!}</span>
                                 </button>
                             </form>
                         </div>
                     </div> <!-- tab-pane.// -->
                 @endif

            </div>
        </div>

        <div id="particles-js-circle-bubble-3"></div>
       <!--  <div class="contact-bg-image"><img src="assets/img/map.png" alt="image"></div> -->
    </section>

    @endsection
@section('page-js')
@include(theme('template-part.gateways.gateway-js'))
@endsection
