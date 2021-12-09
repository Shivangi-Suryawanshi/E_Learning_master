@extends(theme('dashboard.layouts.dashboard'))

@section('content')

<style>
    .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.upload-btn-wrapper {

    border: 1px solid gray;
    color: gray;
    background-color: white;
    padding: 6px 10px 6px 10px;
    border-radius: 5px;
    font-size: 15px;
    font-weight: bold;

}

.upload-btn-wrapper input[type="file"] {
  font-size: 50px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}

    </style>

    <div id="admin-media-manager-wrap">

        <div class="curriculum-top-nav d-flex p-2">
            <h4 class="flex-grow-1">Video Manager </h4>


        </div>

<div class="container">
        <div class="row my-3">
            <div class="col-sm-1" align="center">
                <button type="button" data-toggle="sc-modal" data-target="#add-modal" data-toggle="tooltip" title="Upload" id="button-upload" class="btn btn-primary" data-upload-success="reload" ><i class="la la-upload"></i></button>
            </div>

            <div class="col-sm-11">
                <form action="" method="get">
                    {{-- <div class="input-group">
                        <input type="text" name="q" value="{{request('q')}}" placeholder="Search.." class="form-control">
                        <span class="input-group-btn" style="margin-left:20px;">
                        <button type="submit" data-toggle="tooltip" title="Search" id="button-search" class="btn btn-primary">
                            <i class="la la-search"></i>
                        </button>
                    </span>
                    </div> --}}
                </form>

            </div>
        </div>
        </div>

        <div class="row my-3">
            <div class="col-sm-12">
                <form action="{{route('vimeo_upload')}}" method="post" enctype="multipart/form-data" >
                    {{ csrf_field() }}


                             <div class="col-md-12 {{ $errors->has('title') ? ' has-error' : '' }}">
                               <div class="form-group">
                                <input type="text" name="title" class="form-control filter-input" placeholder="Video Title" value="{{ old('title') }}">
                               </div>
                               @if ($errors->has('title'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                            @endif
                             </div>




                <div class="container">
                             <div class="row">
                                       <div class="col-md-3 {{ $errors->has('file') ? ' has-error' : '' }}">
                                           <div class="form-group">
                                               <div class="add-listing__input-file-box upload-btn-wrapper">

                                                   <input class="add-listing__input-file" type="file" name="video" id="video">
                                                   <div class="add-listing__input-file-wrap">
                                                       <i class="ion-ios-cloud-upload"></i>
                                                       <p class="mb0">Click here to upload your file</p>
                                                   </div>
                                                   @if ($errors->has('file'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('file') }}</strong></span>
                            @endif
                                               </div>
                                           </div>
                                       </div>
<div class="col-md-9" allign="left">
<div class="form-group">
   <input type="submit" name="submit" id="submit" class="main-btn register-submit btn btn-primary" value="Upload"/>
</div>
</div>
</div>
</div>
         </form>
            </div>
        </div>

        <div id="statusMsg" class="my-3"></div>
<?php //echo "<pre>"; print_r($videos); exit; ?>
    
        @if($videos->count())
              <div class="row">
        

                @foreach($videos as $vdo)
             

                <div class=" col-sm-12 col-md-6">
                               <div class="">
                                     
                                    <div class="most-viewed-item">
                                        <div class="">

                                            <div class="selimg">
                                            <input type="checkbox" id="box-2">
                                            <label for="box-2"></label>
                                        </div>

<iframe src="https://player.vimeo.com/video/{{ $vdo->code }}" width="298" height="199" frameborder="1" title="{{ $vdo->video_title }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>



                                             <h4 class="mb5">{{ $vdo->title }}</h4>

                                             &nbsp;
                                             &nbsp;
                                             &nbsp;
                                             &nbsp;
                                             <a target="_blank"  href="https://vimeo.com/manage/{{ $vdo->code }}/embed"> click here to changes video setting </a> 
                                            {{-- <a href="#!" class="btn v2"><i class="ion-share"></i> Share</a> --}}

                                        </div>


                                    </div>
                                   
                                    </div>
                                </div>
                               
                                
                                    @endforeach
                                

                            </div>
            

        @else

            {!! no_data() !!}

        @endif



    </div>




@endsection
