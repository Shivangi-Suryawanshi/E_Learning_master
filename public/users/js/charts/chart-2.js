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

    chart.dataSource.url = COMPANY_URL+'get-graph-2-data';
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
