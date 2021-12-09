@extends('layouts.admin')



@section('page-header-right')
<a href="{{route('functionality')}}"  class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="">{{__t('functionality')}} </a>

@endsection
@section('content')
{{-- <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
       <h4 class="flex-grow-1">{{__t('create_functionality')}} </h4>
    <a href="{{route('functionality')}}" class="btn btn-primary">{{__t('functionality')}}</a>
</div> --}}
    

    
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
                                        <input type="text" name="title" class="form-control" id="title"
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
                                        <input type="text" name="description" class="form-control"
                                            value="{{ old('description') }}">

                                    </div>
                                    @if ($errors->has('description'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('description') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                           
                        </div>

                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary"> <i class="la la-save"></i>
                                {{ __t('create_functionality') }}</button>
                        </div>

                
               
            </div>
                </form>

            </div>
       

@endsection


