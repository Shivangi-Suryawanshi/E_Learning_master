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
                    <div class="login-image">
                        <img src="assets/img/login-bg.jpg" alt="image">
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

                                    <h3>Welcome back</h3>
                                    <p>New to Train-Eaze? <a href="signup.html">Sign up</a></p>

                                    <form>
                                        <div class="form-group">
                                            <input type="email" placeholder="Your email address" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" placeholder="Your password" class="form-control">
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
        <!-- End Become Instructor & Partner Area -->
@endsection
