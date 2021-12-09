@extends('company.layouts.app-company')
@section('additional_styles')
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @if (Auth::user()->profile_completion_status == 1 && Auth::user()->verification_status == 0)
        <div class="page-content">
           
            <header>
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="mb-0">Your account has been successfully submitted for verification process </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 mt-2 p-0 breadcrumbs-chevron">
                                <li class="breadcrumb-item"><a href="/">{{ \Carbon\Carbon::now()->format('d M Y') }}</a>
                                </li>

                            </ol>
                            <br>
                            <a href="{{ url('company/add-profile') }}" class="btn btn-primary">Update</a>
                        </nav>
                    </div>
                </div>
            </header>
        </div>
    @elseif( Auth::user()->profile_completion_status == 0 && Auth::user()->verification_status == 0)

        <div class="page-content">
           
            <header>
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="mb-0">Please update your profile detail for verification </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 mt-2 p-0 breadcrumbs-chevron">
                                <li class="breadcrumb-item"><a
                                        href="/">{{ \Carbon\Carbon::now()->format('d M Y H:i') }}</a>
                                </li>

                            </ol>
                            <br>
                            <a href="{{ url('company/add-profile') }}" class="btn btn-primary">Update</a>
                        </nav>
                    </div>
                </div>
            </header>
        </div>
    @else


        <!-- Main Page Content -->
        <div class="page-content">
            <p> {{Auth::user()->email}}</p>
            <header>
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="mb-0" style="margin-left: 20px;">Welcome to Traivis</h1>
                        {{-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 mt-2 p-0 breadcrumbs-chevron">
                                <li class="breadcrumb-item"><a href="/">{{ \Carbon\Carbon::now()->format('d M Y') }}</a>
                                </li>

                            </ol>
                        </nav> --}}
                    </div>
                </div>
            </header>

            <div class="page-content">
                <div class="row mt-n24">



                    <div class="col-6 col-sm-4 col-lg-3 col-md-3 mt-24">
                        <div class="widget widget-sm h-full">
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                            @php
                                $company_id = Auth::user()->id;

                                $countWorkForce = App\CompanyWorkforce::join('users', 'users.id', 'company_workforce.user_id')
                                    ->where('company_workforce.company_id', $company_id)
                                    ->count();
                            @endphp
                            <h4><span class="counter">{{ $countWorkForce }}</span></h4>
                            <h6>Users</h6>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4 col-lg-3 col-md-3 mt-24">
                        <div class="widget widget-sm h-full">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                            @php
                                $countExternalCourse = App\CompanyRequiredCourse::where([['type', 2], ['company_id', $company_id]])->count();
                                $countInternalCourse = App\CompanyRequiredCourse::where([['type', 1], ['company_id', $company_id]])->count();

                            @endphp
                            <h4><span class="counter">{{ $countExternalCourse }}</span></h4>
                            <h6>External Courses</h6>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4 col-lg-3 col-md-3 mt-24">
                        <div class="widget widget-sm h-full">
                            <i class="fa fa-certificate" aria-hidden="true"></i>
                            <h4><span class="counter">{{ $countInternalCourse }}</span></h4>
                            <h6>Internal Courses</h6>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-3 col-md-3 mt-24">
                        <div class="widget widget-sm h-full">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            @php
                                $coursePurchese = App\CoursePurchase::leftjoin('company_required_courses', 'company_required_courses.id', 'course_purchases.course_id')
                                    ->where('company_required_courses.status', 1)
                                    ->where('company_required_courses.company_id', $company_id)
                                    ->count();
                            @endphp
                            <h4><span class="counter">{{ $coursePurchese }}</span></h4>
                            <h6>Purchased Courses</h6>
                        </div>
                    </div>

                    {{-- <div class="col-md-4"> --}}

                    {{-- <div class="panel widget-chart-3 panel-light"> --}}
                    {{-- <div class="panel-header border-0"> --}}
                    {{-- <h3 class="panel-title">Traffic By Country</h3> --}}
                    {{-- </div> --}}
                    {{-- <div class="panel-body pt-0"> --}}

                    {{-- <div class="row"> --}}
                    {{-- <div class="col-lg-6 col-md-12 col-6 widget-chart"> --}}
                    {{-- <div id="chart-7" style="height: 150px; "><svg
                                                height="150" version="1.1" width="179" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                style="overflow: hidden; position: relative; left: -0.8125px;">
                                                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with
                                                    Raphaël 2.3.0</desc>
                                                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                                <path fill="none" stroke="#67b7dc"
                                                    d="M89.4845,118.33333333333334A43.333333333333336,43.333333333333336,0,0,0,117.31824870008194,108.21235027935339"
                                                    stroke-width="2" opacity="0"
                                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;">
                                                </path>
                                                <path fill="#67b7dc" stroke="#ffffff"
                                                    d="M89.4845,121.33333333333334A46.333333333333336,46.333333333333336,0,0,0,119.24520053316454,110.51166683715478L128.02353666165192,120.98633115602777A60,60,0,0,1,89.4845,135Z"
                                                    stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                </path>
                                                <path fill="none" stroke="#6771dc"
                                                    d="M117.31824870008194,108.21235027935339A43.333333333333336,43.333333333333336,0,0,0,129.28879517742152,57.87119784671223"
                                                    stroke-width="2" opacity="0"
                                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;">
                                                </path>
                                                <path fill="#6771dc" stroke="#ffffff"
                                                    d="M119.24520053316454,110.51166683715478A46.333333333333336,46.333333333333336,0,0,0,132.044477151243,56.68535769763846L144.5981394764298,51.283197018524625A60,60,0,0,1,128.02353666165192,120.98633115602777Z"
                                                    stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                </path>
                                                <path fill="none" stroke="#a367dc"
                                                    d="M129.28879517742152,57.87119784671223A43.333333333333336,43.333333333333336,0,0,0,47.97677050172415,62.55467277747432"
                                                    stroke-width="2" opacity="1"
                                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;">
                                                </path>
                                                <path fill="#a367dc" stroke="#ffffff"
                                                    d="M132.044477151243,56.68535769763846A46.333333333333336,46.333333333333336,0,0,0,45.10315845953582,61.693073200530236L27.22290575258622,56.33200916621149A65,65,0,0,1,149.19094276613228,49.306796770068345Z"
                                                    stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                </path>
                                                <path fill="none" stroke="#dc67ab"
                                                    d="M47.97677050172415,62.55467277747432A43.333333333333336,43.333333333333336,0,0,0,89.47088643205838,118.33333119491907"
                                                    stroke-width="2" opacity="0"
                                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;">
                                                </path>
                                                <path fill="#dc67ab" stroke="#ffffff"
                                                    d="M45.10315845953582,61.693073200530236A46.333333333333336,46.333333333333336,0,0,0,89.46994395427781,121.333331046875L89.46565044438853,134.9999970391187A60,60,0,0,1,32.01225915623343,57.7680084611183Z"
                                                    stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                </path><text x="89.4845" y="65" text-anchor="middle"
                                                    font-family="&quot;Arial&quot;" font-size="15px" stroke="none"
                                                    fill="#000000"
                                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;"
                                                    font-weight="800"
                                                    transform="matrix(1.3131,0,0,1.3131,-28.0204,-22.9369)"
                                                    stroke-width="0.7615384615384615">
                                                    <tspan dy="5.25" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                        Asia</tspan>
                                                </text><text x="89.4845" y="85" text-anchor="middle"
                                                    font-family="&quot;Arial&quot;" font-size="14px" stroke="none"
                                                    fill="#000000"
                                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;"
                                                    transform="matrix(0.9319,0,0,0.9319,6.0939,5.2608)"
                                                    stroke-width="1.073076923076923">
                                                    <tspan dy="4.75" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                        40</tspan>
                                                </text>
                                            </svg></div> --}}
                    {{-- </div> --}}
                    {{-- <ul class="col-lg-6 col-md-12 col-6 chart-details"> --}}
                    {{-- <li> <i class="fa fa-circle"
                                                style="color: #4cacff;"></i> USA: <strong>34,500</strong></li> --}}
                    {{-- <li> <i class="fa fa-circle"
                                                style="color: #5780f7;"></i> Europe: <strong>9,500</strong></li> --}}
                    {{-- <li> <i class="fa fa-circle"
                                                style="color: #06c48c;"></i> Asia: <strong>4,500</strong></li> --}}
                    {{-- <li> <i class="fa fa-circle"
                                                style="color: #fab72b;"></i> Other: <strong>1,500</strong></li> --}}
                    {{-- </ul> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- </div> --}}

                </div>
                <div class="row">



                    <div class="col-md-12">

                        <!-- Notifications -->
                        <div class="panel panel-light">
                            <div class="panel-header">
                                <h1 class="panel-title">Notifications</h1>
                                @php
                                    $notification = App\UserNotification::where([['notifiable_user_id', Auth::user()->id, ['is_read', 0]]])
                                        ->limit(10)
                                        ->latest()
                                        ->get();
                                @endphp
                                @if (count($notification) > 0)
                                    {{-- <div class="panel-toolbar">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <a href="{{ URL::to('dashboard/notifications') }}" role="button" class="btn btn-sm btn-primary">VIEW ALL</a>

                                    </div>
                                </div> --}}
                                @endif
                            </div>
                            <div class="panel-body p-0">

                                <ul class="list-group list-group-notifications">
                                    @if ($notification)
                                        @foreach ($notification as $notifi)


                                            <li class="list-group-item">
                                                <div class="item-icon bg-primary-light">
                                                    <i class="far fa-heart"></i>
                                                </div>
                                                <div class="item-info">
                                                    <a
                                                        href="{{ url('dashboard/notification/view?type=' . $notifi->model) }}">{{ $notifi->notification }}</a>
                                                    <p class="item-description">
                                                        {{ $notifi->created_at->format('Y M d') }}
                                                    </p>
                                                </div>
                                                <div class="timestamp">{{ $notifi->created_at->format('h:i') }}</div>
                                            </li>
                                        @endforeach
                                    @endif

                                </ul>

                            </div>
                        </div><!-- / Notifications -->

                    </div>

                </div>


            </div>






        </div><!-- / .page-content -->
        <!-- Main Page Content -->
    @endif


@endsection
@section('additional_scripts')
    <script src="{{ asset('users/vendor/amcharts/amcharts.js') }}"></script>
    <script src="{{ asset('users/js/charts/dashboard-chart.js') }}"></script>

@endsection
