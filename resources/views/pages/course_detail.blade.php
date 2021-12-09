@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('css/jquery.rateyo.min.css') }}">

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
 <input type="hidden" name="existRate" id="existRate" value="@if($rating) {{ $rating->rating }} @else 2.5 @endif">
       

        <!-- Start Courses Details Area -->
        <section class="courses-details-area ptb-1100">
            <div class="container">
                <div class="courses-details-header">
                    <div class="row align-items-center">
                        <div class="col-lg-8">

          <div class="page-title-content">
                    <ul>
                        <li><a href="#!" class="tblack">Home</a></li>
                    <li class="tblack"><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li><a href="#!" class="tblack">Courses</a></li>
                        <li class="tblack"><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li class="tblack">{!! $course->title !!}</li>
                    </ul>
                   
                </div>


                            <div class="courses-title">
                                <h2>{!! $course->title !!}</h2>
                                <p>{!! $course->short_desc !!}</p>
                            </div>

                            <div class="courses-meta">
                                <ul>
                                    <li>
                                        <i class='bx bx-calendar'></i>
                                        <span>Last Updated</span>
                                        <a href="#!">{{ $course->updated_at->format('M d Y') }}</a>
                                    </li>
                                    <li>
                                        <i class='bx bx-folder-open'></i>
                                        <span>Language</span>
                                         @foreach($course->getLanguages()->get() as $key => $cl)                                   
                                        <a href="#!">{{ getAllLanguage($cl->language_id)->en_language }}</a> 
                                        @if(!$loop->last) , @endif
                                        @endforeach
                                    </li>

                                     <li>
                                        <i class='bx bx-user'></i>
                                        <span>Created by</span>
                                        <a href="#!">{{getUserData($course->user_id)->firstname}}</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="courses-price">
                                <div class="courses-review">
                                    {{-- <div class="review-stars">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </div> --}}
                                   
                                   
                                    <div class="rateyo-readonly-widg review-stars" id="rateYo"></div>
                                                                    
                  
                                    <span class="reviews-total d-inline-block">@if(avgRatings($course->id,'course')) ( {{ totalRatings($course->id,'course')->count() }} ratings) @else 0 ratings @endif</span>
                                </div>
                                                              
                                 @if(Auth::check() && getRating(Auth::user()->id,$course->id)==false)
                                 <a data-toggle="modal" data-target="#myModal" style="cursor: pointer">Write a review</a>
   @endif
                                 <br>
                                  @if(Illuminate\Support\Facades\Auth::check())
                            <div
                                data-id="{{ $course->id }}"
                                class="addtowishlist"
                                onclick="wishlist({{ $course->id }})"
                            >
                                <a
                                    href="javascript:void(0);"
                                    class="at-like wibg"
                                    ><div id="wish_{{ $course->id }}">
                                        @if(checkWishlist($course->id))<i
                                            class="fa fa-heart"
                                        ></i
                                        >@else <i class="fa fa-heart-o"></i>
                                    </div>
                                    @endif</a
                                >
                            </div>
                            @else
                            <div
                                data-id="{{ $course->id }}"
                                class="addtowishlist"
                            >
                                <a
                                    href="#!"
                                    data-toggle="modal"
                                    data-target="#loginpopup"
                                     class="at-like wibg">

                                    <i class="fa fa-heart-o"></i
                                ></a>
                            </div>
                            @endif
                                <div class="price">${!! $course->cost_per_person !!}</div>
                                @if(Auth::check() && checkPurchase(Auth::user()->id,$course->id))
                                Purchased
                                @elseif(Auth::check())
                                <a href="{{ URL::to('/checkout/'.$course->id) }}" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">Buy Course</span><i class="bx bx-paper-plane icon-arrow after"></i></a>
                                @else
               <a href="#!" class="default-btn" id="buyCourse"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">Buy Course</span><i class="bx bx-paper-plane icon-arrow after"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Write Review</h4>
      </div>
      <div class="modal-body">
       <div class="rateyo-readonly-widg review-stars"></div>
       <div class="col-xs-12">
           <label>Title</label>
           <input name="review_title" id="review_title" class="form-control">
       </div>
       <div class="col-xs-12">
               <label>Description</label>
               <textarea name="review_text" id="review_text" class="form-control"></textarea>
       </div>

      </div>
      <div class="modal-footer">
        <button type="button" id="submitReview" class="btn btn-default">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div></div></div>


                <div class="row">
                    <div class="col-lg-8">
                        <div class="courses-details-image text-center">
                            <img src="@if($course->image){!! asset('uploads/course_images/'.$course->image) !!} @else {!! asset('images/noimage.jpg') !!} @endif" alt="image">
                        </div>

                        <!--------accordion------------->
                        <div class="faq-accordion mt50">
                                <ul class="accordion">
                                    <li class="accordion-item">
                                        <a class="accordion-title active" href="javascript:void(0)">
                                            <i class="bx bx-chevron-down"></i>
                                           <h3 class="cdh"> What you'll learn </h3>
                                        </a>
        
                                        <div class="accordion-content show">
                                            <div class="courses-details-desc">
                                             <div class="why-you-learn">
                                                {!! $course->what_learn !!}
                              
                            </div>
                        </div>
                                        </div>
                                    </li>

                                    <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class="bx bx-chevron-down"></i>
                                            <h3 class="cdh"> Requirements </h3>
                                        </a>
        
                                        <div class="accordion-content">
                                            <div class="courses-details-desc">
                                              {{-- <ul class="requirements-list">
                                <li>Contrary to popular belief, Lorem Ipsum is not simply random text.</li>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.</li>
                                <li>The standard Lorem Ipsum passage, used since the 1500s.</li>
                            </ul> --}}
                             {!! $course->requirements !!}
                        </div>
                                        </div>
                                    </li>

                                    <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class="bx bx-chevron-down"></i>
                                           <h3 class="cdh"> Description </h3>
                                        </a>
        
                                        <div class="accordion-content">
                                            <div class="courses-details-desc">
                                           {{--  <p><strong>Hi! Welcome to Certified Graphic Design with Free Project Course, the only course you need to become a BI Analyst.</strong></p>
                            <p>We are proud to present you this one-of-a-kind opportunity. There are several online courses teaching some of the skills related to the BI Analyst profession. The truth of the matter is that none of them completely prepare you.</p>
                            <p><strong>Our program is different than the rest of the materials available online.</strong></p>
                            <p>It is truly comprehensive. The Business Intelligence Analyst Course comprises of several modules:</p> --}}
                            <p>{!! $course->description !!}</p>
                        </div>
                                        </div>
                                    </li>


                                    <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class="bx bx-chevron-down"></i>
                                           <h3 class="cdh"> Training Center </h3>
                                        </a>
        
                                        <div class="accordion-content">
                                            <section class="story-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="section-title text-left">
                            <a href="#!" class="d-block" style="background: #f7f7f7;">
                            <img src="@if($course->user_id && getInstitute($course->user_id)) {!! asset('uploads/provider_images/'.getInstitute($course->user_id)->logo) !!} @else {!! asset('images/noimage.png') !!} @endif" alt="image">
                        </a>
                            
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-12">
                        <div class="story-content">
                            <h3>@if($course->user_id && getInstitute($course->user_id)) {!! getInstitute($course->user_id)->institute_name !!} @endif</h3>
                            <p>@if($course->user_id && getInstitute($course->user_id)) {!! getInstitute($course->user_id)->about_institute !!} @endif</p>
                           
                         
                        </div>
                    </div>
                </div>
            </div>
        </section>
                                        </div>
                                    </li>

                                   
                                </ul>
                            </div>

                        <!--------accordion------------->

                        <div class="courses-details-desc">
                          

                            <h3>Meet your instructors</h3>

                            <!------instructor slider------>
                            <div class="feedback-slides-content">
                            

                            <div class="feedback-slides-two owl-carousel owl-theme">
                                <div class="single-feedback-slides-item">
                                     <div class="courses-author">
                                <div class="author-profile-header"></div>
                                <div class="author-profile">
                                    <div class="author-profile-title">
                                        <img src="assets/img/user1.jpg" class="shadow-sm rounded-circle" alt="image">

                                        <div class="author-profile-title-details d-flex justify-content-between">
                                            <div class="author-profile-details">
                                                <h4>James Anderson</h4>
                                                <span class="d-block">Php Developer</span>
                                            </div>

                                            <div class="author-profile-raque-profile">
                                                <a href="#!" class="d-inline-block">View Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                    <p>James Anderson is a celebrated photographer, author, and teacher who brings passion to everything he does.</p>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                </div>
                            </div>
                                </div>

                             <!--    <div class="single-feedback-slides-item">
                                     <div class="courses-author">
                                <div class="author-profile-header"></div>
                                <div class="author-profile">
                                    <div class="author-profile-title">
                                        <img src="assets/img/user2.jpg" class="shadow-sm rounded-circle" alt="image">

                                        <div class="author-profile-title-details d-flex justify-content-between">
                                            <div class="author-profile-details">
                                                <h4>James Anderson</h4>
                                                <span class="d-block">Photographer, Author, Teacher</span>
                                            </div>

                                            <div class="author-profile-raque-profile">
                                                <a href="#!" class="d-inline-block">View Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                    <p>James Anderson is a celebrated photographer, author, and teacher who brings passion to everything he does.</p>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                </div>
                            </div>
                                     
                                   
                                </div> 
 -->
                           

                                
                            </div>

                         
                        </div>


                    @if(count(totalRatings($course->id,'course'))>0)
    
                             <div class="courses-review-comments">
                                <h3>{{ count(totalRatings($course->id,'course')) }} Reviews</h3>
                               @foreach(totalRatings($course->id,'course') as $rating)
                                <div class="user-review">
                                    <img src="@if($rating->getUser && $rating->getUser->profile_pic){!! asset('profile_images/'.$rating->getUser->profile_pic) !!} @else {!! asset('images/noimage.jpg') !!} @endif" alt="image">
                                    
                                    <div class="review-rating">
                                        {{-- <div class="review-stars">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                        </div> --}}
  <div class="star-rating rateYo review-stars"></div>
                                        <span class="d-inline-block">@if($rating->getUser) {{ $rating->getUser->firstname }} @if($rating->getUser->lastname) {{ $rating->getUser->lastname }} @endif @endif</span>
                                    </div>
                                  

                                    <span class="d-block sub-comment">{!! $rating->review_title !!}</span>
                                    <p>{!! $rating->review_text !!}</p>
                                </div>
                                @endforeach

                               {{--  <div class="user-review">
                                    <img src="assets/img/user2.jpg" alt="image">
                                    
                                    <div class="review-rating">
                                        <div class="review-stars">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                        </div>

                                        <span class="d-inline-block">Sarah Taylor</span>
                                    </div>

                                    <span class="d-block sub-comment">Video Quality!</span>
                                    <p>Was really easy to implement and they quickly answer my additional questions!</p>
                                </div>

                                <div class="user-review">
                                    <img src="assets/img/user3.jpg" alt="image">
                                    
                                    <div class="review-rating">
                                        <div class="review-stars">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                        </div>

                                        <span class="d-inline-block">David Warner</span>
                                    </div>

                                    <span class="d-block sub-comment">Perfect Coding!</span>
                                    <p>Stunning design, very dedicated crew who welcome new ideas suggested by customers, nice support.</p>
                                </div> --}}
                            </div>
                            @endif
                        </div>

                        <div class="related-courses">
                            <h3>Related Courses</h3>

                            <div class="row">

                                <!---------related courses slider--------->

                                  <div class="courses-slides owl-carousel owl-theme">
                @foreach($relatedCourses as $key => $relatedCourse)
                    <div class="single-courses-box without-box-shadow mb-30">
                        <div class="courses-image">
                            <a href="#!" class="d-block"><img src="@if($relatedCourse->image){!! asset('uploads/course_images/'.$relatedCourse->image) !!} @else {!! asset('images/noimage.jpg') !!} @endif" alt="image"></a>

                          
                        </div>

                         <div class="courses-content">
                                                
                
                                                <h3><a href="#!" class="d-inline-block rcs">{{$relatedCourse->title_en}}</a></h3>
                
                                                <div class="courses-rating">
                                                    <!-- <div class="review-stars-rated">
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                    </div> -->
                                        <div class="rateYo relatedRate" id="relatedRate{{$key}}"></div>

 
                                                    <div class="rating-total">
                                                        ( @if(totalRatings($relatedCourse->id,'course')) {{ totalRatings($relatedCourse->id,'course')->count() }} ratings @else 0 ratings @endif )
                                                    </div>
                                                </div>

                                                <p class="cp">Education encompasses both the teaching and learning of knowledge.</p>
                                            </div>

                          <div class="courses-box-footer">
                                                <ul>
                                                    <li class="students-number">
                                                        <i class="bx bx-time"></i> 25 Total hours
                                                    </li>
                
                                                    <li class="courses-lesson">
                                                        <i class="bx bx-book-open"></i> 150 Lectures 
                                                    </li>
                
                                                    <li class="courses-price">
                                                        $150
                                                    </li>
                                                </ul>
                                            </div>
                    </div>
                @endforeach

                    <!-- <div class="single-courses-box without-box-shadow mb-30">
                        <div class="courses-image">
                            <a href="#!" class="d-block"><img src="assets/img/images/sup.jpg" alt="image"></a>

                           
                        </div>

                     <div class="courses-content">
                                                
                
                                                <h3><a href="#!" class="d-inline-block rcs">Supervisor Safety Awareness</a></h3>
                
                                                <div class="courses-rating">
                                                    <div class="review-stars-rated">
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                    </div>
                
                                                    <div class="rating-total">
                                                        5.0 (1 rating)
                                                    </div>
                                                </div>

                                                <p class="cp">Education encompasses both the teaching and learning of knowledge.</p>
                                            </div>

                          <div class="courses-box-footer">
                                                <ul>
                                                    <li class="students-number">
                                                        <i class="bx bx-time"></i> 25 Total hours
                                                    </li>
                
                                                    <li class="courses-lesson">
                                                        <i class="bx bx-book-open"></i> 150 Lectures
                                                    </li>
                
                                                    <li class="courses-price">
                                                        $150
                                                    </li>
                                                </ul>
                                            </div>
                    </div> -->

                   
                </div>

                                <!---------related courses slider---------->


                           
                         



                            </div>
                        </div>
                    </div>





                    <div class="col-lg-4">
                       {{--  <div class="courses-sidebar-information">
                            <ul>
                                <li>
                                    <span><i class="fa fa-video-camera" aria-hidden="true"></i> 18 hours on-demand video</span>
                                    
                                </li>
                                <li>
                                    <span><i class="fa fa-download" aria-hidden="true"></i> 17 downloadable resources</span>
                                    
                                </li>
                                <li>
                                    <span><i class="fa fa-graduation-cap" aria-hidden="true"></i> 2 practice tests</span>
                                   
                                </li>
                                 <li>
                                    <span><i class="fa fa-check" aria-hidden="true"></i> Full lifetime access</span>
                                   
                                </li>

                                 <li>
                                    <span><i class="fa fa-window-restore" aria-hidden="true"></i> Access on mobile and TV</span>
                                  
                                </li>

                              
                               
                             
                               
                              
                                <li>
                                    <span><i class='bx bx-certification'></i> Certificate of completion</span>
                                   
                                </li>
                            </ul>
                        </div> --}}

                       @if(count($previews)>0)
                        <!----------preview videos----------->
                        <aside class="widget-area">

                         <section class="widget widget_raque_posts_thumb">
                                <h3 class="widget-title">Preview Course</h3>

                                @foreach($previews as $preview)

                                <article class="item prlt">
                                    <a class="thumb">
                                        <span class="fullimage cover bg1" role="img"></span>
                                    </a>

                                    <div class="info">
                                        <a href="https://vimeo.com/467141591" class="attrachment-video popup-youtube vmod" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="bx bx-play-circle fs30"></i></a>
                                         <time datetime="2019-06-30">3 Hours</time>
                                        <h5 class="title usmall"><a href="#!">{!! $preview->title_en !!}</a></h5>
                                    </div>

                                    <div class="clear"></div>
                                </article>
                                @endforeach

                                {{--  <article class="item prlt">
                                    <a class="thumb">
                                        <span class="fullimage cover bg2" role="img"></span>
                                    </a>
                                    <div class="info">
                                       <a href="https://vimeo.com/467141591" class="attrachment-video popup-youtube vmod" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="bx bx-play-circle fs30"></i></a>
                                        <time datetime="2019-06-30">6 Hours</time>
                                        <h5 class="title usmall"><a href="#!">Certified Supervisor Safety Awareness Course</a></h5>
                                    </div>

                                    <div class="clear"></div>
                                </article>

                                <article class="item prlt">
                                    <a class="thumb">
                                        <span class="fullimage cover bg3" role="img"></span>
                                    </a>
                                    <div class="info">
                                       <a href="https://vimeo.com/467141591" class="attrachment-video popup-youtube vmod" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="bx bx-play-circle fs30"></i></a>
                                        <time datetime="2019-06-30">9 Hours</time>
                                        <h5 class="title usmall"><a href="#!">Certified Supervisor Safety Awareness Course</a></h5>
                                    </div>

                                    <div class="clear"></div>
                                </article> --}}

                                <br>
                            </section>
                        </aside>
                        @endif

                        <!----------preview videos----------->

                       

                        <div class="courses-purchase-info">
                            <h5>Interested in this course for your Business or Team?</h5>
                            <p>Train your employees in the most in-demand topics, with edX for Business.</p>

                            <a href="#!" class="d-inline-block">Purchase now</a>
                            <a href="#!" class="d-inline-block">Request Information</a>
                        </div>
                    </div>
                </div>
            </div>
         <input type="hidden" name="userId" id="userId" value="@if(Auth::check()) {{ \Auth::user()->id }} @else 0 @endif">
         <input type="hidden" name="get_rate" id="get_rate" value="@if(avgRatings($course->id,'course')) {{ avgRatings($course->id,'course') }} @else 0  @endif">

         <input type="hidden" name="temp_rate" id="temp_rate">
        </section>
        <!-- End Courses Details Area -->

@endsection
@section('additional_scripts')
<script>
   $(document).ready(function(){
     $("#buyCourse").click(function(){
        $("#loginModal").modal();
     });
   });
   </script>
<script src="{{ asset('js/jquery.rateyo.js')}}"></script>
 <script>

      $(function () {

          $.ajax({
          url: "{!! URL::to('course/all-rating') !!}",
      type: 'get',
      data: {
         "_token": "{{ csrf_token() }}",        
         'type' : 'course',
        'post_id' : {{ $course->id }},
      },
      success: function(response){
          //console.log(response);
          var demoRatings = response,
    stars       = $('.rateYo');

for (var i = 0; i < stars.length; i++) {
  $('.rateYo').eq(i).rateYo({ // select by index as an example
    halfStar: true,
    starWidth: "20px",
    rating: demoRatings[i],
    readOnly: true
  });
}
 
      }
  });

@php /*
var valOne = {{ json_encode(avgRatings($relatedCourses->get(0)->id,'course')) }};
var valTwo = {{ json_encode(avgRatings($relatedCourses->get(1)->id,'course')) }};

         $("#relatedRate0").rateYo({
            rating: valOne,            
 starWidth: "20px",
    readOnly: true
  });

         $("#relatedRate1").rateYo({
            rating: valTwo,            
 starWidth: "20px",
    readOnly: true
  });

*/

@endphp


        $("#rateYo").rateYo({
    rating: $('#get_rate').val(),
 starWidth: "20px",
    readOnly: true
  });

        var rating = $('#existRate').val();

        $(".counter").text(rating);

        $("#rateYo1").on("rateyo.init", function () { console.log("rateyo.init"); });
    

        $(".rateyo-readonly-widg").rateYo({

          rating: rating,
          starWidth: "30px",
          numStars: 5,
          precision: 2,
          minValue: 1,
          maxValue: 5
        }).on("rateyo.set", function (e, data) {


       $('#temp_rate').val(data.rating);
          
  
          console.log(data.rating);
        });

        $('#submitReview').click(function(e) {
 
               var temp_rate =  $('#temp_rate').val();
               var review_title =  $('#review_title').val();
               var review_text =  $('#review_text').val();

               $.ajax({
          url: "{!! URL::to('resource/rating') !!}",
      type: 'post',
      data: {
         "_token": "{{ csrf_token() }}",
        'rating' : temp_rate,
        'review_title' : review_title,
        'review_text' : review_text,
        'user_id' : $('#userId').val(),
         'type' : 'course',
        'post_id' : {{ $course->id }},
      },
      success: function(response){

          $('#myModal').modal('hide');
          //location.reload();
 
      }
  });
        });
      });
    </script>

<script>
    function wishlist(e) {
        // var url = "ajax/addToWishlist";
        var url = "{{ url('/ajax/addToWishlist') }}";



        $.ajax({
            type: "POST",
            url: url,
            data: { id: e , _token: '{{csrf_token()}}'},
            success: function (result) {
                console.log("success!", result);
                if (result.status == "remove") {
                    $("#wish_" + e).html("<i class='fa fa-heart-o'></i>");
                } else {
                    $("#wish_" + e).html("<i class='fa fa-heart'></i>");
                }
            },
            error: function (e) {},
        });
    }
</script>
@endsection