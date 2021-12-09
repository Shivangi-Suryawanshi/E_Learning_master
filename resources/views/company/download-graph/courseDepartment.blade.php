<div class="tab-pane fade" id="panel-with-pills-tab-1" aria-expanded="true">
    <span style="float:right;"> <a href="javascript:window.print()" class=" "><i
        title="download" class="btn-btn-primary">Print</i></a></span>

    {{-- <h4 class="mb-3">Courses</h4> --}}
    <div class="col-xs-12">
        <div class="panel panel-light h-auto"
            style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

            <div class="panel-header">
                <h4 class="fs1r">Course VS Department</h4>
            </div>

            <div class="panel-body pl-3 py-3">
                <div class="" data-title="COURSES">
                    <div id="graph-1" style="height: 400px; "></div>
                    {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                </div>
            </div>
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
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create('graph-1', am4charts.XYChart)
//chart.colors.step = 2;
chart.colors.list = [
  am4core.color("#007bff"),
  am4core.color("#59b300"),
  am4core.color("#ff6666")
];
chart.logo.disabled=true;

chart.legend = new am4charts.Legend()
chart.legend.position = 'top'
chart.legend.paddingBottom = 20
chart.legend.labels.template.maxWidth = 95

var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
xAxis.dataFields.category = 'category'
xAxis.renderer.cellStartLocation = 0.1
xAxis.renderer.cellEndLocation = 0.9
xAxis.renderer.grid.template.location = 0;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;

function createSeries(value, name) {
    var series = chart.series.push(new am4charts.ColumnSeries())
    series.dataFields.valueY = value,
    series.dataFields.categoryX = 'category'
    series.name = name,


    series.events.on("hidden", arrangeColumns);
    series.events.on("shown", arrangeColumns);

    var bullet = series.bullets.push(new am4charts.LabelBullet())
    bullet.interactionsEnabled = false
    bullet.dy = 30;
    bullet.label.text = '{valueY}'
    bullet.label.fill = am4core.color('#ffffff')

    return series;
}

chart.dataSource.url = 'http://train.ca/company/'+'get-graph-1-data';
chart.dataSource.load();
chart.dataSource.events.on("done", function(ev) {
// Data loaded and parsed
// console.log('aaa');
console.log(ev.target.data);
});
chart.dataSource.events.on("error", function(ev) {
    console.log("Oopsy! Something went wrong");
  });


createSeries('total', 'Total Courses');
createSeries('valid', 'Valid Courses');
createSeries('expired', 'Expired Courses');

function arrangeColumns() {

    var series = chart.series.getIndex(0);

    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
          //  series.text.pointerOrientation = "vertical";
        var delta = ((x1 - x0) / chart.series.length) * w;
        if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart.series.indexOf(series);
                }
            })
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;
            chart.series.each(function(series) {
                var trueIndex = chart.series.indexOf(series);
                var newIndex = series.dummyData;

                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx },
                 series.interpolationDuration,
                  series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx },
                 series.interpolationDuration,
                  series.interpolationEasing);
            })
        }
    }
}

}); // end am4core.ready()

</script>