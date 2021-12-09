@extends('layouts.admin')


@section('additional_styles')
   
  
@endsection

@section('content')
<div id="layoutSidenav_content">
    <main class="app-content">
         <div class="app-title">
            <div>
               <h1><i class="fa fa-pencil-square-o"></i> Edit Email Templates</h1>
               
            </div>
            <p class="bs-component">
                @if(can('browse_admin_user'))
                    <a class="btn btn-success" href="{{url('email_templates')}}"><i class="fa fa-list"></i>Email Templates</a>
                @endif
            </p>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-customer">Edit Email Templates</h3><br>
       <form role="form" name="adduser" action="{!! URL::to('/admin/email-templates/edit/'.$template_details->id) !!}" method="post">
         <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
         <div class="box-body col-md-10">

          {{-- <div class="form-group @if($errors->first('title')) has-error @endif">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{!! $template_details->title !!}" readonly="readonly">
            <span class="help-block required">{{$errors->first('title')}}</span>
          </div>

          <div class="form-group @if($errors->first('to')) has-error @endif">
            <label for="to">To</label>
            <input type="text" name="to" class="form-control" placeholder="Enter To" value="{!! $template_details->to !!}">
            <span class="help-block required">{{$errors->first('to')}}</span>
          </div> --}}

          <div class="form-group @if($errors->first('subject')) has-error @endif">
            <label for="subject">Subject</label>
            <input type="text" name="subject" class="form-control" id="subject" placeholder="Enter mail subject" value="{!! $template_details->subject !!}">
            <span class="help-block required">{{$errors->first('subject')}}</span>
          </div>

          <div class="form-group @if($errors->first('content')) has-error @endif">
            <label for="description">Email Content</label>
                                        <textarea name="content" id="mytextarea">{!! $template_details->email_body !!}</textarea>
            <span class="help-block required">{{$errors->first('content')}}</span>
          </div>

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>

        </div>
      </form>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('page-js')

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
            <script>
 CKEDITOR.replace( 'mytextarea', {
       allowedContent: true,
     filebrowserUploadUrl: '{!! asset('ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files')!!}',
    filebrowserImageUploadUrl: '{!! asset('ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images')!!}'

   });
</script>

@endsection