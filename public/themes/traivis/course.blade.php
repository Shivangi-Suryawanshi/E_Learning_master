@extends('layouts.website')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')

    @php
    $contine_url = $course->continue_url;
    @endphp

    <style>
        span.discount-text.mr-2 {
            font-size: 14px;
        }

        span.old-price {
            color: red;
        }

        .raque-nav .navbar .navbar-nav .nav-item a {
            padding-top: 5px !important;
        }

        .nav-link img {
            padding-top: 30px;
        }

    </style>



    <div class="page-header-jumborton py-5 funfacts-style-two pad80">

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="page-header-left">
                        <h3 class="text-white fw300">{{ clean_html($course->title) }}</h3>
                        @if ($course->short_description)
                            <p class="page-header-subtitle m-0 text-white">{{ clean_html($course->short_description) }}
                            </p>
                        @endif

                        <p class="mt-3 course-head-meta-wrap text-white">
                            <span class="mr-3"><i class="la la-signal cicons2"></i> {{ course_levels($course->level) }}
                            </span>


                            <span class="created-by mr-3">
                                <i class="la la-user cicons2"></i> {{ __t('created_by') }} <a style="color: #fff"
                                    href="{{ URL::to('user-profile/' . $course->author->id) }}">
                                    {{ $course->author->name }}
                                </a>
                            </span>


                            <span class="last-updated-at clrwhite mr-3">
                                <i class="la la-clock cicons2"></i>
                                {{ __t('last_updated') }}
                                {{ $course->last_updated_at->format('y M d') }}
                                {{-- ->format(date_time_format()) --}}
                            </span>
                            {{-- <br> --}}

                            {{-- //section type --}}

                            {{-- <br> --}}
                        <div></div>
                        {{-- //section type --}}
                       

                        <span class="last-updated-at clrwhite mr-3">
                            <i class="la la-database cicons2"></i>
                            {{ __t('section') }}
                            @php
                                $faceToFace = $course->sections->where('section_type', 1)->first();
                                $recorderd = $course->sections->where('section_type', 2)->first();
                                $live = $course->sections->where('section_type', 3)->first();
                                // dd($faceToFace);
                            @endphp
                            @if ($faceToFace)
                                Face To Face
                            @endif
                            @if ($recorderd)
                                @if ($faceToFace || $live)
                                    +
                                @endif
                                Recorderd
                            @endif
                            @if ($live)
                                @if ($recorderd || $faceToFace)
                                    +
                                @endif
                                Live
                            @endif
                            <i class="la la-database cicons2"></i>
                            @if($course->available_student >= 0 && $course->available_student != null)
                            
                            Max Seat Available : {{ $course->available_student }}
                            @else

                            @endif

                            {{-- ->format(date_time_format()) --}}
                        </span>

                        @if ($course->cert_accr && $course->price_plan == 'paid')
                            <span class="clrwhite"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                {!! $course->cert_accr !!}
                            </span>
                        @endif
                        </p>
                        @if ($course->rating_count)
                            <div class="course-card-ratings mb10">
                                <div class="star-ratings-group d-flex">
                                    {!! star_rating_generator($course->rating_value) !!}
                                    <span
                                        class="star-ratings-point mx-2 clrwhite"><b>{{ $course->rating_value }}</b></span>
                                    <span
                                        class="text-muted star-ratings-count clrwhite">({{ $course->rating_count }})</span>
                                </div>
                            </div>
                        @endif



                    </div>
                </div>

                <div class="col-md-4">

                    <div class="page-header-right-enroll-box p-3 mt-sm-4 mt-md-0 bg-white br55" align="center">
                        
                        @if ($isEnrolled)

                            <p class="text-muted"><strong>Enrolled At</strong> :
                                {{ date('F d, Y', strtotime($isEnrolled->enrolled_at)) }} </p>

                            <a href="{{ $contine_url }}" class="btn btn-info btn-lg btn-block"><i
                                    class="la la-play-circle"></i> Continue course</a>

                        @else
                            @if ($course->paid)

                                <div class="course-landing-page-price-wrap fs20">
                                    {!! $course->price_html(false, true) !!}
                                </div>

                                <form action="{{ route('add_to_cart') }}" class="add_to_cart_form" method="post">
                                    @csrf

                                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                                    <div class="enroll-box-btn-group mt-3">
                                        @if($course->available_student == 0 && $course->available_student != null)

                                        <a  class="btn btn-lg btn-outline-dark btn-block bord"
                                        >Seat Full</a>
                                                @else
                                        <?php $in_cart = cart($course->id); ?>
                                        {{-- <button type="button" class="btn btn-lg btn-theme-primary adc btn-block mb-3 add-to-cart-btn" data-course-id="{{$course->id}}" name="cart_btn" value="add_to_cart" {{$in_cart? 'disabled="disabled"' : ''}} >
                                            @if ($in_cart)
                                                <i class='la la-check-circle'></i> Added to cart
                                            @else
                                                <i class="la la-shopping-cart"></i> Add to cart
                                            @endif
                                        </button> --}}
                                        <button type="submit" class="btn btn-lg btn-outline-dark btn-block bord"
                                            name="cart_btn" value="buy_now">Buy now</button>
                                            @endif
                                    </div>
                                </form>

                            @elseif($course->free)
                                <div class="row">
                                    
                                    @if($course->available_student == 0 && $course->available_student != null)
                                    <button  class="btn btn-primary btn-md"><i
                                             aria-hidden="true"></i>
                                            Seat full
                                    </button>
                                            @else

                                    <div class="col-md-4">
                                        <div class="course-landing-page-price-wrap fs25" align="right">
                                            {!! $course->price_html(false, true) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                    
                                           
                                        <form action="{{ route('free_enroll') }}" class="course-free-enroll mb0"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <button type="submit" class="btn btn-primary btn-md"><i
                                                    class="fa fa-paper-plane" aria-hidden="true"></i>
                                                {{ __t('enroll_now') }}</button>
                                        </form>
                                      
                                    </div>
                                      @endif
                                </div>
                            @endif
                        @endif

                    </div>

                </div>

            </div>
        </div>

    </div>


    <div class="container my-4">

        <div class="row">
            <div class="col-md-10 offset-md-1">


                <div class="course-details-wrap">


                    <div class="course-intro-stats-wrapper mb-4">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="course-whats-included-box course-widget p-4">

                                    <div class="about-text">
                                        <h3 class="mb-4">{{ __t('whats_included') }}</h3>
                                    </div>

                                    @php
                                        $lectures_count = $course->lectures->count();
                                        $assignments_count = $course->assignments->count();
                                        $attachments_count = $course->contents_attachments->count();
                                    @endphp

                                    <ul type="none" class="mlm40">
                                        @if ($course->total_video_time)
                                            <li> <i class="fa fa-video-camera cicons3"></i>
                                                {{ seconds_to_time_format($course->total_video_time) }}
                                                {{ __t('on_demand_video') }} </li>
                                        @endif

                                        <li> <i class="fa fa-book cicons3"></i> {{ $lectures_count }}
                                            {{ __t('lectures') }} </li>
                                        @if ($assignments_count)
                                            <li> <i class="fa fa-server cicons3"></i> {{ $assignments_count }}
                                                {{ __t('assignments') }}</li>
                                        @endif
                                        @if ($attachments_count)
                                            <li> <i class="fa fa-download cicons3"></i> {{ $attachments_count }}
                                                downloadable resources </li>
                                        @endif

                                        <li> <i class="fa fa-tablet cicons3"></i> Access on tablet and phone </li>
                                        <li> <i class="fa fa-graduation-cap cicons3"></i> Certificate of completion </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="col-md-6">

                                @if ($course->video_info())
                                    <h6 align="center" style="font-weight: bold;"> @include(theme('video-player'), ['model'
                                        => $course, 'video_caption' => __t('preview')])</h6>
                                @else
                                    <img src="{{ media_image_uri($course->thumbnail_id)->image_md }}"
                                        class="img-fluid" />
                                @endif


                            </div>
                        </div>

                    </div>



                    @if ($course->benefits_arr)
                        <div class="course-widget mb-4 p-4">
                            <div class="about-text">
                                <h3 class="mb-4">{{ __t('what_learn') }}</h3>
                            </div>

                            <div class="content-expand-wrap">
                                <div class="content-expand-inner">
                                    <ul class="benefits-items row mlm55">
                                        @foreach ($course->benefits_arr as $benefit)
                                            <li class="col-6 benefit-item d-flex mb-2">
                                                <i class="la la-check-square cicons"></i>
                                                <span class="benefit-item-text ml-2">{{ $benefit }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($course->sections->count())

                        <div class="course-curriculum-header d-flex mt-5 ml25">
                            <div class="about-text">
                                <div class="about-text">
                                    <h3 class="mb-4 course-curriculum-title flex-grow-1">{{ __t('course_curriculum') }}
                                    </h3>
                                </div>
                            </div>

                            <p id="expand-collapse-all-sections" class="hidden-xs">
                                <a href="javascript:;" data-action="expand" class="eall">Expand all</a>
                                <a href="javascript:;" data-action="collapse" class="eall" style="display: none;">Collapse
                                    all</a>
                            </p>

                            <p class="ml-3 course-total-lectures-info hidden-xs">{{ $course->total_lectures }}
                                {{ __t('lectures') }}
                            </p>
                            <p class="ml-3 mr-3 course-runtime-info hidden-xs">
                                {{ seconds_to_time_format($course->total_video_time) }}</p>
                        </div>

                        <div class="course-curriculum-wrap mb-4 ml25">

                            @foreach ($course->sections as $section)

                                <div id="course-section-{{ $section->id }}" class="course-section bg-white border mb-2">

                                    <div class="course-section-header bg-light p-3 border-bottom d-flex">
                                        <span class="course-section-name flex-grow-1 ml-2">
                                            <strong>
                                                <i class="la la-{{ $loop->first ? 'minus' : 'plus' }}"></i>
                                                {{ $section->section_name }}

                                            </strong>
                                            <br>
                                            {{-- @if (Auth::check())
                                                @if ($section->liveSection) --}}
                                                    {{-- @foreach ($section->liveSection->liveSectionUser as $liveSectionItem) --}}
                                                        {{-- @if ($liveSectionItem->user_id == Auth::user()->id)
                                                            Live schedule link : {{ $section->liveSection->team_link }}
                                                            <br>
                                                            @endif --}}
                                                            {{-- Max Available :
                                                            {{ $section->liveSection->max_num_of_participate }} <br> --}}
                                                            {{-- <br> --}}
                                                        
                                                    {{-- @endforeach --}}

                                                {{-- @endif
                                            @endif --}}
                                        </span>

                                        <span class="course-section-lecture-count">
                                            {{ $section->items->count() }} {{ __t('lectures') }}
                                        </span>
                                    </div>

                                    <div class="course-section-body"
                                        style="display: {{ $loop->first ? 'block' : 'none' }};">

                                        @if ($section->items->count())
                                            @foreach ($section->items as $item)
                                                <div class="course-curriculum-item border-bottom pl-4 d-flex p10">
                                                    <p class="curriculum-item-title m-0 flex-grow-1">

                                                        <a {{-- href="{{route('single_'.$item->item_type, [$course->slug, $item->id ] )}}" --}}>
                                                            <span class="curriculum-item-icon mr-2">
                                                                {!! $item->icon_html !!}
                                                            </span>
                                                            <span class="curriculum-item-title">
                                                                {{ clean_html($item->title) }}
                                                            </span>
                                                        </a>
                                                    </p>

                                                    <p class="course-section-item-details d-flex m-0">
                                                        <span class="section-item-preview flex-grow-1">
                                                            @if ($item->is_preview)
                                                                <a {{-- href="{{route('single_lecture', [$course->slug, $item->id ] )}}" --}}>
                                                                    <i class="la la-eye"></i> {{ __t('preview') }}
                                                                </a>
                                                            @endif
                                                        </span>

                                                        @if ($item->attachments->count())
                                                            <span class="section-item-attachments mr-3"
                                                                data-toggle="tooltip"
                                                                title="{{ __t('dl_resource_available') }}">
                                                                <i class="la la-paperclip"></i>
                                                            </span>
                                                        @endif

                                                        <span class="section-item-duration ml-auto">
                                                            {{ $item->runtime }}
                                                        </span>
                                                    </p>

                                                </div>
                                            @endforeach
                                        @endif

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endif

                    @if ($course->requirements_arr)

                        <div class="about-text" style="margin-top:50px;">
                            <h3 class="mb-4 ml25">{{ __t('requirements') }}</h3>
                        </div>

                        <div class="course-widget mb-4 p-4">
                            <ul class="benefits-items row mlm55">
                                @foreach ($course->requirements_arr as $requirement)
                                    <li class="col-6 benefit-item d-flex mb-2">
                                        <i class="la la-info-circle cicons cicons"></i>
                                        <span class="benefit-item-text ml-2">{{ $requirement }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($course->description)
                        <div class="course-description mt-4 mb-5">

                            <div class="about-text">
                                <h3 class="mb-4 course-description-title ml25">{{ __t('description') }}</h3>
                            </div>

                            <div class="content-expand-wrap ml25">
                                <div class="content-expand-inner">
                                    {!! $course->description !!}
                                </div>
                            </div>
                        </div>
                    @endif


                    <div id="course-instructors-wrap" class="my-5">

                        <div class="about-text">

                            <h3 class="mb-4 ml25">{{ __t('instructors') }}</h3>
                        </div>

                        <div class="row">

                            @foreach ($course->instructors as $instructor)
                                @php
                                    $courses_count = $instructor
                                        ->courses()
                                        ->publish()
                                        ->count();
                                    $students_count = $instructor->student_enrolls->count();
                                    $instructor_rating = $instructor->get_rating;
                                @endphp

                                <div class="course-single-instructor-wrap mb-4 ml25 shadow col-md-4" style="padding: 10px;">

                                    <div class="instructor-details mb-3">
                                        <a href="{{ URL::to('user-profile/' . $course->author->id) }}">
                                            <h6 class="instructor-name">{{ $instructor->name }}</h6>
                                        </a>

                                        @if ($instructor->job_title)
                                            <h5 class="instructor-designation">{{ $instructor->job_title }}</h5>
                                        @endif

                                        @if ($instructor->about_me)
                                            <div class="profle-about-me-text mt-4">
                                                <div class="content-expand-wrap">
                                                    <div class="content-expand-inner">
                                                        {!! nl2br($instructor->about_me) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="instructor-stats">
                                        <div class="profile-image mb-4">
                                            <a href="{{ URL::to('user-profile/' . $course->author->id) }}">
                                                <span class="pfoto">{!! $instructor->get_photo !!}</span>
                                            </a>
                                        </div>

                                        @if ($instructor_rating->rating_count)
                                            <div class="profile-rating-wrap d-flex">
                                                {!! star_rating_generator($instructor_rating->rating_avg) !!}
                                                <p class="m-0 ml-2">({{ $instructor_rating->rating_avg }})</p>
                                            </div>
                                        @endif

                                        <p class="instructor-stat-value mb-1">
                                            <i class="la la-play-circle cicons"></i>
                                            <strong>{{ $courses_count }}</strong> {{ __t('courses') }}
                                            &nbsp;&nbsp;&nbsp;
                                            <i class="la la-user-circle cicons"></i>
                                            <strong>{{ $students_count }}</strong> {{ __t('students') }}
                                            &nbsp;&nbsp;&nbsp;
                                            <i class="la la-comments cicons"></i>
                                            <strong>{{ $instructor_rating->rating_count }} </strong>
                                            {{ __t('reviews') }}
                                        </p>
                                    </div>




                                </div>

                            @endforeach
                        </div>
                    </div>


                    @if ($course->reviews->count())
                        <div id="course-ratings-wrap">

                            <div class="about-text">
                                <h3 class="mb-4 ml25">{{ __t('student_feedback') }}</h3>
                            </div>

                            <div id="course-rating-stats-wrap" class="my-4 d-flex ml25">
                                <div class="rating-stats-avg mr-5">
                                    <p class="rating-avg-big m-0">{{ $course->rating_value }}</p>
                                    {!! star_rating_generator($course->rating_value) !!}
                                    <p class="number-of-reviews mt-3">
                                        {{ sprintf(__t('from_amount_reviews'), $course->rating_count) }}
                                    </p>
                                </div>

                                <div class="star-rating-reviews-bar-wrap flex-grow-1">
                                    @foreach ($course->get_ratings('stats') as $rateKey => $rating)
                                        <div class="rating-percent-wrap d-flex">
                                            <div class="star-rating-bar-bg">
                                                <div class="star-rating-bar-fill"
                                                    style="width: {{ array_get($rating, 'percent') }}%"></div>
                                            </div>

                                            <div class="star-rating-percent-wrap">
                                                {!! star_rating_generator($rateKey) !!}
                                            </div>
                                            <p class="rating-percent-text m-0">{{ array_get($rating, 'percent') }}%</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="reviews-list-wrap ml25">
                                @foreach ($course->reviews as $review)

                                    <div class="single-review border-top d-flex my-3 py-3">
                                        <div class="reviewed-user">
                                            <div class="reviewed-user-photo">

                                                {{-- href="{{route('profile', $review->user->id)}}" --}}

                                                <a class="pfoto">

                                                    @if ($review->user)
                                                        {!! $review->user->get_photo !!}
                                                    @endif

                                                </a>

                                            </div>
                                            <div class="reviewed-user-name" style="margin-top:13px; margin-right:13px;">
                                                <p class="mb-1">
                                                    <a href="{{ route('review', $review->id) }}"
                                                        class="text-muted ">{{ $review->created_at->diffForHumans() }}</a>
                                                </p>
                                                <a {{-- href="{{route('profile', $review->user->id)}}" --}}>
                                                    @if ($review->user)
                                                        {!! $review->user->name !!} @endif
                                                </a>
                                            </div>
                                        </div>

                                        <div class="review-details">
                                            {!! star_rating_generator($review->rating) !!}
                                            @if ($review->review)
                                                <div class="review-desc mt-3">
                                                    {!! nl2br($review->review) !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>



@endsection
