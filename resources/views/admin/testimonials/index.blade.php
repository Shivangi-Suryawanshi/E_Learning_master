@extends('layouts.admin')
 @section('content')
 <main class="app-content">

    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-md-10">
                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-building"></i>Testimonials</h1>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <p class="bs-component">

                   {{--  <a class="btn btn-primary" href="{{url('admin/free-resources/create')}}" role="button"> <i
                            class="fa fa-plus-circle"></i> Create Home Page Section </a> --}}


                </p>
            </div>
        </div>
        <br>
    </div>


    <div class="panel-body">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 btm-margin">
                   
                </div>

                <div class="col-md-12">

<form action="" method="get">

        <div class="courses-actions-wrap">

            <div class="row">

                <div class="col-md-12">
                    <div class="input-group mb-4">
                        <select name="status" class="mr-3 mt-3 dbtn">
                            <option value="">{{__a('set_status')}}</option>
                            <option value="1" {{selected('1', request('status'))}} >publish</option>
                           {{--  <option value="2" {{selected('2', request('status'))}} >pending</option>
                            <option value="3" {{selected('3', request('status'))}} >block</option> --}}
                            <option value="2" {{selected('2', request('status'))}} >unpublish</option>
                        </select>

                        <button type="submit" name="bulk_action_btn" value="update_status" class="btn btn-primary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{__a('update')}}
                        </button>                      

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="search-filter-form-wrap mb-3">

                        <div class="input-group">
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="Name">
                            <select name="filter_status" class="mr-3 dbtn">
                                <option value="">Filter by status</option>
                                <option value="1" {{selected('1', request('filter_status'))}} >publish</option>
                              {{--   <option value="2" {{selected('2', request('filter_status'))}} >pending</option>
                                <option value="3" {{selected('3', request('filter_status'))}} >block</option> --}}
                                <option value="0" {{selected('0', request('filter_status'))}} >unpublish</option>
                            </select>

                            <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
                        </div>

                    </div>


                </div>
            </div>

        </div>

@if($freeResources->count() > 0)

            <table class="table table-bordered bg-white">

                <tr>
                    <td><input class="bulk_check_all" type="checkbox" /></td>
                    <th>Created on</th>
                    <th>Name</th>
                    <th>Action</th>
   
                </tr>

                @foreach($freeResources as $course)
                    <tr>
                        <td>
                            <label>
                                <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$course->id}}" />
                                <small class="text-muted">#{{$course->id}}</small>
                            </label>
                        </td>
                        <td>
                            {{ Carbon\Carbon::parse($course->created_at)->format('d-M-Y') }}
                        </td>
                        <td>
                            <p class="mb-3">
                                <strong>{{$course->title}}</strong>
                                @if($course->status==1)
                                <span class="badge badge-success"> <i class="la la-check-circle"></i> Published</span>
                                @else
                                 <span class="badge badge-danger"> <i class="la la-check-circle"></i> Unpublished</span>
                                 @endif

                            </p>

                            <p class="m-0 text-muted">
                               


                               
                            </p>
                        </td>
                        <td><a href="{{ url('admin/testimonials/edit/'.$course->id) }}" ><i class="fa fa-pencil-square-o ">&nbsp;&nbsp;</i></a></td>

                      
                    </tr>

                @endforeach

            </table>

            {!! $freeResources->appends(['q' => request('q'), 'status'=> request('status') ])->links() !!}

        @else
            {!! no_data() !!}
        @endif

    </form>
                   
                </div>
            </div>
        </div>
    </div>

</main>
                  @endsection


                  @section('page-js')
                

                  <script type="text/javascript" src="{{asset('admin/js/bootstrap-switch.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/iziToast.min.js')}}"></script>
      <script src="{{asset('admin/datepicker/js/bootstrap-datepicker.js')}}"></script>


                  <script type="text/javascript">

                    var table = $('#example2').DataTable({
                     "bFilter": false,
                     "aaSorting": [],
                     "aoColumnDefs": [

                     {orderable: false, targets: [0]}],
                     "fnDrawCallback": function (oSettings) {
                      $("[name='my-checkbox']").bootstrapSwitch({
                        onText: 'Active',
                        offText: 'Inactive',
                        offColor: 'danger',
                      });

                      if (oSettings.bSorted || oSettings.bFiltered || oSettings._iDisplayLength) {
                       j = 0;
                       for (var i = oSettings._iDisplayStart; i < oSettings.aiDisplay.length + oSettings._iDisplayStart; i++) {
                        $('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[j]].nTr).find('span').text(i + 1);
                        j++;
                      }
                    }

                  },
                  serverSide: true,


                  oLanguage: {
                    sProcessing: "<img src='{{ asset('admin/images/loading.gif')}}'>"
                  },
                  processing: true,
                  "pageLength": 25,
                  "columnDefs": [{ 'orderable': false, 'targets': [0,1,3] }],
                  mark: true,
                  fixedColumns: {

                  },
                  ajax: {
                    url: '{!! URL::to("/testimonial_data") !!}',
                    data: function (d) {
                    }
                  },
                  columns: [
                  {data: 's#', name: 's#'},
                  {data: 'title_en', name: 'title_en'},
                   {data: 'title_ar', name: 'title_ar'},
                    {data: 'status', name: 'status'},                
                  {data: 'action',name: 'action'},

                  ]
                });

    //  $('table').removeClass('dataTable');


  </script>
  <script src="{{ asset('admin/js/includes/testimonial/testimonial.js')}}"></script>


  @endsection
