<div class="tab-pane fade" id="panel-with-pills-tab-2" aria-expanded="true">
    <span style="float:right;"> <a href="javascript:window.print()" class=" "><i
        title="download" class="btn-btn-primary">Print</i></a></span>

    {{-- <h4 class="mb-3">Certificate Status</h4> --}}
    <div class="col-xs-12">
        <!-- Donut Chart -->
        <div class="panel panel-light h-auto"
            style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

            <div class="panel-header">
                <h4 class="fs1r">Number of valid,expired,about to expire certificates from total
                    certificates.</h4>
            </div>


            <div class="panel-body pl-3 py-3">
                <div class="" data-title="CERTIFICATES">
                    <div id="graph-2" style="height: 400px; "></div>
                </div>
            </div>
        </div>
        <!-- / Donut Chart -->
    </div>
</div>

<script src="{{ asset('users/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('users/vendor/amcharts/amcharts.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


<script>

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("graph-2", am4charts.PieChart);
chart.colors.list = [
    am4core.color("#59b300"),
    am4core.color("#ffc34d"),
    am4core.color("#ff6666")
];
chart.logo.disabled=true;

chart.dataSource.url = 'http://train.ca/company/'+'get-graph-2-data';
chart.dataSource.load();
chart.dataSource.events.on("done", function(ev) {
    // Data loaded and parsed
    // console.log(ev.target.data);
});
chart.dataSource.events.on("error", function(ev) {
    console.log("Oopsy! Something went wrong");
});


// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.colors.list = [
    am4core.color("#59b300"),
    am4core.color("#ff6666"),
    am4core.color("#ffc34d")
];
pieSeries.dataFields.value = "percent";
pieSeries.dataFields.category = "category";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

}); // end am4core.ready()

</script>