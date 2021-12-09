@extends(theme('dashboard.layouts.dashboard'))

 @section('page-css')
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 

  <link rel="stylesheet" href="{!! asset('redactor/redactor.css') !!}" />
 <link rel="stylesheet" href="{!! asset('redactor/plugins/filemanager/filemanager.css') !!}" />
@endsectio -->

@section('content')
<style>
    .mb15{margin-bottom:15px;}
    .mt20{margin-top:20px;}
</style>
<div  id="app">
    <main class="">


       <div class="container">
           <br>
        <div class="app-title row">
            <div class="col-md-10">
                <h1><i class="fa fa-plus-circle"></i> Create Free Resource</h1>

            </div>

            <div class="col-md-2">
            <a class="btn btn-primary" href="{{url('/dashboard/free-resources')}}"><i class="fa fa-list"></i> Free resources Lists</a>
            </div>
        </div>
        </div>


            <div class="alert alert-success msgalt" id="successMsg" style="display:none;">
             <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a><span id='insSuccess'>Company added Successfully</span>
           </div>



        <div class="container">
        <div class="panel panel-light h-auto">

                                    {{-- <div class="panel-header">
                                        <h1 class="panel-title">Create Free Resource</h1>

                                    </div> --}}


                                    <div class="panel-body">
                                       <form name="" id="resourceReg" enctype="multipart/form-data" method="POST" action="{{URL('dashboard/free-resources/create')}}" class="form-horizontal" @submit.prevent="onSubmit">




                   <div class="container">

                       <div class="row">
                           <div class="col-md-12">

                   <ul class="nav nav-tabs tabs-underlined" id="custom-tabs-list" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="custom-tab-1" data-toggle="tab" href="#custom-tab-content-1" role="tab" aria-controls="custom-tab-content-1" aria-selected="true">English</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="custom-tab-2" data-toggle="tab" href="#custom-tab-content-2" role="tab" aria-controls="custom-tab-content-2" aria-selected="false">Arabic</a>
        </li>

    </ul>
    </div>
    </div>

                        <div class="row">
                        <input type="hidden" id="def_lan" name="def_lan" value="en">
                            <div class="col-lg-12" >
                                {{csrf_field()}}






                    <div class="tab-content p-4" id="custom-tabs-content">
        <div class="tab-pane fade active show" id="custom-tab-content-1" role="tabpanel" aria-labelledby="custom-tab-1">


  <div class="['form-group', errors.title_en ? 'has-error' : '']" style="margin-bottom:15px;">
                                    <label for="company_name_en">Title (En)</label>
                                    <input id="title_en" name="title_en" value=""  autofocus="autofocus" class="form-control" type="text" v-model="form.title_en">
                                                                      <span class="text-danger">
                            <strong id="company_name_enerror" style="color: #d00505;"></strong>
                        </span>
                                </div>



                                <div class="form-group @if($errors->first('short_desc_en')) has-danger @endif not-external">
                                    <label for="short_desc_en">Short Description (En)</label>
                                    <textarea class="form-control @if($errors->first('short_desc_en')) is-invalid @endif" name="short_desc_en" id="short_desc_en" rows="3">{{old('short_desc_en')}}</textarea>
                                    @if($errors->first('short_desc_en'))
                                        <span class="form-control-feedback">{{$errors->first('short_desc_en')}}</span>
                                    @endif
                                </div>

                                 <div class="col-md-12 mb15">
          <div class="form-group @if($errors->first('main_desc_en')) has-danger @endif not-external">
                                    <label for="description">Main Description (En)</label>
                                    <textarea class="form-control @if($errors->first('main_desc_en')) is-invalid @endif" name="main_desc_en" id="main_desc_en" rows="3">{{old('main_desc_en')}}</textarea>

                                </div>
                                </div>

  </div>


  <div class="tab-pane fade" id="custom-tab-content-2" role="tabpanel" aria-labelledby="custom-tab-2">
  <div :class="['form-group', errors.title_ar ? 'has-error' : '']" style="margin-bottom:15px;">
                                    <label for="title_ar">Title (Ar)</label>
                                    <input id="title_ar" name="title_ar" value=""  autofocus="autofocus" class="form-control" type="text" v-model="form.title_ar">
                                    <span class="text-danger">
                            <strong id="title_arerror" style="color: #d00505;"></strong>
                        </span>



                                </div>

                                <div class="form-group @if($errors->first('short_desc_ar')) has-danger @endif not-external">
                                    <label for="short_desc_ar">Short Description (Ar)</label>
                                    <textarea class="form-control @if($errors->first('short_desc_ar')) is-invalid @endif" name="short_desc_ar" id="short_desc_ar" rows="3">{{old('short_desc_ar')}}</textarea>
                                    @if($errors->first('short_desc_ar'))
                                        <span class="form-control-feedback">{{$errors->first('short_desc_ar')}}</span>
                                    @endif
                                </div>

                                 <div class="col-md-12 mb15">
          <div class="form-group @if($errors->first('main_desc_ar')) has-danger @endif not-external">
                                    <label for="main_desc_ar">Main Description (Ar)</label>
                                    <textarea class="form-control @if($errors->first('main_desc_ar')) is-invalid @endif" name="main_desc_ar" id="main_desc_ar" rows="3">{{old('main_desc_ar')}}</textarea>

                                </div>
                                </div>


  </div>

</div>



 <div class="row">
           <div class="col-md-6 mb15">
          <div class="form-group @if($errors->first('name')) has-error @endif">

                <img class="profile_pic smb3 mb15" name="profile_pic" id="profile_pic" src="" width="150" height="auto">
                <label class="lc">Upload main image</label>
                <div class="form-group">

                  <input type="file" name="profile_file" id="profile_file" class="profile_file form-textbox" accept="image/*" capture style="display:none">


                  <span id="upfile1" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Select Image</span>

                </div>
            <span class="help-block required">{{$errors->first('name')}}</span>
          </div>
          </div>


                  <div class="col-md-6 mb15">
          <div class="form-group @if($errors->first('pre_language')) has-error @endif">
            <label for="naame">Prefered Languages</label>
            <select name="pre_language[]" class="form-control js-example-basic-multiple" multiple="multiple">
            @foreach($all_languages as $language)
            <option value="{{ $language->id }}">{{ $language->en_language }}</option>
            @endforeach
            </select>
            <span class="help-block required">{{$errors->first('pre_language')}}</span>
          </div>
          </div>


       <div class="col-md-6 mb15">
          <div class="form-group @if($errors->first('skills')) has-error @endif">
            <label for="naame">Skills</label>
            <select name="skills[]" class="form-control js-example-basic-multiple" multiple="multiple">
            @foreach($skills as $skill)
            <option value="{{ $skill->id }}">{{ $skill->en_skill }}</option>
            @endforeach
            </select>
            <span class="help-block required">{{$errors->first('skills')}}</span>
          </div>
          </div>

          <div class="col-xs-12">
            <div class="form-group">
               <label for="naame">Document</label>
               <input type="file" name="document" class="form-control">
            </div>
          </div>


  <div class="col-md-12 mb15" align="right">
                        <div class="tile-footer">
                        <input type="submit" value="Submit" class="btn btn-primary">
                        </div>
                        </div>

</div>



                            </div>
                        </div>


                    </form>


                                    </div>
                                    </div>
                                    </div>



    </main>
  </div>
@endsection

@section('page-js')


<script src="{{ asset('redactor/redactor.js')}}"></script>
<script src="{{ asset('redactor/plugins/table/table.js')}}"></script>
<script src="{{ asset('redactor/plugins/table/table.min.js')}}"></script>
<script src="{{ asset('redactor/plugins/filemanager/filemanager.js')}}"></script>
<script src="{{ asset('redactor/plugins/imagemanager/imagemanager.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
       $('.js-example-basic-multiple').select2();
  });

  </script>
<script>

   $R('#main_desc_en', {
    plugins: ['filemanager','table','imagemanager'],
   // fileUpload: '{!! asset('redactor/scripts/file_upload.php')!!}',
  //  fileManagerJson: '/your-folder/files.json' ,
 //   imageUpload: '{!! asset('redactor/scripts/image_upload.php')!!}',
 //   imageManagerJson: '/your-folder/images.json',
    lang: 'en' ,
  });
</script>


<script>

   $R('#main_desc_ar', {
    plugins: ['filemanager','table','imagemanager'],
   // fileUpload: '{!! asset('redactor/scripts/file_upload.php')!!}',
  //  fileManagerJson: '/your-folder/files.json' ,
    imageUpload: '{!! asset('redactor/scripts/image_upload.php')!!}',
 //   imageManagerJson: '/your-folder/images.json',
    lang: 'ar' ,
  });
</script>

    <!--Notifications Message Section-->

    <!--Notifications Message Section-->


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

  $("#custom-tab-1").click(function () {
      $('#def_lan').val('en');
});
$("#custom-tab-2").click(function () {
    $('#def_lan').val('ar');
});
</script>

<script>
 $('#email').on('blur', function(){
  var email = $('#email').val();
 var admin_base_url = '{{ URL::to('/') }}';
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $.ajax({
        url: admin_base_url+ '/checkEmail',
      type: 'post',
      data: {
        'email' : email,
      },
      success: function(response){
          if(response.s==true)
          {
              $('#emailerror').html(response.msg);
          }
          else
          {
            $('#emailerror').html('');
          }

      }
  });
 });
</script>

<script>
$(document).ready(function(){

 $('#resourceReg').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"{{URL('dashboard/free-resources/create')}}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
   success:function(data)
   {
    if(data.status==true)
    {

     $('#successMsg').css('display','block');
     $('#insSuccess').html(data.message);
       $("#resourceReg").trigger("reset");
         $('html, body').animate({
        scrollTop: $("#app").offset().top
    }, 2000);
    }
    if(data.errors) {

        console.log(data.errors);

        if(data.errors.firstname){
  $( '#firstnameerror' ).html( data.errors.firstname[0] );
}
else
{
  $( '#firstnameerror' ).hide();
}

if(data.errors.company_name_en){
  $( '#company_name_enerror' ).html( data.errors.company_name_en[0] );
}
else
{
  $( '#company_name_enerror' ).hide();
}

if(data.errors.company_name_ar){

  $( '#company_name_arerror' ).html( data.errors.company_name_ar[0] );
}
else
{
  $( '#company_name_arerror' ).hide();
}

if(data.errors.email){
  $( '#emailerror' ).html( data.errors.email[0] );
}
else
{
  $( '#emailerror' ).hide();
}
if(data.errors.password){
  $( '#passworderror' ).html( data.errors.password[0] );
}
else
{
  $( '#passworderror' ).hide();
}
if(data.errors.password_confirmation){
  $( '#password_confirmation' ).html( data.errors.password_confirmation[0] );
}
else
{
  $( '#password_confirmation' ).hide();
}


}
   }
  })
 });

});
</script>

@endsection
