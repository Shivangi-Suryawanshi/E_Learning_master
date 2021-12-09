@extends(theme('dashboard.layouts.dashboard'))

@section('content')

<style>
    .pb15 {padding-bottom: 30px !important; margin-top:30px;}
     .ptab {color: #000;
    padding: 10px 20px 10px 10px;    border-radius: 5px;
    box-shadow: 0px 0 2px 0 #666666;
}

.active {box-shadow: 0px 0 7px 0 #666666; font-weight:600;}
    </style>


    <div class="dashboard-inline-submenu-wrap mb-4 border-bottom">
    <div class="pb15">
        <a href="{{route('withdraw')}}" class="ptab">{{__t('withdraw')}}</a>
        <a href="{{route('withdraw_preference')}}" class="active ptab">{{__t('withdraw_preference')}}</a>
</div>
    </div>

    <h4 class="mb-4">{{__t('select_withdraw_method')}}</h4>


    @php
        $withdraw_methods = active_withdraw_methods();
        $saved_preference = (array) $user->get_option('withdraw_preference');
      
    @endphp

    <div class="withdraw-method-preference-wrap bg-white p-4">
        <form action="" method="post">

            @csrf

            <div class="withdraw-method-selection-wrap mb-4 d-flex">
                @foreach($withdraw_methods as $method_key => $method)
                    <div class="select-withdraw-method-name">
                        <input type="radio" class="withdraw-method-input" id="withdraw-method-{{$method_key}}-input" name="withdraw_preference[method]" value="{{$method_key}}" {{checked($method_key, array_get($saved_preference, 'method'))}} style="display: none;">

                        <label for="withdraw-method-{{$method_key}}-input" class="withdraw-preference-method-name py-3 px-4 border mr-3" data-target="withdraw-method-{{$method_key}}-form">
                            <p class="mb-0">{{array_get($method, 'method_name')}}</p>
                            <p class="text-muted mb-0">
                                <small>Min withdraw amount: {!! price_format(get_option("withdraw_methods.{$method_key}.min_withdraw_amount")) !!}</small>
                            </p>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="withdraw-method-preference-form-wrap">

                @foreach($withdraw_methods as $method_key => $method)

                    <div id="withdraw-method-{{$method_key}}-form" class="withdraw-method-form" style="display: {{array_get($saved_preference, 'method') == $method_key ? 'block' : 'none'}};">

                        @php
                            $notes = get_option("withdraw_methods.{$method_key}.notes");
                            $form_fields = array_get($method, 'form_fields');
                        @endphp

                        @if($notes)
                            <div class="alert alert-info">
                                {!! $notes !!}
                            </div>
                        @endif


                        @if(is_array($form_fields) && count($form_fields))
                            <div class="form-row">

                                @foreach($form_fields as $field_key => $field)
                                    <div class="col-md-6 mb-3">
                                        <label> {{array_get($field, 'label')}} </label>

                                        @if(array_get($field, 'type') === 'text')

                                            <input type="text" class="form-control" name="withdraw_preference[{{$method_key}}][{{$field_key}}]" value="{{array_get($saved_preference, $method_key.'.'.$field_key )}}"  >

                                        @elseif(array_get($field, 'type') === 'email')

                                            <input type="email" class="form-control" name="withdraw_preference[{{$method_key}}][{{$field_key}}]" value="{{array_get($saved_preference, $method_key.'.'.$field_key )}}" >

                                        @elseif(array_get($field, 'type') === 'textarea')
                                            <textarea name="withdraw_preference[{{$method_key}}][{{$field_key}}]" class="form-control" >{{array_get($saved_preference, $method_key.'.'.$field_key )}}</textarea>
                                        @endif



                                        @if(array_get($field, 'desc'))
                                            <p class="text-muted font-italic">
                                                <small>{!! array_get($field, 'desc') !!}</small>
                                            </p>
                                        @endif

                                    </div>
                                @endforeach
                            </div>

                        @endif


                        @if(array_get($method, 'desc'))
                            <div class="withdraw-form-desc text-info font-italic">
                                {!! array_get($method, 'desc') !!}
                            </div>
                        @endif

                        <button type="submit" class="btn btn-purple btn-lg mt-5"> <i class="la la-save"></i> Save Withdraw Preference</button>

                    </div>

                @endforeach




            </div>
        </form>


    </div>


@endsection


