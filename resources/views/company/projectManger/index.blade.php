@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css')}}">


@endsection
@section('content')
<div class="page-content">
   <header>
      <div class="row">
         <div class="col-md-6">
            <h1 class="mb-0" id="hedn">Project Manager</h1>
         </div>

         <div class="col-md-6">
         <div class="form-group text-right mr20">
         <a class="btn btn-primary" href="{{ url('register?type=project-manager')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
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
                               
                                 <th width="150px">Email</th>
                              
                                 {{-- <th width="50px">Actions</th> --}}
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


@endsection
@section('additional_scripts')
<script src="{{asset('users/vendor/jquery-dataTables/js/jquery.dataTables.min.js')}}"></script>


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
                 url: COMPANY_URL+'project-manager/get-project-manager-data',
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
                {data: 'email', name: 'email'},
                // {data: 'action', name: 'action'},
               

             ]
           });
     }

</script>

@endsection
