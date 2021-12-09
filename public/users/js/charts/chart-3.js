am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create("graph-3", am4charts.XYChart);
    chart.logo.disabled=true;

    // Add data
    chart.dataSource.url = COMPANY_URL+'get-graph-3-data';
    chart.dataSource.load();
    chart.dataSource.events.on("done", function(ev) {
        // Data loaded and parsed
        console.log(ev.target.data);
    });
    chart.dataSource.events.on("error", function(ev) {
        console.log("Oopsy! Something went wrong");
    });
    
    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "name";
    categoryAxis.renderer.grid.template.disabled = true;
    categoryAxis.renderer.minGridDistance = 30;
    categoryAxis.renderer.inside = true;
    categoryAxis.renderer.labels.template.fill = am4core.color("#000");
    categoryAxis.renderer.labels.template.fontSize = 20;
    
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.renderer.grid.template.strokeDasharray = "4,4";
    valueAxis.renderer.labels.template.disabled = true;
    valueAxis.min = 0;
    
    // Do not crop bullets
    chart.maskBullets = false;
    
    // Remove padding
    chart.paddingBottom = 0;
    
    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = "courses";
    series.dataFields.categoryX = "name";
    series.columns.template.propertyFields.fill = "color";
    series.columns.template.propertyFields.stroke = "color";
    series.columns.template.column.cornerRadiusTopLeft = 15;
    series.columns.template.column.cornerRadiusTopRight = 15;
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/b]";
    
    // Add bullets
    var bullet = series.bullets.push(new am4charts.Bullet());
    var image = bullet.createChild(am4core.Image);
    image.horizontalCenter = "middle";
    image.verticalCenter = "bottom";
    image.dy = 20;
    image.y = am4core.percent(100);
    image.propertyFields.href = "bullet";
    image.tooltipText = series.columns.template.tooltipText;
    image.propertyFields.fill = "color";
    image.filters.push(new am4core.DropShadowFilter());
    
    }); // end am4core.ready()
    