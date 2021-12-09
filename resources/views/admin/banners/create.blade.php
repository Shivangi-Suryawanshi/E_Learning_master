@extends('admin.layouts.app')
@section('head_title')
Dashboard
@endsection
@section('main_content')
<div id="layoutSidenav_content">
  <main>
    
    <div class="container-fluid">
      <h2 class="mt-4">Banners</h1>

       <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ URL::to('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ URL::to('/admin/directory-categories') }}">Banners</a></li>
        <li class="breadcrumb-item active">Create</li>

      </ol>

      <div class="col-xs-12">

        <div class="">
          <div class="table-responsive">
            <div class="col-xs-12 container-fluid" style="text-align: right;margin-bottom: 10px;">
             <a href="{{ URL::to('banner-images') }}" class="btn btn-rounded btn-primary mb-1 ml-4"><i class="fa fa-arrow-left"></i> Back</a>
           </div>

         </div>
       </div>
       @if(Session::get('message'))

       <div class="alert alert-success msgalt">
         <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>{!! Session::get('message') !!}
       </div>

       @endif
       <form role="form" name="adduser" action="{!! URL::to('banner-images/create/') !!}" method="post" enctype="multipart/form-data">
         <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
         
         <div class="box-body col-md-10">


           <div class="form-group @if($errors->first('name')) has-error @endif">
            <label for="naame">Select Page</label>
           <select name="sel_page" class="form-control">
             <option value="">Select</option>
             @foreach($pages as $page)
             <option value="{{ $page->id }}">{{ $page->title_en }}</option>
             @endforeach
           </select>
            <span class="help-block required">{{$errors->first('name')}}</span>
          </div>

          <div class="form-group @if($errors->first('title_en')) has-error @endif">
            <label for="naame">Title (en)</label>
            <input type="text" name="title_en" class="form-control" id="title_en" placeholder="Enter Title" minlength="2" maxlength="30" value="{!! old('title_en') !!}">
            <span class="help-block required">{{$errors->first('title_en')}}</span>
          </div>

          <div class="form-group @if($errors->first('title_ar')) has-error @endif">
            <label for="naame">Title (ar)</label>
            <input type="text" name="title_ar" class="form-control" id="title_ar" placeholder="Enter Title" minlength="2" maxlength="30" value="{!! old('title_ar') !!}">
            <span class="help-block required">{{$errors->first('title_ar')}}</span>
          </div>

          <div class="form-group @if($errors->first('content_en')) has-error @endif">
            <label for="name">Short Description (en)</label>
          <textarea name="content_en" class="form-control"></textarea>
            <span class="help-block required">{{$errors->first('content_en')}}</span>
          </div>


          <div class="form-group @if($errors->first('content_ar')) has-error @endif">
            <label for="name">Short Description (ar)</label>
          <textarea name="content_ar" class="form-control"></textarea>
            <span class="help-block required">{{$errors->first('content_ar')}}</span>
          </div>


          <div class="form-group @if($errors->first('name')) has-error @endif">
            <label class="lc">Upload Logo</label><br />
                <img class="profile_pic smb3" name="profile_pic" id="profile_pic" src="" width="500" height="auto">
                <div class="form-group">

                  <input type="file" name="profile_file" id="profile_file" class="profile_file form-textbox" accept="image/*" capture style="display:none">


                  <span id="upfile1" class="btn btn-primary">Select Logo</span>

                </div>
            <span class="help-block required">{{$errors->first('name')}}</span>
          </div>




          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</main>
@endsection
@section('additional_scripts')

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
@endsection