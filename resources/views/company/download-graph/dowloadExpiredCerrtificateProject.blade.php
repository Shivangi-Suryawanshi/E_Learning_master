<div class="tab-pane fade" id="panel-with-pills-tab-03" aria-expanded="true">
    {{-- <span style="float:right;"> <a href="{{route('download-expired-certificate-project')}}" class="fa fa-print" > Click Download </a></span> --}}
    <span style="float:right;"> <a href="javascript:window.print()" class=" "><i
        title="download" class="btn-btn-primary">Print</i></a></span>
    <h4 class="mb-3">Expired Certificates VS Projects</h4>
    <div class="col-xs-12">
        <div class="panel panel-light h-auto"
            style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

            <div class="panel-header">
                <h4 class="fs1r">Number of workers with expired certificates in specific
                    projects. </h4>
            </div>

            <div class="panel-body pl-3 py-3">
                <div class="" data-title="COURSES">
                    <div id="graph-03" style="height: 400px; "></div>
                    {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                </div>
            </div>
        </div>

   
        <!-- / Column Chart with Datalabels -->
    </div>
    <!-- / Column Chart with Datalabels -->
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
    var chart = am4core.create("graph-03", am4charts.PieChart);
        chart.logo.disabled=true;
// Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "count";
    pieSeries.dataFields.category = "project";

// Let's cut a hole in our Pie chart the size of 30% the radius
    chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
    pieSeries.slices.template.stroke = am4core.color("#fff");
    pieSeries.slices.template.strokeWidth = 2;
    pieSeries.slices.template.strokeOpacity = 1;
    pieSeries.slices.template
    // change the cursor on hover to make it apparent the object can be interacted with
    .cursorOverStyle = [
{
    "property": "cursor",
    "value": "pointer"
}
    ];

    pieSeries.alignLabels = true;
    pieSeries.labels.template.bent = true;
    pieSeries.labels.template.radius = 3;
    pieSeries.labels.template.padding(0,0,0,0);

    pieSeries.ticks.template.disabled = true;

// Create a base filter effect (as if it's not there) for the hover to return to
    var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
    shadow.opacity = 0;

// Create hover state
    var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

// Slightly shift the shadow and make it more prominent on hover
    var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
    hoverShadow.opacity = 0.7;
    hoverShadow.blur = 5;

// Add a legend
    chart.legend = new am4charts.Legend();

    chart.dataSource.url = 'http://train.ca/company/'+'get-graph-03-data';
    chart.dataSource.load();
    chart.dataSource.events.on("done", function(ev) {
        // Data loaded and parsed
        console.log(ev.target.data);
    });
    chart.dataSource.events.on("error", function(ev) {
        console.log("Oopsy! Something went wrong");
    });

    // chart.data = [{
    //     "country": "Project Yarddiant",
    //     "litres": 3
    // },{
    //     "country": "Project Travis",
    //     "litres": 2
    // }, {
    //     "country": "Project Google",
    //     "litres": 1
    // }, {
    //     "country": "Project Autoimmune",
    //     "litres": 3
    // },  ];

}); // end am4core.ready()

</script>



