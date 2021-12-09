
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
     // Create chart instance
    var chart4 = am4core.create("graph-4", am4charts.XYChart3D);
    chart4.logo.disabled=true;

    // Create axes
    var categoryAxis = chart4.yAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "type";
    categoryAxis.numberFormatter.numberFormat = "#";
    categoryAxis.renderer.inversed = true;
    
    var  valueAxis = chart4.xAxes.push(new am4charts.ValueAxis()); 
    
    // Create series
    var series = chart4.series.push(new am4charts.ColumnSeries3D());
    series.dataFields.valueX = "certificates";
    series.dataFields.categoryY = "type";
    series.name = "Certificates";
    series.columns.template.propertyFields.fill = "color";
    series.columns.template.tooltipText = "{valueX}";
    series.columns.template.column3D.stroke = am4core.color("#fff");
    series.columns.template.column3D.strokeOpacity = 0.2;
    
    