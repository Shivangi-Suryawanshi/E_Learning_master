<?php
$gridClass = $grid_class ? $grid_class : 'col-md-3'; ?>

<div class="{{ $gridClass }} course-card-grid-wrap ">
    <div class="course-card mb-5">

        <div class="course-card-img-wrap resimg">
            <a href="{{ route('course', $course->slug) }}">
                <img src="{{ $course->thumbnail_url }}" class="img-fluid br5" />
            </a>

            <button class="course-card-add-wish btn btn-link btn-sm p-0" data-course-id="{{ $course->id }}">
                @if ($auth_user && in_array($course->id, $auth_user->get_option('wishlists', [])))
                    <i class="la la-heart"></i>
                @else
                    <i class="la la-heart-o"></i>
                @endif
            </button>
        </div>

        <div class="course-card-contents shadow">
            <a href="{{ route('course', $course->slug) }}">
                <h6 class="course-card-title pad10 txtwrap mb0">{{ $course->title }}</h6>
                @if ($course->rating_count > 0)
                    <div class="course-card-info-wrap pad103">
                        @if ($course->rating_count)
                            <div class="course-card-ratings">
                                <div class="star-ratings-group d-flex">
                                    {!! star_rating_generator($course->rating_value) !!}
                                    <span class="star-ratings-point mx-2"><b>{{ $course->rating_value }}</b></span>
                                    <span class="text-muted star-ratings-count">({{ $course->rating_count }})</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div style="margin-bottom:17px;">&nbsp;</div>
                @endif



                <p class="course-card-short-info mb-2 d-flex justify-content-between pad102 fs13">
                    <span><i class="la la-play-circle fs18"></i> {{ $course->total_lectures }}
                        {{ __t('lectures') }}</span>
                    <span><i class="la la-signal fs18"></i> {{ course_levels($course->level) }}</span>
                </p>
            </a>

            <div class="course-card-info-wrap pad102">
                <p class="course-card-author d-flex justify-content-between fs13">
                    <span>
                        <i class="la la-user fs18"></i> by <a
                            href="{{ URL::to('user-profile/' . $course->author->id) }}">
                            @if ($course->author){{ $course->author->name }}
                            @endif
                        </a>
                    </span>

                </p>

                <p class="course-card-author d-flex justify-content-between fs13">

                    @if ($course->category)
                        <span>
                            <i class="la la-folder fs18"></i> in <a
                                href="{{ route('category_view', $course->category->slug) }}">{{ $course->category->category_name }}</a>
                        </span>
                    @endif
                </p>

            </div>

            <div class="course-card-footer mt-3 pad102">
                <div class="course-card-cart-wrap d-flex justify-content-between">
                    <p class="prstyle"> {!! $course->price_html(false, false) !!} </p>

                    {{-- <div class="course-card-btn-wrap mb15">
                        @if ($auth_user && in_array($course->id, $auth_user->get_option('enrolled_courses', [])))
                            <a class="btn btn-sm btn-theme-primary add-to-cart-btn adc" href="{{route('course', $course->slug)}}">{{__t('enrolled')}}</a>
                        @else
                            @php($in_cart = cart($course->id))
                            <button type="button" class="btn btn-sm btn-theme-primary add-to-cart-btn adc"  data-course-id="{{$course->id}}" {{$in_cart? 'disabled="disabled"' : ''}}>
                                @if ($in_cart)
                                    <i class='la la-check-circle'></i> {{__t('in_cart')}}
                                @else
                                    <i class="la la-shopping-cart"></i> {{__t('add_to_cart')}}
                                @endif
                            </button>
                        @endif
                    </div> --}}
                </div>
            </div>

        </div>

    </div>
</div>
