@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('css/jquery.rateyo.min.css') }}">


        <!-- Search Box Layout -->
        <div class="search-overlay">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    
                    <div class="search-overlay-close">
                        <span class="search-overlay-close-line"></span>
                        <span class="search-overlay-close-line"></span>
                    </div>

                    <div class="search-overlay-form">
                        <form>
                            <input type="text" class="input-search" placeholder="Search here...">
                            <button type="submit"><i class='bx bx-search-alt'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Box Layout -->

  

        <!-- Start Courses Area -->
        <section class="courses-area ptb-1100">
            <div class="container">

               <div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="about-text">
                                <h3>100,000 online courses</h3>
                                <br>
                                </div>
                                </div>
                                </div>
                                </div>


                <div class="courses-topbar">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2">
                              <div class="topbar-ordering">
                                            <select name="listing_type" id="listing_type" class="listing_type">
                                                <option value="">Select</option>
                                                <option value="free">Free listing</option>
                                                <option value="paid">Paid listing</option>                           
                                            </select>
                                        </div>
                          
                        </div>

                           <div class="col-lg-3 col-md-3">
                              <div class="topbar-ordering">
                                            <select name="listing_variation" id="listing_variation" class="listing_variation">
                                                <option value="">Select</option>
                                                <option value="popular">Most Popular</option>
                                                <option value="high_rated">Highest Rated</option>
                                                <option value="newest">Newest</option>                          
                                            </select>
                                        </div>
                          
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="topbar-ordering-and-search">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="topbar-search">
                                            <form>
                                               <label><i class="bx bx-search"></i></label>
                                                <input type="text" class="input-search" id="search_text" name="keyword" placeholder="Search here..." value="@if(\Request::get('keyword')){{ \Request::get('keyword') }}@endif">
                                                </form>
                                            </div>
                                    </div>
                                    <div class="col-lg-3 col-md-5 offset-lg-4 offset-md-1">
                                         <div class="topbar-result-count">
                                             <row>
                                <p id="resultCount">{!! $count !!}  results</p> </row>
                            </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="row">
                      <div class="col-lg-3 col-md-12">
                        <aside class="widget-area">
 

                            <!------------------------------>
                           <div class="faq-accordion">
                                <ul class="accordion">

                                      <li class="accordion-item">
                                        <a class="accordion-title active" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Languages
                                        </a>
                                     
                                        <div class="accordion-content show">
                                            @foreach($all_languages as $language)
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input lang_class" @if(\Request::get('selLan') && in_array($language->id, \Request::get('selLan'))) checked @endif name="selLan[]" value="{{ $language->id }}"> 
                                     <label class="form-check-label" for="create-an-account"> {!! $language->language !!}</label>
                                        </div>
                                        @endforeach
{{-- 
                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> Arabic</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> French</label>
                                        </div> --}}

                                        </div>
                                    </li>

                                    {{--  <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                           Video Duration
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> 0-2 Hours (220)</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> 3-6 Hours (140)</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> 6+ Hours (300)</label>
                                        </div>

                                        </div>
                                    </li> --}}


                                      <li class="accordion-item">
                                        <a class="accordion-title mb10" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Rating
                                        </a>
         
                                        <div class="accordion-content">
                                             <label class="mb0" style="width: 100%;">
                                             <input type="radio" name="rating_stars" class="rating_class" value="4"> <div class="review-stars-rated filterr">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                       
                                                       <div> 4 Star & Up </div>
                                                    </div>

                                             <span class="checkmark"></span>
                                            </label>

                                           <label class="mb0" style="width: 100%;">
                                             <input type="radio" name="rating_stars" class="rating_class" value="3"> <div class="review-stars-rated filterr">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                                       
                                                       
                                                       <div> 3 Star & Up </div>
                                                    </div>

                                             <span class="checkmark"></span>
                                            </label>

                                             <label class="mb0" style="width: 100%;">
                                             <input type="radio" name="rating_stars" class="rating_class" value="2"> <div class="review-stars-rated filterr">
                                                        <i class='bx bxs-star'></i>
                                                        <i class='bx bxs-star'></i>
                                          
                                                       
                                                       <div> 2 Star & Up </div>
                                                    </div>

                                             <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </li>


                                    <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Price
                                        </a>
        
                                        <div class="accordion-content">
                                        <div>
                                        <input type="radio" id="direct-bank-transfer" class="price_class" name="radio-group" value="1" @if(\Request::get('price')==1) checked @endif>
                                            <label for="direct-bank-transfer"> &nbsp;$1- $50</label>
                                        </div>

                                           <div>
                                        <input type="radio" id="id2" name="radio-group" class="price_class" value="2" @if(\Request::get('price')==2) checked @endif>
                                            <label for="direct-bank-transfer"> &nbsp;$51-$100 </label>
                                        </div>
                                            
                                    

                                        <div>
                                             <input type="radio" id="paypal" name="radio-group" value="3" class="price_class" @if(\Request::get('price')==3) checked @endif>
                                            <label for="paypal">&nbsp;Free</label>
                                        </div>
                                        </div>
                                    </li>

                                  
                                 
                                  

                                     <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            Skills
                                        </a>
        
                                        <div class="accordion-content">
                                             @foreach($skills as $skill)
                                           <div class="form-check mb10">
                                            <input type="checkbox" name="skills[]" @if(\Request::get('skills') && in_array($skill->id, \Request::get('skills'))) checked @endif class="form-check-input skill_class" value="{{ $skill->id }}">
                                     <label class="form-check-label" for="create-an-account"> {!! $skill->skill !!}</label>
                                        </div>
                                        @endforeach

                                        {{-- <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> Skills 2</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> Skills 3</label>
                                        </div> --}}

                                        </div>
                                    </li>



                                     <li class="accordion-item">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                           Learning Approach
                                        </a>
        
                                        <div class="accordion-content">
                                           <div class="form-check mb10">
                                            <input type="checkbox" name="learning_approach[]" class="form-check-input learning_class" @if(\Request::get('learning_approach') && in_array(2, \Request::get('learning_approach'))) checked @endif value="2">
                                     <label class="form-check-label" for="create-an-account"> Face to Face</label>
                                        </div>

                                        <div class="form-check mb10">
                                            <input type="checkbox" name="learning_approach[]" class="form-check-input learning_class" @if(\Request::get('learning_approach') && in_array(1, \Request::get('learning_approach'))) checked @endif value="1">
                                    <label class="form-check-label" for="create-an-account"> Pre Recorded Videos</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" name="learning_approach[]" class="form-check-input learning_class" @if(\Request::get('learning_approach') && in_array(3, \Request::get('learning_approach'))) checked @endif value="3">
                                     <label class="form-check-label" for="create-an-account"> Online Conferencing Call</label>
                                        </div>

                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-------------------------------->


                        </aside>
                    </div>


                    <div class="col-lg-9 col-md-12">
                        <div class="row" id="tag_container">

                            @include('pages.course_render')
        
                         
                        </div>
                    </div>

                  
                </div>
            </div>
            
        </section>
        <!-- End Courses Area -->
        <!-- End Become Instructor & Partner Area -->
@endsection
@section('additional_scripts')
<script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
<script src="{{ asset('js/jquery.rateyo.js')}}"></script>
<script>  

    $(document).ready(function () {
    $('input[type="checkbox"]').on('change', function (e) {
        var data = [],
            loc = $('<a>', { href: window.location })[0];
        $('input[type="checkbox"]').each(function (i) {
            if (this.checked) {
                data.push(this.name + '=' + this.value);
            }            
        });
        if($('#search_text').val()!='')
            {
                data.push('keyword=' + $('#search_text').val());
            }
        data = data.join('&');
        //console.log(data);
         fetchData(data);

         $.get('/courses-listing', data);
        if (history.pushState) {
            history.pushState(null, null, loc.pathname + '?' + data);
        }
    });


      $('#search_text').on('keyup keydown blur', function(event) {
          var data = [];
           loc = $('<a>', { href: window.location })[0];
            $('input[type="checkbox"]').each(function (i) {
            if (this.checked) {
                data.push(this.name + '=' + this.value);
            }            
        });

          if($('#search_text').val()!='')
            {
                data.push('keyword=' + $('#search_text').val());
            }
            data = data.join('&');
           $.get('/courses-listing', data);
            console.log(data);
             if (history.pushState) {
            history.pushState(null, null, loc.pathname + '?' + data);
        }
       fetchData();
        });

            $('.listing_type').change(function(){  
           
            fetchData();
           
      });

       $('.price_class').click(function(){  
           
         fetchData();
           
      });  

       $('.rating_class').click(function(){  
           
         fetchData();
           
      });  

        $('.skill_class').click(function(){  
            
        //fetchData();
           
      }); 

         $('.learning_class').click(function(){  
            
       // fetchData();
           
      }); 
          $('.lang_class').click(function(){  
            
       //fetchData();
           
      }); 
 });  

 function fetchData(request)
 {
     //console.log($('.skill_class:checkbox:checked'));

             var skills = [];
            $.each($('.skill_class:checkbox:checked'), function(){
                skills.push($(this).val());
            });


             var learning_approach = [];
            $.each($('.learning_class:checkbox:checked'), function(){
                learning_approach.push($(this).val());
            });

             var selLan = [];
            $.each($('.lang_class:checkbox:checked'), function(){
                selLan.push($(this).val());
            });

       

         var price = '';
           if($("input:radio.price_class:checked").val())
         {
           price = $("input:radio.price_class:checked").val();
         }
          var rating = '';
           if($("input:radio.rating_class:checked").val())
         {
           rating = $("input:radio.rating_class:checked").val();
         }
           var keyword = '';
           if(request)
           {
            keyword = request.term;
           }
           if($('#search_text').val()!='')
           {
            keyword = $('#search_text').val();
           }

           var list_type = '';

                if($('#listing_type').val()!='')
           {
            list_type = $('#listing_type').val();           
           }

                var listing_variation = '';

                if($('#listing_variation').val()!='')
           {
            listing_variation = $('#listing_variation').val();           
           }


     $.ajax({  
                url:"{{ url('/courses-listing') }}",  
                method:"get",  
                data:{
                    price:price,
                    keyword:keyword,
                   skills:skills,
                   learning_approach:learning_approach,
                   selLan:selLan,
                    rating:rating,
                    list_type:list_type,
                    listing_variation:listing_variation
                   },  
                success:function(data){  
                     // console.log(data);
                    $("#resultCount").text(data.count+' '+'results');

                     $('#tag_container').html(data.html);  
                     var demoRatings = data.allRatings,
                    stars  = $('.rateYo');

                    for (var i = 0; i < stars.length; i++) {
                      $('.rateYo').eq(i).rateYo({ // select by index as an example
                        halfStar: true,
                        starWidth: "20px",
                        rating: demoRatings[i],
                       //rating:2,
                        readOnly: true
                      });
                    }
                    //  var url = $(this).attr('href');
                //  window.history.pushState("", "", url);

                      // window.history.pushState('', '', '?keyword='+keyword+'&price='+price);
                }  
           }); 
 }
 </script>  
 <script type="text/javascript">
  

    
    $(document).ready(function()
    {

                    var demoRatings = {{ json_encode($allRatings) }},
                    stars  = $('.rateYo');

                    for (var i = 0; i < stars.length; i++) {
                      $('.rateYo').eq(i).rateYo({ // select by index as an example
                        halfStar: true,
                        starWidth: "20px",
                        rating: demoRatings[i],
                        readOnly: true
                      });
                    }
        
        $(document).on('click', '.pagination a',function(event)
        {
            
            window.scrollTo({top: 0, behavior: 'smooth'});
            getData($(this).attr('href').split('page=')[1]);
            event.preventDefault();
        });

  
    });
  
    function getData(page){
         //console.log($("input:radio.price_class:checked").val());
             var favorite = [];
            $.each($('.skill_class:checkbox:checked'), function(){
                favorite.push($(this).val());
            });
            //alert(favorite);

         var price = '';
           if($("input:radio.price_class:checked").val())
         {
           price = $("input:radio.price_class:checked").val();
         }
            var keyword= '';
           if($('#search_text').val()!='')
           {
            keyword = $('#search_text').val();
           }
             var learning = [];
            $.each($('.learning_class:checkbox:checked'), function(){
                learning.push($(this).val());
            });

              var langs = [];
            $.each($('.lang_class:checkbox:checked'), function(){
                langs.push($(this).val());
            });  
          var rating = '';
           if($("input:radio.rating_class:checked").val())
         {
           rating = $("input:radio.rating_class:checked").val();
         }

        $.ajax(
        {
            url: '?page=' + page,
            type: "get",
            data:{
                price:price,
                keyword:keyword,
                favorite:favorite,
                learning:learning,
                langs:langs,
                rating:rating,
                },
            datatype: "html"
        }).done(function(data){
           
            // console.log(data.courses.data[i].avg_p);
           var keyword = '';
           if($('#search_text').val()!='')
           {
            keyword = $('#search_text').val();
           }
            $("#tag_container").empty().html(data.html);
            var demoRatings = data.allRatings,
                    stars  = $('.rateYo');
// console.log(stars);
                    for (var i = 0; i < data.courses.data.length; i++) {

            if(data.courses.data[i].avg_p){
                        $('.rateYo').eq(i).rateYo({ 
                        halfStar: true,
                        starWidth: "20px",
                        rating: data.courses.data[i].avg_p,
                        readOnly: true
                      });
                
            }
            else{
                        $('.rateYo').eq(i).rateYo({ 
                        halfStar: true,
                        starWidth: "20px",
                        rating: 0,
                        readOnly: true
                      });
            }


                    }
           // location.hash = page;
                // var url = $(this).attr('href');
                //  window.history.pushState("", "", url);
                   //  window.history.pushState('', '', '?keyword='+keyword);

        }).fail(function(jqXHR, ajaxOptions, thrownError){
              alert('No response from server');
        });
    }
</script>
 @endsection