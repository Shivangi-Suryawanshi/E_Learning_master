@extends('layouts.admin')
@section('title','| Users')
@section('additional_styles')
@endsection
@section('head_title')
Pages
@endsection
@section('content')
<link rel="stylesheet" href="{!! asset('admin/css/jquery.ui.autocomplete.css') !!}" />
  <link rel="stylesheet" href="{!! asset('redactor/redactor.css') !!}" />
 <link rel="stylesheet" href="{!! asset('redactor/plugins/filemanager/filemanager.css') !!}" />
<!-- Content Header (Page header) -->
<section class="content-header">
   <div class="breadcrumb-holder">
    <div class="container-fluid">
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{URL::to('/pages')}}">Pages</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ul>
</div>
</div>

</section>
<div class="box-body" style="margin-top:12px;">
    <div class="container-fluid">
        <div class="box-header">

            <a href="{!! URL::to('admin/home-page-sections') !!}" class="btn btn-primary pull-right">Back to Pages</a>
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
                 
                   <div class="col-md-12 p-left-0 page-dtl">     
                    <form action="{!! URL::to('admin/home-page-sections/view/'.$data->id) !!}" method="post">
                        <input type="hidden" name="_token" value="{!! Session::token() !!}"> 
                        
                        <div class="form-group @if($errors->first('title')) has-error @endif">

                            <label class="rtl">Title (English)</label>

                                <input type="text" name="title_en" id="page_title_en" class="form-control" placeholder="Enter Title" value="{!! $data->title_en !!}">
                                <span class="help-block required">{{$errors->first('title_en')}}</span>

                            </div><!-- /.box-header -->


                          <div class="form-group @if($errors->first('title')) has-error @endif">

                            <label class="rtl">Title (Arabic)</label>

                                <input type="text" name="title_ar" id="page_title_ar" class="form-control" placeholder="Enter Title" value="{!! $data->title_ar !!}">
                                <span class="help-block required">{{$errors->first('title_ar')}}</span>

                            </div><!-- /.box-header -->


                          
                                        <div class="form-group">

                                            <label class="rtl">Status</label>

                                                <select name="select_status" id="select_status" class="form-control">
                                                   <option value="1" @if($data->status==1) {!!'selected'!!} @endif>Active</option>
                                                   <option value="0" @if($data->status==0) {!!'selected'!!} @endif>Inactive</option>
                                               </select>

                                           </div><!-- /.box-header -->

                                           <div class="box-header">
                                         
                                           <div class="box-footer sub-btn">
                                                <button type="submit" class="pull-right btn btn-primary margin-top" value="update" name="update">Update</button>
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

         {{-- <script src="{{ asset('tinymce/tinymce.min.js')}}"></script>
<script src="{{ asset('tinymce/default.js')}}"></script> --}}


           
<script src="{{ asset('redactor/redactor.js')}}"></script>
<script src="{{ asset('redactor/plugins/table/table.js')}}"></script>
<script src="{{ asset('redactor/plugins/table/table.min.js')}}"></script>
<script src="{{ asset('redactor/plugins/filemanager/filemanager.js')}}"></script> 
<script src="{{ asset('redactor/plugins/imagemanager/imagemanager.js')}}"></script> 


<script>
 
   $R('#mytextarea', {
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
 
   $R('#mytextarea_2', {
     replaceTags: false,
    plugins: ['filemanager','table','imagemanager'],
   // fileUpload: '{!! asset('redactor/scripts/file_upload.php')!!}',
  //  fileManagerJson: '/your-folder/files.json' ,
    imageUpload: '{!! asset('redactor/scripts/image_upload.php')!!}',
 //   imageManagerJson: '/your-folder/images.json',
    lang: 'ar' ,
  });
</script>
           

            <!-- place in header of your html document -->
            <script>

              $(function(){

                 $('#page_title').focusout(function(){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{!! URL::to('pages/url-slug') !!}",
                        type: 'POST',
                        data: { title : $(this).val() },
                        success: function (data)
                        {
                           $('#url_slug').val(data);
                       }
                   });	
                });

			// Close Alert Message : start

           setTimeout(function(){ 

              $('.clsAlert').fadeOut();

          }, 4000);

           $('.fa-close').click(function(){

              $('.clsAlert').fadeOut();

          });

	        // Close Alert Message : end

      });

  </script>
 
@endsection