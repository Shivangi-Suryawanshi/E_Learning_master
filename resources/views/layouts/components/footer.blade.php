<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-footer-widget mb-30">
                    <h3>{{__t('contact')}}</h3>
                    <ul class="contact-us-link">
                        <li>
                            <i class='bx bx-map'></i>
                            <a>ABC Street, New York, USA</a>
                        </li>
                        <li>
                            <i class='bx bx-phone-call'></i>
                            <a>+1 (123) 456 7890</a>
                        </li>
                        <li>
                            <i class='bx bx-envelope'></i>
                            <a>info@traivis.com</a>
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
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-footer-widget mb-30">
                    <h3>Sitemap</h3>
                    <ul class="support-link">
                        <li><a href="{{ URL::to('/') }}">Home</a></li>
                        <li><a href="{{ URL::to('/trainer-landing') }}">{{ __t('label_register_as_trainer') }} </a></li>
                        <li><a href="{{ URL::to('/training-centre-landing') }}">{{ __t('label_register_as_training_center') }}</a></li>
                        <li><a href="{{ URL::to('/individual-user-landing') }}">{{ __t('label_for_students') }}</a>
                        </li>
                        <li><a href="{{ URL::to('/company-landing') }}">{{ __t('label_for_enterprises') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="single-footer-widget mb-30">
                    <h3>Useful Link</h3>
                    <ul class="useful-link">
                        <li><a href="{{ URL::to('/about-us') }}">{{__t('about_us')}}</a></li>
                        <li><a href="{{ URL::to('/download-resourses') }}">{{__t('label_download_resourses')}}</a></li>
                        <li><a href="{{ URL::to('/courses') }}">{{__t('courses')}}</a></li>
                        <li><a href="{{ URL::to('/privacy-policy') }}"> {{__t('privacy_policy')}}</a></li>
                        <li><a href="{{ URL::to('/contact-us') }}"> {{__t('contact')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-footer-widget mb-30">
                    <h3>Newsletter</h3>
                    <div class="newsletter-box">
                        <form class="newsletter-form" data-toggle="validator">
                            <label>Your e-mail address:</label>
                            <input type="email" class="input-newsletter" placeholder="Enter your email" name="EMAIL"
                                required autocomplete="off">
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
            <p><i class='bx bx-copyright'></i>2020 | Designed By <a href="https://www.yarddiant.com/"
                    target="_blank">Yarddiant</a> | All rights reserved.</p>
        </div>
    </div>
</footer>
<div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    {{ csrf_field() }}
</form>

@if (!auth()->check() && request()->path() != 'login')
    @include(theme('template-part.login-modal-form'))
@endif

<!-- jquery latest version -->
<script src="{{ asset('assets/js/vendor/jquery-1.12.0.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

@yield('page-js')

<!-- main js -->
<script src="{{ theme_asset('js/main.js') }}"></script>


</body>

</html>
