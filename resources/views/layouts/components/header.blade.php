@php
use App\Category;
$categories = Category::whereStep(0)
    ->with('sub_categories')
    ->orderBy('category_name', 'asc')
    ->get();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ get_option('enable_rtl') ? 'rtl' : 'auto' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (!empty($title)) {{ $title }} | {{ get_option('site_title') }}
        @else
            {{ get_option('site_title') }} @endif
    </title>

    <!-- all css here -->

    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">

    @yield('page-css')

    <!-- style css -->
    {{-- <link rel="stylesheet" href="{{ theme_asset('website/css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ theme_asset('website/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/odometer.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/viewer.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('website/css/slick.min.css') }}">

    <link rel="stylesheet" href="{{ theme_asset('website/css/magnific-popup.min.css') }}">

    @if(app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ theme_asset('website/css/ar-style.css') }}">
    @else
    <link rel="stylesheet" href="{{ theme_asset('website/css/style.css') }}">
    @endif
    
    <link rel="stylesheet" href="{{ theme_asset('website/css/responsive.css') }}">
    <!-- modernizr css -->
    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>


    <!-- Links of JS files -->
    <script src="{{ theme_asset('website/js/jquery.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/popper.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/bootstrap.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/owl.carousel.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/mixitup.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/parallax.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/jquery.appear.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/odometer.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/particles.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/meanmenu.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/viewer.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/slick.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/form-validator.min.js') }}"></script>
    <script src="{{ theme_asset('website/js/contact-form-script.js') }}"></script>
    <script src="{{ theme_asset('website/js/main.js') }}"></script>



    <script type="text/javascript">
        /* <![CDATA[ */
        window.pageData = @json(pageJsonData());
        /* ]]> */

    </script>

    <style>
        @media (max-width: 989px) {
            .visible-xs {
                display: block;
            }


        }

        @media (min-width: 990px) {
            .visible-xs {
                display: none !important;
            }
        }

    </style>
</head>

<body class="{{ get_option('enable_rtl') ? 'rtl' : '' }}">

    <header>

        <!-- Start Navbar Area -->
        <div class="navbar-area navbar-style-three">
            <div class="raque-responsive-nav">
                <div class="container">
                    <div class="raque-responsive-menu">
                        <div class="logo">
                            <a href="{{ URL::to('/') }}">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-navbar-wrap">
                <div class="raque-nav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-expand-md navbar-light">
                            <a class="navbar-brand" href="{{ URL::to('/') }}">
                                @php
                                    $logoUrl = media_file_uri(get_option('site_logo'));
                                @endphp

                                @if ($logoUrl)
                                    <img src="{{ media_file_uri(get_option('site_logo')) }}"
                                        alt="{{ get_option('site_title') }}" />
                                @else
                                    <img src="{{ asset('assets/images/logo.png') }}"
                                        alt="{{ get_option('site_title') }}" />
                                @endif
                            </a>

                            <div class="collapse navbar-collapse mean-menu">
                                <ul class="navbar-nav">
                                    <li class="nav-item"><a href="{{ URL::to('/courses') }}"
                                            class="nav-link">{{ __t('courses') }}
                                            </i></a>

                                    </li>
                                    <li class="nav-item"><a href="{{ URL::to('/company-landing') }}"
                                            class="nav-link">{{ __t('label_for_enterprises') }}
                                            </i></a>

                                    </li>
                                    <li class="nav-item">
                                        <a href="#!" class="nav-link">{{ __t('label_training_organization') }} &nbsp;
                                            <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item"><a href="{{ URL::to('/training-centre-landing') }}"
                                                    data-role="4"
                                                    class="nav-link">{{ __t('label_register_as_training_center') }}</a>
                                            </li>
                                            <li class="nav-item"><a href="{{ URL::to('/trainer-landing') }}"
                                                    data-role="5"
                                                    class="nav-link">{{ __t('label_register_as_trainer') }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a href="{{ URL::to('/individual-user-landing') }}"
                                            class="nav-link @if (Request::is('individual-user-landing')) active @endif">{{ __t('label_for_students') }}
                                            </i></a>
                                    </li>
                                    <li class="nav-item"><a href="{{ URL::to('/download-resourses') }}"
                                            class="nav-link @if (Request::is('download-resourses')) active @endif">{{ __t('label_download_resourses') }}
                                        </a>
                                    </li>

                                    @if (!Auth::check())
                                        <li class="nav-item"><a href="{{ URL::to('/login') }}" class="nav-link"
                                                id="loginBtn">{{ __t('label_login') }}</a>
                                        </li>

                                        <li class="nav-item"><a href="#!" class="nav-link">{{__t('sign-up')}}</a>
                                            <ul class="dropdown-menu">
                                                <li class="nav-item"><a href="{{ URL::to('/register/company') }}"
                                                        class="nav-link" id="myBtn2">{{__t('title_register_as_company')}}</a></li>

                                                <li class="nav-item"><a href="{{ URL::to('/register/instructor') }}"
                                                        class="nav-link" id="myBtn3">{{__t('title_register_training_centers')}}</a>
                                                </li>

                                                <li class="nav-item"><a href="{{ URL::to('/register/trainer') }}"
                                                        class="nav-link" id="myBtn4">{{__t('label_register_as_trainer')}}</a></li>

                                                <li class="nav-item"><a href="{{ URL::to('/register/student') }}"
                                                        class="nav-link" id="myBtn5">{{__t('label_register_as_individual')}}</a></li>
                                            </ul>
                                        </li>
                                    @endif


                                    @if (Auth::check())





                                        <li class="nav-item visible-xs"><a href="#!" class="nav-link"> <img
                                                    src="{{ theme_asset('website/img/user.png') }}" class=""
                                                    alt="image" width="30" height="30"></a>
                                            <ul class="dropdown-menu">
                                                <li class="nav-item"><a href="{{ Session::get('redirect_url') }}"
                                                        class="nav-link" id="myBtn2">Dashboard</a></li>

                                                <li class="nav-item"><a href="{{ URL::to('/logout') }}"
                                                        class="nav-link" id="myBtn3">{{__t('logout')}}</a></li>



                                            </ul>
                                        </li>











                                    @endif
                                    <li class="visible-xs">


                                        <select class="change-language"
                                            style="background:transparent; color:#fff;border:none; font-size:13px; font-weight:bold; text-transform:uppercase;">
                                            @foreach (\App\Language::where('active', 1)->get() as $language)
                                                <option style="background:#000;" value="{!! $language->code !!}"
                                                    {!! \App::getLocale() == $language->code ? 'selected' : '' !!}>{!! $language->display_name !!}</option>
                                            @endforeach
                                        </select>


                                    </li>


                                </ul>
                                <div class="others-option">
                                    <ul class="navbar-nav">
                                        @if (Auth::check())

                                            <!--------------------->



                                            <li class="nav-item"><a href="#!" class="nav-link"> <img
                                                        src="{{ theme_asset('website/img/user.png') }}" class="mtm20"
                                                        alt="image" width="30" height="30"></a>
                                                <ul class="dropdown-menu">
                                                    <li class="nav-item"><a href="{{ Session::get('redirect_url') }}"
                                                            class="nav-link" id="myBtn2">Dashboard</a></li>

                                                    <li class="nav-item"><a href="{{ URL::to('/logout') }}"
                                                            class="nav-link" id="myBtn3">Logout</a></li>



                                                </ul>
                                            </li>








                                            <!----------------->

                                            <!-- <div class="dropdown language-switcher d-inline-block">
            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ theme_asset('website/img/user.png') }}" class="shadow" alt="image">
            <span><i class='bx bx-chevron-down'></i></span>
            </button>
            <div class="dropdown-menu">
          <li class="nav-item"><a href="{{ Session::get('redirect_url') }}" class="nav-link">
               <span>Dashboard</span>
               </a></li>
                <li class="nav-item"><a href="{{ URL::to('/logout') }}" class="nav-link">
               <span>Logout</span>
               </a></li>
            </div>
         </div> -->
                                        @endif
                                        <li>
                                            {{-- <div class="nice-select change-language mt10"
                                    tabindex="0"><span class="current">English</span>
                                    <ul class="list">
                                        <li data-value="en" class="option selected">English</li>
                                        <li data-value="ar" class="option">عربى</li>
                                    </ul>
                                </div> --}}

                                            <select class="change-language"
                                                style="background:transparent; color:#fff;border:none; font-size:13px; font-weight:bold; text-transform:uppercase;">
                                                @foreach (\App\Language::where('active', 1)->get() as $language)
                                                    <option style="background:#000;" value="{!! $language->code !!}"
                                                        {!! \App::getLocale() == $language->code ? 'selected' : '' !!}>{!! $language->display_name !!}</option>
                                                @endforeach
                                            </select>


                                        </li>
                                    </ul>
                                </div>


                            </div>
                        </nav>
                    </div>
                </div>

            </div>

    </header>

    <script type="text/javascript">
        $(document).on('change', '.change-language', function() {
            var $this = $(this);
            $.ajax({
                type: 'GET',
                url: '/change-language/' + $this.val(),
                contentType: false,
                processData: false,
                success: function(data) {

                    if (data.show_popup) {
                        $('div#success-popup').bPopup({
                            closeClass: 'close-trigger',
                            follow: ([false, false]),
                            position: (['auto', window.innerHeight / 3]),
                            onOpen: function() {
                                $("#success-popup").find('span.success').html(data
                                    .message);
                            },
                            onClose: function() {
                                location.reload(true);
                            },
                        });
                    } else {
                        location.reload(true);
                    }
                },
                error: function(data) {
                    location.reload(true)
                }
            });
        });

    </script>
