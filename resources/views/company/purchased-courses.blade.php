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
            <h1 class="mb-0" id="hedn">Purchased Courses</h1>
         </div>
      </div>
   </header>
   <div class="panel panel-light">
      {{-- <div class="container">
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
                    <?php  echo company_projects(); ?>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
              <label for="">&nbsp;</label>
               <div class="form-group ">
                  <button type="button" class="m-1 btn btn-dark" id="searchBtn"><i class="fa fa-search" aria-hidden="true"></i> Find</button>
               </div>
            </div>
         </div>
      </div> --}}
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
                                 <th>External Course</th>
                                 <th>Purchased Course</th>
                                 <th>Purchase Date</th>
                                 <th>Spent Amount</th>
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
               <h5 class="modal-title mdh2">Details</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 24 24" width="30" height="30">
                     <path d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                  </svg>
               </button>
            </div>
            <div class="modal-body mdb">
            </div>
            <div class="modal-footer">
               <input type="hidden" name="course_id" id="course_id" value="">
               <button type="submit" class="btn btn-success">Save</button>
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
                 url: COMPANY_URL+'get-purchased-courses',
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
               {data: 'external_course', name: 'external_course'},
               {data: 'purchased_course', name: 'purchased_course'},
               {data: 'purchase_date', name: 'purchase_date'},
               {data: 'spent_amount', name: 'spent_amount'},
               {data: 'actions', name: 'actions'}
               ]
           });
     }
     
</script>
<script type="text/javascript">
   //edit 
   function showEditModal(thisObj){
    console.log(thisObj);
     var course_id  = $(thisObj).attr('data-id');
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
     $('#new-position-modal').modal().show();
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

</script>
@endsection