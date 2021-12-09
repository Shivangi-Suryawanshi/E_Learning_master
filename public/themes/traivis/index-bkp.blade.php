@extends('layouts.website')

@section('content')


<!-- Search Box Layout -->
        <div class="search-overlay">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>

                    <div class="search-overlay-close">
                        <span class="search-overlay-close-line"></span>
                        <span class="search-overlay-close-line"></span>
                    </div>

                    <div class="search-overlay-form">
                        <form>
                            <input type="text" class="input-search" placeholder="Search here...">
                            <button type="submit"><i class='bx bx-search-alt'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Box Layout -->

         <section class="business-coaching-banner" style=" background-image: url('{{asset('home_banners/'.getHomeBannerImg(getHomeBanner('home-section-1')->id)->logo)}}');">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">





  <div class="banner-wrapper-content mt150">
                    {{-- <h1>Take your next step towards <a href="#" class="typewrite" data-period="2000" data-type='[ "Employ", "Employ", "Employ", "Employ" ]'><span class="wrap"></span></a> Training</h1>
                    <p>95% of people learning for professional development report career benefits like getting a promotion, a raise, or starting a new career.</p> --}}
                    {!! getHomeBannerImg(getHomeBanner('home-section-1')->id)->content !!}

                    <!-- <div class="btn-box mt10">
                      <a class="optional-btn animated fadeInUp" style="opacity: 1;font-size: 16px;">What do you want to learn? &nbsp;</a>
                                    <a href="#!" class="default-btn animated fadeInLeft" style="opacity: 1;padding: 5px 10px 5px 10px;border-radius: 50px;"> Explore</a>


                                </div> -->

                    <form action="{{route('courses')}}" method="get">
                        <input type="text" class="input-search" name="q" value="{{request('q')}}" placeholder="{!! __t('what_do_you_want_to_learn') !!}">
                        <button type="submit">{!! __t('search_btn') !!}</button>
                    </form>                    

                    <br>

                </div>




                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="business-banner-image">
                            <img src="{{theme_asset('website/img/business-coaching/man.png')}}" alt="image">
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="business-shape1"><img src="assets/img/business-coaching/business-shape1.png" alt="image"></div> -->
            <div class="business-shape2"><img src="{{theme_asset('website/img/business-coaching/business-shape2.png')}}" alt="image"></div>
           <!--  <div class="business-shape3"><img src="assets/img/business-coaching/business-shape3.png" alt="image"></div> -->
        </section>
        <!-- Start Courses Categories Area -->
        <section class="courses-categories-area pt-100 pb-100">
            <div class="container">
                <div class="section-title text-left">
                    <span class="sub-title">{!! __t('courses_categories') !!}</span>
                    <h2>{!! __t('most_popular_certificates') !!}</h2>
                    <a href="{{ URL::to('/courses') }}" class="default-btn"><i class='bx bx-show-alt icon-arrow before'></i><span class="label">{!! __t('view_all') !!}</span><i class="bx bx-show-alt icon-arrow after"></i></a>
                </div>

                <div class="courses-categories-slides owl-carousel owl-theme">
                    <div class="single-categories-courses-item bg1 mb-30">
                        <div class="icon">
                            <!-- <i class='bx bx-code-alt'></i> -->
                        </div>
                        <h3>{!! __t('fall_protection_certificates') !!}</h3>
                        <span>{!! __t('10_centers_providing_this') !!}</span>

                        <a href="#!" class="learn-more-btn">{!! __t('btn_learn_more') !!} <i class='bx bx-book-reader'></i></a>

                        <a href="#!" class="link-btn"></a>
                    </div>

                    <div class="single-categories-courses-item bg2 mb-30">
                        <div class="icon">
                            <!-- <i class='bx bx-camera'></i> -->
                        </div>
                        <h3>Forklift Theory (Blended)  </h3>
                        <span>15+ Centers Providing this</span>

                        <a href="#!" class="learn-more-btn">{!! __t('btn_learn_more') !!} <i class='bx bx-book-reader'></i></a>

                        <a href="#!" class="link-btn"></a>
                    </div>

                    <div class="single-categories-courses-item bg3 mb-30">
                        <div class="icon">
                            <!-- <i class='bx bx-layer'></i> -->
                        </div>
                        <h3>{!! __t('aerial_work_platform') !!}</h3>
                        <span>{!! __t('25_centers_providing_this') !!}</span>

                        <a href="#!" class="learn-more-btn">{!! __t('btn_learn_more') !!} <i class='bx bx-book-reader'></i></a>

                        <a href="#!" class="link-btn"></a>
                    </div>

                    <div class="single-categories-courses-item bg4 mb-30">
                        <div class="icon">
                           <!--  <i class='bx bxs-flag-checkered'></i> -->
                        </div>
                        <h3>Supervisor  Safety Awareness</h3>
                        <span>15+ Centers Providing this</span>

                        <a href="#!" class="learn-more-btn">{!! __t('btn_learn_more') !!} <i class='bx bx-book-reader'></i></a>

                        <a href="#!" class="link-btn"></a>
                    </div>

                    <div class="single-categories-courses-item bg5 mb-30">
                        <div class="icon">
                            <!-- <i class='bx bx-health'></i> -->
                        </div>
                      <h3>{!! __t('fall_protection_certificates') !!}</h3>
                        <span>{!! __t('10_centers_providing_this') !!}</span>

                        <a href="#!" class="learn-more-btn">{!! __t('btn_learn_more') !!} <i class='bx bx-book-reader'></i></a>

                        <a href="#!" class="link-btn"></a>
                    </div>

                    <div class="single-categories-courses-item bg6 mb-30">
                        <div class="icon">
                            <!-- <i class='bx bx-line-chart'></i> -->
                        </div>
                        <h3>Forklift Theory (Blended)  </h3>
                        <span>15+ Centers Providing this</span>

                        <a href="#!" class="learn-more-btn">{!! __t('btn_learn_more') !!} <i class='bx bx-book-reader'></i></a>

                        <a href="#!" class="link-btn"></a>
                    </div>
                </div>
            </div>

            <div id="particles-js-circle-bubble-2"></div>
        </section>
        <!-- End Courses Categories Area -->

         <!-- Start Features Area -->
        <section class="features-area">
            <div class="container-fluid p-0">
                <div class="row m-0">
                    <div class="col-lg-3 col-sm-6 col-md-6 p-0">
                        <div class="single-features-box">
                            <div class="inner-content">
                                <h3>{!! __t('title_everything_online') !!}</h3>
                                <p>{!! __t('content_everything_online') !!}</p>
                                <a href="#!" class="default-btn"><i class='bx bx-log-in-circle icon-arrow before'></i><span class="label">{!! __t('btn_learn_more') !!}</span><i class="bx bx-log-in-circle icon-arrow after"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6 p-0">
                        <div class="single-features-box">
                            <div class="inner-content">
                                <h3>{!! __t('title_trusted_training') !!}</h3>
                                <p>{!! __t('content_trusted_training') !!}</p>
                                <a href="#!" class="default-btn"><i class='bx bx-log-in-circle icon-arrow before'></i><span class="label">{!! __t('btn_learn_more') !!}</span><i class="bx bx-log-in-circle icon-arrow after"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6 p-0">
                        <div class="single-features-box">
                            <div class="inner-content">
                                <h3>{!! __t('title_500k_courses') !!}</h3>
                                <p>{!! __t('content_500k_courses') !!}</p>
                                <a href="#!" class="default-btn"><i class='bx bx-log-in-circle icon-arrow before'></i><span class="label">{!! __t('btn_learn_more') !!}</span><i class="bx bx-log-in-circle icon-arrow after"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6 p-0">
                        <div class="single-features-box">
                            <div class="inner-content">
                                <h3>{!! __t('title_145_companies') !!}</h3>
                                <p>{!! __t('content_145_companies') !!}</p>
                                <a href="#!" class="default-btn"><i class='bx bx-log-in-circle icon-arrow before'></i><span class="label">{!! __t('btn_learn_more') !!}</span><i class="bx bx-log-in-circle icon-arrow after"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slideshow-box">
                <ul class='slideshow-slides owl-carousel owl-theme'>
                    <li><span class="bg3"></span></li>
                    <li><span class="bg2"></span></li>
                    <li><span class="bg1"></span></li>
                    <li><span class="bg4"></span></li>
                    <li><span class="bg5"></span></li>
                </ul>
            </div>
        </section>
        <!-- End Features Area -->

        <!-- Start Funfacts Area -->
        <section class="funfacts-style-two ptb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bx-group'></i>
                            </div>
                            <h3 class="odometer" data-count="4">00</h3>
                            <p>{{ __t('million_learners') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bxs-graduation'></i>
                            </div>
                            <h3 class="odometer" data-count="{{ totalTrainers() }}">00</h3>
                            <p>{{ __t('million_trainers') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bx-book-reader'></i>
                            </div>
                            <h3 class="odometer" data-count="{{ totalCourses() }}">00</h3>
                            <p>{{ __t('courses') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bx-world'></i>
                            </div>
                            <h3 class="odometer" data-count="{{ totalCompanies() }}">00</h3>
                            <p>{{ __t('companies') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="particles-js-circle-bubble"></div>
        </section>
        <!-- End Funfacts Area -->





        <!-- Start Courses Area -->
        <section class="courses-area ptb-100">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title">{{ __t('learn_at_your_own_pace') }}</span>
                    <h2>{{ __t('most_popular_courses') }}</h2>
                    <p>Explore all of our courses and pick your suitable ones to enroll and start learning with us! We ensure that you will never regret it!</p>
                </div>

                <div class="row">
                    @if($popular_courses->count())
                    @foreach($popular_courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <div class="courses-box">
                            <div class="courses-image">
                                <a href="#!" class="d-block image">
                                    <img src="{{ $course->thumbnail_url }}" alt="image">
                                </a>

                                <div class="price shadow">${{$course->price_plan == "paid" ? number_format($course->sale_price) : "Free" }}</div>
                            </div>
                            <div class="courses-content">

                                <h3><a href="{{route('course', $course->slug)}}">{{ $course->title }}</a></h3>
                                <p>{!!strlen($course->short_description) > 105 ? substr($course->short_description,0,109)."..." : $course->short_description!!}</p>
                                <ul class="courses-box-footer d-flex justify-content-between align-items-center">
                                    <li><i class='bx bx-book-reader'></i><a href="{{route('course', $course->slug)}}" class="txtg"> {{ __t('read_more') }} </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="courses-box">
                            <div class="courses-image">
                                <a href="#!" class="d-block image">
                                    <img src="{{theme_asset('website/img/images/fall.jpg')}}" alt="image">
                                </a>

                                <div class="price shadow">$49</div>
                            </div>
                            <div class="courses-content">

                                <h3><a href="#!">Fall Protection Certificates </a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                                <ul class="courses-box-footer d-flex justify-content-between align-items-center">
                                    <li><i class='bx bx-book-reader'></i><a href="#!" class="txtg"> Read More </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 offset-lg-0 offset-md-3">
                        <div class="courses-box">
                            <div class="courses-image">
                                <a href="#!" class="d-block image">
                                    <img src="{{theme_asset('website/img/images/sup.jpg')}}" alt="image">
                                </a>

                                <div class="price shadow">$59</div>
                            </div>
                            <div class="courses-content">

                                <h3><a href="#!">Supervisor  Safety Awareness</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                                <ul class="courses-box-footer d-flex justify-content-between align-items-center">
                                    <li><i class='bx bx-book-reader'></i><a href="#!" class="txtg"> Read More </a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-lg-12 col-md-12">
                        <div class="courses-info">
                            <p>Enjoy the top notch learning methods and achieve next level skills! You are the creator of your own career & we will guide you through that. <a href="#!" id="myBtn8">Register as Individual User!</a>.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="business-shape5"><img src="{{theme_asset('website/img/business-coaching/business-shape4.png')}}" alt="image"></div>
        </section>

        <!-- End Courses Area -->





         <!-- Start Feedback Area -->
        <section class="feedback-area-two pt-100 pb-100 faq-area bg-f8e8e9">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title">{!! __t('title_feedback') !!}</span>
                    <h2>{{ __t('title_our_testimonials') }}</h2>
                </div>

                <div class="feedback-slides owl-carousel owl-theme">

                    @foreach($testimonials as $testimonial)
                    <div class="single-feedback-box">
                        @if(App::getLocale()=='ar')
                        <p>{!! $testimonial->description_ar !!}</p>
                        @else
                         <p>{!! $testimonial->description_en !!}</p>
                         @endif

                        <div class="info">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="@if($testimonial->img){!! asset('testimonial_images/'.$testimonial->img) !!} @else {{ asset('images/noimage.jpg') }} @endif" alt="image">
                                <div class="title">
                                       @if(App::getLocale()=='ar')
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




      <!-- Start Partner Area -->
        <section class="partner-area pb-100 pt-100">
            <div class="container">
                <div class="section-title">
                    <h2>{!! __t('title_training_centers') !!}</h2>
                </div>

                <div class="partner-slides owl-carousel owl-theme">
                    <div class="single-partner-item">
                        <a href="#!" class="d-block">
                            <img src="{{theme_asset('website/img/partner/7.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#!" class="d-block">
                            <img src="{{theme_asset('website/img/partner/8.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#!" class="d-block">
                            <img src="{{theme_asset('website/img/partner/9.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#!" class="d-block">
                            <img src="{{theme_asset('website/img/partner/10.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#!" class="d-block">
                            <img src="{{theme_asset('website/img/partner/11.png')}}" alt="image">
                        </a>
                    </div>

                    <div class="single-partner-item">
                        <a href="#!" class="d-block">
                            <img src="{{theme_asset('website/img/partner/12.png')}}" alt="image">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Partner Area -->

       <!-- Start Become Instructor & Partner Area -->
        <section class="become-instructor-partner-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="become-instructor-partner-content bg-color">
                            <h2>{{ __t('title_register_training_centers') }}</h2>
                            <p>{{ __t('content_register_training_centers') }}</p>
                            <a href="{{ URL::to('register/instructor') }}" class="default-btn" id="myBtn6"><i class='bx bx-plus-circle icon-arrow before'></i><span class="label">{{ __t('register') }}</span><i class="bx bx-plus-circle icon-arrow after"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="become-instructor-partner-image bg-image1 jarallax" data-jarallax='{"speed": 0.3}'>
                            <img src="{{theme_asset('website/img/become-instructor.jpg')}}" alt="image">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="become-instructor-partner-image bg-image2 jarallax" data-jarallax='{"speed": 0.3}'>
                            <img src="{{theme_asset('website/img/become-partner.jpg')}}" alt="image">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="become-instructor-partner-content">
                            <h2>{{ __t('title_register_as_company') }}</h2>
                            <p>{{ __t('content_register_as_company') }}</p>
                            <a href="{{ URL::to('register/company') }}" class="default-btn" id="myBtn7"><i class='bx bx-plus-circle icon-arrow before'></i><span class="label">{{ __t('register') }}</span><i class="bx bx-plus-circle icon-arrow after"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Become Instructor & Partner Area -->



      <!-- original codes -->


   {{--  <div class="hero-banner py-3">

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">

                    <div class="hero-left-wrap">
                        <h1 class="hero-title mb-4">{{__t('hero_title')}}</h1>
                        <p class="hero-subtitle  mb-4">
                            {!! __t('hero_subtitle') !!}
                        </p>
                        <a href="{{route('categories')}}" class="btn btn-theme-primary btn-lg">Browse Course</a>
                    </div>

                </div>


                <div class="col-md-12 col-lg-6 hero-right-col">
                    <div class="hero-right-wrap">
                        <img src="{{theme_url('images/hero-image.png')}}" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div class="home-section-wrap home-info-box-wrapper py-5">
        <div class="container">
            <div class="row">

                <div class="col-md-3">
                    <div class="home-info-box">
                        <img src="{{theme_url('images/skills.svg')}}">
                        <h3 class="info-box-title">Learn the latest skills</h3>
                        <p class="info-box-desc">like business analytics, graphic design, Python, and more</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="home-info-box">
                        <img src="{{theme_url('images/career-goal.svg')}}">
                        <h3 class="info-box-title">Get ready for a career</h3>
                        <p class="info-box-desc">in high-demand fields like IT, AI and cloud engineering</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="home-info-box">
                        <img src="{{theme_url('images/instructions.svg')}}">
                        <h3 class="info-box-title">Expert instruction</h3>
                        <p class="info-box-desc">Every course designed by expert instructor</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="home-info-box">
                        <img src="{{theme_url('images/cartificate.svg')}}">
                        <h3 class="info-box-title">Earn a certificate</h3>
                        <p class="info-box-desc">Get certified upon completing a course</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if($featured_courses->count())
        <div class="home-section-wrap home-featured-courses-wrapper py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-header-wrap">
                            <h3 class="section-title">
                                {{__t('featured_courses')}}

                                <a href="{{route('featured_courses')}}" class="btn btn-link float-right"><i class="la la-bookmark"></i> {{__t('all_featured_courses')}}</a>
                            </h3>

                            <p class="section-subtitle">{{__t('featured_courses_desc')}}</p>
                        </div>
                    </div>
                </div>
                <div class="popular-courses-cards-wrap mt-3">
                    <div class="row">
                        @foreach($featured_courses as $course)
                            {!! course_card($course, 'col-md-4') !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="mid-callto-action-wrap text-white text-center py-5">
        <div class="container py-3">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-3">Find the perfect course for you</h2>
                    <h4 class="mb-3 mid-callto-action-subtitle">Choose from over 100 online video courses <br /> with new additions published every day</h4>

                    <a href="{{route('courses')}}" class="btn btn-warning btn-lg" >Find new courses</a>
                </div>
            </div>
        </div>
    </div>

    @if($popular_courses->count())
        <div class="home-section-wrap home-fatured-courses-wrapper py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-header-wrap">
                            <h3 class="section-title">{{__t('popular_courses')}}

                                <a href="{{route('popular_courses')}}" class="btn btn-link float-right"><i class="la la-bolt"></i> {{__t('all_popular_courses')}}</a>
                            </h3>
                            <p class="section-subtitle">{{__t('popular_courses_desc')}}</p>
                        </div>
                    </div>
                </div>
                <div class="popular-courses-cards-wrap mt-3">
                    <div class="row">
                        @foreach($featured_courses as $course)
                            {!! course_card($course) !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if($new_courses->count())
        <div class="home-section-wrap home-new-courses-wrapper py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-header-wrap">
                            <h3 class="section-title">{{__t('new_arrival')}}

                                <a href="{{route('courses')}}" class="btn btn-link float-right"><i class="la la-list"></i> {{__t('all_courses')}}</a>
                            </h3>
                            <p class="section-subtitle">{{__t('new_arrival_desc')}}</p>
                        </div>
                    </div>
                </div>

                <div class="popular-courses-cards-wrap mt-3">
                    <div class="row">
                        @foreach($new_courses as $course)
                            {!! course_card($course) !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($posts->count())
    <div class="home-section-wrap home-blog-section-wrapper py-5">

        <div class="container">

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="section-header-wrap">
                        <h3 class="section-title">{{__t('latest_blog_text')}}</h3>
                        <p class="section-subtitle">{{__t('latest_blog_desc')}}</p>
                    </div>
                </div>
            </div>


            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-4 mb-4">
                        <div class="home-blog-card">
                            <a href="{{$post->url}}">
                                <img src="{{$post->thumbnail_url->image_md}}" alt="{{$post->title}}" class="img-fluid">
                            </a>
                            <div class="excerpt px-4">
                                <h2><a href="{{$post->url}}">{{$post->title}}</a></h2>
                                <div class="post-meta d-flex justify-content-between">
                                    <span>
                                        <i class="la la-user"></i>
                                        <a href="{{route('profile', $post->user_id)}}">
                                            {{$post->author->name}}
                                        </a>
                                    </span>
                                    <span>&nbsp;<i class="la la-calendar"></i>&nbsp; {{$post->published_time}}</span>
                                </div>
                                <p class="mt-4">
                                    <a href="{{$post->url}}"><strong>READ MORE <i class="la la-arrow-right"></i> </strong></a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="btn-see-all-posts-wrapper pt-4">
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <a href="{{route('blog')}}" class="btn btn-lg btn-theme-primary ml-auto mr-auto">
                            <i class="la la-blog"></i> See All Posts
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @endif

    <div class="home-section-wrap home-cta-wrapper py-5 ">

        <div class="home-partners-logo-section pb-5 mb-5 text-center">
            <div class="container">

                <h5 class="home-partners-title mb-5">Companies use Teachify to enrich their brand & business.</h5>

                <div class="home-partners-logo-wrap">
                    <div class="logo-item">
                        <a href=""><img src="{{theme_url('images/adidas.png')}}" alt="adidas" /></a>
                    </div>
                    <div class="logo-item">
                        <a href=""><img src="{{theme_url('images/disnep.png')}}" alt="images" /></a>
                    </div>
                    <div class="logo-item">
                        <a href=""><img src="{{theme_url('images/intel.png')}}" alt="intel" /></a>
                    </div>
                    <div class="logo-item">
                        <a href=""><img src="{{theme_url('images/penlaw.png')}}" alt="penlaw" /></a>
                    </div>
                    <div class="logo-item">
                        <a href=""><img src="{{theme_url('images/shopify.png')}}" alt="shopify" /></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="home-course-stats-wrap pb-5 mb-5 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-3"><h3>580</h3> <h5>Active Courses</h5></div>
                    <div class="col-md-3"> <h3>1200</h3> <h5>Hours Video</h5></div>
                    <div class="col-md-3"><h3>850</h3> <h5>Teachers</h5></div>
                    <div class="col-md-3"><h3>1800</h3> <h5>Students Learning</h5></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-6 home-cta-left-col">

                    <div class="home-cta-text-wrapper px-5 text-center">
                        <h4>Become an instructor</h4>
                        <p>Spread your knowledge to millions of students around the world through teachify teaching platform. You can teach any tech you love from heart.
                        </p>
                        <a href="{{route('create_course')}}" class="btn btn-theme-primary">Start Teaching Today</a>

                    </div>

                </div>

                <div class="col-sm-6">

                    <div class="home-cta-text-wrapper px-5 text-center">
                        <h4>Discover latest technology</h4>
                        <p>Earn new skills and enroll to the new courses. Continuous learning is only key to keep your self up-to-date with modern technology.
                        </p>
                        <a href="{{route('courses')}}" class="btn btn-theme-primary">{{__t('find_new_courses')}}</a>
                    </div>

                </div>

            </div>
        </div>

    </div>--}}

@endsection
