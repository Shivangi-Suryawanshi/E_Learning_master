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
         <div class="col-md-8">
            <h1 class="mb-0" id="hedn">Project Manager Bidding Request</h1>
         </div>

         <div class="col-md-4">
         <div class="form-group text-right mr20">
            <a class="btn btn-primary" href="{{ url('company/search-courses')}}"><i class="fa fa-plus" aria-hidden="true"></i> Request to bidding</a>
         </div>
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
                                 <th>Course</th>
                                 {{-- <th>Total Employee</th> --}}
                                 <th>Details</th>
                                 <th>Instructor</th>
                                 <th>Status</th>

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
                 url: COMPANY_URL+'get-bidding-list-detail',
                 data: function (d) {

                 }
           },
           "columnDefs": [{ 'orderable': false, 'targets': [0,1] }],
           mark: true,
           fixedColumns: {
           },
           columns: [
               {data: 's#', name: 's#'},
               {data: 'course', name: 'course'},
               // {data: 'total_employee', name: 'total_employee'},
               {data: 'details', name: 'details'},
               // {data: 'details', name: 'details'},

               {data:'instructor_name',name:'instructor_name'},
               {data: 'status', name: 'status'},


               ]
           });
     }

</script>
{{-- accept bidding  --}}
<script>

    $('body').on('click', '.accept-bidding', function() {


      var id = $(this).data('id');
      $.ajax({
         url : "accept-project-manager-bidding-request",
         type :"post",
         data:{id:id,
            _token: '{{csrf_token()}}'},

         success:function()
         {
            window.location.reload();
         },error:function()
         {

         }
      })
   })
</script>

@endsection
