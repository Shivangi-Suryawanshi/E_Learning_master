<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Traivis</title>
    <meta name="description" content="Exon Admin Dashboard Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="{{ asset('users/assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('users/assets/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('users/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('users/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />
    <!-- Dosis & Poppins Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300;400;500;523;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <?php
    $language = 'english';
    if (session()->has('language')) {
    $language = Session::get('language');
    }
    if ($language == 'english') { ?>
    <link rel="stylesheet" href="{{ asset('users/layouts/css/app.css') }}">
    <?php } else { ?>
    <link rel="stylesheet" href="{{ asset('users/css/ar/js-list-manager.css') }}">
    <link rel="stylesheet" href="{{ asset('users/css/ar/app.css') }}">
    <link rel="stylesheet" href="{{ asset('users/css/ar/extra.css') }}">
    <?php }
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <script type="text/javascript">
        var ROOT_URL = "{{ env('ASSET_URL') }}";
        var COMPANY_URL = "{{ env('COMPANY_DOMAIN') }}";

    </script>

    @yield('additional_styles')
</head>

<body>
    <div class="page-wrapper sidebar-open ">
        @include('company.layouts.company-sidebar')
        <main class="main-content">
            <div class="sidebar-backdrop"></div>
            <div class="page-container">
                <!-- Header Nav -->
                <div class="navigation-wrapper">
                    <nav class="navbar navbar-top navbar-expand-lg navbar-light bg-white adxs">
                        <div class="container-fluid">
                            <button
                                class="navbar-toggler navbar-toggler-css navbar-menu-toggler collapsed sidebar-toggler"
                                style="position: absolute;
                        top: 60px;
                        z-index: 9;">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </button>
                            <button class="navbar-toggler navbar-toggler-css-reverse navbar-menu-toggler collapsed"
                                type="button" data-toggle="collapse" data-target="#navbar-top-collapsible"
                                aria-controls="navbar-top-collapsible" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbar-top-collapsible">
                                <div class="form-search-container">
                                    <div class="sidebar-brand">
                                        <a href="{{ url('/') }}"> <img
                                                src="{{ asset('users/assets/layouts/logos/logo-light.png') }}"
                                                class="img" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <nav class="navbar navbar-toolbar navbar-expand-lg navbar-light">
                        <div class="container-fluid">
                            <ul class="navbar-nav navbar-menu-primary">
                                <?php
                                $language = 'english';
                                $flag = 'us.svg';
                                $prefix = 'en';
                                if (session()->has('language')) {
                                $language = Session::get('language');
                                if ($language != 'english') {
                                $flag = 'ar.svg';
                                $prefix = 'ar';
                                }
                                }
                                ?>
                                {{-- @if (Auth::user()->verification_status == 1 && Auth::user()->profile_completion_status == 1) --}}

                                <li class="nav-item dropdown language-dropdown">

                                    <a href="#" class="nav-link dropdown-toggle dropdown-nocaret" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('users/assets/layouts/flags/') . '/' . $flag }}" alt="">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-sm dropdown-menu-left"
                                        id="langDv">
                                        <a href="#" class="dropdown-item" id="english" @click="select_Lang('english')">
                                            <img src="{{ asset('users/assets/layouts/flags/us.svg') }}" alt="">
                                            English
                                        </a>
                                        <a href="#" class="dropdown-item" id="arabic" @click="select_Lang('arabic')">
                                            <img src="{{ asset('users/assets/layouts/flags/ar.svg') }}" alt="">
                                            Arabic
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs20" href="{{ route('home') }}" target="_blank"
                                        data-toggle="tooltip" data-original-title="{{ __a('site_home') }}"><i
                                            class="fa fa-home mt5 icxs"></i></a>
                                </li>
                                {{-- @include('company.layouts.notifications') --}}


                                <li class="nav-item nav-user-dropdown dropdown">
                                    <a href="#" class="nav-link dropdown-toggle dropdown-nocaret" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span
                                            class="avatar avatar-1 rounded-circle">{{ Auth::user()->get_name }}</span>

                                    </a>
                                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-sm dropdown-menu-left"
                                        id="logoutDv">
                                        <div class="dropdown-header pt-0">
                                            <small class="text-overflow m-0">Welcome {{ Auth::user()->name }}</small>
                                        </div>
                                        <a href="{{ route('profile') }}" target="_blank" class="dropdown-item">
                                            <i class="fas fa-users"></i>
                                            <span>Profile</span>
                                        </a>
                                        <a href="{{ url('logout') }}" class="dropdown-item" id="logoutBtn"
                                            @click="logoutFn()">
                                            <i class="fas fa-power-off"></i>
                                            <span>Logout</span>
                                        </a>
                                    </div>
                                </li>
                                {{-- @endif --}}
                            </ul>
                        </div>
                    </nav>
                </div>
                @yield('content')
                <!-- Footer -->
                <div class="copyright row">
                    <div class="col-md-12" align="center">
                        Copyright &copy; Traivis <?php echo date('Y'); ?>
                    </div>
                    {{-- <div class="col-md-6 text-right">
                     Design By <a href="#!">Yarddiant</a>.
                  </div> --}}
                </div>
            </div>
         </main>
      </div>
      <!-- / .page-wrapper -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
      <script src="{{asset('users/js/vendor.js')}}"></script>
      <script src="{{asset('users/layouts/js/app.js')}}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

<script>
   var toastr_options = {closeButton : true};
</script>

      <script type="text/javascript">
         var lang = new Vue({
             data: {
               message: '{}'
             },
             el: '#langDv',
             methods: {
               select_Lang: function(language) {
                 axios.post(COMPANY_URL+'set-language', {language})
                   .then(response => {
                       window.location.reload();
                   })
               }
             }
         });
      </script>
      <script src="{{ asset('js/common.js') }}"></script>
      <script src="{{ asset('js/global-auth.js') }}"></script>
      <script>

      </script>
      @yield('additional_scripts')

   </body>
</html>
