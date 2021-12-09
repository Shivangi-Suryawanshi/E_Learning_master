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
Pages
@endsection
@section('content')
<form action="" method="get">

    <div class="courses-actions-wrap">

        <div class="row">

            {{-- <div class="col-md-12">
                <div class="input-group mb-3">
                    <select name="status" class="mr-3 mt-3">
                        <option value="">{{__a('set_status')}}</option>
                        <option value="1" {{selected('1', request('status'))}} >publish</option>
                        <option value="2" {{selected('2', request('status'))}} >pending</option>
                        <option value="3" {{selected('3', request('status'))}} >block</option>
                        <option value="4" {{selected('4', request('status'))}} >unpublish</option>
                    </select>

                    <button type="submit" name="bulk_action_btn" value="update_status" class="btn btn-primary mt-3 mr-2">
                        <i class="la la-refresh"></i> {{__a('update')}}
                    </button>

                    <button type="submit" name="bulk_action_btn" value="mark_as_popular" class="btn btn-info mt-3 mr-2">
                        <i class="la la-bolt"></i>{{__a('mark_as_popular')}}
                    </button>

                    <button type="submit" name="bulk_action_btn" value="remove_from_popular" class="btn btn-warning mt-3 mr-2">
                        <i class="la la-bolt"></i> {{__a('remove_from_popular')}}
                    </button>

                    <button type="submit" name="bulk_action_btn" value="mark_as_feature" class="btn btn-dark mt-3 mr-2">
                        <i class="la la-bookmark"></i> {{__a('mark_as_feature')}}
                    </button>
                    <button type="submit" name="bulk_action_btn" value="remove_from_feature" class="btn btn-warning mt-3 mr-2">
                        <i class="la la-bolt"></i> {{__a('remove_from_feature')}}
                    </button>

                    <button type="submit" name="bulk_action_btn" value="delete" class="btn btn-danger delete_confirm mt-3"> <i class="la la-trash"></i> {{__a('delete')}}</button>

                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="search-filter-form-wrap mb-3">

                    <div class="input-group">
                        <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="Page name">
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

    @if($template->count() > 0)

        <table class="table table-bordered bg-white">

            <tr>
              
                <th>{{__t('title')}}</th>
                <th>{{__t('key')}}</th>
                <th>#</th>
            </tr>

            @foreach($template as $emailtemplate)
                <tr>
                    <td>
                        {{$emailtemplate->title}}
                    </td>
                                          
                    
                    <td>
                        {{$emailtemplate->key}}
                      
                    </td>

                    <td>

                        <a href="{{route('email_template_edit', $emailtemplate->id)}}" class="btn btn-sm btn-primary mt-2" target="_blank"><i class="la la-edit"></i> {{__t('edit')}} </a>

                    </td>
                </tr>

            @endforeach

        </table>

      

    @else
        {!! no_data() !!}
    @endif

</form>

@endsection
</div><!-- /.content-wrapper -->
