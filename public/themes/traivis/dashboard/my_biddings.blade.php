@extends(theme('dashboard.layouts.dashboard'))

@section('content')
<div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('my_biddings')}} </h4>
       
    </div>
<form action="" method="get">

    <div class="courses-actions-wrap">

        <div class="row">
            

            <div class="col-md-12">
                <div class="search-filter-form-wrap mb-3">

                    <div class="input-group">
                        <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="Course name">
                        <select name="filter_status" class="mr-3">
                            <option value="">Filter by status</option>
                            <option value="1" {{selected('1', request('filter_status'))}} >publish</option>
                            <option value="2" {{selected('2', request('filter_status'))}} >pending</option>
                            <option value="3" {{selected('3', request('filter_status'))}} >block</option>
                            <option value="4" {{selected('4', request('filter_status'))}} >unpublish</option>
                        </select>

                        <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
                    </div>

                </div>


            </div>
        </div>

    </div>

    @if($biddings->count() > 0)

        <table class="table table-bordered bg-white">

            <tr>
                <td><input class="bulk_check_all" type="checkbox" /></td>
                <th>{{__t('course')}}</th>
                <th>{{__t('bidding_price')}}</th>
                <th>{{__t('number_of_employees')}}</th>
                <th>{{__t('created_on')}}</th>
                <th>#</th>
            </tr>

            @foreach($biddings as $course)
                <tr>
                    <td>
                        <label>
                            <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$course->id}}" />
                            <small class="text-muted">#{{$course->id}}</small>
                        </label>
                    </td>
                    <td>
                        <p class="mb-3">
                           @if($course->biddingRequestCourse) {{$course->biddingRequestCourse->title}} @endif                           
                        </p>                     
                    </td>
                      <td>
                        <p class="mb-3">
                            {{$course->bidding_price}}                           
                        </p>                     
                    </td>
                     <td>
                        
                            {{$course->number_of_employees}}                           
                                          
                    </td>
                    <td>{{ date('F j, Y',strtotime($course->created_at)) }}</td>

                    <td>

                      
                            <a href="#!" class="btn btn-sm btn-primary mt-2" target="_blank"><i class="la la-eye"></i> {{__t('view')}} </a>
                       

                       

                    </td>
                </tr>

            @endforeach

        </table>

        {!! $biddings->appends(['q' => request('q'), 'status'=> request('status') ])->links() !!}

    @else
        {!! no_data() !!}
    @endif

</form>

@endsection

