@extends('company.layouts.app-company')
@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css') }}">
@endsection
@section('content')

    <div class="page-content">
        <header>
            <div class="row">
                <div class="col-md-8">
                    <h1 class="mb-0" id="hedn">Projects</h1>
                </div>
                @if (Auth::user()->user_type == 'company')
                    <div class="col-md-4">
                        <div class="form-group text-right">
                            <button class="btn btn-primary" data-toggle="modal" onclick="return showNewModal(this)"><i
                                    class="fa fa-plus" aria-hidden="true"></i> Add New</button>


                        </div>
                    </div>
                @endif

            </div>
        </header>
        <div class="panel panel-light">


            <div class="form-group text-right mt20 mr20">
            </div>

            <!--<div class="container mw50 others">-->
            <!--  <div class="row">-->
            <!--    <div class="col-md-12" align="right">-->
            <!--        <div class="panel">-->
            <!--          <div>-->
            <!--              <ul class="nav nav-pills nav-fill">-->
            <!--                <li class="nav-item">-->
            <!--                  <button type="button" class="btn btn-wide btn-primary" data-toggle="modal" onclick="return showNewModal(this)">Add New</button>-->
            <!--                </li>-->
            <!--              </ul>-->
            <!--          </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->

            <div class="panel-body othertbl">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="search-table-outter wrapper">
                                    <table id="example" class="search-table inner table-row-hover">
                                        <thead>
                                            <tr>
                                                <th>S#</th>
                                                <th>Project ( English)</th>
                                                <th>Project ( Arabic)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="new-project-modal">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content mdc">
                <form method="POST" enctype="multipart/form-data" id="projectForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header mdh">
                        <h5 class="modal-title mdh2">Add New Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="30" height="30">
                                <path
                                    d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body mdb">
                        <div class="form-group">
                            <label for="">Project title</label>
                            <input type="text" id="project_en" name="project_en" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Project title (arabic)</label>
                            <input type="text" id="project_ar" name="project_ar" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="project_id" id="project_id" value="">
                        {{-- <button type="button" class="btn btn-light" data-dismiss="modal">No</button> --}}
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="confirm-modal">
        <div class="modal-dialog modal-dialog-centered modal-confirm confirm-danger">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="icon-box">
                        <i class="fa fa-times"></i>
                    </div>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Do you really want to delete this item? This process cannot be undone.</p>
                </div>







                <form method="POST" id="deleteForm">
                    <div class="row">
                        <div class="col-md-6 px-2 mt5">
                            <button type="button" class="btn my-1 btn-success btn-block close"
                                data-dismiss="modal">No</button>
                        </div>

                        <div class="col-md-6 px-2">
                            <button type="button" class="btn my-1 btn-danger btn-block"
                                onclick="deleteProject(this)">YES</button>
                        </div>


                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="delete_id" id="delete_id" value="">

                    </div>
                </form>















                <!--<div class="modal-footer row">-->
                <!--    <div class="col-md-6 px-2">-->
                <!--        <button type="button" class="btn my-1 btn-secondary btn-block close" data-dismiss="modal">No</button>-->
                <!--    </div>-->
                <!--    <form method="POST"  id="deleteForm">-->
                <!--      <input type="hidden" name="_token" value="{{ csrf_token() }}">-->
                <!--      <input type="hidden" name="delete_id" id="delete_id" value="">-->
                <!--    <div class="col-md-6 px-2">-->
                <!--        <button type="button" class="btn my-1 btn-danger btn-block" onclick="deleteProject(this)">YES</button>-->
                <!--    </div>-->
                <!--    </form>-->
                <!--</div>-->
            </div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script src="{{ asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('users/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            loadTable();
        });

        function loadTable() {
            $('#example').DataTable({

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
                    url: COMPANY_URL + 'get-company-projects',
                    data: function(d) {
                        //d.prop_status = $prop_status;
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
                        data: 'title_en',
                        name: 'title_en'
                    },
                    {
                        data: 'title_ar',
                        name: 'title_ar'
                    },
                    {
                        data: 'actions',
                        name: 'actions'
                    },
                ]
            });
        }

    </script>

    <script type="text/javascript">
        function showNewModal(thisObj) {
            $("#project_id").val("");
            $("#project_en").val("");
            $("#project_ar").val("");
            $('#new-project-modal').modal('show');
        }

        //edit
        function showEditModal(thisObj) {
            $("#project_id").val($(thisObj).attr('data-id'));
            $("#project_en").val($(thisObj).attr('data-en'));
            $("#project_ar").val($(thisObj).attr('data-ar'));
            $('#new-project-modal').modal().show();
        }

        $(function() {
            $("#saveBtn").on('click', function() {
                $("#projectForm").submit();
            });

            $('#new-project-modal').on('show.bs.modal', function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("#projectForm").validate({
                    groups: {},
                    rules: {
                        project_en: {
                            required: true
                        },
                    },
                    messages: {
                        project_en: {
                            required: "required field"
                        },
                    },

                    submitHandler: function(form) {
                        var formData = new FormData($("#projectForm")[0]);

                        $.ajax({
                            type: "POST",
                            url: COMPANY_URL + 'save-company-projects',
                            data: formData,
                            async: true,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.status == 'success') {
                                    $('#new-project-modal').modal().hide();
                                    $('body').removeClass('modal-open');
                                    $(".modal-backdrop").remove();
                                    table = $('#example').DataTable();
                                    $(".close").click();
                                    table.destroy();
                                    loadTable();
                                } else {

                                }
                            }
                        });
                        return false;
                        //e.preventDefault();
                    }
                });
            });

        });

        //delete
        function showConfirmModal(thisObj) {
            $("#delete_id").val($(thisObj).attr('data-id'));
            $('#confirm-modal').modal().show();
        }

        function deleteProject(thisObj) {
            project_id = $("#delete_id").val();
            $.ajax({
                type: "POST",
                url: COMPANY_URL + 'delete-company-projects',
                data: {
                    project_id: project_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $(".close").click();
                    table = $('#example').DataTable();
                    table.destroy();
                    loadTable();
                }
            });
        }

    </script>
@endsection
