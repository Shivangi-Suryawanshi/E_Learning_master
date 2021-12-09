@extends('company.layouts.app-company')
@section('additional_styles')
@endsection
@section('content')
<div class="page-content">
   <header>
      <div class="row">
         <div class="col-md-6">
            <h1 class="mb-0" id="hedn">Pay Now</h1>
         </div>
      </div>
   </header>
   <div class="panel panel-light">
      <div class="container">
         <div class="row mt20 paymentDv">
            <div class="col-md-4">
               <div class="form-group">
                  Total Employees : <label id="employees"></label></br>
                  Cost per Person : <label id="cost"></label></br>
                  Total Price : <label id="total"></label>
                  <input type="hidden" id="total_price" name="total_price"  class="form-control form-control-lg">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <button type="button" class="btn btn-block btn-primary" id="paymentBtn">Pay Now</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('additional_scripts')
<script src="{{asset('users/vendor/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{ asset('js/common.js') }}"></script>

<script type="text/javascript">

$(document).ready( function () {
   unit_price      = getCookie('unit_price');
   course_quantity = getCookie('quantity');
   var unitprice = Number(unit_price);
   var coursequantity = Number(course_quantity);
   total = unitprice*coursequantity;
   $("#total_price").val(total);
   $("#total").html("$ "+total);
   $("#employees").html(coursequantity);
   $("#cost").html("$ "+unitprice);

});

$("#paymentBtn").click(function(){
   total_price    = $("#total_price").val();
   temporary_id   = getCookie('temp_course_id');
   $.ajax({
         type: "POST",
         url: COMPANY_URL+'save-purchase-course-payment',
         data:{total_price:total_price,
               temporary_id:temporary_id,
               _token: '{{csrf_token()}}'},
         success: function(response){
            if(response){
               $(".paymentDv").html("");
               $(".paymentDv").html("You have purchased the course successfully.");
            }
         }
   });
});
</script>
@endsection