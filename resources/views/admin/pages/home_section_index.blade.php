@extends('layouts.admin')
<style type="text/css">
    .pretty .state label {
    position: initial;
    display: inline-block;
    font-weight: 400;
    margin: 7px !important;
    min-width: calc(1em + 2px);
}
</style>
@section('head_title')
Home Page Sections
@endsection
@section('content')
<main class="app-content">

    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-md-10">
                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-building"></i> Home Page Sections</h1>

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
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="course name">
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
                    <th>{{__t('title')}}</th>
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
                        <td><a href="{{ url('admin/home-page-sections/view/'.$course->id) }}" ><i class="fa fa-pencil-square-o ">&nbsp;&nbsp;</i></a></td>

                      
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
</div><!-- /.content-wrapper -->
@section('page-js')
      <script type="text/javascript" src="{{asset('admin/js/bootstrap-switch.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/iziToast.min.js')}}"></script>
      <script src="{{asset('admin/datepicker/js/bootstrap-datepicker.js')}}"></script>

<script type="text/javascript">

    var table = $('#example2').DataTable({
        "aaSorting": [],
            "fnDrawCallback": function(oSettings) {

                if (oSettings.bSorted || oSettings.bFiltered || oSettings._iDisplayLength)
                {
                    j = 0;

                    for (var i = oSettings._iDisplayStart; i < oSettings.aiDisplay.length + oSettings._iDisplayStart; i++)
                    {
                        $('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[j] ].nTr).find('span').text(i + 1);
                        j++;
                    }
                }

                /********* Switch Status ********/
                $("[name='my-checkbox']").bootstrapSwitch({
                    onText: 'Active',
                    offText: 'Inactive',
                    offColor: 'danger'
                });

            },
            processing: true,
 
        // fixedHeader: true,
        /*fixedColumns: {
            leftColumns: 2
        },*/
        //scrollX: true,
    mark: true,
        ajax: {
            url: '{!! URL::to("home-page-sections/get-data") !!}',
            data: function(d) {
                d.pageName = $('#txt_name').val();
            }
        },
        columns: [
        {data: 'id', name: 'id', orderable: false, searchable: false},
        {data: 'title_en', name: 'title_en'},
        {data: 'status', name: 'status', orderable: false, searchable: false},
        {data: 'created_at', name: 'created_at'},
        {data: 'tblaction', name: 'tblaction', orderable: false, searchable: false}

        ]});

    $('#txt_name').on('keyup', function () {
        table.draw();
    });

    $('.cls-form-reset').on('click',function(event){
        event.preventDefault();
        $('#txt_name').val('');
        table.draw();
    });
</script>

<script src="{{ asset('admin/js/includes/pages/pages.js')}}"></script>

@endsection