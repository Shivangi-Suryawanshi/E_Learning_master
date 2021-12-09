 <!DOCTYPE html>
 <html lang="{{ app()->getLocale() }}" dir="{{ get_option('enable_rtl') ? 'rtl' : 'auto' }}">

 <head>

     <style type="text/css">
         .fr {
             float: right;
         }

         .question-opt-image {
             width: 10%
         }

     </style>

     <meta name="viewport" content="width=device-width, initial-scale=1">

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
     <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />

     <!--------new admin css---------->




     <link rel="stylesheet" href="{{ theme_asset('website/css/dashboard/admin.css') }}">
     <link rel="stylesheet" href="{{ theme_asset('website/css/dashboard/extra_layout.css') }}">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>
         @if (!empty($title)) {{ $title }} | {{ get_option('site_title') }}
         @else {{ get_option('site_title') }} @endif
     </title>

     <!-- all css here -->

     <!-- bootstrap v3.3.6 css -->
     <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">

     @yield('page-css')

     <!-- style css -->
     <!--  <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}"> -->


 </head>

 <body class="{{ get_option('enable_rtl') ? 'rtl' : '' }}" style="background: #000;">

     <div class="main-navbar-wrap">

         <!---------------------------------------------------------------------------------->
         <!-- Topbar -->
         <nav class="navbar navbar-expand navbar-light topbar static-top imphead">

             <!-- Sidebar Toggle (Topbar) -->
             <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                 <i class="fa fa-bars"></i>
             </button>

             <!-- Topbar Search -->
             <form class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                 <div class="input-group">
                     <a class="navbar-brand site-main-logo mlm20" href="{{ route('home') }}">
                         @php
                             $logoUrl = media_file_uri(get_option('site_logo'));
                         @endphp

                         @if ($logoUrl)
                             <img src="{{ media_file_uri(get_option('site_logo')) }}"
                                 alt="{{ get_option('site_title') }}" class="img-responsive" />
                         @else
                             <img src="{{ asset('assets/images/logo.png') }}" alt="{{ get_option('site_title') }}"
                                 width="30%" class="loxs" />
                         @endif
                     </a>
                 </div>
             </form>

             <!-- Topbar Navbar -->
             <ul class="navbar-nav ml-auto">





                 <!----------------------------------------------->
                 <li class="nav-item dropdown no-arrow">
                     <a class="nav-link dropdown-toggle mt5" href="#" id="userDropdown" role="button"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @php
                        $checkUserAdminIsCompany  = App\CompanyWorkforce::
            join('users','users.id','company_workforce.company_id')
            ->where('company_workforce.user_id',Auth::user()->id)->first();
                    @endphp
                    @if ($checkUserAdminIsCompany)
                        @if($checkUserAdminIsCompany->user_type == "company")
                            Company Name : {{ucwords($checkUserAdminIsCompany->name)}}
                        @endif
                    @endif
                         {{-- <img src="http://traivis.com/users/assets/layouts/flags/us.svg" class="fr w5"> --}}

                     </a>
                 <li class="nav-item ">
                     <a class="nav-link " href="{{ route('home') }}" target="_blank" data-toggle="tooltip"
                         data-original-title="{{ __a('site_home') }}"><i class="fa fa-home mt5"
                             style="font-size: 25px;"></i></a>
                 </li>
                 <!-- Dropdown - User Information -->





                 {{-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                     <!--     @include(theme('dashboard.sidebar-menu')) -->

                     <a class="dropdown-item" href="#">

                         English
                     </a>
                     <a class="dropdown-item" href="#">

                         Arabic
                     </a>


                 </div> --}}
                 </li>


                 <!--------------------------------------------------->



                 <div class="topbar-divider d-none d-sm-block"></div>

                 <!-- Nav Item - User Information -->
                 <li class="nav-item dropdown no-arrow mt9">
                     <a class="nav-link dropdown-toggle userd" href="#" id="userDropdown" role="button"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <span class="d-lg-inline text-gray-600 small">{{ $auth_user->get_name }}</span>

                     </a>
                     <!-- Dropdown - User Information -->





                     <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="userDropdown">

                         <!--     @include(theme('dashboard.sidebar-menu')) -->

                         <a class="dropdown-item" href="{{ URL::to('/dashboard/settings') }}">
                             <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                             Profile
                         </a>
                         {{-- <a class="dropdown-item" href="#">
                                    <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> --}}
                         <div class="dropdown-divider"></div>
                         <a class="dropdown-item" href="{{ URL::to('/logout') }}">
                             <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
                             Logout
                         </a>
                     </div>
                 </li>

             </ul>

         </nav>
         <!-- End of Topbar -->
         <!------------------------------------------------------------------------------>


     </div>
     <script type="text/javascript">
         /* <![CDATA[ */
         window.pageData = @json(pageJsonData());
         /* ]]> */

     </script>

     <!---------new js---------------->

     <script src="{{ theme_asset('website/js/dashboard/sb-admin-2.min.js') }}"></script>
     <script src="{{ theme_asset('website/vendor/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
