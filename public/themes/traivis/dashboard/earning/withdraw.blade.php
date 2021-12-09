@extends(theme('dashboard.layouts.dashboard'))

@section('content')

<style>
    .pb15 {padding-bottom: 30px !important; margin-top:30px;}
     .ptab {color: #000;
    padding: 10px 20px 10px 10px;    border-radius: 5px;
    box-shadow: 0px 0 2px 0 #666666;
}

.ptab2  {box-shadow: 0px 0 7px 0 #666666; font-weight:600;}


@media screen and (max-width: 460px) {

 .ptab {color: #000;
    padding: 0px 1px 0px 0px; border-radius: 0px;
    margin-right:40px;
    box-shadow: 0px 0 0px 0 #666666;;
}

.active {font-weight:600; border-bottom:1px solid #000;box-shadow: 0px 0 0px 0 #666666;}

}

    </style>


    <div class="dashboard-inline-submenu-wrap mb-4 border-bottom">
    <div class="pb15">
        <a href="{{route('withdraw')}}" class="ptab ptab2  active">{{__t('withdraw')}}</a>
        <a href="{{route('withdraw_preference')}}" class="ptab">{{__t('withdraw_preference')}}</a>
</div>
    </div>

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Lifetime sales</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->sales_amount) !!}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Lifetime Earnings</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->earnings) !!}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Commission Deducted</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->commission) !!}</h4>
            </div>
        </div>


        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">{{__t('withdrawn')}}</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->withdrawals) !!}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-body mb-4">
                <h6 class="text-muted text-uppercase">Balance</h6>
                <h4 class="earning-stats amount">{!! price_format($user->earning->balance) !!}</h4>
            </div>
        </div>

    </div>


    @if( ! $user->withdraw_method)
        <div class="alert alert-warning">You did not select any withdraw method yet. Please select a withdraw method to process your withdraw.</div>

        <a href="{{route('withdraw_preference')}}" class="btn btn-primary"> <i class="la la-cash-register"></i> Set Withdraw Method</a>
    @else

        <h4 class="mb-4">Enter withdrawal details</h4>

        <div class="withdrawal-details-form p-4 bg-white">


            <p class="mb-0">Withdrawal Method: <strong>{{$user->withdraw_method->method_name}}</strong></p>

            @if( array_get($user->withdraw_method->admin_form_fields, 'min_withdraw_amount') )
                <p>Min Withdraw amount: <strong>{!! price_format(array_get($user->withdraw_method->admin_form_fields, 'min_withdraw_amount')) !!}</strong></p>
            @endif


            @if(is_array($user->withdraw_method->form_fields) && count($user->withdraw_method->form_fields) )
                <div class="preferred-withdraw-method-details mb-4">
                    @foreach($user->withdraw_method->form_fields as $field)
                        <p class="mb-0"> {{array_get($field, 'label')}} : <strong>{!! array_get($field, 'value') !!}</strong></p>
                    @endforeach
                </div>
            @endif


            <div class="card mb-4">
                <div class="card-body">

                    <form action="" method="post">
                        @csrf


                        <div class="form-group row {{form_error($errors, 'amount' )->class}}">
                            <label class="col-md-4 control-label"> {{__t('amount')}} ({{get_currency()}}) </label>
                            <div class="col-md-6 ">
                                <input type="number" class="form-control" name="amount" value="{{old('amount')}}">

                                <p class="text-muted my-1">

                                    <small>
                                        @if( array_get($user->withdraw_method->admin_form_fields, 'min_withdraw_amount') )
                                            Min withdraw amount <strong>{!! price_format(array_get($user->withdraw_method->admin_form_fields, 'min_withdraw_amount')) !!}</strong>,
                                        @endif

                                        Max : <strong>{!! price_format($user->earning->balance) !!}</strong>
                                    </small>
                                </p>

                                {!! form_error($errors, 'amount' )->message !!}

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 control-label"> {{__t('description')}} <span class="text-muted">(Optional)</span> </label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description">{{old('description')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-md-4 col-md-6">
                                <button type="submit" class="btn btn-purple">{{__t('withdraw')}}</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>


            @if( array_get($user->withdraw_method->admin_form_fields, 'notes') )
                <p class="text-muted">
                    {!! array_get($user->withdraw_method->admin_form_fields, 'notes') !!}
                </p>
            @endif

        </div>

    @endif



    @if($user->withdraws->count())
        <h4 class="my-4">{{__t('previous_withdraws')}}</h4>

        <table class="table table-bordered table-striped">
            <tr>
                <th>{{__t('id')}}</th>
                <th>{{__t('details')}}</th>
                <th>{{__t('description')}}</th>
                <th>{{__t('time')}}</th>
            </tr>

            @foreach($user->withdraws as $withdraw)

                <tr>
                    <td>#{{$withdraw->id}}</td>
                    <td>
                        <h5 class="mb-4">Amount: <strong>{!! price_format($withdraw->amount) !!}</strong> {!! $withdraw->status_context !!} </h5>
                        <h5>Method: <strong>{{array_get($withdraw->method_data, 'method_name')}}</strong></h5>

                        @if(is_array(array_get($withdraw->method_data, 'form_fields')))
                            @foreach(array_get($withdraw->method_data, 'form_fields') as $field)
                                <p class="mb-0"> {{array_get($field, 'label')}} : <strong>{!! array_get($field, 'value') !!}</strong></p>
                            @endforeach
                        @endif
                    </td>

                    <td>{{$withdraw->description}}</td>

                    <td>{{$withdraw->created_at->format(date_time_format())}}</td>
                </tr>

            @endforeach

        </table>

    @endif

@endsection


