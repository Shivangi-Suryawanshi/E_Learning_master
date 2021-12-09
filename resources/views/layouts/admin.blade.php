<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ get_option('enable_rtl') ? 'rtl' : 'auto' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />

    <!-- Teachify Version -->
    <meta name="generator" content="UnitedForTech LMS v.{{ config('app.version') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
    @if (!empty($title)) {{ $title }} @else {{ get_option('site_title') }}
        @endif
    </title>

    <!-- all css here -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- bootstrap v4.3.1 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link href="{{ asset('assets/plugins/select2-4.0.3/css/select2.css') }}" rel="stylesheet" />

    @yield('page-css')

    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

    <script type="text/javascript">
        var pageData = @json(pageJsonData())

    </script>

</head>

<body class="{{ get_option('enable_rtl') ? 'rtl' : '' }}">


    <nav class="navbar navbar-expand-lg navbar-light dashboard-top-nav">
        <div class="dashboard-top-navbar-brand">
            <a class="navbar-brand" href="{{ route('home') }}">
                @php
                    $logoUrl = media_file_uri(get_option('site_logo'));
                @endphp

                @if ($logoUrl)
                    <img src="{{ media_file_uri(get_option('site_logo')) }}" alt="{{ get_option('site_title') }}" />
                @else
                    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ get_option('site_title') }}" />
                @endif
            </a>
        </div>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">


            <ul class="navbar-nav dashboard-user-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link fs20" href="{{ route('home') }}" target="_blank" data-toggle="tooltip"
                        data-original-title="{{ __a('site_home') }}"><i class="fa fa-home mt5"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                        class="nav-link dropdown-toggle nav-user-profile">

                        {!! $auth_user->get_photo !!}
                        <span class="user-name">{{ $auth_user->name }}</span>
                    </a>

                    <div role="menu" class="dropdown-menu">
                        @if (can('browse_trainer_dashboard'))
                            <a href="{{ route('profile_settings') }}" class="dropdown-item" target="_blank"><i
                                    class="la la-user"></i> {{ __('admin.profile') }}</a>
                        @endif
                        <a href="{{ url('logout') }}" class="dropdown-item">

                            <i class="la la-sign-out"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

        </div>


    </nav>




    <div class="dashboard-wrap">
        <div class="container-fluid">

            <div id="wrapper">
                @include('admin.menu')

                <div id="page-wrapper">
                    @if (!empty($title))
                        <div class="page-header px-4">
                            <h4 class="page-header-left mt5"> @yield('title-before') {{ $title }}
                                @yield('title-after') </h4>
                            @yield('page-header-right')
                        </div>
                    @endif

                    <div id="admin-page-body">
                        @php
                            do_action('admin_notices');
                        @endphp

                        @include('inc.flash_msg')
                        @yield('content')
                    </div>
                    <div class="admin-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <p class="m-0"><a href="http://unitedfortech.com" target="_blank">UnitedForTech LMS</a> Version {{config('app.version')}}</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- all js here -->
    <!-- jquery latest version -->
    <script src="{{ asset('assets/js/vendor/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2-4.0.3/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script>
        var toastr_options = {
            closeButton: true
        };

    </script>
    @yield('page-js')

    <script src="{{ asset('assets/js/filemanager.js') }}"></script>

</body>

</html>
