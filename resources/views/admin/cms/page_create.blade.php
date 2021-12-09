@extends('layouts.admin')


@section('page-header-right')
    <a href="{{route('pages')}}" class="btn btn-info" data-toggle="tooltip" title="{{__a('pages')}}"> <i class="la la-list"></i> {{__a('pages')}} </a>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">

            <form action="" method="post" id="createPostForm" enctype="multipart/form-data">
                @csrf

                <div class="form-group row {{ $errors->has('title')? 'has-error':'' }}">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="title" value="{{ old('title') }}" name="title" placeholder="{{__a('title')}}">
                        {!! $errors->has('title')? '<p class="help-block">'.$errors->first('title').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('post_content')? 'has-error':'' }}">
                    <div class="col-sm-12">
                        <textarea name="post_content" id="post_content" class="form-control" rows="6">{{ old('post_content') }}</textarea>
                        {!! $errors->has('post_content')? '<p class="help-block">'.$errors->first('post_content').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">{{__a('create_new_page')}}</button>
                    </div>
                </div>
            </form>

        </div>

    </div>


@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'post_content' );
    </script>
@endsection
