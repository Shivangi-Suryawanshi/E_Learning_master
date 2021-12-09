am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create('graph-01', am4charts.XYChart)
//chart.colors.step = 2;
chart.colors.list = [
  am4core.color("#007bff"),
  am4core.color("#ff6666"),

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

chart.dataSource.url = COMPANY_URL+'get-graph-1-data';
chart.dataSource.load();
chart.dataSource.events.on("done", function(ev) {
// Data loaded and parsed
// console.log('aaa');
// console.log(ev.target.data);
});
chart.dataSource.events.on("error", function(ev) {
    console.log("Oopsy! Something went wrong");
  });


createSeries('total', 'Total Certificate');
createSeries('expired', 'Expired Certificate');

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
