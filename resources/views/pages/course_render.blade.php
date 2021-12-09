 @foreach($courses as $course)
 <div class="col-lg-12 col-md-12">
                                <div class="single-courses-list-box mb-30">
                                    <div class="box-item">
                                        <div class="courses-image">
                                            <div>
                                                

                                                <a href="{{ URL::to('course-detail/'.$course->id) }}" class="link-btn">
                                         <img src="@if($course->image) {{ asset('/uploads/course_images/'.$course->image) }} @else {!! asset('images/noimage.jpg') !!} @endif" alt="image" class="br5">
                                                </a>

                                                <!-- <div class="courses-tag">
                                                    <a href="#" class="d-block">Bestseller</a>
                                                </div> -->
                                            </div>
                                        </div>
            
                                        <div class="courses-desc">
                                            <div class="courses-content">
                                                
                
                                                <h3><a href="{{ URL::to('course-detail/'.$course->slug) }}" class="d-inline-block">{!! $course->title !!}</a></h3>
                
                                                <div class="courses-rating">
                                                   {{--  <div class="review-stars-rated">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                    </div> --}}

                                                     <div class="star-rating rateYo review-stars"></div>
                
                                                    <div class="rating-total">
                                                         {{-- (@if($course->avg_p) {!! $course->avg_p !!} @else 0 @endif rating) --}}
                                                         @if(avgRatings($course->id,'course')) ( {{ totalRatings($course->id,'course')->count() }} ratings) @else 0 ratings @endif
                                                    </div>
                                                </div>

                                                <p class="cp">@if($course->short_description) {!! $course->short_description !!} @endif</p>
                                            </div>
                
                                            <div class="courses-box-footer">
                                                <ul>
                                                    <li class="students-number">
                                                        <i class='bx bx-time'></i> 25 Total hours
                                                    </li>
                
                                                    <li class="courses-lesson">
                                                        <i class='bx bx-book-open'></i> 150 Lectures - All levels
                                                    </li>
                
                                                    <li class="courses-price">
                                                        ${!! $course->cost_per_person  !!}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {!! $courses->render() !!}