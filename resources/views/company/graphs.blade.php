@extends('company.layouts.app-company')
@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('myadmin/datepicker/css/bootstrap-datepicker.css') }}">
    <style>
        .hide {
            display: none !important;
        }

    </style>
@endsection
@section('content')
    <div class="page-content">
        <header>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mb-0" id="hedn">Graphs</h1>
                </div>
            </div>
        </header>


        <!-- start -->
        <div class="panel panel-light">
            <div class="panel-header">

                <div class="panel-toolbar">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow active" data-toggle="tab"
                                href="#panel-with-pills-tab-01" role="tab" aria-selected="false">
                                <h6> Expired VS Total Certificates </h6>
                            </a>

                            {{-- <a href="javascript:window.print()" class="fa fa-print"><i
                                            title="download" class="fa fa-print">Print</i></a> --}}
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" data-toggle="tab" href="#panel-with-pills-tab-02"
                                role="tab" aria-selected="false">
                                <h6> Expired certificates VS Training </h6>
                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" data-toggle="tab" href="#panel-with-pills-tab-03"
                                role="tab" aria-selected="false">
                                <h6> Expired certificates VS Project </h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" data-toggle="tab" href="#panel-with-pills-tab-04"
                                role="tab" aria-selected="false">
                                <h6> Cost spend on Trainings </h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" data-toggle="tab" href="#panel-with-pills-tab-1"
                                role="tab" aria-selected="false">
                                <h6> Courses </h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" data-toggle="tab" href="#panel-with-pills-tab-2"
                                role="tab" aria-selected="true">
                                <h6> Certificate Overall staus </h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" data-toggle="tab" href="#panel-with-pills-tab-3"
                                role="tab" aria-selected="false">
                                <h6> Workforce Certifications </h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-primary has-arrow" data-toggle="tab" href="#panel-with-pills-tab-4"
                                role="tab" aria-selected="false">
                                <h6> Certificate Status </h6>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">

                    {{-- *****************************************************NEW GRAPH 01*************************************** --}}
                    <div class="tab-pane fade  active show" id="panel-with-pills-tab-01" aria-expanded="true">
                        <span style="float:right;"> <a href="{{route('download-expired-totalCerit')}}" class="fa fa-print" > Click Download </a></span>
                        <h4 class="mb-3">Expired VS Total Certificates </h4>

                        <div class="col-xs-12">
                            <div class="panel panel-light h-auto"
                                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                <div class="panel-header">
                                    <h4 class="fs1r">Number of expired certificates from total certificates.
                                    </h4>

                                </div>

                                <div class="panel-body pl-3 py-3">
                                    <div class="" data-title="COURSES">
                                        <div id="graph-01" style="height: 400px; "></div>
                                        {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- / Column Chart with Datalabels -->
                        </div>
                    </div>
                    
                    {{-- *****************************************************GRAPHP END*************************************** --}}

                    {{-- *****************************************************NEW GRAPH 02*************************************** --}}
                    <div class="tab-pane fade" id="panel-with-pills-tab-02" aria-expanded="true">
                        <span style="float:right;"> <a href="{{route('download-expired-certificate')}}" class="fa fa-print" > Click Download </a></span>

                        <h4 class="mb-3">Expired Certificates VS Training</h4>
                        <div class="col-xs-12">
                            <div class="panel panel-light h-auto"
                                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                <div class="panel-header">
                                    <h4 class="fs1r">Number of workers with expired certificates in specific
                                        trainings. </h4>
                                </div>

                                <div class="panel-body pl-3 py-3">
                                    <div class="" data-title="COURSES">
                                        <div id="graph-02" style="height: 400px; "></div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-12">

                                <!-- Column chart with images on top -->
                                <div class="panel panel-light">
                                    <div class="panel-header">
                                        <h1 class="panel-title">ng</h1>
                                    </div>

                                    <div class="table-responsive">

                                        <table class="table table-bordered table-row-hover">
                                            <thead class="thead theadin">
                                            <tr>
                                                <th>Training</th>
                                                <th>Number of workers with expired certificates</th>


                                            </tr>
                                            </thead>
                                            <tbody class="bglight">
                                            <tr>

                                                <td>PHP</td>
                                                <td width="350px">2</td>


                                            </tr>

                                            <tr>
                                                <td>Python</td>
                                                <td width="350px">1</td>

                                            </tr>

                                            <tr>
                                                <td>SEO</td>
                                                <td width="350px">1</td>

                                            </tr>
                                            <tr>
                                                <td>DESIGNING</td>
                                                <td width="350px">3</td>

                                            </tr>


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> --}}
                            <!-- / Column Chart with Datalabels -->
                        </div>
                        <!-- / Column Chart with Datalabels -->
                    </div>

                    {{-- *****************************************************GRAPHP END*************************************** --}}

                    {{-- *****************************************************NEW GRAPH 03 PROJECTS**************************** --}}
                    <div class="tab-pane fade" id="panel-with-pills-tab-03" aria-expanded="true">
                        <span style="float:right;"> <a href="{{route('download-expired-certificate-project')}}" class="fa fa-print" > Click Download </a></span>

                        <h4 class="mb-3">Expired Certificates VS Projects</h4>
                        <div class="col-xs-12">
                            <div class="panel panel-light h-auto"
                                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                <div class="panel-header">
                                    <h4 class="fs1r">Number of workers with expired certificates in specific
                                        projects. </h4>
                                </div>

                                <div class="panel-body pl-3 py-3">
                                    <div class="" data-title="COURSES">
                                        <div id="graph-03" style="height: 400px; "></div>
                                        {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-12">

                                <!-- Column chart with images on top -->
                                <div class="panel panel-light">
                                    <div class="panel-header">
                                        <h1 class="panel-title">Number of workers with expired certificates in specific projects</h1>
                                    </div>

                                    <div class="table-responsive">

                                        <table class="table table-bordered table-row-hover">
                                            <thead class="thead theadin">
                                            <tr>
                                                <th>Projects</th>
                                                <th>Number of workers with expired certificates</th>


                                            </tr>
                                            </thead>
                                            <tbody class="bglight">
                                            <tr>

                                                <td>Project Yarddiant</td>
                                                <td width="350px">3</td>


                                            </tr>

                                            <tr>
                                                <td>Project Travis</td>
                                                <td width="350px">2</td>

                                            </tr>

                                            <tr>
                                                <td>Project Google</td>
                                                <td width="350px">1</td>

                                            </tr>
                                            <tr>
                                                <td>Project Autoimmune</td>
                                                <td width="350px">3</td>

                                            </tr>


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> --}}
                            <!-- / Column Chart with Datalabels -->
                        </div>
                        <!-- / Column Chart with Datalabels -->
                    </div>

                    {{-- *****************************************************GRAPHP END*************************************** --}}

                    {{-- *****************************************************NEW GRAPH 03 COST SPENT ON CATEGORY************* --}}
                    <div class="tab-pane fade" id="panel-with-pills-tab-04" aria-expanded="true">
                        <span style="float:right;"> <a href="{{route('download-cost-spend')}}" class="fa fa-print" > Click Download </a></span>

                        <h4 class="mb-3">Cost spend on Trainings based on categories</h4>

                        <div class="col-xs-12">
                            <div class="panel panel-light h-auto"
                                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                <div class="panel-header">
                                    <h4 class="fs1r">Total cost that the company spent on the training of a specific
                                        project
                                    </h4>
                                </div>

                                <div class="panel-body pl-3 py-3">
                                    <div class="" data-title="COURSES">
                                        <div id="graph-04-1" style="height: 400px; "></div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="panel panel-light h-auto"
                                    style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                    <div class="panel-header">
                                        <h4 class="fs1r">Total cost that the company spent on the training of a
                                            specific department
                                        </h4>
                                    </div>

                                    <div class="panel-body pl-3 py-3">
                                        <div class="" data-title="COURSES">
                                            <div id="graph-04-2" style="height: 400px; "></div>
                                            {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                                        </div>
                                    </div>
                                </div>

                                <!-- / Column Chart with Datalabels -->
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-light h-auto"
                                    style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                    <div class="panel-header">
                                        <h4 class="fs1r">Total cost that the company spent on the training of a
                                            specific position
                                        </h4>
                                    </div>

                                    <div class="panel-body pl-3 py-3">
                                        <div class="" data-title="COURSES">
                                            <div id="graph-04-3" style="height: 400px; "></div>
                                            {{-- <div id="column-datalabels" style="height: 300px; "></div> --}}
                                        </div>
                                    </div>
                                </div>

                                <!-- / Column Chart with Datalabels -->
                            </div>
                            <!-- / Column Chart with Datalabels -->
                        </div>
                    </div>

                    {{-- *****************************************************GRAPHP END*************************************** --}}

                    {{-- *****************************************************NEW GRAPH *************************************** --}}
                    <div class="tab-pane fade" id="panel-with-pills-tab-1" aria-expanded="true">
                        <span style="float:right;"> <a href="{{route('course-department')}}" class="fa fa-print" > Click Download </a></span>

                        <h4 class="mb-3">Courses</h4>
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
                    {{-- *****************************************************GRAPHP END*************************************** --}}



                    <div class="tab-pane fade" id="panel-with-pills-tab-2" aria-expanded="true">
                        <span style="float:right;"> <a href="{{route('certificate-status')}}" class="fa fa-print" > Click Download </a></span>

                        <h4 class="mb-3">Certificate Status</h4>
                        <div class="col-xs-12">
                            <!-- Donut Chart -->
                            <div class="panel panel-light h-auto"
                                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                <div class="panel-header">
                                    <h4 class="fs1r">Number of valid,expired,about to expire certificates from total
                                        certificates.</h4>
                                </div>


                                <div class="panel-body pl-3 py-3">
                                    <div class="" data-title="CERTIFICATES">
                                        <div id="graph-2" style="height: 400px; "></div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Donut Chart -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="panel-with-pills-tab-3" aria-expanded="true">
                        <h4 class="mb-3">Workforce Certifications</h4>
                        <div class="col-xs-12">


                            <!-- Donut Chart -->
                            <div class="panel panel-light h-auto"
                                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">
                                <div class="panel-header">
                                    <h4 class="fs1r"> Workforce Certifications</h4>
                                </div>

                                <div class="panel-body pl-3 py-3">
                                    <div class="" data-title="WORKFORCE CERTIFICATIONS">
                                        <div id="graph-3" style="height: 400px; "></div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Donut Chart -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="panel-with-pills-tab-4" aria-expanded="true">
                        <h4 class="mb-3"> Certificate Status </h4>
                        <div class="col-xs-12">

                            <div class="panel panel-light h-auto"
                                style="box-shadow: rgba(0, 0, 0, 0.55) 0px 2px 5px !important;">

                                <div class="panel-header">
                                    <h4 class="fs1r">Certificate status based on Department/Course</h4>
                                </div>


                                <div class="panel-body pl-3 py-3">
                                    <div class="" data-title="Certificate Status">
                                        <div id="graph-4-filter" style="height: 200px; margin-top: 20px; ">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Select Category</label>
                                                        <select id="category" name="category" data-toggle="select2"
                                                            data-search="true" class="form-control">
                                                            <option value="">-Select-</option>
                                                            <option value="1">Department</option>
                                                            {{-- <option value="2">Position</option>
                                                            <option value="3">Project</option> --}}
                                                            <option value="4">Course</option>
                                                        </select>
                                                        <label id="category-error" class="error hide" for="category">Please
                                                            Select a Category</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Select Item</label>
                                                        <select id="select_item" name="select_item" data-toggle="select2"
                                                            data-search="true" class="form-control">
                                                        </select>
                                                        <label id="select_item-error" class="error hide"
                                                            for="select_item">Please Select an Item</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="">&nbsp;</label>
                                                    <div class="form-group" style="margin-top: -4px;">
                                                        <button type="button" class="m-1 btn btn-dark" id="getGraph4"><i
                                                                class="fa fa-search" aria-hidden="true"></i> Find</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="graph-4" style="height: 300px;margin-top: -120px; "></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end -->

    </div>
    </div>
@endsection
@section('additional_scripts')
    <script src="{{ asset('users/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('users/vendor/amcharts/amcharts.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
    <script src="{{ asset('users/js/charts/chart-01.js') }}"></script>
    <script src="{{ asset('users/js/charts/chart-02.js') }}"></script>
    <script src="{{ asset('users/js/charts/chart-03.js') }}"></script>
    <script src="{{ asset('users/js/charts/chart-04.js') }}"></script>
    <script src="{{ asset('users/js/charts/chart-1.js') }}"></script>
    <script src="{{ asset('users/js/charts/chart-2.js') }}"></script>
    <script src="{{ asset('users/js/charts/chart-3.js') }}"></script>
    <script src="{{ asset('users/js/charts/chart-4.js') }}"></script>

    <script type="text/javascript">
        $("#category").change(function() {
            var category = $("#category").val();
            if (category == "") {
                $('#select_item').empty();
            }
            if (category == 1) {
                get_departments('all', '', 'select_item');
            }
            if (category == 4) {
                get_courses('all', '', '', 'select_item');
            }
            $("#category-error").addClass('hide');
            $("#category").removeClass('error');

        });

        $("#select_item").change(function() {
            var category = $("#category").val();
            var id = $("#select_item").val();
            if (category == "") {
                $("#category-error").removeClass('hide');
                $("#category").addClass('error');
            }
            $("#select_item-error").addClass('hide');
            $("#select_item").removeClass('error');
        });


        $("#getGraph4").click(function() {
            var category = $("#category").val();
            var id = $("#select_item").val();
            if (category != "" && id != "") {
                $("#select_item-error").addClass('hide');
                $("#select_item").removeClass('error');
                chart4.dataSource.url = COMPANY_URL + 'get-graph-4-data/' + category + '/' + id;
                chart4.dataSource.load();
                chart4.dataSource.events.on("done", function(ev) {
                    // Data loaded and parsed
                    console.log(ev.target.data);
                });
                chart4.dataSource.events.on("error", function(ev) {
                    console.log("Oopsy! Something went wrong");
                });
            } else {
                if (category == "") {
                    $("#category-error").removeClass('hide');
                    $("#category").addClass('error');
                } else {
                    $("#select_item-error").removeClass('hide');
                    $("#select_item").addClass('error');
                }
            }

        });

        function get_departments(whose, whose_id, where_id) {
            $.ajax({
                type: "POST",
                url: COMPANY_URL + 'get-departments-with-selected',
                data: {
                    whose: whose,
                    id: whose_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#' + where_id).empty();
                    var $newOption = $("<option></option>").val("").text("-Select-");
                    $("#" + where_id).append($newOption).trigger('change');
                    response.optn_values && response.optn_values.map((item, idx) => {
                        var text = response.optn_text[idx];
                        var selected = response.optn_selects[idx];
                        var $newOption = $("<option " + selected + "></option>").val(item).text(text);
                        $("#" + where_id).append($newOption).trigger('change');
                    })
                }
            });
        }

        function get_courses(whose, whose_id, type, where_id) {
            $.ajax({
                type: "POST",
                url: COMPANY_URL + 'get-courses-with-selected',
                data: {
                    whose: whose,
                    id: whose_id,
                    type: type,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#' + where_id).empty();
                    var $newOption = $("<option></option>").val("").text("-Select-");
                    $("#" + where_id).append($newOption).trigger('change');
                    response.optn_values && response.optn_values.map((item, idx) => {
                        var text = response.optn_text[idx];
                        var selected = response.optn_selects[idx];
                        var $newOption = $("<option></option>").val(item).text(text);
                        $("#" + where_id).append($newOption).trigger('change');
                    })
                }
            });
        }

    </script>
    {{-- <script>
        var myBlob;

$$('#myTable').DataTable( {
buttons: [
    'pdf'
]
} );
    </script> --}}
@endsection
