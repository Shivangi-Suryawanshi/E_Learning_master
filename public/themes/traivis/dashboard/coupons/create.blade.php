@extends('layouts.admin')
@section('content')

    <form action="{!! URL::to('dashboard/coupon/create') !!}" method="post" enctype="multipart/form-data">
         @csrf

        <div class="row">
            <div class="col-md-12" style="margin-top: 18px">
                <h4>@lang('admin.coupon_create')</h4>
            </div>
            <div class="col-md-12">

                <div class="form-group row {{ $errors->has('category_name')? 'has-error':'' }} ">
                    <label class="col-sm-3 control-label" for="category_name">@lang('admin.coupon_title')</label>
                    <div class="col-sm-5">
                        <input type="text" name="coupon_title" value="" placeholder="@lang('admin.coupon_title')" id="coupon_title" class="form-control">
                        {!! $errors->has('coupon_title')? '<p class="help-block">'.$errors->first('coupon_title').'</p>':'' !!}
                    </div>
                </div>    

                <div class="form-group sub-btns" @if($errors->first('coupon_type')) has-error @endif">

                    <label class="rtl">Coupon Type</label>
    
                    <div class="pretty p-default p-round p-thick">          
                      <input type="radio" name="coupon_type" value="0" checked/>
                      <div class="state p-primary">
                        <i class="icon mdi mdi-check"></i>
                        <label>General</label>
                      </div>
                    </div> 
                    <div class="pretty p-default p-round p-thick">          
                      <input type="radio" name="coupon_type" value="1" />
                      <div class="state p-primary">
                        <i class="icon mdi mdi-check"></i>
                        <label>Specific Courses Only</label>
                      </div>
                    </div> 
                    <span class="help-block required">{{$errors->first('coupon_type')}}</span>
                  </div>
                 
                <div class="form-group" style="display: none;" id="percentage-div">

                    <label class="rtl">Select Courses</label>
                    <div class="col-xs-12">
                      <div class="col-md-4 landiv">                        
                      </div><div class="col-md-8 ">
                        <select name="courses[]" class="form-control js-example-basic-multiple" multiple="multiple">
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                     </div>
                   </div>               
    
    
                </div>
    
                
                <div class="form-group row @if($errors->first('promocode')) has-error @endif">
                    <label for="promocode" class="rtl col-sm-3">Coupon Code</label>
                    <div class="col-sm-5 landiv sub-pad">
                     <input type="text" class="form-control" name="promocode" maxlength="8"  value="">
                     <span class="help-block required">{{$errors->first('promocode')}}</span>
                   </div>
                   <div class="col-md-3 landiv sub-pad">
                    <input type="button"  value="Generate Code" class="btn btn-warning" onclick="randomStringToInput(this)">
                  </div>
                 
                </div>

                <div class="form-group row {{ $errors->has('discount_amount')? 'has-error':'' }} ">
                    <label class="col-sm-3 control-label" for="discount_amount">@lang('admin.discount_amount')</label>
                    <div class="col-sm-5">
                        <input type="text" name="discount_amount" value="" placeholder="@lang('admin.discount_amount')" id="discount_amount" class="form-control">
                        {!! $errors->has('discount_amount')? '<p class="help-block">'.$errors->first('discount_amount').'</p>':'' !!}
                    </div>
                </div>  

                <div class="form-group row {{ $errors->has('coupon_description')? 'has-error':'' }} ">
                    <label class="col-sm-3 control-label" for="coupon_description">@lang('admin.coupon_description')</label>
                    <div class="col-sm-5">
                        <textarea name="coupon_description" class="form-control"></textarea>                      
                        {!! $errors->has('coupon_description')? '<p class="help-block">'.$errors->first('coupon_description').'</p>':'' !!}
                    </div>
                </div>   

                <div class="form-group row @if($errors->first('starts_on')) has-error @endif">
                    <label for="starts_on" class="rtl col-sm-3">Valid From</label>
                    <div class="col-sm-5">
                    <input type="date" name="starts_on" class="form-control rtl basic-usage" id="starts_on" placeholder="Select Start Date"  value="{!! old('starts_on') !!}">
                     <span class="help-block required">{{$errors->first('starts_on')}}</span>      
                     </div>
                  </div>
    
    
                  <div class="form-group row @if($errors->first('starts_on')) has-error @endif">
                    <label for="starts_on" class="rtl col-sm-3">Valid To</label>
                    <div class="col-sm-5">
                    <input type="date" name="ends_on" class="form-control rtl basic-usage" id="ends_on" placeholder="Select End Date"  value="{!! old('starts_on') !!}">
                    <span class="help-block required">{{$errors->first('starts_on')}}</span>
                    </div>
                  </div>
               

                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="description">@lang('admin.used_status')</label>
                    <div class="col-sm-7">
                        <label><input type="radio" name="used_status" value="1"> {{__a('active')}}</label> <br />
                        <label><input type="radio" name="used_status" value="0" checked="checked"> {{__a('inactive')}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="description">@lang('admin.active_status')</label>
                    <div class="col-sm-7">
                        <label><input type="radio" name="active_status" value="1" checked="checked"> {{__a('active')}}</label> <br />
                        <label><input type="radio" name="active_status" value="0"> {{__a('inactive')}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-7 offset-3">
                        <input type="submit" class="btn btn-success btn-xl" data-toggle="tooltip" title="@lang('admin.save')">
                    </div>
                </div>


            </div>

        </div>

    </form>

@endsection
@section('page-css')
    <link href="{{ asset('assets/plugins/select2-4.0.3/css/select2.css') }}" rel="stylesheet" />
@endsection
@section('page-js')
<script>


    function randomStringToInput(clicked_element)
    {
     // var self = $(clicked_element);
     var random_string = generateRandomString(7);
     $('input[name=promocode]').val(random_string);
    //  self.remove();
  }
  function generateRandomString(string_length)
  {
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var string = '';
    for(var i = 0; i <= string_length; i++)
    {
      var rand = Math.round(Math.random() * (characters.length - 1));
      var character = characters.substr(rand, 1);
      string = string + character;
    }
    return string;
  }
  </script>
  
<script type="text/javascript">
    $(document).ready(function () {
     $("input[name='coupon_type']").click(function() 
      {
       $('#discount-div').css('display', 'block');
       var radioValue = $("input[name='coupon_type']:checked").val();
       $('.percent').css('display', 'none');
       $('.dis-percent').css('display', 'none');
       $('.dis-amt').css('display', 'block');  
       $('#amount-div').css('display', 'block');
       $('#percentage-div').css('display', 'none');
  
       if(radioValue =='1'){
        $('.percent').css('display', 'block');
        $('.dis-percent').css('display', 'block');
        $('.dis-amt').css('display', 'none');  
        $('#amount-div').css('display', 'none');
        $('#percentage-div').css('display', 'block');
      }
    });
  
   
  });
  
  </script>
     <script src="{{ asset('assets/plugins/select2-4.0.3/js/select2.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
       $('.js-example-basic-multiple').select2();
  });
  
  </script>
@endsection
