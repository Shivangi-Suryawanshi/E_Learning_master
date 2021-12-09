@extends('layouts.admin')

 <link rel="stylesheet" href="{{ theme_asset('website/css/dashboard/extra_layout.css') }}">

<style>
    .mb30 {margin-bottom: 50px !important;}

.mt30 {margin-top: 30px;}

    </style>

@section('content')


    @php
    $userCount = \App\User::count();
    $subAdminCount = \App\User::whereUserType('sub-admin')->count();
    $companyUserCount = \App\User::where('user_type','company')->count();   
    $totalInstructors = \App\User::whereUserType('instructor')->count();
    $totalStudents = \App\User::whereUserType('student')->count();
    $courseCount = \App\Course::publish()->count();
    $lectureCount = \App\Content::whereItemType('lecture')->count();
    $quizCount = \App\Content::whereItemType('quiz')->count();
    $assignmentCount = \App\Content::whereItemType('assignment')->count();
    $questionCount = \App\Discussion::whereDiscussionId(0)->count();
    $totalEnrol = \App\Enroll::whereStatus('success')->count();
    $totalReview = \App\Review::count();
    $totalAmount = \App\Payment::whereStatus('success')->sum('amount');
    $withdrawsTotal = \App\Withdraw::whereStatus('approved')->sum('amount');
    $payments = \App\Payment::query()->orderBy('id', 'desc')->take(20)->get();
    $notification = App\UserNotification::where('notifiable_user_id',Auth::user()->id)->orderBy('id','desc')->limit(5)->get();

    @endphp

    <div class="row">
     

        
        <div class="col-lg-3 col-md-6">
        <a href="{{ route('users') }}">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
           
                <div class="card-icon mr-2">
                    <span><i class="fa fa-user-circle-o"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$userCount}}</h4></div>
                    <h6 class="mb0">Users</h6>
                </div>
               
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ url('admin/users?filter_user_group=sub-admin') }}">
                <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
               
                    <div class="card-icon mr-2">
                        <span><i class="fa fa-user-circle-o"></i> </span>
                    </div>
    
                    <div class="card-info">
                        <div class="text-value"><h4>{{$subAdminCount}}</h4></div>
                        <h6 class="mb0">Sub Admin</h6>
                    </div>
                   
                </div>
                </a>
            </div>
        <div class="col-lg-3 col-md-6">
            <a target="_blank" href="{{ url('admin/users?filter_user_group=company') }}">
                <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                    
                    <div class="card-icon mr-2">
                        <span><i class="fa fa-user-circle-o"></i> </span>
                    </div>
    
                    <div class="card-info">
                        <div class="text-value"><h4>{{$companyUserCount}}</h4></div>
                        <h6 class="mb0">Company User</h6>
                    </div>
                   
                </div>
                </a>
            </div>

        <div class="col-lg-3 col-md-6">
        <a href="{{ URL::to('admin/users?status=&q=&filter_status=&filter_user_group=instructor') }}">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-users"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$totalInstructors}}</h4></div>
                    <h6 class="mb0">Instructors</h6>
                </div>
            </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
        <a href="{{ URL::to('admin/users?status=&q=&filter_status=&filter_user_group=student') }}">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-address-book-o"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$totalStudents}}</h4></div>
                    <h6 class="mb0">Students</h6>
                </div>
            </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6">
        <a href="{{ route('admin_courses') }}">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-graduation-cap"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$courseCount}}</h4></div>
                    <h6 class="mb0">Course</h6>
                </div>
            </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-play"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$lectureCount}}</h4></div>
                    <h6 class="mb0">Lecture</h6>
                </div>
            </div>
         </a>
        </div>

        <div class="col-lg-3 col-md-6">
        <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-comments"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$quizCount}}</h4></div>
                    <h6 class="mb0">Quiz</h6>
                </div>
            </div>
          </a>
        </div>

        <div class="col-lg-3 col-md-6">
        <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-server"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$assignmentCount}}</h4></div>
                    <h6 class="mb0">Assignments</h6>
                </div>
            </div>
        </a>
        </div>

        <div class="col-lg-3 col-md-6">
        <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-question-circle-o"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$questionCount}}</h4></div>
                    <h6 class="mb0">Question Asked</h6>
                </div>
            </div>
        </a>
        </div>

        <div class="col-lg-3 col-md-6">
        <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-certificate"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$totalEnrol}}</h4></div>
                    <h6 class="mb0">Enrolled</h6>
                </div>
            </div>
          </a>
        </div>

        <div class="col-lg-3 col-md-6">
        <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-star"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$totalReview}}</h4></div>
                    <h6 class="mb0"> Reviews</h6>
                </div>
            </div>
        </a>
        </div>

        <div class="col-lg-3 col-md-6">
        <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-money"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{!! price_format($totalAmount) !!}</h4></div>
                    <h6 class="mb0"> Payment Total</h6>
                </div>
            </div>
        </a>
        </div>


        <div class="col-lg-3 col-md-6">
        <a href="#!">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-white">
                <div class="card-icon mr-2">
                    <span><i class="fa fa-credit-card"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{!! price_format($withdrawsTotal) !!}</h4></div>
                    <h6 class="mb0"> Withdraws Total</h6>
                </div>
            </div>
        </a>
        </div>
                           
        @if(count($notification)>0)
        
            <div class="col-md-12 mb30">

                <!-- Notifications -->
                <div class="panel panel-light">
                    <div class="panel-header">
                        <h1 class="panel-title">Notifications</h1>
                        <div class="panel-toolbar">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                {{-- <a href="{{ URL::to('dashboard/notifications') }}" role="button" class="btn btn-sm btn-primary">VIEW ALL</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body p-0">

                        <ul class="list-group list-group-notifications">

                        
                      
                            @foreach($notification as $notify)
                            <li class="list-group-item">
                                <div class="item-icon bg-success-light">
                                    <i class="fa fa-align-justify"></i>
                                </div>
                                <div class="item-info">
                                    <a href="{{ URL::to('dashboard/notification/view?type='.$notify->model) }}">{{ $notify->notification }}</a>
                                    <p class="item-description">
                                        {{ Carbon\Carbon::parse($notify->created_at)->format('Y M d')  }}
                                    </p>
                                </div>
                                <div class="timestamp">{{ Carbon\Carbon::parse($notify->created_at)->format('h:i')  }}</div>
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

            </div>
@endif

    </div>



    <!----------------------------------------->
    {{-- <div class="row">
    <div class="col-md-12">
						
                        <div class="panel panel-light">
                           
                            <div class="panel-body">
                            
                                <div class="accordion accordion-sm" id="accordiondarkExample">
                                    <div class="card">
                                        <div class="card-header" id="accordiondarkHeadingOne">
                                            <h2 class="mb-0">
                                                <a class="accheader" data-toggle="collapse" data-target="#accordiondarkCollapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Payments Graph for the Month of <strong>{{date('M')}}</strong>
                                             </a>
                                            </h2>
                                        </div>
                                    
                                        <div id="accordiondarkCollapseOne" class="collapse show" aria-labelledby="accordiondarkHeadingOne" data-parent="#accordiondarkExample" style="">
                                            <div class="card-body">
                                               
    <div class="p-4 bg-white">
  

        <canvas id="ChartArea"></canvas>
    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="accordiondarkHeadingTwo">
                                            <h2 class="mb-0">
                                                <a class="accheader" data-toggle="collapse" data-target="#accordiondarkCollapseTwo" aria-expanded="false" aria-controls="accordiondarkCollapseTwo">
                                                @if($payments->count() > 0)
         Last {{$payments->count()}} {{__a('payments')}}
</a>
                                            </h2>
                                        </div>
                                        <div id="accordiondarkCollapseTwo" class="collapse" aria-labelledby="accordiondarkHeadingTwo" data-parent="#accordiondarkExample" style="">
                                            <div class="card-body">
                                              

    

        <table class="table table-striped table-bordered">

            <tr>
                <th>{{__a('paid_by')}}</th>
                <th>{{__a('amount')}}</th>
                <th>{{__a('method')}}</th>
                <th>{{__a('time')}}</th>
                <th>{{__a('status')}}</th>
                <th>#</th>
            </tr>

            @foreach($payments as $payment)
                <tr>
                    <td>
                        <a href="{!!route('payment_view', $payment->id)!!}">
                            {!!$payment->name!!} <br />
                            <small>{!!$payment->email!!}</small>
                        </a>
                    </td>

                    <td>
                        {!!price_format($payment->amount)!!}
                    </td>
                    <td>{!!ucwords(str_replace('_', ' ', $payment->payment_method))!!}</td>

                    <td>
                        <small>
                            {!!$payment->created_at->format(get_option('date_format'))!!} <br />
                            {!!$payment->created_at->format(get_option('time_format'))!!}
                        </small>
                    </td>

                    <td>
                        {!! $payment->status_context !!}
                    </td>
                    <td>
                        @if($payment->status == 'success')
                            <span class="text-success" data-toggle="tooltip" title="{!!$payment->status!!}"><i class="fa fa-check-circle-o"></i> </span>
                        @else
                            <span class="text-warning" data-toggle="tooltip" title="{!!$payment->status!!}"><i class="fa fa-exclamation-circle"></i> </span>
                        @endif

                        <a href="{!!route('payment_view', $payment->id)!!}" class="btn btn-info"><i class="la la-eye"></i> </a>
                    </td>

                </tr>
            @endforeach

        </table>

    @else
        {!! no_data() !!}
    @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>

    <!------------------------------------------>
</div>
   --}}








@endsection



@section('page-js')
    <script src="{{asset('assets/plugins/chartjs/Chart.min.js')}}"></script>

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
                                return '{{get_currency()}} ' + value;
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            var xLabel = d.datasets[t.datasetIndex].label;
                            var yLabel = t.yLabel >= 1000 ? '$' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '{{get_currency()}} ' + t.yLabel;
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

@endsection