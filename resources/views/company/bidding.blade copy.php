@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/select2/select2.min.css')}}">
<style>
   .select2-container {width:100% !Important;} 
   .select2-container--default .select2-selection--multiple {
   border: solid #e2e5ec 1px !important;}
   .select2-container .select2-selection--single {
   box-sizing: border-box;
   cursor: pointer;
   display: block;
   height: 38px !important;
   user-select: none;
   -webkit-user-select: none;
   }
   .mb20 { margin-bottom: 40px; }
   .select2-container--default .select2-search--inline .select2-search__field{height: 30px !important;font-size: 14px;}
   .select2-container--default .select2-selection--single {
   background-color: #fff;
   border: 1px solid  #e2e5ec;
   border-radius: 4px;
   }
  .showBtn{ display: block;}
  .hideBtn{ display: none;}
  .hide{ display: none !important; }

  .buyModal p {color: #000; font-size: 18px;}

</style>
@endsection
@section('content')
<div class="page-content">
   <header>
      <div class="row">
         <div class="col-md-6">
            <h1 class="mb-0" id="hedn">Bidding</h1>
         </div>
      </div>
   </header>
   <div class="panel panel-light">
      <div class="container">
      <form name="Form1" id="Form1" action="{{route('save-bidding-price')}}" method="POST">
         @csrf
         <div class="row mt20">
            <div class="col-md-3">
               <ul class="nav nav-tabs flex-column tabs-sidelined sideline-right nav-vertical-tabs-animated nav-vertical-tabs-bg-animated h-auto">
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">Select Your Course</a>
                  </li>
                  <li class="nav-wall wall-left has-left-arrow"></li>
               </ul>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label for="">Department</label>
                  <select id="course_department" name="course_department" data-toggle="select2" data-search="true" class="form-control">
                  </select>
               </div>
            </div>
            <div class="col-md-5">
               <div class="form-group">
                  <label for="">Select Course</label>
                  <select id="company_course" name="companCourse_id" data-toggle="select2" data-search="true" class="form-control">
                  </select>
                  <label id="company-error" class="error hide" for="company_course">Please Select a Course</label>
               </div>
            </div>
         </div>
      
         <div class="row mt20">
           
           
           
            <div class="col-md-6 mt20 mb20">
               <div class="form-group">
                  <label for="">Enter Number Employees</label>
                  {{-- <select id="employees" name="employees[]" data-toggle="select2" data-search="true" class="form-control" multiple>
                  </select> --}}
                  <input type="text" id="employeesCount" name="employeesCount"  class="form-control form-control-lg">

                  <label id="employees-error" class="error hide" for="employees">Please Select Minimum 1 Employee</label>
               </div>
            </div>
            <div class="col-md-6 mt20 mb20">
               <div class="form-group">
                  <label for="">Biding amount </label>
                  {{-- <select id="employees" name="employees[]" data-toggle="select2" data-search="true" class="form-control" multiple>
                  </select> --}}
                  <input type="text" placeholder="starting bid amount" id="bidding_price" name="bidding_price"  class="form-control form-control-lg">

                  <label id="employees-error" class="error hide" for="employees">Please Select Minimum 1 Employee</label>
               </div>
            </div>
            <div class="col-md-6 mt20 mb20">
               <div class="form-group">
                  <label for="">Dead Line </label>
                  {{-- <select id="employees" name="employees[]" data-toggle="select2" data-search="true" class="form-control" multiple>
                  </select> --}}
                  <input type="date" placeholder="starting bid amount" id="deadLine" name="deadLine"  class="form-control form-control-lg">

                
               </div>
            </div>
            {{-- <div class="col-md-6 mt20 mb20">
               <div class="form-group">
                  <label for="">Message/Course Requirements</label> --}}
                  {{-- <select id="employees" name="employees[]" data-toggle="select2" data-search="true" class="form-control" multiple>
                  </select> --}}
                  {{-- <textarea type="text" id="keyword" name="keyword"  class="form-control form-control-lg"></textarea>

                  <label id="employees-error" class="error hide" for="employees">Please Select Minimum 1 Employee</label>
               </div>
            </div> --}}
            <div class="col-md-2">
               <label for="">&nbsp;</label>
               <div class="form-group ">
                  <input type="hidden" name="skip" id="skip" value="0">
                  <input type="hidden" name="types" id="skip" value="1">

                  <button type="submit" class="m-1 btn btn-dark" id="searchBtn1x"><i  aria-hidden="true"></i> Submit Request</button>
               </div>
            </div>
            <br>
         </div>
      </form>
      </div>
   </div>
   {{-- <!----------------------sec2---------------------------------> --}}
   
   


         <div class="row">
            <div class="col-md-12">
                  <div class="pagination-box hidden-mb-45 text-center">
                  </br>
                     <div class="loadMore">
                     <div id="loading" class="hideBtn">
                        <img id="loading-image" src="img/loading.gif" alt="Loading..." />
                     </div>  
                     <div align="center" id="loadbtndv">
                        <button id="loadBtn" class="load-more btn btn-outline-dark bomd mt30 hideBtn" data-totalResult="">Load More</button>
                     </div>
                     <div id="noData" class="hideBtn">
                        No result found!
                     </div>
                     </div>
                  </div>
            </div>
         </div>

</div>
<input type="hidden" name="company_id" id="company_id" value="{{ Session::get('company_id') }}">
<div class="modal fade" tabindex="-1" role="dialog" id="buy-modal">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content mdc">
         <form method="POST"  enctype="multipart/form-data" id="buyForm">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="modal-header mdh">
               <h5 class="modal-title mdh2">Buy Now</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="30" height="30">
                     <path d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                  </svg>
               </button>
            </div>
            <div class="modal-body mdb buyModal">
               <p>
              Do you want to purchase this course?
               </p>
               
            </div>
            <div class="modal-footer">
               <div class="col-md-4 px-2">
                  <button type="button" class="btn my-1 btn-danger btn-block" data-dismiss="modal">No</button>
               </div>
               <div class="col-md-4 px-2">
                  <button type="button" id="buyBtn" data-id="" data-price="" class="btn my-1 btn-success btn-block">Yes</button>
               </div>
               <input type="hidden" name="course_id" id="course_id" value="">
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="bid-modal">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content mdc">
         <form method="POST"  enctype="multipart/form-data" id="bidForm">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="modal-header mdh">
               <h5 class="modal-title mdh2">Bid Request Acknowledgement</h5> 
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="30" height="30">
                     <path d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"/>
                  </svg>
               </button>
            </div>
            <div class="modal-body mdb bidModal">
               <p>
                <label>Your bid request has been successfully submited.</label>
                {{-- <input type="text" id="bidding_price" name="bidding_price"  class="form-control form-control-lg"> --}}
               </p>
                <label id="bidding_price-error" class="error hide" for="employees">This field is required!</label>
            </div>
            <div class="modal-footer">
               {{-- <div class="col-md-4 px-2">
                  <button type="button" class="btn my-1 btn-danger btn-block" data-dismiss="modal">No</button>
               </div> --}}
               <div class="col-md-4 px-2">
                  <button type="button" id="bidBtn" data-id="" data-price="" class="btn my-1 btn-success btn-block">Close</button>
               </div>
               <input type="hidden" name="course_id" id="course_id" value="">
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="preview-modal">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content mdc">      
          <div id="preview-content"></div>         
      
      </div>
   </div>
</div>

@endsection
@section('additional_scripts')
<script src="{{asset('users/js/pages/form/extended/select2.js')}}"></script>
<script src="{{asset('users/vendor/select2/select2.full.min.js')}}"></script>
<script src="{{asset('users/vendor/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{ asset('js/common.js') }}"></script>

<script type="text/javascript">
$(document).ready( function () {
     get_departments('all','','course_department');
     get_departments('all','','employee_department');
     get_positions('all','','employee_position');
     get_projects('all','','employee_project');
     get_skills('all','','skills');
     get_occupations('all','','occupation');
     get_industries('all','','industry');
});

$("#course_department").change(function(){
   department = $(this).val();
   get_courses('department',department,'2','company_course');
});

function get_departments(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-departments-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

   function get_courses(whose,whose_id,type,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-courses-with-selected',
               data:{whose:whose,
               id:whose_id,
               type:type,
                _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   if(selected!=""){
                     var $newOption = $("<option></option>").val(item).text(text);
                     $("#"+where_id).append($newOption).trigger('change');
                   }
                 })
               }
      });
   }

   function get_positions(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-positions-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

   function get_projects(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-projects-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

   $(".getEmp").change(function(){
      departments = $("#employee_department").val();
      positions   = $("#employee_position").val();
      projects    = $("#employee_project").val();
      //$('#employees').empty();
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-employee-with-filters',
               data:{departments:departments,
                     positions:positions,
                     projects:projects,
                     _token: '{{csrf_token()}}'},
               success: function(response){
                  $('#employees').empty();
                  if(response.optn_values){
                   var $newOption = $("<option ></option>").val('all').text('Select All');
                   $("#employees").append($newOption).trigger('change');
                  }
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#employees").append($newOption).trigger('change');
                 })
               }
      });
   });

   $('#employees').on("select2:select", function (e) { 
      var data = e.params.data.text;
      if(data=='Select All'){
         $("#employees > option").prop("selected","selected");
         $("#employees").trigger("change");
      }
      $("#employees-error").addClass('hide');
      $("#employees").removeClass('error');
   });

   $("#companCourse_id").change(function(){
      $("#company-error").addClass('hide');
      $("#companCourse_id").removeClass('error');
   });

      
   function get_skills(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-skills-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

   function get_occupations(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-occupations-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }

   function get_industries(whose,whose_id,where_id){
      $.ajax({
               type: "POST",
               url: COMPANY_URL+'get-industries-with-selected',
               data:{whose:whose,id:whose_id, _token: '{{csrf_token()}}'},
               success: function(response){
                 $('#'+where_id).empty();
                 response.optn_values&&response.optn_values.map((item, idx) =>{
                   var text = response.optn_text[idx];
                   var selected = response.optn_selects[idx];
                   var $newOption = $("<option "+selected+"></option>").val(item).text(text);
                   $("#"+where_id).append($newOption).trigger('change');
                 })
               }
      });
   }
   

   function showBuyModal(thisObj){
      company_course = $("#companCourse_id").val();
      employees = $("#employees").val();
      flag = 0;
      if(!company_course){
         flag = 1;
         $("#company-error").removeClass('hide');
         $("#companCourse_id").addClass('error');
      }
      if(employees==""){
         flag = 1;
         $("#employees-error").removeClass('hide');
         $("#employees").addClass('error');
      }
      if(flag == 0){
         purchase_course_id = $(thisObj).attr('data-id');
         unit_price = $(thisObj).attr('data-price');
         $("#buyBtn").attr('data-id',purchase_course_id);
         $("#buyBtn").attr('data-price',unit_price);
         $('#buy-modal').modal('show');
      }else{
         $('html, body').animate({
            scrollTop: $("#hedn").offset().top
         }, 500);
      }
   }

   $("#buyBtn").click(function(){
         company_course = $("#companCourse_id").val();
         employees      = $("#employees").val();
         purchase_course_id =  $("#buyBtn").attr('data-id');
         unit_price =  $("#buyBtn").attr('data-price');

         $.ajax({
               type: "POST",
               url: COMPANY_URL+'save-purchase-course-relation',
               data:{company_course:company_course,
                     employees:employees,
                     purchase_course_id:purchase_course_id,
                     unit_price:unit_price,
                     _token: '{{csrf_token()}}'},
               success: function(response){
                  if(response){
                     setCookie('temp_course_id', response.id, 1);
                     setCookie('unit_price', response.unit_price, 1);
                     setCookie('quantity', response.course_quantity, 1);
                     window.location.href = COMPANY_URL+'course-payment';
                  }
               }
         });
   });
</script>
{{-- SEARCH FUNCTIONALITIES --}}
<script type="text/javascript">
   $(function () {
     $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
 
     $("#searchBtn").on('click',function(){
       $("#skip").val(0);
       $("#searchResult").html("");
       searchResult();
     });
 
     $("#loadBtn").on('click',function(){
      searchResult();
     });
 
   });
 
   function searchResult(){
     var formData = new FormData($("#searchForm")[0]);
     var skip = $("#skip").val();
     skip = Number(skip);
 
     $("#loading").addClass("showBtn");
     $("#noData").addClass("hideBtn");
     $("#loadBtn").addClass("hideBtn");
 
     $.ajax({
       type: "POST",
       url: COMPANY_URL+'search-course-items',
       data:formData,
       async: true,
       cache: false,
       contentType: false,
       processData: false,
       success: function(response){
         if(response){
           $("#loading").removeClass("showBtn");
           $("#searchResult").append(response);
           skip = skip+6;
           $("#skip").val(skip);
 
           $("#loadBtn").removeClass("hideBtn");
           $("#loadBtn").addClass("showBtn");
           $("#noData").removeClass("showBtn");
           $("#noData").addClass("hideBtn");
         }else{
           $("#loadBtn").removeClass("showBtn");
           $("#loadBtn").addClass("hideBtn");
           $("#noData").removeClass("hideBtn");
           $("#noData").addClass("showBtn");
         }
 
       }
     });
   }
 </script>

 {{-- Bidding script --}}
 <script type="text/javascript">
 function showBidModal(thisObj){
  //console.log(thisObj);
   course_id = $(thisObj).attr('data-id');
   $("#bidBtn").attr('data-id',course_id);
   employees = $("#employees").val();
    flag = 0;
      
      if(employees==""){
         flag = 1;
         $("#employees-error").removeClass('hide');
         $("#employees").addClass('error');
      }
   if(flag == 0){        
          $('#bid-modal').modal('show');
      }else{
         $('html, body').animate({
            scrollTop: $("#hedn").offset().top
         }, 500);
      }
  
 } 

  $("#bidBtn").click(function(){

           course_id =  $("#bidBtn").attr('data-id');
           company_id = $("#company_id").val();
           employees      = $("#employees").val();
           bidding_price      = $("#bidding_price").val();

           if(jQuery.inArray("all", employees) !== -1)
           {
            employeesCount = (employees.length)-1;
           }
           else
           {
            employeesCount = employees.length;
           }
           flg = 0;
          if(bidding_price==""){
           flag = 1;
          $("#bidding_price-error").removeClass('hide');
          $("#bidding_price").addClass('error');
         }

           
        else
        {
         $.ajax({
               type: "POST",
              url: COMPANY_URL+'save-bidding-price',
               data:{course_id:course_id,
                     company_id:company_id,
                     employeesCount:employeesCount,
                     bidding_price:bidding_price,
                     _token: '{{csrf_token()}}'},
               success: function(response){
                  if(response){
                      $('#bid-modal').modal('hide');
                  }
               }
         }); 
        }
         
   });
$("#searchBtn1").click(()=>{
 
   $('#bid-modal').modal('show');
})
</script>

@endsection