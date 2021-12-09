@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')

<div class="page-content">
  <header>
     <div class="row">
        <div class="col-md-6">
           <h1 class="mb-0" id="hedn">ASSIGN REQUIRED COURSES</h1>
        </div>
     </div>
  </header>
  <div class="panel panel-light">
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
                               <th>Position Title ( English)</th>
                               <th>Position Title ( Arabic)</th>
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
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content mdc">
        <form method="POST"  enctype="multipart/form-data" id="positionForm">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="modal-header mdh">
              <h4 class="modal-title mdh2">Add New Position</h4>
             
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 24 24" width="30" height="30"><path d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/></svg>
              </button>
             
          </div>
          <div class="modal-body mdb">
               
            <div class="form-group">
              <label for="">Position title</label>
              <input type="text" id="position_en" name="position_en" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Position title (arabic)</label>
              <input type="text" id="position_ar" name="position_ar" class="form-control">
            </div>
            
            <div align="right">
            <input type="hidden" name="position_id" id="position_id" value="">
              {{-- <button type="button" class="btn btn-light" data-dismiss="modal">No</button> --}}
              <button type="submit" class="btn btn-primary">Save</button>
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
              <div class="col-md-6 px-2 mt5">
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
<script type="text/javascript">
  $(document).ready( function () {
    loadTable();
  });
    
      function loadTable(){
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
                url: COMPANY_URL+'get-company-positions',
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
              {data: 'title_en', name: 'title_en'},
              {data: 'title_ar', name: 'title_ar'},
              {data: 'actions', name: 'actions'},
            ]
          });
    }
    </script>
    
  <script type="text/javascript">

    function showNewModal(thisObj){
      alert(789);
      $('#new-position-modal').modal('show');

      $("#position_id").val("");
      $("#position_en").val("");
      $("#position_ar").val("");
    }

    //edit 
    function showEditModal(thisObj){
      $("#position_id").val($(thisObj).attr('data-id'));
      $("#position_en").val($(thisObj).attr('data-en'));
      $("#position_ar").val($(thisObj).attr('data-ar'));
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
                position_en: {
                  required: true
                },
              },
              messages: {
                position_en: {
                  required: "required field"
                },
              },
  
              submitHandler: function (form) {
                var formData = new FormData($("#positionForm")[0]);
  
                $.ajax({
                    type: "POST",
                    url: COMPANY_URL+'save-company-positions',
                    data:formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response.status == 'success'){
                          $(".close").click();
                          table = $('#example').DataTable();
                          table.destroy();
                          loadTable();
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
    position_id = $("#delete_id").val();
    $.ajax({
                type: "POST",
                url: COMPANY_URL+'delete-company-positions',
                data:{position_id:position_id, _token: '{{csrf_token()}}'},
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
@endsection

                    