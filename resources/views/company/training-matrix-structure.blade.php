@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css')}}">
<style>
  .select2-container {width:100% !Important;}
  .select2-container--default .select2-selection--multiple {
 border: solid #e2e5ec 1px !important;}
</style>
@endsection
@section('content')
<div class="page-content">
   <header>
      <div class="row">
         <div class="col-md-6">
            <h1 class="mb-0" id="hedn">Training Matrix Structure</h1>
         </div>
         <div class="col-md-6">
          <div class="form-group text-right">
             <button class="btn btn-primary" data-toggle="modal" onclick="return showNewModal(this)"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
          </div>
         </div>
      </div>
   </header>
   <div class="panel panel-light">
      <div class="container">
         <div class="row mt20">
            <div class="col-md-3">
               <div class="form-group">
                  <label for="">Department</label>
                  <select id="search_department" name="search_department" data-toggle="select2" data-search="true" class="form-control" multiple>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                  <label for="">Position</label>
                  <select id="search_position" name="search_position" data-toggle="select2" data-search="true" class="form-control" multiple>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                  <label for="">Project</label>
                  <select id="search_project" name="search_project" data-toggle="select2" data-search="true" class="form-control" multiple>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
              <label for=""></label>
               <div class="form-group ">
                  <button type="button" class="m-1 btn btn-dark" id="searchBtn"><i class="fa fa-search" aria-hidden="true"></i> Find</button>
               </div>
            </div>
         </div>
      </div>
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
                                 <th>Course</th>
                                 <th>Validity</th>
                                 <th>Type</th>
                                 <th>Departments</th>
                                 <th>Positions</th>
                                 <th>Projects</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="new-position-modal">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content mdc">
         <form method="POST"  enctype="multipart/form-data" id="positionForm">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="modal-header mdh">
               <h5 class="modal-title mdh2">Add New Entry</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="30" height="30">
                     <path d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                  </svg>
               </button>
            </div>
            <div class="modal-body mdb">
               <div class="form-group">
                  <label for="">Course name (English)</label>
                  <input type="text" id="en_course_name" name="en_course_name" class="form-control">
               </div>
               <div class="form-group">
                  <label for="">Course name (Arabic)</label>
                  <input type="text" id="ar_course_name" name="ar_course_name" class="form-control">
               </div>
               <div class="form-group">
                  <label for="">Validity</label>
                  <select id="validity" name="validity" class="form-control">
                     <option value="0">No Validity</option>
                     @for($i=1;$i<=24;$i++)
                     <option value="{{$i}}">{{$i}} months</option>
                     @endfor
                  </select>
               </div>
               <div class="form-group">
                  <label for="">Course Type</label>
                  <select id="course_type" name="course_type" class="form-control">
                     <option value="">-Select-</option>
                     <option value="1">Internal</option>
                     <option value="2">External</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="">Department</label>
                  <select id="department" name="department[]" data-toggle="select2" data-search="true" class="form-control department" multiple>
                  </select>
               </div>
               <div class="form-group">
                  <label for="">Position</label>
                  <select id="position" name="position[]" data-toggle="select2" data-search="true" class="form-control department" multiple>
                  </select>
               </div>
               <div class="form-group">
                  <label for="">Project</label>
                  <select id="project" name="project[]" data-toggle="select2" data-search="true" class="form-control department" multiple>
                     <?php  echo company_projects(); ?>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" name="course_id" id="course_id" value="">
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
            <div class="icon-box mpnt" onclick="closeThis()">
               <i class="fa fa-times"></i>
            </div>
            <h4 class="modal-title">Are you sure?</h4>
         </div>
         <div class="modal-body">
            <p class="text-center">Do you really want to delete this item? This process cannot be undone.</p>
         </div>
         <form method="POST"  id="deleteForm">
            <div class="row">
               <div class="col-md-6 px-2">
                  <button type="button" class="btn my-1 btn-success btn-block close" data-dismiss="modal">No</button>
               </div>
               <div class="col-md-6 px-2">
                  <button type="button" class="btn my-1 btn-danger btn-block" onclick="deleteItem(this)">YES</button>
               </div>
               <input type="hidden" name="_token" value="{{csrf_token()}}">
               <input type="hidden" name="delete_id" id="delete_id" value="">
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('additional_scripts')
<script src="{{asset('users/js/pages/form/extended/select2.js')}}"></script>
<script src="{{asset('users/vendor/select2/select2.full.min.js')}}"></script>
<script src="{{asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('users/vendor/jquery-validate/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready( function () {
     loadTable();
     get_positions('all','','search_position');
     get_departments('all','','search_department');
     get_projects('all','','search_project');

   });

  $('#searchBtn').click(function(){
    table = $('#example').DataTable();
    table.destroy();
    loadTable();
  });

   function loadTable(){

        var $department = $("#search_department").val();
        var $position   = $("#search_position").val();
        var $project    = $("#search_project").val();

         $('#example').DataTable({

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
           "pageLength": 10,
           ajax: {
                 url: COMPANY_URL+'get-training-matrix-structure',
                 data: function (d) {
                   d.department = $department;
                   d.position   = $position;
                   d.project    = $project;
                 }
           },
           "columnDefs": [{ 'orderable': false, 'targets': [0,1] }],
           mark: true,
           fixedColumns: {
           },
           columns: [
               {data: 's#', name: 's#'},
               {data: 'course_name', name: 'course_name'},
               {data: 'validity', name: 'validity'},
               {data: 'type', name: 'type'},
               {data: 'department', name: 'department'},
               {data: 'position', name: 'position'},
               {data: 'project', name: 'project'},
               {data: 'actions', name: 'actions'}

             ]
           });
     }

</script>
<script type="text/javascript">
   function showNewModal(thisObj){
     $("#en_course_name").val("");
     $("#ar_course_name").val("");
     $("#validity").val("");
     $("#course_type").val("");

     $('#department').empty();
     get_departments('all','','department');

     $("#project").val("");
     get_projects('all','','project');

     $('#position').empty();
     get_positions('all','','position');
     $('#new-position-modal').modal('show');
   }

   //edit
   function showEditModal(thisObj){
      var course_id  = $(thisObj).attr('data-id');
      // alert(course_id);
     $("#course_id").val(course_id);
     $("#en_course_name").val($(thisObj).attr('data-en-course'));
     $("#ar_course_name").val($(thisObj).attr('data-ar-course'));
     $("#course_type").val($(thisObj).attr('data-course-type'));
     $("#validity").val($(thisObj).attr('data-validity'));

     $('#position').empty();
     get_positions('course',course_id,'position');

     $('#department').empty();
     get_departments('course',course_id,'department');

     $("#project").val($(thisObj).attr('data-project'));
     get_projects('course',course_id,'project');

     $('#new-position-modal').modal().show();
   }

   $(function () {
     $("#saveBtn").on('click',function(){
         $("#positionForm").submit();
     });

     $('#new-position-modal').on('show.bs.modal', function () {

         $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });

         $("#positionForm").validate({
             groups: {
             },
             rules: {
               en_course_name: {
                 required: true
               },
               course_type: {
                 required: true
               },
               department: {
                 required: true
               },
               position: {
                 required: true
               },
               project: {
                 required: true
               },

             },
             messages: {
               en_course_name: {
                 required: "Please enter course name"
               },
               course_type: {
                 required: "Please enter course type"
               },
               department: {
                 required: "Please select department"
               },
               position: {
                 required: "Please select position"
               },
               project: {
                 required: "Please select project"
               },

             },

             submitHandler: function (form) {
               var formData = new FormData($("#positionForm")[0]);

               $.ajax({
                   type: "POST",
                   url: COMPANY_URL+'save-training-matrix-structure',
                   data:formData,
                   async: true,
                   cache: false,
                   contentType: false,
                   processData: false,
                   success: function(response){
                       if(response.status == 'success'){
                         table = $('#example').DataTable();
                         table.destroy();
                         loadTable();
                         $(".close").click();
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

   //delete
   function showConfirmModal(thisObj){
     $("#delete_id").val($(thisObj).attr('data-id'));
     $('#confirm-modal').modal().show();
   }

   function deleteItem(thisObj){
       course_id = $("#delete_id").val();
       $.ajax({
               type: "POST",
               url: COMPANY_URL+'delete-training-matrix-structure',
               data:{course_id:course_id, _token: '{{csrf_token()}}'},
               success: function(data){
                  $(".close").click();
                  table = $('#example').DataTable();
                  table.destroy();
                  loadTable();
               }
       });
   }

   function get_positions(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-positions-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

   function get_departments(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-departments-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

   function get_projects(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-projects-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

</script>
@endsection
