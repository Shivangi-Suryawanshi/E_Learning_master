@extends('layouts.admin')

@section('page-header-right')
<a href="{{route('packages')}}"  class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="">{{__t('packages')}} </a>

@endsection
@section('content')

{{-- <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
    <h4 class="flex-grow-1">{{__t('packages')}} </h4>
    <a href="{{route('packages')}}" class="btn btn-primary">{{__t('packages')}}</a>
</div>
    
    <h5>Edit Package</h5> --}}
    
            <div class="card">
                <div class="card-body">
           
 
     
                    <form method="post">
                        @csrf
                        <hr>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="title">{{ __t('title') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="title" class="form-control" id="title" value="{{$edit->title}}"
                                            value="{{ old('title') }}">
                                    </div>
                                    @if ($errors->has('title'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="title">{{ __t('description') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="description" class="form-control" value="{{$edit->description}}"
                                            value="{{ old('description') }}">

                                    </div>
                                    @if ($errors->has('description'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('description') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group {{ $errors->has('regular_price') ? ' has-error' : '' }}">
                                    <label for="title">{{ __t('regular_price') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="regular_price" class="form-control" id="regular_price"  value="{{$edit->regular_price}}"
                                            value="{{ old('regular_price') }}">

                                    </div>
                                    @if ($errors->has('regular_price'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('regular_price') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group {{ $errors->has('sale_price') ? ' has-error' : '' }}">
                                    <label for="title">{{ __t('sale_price') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="sale_price" class="form-control" id="sale_price" value="{{$edit->sale_price}}"
                                            value="{{ old('sale_price') }}">

                                    </div>
                                    @if ($errors->has('sale_price'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('sale_price') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group {{ $errors->has('month') ? ' has-error' : '' }}">
                                    <label for="title">{{ __t('month') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="number" min="0" name="month" class="form-control" id="month" value="{{$edit->month}}"
                                            value="{{ old('month') }}">

                                    </div>
                                    @if ($errors->has('month'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('month') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label for="title">{{ __t('status') }}</label>
                                    <div class="input-group mb-3">
                                      <select class="form-control" name="status" id="">
                                          <option value="">Choose</option>
                                      <option @if($edit->status == 1) selected @endif value="1">Active</option>
                                      <option @if($edit->status == 0) selected @endif value="0">InActive</option>
                                    </select>
                                    </div>
                                    
                                    @if ($errors->has('status'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('status') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary"> <i class="la la-save"></i>
                                {{ __t('update_package') }}</button>
                        </div>

                
               
            </div>
                </form>

            </div>
       

@endsection



@section('page-css')
 
@endsection

@section('page-js')
  
@endsection
