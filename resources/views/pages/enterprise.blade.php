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

  

        <!-- Start Courses Area -->
        <section class="courses-area ptb-1100">
            <div class="container">

               <div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="about-text">
                                <h3>100,000 online courses</h3>
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
                                                <option>Most Popular</option>
                                                <option>Highest Rated</option>
                                                <option>Newest</option>
                                                
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
                                <p>Showing - 25 results</p>
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

                                      <li class="accordion-item">
                                        <a class="accordion-title active" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Languages
                                        </a>
        
                                        <div class="accordion-content show">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account" checked> 
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
                                           Video Duration
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> 0-2 Hours (220)</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> 3-6 Hours (140)</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> 6+ Hours (300)</label>
                                        </div>

                                        </div>
                                    </li>


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
                                            Price
                                        </a>
        
                                        <div class="accordion-content">
                                        <div>
                                        <input type="radio" id="direct-bank-transfer" name="radio-group" checked>
                                            <label for="direct-bank-transfer"> &nbsp;$1- $50</label>
                                        </div>

                                           <div>
                                        <input type="radio" id="id2" name="radio-group">
                                            <label for="direct-bank-transfer"> &nbsp;$51-$100 </label>
                                        </div>
                                            
                                    

                                        <div>
                                             <input type="radio" id="paypal" name="radio-group">
                                            <label for="paypal">&nbsp;Free</label>
                                        </div>
                                        </div>
                                    </li>

                                  
                                 
                                  

                                     <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Skills
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Skills 1</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> Skills 2</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Skills 3</label>
                                        </div>

                                        </div>
                                    </li>



                                     <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                           Learning Approach
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Face to Face</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> Pre Recorded Videos</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Online Conferencing Call</label>
                                        </div>

                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-------------------------------->


                        </aside>
                    </div>


                    <div class="col-lg-9 col-md-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="single-courses-list-box mb-30">
                                    <div class="box-item">
                                        <div class="courses-image">
                                            <div class="image bg-1">
                                                <img src="assets/img/courses/1.jpg" alt="image">

                                                <a href="#!" class="link-btn"></a>

                                                <!-- <div class="courses-tag">
                                                    <a href="#" class="d-block">Bestseller</a>
                                                </div> -->
                                            </div>
                                        </div>
            
                                        <div class="courses-desc">
                                            <div class="courses-content">
                                                
                
                                                <h3><a href="#!" class="d-inline-block">Professional IT Expert Certificate Course</a></h3>
                
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
                
                                            <div class="courses-box-footer">
                                                <ul>
                                                    <li class="students-number">
                                                        <i class='bx bx-time'></i> 25 Total hours
                                                    </li>
                
                                                    <li class="courses-lesson">
                                                        <i class='bx bx-book-open'></i> 150 Lectures - All levels
                                                    </li>
                
                                                    <li class="courses-price">
                                                        $150
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                           <div class="col-lg-12 col-md-12">
                                <div class="single-courses-list-box mb-30">
                                    <div class="box-item">
                                        <div class="courses-image">
                                            <div class="image bg-2">
                                                <img src="assets/img/courses/2.jpg" alt="image">

                                                <a href="#!" class="link-btn"></a>

                                                <!-- <div class="courses-tag">
                                                    <a href="#" class="d-block">Popular</a>
                                                </div> -->
                                            </div>
                                        </div>
            
                                        <div class="courses-desc">
                                            <div class="courses-content">
                                                
                
                                                <h3><a href="#!" class="d-inline-block">Supervisor Safety Awareness</a></h3>
                
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
                
                                            <div class="courses-box-footer">
                                                <ul>
                                                    <li class="students-number">
                                                        <i class='bx bx-time'></i> 25 Total hours
                                                    </li>
                
                                                    <li class="courses-lesson">
                                                        <i class='bx bx-book-open'></i> 150 Lectures - All levels
                                                    </li>
                
                                                    <li class="courses-price">
                                                        $250
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="single-courses-list-box mb-30">
                                    <div class="box-item">
                                        <div class="courses-image">
                                            <div class="image bg-3">
                                                <img src="assets/img/courses/3.jpg" alt="image">

                                                <a href="#!" class="link-btn"></a>

                                              <!--   <div class="courses-tag">
                                                    <a href="#" class="d-block">Bestseller</a>
                                                </div> -->
                                            </div>
                                        </div>
            
                                        <div class="courses-desc">
                                            <div class="courses-content">
                                                
                
                                                <h3><a href="#!" class="d-inline-block">Fall Protection Certificates</a></h3>
                
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
                
                                            <div class="courses-box-footer">
                                                <ul>
                                                    <li class="students-number">
                                                        <i class='bx bx-time'></i> 25 Total hours
                                                    </li>
                
                                                    <li class="courses-lesson">
                                                        <i class='bx bx-book-open'></i> 150 Lectures - All levels
                                                    </li>
                
                                                    <li class="courses-price">
                                                        Free
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

        
                            <div class="col-lg-12 col-md-12">
                                <div class="single-courses-list-box mb-30">
                                    <div class="box-item">
                                        <div class="courses-image">
                                            <div class="image bg-4">
                                                <img src="assets/img/courses/4.jpg" alt="image">

                                                <a href="#!" class="link-btn"></a>

                                               <!--  <div class="courses-tag">
                                                    <a href="#" class="d-block">Bestseller</a>
                                                </div> -->
                                            </div>
                                        </div>
            
                                        <div class="courses-desc">
                                            <div class="courses-content">
                                                
                
                                                <h3><a href="#!" class="d-inline-block">Diploma in Fire and Safety</a></h3>
                
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
                
                                            <div class="courses-box-footer">
                                                <ul>
                                                    <li class="students-number">
                                                        <i class='bx bx-time'></i> 25 Total hours
                                                    </li>
                
                                                    <li class="courses-lesson">
                                                        <i class='bx bx-book-open'></i> 150 Lectures - All levels
                                                    </li>
                
                                                    <li class="courses-price">
                                                        Free
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

        
                          

        
        
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

   <!-- Start Footer Area -->
        <footer class="footer-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-footer-widget mb-30">
                            <h3>Contact Us</h3>

                            <ul class="contact-us-link">
                                <li>
                                    <i class='bx bx-map'></i>
                                    <a href="#!">ABC Street, New York, USA</a>
                                </li>
                                <li>
                                    <i class='bx bx-phone-call'></i>
                                    <a href="#!">+1 (123) 456 7890</a>
                                </li>
                                <li>
                                    <i class='bx bx-envelope'></i>
                                    <a href="#!">info@name.com</a>
                                </li>
                            </ul>

                            <ul class="social-link">
                                <li><a href="#!" class="d-block" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                                <li><a href="#!" class="d-block" target="_blank"><i class='bx bxl-twitter'></i></a></li>
                                <li><a href="#!" class="d-block" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                                <li><a href="#!" class="d-block" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
                              
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="single-footer-widget mb-30">
                            <h3>Sitemap</h3>

                            <ul class="support-link">
                                <li><a href="#!">Home</a></li>
                                 <li><a href="#!">Register as Training Centers</a></li>
                                <li><a href="#!">Register as Trainers </a></li>
                                <li><a href="#!">Free Resources</a></li>
                                
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="single-footer-widget mb-30">
                            <h3>Useful Link</h3>

                            <ul class="useful-link">
                                <li><a href="#!">Login</a></li>
                                <li><a href="#!">Register</a></li>
                                <li><a href="#!">Courses</a></li>
                                 <li><a href="#!"> Privacy & Policy</a></li>
                               
                               
                                
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-footer-widget mb-30">
                            <h3>Newsletter</h3>

                            <div class="newsletter-box">
                               

                                <form class="newsletter-form" data-toggle="validator">
                                    <label>Your e-mail address:</label>
                                    <input type="email" class="input-newsletter" placeholder="Enter your email" name="EMAIL" required autocomplete="off">
                                    <button type="submit">Subscribe</button>
                                    <div id="validator-newsletter" class="form-result"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-area">
                <div class="container">
                   <!--  <div class="logo">
                        <a href="index-6.html" class="d-inline-block"><img src="assets/img/logo.png" alt="image"></a>
                    </div> -->
                    <p><i class='bx bx-copyright'></i>2020 | Designed By <a href="https://www.yarddiant.com/" target="_blank">Yarddiant</a> | All rights reserved.</p>
                </div>
            </div>
        </footer>
        <!-- End Footer Area -->
        
        <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>


          <!-----------login modals------------->


<div class="container">
  
  <!-- Trigger the modal with a button -->
 

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4><i class="fa fa-sign-in" aria-hidden="true"></i> Login</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         <!--------------------login------------------------>

           <!-- Start Login Area -->
        <section class="login-area">
            <div class="row m-0">
                

                <div class="col-lg-12 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div>
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Welcome back</h3>
                                    <p>New to Train-Eaze? <a href="#!">Sign up</a></p>

                                    <form>
                                        <div class="form-group">
                                            <input type="email" placeholder="Your email address" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" placeholder="Your password" class="form-control" required>
                                        </div>

                                        <button type="submit">Login</button>
                                        
                                        <div class="forgot-password">
                                            <a href="#">Forgot Password?</a>
                                        </div>

                                        <!--<div class="connect-with-social">-->
                                        <!--    <button type="submit" class="facebook"><i class='bx bxl-facebook'></i> Connect with Facebook</button>-->
                                        <!--    <button type="submit" class="google"><i class='bx bxl-google'></i> Connect with Google</button>-->
                                        <!--</div>-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>
                </div>
            </div>
        </section>
        <!-- End Login Area -->

         <!--------------------login------------------------>
        </div>
       
      </div>
      
    </div>
  </div> 
</div>
 
 <script>
$(document).ready(function(){
  $("#myBtn").click(function(){
    $("#myModal").modal();
  });
});
</script>

        <!-----------login modals------------->






        <!-----------Register modal------------->


<div class="container">
  
 
 

  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4><i class="fa fa-sign-in" aria-hidden="true"></i> Register</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         
           <!-- Start register Area -->
        <section class="login-area">
            <div class="row m-0">
                

                <div class="col-lg-12 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div>
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Open up your Train-Eaze<br> Account Now!</h3>
                                     <p>Already Signed Up? <a href="#!">Login</a></p>

                                    <form>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group txl">
                                            <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                         
                                          <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> Last Name <span class="required">*</span></label>
                                            <input type="password" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-envelope" aria-hidden="true"></i> Email <span class="required">*</span></label>
                                            <input type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password <span class="required">*</span></label>
                                            <input type="text" placeholder="Password" class="form-control" required="">
                                        </div>
                                    </div>


                                
                                    <div class="col-md-12 mt10 mb10">
                                        <button type="submit">Sign Up</button>
                                    </div>
    
                                  
                                </div>
                            

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>
                </div>
            </div>
        </section>
        <!-- End register Area -->

        
        </div>
       
      </div>
      
    </div>
  </div> 
</div>
 
 <script>
$(document).ready(function(){
  $("#myBtn2").click(function(){
    $("#myModal2").modal();
  });
});
</script>

        <!-----------register modal------------->


           <!-----------Register modal2------------->


<div class="container">
  
 
 

  <!-- Modal -->
  <div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4><i class="fa fa-sign-in" aria-hidden="true"></i> Register</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         
           <!-- Start register Area -->
        <section class="login-area">
            <div class="row m-0">
                

                <div class="col-lg-12 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div>
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Open up your Train-Eaze<br> Account Now!</h3>
                                     <p>Already Signed Up? <a href="#!">Login</a></p>

                                        <form>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group txl">
                                            <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                         
                                          <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> Last Name <span class="required">*</span></label>
                                            <input type="password" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-envelope" aria-hidden="true"></i> Email <span class="required">*</span></label>
                                            <input type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password <span class="required">*</span></label>
                                            <input type="text" placeholder="Password" class="form-control" required="">
                                        </div>
                                    </div>


                                
                                    <div class="col-md-12 mt10 mb10">
                                        <button type="submit">Sign Up</button>
                                    </div>
    
                                  
                                </div>
                            

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>
                </div>
            </div>
        </section>
        <!-- End register Area -->

        
        </div>
       
      </div>
      
    </div>
  </div> 
</div>
 
 <script>
$(document).ready(function(){
  $("#myBtn3").click(function(){
    $("#myModal3").modal();
  });
});
</script>

        <!-----------register modal2------------->


           <!-----------Register modal3------------->


<div class="container">
  
 
 

  <!-- Modal -->
  <div class="modal fade" id="myModal4" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4><i class="fa fa-sign-in" aria-hidden="true"></i> Register</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         
           <!-- Start register Area -->
        <section class="login-area">
            <div class="row m-0">
                

                <div class="col-lg-12 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div>
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Open up your Train-Eaze<br> Account Now!</h3>
                                     <p>Already Signed Up? <a href="#!">Login</a></p>

                                        <form>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group txl">
                                            <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                         
                                          <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> Last Name <span class="required">*</span></label>
                                            <input type="password" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-envelope" aria-hidden="true"></i> Email <span class="required">*</span></label>
                                            <input type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password <span class="required">*</span></label>
                                            <input type="text" placeholder="Password" class="form-control" required="">
                                        </div>
                                    </div>


                                
                                    <div class="col-md-12 mt10 mb10">
                                        <button type="submit">Sign Up</button>
                                    </div>
    
                                  
                                </div>
                            

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>
                </div>
            </div>
        </section>
        <!-- End register Area -->

        
        </div>
       
      </div>
      
    </div>
  </div> 
</div>
 
 <script>
$(document).ready(function(){
  $("#myBtn4").click(function(){
    $("#myModal4").modal();
  });
});
</script>

        <!-----------register modal3------------->



           <!-----------Register modal4------------->


<div class="container">
  
 
 

  <!-- Modal -->
  <div class="modal fade" id="myModal5" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4><i class="fa fa-sign-in" aria-hidden="true"></i> Register</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         
           <!-- Start register Area -->
        <section class="login-area">
            <div class="row m-0">
                

                <div class="col-lg-12 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div>
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Open up your Train-Eaze<br> Account Now!</h3>
                                     <p>Already Signed Up? <a href="#!">Login</a></p>

                                       <form>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group txl">
                                            <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                         
                                          <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> Last Name <span class="required">*</span></label>
                                            <input type="password" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-envelope" aria-hidden="true"></i> Email <span class="required">*</span></label>
                                            <input type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password <span class="required">*</span></label>
                                            <input type="text" placeholder="Password" class="form-control" required="">
                                        </div>
                                    </div>


                                
                                    <div class="col-md-12 mt10 mb10">
                                        <button type="submit">Sign Up</button>
                                    </div>
    
                                  
                                </div>
                            

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>
                </div>
            </div>
        </section>
        <!-- End register Area -->

        
        </div>
       
      </div>
      
    </div>
  </div> 
</div>
 
 <script>
$(document).ready(function(){
  $("#myBtn5").click(function(){
    $("#myModal5").modal();
  });
});
</script>

        <!-----------register modal4------------->


           <!-----------Register modal5------------->


<div class="container">
  
 
 

  <!-- Modal -->
  <div class="modal fade" id="myModal6" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4><i class="fa fa-sign-in" aria-hidden="true"></i> Register</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         
           <!-- Start register Area -->
        <section class="login-area">
            <div class="row m-0">
                

                <div class="col-lg-12 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div>
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Open up your Train-Eaze<br> Account Now!</h3>
                                     <p>Already Signed Up? <a href="#!">Login</a></p>

                                       <form>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group txl">
                                            <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                         
                                          <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> Last Name <span class="required">*</span></label>
                                            <input type="password" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-envelope" aria-hidden="true"></i> Email <span class="required">*</span></label>
                                            <input type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password <span class="required">*</span></label>
                                            <input type="text" placeholder="Password" class="form-control" required="">
                                        </div>
                                    </div>


                                
                                    <div class="col-md-12 mt10 mb10">
                                        <button type="submit">Sign Up</button>
                                    </div>
    
                                  
                                </div>
                            

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                </div>
            </div>
        </section>
        <!-- End register Area -->

        
        </div>
       
      </div>
      
    </div>
  </div> 
</div>
 
 <script>
$(document).ready(function(){
  $("#myBtn6").click(function(){
    $("#myModal6").modal();
  });
});
</script>

        <!-----------register modal5------------->


         <!-----------Register modal6------------->


<div class="container">
  
 
 

  <!-- Modal -->
  <div class="modal fade" id="myModal7" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4><i class="fa fa-sign-in" aria-hidden="true"></i> Register</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         
           <!-- Start register Area -->
        <section class="login-area">
            <div class="row m-0">
                

                <div class="col-lg-12 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div>
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Open up your Train-Eaze<br> Account Now!</h3>
                                     <p>Already Signed Up? <a href="#!">Login</a></p>

                                        <form>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group txl">
                                            <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                         
                                          <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-user-circle-o" aria-hidden="true"></i> Last Name <span class="required">*</span></label>
                                            <input type="password" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-envelope" aria-hidden="true"></i> Email <span class="required">*</span></label>
                                            <input type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>

                                     <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password <span class="required">*</span></label>
                                            <input type="text" placeholder="Password" class="form-control" required="">
                                        </div>
                                    </div>


                                
                                    <div class="col-md-12 mt10 mb10">
                                        <button type="submit">Sign Up</button>
                                    </div>
    
                                  
                                </div>
                            

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>
                </div>
            </div>
        </section>
        <!-- End register Area -->

        
        </div>
       
      </div>
      
    </div>
  </div> 
</div>
 
 <script>
$(document).ready(function(){
  $("#myBtn7").click(function(){
    $("#myModal7").modal();
  });
});
</script>
        <!-- End Become Instructor & Partner Area -->
@endsection
