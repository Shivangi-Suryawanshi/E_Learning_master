@extends('layouts.admin')
<link rel="stylesheet" href="{!! asset('redactor/redactor.css') !!}" />
 <link rel="stylesheet" href="{!! asset('redactor/plugins/filemanager/filemanager.css') !!}" />
@section('content')

 <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
<!-- Content Header (Page header) -->
<section class="content-header">
 <div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{URL::to('/testimonials')}}">Testimonials</a></li>
      <li class="breadcrumb-item active">Create</li>
    </ul>
  </div>
</div>

</section>


<div class="box-body" style="margin-top:12px;">
  <div class="container-fluid">
    <div class="box-header">

      <a href="{!! URL::to('admin/testimonials') !!}" class="btn btn-primary pull-right">Back to Testimonials</a>
    </div><!-- /.box-header -->
  </div>
</div>

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
           <div class="col-md-8 p-left-0">
            <form role="form" name="addtestimonial" method="post" enctype="multipart/form-data" action="{!! URL::to('admin/testimonials/edit/'.$testimonials->id) !!}" method="post">
              <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
              <div class="box-body">

                 <div class="form-group @if($errors->first('name_en')) has-error @endif">
                  <label for="name" class="rtl">Name (en)</label>
                  <input type="text" name="name_en" class="form-control rtl basic-usage" id="name_en" placeholder="Enter the Name" value="{!! $testimonials->title_en !!}">
                  <span class="help-block required">{{$errors->first('name_en')}}</span>
                </div>

                <div class="form-group @if($errors->first('description_en')) has-error @endif editor_height">
                  <label for="description_en" class="rtl">Content (en) </label>
                  <textarea name="description_en" class="form-control rtl basic-usage" id="content_en" >{!! $testimonials->description_en !!}</textarea>
                  <span class="help-block required">{{$errors->first('description_en')}}</span>
                </div>    

                 
                  <div class="form-group @if($errors->first('name_ar')) has-error @endif">
                  <label for="name_ar" class="rtl">Name (ar)</label>
                  <input type="text" name="name_ar" class="form-control rtl basic-usage" id="name_ar" placeholder="Enter the Name" value="{!! $testimonials->title_ar !!}">
                  <span class="help-block required">{{$errors->first('name_ar')}}</span>
                </div>

                <div class="form-group @if($errors->first('description_ar')) has-error @endif editor_height">
                  <label for="description_ar" class="rtl">Content (ar) </label>
                  <textarea name="description_ar" class="form-control rtl basic-usage" id="content_ar" >{!! $testimonials->description_ar !!}</textarea>
                  <span class="help-block required">{{$errors->first('description_ar')}}</span>
                </div>  

                     <div class="form-group @if($errors->first('position_en')) has-error @endif">
                  <label for="name" class="rtl">Position (en)</label>
                  <input type="text" name="position_en" class="form-control rtl basic-usage" id="position_en" placeholder="Enter the Name" value="{!! $testimonials->position_en !!}">
                  <span class="help-block required">{{$errors->first('position_en')}}</span>
                </div>

                     <div class="form-group @if($errors->first('position_ar')) has-error @endif">
                  <label for="name" class="rtl">Position (ar)</label>
                  <input type="text" name="position_ar" class="form-control rtl basic-usage" id="position_ar" placeholder="Enter the Name" value="{!! $testimonials->position_ar !!}">
                  <span class="help-block required">{{$errors->first('position_ar')}}</span>
                </div>           


                <div class="row">
                                                      
                            <div class="edit-profile-photo mt1015" style="margin-bottom: 100px;">

                <img class="profile_pic" name="profile_pic" id="profile_pic" src="@if($testimonials->img){!! asset('testimonial_images/'.$testimonials->img) !!} @else {{ asset('images/noimage.jpg') }} @endif" width="300" height="auto">



                <div class="change-photo-btn">

                  <div class="contact-form__upload-btn xs-left">


                    <input type="file" name="profile_file" id="profile_file" class="profile_file form-textbox" accept="image/*" capture style="display:none">


                    <span id="upfile1" class="btn btn-primary">Upload photo</span>


                  </div>
                </div>
              </div>
                           </div>
                
              </div><!-- /.box-body -->

              <div class="box-footer sub-btn">
                <button type="submit" class="btn btn-primary" >Submit</button>
              </div>

            </form>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
</section><!-- /.content -->


@endsection

@section('page-js')

<script>
    $("#profile_file").change(function(){
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile_pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#upfile1").click(function () {
        $("#profile_file").trigger('click');
    });
</script>

<script src="{{ asset('redactor/redactor.js')}}"></script>
<script src="{{ asset('redactor/plugins/table/table.js')}}"></script>
<script src="{{ asset('redactor/plugins/table/table.min.js')}}"></script>
<script src="{{ asset('redactor/plugins/filemanager/filemanager.js')}}"></script> 
<script src="{{ asset('redactor/plugins/imagemanager/imagemanager.js')}}"></script> 


<script>
 
   $R('#content_en', {
     replaceTags: false,
    plugins: ['filemanager','table','imagemanager'],
   // fileUpload: '{!! asset('redactor/scripts/file_upload.php')!!}',
  //  fileManagerJson: '/your-folder/files.json' ,
    imageUpload: '{!! asset('redactor/scripts/image_upload.php')!!}',
 //   imageManagerJson: '/your-folder/images.json',
    lang: 'en' ,
  });
</script>


<script>
 
   $R('#content_ar', {
     replaceTags: false,
    plugins: ['filemanager','table','imagemanager'],
   // fileUpload: '{!! asset('redactor/scripts/file_upload.php')!!}',
  //  fileManagerJson: '/your-folder/files.json' ,
    imageUpload: '{!! asset('redactor/scripts/image_upload.php')!!}',
 //   imageManagerJson: '/your-folder/images.json',
    lang: 'ar' ,
  });
</script>
@endsection
