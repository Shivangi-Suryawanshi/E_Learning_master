@extends('company.layouts.app-company')
@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('users/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('myadmin/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('users/layouts/css/trainingmatrix.css') }}">
    <style>
        .badgeDvorange {
            background: #ebccd1 !important;
            color: #000 !important;
        }

        .badgeDvAsg {
            background: #f1eaed !important;
            color: #000 !important;
        }

        .badgeDvNa {
            background: #eae9e9 !important;
            color: #000 !important;
        }

        .badgeDvyellow {
            background: rgb(235, 235, 9) !important;
            color: #000 !important;
        }


        .badgeDvgreen {
            background: #5cd65c !important;
            color: #000 !important;
        }


        .badgeDvorange {
            background: #ffad33 !important;
            color: #000 !important;
        }

        .badgeDvred {
            background: #c41f1f !important;
            color: #000 !important;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 1px 1px;
        }

        .search-table {
            table-layout: fixed;
        }

        .search-table,
        td,
        th {
            border-collapse: collapse;
            border: 1px solid #777 !important;
        }

        th {
            padding: 5px 0px 5px 5px !important;
            color: #fff !important;
            background: #343a40 !important;
            font-weight: 600 !important;
        }

        .search-table-outter {
            overflow-x: scroll;
        }

        .m-1 {

            padding: 10px !important;
            cursor: pointer;
        }

        .hide {
            display: none !important;
        }

        .custom-file.custom-image.custom-image-avatar .image-preview {
            height: 100px;
            overflow: visible;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.51);
            border-radius: 0% !important;
            /* background-color: #ebebeb; */
            background-image: url(../assets/images/placeholder-image.png);
        }

        .custom-file.custom-image.custom-image-avatar .upload-btn {
            top: 85px;
        }

        .custom-file.custom-image.custom-image-avatar button.btn-upload {
            width: auto !important;
            height: auto !important;
            padding: 0px;
            border-radius: 0 !important;
            font-size: 13px !important;
            padding-top: 0px !important;
            color: #fff !important;
            background: #a1a1a1;
            border-color: #fff;
        }

        .custom-file.custom-image.custom-image-avatar .image-preview .image-button button.close {
            bottom: -110px;
            width: 100px;
            border-radius: 0px;
            height: 40px;
            z-index: 99;
            padding: 0;
            border: 1px solid #dedddd;
            box-shadow: none;
            background-color: #fff;
        }

        .mt35 {
            margin-top: 35px !important;
        }

    </style>
@endsection
@section('content')
    <div class="page-content">
        <header>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="mb-0" id="hedn">Training Matrix</h1>
                </div>
            </div>
        </header>
        <div class="panel panel-light">
            <input type="text" value="{{$type}}" class="contactors" id="" hidden>
           
            @if($type== null)
            @include('company.training-menu')
            @endif
            <div class="container">
                <div class="col-md-3">
                    <label for="">Contactor</label>
                    <div class="form-group">
                        <select id="contactor" class="contactor" name="contractor" data-toggle="select2" data-search="true"
                            class="form-control" >
                           <option value="">Select Contractor</option>
                           @if($contactor)
                           @foreach ($contactor as $item)
                               <option @if($item->id == $type) selected @endif value="{{$item->id}}">{{ucwords($item->name)}}</option>
                           @endforeach
                           @endif
                        </select>
                    </div>
                </div>
                <div class="row mt20">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Department</label>
                            <select id="search_department" name="search_department" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                                <?php echo company_departments(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Position</label>
                            <select id="search_position" name="search_position" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                                <?php echo company_positions(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Project</label>
                            <select id="search_project" name="search_project" data-toggle="select2" data-search="true"
                                class="form-control" multiple>
                                <?php echo company_projects(); ?>
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
                <div>
                    <div class="row">
                        <div class="col-md-8 mb10" align="left">
                            <div class="btn-group">
                                {{-- <button type="button" class="btn btn-secondary "><i class="fa fa-file-pdf-o"
                                        aria-hidden="true"></i> PDF</button>
                                <button type="button" class="btn btn-secondary "><i class="fa fa-file-excel-o"
                                        aria-hidden="true"></i> Excel</button>
                                <button type="button" class="btn btn-secondary "><i class="fa fa-file"
                                        aria-hidden="true"></i> CSV</button> --}}
                                {{-- <a href="javascript:window.print()" role="button" class="btn btn-secondary"> <i class="fa fa-print"
                                        aria-hidden="true"></i> Print</a> --}}
                                        {{-- <a href="javascript:window.print()" class="fa fa-print"><i
                                            title="download" class="fa fa-print">Print</i></a> --}}
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="search-table-outter wrapper">
                                    <table id="example" class="search-table inner  table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="30px" rowspan="3" scope="col">No</th>
                                                <th width="180px" rowspan="3" scope="col">NAME</th>
                                                <th width="180px" rowspan="3" scope="col">EMPLOYEE NO</th>
                                                <th width="180px" rowspan="3" scope="col">DEPARTMENTS</th>
                                                <th width="180px" rowspan="3" scope="col">POSITIONS</th>
                                                <th width="180px" rowspan="3" scope="col">PROJECTS</th>
                                                @foreach ($courses as $course)
                                                    <th width="180px" scope="col" class="st"><span class="badge"
                                                            data-type="light" title="" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-original-title="Course">C</span>{{ $course->en_course_name }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($courses as $course)
                                                    <th width="180px" scope="col" class="st">
                                                        <span class="badge b2" data-type="light" title=""
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="Validity">V</span>
                                                        {{ $course->validity }}
                                                        Months
                                                    </th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <?php $coloumn_count = 1; ?>
                                                @foreach ($courses as $course)
                                                    <?php $coloumn_count++; ?>
                                                    <th width="180px" scope="col" class="st"><span class="badge b3"
                                                            data-type="light" title="" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-original-title="Provider">INT/EXT</span>
                                                        @if ($course->type == 1)
                                                            {{ 'Internal' }} @else{{ 'External' }} @endif
                                                    </th>
                                                @endforeach
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

    <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-md">
                <form method="POST" enctype="multipart/form-data" id="EditForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{-- <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="modalClose" data-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="24" height="24">
                                <path
                                    d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z" />
                            </svg>
                        </button>
                    </div> --}}
                    <div class="modal-body">
                        <div align="right">
                            <button type="button" class="modalClose" data-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="24"
                                    height="24">
                                    <path
                                        d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z" />
                                </svg>
                            </button>
                        </div>
                        <ul class="nav nav-tabs" id="default-tabs-list" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link tab1 active" id="default-tab-1" data-toggle="tab"
                                    href="#default-tab-content-1" role="tab" aria-controls="default-tab-content-1"
                                    aria-selected="true">Assign Course</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab2" id="default-tab-2" data-toggle="tab" href="#default-tab-content-2"
                                    role="tab" aria-controls="default-tab-content-2" aria-selected="false">Upload Certificate</a>
                            </li>
                        </ul>

                        <div class="tab-content p-4 border border-top-0" id="default-tabs-content">
                            <div class="tab-pane show active" id="default-tab-content-1" role="tabpanel"
                                aria-labelledby="default-tab-1">
                                {{-- <h2 style="color: black;">Details</h2> --}}

                                <div class="form-group">
                                    <label for="">Department</label>
                                    <input type="text" id="department" name="department" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="">Position</label>
                                    <input type="text" id="position" name="position" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="">Course</label>
                                    <input type="text" id="course_name" name="course_name" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" id="workforce_name" name="workforce_name" class="form-control"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label for="">Assign Upcomming Course Date</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control"
                                        placeholder="upcomming course" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="tab-pane " id="default-tab-content-2" role="tabpanel" aria-labelledby="default-tab">
                                <br>
                                {{-- <h2 style="color: black;">Certificate</h2> --}}
                                <div class="form-group">
                                    <label for="">Issue Date</label>
                                    <input type="text" id="issue_date" name="issue_date" class="form-control"
                                        placeholder="Select Issue Date" value="" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="">Expiry Date</label>
                                    <input type="text" id="expiry_date" name="expiry_date" class="form-control expiry_date">
                                </div>
                                <div class="form-group uploadCls certificate-upload">
                                    <div class="custom-file custom-image custom-image-avatar">
                                        <label class="custom-image-label " for="customImage">+Upload certificate</label>
                                        <input type="file" name="certificate" id="certificate" data-placeholder=""
                                            class="custom-image-input" id="customImage">

                                    </div>
                                </div>
                                <div class="form-group aproveCls mt35">
                                    <label for="">Approve Certificate</label>
                                    <input type="checkbox" id="approve" name="approve">
                                </div>
                                {{-- <div class="form-group aproveStatusCls">
                        <label for="">Approved </label>
                     </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="course_id" id="course_id" value="">
                        <input type="hidden" name="course_type" id="course_type" value="">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input type="hidden" name="validity" id="validity" value="">
                        <input type="hidden" name="endDate" id="endDate" value="">
                        <input type="hidden" name="index_id" id="index_id" value="">
                        <input type="hidden" name="removeImg" id="removeImg" value="">
                        {{-- <button type="button" class="btn btn-light" data-dismiss="modal">No</button> --}}
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script src="{{ asset('users/js/pages/form/extended/select2.js') }}"></script>
    <script src="{{ asset('users/vendor/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('users/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
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
            var colCount = <?php echo $coloumn_count; ?> ; //if(colCount!=""){
            loadTable();
            //}
        });
        $('.contactor').on('change', function()
        {
            var contactor = $('.contactor').val();  
            // alert(contactor);
            window.location.href = COMPANY_URL + "training-matrix?contactor="+contactor
            // table = $('#example').DataTable();
            // table.destroy();
            // loadTable();

        })
        $('#searchBtn').click(function() {
            table = $('#example').DataTable();
            table.destroy();
            //$(".thead-dark").empty();
            //getTableHead();
            loadTable();
        });




        function loadTable() {
            var $department = $("#search_department").val();
            var $position = $("#search_position").val();
            var $project = $("#search_project").val();

            var arr = [{
                    data: 's#',
                    name: 's#'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'work_id',
                    name: 'work_id'
                },
                {
                    data: 'department',
                    name: 'department'
                },
                {
                    data: 'position',
                    name: 'position'
                },
                {
                    data: 'project',
                    name: 'project'
                },


            ];

         var colCount = <?php echo $coloumn_count ; ?>;

         for (let colindex = 1; colindex < colCount; colindex++) {
            arr.push({data: 'nullcol_'+colindex, name: 'nullcol_'+colindex});
         }

         $('#example').DataTable({
            dom: 'Bfrtip',
                buttons: [
                    'excel',
                    'csv',
                    'pdf'
                ],
           "fnDrawCallback": function(oSettings) {
             if (oSettings.bSorted || oSettings.bFiltered || oSettings._iDisplayLength){
               j = 0;
               for (var i = oSettings._iDisplayStart; i < oSettings.aiDisplay.length + oSettings._iDisplayStart; i++){
                 $('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[j] ].nTr).find('span').text(i + 1);
                       j++;
               }
             }
           },

           processing: true,
           serverSide: true,
           "pageLength": 50,
           ajax: {
                 url: COMPANY_URL+'get-training-matrix-data',
                 data: function (d) {
                   d.department = $department;
                   d.position   = $position;
                   d.project    = $project;
                   d.type = $('.contactors').val();
                   d.contactor = $('.contactor').val();
                 },
           },
           "columnDefs": [{ 'orderable': false, 'targets': [0,1] }],
           mark: true,
           fixedColumns: {
           },
           columns: arr

         });
     }
//      $.fn.dataTableExt.sErrMode = 'throw';

//      $('#example').on('error.dt', function (e, settings, techNote, message) {
//     // console.log( 'An error has been reported by DataTables: ', message );
//    //  alert('hai');
//     swal("Hey!", "Please Wait ! We are loading your datas!", "info")
//         .then(function (willDelete) {
//             if (willDelete) {
//                 location.reload();
//             }
//         });
// });
     function showEditModal(thisObj){
        // console.log(thisObj);
      // console.log($(thisObj).attr('data-certificate'));
      $("#index_id").val($(thisObj).attr('data-id'));
      $("#course_id").val($(thisObj).attr('data-course-id'));
      $("#course_name").val($(thisObj).attr('data-course'));
      $("#validity").val($(thisObj).attr('data-validity'));
      $("#department").val($(thisObj).attr('data-department'));
      $("#position").val($(thisObj).attr('data-position'));
      //$("#project").val($(thisObj).attr('data-position'));
      $("#workforce_name").val($(thisObj).attr('data-user'));
      $("#user_id").val($(thisObj).attr('data-user-id'));
      $("#issue_date").val($(thisObj).attr('data-issue-date'));
      $("#expiry_date").val($(thisObj).attr('data-expiry-date'));
      $("#start_date").val($(thisObj).attr('data-start-date'));
      $("#course_type").val($(thisObj).attr('data-course-type'));
      $course_type = $(thisObj).attr('data-course-type');
    //   $id = $(thisObj).attr('');
      $certificate = $(thisObj).attr('data-certificate');
      $certificate_status = $(thisObj).attr('data-certificate-status');
      $upload_status = $(thisObj).attr('data-upload-status');
      if($course_type==2){
         // alert ('hi');
         $upload_status = $(thisObj).attr('data-upload-status');
         if($upload_status==0){
               $(".tab2").addClass('disabled');
         }else{
               $(".tab2").removeClass('disabled');
               $("#issue_date").attr('disabled','disabled');
               $("#expiry_date").attr('disabled','disabled');
               $("#certificate").attr('disabled','disabled');
               //$(".uploadCls").addClass('hide');
               $(".aproveCls").removeClass('hide');
               if($certificate_status==1){
                  $("#approve").prop("checked", true);
               }else{
                  $("#approve").prop("checked", false );
               }
         }
      }else{
         $(".tab2").removeClass('disabled');
         $(".uploadCls").removeClass('hide');
         $(".aproveCls").addClass('hide');
         $(".aproveStatusCls").addClass('hide');
      }

      $(".tab1").addClass('active');
      $("#default-tab-content-1").addClass('active');
      $(".tab2").removeClass('active');
      $(".tab2").removeClass('disabled');
      $("#default-tab-content-2").removeClass('active');
      // console.log($certificate);
      imageUrl ="";
      if($upload_status==1 && $certificate_status!=0){
         //set placeholder image
      //  alert('hai');
         if($certificate  != "")
         {
            // console.log($certificate);
         imageUrl = ROOT_URL+"/uploads/certificates/"+$certificate;
         $("#certificate").attr('data-placeholder',imageUrl);
         $(".image-preview").attr('data-placeholder',imageUrl);
         $(".image-preview").css("background-image", "url(" + imageUrl + ")");
         }
         
// alert('hlo');
         if($course_type==1){
            $(".close").css("display", "block");
         }else{
            $("#certificate").attr('disabled','disabled');
            $(".custom-image-label").addClass('hide');
            $(".btn-upload").addClass('hide');
         }
      }
    
            // imageUrl = ROOT_URL+"/uploads/certificates/"+$certificate;
      
         
      $("#removeImg").val("");
      $('#edit-modal').modal().show();
    }

    function showNewModal(thisObj){
      //  alert('jkk');
       imageUrl="";
       $("#certificate").attr('data-placeholder',imageUrl);
         $(".image-preview").attr('data-placeholder',imageUrl);
         $(".image-preview").css("background-image", "url(" + imageUrl + ")");
      // $('.image-preview').hide();

      $("#index_id").val("");
      $("#course_id").val($(thisObj).attr('data-course-id'));
      $("#course_name").val($(thisObj).attr('data-course'));
      $("#validity").val($(thisObj).attr('data-validity'));
      $("#department").val($(thisObj).attr('data-department'));
      $("#position").val($(thisObj).attr('data-position'));
      $("#workforce_name").val($(thisObj).attr('data-user'));
      $("#user_id").val($(thisObj).attr('data-user-id'));
      $("#course_type").val($(thisObj).attr('data-course-type'));
      $("#start_date").val("");
      $("#issue_date").val("");
      $("#expiry_date").val("");
      $course_type = $(thisObj).attr('data-course-type');
      $certificate = $(thisObj).attr('data-certificate');
      $certificate_status = $(thisObj).attr('data-certificate-status');
      if($course_type==2 ){
         // alert('ha');
         $upload_status = $(thisObj).attr('data-upload-status');
         if($upload_status==0){
         // alert('ha');
            
              // $(".tab2").addClass('disabled');
         }else{
         // alert('dha');

               $(".tab2").removeClass('disabled');
               $("#issue_date").attr('disabled','disabled');
               $("#expiry_date").attr('disabled','disabled');
               $("#certificate").attr('disabled','disabled');
               $(".uploadCls").addClass('hide');
               $(".aproveCls").removeClass('hide');
               if($certificate_status==0){
                  $("#approve").prop("checked", false);
               }else{
                  $("#approve").prop("checked", true);
               }
         }
      }else{
         // alert('haqq');

         $(".tab2").removeClass('disabled');
         $(".uploadCls").removeClass('hide');
         $(".aproveCls").addClass('hide');
         $(".aproveStatusCls").addClass('hide');
      }
      $(".tab1").addClass('active');
      $("#default-tab-content-1").addClass('active');
      $(".tab2").removeClass('active');
      $("#default-tab-content-2").removeClass('active');
      $("#removeImg").val("");
      $('#edit-modal').modal().show();
   }

   $(function () {
     $("#saveBtn").on('click',function(){
         $("#EditForm").submit();
     });

     $('#edit-modal').on('show.bs.modal', function () {

         $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });

         $("#EditForm").validate({
             groups: {
             },
             rules: {
               issue_date: {
                 required: true
               },
            //    start_date: {
            //      required: true
            //    },

             },
             messages: {
               issue_date: {
                 required: "Please enter issue date"
               },
            //    start_date: {
            //       start_date: "Please enter start date"
            //    },

             },

             submitHandler: function (form) {
               var formData = new FormData($("#EditForm")[0]);

               $.ajax({
                   type: "POST",
                   url: COMPANY_URL+'assign-required-course',
                   data:formData,
                   async: true,
                   cache: false,
                   contentType: false,
                   processData: false,
                   success: function(response){
                       if(response.status == 'success'){ 
                         $(".custom-image-input").val("");

                         table = $('#example').DataTable();
                         table.destroy();
                         loadTable();
                         $(".modalClose").click();
                        //  window.location.reload();
                       }else{

                       }
                   }
               });
               return false;
               //e.preventDefault();
             }
         });
     });

   });
   $(".modalClose").on('click', function()
   {
     
   })
   $(".close").on('click',function(){
      $("#removeImg").val(1);
      $(".close").css("display", "none");
   });

</script>
<script src="{{asset('myadmin/datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
   $(function() {
      $('#issue_date').datepicker({
         'todayHighlight': true,
         dateFormat: 'yy-mm-dd' ,
         clearBtn: true,
         autoclose: true,
      }).on('changeDate', function () {
         var validity = $("#validity").val();
         validity = parseInt(validity);
         var d = new Date($(this).val());
         d.setMonth(d.getMonth() + validity);
         d.setDate(d.getDate() - 1);
         var d = new Date(d);
         b = getFormattedString(d);
         $('#expiry_date').datepicker('setDate', d);
         //$('#expiry_date').attr("disabled", true);
         $('#endDate').val(b);
      });
   });

   function getFormattedString(d){
      return d.getFullYear() + "-"+(d.getMonth()+1) +"-"+d.getDate();
   }

   $(function() {
      $('#start_date').datepicker({
         'todayHighlight': true,
         dateFormat: 'yy-mm-dd' ,
         clearBtn: true,
         autoclose: true,
      });
   });
</script>
<script>
    $('.image-preview').on('click', function()
    {
       var image = $(this).data('placeholder');
       window.open(image);

    //    alert(image);
    //    window.open(image);
       window.location.reload()

    })
</script>
@endsection
