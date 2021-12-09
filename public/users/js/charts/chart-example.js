am4core.ready(function() {
    am4core.useTheme(am4themes_animated);
    var e = am4core.create("graph-1", am4charts.XYChart);

    //var dataSource = new am4core.DataSource();
    e.dataSource.url = COMPANY_URL+'get-graph-1-data';
    e.dataSource.load();
    e.dataSource.events.on("done", function(ev) {
    // Data loaded and parsed
    // console.log(ev.target.data);
    });
    e.dataSource.events.on("error", function(ev) {
        console.log("Oopsy! Something went wrong");
      });
      

    // e.dataSource.requestOptions.requestHeaders = [
    //     { key: "Accept", value: "*/*" },
    //     { key: "Content-Type", value: "text/csv" },
    //     { key: "Authorization", value: "123456789" }
    //   ];
 
    var a = e.xAxes.push(new am4charts.CategoryAxis);
    a.dataFields.category = "department", a.renderer.grid.template.location = 0, a.renderer.minGridDistance = 30, a.renderer.labels.template.adapter.add("dy", function(e, a) {
        return a.dataItem && !0 & a.dataItem.index ? e + 25 : e
    });
    e.yAxes.push(new am4charts.ValueAxis);
    var t = e.series.push(new am4charts.ColumnSeries);
    t.dataFields.valueY = "total", t.dataFields.categoryX = "department", t.name = "Count", t.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]", t.columns.template.fillOpacity = .8;
    var r = t.columns.template;
    r.strokeWidth = 2, r.strokeOpacity = 1
});