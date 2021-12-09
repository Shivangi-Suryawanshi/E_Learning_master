@extends('layouts.app')

@section('content')
   <!-- Preloader -->
        <div class="preloader">
            <div class="loader">
                <div class="shadow"></div>
                <div class="box"></div>
            </div>
        </div>
        <!-- End Preloader -->

        <!-- Start Login Area -->
        <section class="login-area">
            <div class="row m-0">
                <div class="col-lg-6 col-md-12 p-0">
                    <div class="register-image">
                        <img src="assets/img/register-bg.jpg" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 p-0">
                    <div class="login-content">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="login-form">
                                    <div class="logo">
                                        <a href="index.html"><img src="assets/img/black-logo.png" alt="image"></a>
                                    </div>

                                    <h3>Open up your Train-Eaze Account Now!</h3>
                                    <p>Already Signed Up? <a href="login.html">Login</a></p>

                                    <form>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group txl">
                                            <label>First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                         
                                          <div class="col-md-6 txl">
                                        <div class="form-group">
                                             <label>Last Name <span class="required">*</span></label>
                                            <input type="password" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-12 txl">
                                        <div class="form-group">
                                             <label>Email <span class="required">*</span></label>
                                            <input type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>

                                     <div class="col-md-12 txl">
                                        <div class="form-group">
                                             <label>Password <span class="required">*</span></label>
                                            <input type="text" placeholder="Password" class="form-control" required="">
                                        </div>
                                    </div>


                                    <div class="col-lg-12 col-md-12 mt10 ml10">

                                        <div class="row">
                                            <div class="col-md-6">

                                       <div class="form-group txl">
       
                                    
                                     <input type="radio" id="direct-bank-transfer" name="radio-group" checked>

                                     <label for="direct-bank-transfer" class="ml15">Register as Company</label>
                                   
    
                                        
                                       
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group txl">
       
                                    
                                     <input type="radio" id="" name="radio-group">

                                     
                                    <label for="direct-bank-transfer" class="ml15">Register as Individual User</label>
    
                                        
                                       
                                           
                                        </div>
                                    </div>
                                </div>
                                        
                                    </div>
                               
    
                                  
                                </div>
                            

                                      

                                       


                                   
                                      
                                       <div class="col-md-12 mt10 mb10">
                                        <button type="submit">Sign Up</button>
                                    </div>
                                        
                                     

                                        
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                     

                     <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>


                    </div>
                </div>
            </div>
        </section>
        <!-- End Become Instructor & Partner Area -->
@endsection
