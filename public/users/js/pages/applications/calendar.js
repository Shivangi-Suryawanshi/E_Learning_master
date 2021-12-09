// alert('hai');
"use strict";
// dsdsdsdsA1       
// (window.createNewEvent = function (a, r, l, n) {
//     var d = $("#newEventModal");
//     d.modal("show");
//     var i = d.find("form");
//     function t(e) {
//         e.preventDefault();
//         var t = {    
//             title: i.serializeArray()[0].value,
//             className: i.serializeArray()[1].value + "-light",
//             start: r,
//             end: l,
//             allDay: n,
//         };
//         a.fullCalendar("renderEvent", t, !0),
//             d.modal("hide"),
//             a.fullCalendar("unselect");
//     }
//     i.one("submit", t),
//         d.one("hidden.bs.modal", function (e) {
//             i.off("submit", t),
//                 i.find("input").val(""),
//                 i
//                     .find("select>option:first-child")
//                     .attr("selected", "selected")
//                     .parent()
//                     .selectpicker("refresh");
//         });
// }),
    $(document).ready(function () {
       var schedule=[];
        $.ajax({
            url: base_url + "/dashboard/calender/get-list",
            success: function (data) {
               var  result = data.events;
                $.each(result, function(key,val) {
                    var e = new Date(val.start),
                        t = e.getMonth(),
                        a = e.getFullYear(),
                        d = e.getDate();
                      var startDate =  new Date(a, t, d)
                  schedule.push({title:"Section Name:"+val.section_name
                   + "\nSeat Available :" + val.seat_available, start:startDate,
                  id: val.id , className: "bg-info-light border-info" ,
                  seat_available : "Seat Available :" + val.seat_available});
                });
                  var r = $("#calendar").fullCalendar({

                    header: {
                        left: "title",
                        center: "agendaDay,agendaWeek,month",
                        right: "prev,next today",
                    },
                    editable: !0,
                    firstDay: 1,
                    selectable: !0,
                    defaultView: "month",
                    axisFormat: "h:mm",
                    columnFormat: {
                        month: "ddd",
                        week: "ddd d",
                        day: "dddd M/d",
                        agendaDay: "dddd d",
                    },
                    titleFormat: {
                        month: "MMMM yyyy",
                        week: "MMMM yyyy",
                        day: "MMMM yyyy",
                    },
                    allDaySlot: !1,
                    selectHelper: !0,
                    select: function (e, t, a) {

                        createNewEvent(r, e, t, a);
                    },
                    droppable: !0,
                    drop: function (e, t) {

                        var a = $(this).data("eventObject"),
                            r = $.extend({}, a);
                        (r.start = e),
                            (r.allDay = t),
                            $("#calendar").fullCalendar("renderEvent", r, !0),
                            $("#drop-remove").is(":checked") && $(this).remove();
                    },
                    events:
                        schedule
                });

            },
            error: function (data) {

            },
        });



        //    var r = $("#calendar").fullCalendar({

        //             header: {
        //                 left: "title",
        //                 center: "agendaDay,agendaWeek,month",
        //                 right: "prev,next today",
        //             },
        //             editable: !0,
        //             firstDay: 1,
        //             selectable: !0,
        //             defaultView: "month",
        //             axisFormat: "h:mm",
        //             columnFormat: {
        //                 month: "ddd",
        //                 week: "ddd d",
        //                 day: "dddd M/d",
        //                 agendaDay: "dddd d",
        //             },
        //             titleFormat: {
        //                 month: "MMMM yyyy",
        //                 week: "MMMM yyyy",
        //                 day: "MMMM yyyy",
        //             },
        //             buttonText: {
        //                 // prev: "<i class='fas fa-chevron-left'></i>",
        //                 // next: "<i class='fas fa-chevron-right'></i>",
        //                 // prevYear: "<i class='fas fa-arrow-left'></i>",
        //                 // nextYear: "<i class='fas fa-arrow-right'></i>",
        //                 // today: "Today",
        //                 // month: "Month",
        //                 // week: "Week",
        //                 // day: "Day",
        //             },
        //             allDaySlot: !1,
        //             selectHelper: !0,
        //             select: function (e, t, a) {

        //                 createNewEvent(r, e, t, a);
        //             },
        //             droppable: !0,
        //             drop: function (e, t) {

        //                 var a = $(this).data("eventObject"),
        //                     r = $.extend({}, a);
        //                 (r.start = e),
        //                     (r.allDay = t),
        //                     $("#calendar").fullCalendar("renderEvent", r, !0),
        //                     $("#drop-remove").is(":checked") && $(this).remove();
        //             },
        //             events:
        //                 schedule
        //         });


    });

