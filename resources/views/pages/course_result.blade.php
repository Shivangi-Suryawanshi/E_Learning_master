@extends('layouts.app')

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

  


        <!-- Start Courses Area -->
        <section class="courses-area ptb-1100">
            <div class="container">

               <div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="about-text">
                                <h3>1,000  Free Resources</h3>
                                <br>
                                </div>
                                </div>
                                </div>
                                </div>


                <div class="courses-topbar">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-3">
                              <div class="topbar-ordering">
                                            <select>
                                                <option>Sort by popularity</option>
                                                <option>Sort by latest</option>
                                                <option>Default sorting</option>
                                                <option>Sort by rating</option>
                                                <option>Sort by new</option>
                                            </select>
                                        </div>
                          
                        </div>

                        <div class="col-lg-9 col-md-9">
                            <div class="topbar-ordering-and-search">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="topbar-search">
                                            <form>
                                                <label><i class="bx bx-search"></i></label>
                                                <input type="text" class="input-search" placeholder="Search here...">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-5 offset-lg-4 offset-md-1">
                                         <div class="topbar-result-count">
                                <p>Showing - {{ count($free_resources) }} results</p>
                            </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="row">
                      <div class="col-lg-3 col-md-12">
                        <aside class="widget-area">


                            <!------------------------------>
                           <div class="faq-accordion">
                                <ul class="accordion">
                                   <!--  <li class="accordion-item">
                                        <a class="accordion-title active" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Price
                                        </a>
        
                                        <div class="accordion-content show">
                                           
                                        <div>
                                        <input type="radio" id="direct-bank-transfer" name="radio-group" checked>
                                            <label for="direct-bank-transfer"> &nbsp;Paid</label>
                                        </div>
                                            
                                    

                                        <div>
                                             <input type="radio" id="paypal" name="radio-group">
                                            <label for="paypal">&nbsp;Free</label>
                                        </div>
                                        </div>
                                    </li> -->

                                    <li class="accordion-item">
                                        <a class="accordion-title mb10" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Rating
                                        </a>
         
                                        <div class="accordion-content">
                                             <label class="mb0">
                                             <input type="radio" checked="checked" name="radio"> <div class="review-stars-rated filterr">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                       
                                                       <div> 4 Star & Up (512)</div>
                                                    </div>

                                             <span class="checkmark"></span>
                                            </label>

                                           <label class="mb0">
                                             <input type="radio" name="radio"> <div class="review-stars-rated filterr">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                       
                                                       
                                                       <div> 3 Star & Up (12)</div>
                                                    </div>

                                             <span class="checkmark"></span>
                                            </label>

                                             <label class="mb0">
                                             <input type="radio" name="radio"> <div class="review-stars-rated filterr">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                          
                                                       
                                                       <div> 2 Star & Up (2)</div>
                                                    </div>

                                             <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </li>

                                 

                                  

                                    <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Languages
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> English</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> Arabic</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> French</label>
                                        </div>

                                        </div>
                                    </li>


                                       <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Topic
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Topic 1</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> Topic 2</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Topic 3</label>
                                        </div>

                                        </div>
                                    </li>

                                     <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Document Type
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> PDF</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> WORD</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Excel</label>
                                        </div>

                                        </div>
                                    </li>

                                 

                                </ul>
                            </div>
                            <!-------------------------------->


                        </aside>
                    </div>


                    <div class="col-lg-9 col-md-12">
                        <div>


                         <!--------------new----------->
           <div class="shorting">
                    <div class="row">
                        @if(count($free_resources)>0)
                        @foreach($free_resources as $free)
                        <div class="col-lg-4 col-md-6 mix business design language">
                            <div class="single-courses-box mb-30">
                                <div class="courses-image">
                                    <a href="resource-detail.html" class="d-block"><img src="@if($free->img){!! asset('uploads/free_resources_images/'.$free->img) !!} @else {!! asset('images/noimage.png') !!} @endif" alt="image"></a>
    
                                </div>
    
                                        <div class="courses-desc">
                                            <div class="courses-content freef">
                                                
                
                                                <h3 class="fs14"><a href="{{ URL::to('/free-resource-detail/').'/'.$free->id }}" class="d-inline-block">@if(isset($free->title)) {!! $free->title !!} @endif</a></h3>
                
                                                <div class="courses-rating">
                                                    <div class="review-stars-rated">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                    </div>
                
                                                    <div class="rating-total">
                                                        5.0 (1 rating)
                                                    </div>
                                                </div>

                                                <p class="cp">@if(isset($free->short_desc)) {!! $free->short_desc !!} @endif</p>
                                            </div>
                
                                            <div class="courses-box-footer freef">
                                            <div align="center"><a href="@if($free->document){!! asset('uploads/free_resources_documents/'.$free->document) !!} @endif" target="_blank"><i class="bx bx-download"></i> Download</a></div>
                                            </div>
                                        </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
    
                         {{--  <div class="col-lg-4 col-md-6 mix business design language">
                            <div class="single-courses-box mb-30">
                                <div class="courses-image">
                                    <a href="resource-detail.html" class="d-block"><img src="assets/img/images/pdf.png" alt="image"></a>
    
                                </div>
    
                                        <div class="courses-desc">
                                            <div class="courses-content freef">
                                                
                
                                                <h3 class="fs14"><a href="resource-detail.html" class="d-inline-block">Document Name</a></h3>
                
                                                <div class="courses-rating">
                                                    <div class="review-stars-rated">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                    </div>
                
                                                    <div class="rating-total">
                                                        5.0 (1 rating)
                                                    </div>
                                                </div>

                                                <p class="cp">Education encompasses both the teaching and learning of knowledge.</p>
                                            </div>
                
                                            <div class="courses-box-footer freef">
                                            <div align="center"><a href="#!"><i class="bx bx-download"></i> Download</a></div>
                                            </div>
                                        </div>
                            </div>
                        </div> --}}
     {{--  <div class="col-lg-4 col-md-6 mix business design language">
                            <div class="single-courses-box mb-30">
                                <div class="courses-image">
                                    <a href="resource-detail.html" class="d-block"><img src="assets/img/images/doc.png" alt="image"></a>
    
                                </div>
    
                                        <div class="courses-desc">
                                            <div class="courses-content freef">
                                                
                
                                                <h3 class="fs14"><a href="resource-detail.html" class="d-inline-block">Document Name</a></h3>
                
                                                <div class="courses-rating">
                                                    <div class="review-stars-rated">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                    </div>
                
                                                    <div class="rating-total">
                                                        5.0 (1 rating)
                                                    </div>
                                                </div>

                                                <p class="cp">Education encompasses both the teaching and learning of knowledge.</p>
                                            </div>
                
                                            <div class="courses-box-footer freef">
                                            <div align="center"><a href="#!"><i class="bx bx-download"></i> Download</a></div>
                                            </div>
                                        </div>
                            </div>
                        </div>
 --}}    
                      
    
    
                       
                    </div>
                </div>
                          
                           <!--------------new----------->
        
        
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="pagination-area text-center">
                                     <a href="#" class="next page-numbers"><i class='bx bx-chevron-left'></i></a>
                                    <span class="page-numbers current" aria-current="page">1</span>
                                    <a href="#" class="page-numbers">2</a>
                                    <a href="#" class="page-numbers">3</a>
                                    <a href="#" class="page-numbers">4</a>
                                    <a href="#" class="page-numbers">5</a>
                                    <a href="#" class="next page-numbers"><i class='bx bx-chevron-right'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                  
                </div>
            </div>
            
        </section>
        <!-- End Courses Area -->
        <!-- End Become Instructor & Partner Area -->
@endsection
