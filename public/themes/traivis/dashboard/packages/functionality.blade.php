@extends('layouts.admin')
@section('page-header-right')
<a href="{{route('packages')}}"  class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="">{{__t('packages')}} </a>

@endsection

@section('content')
    {{-- <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{ __t('package_functionality') }}  :{{$package->title}} </h4>
        <a href="{{ route('packages') }}" class="btn btn-primary">{{ __t('packages') }}</a>
    </div> --}}

    {{-- <h5>Package Functionality</h5> --}}

    <div class="card">
        <div class="card-body">
            <form method="post">
                @csrf
                <hr>
                <div class="row">
                    @if($functionality)
                    @foreach($functionality as $key => $functionList)
                    <div class="col-md-2">
                        <strong>{{$functionList->title}}</strong>
                    {{-- <input type="text" name="package_functionality[]" value="{{$}}" id=""> --}}
                        <div class="form-group ">   
                            <div class="input-group mb-3">
                                <input type="text" hidden @if(isset($packageFunctionality[$key] ) != null) @if($packageFunctionality[$key]['functionality_id'] == $functionList->id) checked @endif @endif name="functionality[]"   value="{{$functionList->id}}">
                            </div>
                        </div>
                     
                        <div class="form-group {{ $errors->has('total_count') ? ' has-error' : '' }}">
                            <label for="title">{{ __t('total_count') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" name="total_count[]" class="form-control" id="total_count" @if(isset($packageFunctionality[$key] ) != null) value="{{ $packageFunctionality[$key]['count'] }}" @endif>
                            </div>
                            @if ($errors->has('total_count'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('total_count') }}</strong></span>
                            @endif
                        </div>
                    
                        {{-- <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="title">{{ __t('price') }}</label>
                   
           
                            <div class="input-group mb-3">
                                <input type="text" name="price[]" class="form-control" id="price" @if(isset($packageFunctionality[$key] ) != null)  value="{{$packageFunctionality[$key]['price']}}" @endif>
                            </div>
                            @if ($errors->has('price'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('price') }}</strong></span>
                            @endif
                        </div> --}}
                    </div>
                    @endforeach
                    @endif
                </div>

                <div class="col-md-12" align="right">
                    <button type="submit" class="btn btn-primary"> <i class="la la-save"></i>
                        {{ __t('Update') }}</button>
                </div>



        </div>
        </form>

    </div>


@endsection



