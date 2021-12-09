@extends(theme('dashboard.layouts.dashboard'))
@section('content')
<div class="page-content">

    <!--     <header>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mb-0">Complete Company profile to Explore More</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 mt-2 p-0 breadcrumbs-chevron">
                            <li class="breadcrumb-item"><a href="/">Thursday, Sep 17, 6:05 pm</a></li>

                        </ol>
                    </nav>
                </div>
            </div>
        </header> -->


    {{-- <input type="text" class="calender-data" value="{{$calendarList}}"> --}}


    <div class="curriculum-top-nav d-flex p-2">
        <h4 class="flex-grow-1" style="margin-bottom: -15px;">Calendar </h4>


    </div>


                     <!-- User Profile -->
                <div class="panel-light h-auto" id="cpr">
                    {{-- <div class="panel-header">
                        <h1 class="panel-title">Calendar</h1>
                     <div class="panel-toolbar">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <button type="button" class="btn btn-sm btn-primary">ADD</button>
                            </div>
                        </div>

                    </div> --}}
                    <div>

                      <div class="panel panel-light panel-calendar">

<div class="panel-body p-0">
<div id="calendar" class="fc fc-ltr">

    {{-- <table class="fc-header" style="width:100%"><tr><td class="fc-header-left"><span class="fc-header-title"><h2>November 2020</h2></span></td><td class="fc-header-center"><span class="fc-button fc-button-agendaDay fc-state-default fc-corner-left" unselectable="on">Day</span><span class="fc-button fc-button-agendaWeek fc-state-default" unselectable="on">Week</span><span class="fc-button fc-button-month fc-state-default fc-corner-right fc-state-active" unselectable="on">Month</span></td><td class="fc-header-right"><span class="fc-button fc-button-prev fc-state-default fc-corner-left" unselectable="on"><i class="fas fa-chevron-left"></i></span><span class="fc-button fc-button-next fc-state-default fc-corner-right" unselectable="on"><i class="fas fa-chevron-right"></i></span><span class="fc-header-space"></span><span class="fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right fc-state-disabled" unselectable="on">Today</span></td></tr></table><div class="fc-content" style="position: relative;"><div class="fc-view fc-view-month fc-grid" style="position:relative" unselectable="on"><div class="fc-event-container" style="position:absolute;z-index:8;top:0;left:0"><div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end" style="position: absolute; left: 771px; width: 125px; top: 92px;"><div class="fc-event-inner"><span class="fc-event-title">All Day Event</span></div><div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div></div><div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end bg-primary-light border-primary ui-draggable" style="position: absolute; left: 387px; width: 123px; top: 92px;" unselectable="on"><div class="fc-event-inner"><span class="fc-event-time">4p</span><span class="fc-event-title">Repeating Event</span></div><div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div></div><div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end bg-info-light border-info" style="position: absolute; left: 387px; width: 123px; top: 270px;"><div class="fc-event-inner"><span class="fc-event-time">4p</span><span class="fc-event-title">Repeating Event</span></div><div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div></div><div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end bg-danger-light border-danger" style="position: absolute; left: 771px; width: 125px; top: 137px;"><div class="fc-event-inner"><span class="fc-event-time">10:30a</span><span class="fc-event-title">Meetinddg</span></div><div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div></div><div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end bg-danger-light border-danger ui-draggable" style="position: absolute; left: 771px; width: 125px; top: 182px;" unselectable="on"><div class="fc-event-inner"><span class="fc-event-time">12p</span><span class="fc-event-title">Lunch</span></div><div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div></div><div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end ui-draggable" style="position: absolute; left: 2px; width: 124px; top: 270px;" unselectable="on"><div class="fc-event-inner"><span class="fc-event-time">7p</span><span class="fc-event-title">Birthday Party</span></div><div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div></div><a href="http://google.com/" class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end bg-success-light border-success" style="position: absolute; left: 643px; width: 253px; top: 577px;"><div class="fc-event-inner"><span class="fc-event-title">Click for Google</span></div><div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div></a></div><table class="fc-border-separate" style="width:100%" cellspacing="0"><thead><tr class="fc-first fc-last"><th class="fc-day-header fc-mon fc-widget-header fc-first" style="width: 128px;">Mon</th><th class="fc-day-header fc-tue fc-widget-header" style="width: 128px;">Tue</th><th class="fc-day-header fc-wed fc-widget-header" style="width: 128px;">Wed</th><th class="fc-day-header fc-thu fc-widget-header" style="width: 128px;">Thu</th><th class="fc-day-header fc-fri fc-widget-header" style="width: 128px;">Fri</th><th class="fc-day-header fc-sat fc-widget-header" style="width: 128px;">Sat</th><th class="fc-day-header fc-sun fc-widget-header fc-last">Sun</th></tr></thead><tbody><tr class="fc-week fc-first"><td class="fc-day fc-mon fc-widget-content fc-other-month fc-past fc-first" data-date="2020-10-26"><div style="min-height: 102px;"><div class="fc-day-number">26</div><div class="fc-day-content"><div style="position: relative; height: 135px;">&nbsp;</div></div></div></td><td class="fc-day fc-tue fc-widget-content fc-other-month fc-past" data-date="2020-10-27"><div><div class="fc-day-number">27</div><div class="fc-day-content"><div style="position: relative; height: 135px;">&nbsp;</div></div></div></td><td class="fc-day fc-wed fc-widget-content fc-other-month fc-past" data-date="2020-10-28"><div><div class="fc-day-number">28</div><div class="fc-day-content"><div style="position: relative; height: 135px;">&nbsp;</div></div></div></td><td class="fc-day fc-thu fc-widget-content fc-other-month fc-past" data-date="2020-10-29"><div><div class="fc-day-number">29</div><div class="fc-day-content"><div style="position: relative; height: 135px;">&nbsp;</div></div></div></td><td class="fc-day fc-fri fc-widget-content fc-other-month fc-past" data-date="2020-10-30"><div><div class="fc-day-number">30</div><div class="fc-day-content"><div style="position: relative; height: 135px;">&nbsp;</div></div></div></td><td class="fc-day fc-sat fc-widget-content fc-other-month fc-past" data-date="2020-10-31"><div><div class="fc-day-number">31</div><div class="fc-day-content"><div style="position: relative; height: 135px;">&nbsp;</div></div></div></td><td class="fc-day fc-sun fc-widget-content fc-past fc-last" data-date="2020-11-01"><div><div class="fc-day-number">1</div><div class="fc-day-content"><div style="position: relative; height: 135px;">&nbsp;</div></div></div></td></tr><tr class="fc-week"><td class="fc-day fc-mon fc-widget-content fc-past fc-first" data-date="2020-11-02"><div style="min-height: 101px;"><div class="fc-day-number">2</div><div class="fc-day-content"><div style="position: relative; height: 60px;">&nbsp;</div></div></div></td><td class="fc-day fc-tue fc-widget-content fc-past" data-date="2020-11-03"><div><div class="fc-day-number">3</div><div class="fc-day-content"><div style="position: relative; height: 60px;">&nbsp;</div></div></div></td><td class="fc-day fc-wed fc-widget-content fc-past" data-date="2020-11-04"><div><div class="fc-day-number">4</div><div class="fc-day-content"><div style="position: relative; height: 60px;">&nbsp;</div></div></div></td><td class="fc-day fc-thu fc-widget-content fc-past" data-date="2020-11-05"><div><div class="fc-day-number">5</div><div class="fc-day-content"><div style="position: relative; height: 60px;">&nbsp;</div></div></div></td><td class="fc-day fc-fri fc-widget-content fc-past" data-date="2020-11-06"><div><div class="fc-day-number">6</div><div class="fc-day-content"><div style="position: relative; height: 60px;">&nbsp;</div></div></div></td><td class="fc-day fc-sat fc-widget-content fc-past" data-date="2020-11-07"><div><div class="fc-day-number">7</div><div class="fc-day-content"><div style="position: relative; height: 60px;">&nbsp;</div></div></div></td><td class="fc-day fc-sun fc-widget-content fc-past fc-last" data-date="2020-11-08"><div><div class="fc-day-number">8</div><div class="fc-day-content"><div style="position: relative; height: 60px;">&nbsp;</div></div></div></td></tr><tr class="fc-week"><td class="fc-day fc-mon fc-widget-content fc-past fc-first" data-date="2020-11-09"><div style="min-height: 101px;"><div class="fc-day-number">9</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-tue fc-widget-content fc-past" data-date="2020-11-10"><div><div class="fc-day-number">10</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-wed fc-widget-content fc-past" data-date="2020-11-11"><div><div class="fc-day-number">11</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-thu fc-widget-content fc-past" data-date="2020-11-12"><div><div class="fc-day-number">12</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-fri fc-widget-content fc-past" data-date="2020-11-13"><div><div class="fc-day-number">13</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-sat fc-widget-content fc-past" data-date="2020-11-14"><div><div class="fc-day-number">14</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-sun fc-widget-content fc-past fc-last" data-date="2020-11-15"><div><div class="fc-day-number">15</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td></tr><tr class="fc-week"><td class="fc-day fc-mon fc-widget-content fc-past fc-first" data-date="2020-11-16"><div style="min-height: 101px;"><div class="fc-day-number">16</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-tue fc-widget-content fc-past" data-date="2020-11-17"><div><div class="fc-day-number">17</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-wed fc-widget-content fc-past" data-date="2020-11-18"><div><div class="fc-day-number">18</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-thu fc-widget-content fc-past" data-date="2020-11-19"><div><div class="fc-day-number">19</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-fri fc-widget-content fc-past" data-date="2020-11-20"><div><div class="fc-day-number">20</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-sat fc-widget-content fc-past" data-date="2020-11-21"><div><div class="fc-day-number">21</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-sun fc-widget-content fc-past fc-last" data-date="2020-11-22"><div><div class="fc-day-number">22</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td></tr><tr class="fc-week"><td class="fc-day fc-mon fc-widget-content fc-past fc-first" data-date="2020-11-23"><div style="min-height: 101px;"><div class="fc-day-number">23</div><div class="fc-day-content"><div style="position: relative; height: 45px;">&nbsp;</div></div></div></td><td class="fc-day fc-tue fc-widget-content fc-past" data-date="2020-11-24"><div><div class="fc-day-number">24</div><div class="fc-day-content"><div style="position: relative; height: 45px;">&nbsp;</div></div></div></td><td class="fc-day fc-wed fc-widget-content fc-past" data-date="2020-11-25"><div><div class="fc-day-number">25</div><div class="fc-day-content"><div style="position: relative; height: 45px;">&nbsp;</div></div></div></td><td class="fc-day fc-thu fc-widget-content fc-past" data-date="2020-11-26"><div><div class="fc-day-number">26</div><div class="fc-day-content"><div style="position: relative; height: 45px;">&nbsp;</div></div></div></td><td class="fc-day fc-fri fc-widget-content fc-past" data-date="2020-11-27"><div><div class="fc-day-number">27</div><div class="fc-day-content"><div style="position: relative; height: 45px;">&nbsp;</div></div></div></td><td class="fc-day fc-sat fc-widget-content fc-today fc-state-highlight" data-date="2020-11-28"><div><div class="fc-day-number">28</div><div class="fc-day-content"><div style="position: relative; height: 45px;">&nbsp;</div></div></div></td><td class="fc-day fc-sun fc-widget-content fc-future fc-last" data-date="2020-11-29"><div><div class="fc-day-number">29</div><div class="fc-day-content"><div style="position: relative; height: 45px;">&nbsp;</div></div></div></td></tr><tr class="fc-week fc-last"><td class="fc-day fc-mon fc-widget-content fc-future fc-first" data-date="2020-11-30"><div style="min-height: 104px;"><div class="fc-day-number">30</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-tue fc-widget-content fc-other-month fc-future" data-date="2020-12-01"><div><div class="fc-day-number">1</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-wed fc-widget-content fc-other-month fc-future" data-date="2020-12-02"><div><div class="fc-day-number">2</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-thu fc-widget-content fc-other-month fc-future" data-date="2020-12-03"><div><div class="fc-day-number">3</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-fri fc-widget-content fc-other-month fc-future" data-date="2020-12-04"><div><div class="fc-day-number">4</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-sat fc-widget-content fc-other-month fc-future" data-date="2020-12-05"><div><div class="fc-day-number">5</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td><td class="fc-day fc-sun fc-widget-content fc-other-month fc-future fc-last" data-date="2020-12-06"><div><div class="fc-day-number">6</div><div class="fc-day-content"><div style="position: relative; height: 0px;">&nbsp;</div></div></div></td></tr></tbody></table></div></div> --}}
</div>
</div>
</div>

<div class="modals">

            <div class="modal fade" tabindex="-1" role="dialog" id="newEventModal">
                <div class="modal-dialog modal-mini modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <form action="#">

                            <div class="modal-body">
                                <div class="icon-box">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <h4 class="modal-title text-center">Setup A New Event</h4>

                                <div class="modal-form new-folder-form mt-3 px-4">

                                    <div class="form-group">
                                        <label for="storage-selector">Title</label>
                                        <input type="text" class="form-control" name="title" placeholder="Event Name" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="storage-selector">Color</label>
                                        <div class="dropdown bootstrap-select"><select name="class" class="selectpicker">

                                            <option value="bg-default" data-icon="far fa-circle">Default</option>
                                            <option value="bg-primary" data-icon="fas fa-circle text-primary">Primary</option>
                                            <option value="bg-secondary" data-icon="fas fa-circle text-secondary">Secondary</option>
                                            <option value="bg-success" data-icon="fas fa-circle text-success">Success</option>
                                            <option value="bg-danger" data-icon="fas fa-circle text-danger">Danger</option>
                                            <option value="bg-warning" data-icon="fas fa-circle text-warning">Warning</option>
                                            <option value="bg-info" data-icon="fas fa-circle text-info">Info</option>
                                            <option value="bg-light" data-icon="fas fa-circle text-light">Light</option>
                                            <option value="bg-dark" data-icon="fas fa-circle text-dark">Dark</option>

                                        </select><button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox" aria-expanded="false" title="Default"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner"><i class=" far fa-circle"></i>&nbsp;Default</div></div> </div></button><div class="dropdown-menu "><div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer row">
                                <div class="col-md-6 px-2">
                                    <button type="submit" class="btn btn-success btn-block">Save</button>
                                </div>
                                <div class="col-md-6 px-2">
                                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>

                    </div>
                </div> <!-- User Profile -->

    </div>

@endsection
    @section('page-css')

<link rel="stylesheet" href="{{asset('users/vendor/fullcalendar/fullcalendar.css')}}">
{{-- <link rel="stylesheet" href="{{asset('users/css/vendor.css')}}" /> --}}
<link rel="stylesheet" href="{{asset('users/css/style.css')}}" />

    @endsection



    @section('page-js')
    {{-- <script src="{{asset('users/js/vendor.js')}}"></script> --}}
<script src="{{asset('users/js/pages/applications/calendar.js')}}"></script>

<script src="{{asset('users/vendor/fullcalendar/fullcalendar.js')}}"></script>

{{-- <script src="{{asset('institute/custom/calender-view.js')}}"></script> --}}

{{-- <script src="{{asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js')}}"></script> --}}


@endsection
