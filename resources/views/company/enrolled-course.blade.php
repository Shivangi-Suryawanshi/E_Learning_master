@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css')}}">

@endsection
@section('content')
<div class="page-content">
   <header>
      <div class="row">
         <div class="col-md-6">
            <h1 class="mb-0" id="hedn">Enrolled Courses</h1>
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
                                 <th>Work Force</th>
                                 <th>Course</th>
                                 <th>Price</th>
                                 {{-- <th>Spent Amount</th> --}}
                                 <th>Satus</th>
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


@endsection
@section('additional_scripts')
<script src="{{asset('users/js/pages/form/extended/select2.js')}}"></script>
<script src="{{asset('users/vendor/select2/select2.full.min.js')}}"></script>
<script src="{{asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('users/vendor/jquery-validate/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready( function () {
     loadTable();
    
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
                 url: COMPANY_URL+'get-entrolled-course',
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
               {data: 'work_force', name: 'work_force'},
               {data: 'course', name: 'course'},
               {data: 'price', name: 'price'},
               {data:'status',name:'status'},
               {data: 'actions', name: 'actions'}
               ]
           });
     }
     
</script>

   
 

@endsection