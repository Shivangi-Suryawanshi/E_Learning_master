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



         <!-- Start Mission Area -->
        <section class="ptb-170 jarallax" data-jarallax='{"speed": 0.3}' style="background: url(assets/img/images/unnamed.png);">
            <div class="container">
                <div class="mission-content">
                    <div class="section-title">
                        <img src="{!! asset('assets/img/images/su.png') !!}">
                       <!--  <span class="sub-title">Discover Mission</span> -->
                        <h2 style="font-size: 27px;">Thanks!<br> Your Payment was successful.</h2>
                        <h3>You Can Start Exploring..</h3>
                    </div>

                 
                </div>
            </div>

             <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" width="1898" height="820" style="width: 100%; height: 100%;"></canvas></div>
        </section>
        <!-- End Mission Area -->
 

@endsection
@section('additional_scripts')

@endsection