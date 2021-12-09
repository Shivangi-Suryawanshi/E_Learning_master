@extends(theme('dashboard.layouts.dashboard'))

@section('content')
    @php
    $user_id = $auth_user->id;

    $enrolledCount = \App\Enroll::whereUserId($user_id)
        ->whereStatus('success')
        ->count();
    $wishListed = \Illuminate\Support\Facades\DB::table('wishlists')
        ->whereUserId($user_id)
        ->count();

    $myReviewsCount = \App\Review::whereUserId($user_id)->count();
    $purchases = $auth_user
        ->purchases()
        ->take(10)
        ->get();

    $totalCourse = \App\Course::whereUserId($user_id)->count();
    $team = \App\InstructorTrainer::whereInstructorUserId($user_id)->count();
    $purchasedUser = \App\Enroll::join('courses', 'courses.id', 'enrolls.course_id')
        ->where([['courses.user_id', Auth::user()->id], ['enrolls.status', 'success']])
        ->select('enrolls.*')
        ->count();
    @endphp


    <link
        href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300;400;500;523;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <style>
        .badge {
            float: right;
        }

        @media (max-width: 767px) {

            .badge {
                float: left;
            }
        }

        .list-group-item {
            padding-left: 10px !important;
            font-size: 15px;
        }

        .pbtn {
            background: #007bff;
            padding: 6px;
            font-weight: 500;
            color: #fff;
            cursor: pointer;
        }

        .clb {
            color: #007bff;
        }

        .mb0 {
            margin-bottom: 0px !important;
        }

        .dtsty {
            color: #a29d9d;
            font-weight: 500;
            font-size: 13px;
            margin-right: 10px;
        }

        .widget-sm {
            background-size: cover;
            background-position: center center;
            width: 100%;
            min-height: 200px;
            display: inline-flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #000;
        }

        .widget {
            position: relative;
            background-color: #fff;
            padding: 20px;
            padding: 0;
            border-radius: 3px;
            border: 0;
            box-shadow: 0 2px 4px rgb(51 51 51 / 30%);
            /* min-height: 150px; */
            background-size: contain;
            background-position: top right;
            background-repeat: no-repeat;
        }

        .widget-sm svg {
            display: block;
            height: 35px;
            opacity: 1.05;
            fill: #6f7892;
            margin-top: 30px;
        }

        .widget-sm>* {
            position: relative;
            z-index: 10;
        }

        .widget-sm h4 {
            color: #464646;
            margin: 20px 0;
            font-size: 44px;
            font-weight: 200;
            line-height: 1;
            font-family: dosis;
        }

        .h-full {
            height: 100% !important;
        }

        .page-content header h1 {
            font-size: 1.3rem;
            font-weight: 300;
            /* font-family: "Open Sans", sans-serif; */
            letter-spacing: .5px;
            font-weight: 500;
            /* text-transform: uppercase; */
        }

        .breadcrumb {
            background-color: transparent;
            font-weight: 500;
        }

        .page-content header nav .breadcrumb .breadcrumb-item {
            color: #8a959e;
        }

        header .breadcrumb a,
        header .breadcrumb .breadcrumb-item {
            font-size: 13px;
            text-transform: uppercase;
        }

        .breadcrumb a,
        .breadcrumb .breadcrumb-item {
            color: #6c757d;
            text-decoration: none;
            font-size: 15px;
            font-family: "Open Sans", sans-serif;
            letter-spacing: .5px;
            font-weight: 500;
        }

        .widget-sm h6 {
            color: #6f7892;
            font-size: 16px;
            font-weight: 500;
            font-family: "Open Sans", sans-serif;
            margin: 0;
        }

        .mt20 {
            margin-top: 20px;
        }

        .dfa {
            font-size: 35px;
            color: #6f7892;
        }

        @media (max-width: 580px) {
            .mtxs20 {
                margin-top: 20px !important;
            }
        }

    </style>


    <div class="page-content">


        <header> 
            <div class="row">
                
                <div class="col-md-6">
                    <h1 class="mb-0">Welcome to Traivis</h1>
                    <nav aria-label="breadcrumb">
                        {{-- <ol class="breadcrumb m-0 mt-2 p-0 breadcrumbs-chevron">
                            <li class="breadcrumb-item"><a href="/">{{ \Carbon\Carbon::now()->format('d M Y') }}</a>

                            </li>

                        </ol> --}}

                        <p style="font-size: 15px;margin-top:5px;
                        margin-bottom: 5px;"><i class="fa fa-envelope" aria-hidden="true"></i> {{Auth::user()->email}}</p>
                    </nav>
                    <br>
                </div>
            </div>
        </header>

        @if (Auth::user()->user_type == 'trainer' || Auth::user()->user_type == 'student')
            <div class="row mt-n24">
                <div class="col-6 col-sm-4 col-lg-4 col-md-4 mt-24">
                    <div class="widget widget-sm h-full">
                        <i class="fa fa-graduation-cap dfa" aria-hidden="true"></i>

                        <h4><span class="counter">{{ $enrolledCount }}</span></h4>
                        <h6>Courses Enrolled</h6>
                    </div>
                </div>

                <div class="col-6 col-sm-4 col-lg-4 col-md-4 mt-24">
                    <div class="widget widget-sm h-full">
                        <i class="fa fa-heart-o dfa"></i>


                        <h4><span class="counter">{{ $wishListed }}</span></h4>
                        <h6>In Wishlist</h6>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-4 col-md-4 mt-24 mtxs20">
                    <div class="widget widget-sm h-full">
                        <i class="fa fa-star-o dfa" aria-hidden="true"></i>
                        <h4><span class="counter">{{ $myReviewsCount }}</span></h4>
                        <h6>My Reviews</h6>
                    </div>
                </div>
            </div>
        @endif


        @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin')
            <div class="row mt-n24">
                <div class="col-6 col-sm-4 col-lg-4 col-md-4 mt-24">
                    <div class="widget widget-sm h-full">
                        <i class="fa fa-graduation-cap dfa" aria-hidden="true"></i>

                        <h4><span class="counter">{{ $totalCourse }}</span></h4>
                        <h6>Course</h6>
                    </div>
                </div>

                <div class="col-6 col-sm-4 col-lg-4 col-md-4 mt-24">
                    <div class="widget widget-sm h-full">
                        <i class="fa fa-heart-o dfa"></i>


                        <h4><span class="counter">{{ $team }}</span></h4>
                        <h6>My Team</h6>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-4 col-md-4 mt-24 mtxs20">
                    <div class="widget widget-sm h-full">
                        <i class="fa fa-users dfa" aria-hidden="true"></i>
                        <h4><span class="counter">{{ $purchasedUser }}</span></h4>
                        <h6>Purchased Users</h6>
                    </div>
                </div>
            </div>
        @endif
    </div>



    <div class="row mt-n24">

        <div class="col-md-8">
            <!-- User Profile -->
            <div class="panel panel-light h-auto" id="cpr">
                <div class="panel-header">
                    <h1 class="panel-title">Calendar</h1>
                    <!-- <div class="panel-toolbar">
                                                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                                            <button type="button" class="btn btn-sm btn-primary">ADD</button>
                                                                        </div>
                                                                    </div> -->

                </div>
                <div class="panel-body">

                    <div class="panel panel-light panel-calendar">

                        <div class="panel-body p-0">
                            <div id="calendar" class="fc fc-ltr">

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- User Profile -->
        </div>

        <div class="col-md-4">
            @if (count($getNotifications) > 0)


                <!-- Notifications -->
                <div class="panel panel-light">
                    <div class="panel-header">
                        <h1 class="panel-title">Notifications</h1>
                        <div class="panel-toolbar">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{ URL::to('dashboard/notifications') }}" role="button"
                                    class="btn btn-sm btn-primary">VIEW ALL</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body p-0">

                        <ul class="list-group list-group-notifications">



                            @foreach ($getNotifications as $notify)
                                <li class="list-group-item">
                                    <div class="item-icon bg-success-light">
                                        <i class="fa fa-align-justify"></i>
                                    </div>
                                    <div class="item-info">
                                        <a
                                            href="{{ URL::to('dashboard/notification/view?type=' . $notify->model) }}">{{ $notify->notification }}</a>
                                        <p class="item-description">
                                            {{ Carbon\Carbon::parse($notify->created_at)->format('Y M d') }}

                                        </p>
                                    </div>
                                    <div class="timestamp">{{ Carbon\Carbon::parse($notify->created_at)->format('h:i') }}
                                    </div>
                                </li>
                            @endforeach

                            {{-- <li class="list-group-item">
                                                <div class="item-icon bg-success-light">
                                                    <i class="fa fa-align-justify"></i>
                                                </div>
                                                <div class="item-info">
                                                    <a href="#">Keon Boyer sent you a new message.</a>
                                                    <p class="item-description">
                                                        Sit amet conse ctetur adipi sicing.
                                                    </p>
                                                </div>
                                                <div class="timestamp">19:45</div>
                                            </li> --}}


                        </ul>

                    </div>
                </div><!-- / Notifications -->


            @endif
        </div>
    </div>



    <!------------>
    <!--------------------------------------------------------------------------------->

    <!-------------------------------------------------------------------------------->









    @if ($purchases->count() > 0)
        <h5 class="mt20"> {{ sprintf(__t('my_last_purchases'), $purchases->count()) }} </h5>
        <hr>

        <table class="table table-striped table-bordered">

            <tr>
                <th>#</th>
                <th>{{ __a('amount') }}</th>
                <th>{{ __a('method') }}</th>
                <th>{{ __a('time') }}</th>
                <th>{{ __a('status') }}</th>
                <th>#</th>
            </tr>

            @foreach ($purchases as $purchase)
                <tr>
                    <td>
                        <span class="text-muted">#{{ $purchase->id }}</span>
                    </td>
                    <td>
                        {!! price_format($purchase->amount) !!}
                    </td>
                    <td>{!! ucwords(str_replace('_', ' ', $purchase->payment_method)) !!}</td>

                    <td>
                        <span>
                            {!! $purchase->created_at->format('Y-m-d') !!} <br />
                            {!! $purchase->created_at->format(get_option('time_format')) !!}
                        </span>
                    </td>

                    <td>
                        {!! $purchase->status_context !!}
                    </td>
                    <td>
                        @if ($purchase->status == 'success')
                            <span class="text-success" data-toggle="tooltip" title="{!! $purchase->status !!}"><i
                                    class="fa fa-check-circle-o"></i> </span>
                        @else
                            <span class="text-warning" data-toggle="tooltip" title="{!! $purchase->status !!}"><i
                                    class="fa fa-exclamation-circle"></i> </span>
                        @endif

                        <a href="{!! route('purchase_view', $purchase->id) !!}" class="btn btn-info"><i class="la la-eye"></i> </a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

@endsection

@section('page-js')
    <script src="{{ asset('users/js/pages/applications/calendar.js') }}"></script>

    <script src="{{ asset('users/vendor/fullcalendar/fullcalendar.js') }}"></script>
    @if ($chartData)
        <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>

        <script>
            var ctx = document.getElementById("ChartArea").getContext('2d');
            var ChartArea = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($chartData)) !!},
                    datasets: [{
                        label: 'Earning ',
                        backgroundColor: '#216094',
                        borderColor: '#216094',
                        data: {!! json_encode(array_values($chartData)) !!},
                        borderWidth: 2,
                        fill: false,
                        lineTension: 0,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0, // it is for ignoring negative step.
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    return '{{ get_currency() }} ' + value;
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(t, d) {
                                var xLabel = d.datasets[t.datasetIndex].label;
                                var yLabel = t.yLabel >= 1000 ? '$' + t.yLabel.toString().replace(
                                    /\B(?=(\d{3})+(?!\d))/g, ",") : '{{ get_currency() }} ' + t.yLabel;
                                return xLabel + ': ' + yLabel;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            });

        </script>
    @endif

@endsection

@section('page-css')

    <link rel="stylesheet" href="{{ asset('users/vendor/fullcalendar/fullcalendar.css') }}">
    {{-- <link rel="stylesheet" href="{{asset('users/css/vendor.css')}}" /> --}}
    <link rel="stylesheet" href="{{ asset('users/css/style.css') }}" />

@endsection
