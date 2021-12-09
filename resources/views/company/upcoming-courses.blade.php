@extends('company.layouts.app-company')
@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('users/vendor/select2/select2.min.css') }}">
@endsection
@section('content')
    <div class="page-content">
        <header>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mb-0">Upcoming Courses</h1>
                </div>
            </div>
        </header>
        <div class="panel panel-light">
            <div class="container mw50">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div>
                                <ul class="nav nav-pills nav-fill">
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-primary has-arrow"
                                            href="{{ route('training-matrix') }}">
                                            <h6><i class="fa fa-cube" aria-hidden="true"></i>
                                                Training Matrix </h6>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-primary has-arrow"
                                            href="{{ route('progress-report') }}">
                                            <h6><i class="fa fa-bullhorn" aria-hidden="true"></i> Progress</h6>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-primary has-arrow active"
                                            href="{{ route('upcoming-courses') }}">
                                            <h6> <i class="fa fa-bullhorn" aria-hidden="true"></i> Upcoming Courses</h6>
                                        </a>
                                    </li>
                                    @if (Auth::user()->user_type == 'company')
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-primary has-arrow" href="{{ route('graphs') }}">
                                                <h6><i class="fa fa-cubes" aria-hidden="true"></i> Graphs</h6>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row mt20">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Employees</label>
                            <select id="search_employees" name="search_employees[]" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Department</label>
                            <select id="search_department" name="search_department" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Position</label>
                            <select id="search_position" name="search_position" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Project</label>
                            <select id="search_project" name="search_project" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt20">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Course </label>
                            <select id="search_course" name="search_course" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Course Type</label>
                            <select id="search_type" name="search_type" class="form-control">
                                <option value="">-Select-</option>
                                <option value="1">Internal</option>
                                <option value="2">External</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <div class="form-group ">
                            <button type="button" class="btn btn-dark" id="searchBtn"><i class="fa fa-search"
                                    aria-hidden="true"></i> Find</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body mt20">
                <div class="row">
                    <div class="col-md-8 mb10" align="left">
                        <div class="btn-group">
                            {{-- <button type="button" class="btn btn-secondary "><i class="fa fa-file-pdf-o"
                                    aria-hidden="true"></i> PDF</button>
                            <button type="button" class="btn btn-secondary "><i class="fa fa-file-excel-o"
                                    aria-hidden="true"></i> Excel</button>
                            <button type="button" class="btn btn-secondary "><i class="fa fa-file" aria-hidden="true"></i>
                                CSV</button>
                            <button type="button" class="btn btn-secondary"> <i class="fa fa-print" aria-hidden="true"></i>
                                Print</button> --}}
                                {{-- <a href="javascript:window.print()" role="button" class="btn btn-secondary"> <i class="fa fa-print"
                                    aria-hidden="true"></i> Print</a> --}}
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-row-hover" id="example">
                        <thead class="thead theadin">
                            <tr>
                                <th width="30px">No</th>
                                <th width="180px">NAME</th>
                                <th width="180px">EMPLOYEE&nbsp;NO</th>
                                <th width="180px">DEPARTMENTS</th>
                                <th width="180px">POSITIONS</th>
                                <th width="180px">PROJECTS</th>
                                <th width="180px">COURSE</th>
                                <th width="180px">TYPE</th>
                                <th width="180px">START&nbsp;DATE</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('additional_scripts')
    <script src="{{ asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('users/js/pages/form/extended/select2.js') }}"></script>
    <script src="{{ asset('users/vendor/select2/select2.full.min.js') }}"></script>
    <script src=" https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js
    "></script>
   <script src=" https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js
    "></script>
   <script src=" https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
    "></script>
   <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
    "></script>
   <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
    "></script>
   <script src=" https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js
    "></script>
    <script type="text/javascript">
        $(document).ready(function() {
            loadTable();
            get_positions('all', '', 'search_position');
            get_departments('all', '', 'search_department');
            get_projects('all', '', 'search_project');
            get_courses('all', '', '', 'search_course');
            get_employees('all', '', '', 'search_employees');
        });

        $('#searchBtn').click(function() {
            table = $('#example').DataTable();
            table.destroy();
            loadTable();
        });


        function loadTable() {
            var $department = $("#search_department").val();
            var $position = $("#search_position").val();
            var $project = $("#search_project").val();
            var $employee = $("#search_employees").val();
            var $course = $("#search_course").val();
            var $type = $("#search_type").val();

            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel',
                    'csv',
                    'pdf'
                ],
                "fnDrawCallback": function(oSettings) {
                    if (oSettings.bSorted || oSettings.bFiltered || oSettings._iDisplayLength) {
                        j = 0;
                        for (var i = oSettings._iDisplayStart; i < oSettings.aiDisplay.length + oSettings
                            ._iDisplayStart; i++) {
                            $('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[j]].nTr).find('span').text(i +
                                1);
                            j++;
                        }
                    }
                },

                processing: true,
                serverSide: true,
                "pageLength": 10,
                ajax: {
                    url: COMPANY_URL + 'get-upcoming-courses-data',
                    data: function(d) {
                        d.department = $department;
                        d.position = $position;
                        d.project = $project;
                        d.employee = $employee;
                        d.course = $course;
                        d.type = $type;
                    }
                },
                "columnDefs": [{
                    'orderable': false,
                    'targets': [0, 1]
                }],
                mark: true,
                fixedColumns: {},
                columns: [{
                        data: 's#',
                        name: 's#'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'emp_no',
                        name: 'emp_no'
                    },
                    {
                        data: 'departments',
                        name: 'departments'
                    },
                    {
                        data: 'positions',
                        name: 'positions'
                    },
                    {
                        data: 'projects',
                        name: 'projects'
                    },
                    {
                        data: 'course',
                        name: 'course'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    }
                ]
            });
        }

        function get_positions(whose, whose_id, where_id) {
            $.ajax({
                type: "POST",
                url: COMPANY_URL + 'get-positions-with-selected',
                data: {
                    whose: whose,
                    id: whose_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#' + where_id).empty();
                    response.optn_values && response.optn_values.map((item, idx) => {
                        var text = response.optn_text[idx];
                        var selected = response.optn_selects[idx];
                        var $newOption = $("<option " + selected + "></option>").val(item).text(text);
                        $("#" + where_id).append($newOption).trigger('change');
                    })
                }
            });
        }

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
                    response.optn_values && response.optn_values.map((item, idx) => {
                        var text = response.optn_text[idx];
                        var selected = response.optn_selects[idx];
                        var $newOption = $("<option " + selected + "></option>").val(item).text(text);
                        $("#" + where_id).append($newOption).trigger('change');
                    })
                }
            });
        }

        function get_projects(whose, whose_id, where_id) {
            $.ajax({
                type: "POST",
                url: COMPANY_URL + 'get-projects-with-selected',
                data: {
                    whose: whose,
                    id: whose_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#' + where_id).empty();
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
                    response.optn_values && response.optn_values.map((item, idx) => {
                        var text = response.optn_text[idx];
                        var selected = response.optn_selects[idx];
                        var $newOption = $("<option></option>").val(item).text(text);
                        $("#" + where_id).append($newOption).trigger('change');
                    })
                }
            });
        }

        function get_employees(whose, whose_id, type, where_id) {
            $.ajax({
                type: "POST",
                url: COMPANY_URL + 'get-employee-with-filters',
                data: {
                    whose: whose,
                    id: whose_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#" + where_id).empty();
                    response.optn_values && response.optn_values.map((item, idx) => {
                        var text = response.optn_text[idx];
                        var selected = response.optn_selects[idx];
                        var $newOption = $("<option " + selected + "></option>").val(item).text(text);
                        $("#" + where_id).append($newOption).trigger('change');
                    })
                }
            });
        }

    </script>
@endsection
