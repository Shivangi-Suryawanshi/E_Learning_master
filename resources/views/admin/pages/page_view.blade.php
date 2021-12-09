@extends('layouts.admin')
@section('title','| Users')
@section('page-css')
@endsection
@section('head_title')
Pages
@endsection
@section('content')


  <link rel="stylesheet" href="{!! asset('assets/redactor/redactor.css') !!}" />
 <link rel="stylesheet" href="{!! asset('assets/redactor/plugins/filemanager/filemanager.css') !!}" />
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
                    <form action="{!! URL::to('admin/pages/pages/view/'.$data->id) !!}" method="post" enctype="multipart/form-data">
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
                             
                            @if($data->slug=='about-us' || $data->slug=='company-landing' || $data->slug=='training-centre-landing' || $data->slug=='trainer-landing' || $data->slug=='individual-user-landing')
                            
                            @if($data->getImages() && count($data->getImages()->get())>0)
                            <div class="row">
                            @foreach($data->getImages()->get() as $key => $ps_img)
                                                <div class="form-group col-md-3">
                                <label>Image {{ $key+1 }}</label>
                                {{-- {!! image_upload_form('photo', $user->photo) !!} --}}
                                <div class="choose-img-div">
                                   <img class="profile_pic" name="profile_pic" id="profile_pic{{$key}}"  width="150" height="auto" src="@if($ps_img->img) {!! asset('assets/page_images/'.$ps_img->img) !!} @else {!! asset('assets/images/placeholder-image.png') !!} @endif">
                                  <input type="file" name="profile_file[]" id="profile_file{{$key}}" class="profile_file" accept="image/*" capture style="display:none">
                                  <img src="{!! asset('assets/images/file_choose.png') !!}" id="upfile1{{$key}}" data-id = "{{$key}}" class="choose-img" style="cursor:pointer" title="Change Profile Picture" />
                               </div>
                            </div>
                            @endforeach
                            </div>
                            @endif



                            @if($data->getContent() && count($data->getContent()->get())>0)

                          @foreach($data->getContent()->get() as $key => $ps)
                           <div class="row">
                             
                            <div class="col-md-6">

                            <div class="form-group editor_height @if($errors->first('content')) has-error @endif">

                                <label class="rtl">Content (English)</label>
                            

                                    <textarea name="content_en[]" class="form-control" id="mytextarea">{!! $ps->content_en !!}</textarea>

                                    <span class="help-block required">{{$errors->first('content_en')}}</span>

                                      
                                </div><!-- /.box-header -->

                            </div>
                            <div class="col-md-6">
                            <div class="form-group editor_height @if($errors->first('content_ar')) has-error @endif">

                                <label class="rtl">Content (Arabic)</label>


                                    <textarea name="content_ar[]" class="form-control" id="mytextarea_2">{!! $ps->content_ar !!}</textarea>

                                    <span class="help-block required">{{$errors->first('content_ar')}}</span>


                                </div><!-- /.box-header -->
                            </div>
                           </div>
                           @endforeach
                           @endif
                                @else 




                                 @if($data->getContent() && count($data->getContent()->get())>0)

                          @foreach($data->getContent()->get() as $key => $ps)
                           <div class="row">
                             
                            <div class="col-md-6">

                            <div class="form-group editor_height @if($errors->first('content')) has-error @endif">

                                <label class="rtl">Content (English)</label>
                            

                                    <textarea name="content_en[]" class="form-control" id="mytextarea">{!! $ps->content_en !!}</textarea>

                                    <span class="help-block required">{{$errors->first('content_en')}}</span>

                                      
                                </div><!-- /.box-header -->

                            </div>
                            <div class="col-md-6">
                            <div class="form-group editor_height @if($errors->first('content_ar')) has-error @endif">

                                <label class="rtl">Content (Arabic)</label>


                                    <textarea name="content_ar[]" class="form-control" id="mytextarea_2">{!! $ps->content_ar !!}</textarea>

                                    <span class="help-block required">{{$errors->first('content_ar')}}</span>


                                </div><!-- /.box-header -->
                            </div>
                           </div>
                           @endforeach

                          @else

    

<div class="row">
                             
                            <div class="col-md-6">

                            <div class="form-group editor_height @if($errors->first('content')) has-error @endif">

                                <label class="rtl">Content (English)</label>
                            

                                    <textarea name="content_en[]" class="form-control" id="mytextarea"></textarea>

                                    <span class="help-block required">{{$errors->first('content_en')}}</span>

                                      
                                </div><!-- /.box-header -->

                            </div>
                            <div class="col-md-6">
                            <div class="form-group editor_height @if($errors->first('content_ar')) has-error @endif">

                                <label class="rtl">Content (Arabic)</label>


                                    <textarea name="content_ar[]" class="form-control" id="mytextarea_2"></textarea>

                                    <span class="help-block required">{{$errors->first('content_ar')}}</span>


                                </div><!-- /.box-header -->
                            </div>
                           </div>

                            @endif


                                

                                @endif


                                <div class="form-group">

                                    <label class="rtl">Meta Key</label>

                                        <input type="text" name="meta_key" class="form-control" placeholder="Enter Meta Key" value="{!! $data->meta_key !!}">
                                        
                                    </div><!-- /.box-header -->
                                    <div class="form-group">

                                        <label class="rtl">Meta Description</label>

                                            <textarea name="meta_desc" class="form-control" placeholder="Enter meta description">{!! $data->meta_description !!}</textarea>
                                            
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


           
<script src="{{ asset('assets/redactor/redactor.js')}}"></script>
<script src="{{ asset('assets/redactor/plugins/table/table.js')}}"></script>
<script src="{{ asset('assets/redactor/plugins/table/table.min.js')}}"></script>
<script src="{{ asset('assets/redactor/plugins/filemanager/filemanager.js')}}"></script> 
<script src="{{ asset('assets/redactor/plugins/imagemanager/imagemanager.js')}}"></script> 


<script>
 
   $R('#mytextarea', {
     replaceTags: false,
    //plugins: ['filemanager','table','imagemanager'],
   // fileUpload: '{!! asset('redactor/scripts/file_upload.php')!!}',
  //  fileManagerJson: '/your-folder/files.json' ,
  //  imageUpload: '{!! asset('assets/redactor/scripts/image_upload.php')!!}',
 //   imageManagerJson: '/your-folder/images.json',
    lang: 'en' ,
  });
</script>


<script>
 
   $R('#mytextarea_2', {
     replaceTags: false,
   // plugins: ['filemanager','table','imagemanager'],
   // fileUpload: '{!! asset('redactor/scripts/file_upload.php')!!}',
  //  fileManagerJson: '/your-folder/files.json' ,
   // imageUpload: '{!! asset('assets/redactor/scripts/image_upload.php')!!}',
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

    @if($data->getImages() && count($data->getImages()->get())>0)
    @foreach($data->getImages()->get() as $key => $ps_img)
<script>
  var keys = '';
     $("#upfile1{{$key}}").click(function () {
       keys = $(this).data('id');
//  alert(keys);
      $("#profile_file{{$key}}").trigger('click');
    });


    $("#profile_file{{$key}}").change(function(){
      readURL(this);
    });
   
    function readURL(input) {

      if (input.files && input.files[0]) {
        // console.log(input.files[0]);
        var reader = new FileReader();
  
        reader.onload = function (e) {
          console.log(keys);
          $('#profile_pic' + keys).attr('src', e.target.result);

        }
  

        reader.readAsDataURL(input.files[0]);
      }
    }
   
  </script>

  @endforeach
  @endif
 
@endsection