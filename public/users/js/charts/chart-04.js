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

chart.dataSource.url = COMPANY_URL+'get-graph-04-data';
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

chart.dataSource.url = COMPANY_URL+'get-graph-04-data-2';
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

chart.dataSource.url = COMPANY_URL+'get-graph-04-data-3';
chart.dataSource.load();
chart.dataSource.events.on("done", function(ev) {
    // Data loaded and parsed
    console.log(ev.target.data,'HAI');
});
chart.dataSource.events.on("error", function(ev) {
    console.log("Oopsy! Something went wrong");
});


});
