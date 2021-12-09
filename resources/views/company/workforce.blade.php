@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('users/vendor/select2/select2.min.css')}}">
<style>
  .select2-container {width:100% !Important;}
  .select2-container--default .select2-selection--multiple {
   border: solid #e2e5ec 1px !important;}


   .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 35px !important;
    user-select: none;
    -webkit-user-select: none;
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #e2e5ec !important;
    border-radius: 4px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #a59e9e !important;
    line-height: 22px !important;
}



.modal-confirm .close {
    position: unset !important;
    top: 0px;
    right: 0px;
}


</style>
@endsection
@section('content')
<div class="page-content">
   <header>
      <div class="row">
         <div class="col-md-6">
            <h1 class="mb-0" id="hedn">Workforces</h1>
         </div>

         <div class="col-md-6">
            
        
         <div class="form-group text-right mr20">
            <a  class="btn btn-primary" href="{{url('company/request-individual-user')}}"><i  aria-hidden="true"></i> Request Individual User</a>

         <button class="btn btn-primary" data-toggle="modal" onclick="return showNewModal(this)"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
      </div>
      </div>





      </div>
   </header>


   <div class="panel panel-light">

      <div class="panel-body othertbl">
            <div class="row">
               <div class="col-md-12">
                  <div class="table-responsive">
                     <div class="search-table-outter wrapper">
                        <table id="example" class="search-table inner table-row-hover" style="text-align: center">
                           <thead>
                              <tr>
                                 <th width="10px">No</th>
                                 <th>Name</th>
                                 <th>Added By</th>
                                 <th width="50px">Employee No</th>
                                 <th width="150px">Email</th>
                                 <th>Department</th>
                                 <th>Position</th>
                                 <th>Project</th>
                                 <th width="50px">Actions</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="new-data-modal">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content mdc">
         <form method="POST"  enctype="multipart/form-data" id="dataForm">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="modal-header mdh">
               <h4 class="modal-title mdh2">Workforce</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="30" height="30">
                     <path d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                  </svg>
               </button>
            </div>
            <div class="modal-body mdb">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" id="fname" name="fname" class="form-control">
                     </div>
                  </div>
                  {{-- <div class="col-md-4">
                     <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" id="lname" name="lname" class="form-control">
                     </div>
                  </div> --}}
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Work Id</label>
                        <input type="text" id="work_id" name="work_id" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" id="email" name="email" class="form-control">
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" id="password" name="password" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label for="">Department</label>
                     <select id="department" name="department[]" data-toggle="select2" data-search="true" class="form-control form-control-lg" >
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label for="">Position</label>
                     <select id="position" name="position[]" data-toggle="select2" data-search="true" class="form-control form-control-lg" >
                     </select>
                  </div>
                  <div class="col-md-6 mt20">
                     <label for="">Project</label>
                     <select id="project" name="project[]" data-toggle="select2" data-search="true" class="form-control form-control-lg" >
                     </select>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
              <div class="row">
              <div class="col-md-12 px-2">
                <input type="hidden" name="user_id" id="user_id" value="">

                <button type="submit" class="btn btn-primary">Save</button>
              </div>
              </div>
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
                  <button type="button" class="btn my-1 btn-danger btn-block" onclick="deletePosition(this)">YES</button>
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
<script src="{{asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('users/vendor/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('users/vendor/select2/select2.full.min.js')}}"></script>
<script src="{{asset('users/js/pages/form/extended/select2.js')}}"></script>

<script type="text/javascript">
   $(document).ready( function () {
     loadTable();
   });

       function loadTable(){
         $('#example').DataTable({
            // dom: 'Bfrtip',
         
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
                 url: COMPANY_URL+'get-workforce-data',
                 data: function (d) {
                   //d.prop_status = $prop_status;
                 }
           },
           "columnDefs": [{ 'orderable': false, 'targets': [0,1] }],
           mark: true,
           fixedColumns: {
           },
           columns: [
                {data: 's#', name: 's#'},
                {data: 'fname', name: 'fname'},
                {data: 'added_by', name: 'added_by'},
                {data: 'work_id', name: 'work_id'},
                {data: 'email', name: 'email'},
                {data: 'department', name: 'department'},
                {data: 'position', name: 'position'},
                {data: 'project', name: 'project'},
                {data: 'actions', name: 'actions'},

             ],
        
           });
           
     }

</script>
<script type="text/javascript">
   function showNewModal(thisObj){
     $(".modal-title").html("Add new workforce");
     $("#user_id").val("");
     $("#fname").val("");
   //  $("#lname").val("");
     $("#email").val("");
     $("#work_id").val("");

     $('#department').val("");
     get_departments('all','','department');

     $("#project").val("");
     get_projects('all','','project');

     $('#position').val("");
     get_positions('all','','position');
     $('#new-data-modal').modal('show');
   }

   //edit
   function showEditModal(thisObj){
     $(".modal-title").html("Edit workforce");
     var user_id  = $(thisObj).attr('data-id');
     $("#user_id").val(user_id);
     $("#fname").val($(thisObj).attr('data-fname'));
   //  $("#lname").val($(thisObj).attr('data-lname'));
     $("#email").val($(thisObj).attr('data-email'));
     $("#work_id").val($(thisObj).attr('data-work-id'));
     $("#password").val($(thisObj).attr('data-password'));

     $('#position').empty();
     get_positions('user',user_id,'position');

     $('#department').empty();
     get_departments('user',user_id,'department');

     $("#project").empty();
     get_projects('user',user_id,'project');

     $('#new-data-modal').modal().show();
   }

   $(function () {
     $("#saveBtn").on('click',function(){
         $("#dataForm").submit();
     });

     $('#new-data-modal').on('show.bs.modal', function () {

         $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });

         $("#dataForm").validate({
             groups: {
             },
             rules: {
              fname: {
                 required: true
               },
               email: {
                 required: true,
                 email:true,
                 remote: {
                        url: '{{url('company/user/checkemail')}}',
                        type: "post",
                        cache: false,
                        data: {
                            email: function () {
                                return $('#dataForm :input[name="email"]').val();
                            },
                            id: function () {
                                return $('#dataForm :input[name="user_id"]').val();
                            },
                            _token:"{{ csrf_token() }}"
                        }
                    }
               },
               password: {
                 required: true
               },
               position: {
                 required: true
               },
               department: {
                 required: true
               },
               project: {
                 required: true
               },

             },
             messages: {
              fname: {
                 required: "Please Enter Name"
               },
               email: {
                 required: "Please Enter Email",
                 email:"Please Enter Valid Email",
                 remote: jQuery.validator.format("Email address already in use")
               },
               // password: {
               //   required: "Please Enter Password"
               // },
               position: {
                 required: "Please Select Position"
               },
               department: {
                 required: "Please Enter Department"
               },
               project: {
                 required: "Please Enter Project"
               },

             },

             submitHandler: function (form) {
               var formData = new FormData($("#dataForm")[0]);

               $.ajax({
                   type: "POST",
                   url: COMPANY_URL+'add-workforce',
                   data:formData,
                   async: true,
                   cache: false,
                   contentType: false,
                   processData: false,
                   success: function(response){
                       if(response.status == 'success' || response.status == 'false'){
                         $(".close").click();
                         table = $('#example').DataTable();
                         table.destroy();
                         loadTable();
                         if(response.status == 'false')
                         {
                         toastr.error(response.message, 'Error', toastr_options);

                         }
                         else
                         {
                           toastr.success(response.message, 'Success', toastr_options);

                         }
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

   function deletePosition(thisObj){
      userId = $("#delete_id").val();
        $.ajax({
               type: "POST",
               url: COMPANY_URL+'delete-company-positions',
               data:{userId:userId, _token: '{{csrf_token()}}'},
               success: function(data){
                   $(".close").click();
                   table = $('#example').DataTable();
                   table.destroy();
                   loadTable();
               }
        });
   }

   function closeThis(){
   $(".close").click();
   }
</script>

<script type="text/javascript">
  $(document).ready( function () {
       get_departments('all','','department');
       get_positions('all','','position');
       get_projects('all','','project');
  });

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
