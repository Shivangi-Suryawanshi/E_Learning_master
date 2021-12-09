
@extends(theme('dashboard.layouts.dashboard'))

@section('content')
    @include(theme('dashboard.courses.course_nav'))

    <div class="curriculum-top-nav d-flex bg-white mb-4 p-2 border">
        <h4 class="flex-grow-1"><i class="la la-list-alt"></i> {{__t('new_section')}} </h4>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="" method="post">
                @csrf
                <div class="form-group {{ $errors->has('section_name') ? ' has-error' : '' }}">
                    <label for="section_name">{{__t('section_name')}}</label>
                    <input type="text" name="section_name" class="form-control" id="section_name" placeholder="{{__t('section_name_eg')}}" value="" >
                   
                    @if ($errors->has('section_name'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('section_name') }}</strong></span>
                    @endif
                </div>
                <div>
                    <select name="section_type" class="form-control" >
                        <option value="">Choose Type</option>
                        <option value="1">Face To Face</option>
                        <option value="2">Recorderd</option>
                        <option value="3">Live</option>
                    </select>
                     
                    @if ($errors->has('section_type'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('section_type') }}</strong></span>
                    @endif
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="save" value="save">
                    <i class="la la-save"></i> {{__t('create_section')}}
                </button>
            </form>

        </div>
    </div>
@endsection
