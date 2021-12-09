@extends('company.layouts.app-company')
@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css') }}">
@endsection
@section('content')
    <div class="page-content">
        <header>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mb-0">Progress Report</h1>
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
                                            <h6><i class="fa fa-cube" aria-hidden="true"></i> Training Matrix</h6>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-primary has-arrow active" href="javascript:void(0);">
                                            <h6><i class="fa fa-bullhorn" aria-hidden="true"></i> Progress</h6>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-primary has-arrow"
                                            href="{{ route('upcoming-courses') }}" title="Upcoming Courses">
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
                                <th>NO</th>
                                <th>Name</th>
                                <th>Total Courses</th>
                                <th>Assigned Courses</th>
                                <th>Expired Courses</th>
                                <th>Closed To Expired</th>
                                <th>Completion %</th>
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
        });

        function loadTable() {
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
                "pageLength": 50,
                ajax: {
                    url: COMPANY_URL + 'get-progress-report-data',
                    data: function(d) {
                        //d.language = $language;
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
                        data: 'department_course',
                        name: 'department_course'
                    },
                    {
                        data: 'assigned_course',
                        name: 'assigned_course'
                    },
                    {
                        data: 'expired_course',
                        name: 'expired_course'
                    },
                    {
                        data: 'close_to_expire',
                        name: 'close_to_expire'
                    },
                  
                    {
                        data: 'completion_percentage',
                        name: 'completion_percentage'
                    }
                ]
            });
        }

    </script>

@endsection
