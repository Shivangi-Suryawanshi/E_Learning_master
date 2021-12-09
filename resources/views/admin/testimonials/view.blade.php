 @extends('admin.layout.cms-app')
@section('title','| Users')
@section('additional_styles')
<style>
        .required{color:#f00;}
   </style>

@endsection
@section('head_title')
Testimonial
@endsection
@section('content')
 
<!-- Content Header (Page header) -->
  <section class="content-header">
             <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{URL::to('/testimonials')}}">Testimonials</a></li>
               <li class="breadcrumb-item active">Edit</li>
          </ul>
        </div>
      </div>

    </section>

    <div class="box-body" style="margin-top:12px;">
            <div class="container-fluid">
                <div class="box-header">
                                        
                        <a href="{!! URL::to('testimonials') !!}" class="btn btn-primary pull-right">Back to Testimonials</a>
                  </div><!-- /.box-header -->
              </div>
        </div>

<!-- Main content -->
<section class="content section-padding">
       <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
             

                <div class="box">
                      
                    <div class="box-body common-spacing">
                        @if(Session::get('message'))
                    
                    <div class="alert alert-success msgalt">
                         <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>{!! Session::get('message') !!}
                                                 </div>
                        
                    @endif
                    @if($testimonial)
                        <div class="col-md-10 p-left-0">
                        <form role="form"  name="editDomain" enctype="multipart/form-data" action="{!! URL::to('gallery/edit/'.$testimonial->id) !!}" method="post" id="editDomain">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-3 p-3  bg-light"><b>Name (en)</b></div>
                                    <div class="col-sm-1 p-3  bg-light">:</div>
                                    <div class="col-sm-8 p-3  bg-light"> {!! $testimonial->title_en !!}</div>
                                </div>

                                         <div class="row">
                                    <div class="col-sm-3 p-3  bg-light"><b>Name (es)</b></div>
                                    <div class="col-sm-1 p-3  bg-light">:</div>
                                    <div class="col-sm-8 p-3  bg-light"> {!! $testimonial->title_es !!}</div>
                                </div>

                                         <div class="row">
                                    <div class="col-sm-3 p-3  bg-light"><b>Name (ar)</b></div>
                                    <div class="col-sm-1 p-3  bg-light">:</div>
                                    <div class="col-sm-8 p-3  bg-light"> {!! $testimonial->title_ar !!}</div>
                                </div>
                         
                                <div class="row">
                                    <div class="col-sm-3 p-3  bg-light"><b>Description (en)</b></div>
                                      <div class="col-sm-1 p-3  bg-light">:</div>
                                    <div class="col-sm-8 p-3  bg-light"> {!! $testimonial->description_en !!} </div>                                    
                                </div>
                                     <div class="row">
                                    <div class="col-sm-3 p-3  bg-light"><b>Description (es)</b></div>
                                      <div class="col-sm-1 p-3  bg-light">:</div>
                                    <div class="col-sm-8 p-3  bg-light"> {!! $testimonial->description_es !!} </div>                                    
                                </div>


     <div class="row">
                                    <div class="col-sm-3 p-3  bg-light"><b>Description (ar)</b></div>
                                      <div class="col-sm-1 p-3  bg-light">:</div>
                                    <div class="col-sm-8 p-3  bg-light"> {!! $testimonial->description_ar !!} </div>                                    
                                </div>


                                <div class="row">
                                    <div class="col-sm-3 p-3  bg-light"><b>Image</b></div>
                                      <div class="col-sm-1 p-3  bg-light">:</div>



                                  
                                 
                                   
                                   <img src="{!! asset('testimonial_images/'.$testimonial->img) !!}" height="200" width="200">
                                    <a style="cursor: pointer;" data-id="{{ $testimonial->id }}" onclick="myModal({{ $testimonial->id }})" id="thisuser"  class="thisuser" href="javascript:void(0);"  data-user=" {{ $testimonial->id }}" ><i class="far fa-trash-alt"></i></a>
                                                           
                                </div>

                                    
                               
                            </div><!-- /.box-body -->
                           
                        </form>
                        </div>
                        @else
                        No Content Available
                        @endif
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

              

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
                       <div class="modal fade mymodal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #d9534f;">
           <h4 class="modal-title" id="myModalLabel">Delete Testimonial</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Testimonial?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-outline" data-myval="" id="btn-yes" onclick="delTestimonialImg(this)">Yes</button>
                </div>
            </div>
        </div>
    </div>



    </section><!-- /.content -->


@endsection

@section('page-js')

  <script src="{{ asset('admin/js/includes/testimonial/testimonial.js')}}"></script>

<script>
  $(function() {

   $("form[name='editDomain']").validate({

    rules: {

     room_name: {
      required: true,
        },
    },
    // Specify validation error messages
    messages: {

     room_name: {
      required: "Please enter the room type",
      
    },
   
  
  },

  submitHandler: function(form) {
    form.submit();
  }
});
 });
</script>
@endsection