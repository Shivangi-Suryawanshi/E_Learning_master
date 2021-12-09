// alert('hai');
"use strict";
(window.createNewEvent = function (a, r, l, n) {
    var d = $("#newEventModal");
    d.modal("show");
    var i = d.find("form");
    function t(e) {
        e.preventDefault();
        var t = {
            title: i.serializeArray()[0].value,
            className: i.serializeArray()[1].value + "-light",
            start: r,
            end: l,
            allDay: n,
        };
        a.fullCalendar("renderEvent", t, !0),
            d.modal("hide"),
            a.fullCalendar("unselect");
    }
    i.one("submit", t),
        d.one("hidden.bs.modal", function (e) {
            i.off("submit", t),
                i.find("input").val(""),
                i
                    .find("select>option:first-child")
                    .attr("selected", "selected")
                    .parent()
                    .selectpicker("refresh");
        });
}),
    $(document).ready(function () {
        
        var e = new Date(),
            t = e.getMonth(),
            a = e.getFullYear();
        $("#external-events div.external-event").each(function () {
            var e = { title: $.trim($(this).text()) };
            $(this).data("eventObject", e),
                $(this).draggable({
                    zIndex: 999,
                    revert: !0,
                    revertDuration: 0,
                }); 
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
            buttonText: {
                prev: "<i class='fas fa-chevron-left'></i>",
                next: "<i class='fas fa-chevron-right'></i>",
                prevYear: "<i class='fas fa-arrow-left'></i>",
                nextYear: "<i class='fas fa-arrow-right'></i>",
                today: "Today",
                month: "Month",
                week: "Week",
                day: "Day",
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
            events: [
                { title: "All Day Event", start: new Date(a, t, 1) },
                {
                    id: 999,
                    title: "Repeating Event",
                    start: new Date(a, t, -2, 16, 0),
                    allDay: !1,
                    className: "bg-primary-light border-primary",
                },
                {
                    id: 999,
                    title: "Repeating Event 2",
                    start: new Date(a, t, 5, 16, 0),
                    allDay: !1,
                    className: "bg-info-light border-info",
                },
                {
                    title: "Meeting",
                    start: new Date(a, t, 1, 10, 30),
                    allDay: !1,
                    className: "bg-danger-light border-danger",
                },
                {
                    title: "Lunch",
                    start: new Date(a, t, 1, 12, 0),
                    end: new Date(a, t, 1, 14, 0),
                    allDay: !1,
                    className: "bg-danger-light border-danger",
                },
                {
                    title: "Birthday Party",
                    start: new Date(a, t, 2, 19, 0),
                    end: new Date(a, t, 2, 22, 30),
                    allDay: !1,
                },
                {
                    title: "Click for Google",
                    start: new Date(a, t, 28),
                    end: new Date(a, t, 29),
                    url: "http://google.com/",
                    className: "bg-success-light border-success",
                },
            ],
        });
    });
