@extends(theme('dashboard.layouts.dashboard'))

@section('content')

<style>
    .frgt {float:right;}
    .fs14 {font-size:18px;}

    .pb15 {padding-bottom: 30px !important; margin-top:30px;}
     .ptab {color: #000;
    padding: 10px 20px 10px 10px;    border-radius: 5px;
    box-shadow: 0px 0 2px 0 #666666;
}

.current {box-shadow: 0px 0 7px 0 #666666; font-weight:600;}


@media screen and (max-width: 460px) {

 .ptab {color: #000;
    padding: 0px 1px 0px 0px; border-radius: 0px;
    margin-right:40px;
    box-shadow: 0px 0 0px 0 #666666;;
}

.active {font-weight:600; border-bottom:1px solid #000;box-shadow: 0px 0 0px 0 #666666;}

}

    </style>

    <div class="dashboard-inline-submenu-wrap mb-4 border-bottom">
    <div class="pb15">
        <a href="{{route('earning')}}" class="current ptab">{{__t('earnings')}}</a>
        <a href="{{route('earning_report')}}" class="ptab">{{__t('report_statements')}}</a>
</div>
    </div>


    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Lifetime sales</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->sales_amount) !!}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Lifetime Earnings</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->earnings) !!}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Commission Deducted</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->commission) !!}</h4>
            </div>
        </div>


        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Lifetime Withdrawals</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->withdrawals) !!}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Balance</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->balance) !!}<span class="frgt"> <a href="{{route('withdraw')}}" class="fs14"> <small><i class="la la-cash-register"></i> Withdraw</small></a></span></h4>

            </div>
        </div>

    </div>


    <div class="p-4 bg-white">
        <h4 class="mb-4">Earning for this month</h4>

        <canvas id="ChartArea"></canvas>
    </div>
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
