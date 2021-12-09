@extends(theme('dashboard.layouts.dashboard'))

@section('additional_styles')
<style>
    #company-table_filter {
        text-align: right;
    }

    .mb0 {
        margin-bottom: 0px !important;
    }

    .pretty.p-switch .state {
        position: relative;
        top: -20px;
    }

    #company-table_paginate {
        float: right;
        margin-top: 10px;
    }
</style>
<link rel="stylesheet" href="{{ asset('myadmin/datepicker/css/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<main class="app-content">

    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-md-10">
                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-building"></i> Free Resources</h1>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <p class="bs-component">

                    <a class="btn btn-primary" href="{{url('dashboard/free-resources/create')}}" role="button"> <i
                            class="fa fa-plus-circle"></i> Create Free Resources </a>


                </p>
            </div>
        </div>
        <br>
    </div>


    <div class="panel-body">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 btm-margin">
                    <!--  <form method="get" name="form1" id="form1" >
      <div class="d-flex d-sort">
          <div class="col-md-3">
              <label class="lab-pad">From</label>
     <input type="text" name="starts_on" class="form-control" id="starts_on" placeholder="Select Start Date"  value="" autocomplete="off">
        </div>

         <div class="col-md-3">
              <label class="lab-pad">To</label>

      <input type="text" name="ends_on" class="form-control" id="ends_on" placeholder="Select End Date"  value="" autocomplete="off">
        </div>



          <div class="col-md-2 status">
              <label class="lab-pad">Account Status</label>
            <select name="status" id="status" class="form-control">
              <option value="">Choose Status</option>
              <option value="1" @if(Request::get('status') == '1') selected="selected" @endif>Active</option>
              <option value="0" @if(Request::get('status') == '0') selected="selected" @endif>Inactive</option>

            </select>
          </div>
          <div class="col-md-1">
               <label class="gobtn">&nbsp;</label>
            <button class="search btn btn-primary" id="btn">GO</button>
          </div>
        </div>
      </form> -->
                </div>

                <div class="col-md-12">



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
                                
                            </p>

                            <p class="m-0 text-muted">
                               


                               
                            </p>
                        </td>
                        <td><a href="{{ url('dashboard/free-resources/edit/'.$course->id) }}" ><i class="fa fa-pencil-square-o ">&nbsp;&nbsp;</i></a></td>

                      
                    </tr>

                @endforeach

            </table>

            {!! $freeResources->appends(['q' => request('q'), 'status'=> request('status') ])->links() !!}

        @else
            {!! no_data() !!}
        @endif
                   
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('page-js')

@endsection
