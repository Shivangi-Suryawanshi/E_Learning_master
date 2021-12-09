@extends('layouts.website')

@section('content')
    <!-- Search Box Layout -->
    @if (Auth::check())
        @if (Auth::user()->user_type != 'company')
            @if ($banner && ($page->slug == 'company-landing' || $page->slug == 'training-centre-landing' || $page->slug == 'individual-user-landing' || $page->slug == 'trainer-landing'))

                <!-- Start Language Banner Area -->
                <section class="language-banner-area">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            @if (Session::get('locale') == "ar")
                                
                            <div class="col-lg-6 col-md-12">
                                <div class="language-banner-image">
                                    <img src="@if ($banner->logo) {!! asset('banners/' . $banner->logo) !!}
                                @else {{ asset('images/noimage.jpg') }} @endif" alt="image">
                                </div>
                            </div>
                            @endif

                            <div class="col-lg-6 col-md-12">
                                <div class="language-banner-content">
                                    <h1>
                                        @if (\App::getLocale() == 'ar')
                                        {!! $banner->title_ar !!} @else {!! $banner->title_en !!} @endif
                                    </h1>
                                    <p>
                                        @if (\App::getLocale() == 'ar')
                                        {!! $banner->content_ar !!} @else {!! $banner->content_en !!} @endif
                                    </p>
                                    @if ($page->slug == 'company-landing')
                                        <a href="{{ URL::to('register/company') }}" data-role="3" class="default-btn"><i
                                                class='bx bx-user-circle icon-arrow before'></i><span class="label">Register
                                                Now</span><i class="bx bx-user-circle icon-arrow after"></i></a>

                                    @elseif($page->slug=='training-centre-landing')
                                        <a href="{{ URL::to('register/instructor') }}" data-role="4"
                                            class="default-btn"><i class='bx bx-user-circle icon-arrow before'></i><span
                                                class="label">Register
                                                Now</span><i class="bx bx-user-circle icon-arrow after"></i></a>

                                    @elseif($page->slug=='individual-user-landing')
                                        <a href="{{ URL::to('register/student') }}" data-role="6" class="default-btn"
                                            onclick="return showRegisterModal(this)"><i
                                                class='bx bx-user-circle icon-arrow before'></i><span class="label">Register
                                                Now</span><i class="bx bx-user-circle icon-arrow after"></i></a>

                                    @elseif($page->slug=='trainer-landing')
                                        <a href="{{ URL::to('register/trainer') }}" data-role="5" class="default-btn"
                                            onclick="return showRegisterModal(this)"><i
                                                class='bx bx-user-circle icon-arrow before'></i><span class="label">Register
                                                Now</span><i class="bx bx-user-circle icon-arrow after"></i></a>

                                    @endif

                                </div>
                            </div>
                            @if (Session::get('locale') == "en")
                                
                            <div class="col-lg-6 col-md-12">
                                <div class="language-banner-image">
                                    <img src="@if ($banner->logo) {!! asset('banners/' . $banner->logo) !!}
                                @else {{ asset('images/noimage.jpg') }} @endif" alt="image">
                                </div>
                            </div>
                            @endif
                           
                        </div>
                    </div>

                    <div class="lang-shape1"><img src="assets/img/lang-shape1.png" alt="image"></div>
                    <!-- <div class="divider bg-e4feff"></div> -->
                </section>


            @elseif($banner)

                <!-- Start Page Title Area -->
                <div class="page-title-area item-bg1 jarallax" style="background-image: url(@if ($banner->logo) {!! asset('banners/' . $banner->logo) !!} @else {{ asset('images/noimage.jpg') }} @endif);" data-jarallax='{"speed": 0.3}'>
                    <div class="container">
                        <div class="page-title-content">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li>
                                    @if (\App::getLocale() == 'ar') {!! $banner->title_ar !!}
                                    @else {!! $banner->title_en !!} @endif
                                </li>
                            </ul>
                            <h2>
                                @if (\App::getLocale() == 'ar') {!! $banner->title_ar !!}
                                @else {!! $banner->title_en !!} @endif
                            </h2>
                            @if ((\App::getLocale() == 'en' && $banner->content_en) || (\App::getLocale() == 'ar' && $banner->content_ar))
                                <p class="txtw">{!! $banner->content !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Page Title Area -->
                <!-- Start About Area -->


            @else


                <section class="language-banner-area">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="language-banner-content">


                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="language-banner-image">
                                    <img src="{{ theme_url('assets/website/img/images/tra.png') }}" alt="image">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lang-shape1"><img src="{{ theme_url('assets/website/img/lang-shape1.png') }}" alt="image">
                    </div>
                    <!-- <div class="divider bg-e4feff"></div> -->
                </section>

            @endif
        @endif
        <!-- End Language Banner Area -->

    @endif
    {{-- {!! $page->content !!} --}}

    @if ($page->slug == 'about-us' || $page->slug == 'company-landing' || $page->slug == 'training-centre-landing' || $page->slug == 'trainer-landing' || $page->slug == 'individual-user-landing')

        @if ($page->getContent() && count($page->getContent()->get()) > 0)

            @php
                $getContent = $page->getContent()->get();
                $getImages = $page->getImages()->get();
            @endphp

            <!----------------- ABOUT US  ----------------->
            @if ($page->slug == 'about-us')
                <section class="about-area ptb-100">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="experience-image">
                                    <img src="@if ($getImages[0]->img) {!! asset('assets/page_images/' . $getImages[0]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif" >
                                </div>

                            </div>

                            {!! $getContent[0]->content !!}
                        </div>

                        {!! $getContent[1]->content !!}
                    </div>


                </section>

                <!-- Start Feedback Area -->
                <section class="feedback-area-two pt-100 pb-100 faq-area bg-f8e8e9">
                    <div class="container">
                        <div class="section-title">
                            <span class="sub-title">{!! __t('title_feedback') !!}</span>
                            <h2>{{ __t('title_our_testimonials') }}</h2>
                        </div>

                        <div class="feedback-slides owl-carousel owl-theme">

                            @foreach ($testimonials as $testimonial)
                                <div class="single-feedback-box">
                                    @if (App::getLocale() == 'ar')
                                        <p>{!! $testimonial->description_ar !!}</p>
                                    @else
                                        <p>{!! $testimonial->description_en !!}</p>
                                    @endif

                                    <div class="info">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="@if ($testimonial->img) {!! asset('testimonial_images/' . $testimonial->img) !!}
                                        @else {{ asset('images/noimage.jpg') }} @endif" alt="image">
                                            <div class="title">
                                                @if (App::getLocale() == 'ar')
                                                    <h3>{{ $testimonial->title_ar }}</h3>
                                                    <span>{{ $testimonial->position_ar }}</span>
                                                @else
                                                    <h3>{{ $testimonial->title_en }}</h3>
                                                    <span>{{ $testimonial->position_en }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    <div class="divider bg-fff"></div>

                </section>
                <!-- End Feedback Area -->
            @endif

            <!----------------- END - ABOUT US  ----------------->

            <!-----------------COMPANY LANDING  ----------------->
            @if ($page->slug == 'company-landing')


                <!----------pricing-------------->
                @if (Auth::check() && Auth::user()->user_type == 'company')
                    <section class="pricing-section">
                        <div class="container">
                            <div class="information-content" align="center">
                                <span class="sub-title">SUBSCRIPTION PLANS</span>
                                <h2>Choose a Plan</h2>
                            </div>

                            <div class="outer-box">
                                <div class="row">
                                    @if ($package)
                                        @foreach ($package as $packages)

                                            <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp"
                                                data-wow-delay="400ms">

                                                <div class="inner-box">
                                                    <div class="icon-box">
                                                        <div class="icon-outer"><i class="flaticon-checkmark"></i></div>
                                                    </div>

                                                    <div class="price-box">

                                                        <div class="title">{{ ucwords($packages->title) }}</div>
                                                        <h4 class="price">
                                                        @if ($packages->sale_price == 0) Free @else
                                                                ${{ $packages->sale_price }} @endif
                                                            <span class="fs15"><sup>/
                                                                    {{ $packages->month }} Months</sup></span>
                                                        </h4>

                                                    </div>
                                                    <ul class="features">
                                                        @if ($packages->packageFuctionality)
                                                            @foreach ($packages->packageFuctionality as $itemFuctionality)
                                                                <li class="true">
                                                                    @if ($itemFuctionality->functionality)

                                                                        {{ ucwords($itemFuctionality->functionality->title) }}
                                                                    @endif
                                                                    <span class="badge badge-danger bpad">
                                                                        @if ($itemFuctionality->count == 0) Free
                                                                        @else {{ $itemFuctionality->count }}
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endforeach

                                                        @endif
                                                        {{-- <li class="true">Training dashboard</li>
                        <li class="false">Contractor dashboard</li>
                        <li class="false">Training matrix</li>
                        <li class="true">Subcontractor creation <span class="badge badge-danger bpad">1</span></li>
                        <li class="false">Bidding</li> --}}
                                                    </ul>
                                                    @if (count($packages->packageFuctionality) > 0)
                                                    @if ($packages->sale_price != 0)
                                                        <div class="btn-box">
                                                            <a href="{{ route('subscription', $packages->id) }}"
                                                                class="theme-btn subscrip" data-id="{{ $packages->id }}"
                                                                id="subscrip{{ $packages->id }}">
                                                          BUY plan 
                                                            </a>
                                                        </div>
                                                        @else 
                                                        <div class="btn-box">
                                                            <a href="{{ route('add-profile') }}"
                                                                class="theme-btn subscrip" data-id="{{ $packages->id }}"
                                                                id="subscrip{{ $packages->id }}">
                                                          Free
                                                            </a>
                                                        </div>
                                                        @endif
                                                    @endif
                                                </div>

                                            </div>


                                            {{-- <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="400ms">
                    <div class="inner-box">
                      <div class="icon-box">
                        <div class="icon-outer"><i class="flaticon-checkmark"></i></div>
                      </div>
                      <div class="price-box">
                        <div class="title">Medium Package</div>
                        <h4 class="price">$100 <span class="fs15"><sup>/ 6 Mnths</sup></span></h4>
                      </div>
                      <ul class="features">
                        <li class="true">Employee creation <span class="badge badge-danger bpad">3</span></li>
                        <li class="true">Training dashboard</li>
                        <li class="true">Contractor dashboard</li>
                        <li class="false">Training matrix</li>
                        <li class="true">Subcontractor creation <span class="badge badge-danger bpad">2</span></li>
                        <li class="false">Bidding</li>
                      </ul>
                      <div class="btn-box">
                        <a href="#!" class="theme-btn">BUY plan</a>
                      </div>
                    </div>
                  </div> --}}


                                            {{-- <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="400ms">
                    <div class="inner-box">
                      <div class="icon-box">
                        <div class="icon-outer"><i class="flaticon-checkmark"></i></div>
                      </div>
                      <div class="price-box">
                        <div class="title">Premium Package</div>
                        <h4 class="price">$200 <span class="fs15"><sup>/ 6 Mnths</sup></span></h4>
                      </div>
                      <ul class="features">
                        <li class="true">Employee creation <span class="badge badge-danger bpad">5</span></li>
                        <li class="true">Training dashboard</li>
                        <li class="true">Contractor dashboard</li>
                        <li class="true">Training matrix</li>
                        <li class="true">Subcontractor creation <span class="badge badge-danger bpad">5</span></li>
                        <li class="true">Bidding</li>
                      </ul>
                      <div class="btn-box">
                        <a href="#!" class="theme-btn">BUY plan</a>
                      </div>
                    </div>
                  </div> --}}



                                        @endforeach


                                    @endif
                                </div>

                            </div>

                        </div>
                    </section>
                @endif

                <!---------pricing--------------->


                <section class="information-area ptb-100 bg-fcfcfc">
                    <div class="container">
                        <div class="row align-items-center">
                            {{-- @if(Session::get('locale') == "ar")
                            <div class="col-lg-6 col-md-12">
                            {!! $getContent[0]->content_ar !!}
                            </div>
                            @endif --}}
                            <div class="col-lg-6 col-md-12">
                                <div class="information-image text-center">
                                    <figure><img src="@if ($getImages[0]->img) {!! asset('assets/page_images/' . $getImages[0]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif" alt="image" data-image="jd7a06rdljz3"></figure>
                                </div>
                            </div>
                            
                           
                            
                            {!! $getContent[0]->content !!}
                            
                            
                        </div>
                    </div>
                </section>
                <p> <br> </p>
                <section class="subscribe-area ptb-100">
                    {{-- {{dd($getContent[1])}} --}}
                    {!! $getContent[1]->content !!}

                    <div class="lang-shape4">
                        <figure><img src="@if ($getImages[1]->img) {!! asset('assets/page_images/' . $getImages[1]->img) !!} @else assets/img/lang-shape4.png @endif"
                            alt="image" data-image="1wxt2hnuc49q"></figure>
                    </div>
                    <div class="lang-shape5">
                        <figure><img src="@if ($getImages[2]->img) {!! asset('assets/page_images/' . $getImages[2]->img) !!} @else assets/img/lang-shape5.png @endif"
                            alt="image" data-image="2jh518yeg8in"></figure>
                    </div>

                </section>
            @endif

            <!-----------------END - COMPANY LANDING  ----------------->

            <!-----------------TRAINING CENTER LANDING  ----------------->
            @if ($page->slug == 'training-centre-landing')
                <section class="distance-learning-area ptb-200">
                    <div class="container">
                        <div class="row">
                            @if (Session::get('locale') == "ar")
                                
                            {!! $getContent[0]->content_ar !!}
                            @endif
                            <div class="col-lg-6 col-md-12">
                            <div class="distance-learning-image"><img alt="image" src="@if ($getImages[0]->img) {!! asset('assets/page_images/' . $getImages[0]->img) !!} @else
                                    assets/img/images/center.png @endif"></div>
                            </div>
                            {{-- {{dd($getContent[0]->id)}} --}}
                            @if (Session::get('locale') == "en")
                                
                            {!! $getContent[0]->content_en !!}
                            @endif


                        </div>
                    </div>

                    <div class="business-shape4"><img alt="image" src="assets/img/business-coaching/business-shape4.png">
                    </div>
                    <!-- <div class="divider bg-e4feff"></div> -->
                </section>


                <section class="services-area ptb-100">
                    @if (Session::get('locale') == "ar")
                    {!! $getContent[1]->content_ar !!}

                        @else
                        {!! $getContent[1]->content_en !!}
                    @endif
                   

                </section>

                <section class="information-area ptb-100 bg-fcfcfc">
                    <div class="container">
                        <div class="row align-items-center">
                            @if(Session::get('locale') == "ar")
                            {!! $getContent[2]->content_ar !!}
                            @endif
                            <div class="col-lg-6 col-md-12">
                            <div class="information-image text-center"><img alt="image" src="@if ($getImages[1]->img) {!! asset('assets/page_images/' . $getImages[1]->img) !!} @else
                                    assets/img/images/training.png @endif "></div>
                            </div>
                            @if(Session::get('locale') == "en")
                            {!! $getContent[2]->content_en !!}
                            @endif

                        </div>
                    </div>
                </section>

                <section class="subscribe-area ptb-100">
                    {{-- {{dd($getContent[3]->id)}} --}}
                    @if (Session::get('locale') == "ar")
                    {!! $getContent[3]->content_ar !!}

                        @else
                        {!! $getContent[3]->content_en !!}
                    @endif
                 
                    <div class="lang-shape5"><img alt="image" src="@if ($getImages[3]->img) {!! asset('assets/page_images/' . $getImages[3]->img) !!} @else assets/img/lang-shape5.png @endif"></div>
                    <div class="lang-shape4"><img alt="image" src="@if ($getImages[2]->img) {!! asset('assets/page_images/' . $getImages[2]->img) !!} @else assets/img/lang-shape4.png @endif"></div>
                
                 
                </section>

            @endif

            <!-----------------END - TRAINING CENTER LANDING ----------------->

            <!-----------------TRAINER LANDING  ----------------->
            @if ($page->slug == 'trainer-landing')
                <section class="distance-learning-area ptb-200">
                    <div class="container">
                        <div class="row">
                            @if(Session::get('locale') == "ar")
                            {!! $getContent[0]->content_ar !!}
                            @endif
                            <div class="col-lg-6 col-md-12">
                                <div class="distance-learning-image">
                                    <figure><img src="@if ($getImages[0]->img) {!! asset('assets/page_images/' . $getImages[0]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif" alt="image" data-image="y34ck7mn8e2s"></figure>
                                </div>
                            </div>
                            @if(Session::get('locale') == "en")
                            {!! $getContent[0]->content_en !!}
                            @endif

                          

                        </div>
                    </div>

                    <div class="business-shape4">
                        <figure><img src="assets/img/business-coaching/business-shape4.png" alt="image"
                                data-image="yf1t0fq1dxmr"></figure>
                    </div>

                </section>
                <section class="services-area ptb-100">

                    {!! $getContent[1]->content !!}

                </section>

                <section class="information-area ptb-100 bg-fcfcfc">
                    <div class="container">
                        <div class="row align-items-center">
                            @if(Session::get('locale') == "ar")
                            {!! $getContent[2]->content_ar !!}
                            @endif
                            <div class="col-lg-6 col-md-12">
                                <div class="information-image text-center">
                                    <figure><img src="@if ($getImages[1]->img) {!! asset('assets/page_images/' . $getImages[1]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif" alt="image" data-image="yjpf7mpsa4x9"></figure>
                                </div>
                            </div>

                            @if(Session::get('locale') == "en")
                            {!! $getContent[2]->content_en !!}
                            @endif
                            
                        </div>
                    </div>
                </section>

                <section class="subscribe-area ptb-100">

                    {!! $getContent[3]->content !!}
                    {{-- {{dd($getContent[3]->id)}} --}}
                    <div class="lang-shape4">
                        <figure><img src="@if ($getImages[2]->img) {!! asset('assets/page_images/' . $getImages[2]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif"
                            alt="image" data-image="aspyku2tqur0"></figure>
                    </div>
                    <div class="lang-shape5">
                        <figure><img src="@if ($getImages[3]->img) {!! asset('assets/page_images/' . $getImages[3]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif"
                            alt="image" data-image="n9qnj7hev60h"></figure>
                    </div>

                </section>
            @endif
            <!-----------------END - TRAINING CENTER LANDING ----------------->

            <!-----------------INDIVIDUAL LANDING  ----------------->

            @if ($page->slug == 'individual-user-landing')
                <section class="distance-learning-area ptb-200">
                    <div class="container">
                        <div class="row">
                            @if(Session::get('locale') == "ar")
                            {!! $getContent[0]->content_ar !!}
                            @endif
                            <div class="col-lg-6 col-md-12">
                                <div class="distance-learning-image">
                                    <figure><img src="@if ($getImages[0]->img) {!! asset('assets/page_images/' . $getImages[0]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif" alt="image" data-image="av6qhm14vvpe"></figure>
                                </div>
                            </div>
                            @if(Session::get('locale') == "en")
                            {!! $getContent[0]->content_en !!}
                            @endif

                        </div>
                    </div>

                    <div class="business-shape4">
                        <figure><img src="assets/img/business-coaching/business-shape4.png" alt="image"
                                data-image="zp2zdkhtfze3"></figure>
                    </div>

                </section>
                <section class="services-area ptb-100">

                    @if (Session::get('locale') == "ar")
                    {!! $getContent[1]->content_ar !!}
                        
                    @else
                    {!! $getContent[1]->content_en !!}

                    @endif
                   

                </section>
                <section class="information-area ptb-100 bg-fcfcfc">
                    <div class="container">
                        <div class="row align-items-center">
                            @if (Session::get('locale') == "ar")
                            {!! $getContent[2]->content_ar !!}
                                
                            @endif
                            <div class="col-lg-6 col-md-12">
                                <div class="information-image text-center">
                                    <figure><img src="@if ($getImages[1]->img) {!! asset('assets/page_images/' . $getImages[1]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif" alt="image" data-image="g8gnytp2f5mu"></figure>
                                </div>
                            </div>
                            @if (Session::get('locale') == "en")
                            {!! $getContent[2]->content_en !!}
                                
                            @endif

                        </div>
                    </div>
                </section>
                <section class="subscribe-area ptb-100">

                    {!! $getContent[3]->content !!}
                    {{-- {{dd($getContent[3]->id)}} --}}
                    <div class="lang-shape4">
                        <figure><img src="@if ($getImages[2]->img) {!! asset('assets/page_images/' . $getImages[2]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif"
                            alt="image" data-image="s7wmv67vlf5g"></figure>
                    </div>
                    <div class="lang-shape5">
                        <figure><img src="@if ($getImages[3]->img) {!! asset('assets/page_images/' . $getImages[3]->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif"
                            alt="image" data-image="6s30uzgljny5"></figure>
                    </div>

                </section>


            @endif

            <!-----------------END - INDIVIDUAL LANDING  ----------------->


        @endif


    @elseif($page->slug=='contact-us')

        <!-- Start Contact Area -->

        <section class="contact-area pb-100" style="margin-top: 80px;padding-top: 5px;">

            <div class="container">
                <div class="section-title">
                    <span class="sub-title">Contact Us</span>
                    <h2>Drop us Message for any Query</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                </div>
            </div>




            <div class="contact-form">

                <div class="container">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form id="contactForm" action="{{ url('contact') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input type="text" name="name" id="name" class="form-control"
                                        data-error="Please enter your name" placeholder="Your Name" required>
                                    @if ($errors->has('name'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control"
                                        data-error="Please enter your email" placeholder="Your Email" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="phone" id="phone_number" data-error="Please enter your number"
                                        class="form-control" placeholder="Your Phone" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="subject" id="msg_subject" class="form-control"
                                        data-error="Please enter your subject" placeholder="Your Subject" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="5"
                                        data-error="Write your message" placeholder="Your Message" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <button type="submit" class="default-btn"><i
                                        class='bx bx-paper-plane icon-arrow before'></i><span class="label">Send
                                        Message</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="particles-js-circle-bubble-3"></div>
            <!--  <div class="contact-bg-image"><img src="assets/img/map.png" alt="image"></div> -->
        </section>
        <!-- End Contact Area -->

    @else


        @if ($page->getContent() && count($page->getContent()->get()) > 0)

            @php
                $getContent = $page->getContent()->get();
                $getImages = $page->getImages()->get();
            @endphp

            {!! $getContent[0]->content !!}

        @endif


    @endif







@endsection
@section('page-js')
    @include(theme('template-part.gateways.gateway-js'))
    <script>
        $('.subscrip').on('click', function() {
            var dataId = $(this).data('id');
            $('.subscrip-strip' + dataId).show();
            var packId = $('.packId' + dataId).val(dataId);
        })

    </script>
@endsection
