<div class="tab-pane fade" id="panel-with-pills-tab-04" aria-expanded="true">
    {{-- <span style="float:right;"> <a href="{{route('download-cost-spend')}}" class="fa fa-print" > Click Download </a></span> --}}
    <span style="float:right;"> <a href="javascript:window.print()" class=" "><i
        title="download" class="btn-btn-primary">Print</i></a></span>
    <h4 class="mb-3">Cost spend on Trainings based on categories</h4>

    <div class="col-xs-12">
        <div class="panel panel-light h-auto"
            style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

            <div class="panel-header">
                <h4 class="fs1r">Total cost that the company spent on the training of a specific
                    project
                </h4>
            </div>

            <div class="panel-body pl-3 py-3">
                <div class="" data-title="COURSES">
                    <div id="graph-04-1" style="height: 400px; "></div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-light h-auto"
                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                <div class="panel-header">
                    <h4 class="fs1r">Total cost that the company spent on the training of a
                        specific department
                    </h4>
                </div>

                <div class="panel-body pl-3 py-3">
                    <div class="" data-title="COURSES">
                        <div id="graph-04-2" style="height: 400px; "></div>
                        {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                    </div>
                </div>
            </div>

            <!-- / Column Chart with Datalabels -->
        </div>
        <div class="col-md-12">
            <div class="panel panel-light h-auto"
                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                <div class="panel-header">
                    <h4 class="fs1r">Total cost that the company spent on the training of a
                        specific position
                    </h4>
                </div>

                <div class="panel-body pl-3 py-3">
                    <div class="" data-title="COURSES">
                        <div id="graph-04-3" style="height: 400px; "></div>
                        {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                    </div>
                </div>
            </div>

            <!-- / Column Chart with Datalabels -->
        </div>
        <!-- / Column Chart with Datalabels -->
    </div>
</div>

<script src="{{ asset('users/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('users/vendor/amcharts/amcharts.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>
   am4core.ready(function() {

// Themes begin
    am4core.useTheme(am4themes_material);
    am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
    var chart = am4core.create("graph-04-1", am4charts.XYChart);
    chart.logo.disabled=true;

// Add data
    chart.data = [
        
    ];

// Create axes

    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "country";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;

    categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
        if (target.dataItem && target.dataItem.index & 2 == 2) {
            return dy + 25;
        }
        return dy;
    });

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = "visits";
    series.dataFields.categoryX = "country";
    series.name = "Visits";
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;

    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;

        
// Add a legend
chart.legend = new am4charts.Legend();

chart.dataSource.url = 'http://train.ca/company/'+'get-graph-04-data';
chart.dataSource.load();
chart.dataSource.events.on("done", function(ev) {
    // Data loaded and parsed
    console.log(ev.target.data,'HAI');
});
chart.dataSource.events.on("error", function(ev) {
    console.log("Oopsy! Something went wrong");
});


});
am4core.ready(function() {

// Themes begin
    am4core.useTheme(am4themes_material);
    am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
    var chart = am4core.create("graph-04-2", am4charts.XYChart);
    chart.logo.disabled=true;

// Add data
    chart.data = [];

// Create axes

    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "country";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;

    categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
        if (target.dataItem && target.dataItem.index & 2 == 2) {
            return dy + 25;
        }
        return dy;
    });

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = "visits";
    series.dataFields.categoryX = "country";
    series.name = "Visits";
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;

    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;


            
// Add a legend
chart.legend = new am4charts.Legend();

chart.dataSource.url = 'http://train.ca/company/'+'get-graph-04-data-2';
chart.dataSource.load();
chart.dataSource.events.on("done", function(ev) {
    // Data loaded and parsed
    console.log(ev.target.data,'HAI');
});
chart.dataSource.events.on("error", function(ev) {
    console.log("Oopsy! Something went wrong");
});

});




am4core.ready(function() {

// Themes begin
    am4core.useTheme(am4themes_material);
    am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
    var chart = am4core.create("graph-04-3", am4charts.XYChart);
    chart.logo.disabled=true;

// Add data
    chart.data = [];

// Create axes

    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "country";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;

    categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
        if (target.dataItem && target.dataItem.index & 2 == 2) {
            return dy + 25;
        }
        return dy;
    });

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = "visits";
    series.dataFields.categoryX = "country";
    series.name = "Visits";
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;

    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;

                
// Add a legend
chart.legend = new am4charts.Legend();

chart.dataSource.url = 'http://train.ca/company/'+'get-graph-04-data-3';
chart.dataSource.load();
chart.dataSource.events.on("done", function(ev) {
    // Data loaded and parsed
    console.log(ev.target.data,'HAI');
});
chart.dataSource.events.on("error", function(ev) {
    console.log("Oopsy! Something went wrong");
});


});

</script>



