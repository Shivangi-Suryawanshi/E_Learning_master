@extends(theme('dashboard.layouts.dashboard'))


@section('content')

    @include(theme('dashboard.courses.course_nav'))

    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 25px !important;
            font-size: 16px !important;
        }

    </style>

    <div class="card">
        <div class="card-body">

            <form action="" method="post">
                @csrf

                @php do_action('course_information_before_form_fields', $course); @endphp


                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title">{{ __t('title') }}</label>

                    <div class="input-group mb-3">
                        <input type="text" name="title" class="form-control" id="title"
                            placeholder="{{ __t('course_title_eg') }}" value="{{ $course->title }}"
                            data-maxlength="120">
                        <div class="input-group-append">
                            <span class="input-group-text">{{ 120 - strlen($course->title) }}</span>
                        </div>
                    </div>

                    @if ($errors->has('title'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('short_description') ? ' has-error' : '' }}">
                    <label for="short_description">{{ __t('short_description') }}</label>

                    <div class="input-group">
                        <textarea name="short_description" id="short_description" class="form-control"
                            placeholder="{{ __t('course_short_desc_eg') }}"
                            data-maxlength="220">{{ $course->short_description }}</textarea>
                        <div class="input-group-append">
                            <span class="input-group-text">{{ 220 - strlen($course->short_description) }}</span>
                        </div>
                    </div>

                    @if ($errors->has('short_description'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('short_description') }}</strong></span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">{{ __t('description') }}</label>
                    <textarea name="description" id="description" class="form-control ckeditor"
                        rows="7">{{ $course->description }}</textarea>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('description') }}</strong></span>
                    @endif
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="benefits">{{ __t('what_learn_text') }}</label>
                            <textarea name="benefits" id="benefits" class="form-control"
                                rows="5">{{ $course->benefits }}</textarea>
                            <span id="befitsHelp" class="form-text text-muted">{{ __t('benefits_desc') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="requirements">{{ __t('requirements') }}</label>
                            <textarea name="requirements" id="requirements" class="form-control"
                                rows="5">{{ $course->requirements }}</textarea>
                            <span id="requirementsHelp"
                                class="form-text text-muted">{{ __t('requirements_desc') }}</span>
                        </div>
                    </div>

                </div>

                <div class="form-row my-5">
                    <div class="col">
                        <div class="form-group">
                            <label for="requirements">{{ __t('course_thumbnail') }}</label>
                            {!! image_upload_form('thumbnail_id', $course->thumbnail_id, [750, 422]) !!}
                            <span class="form-text text-muted"> {{ __t('course_img_guide') }}</span>
                        </div>
                    </div>


                    <div class="col">


                        <div class="form-group">
                            <label for="level" class="mr-4">{{ __t('course_level') }}</label>
                            <select name="level" class="form-control">
                                @foreach (course_levels() as $key => $level)
                                    <option value="{{ $key }}" {{ selected($course->level, $key) }}>
                                        {{ $level }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="mb-3">{{ __t('category') }}</label>

                            @if ($categories->count())
                                <select name="category_id" id="course_category" class="form-control select2">
                                    <option value="">{{ __t('select_category') }}</option>
                                    @foreach ($categories as $category)
                                        <optgroup label="{{ $category->category_name }}">
                                            @if ($category->sub_categories->count())
                                                @foreach ($category->sub_categories as $sub_category)
                                                    <option value="{{ $sub_category->id }}"
                                                        {{ selected($course->second_category_id, $sub_category->id) }}>
                                                        {{ $sub_category->category_name }}</option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    @endforeach
                                </select>
                            @endif
                        </div>


                        <div class="form-group {{ $errors->has('topic_id') ? ' has-error' : '' }}">
                            <label class="mb-3">{{ __t('topic') }} <span class="show-loader"></span> </label>

                            @if ($categories->count())
                                <select name="topic_id" id="course_topic" class="form-control select2">
                                    <option value="">{{ __t('select_topic') }}</option>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}"
                                            {{ selected($topic->id, $course->category_id) }}>
                                            {{ $topic->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @if ($errors->has('topic_id'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('topic_id') }}</strong></span>
                            @endif
                        </div>

                    </div>
                </div>


                <div class="lecture-video-upload-wrap mb-5">
                    @php
                        $video_source = $course->video_info('source');
                    @endphp

                    <label>Video Manager</label>

                    <select name="video[source]" hidden class="lecture_video_source form-control mb-2">
                        {{-- <option value="-1">Select Video Source</option> --}}
                        {{-- <option value="html5" {{ selected($video_source, 'html5') }}>HTML5 (mp4)</option> --}}
                        {{-- <option value="external_url" {{ selected($video_source, 'external_url') }}>External URL</option> --}}
                        {{-- <option value="youtube" {{ selected($video_source, 'youtube') }}>YouTube</option> --}}
                        <option value="vimeo"  selected selected($video_source, 'vimeo') }}>Vimeo</option>
                        {{-- <option value="embedded" {{ selected($video_source, 'embedded') }}>Embedded</option> --}}
                    </select>
<br>
<div class="video-source-item video_source_wrap_vimeo"
>
@if($course->video_info('source_vimeo')) <a target="_blank" href="{{$course->video_info('source_vimeo')}}">view vimeo video</a>@endif

<select name="video[source_vimeo]"  class="form-control">
   <option value="">Select Vimeo Ttile</option>
   @if ($vimeoTitle)
  
       @foreach ($vimeoTitle as $vimeoTitleitem)
           <option @if($course->video_info('source_vimeo') == "https://player.vimeo.com/video/{{$vimeoTitleitem->code}}") selected @endif 
            value="https://player.vimeo.com/video/{{ $vimeoTitleitem->code }}">{{ucwords($vimeoTitleitem->title)}}</option>
       @endforeach
   @endif
</select>
</div>

                    <div class="video-source-input-wrap mb-4" style="display: {{ $video_source ? 'block' : 'none' }};">
                        <br>
                        <div class="video-file-type-desc">
                            <label class="text-muted">Select Vimeo Only </label>
                        </div>


                        <div class="video-source-item video_source_wrap_html5 border bg-white p-4"
                            style="display: {{ $video_source == 'html5' ? 'block' : 'none' }};">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="video-upload-wrap text-center">
                                        <i class="la la-cloud-upload text-muted"></i>
                                        <h5>{{ __t('upload_video') }}</h5>
                                        <p class="mb-2">File Format: .mp4</p>
                                        {!! media_upload_form('video[html5_video_id]', __t('upload_video'), null, $course->video_info('html5_video_id')) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="video-poster-upload-wrap text-center">
                                        <i class="la la-image text-muted"></i>
                                        <h5>{{ __t('video_poster') }}</h5>
                                        <small class="text-muted mb-3 d-block">Size: 700x430 pixels. Supports: jpg,jpeg, or
                                            png</small>

                                        {!! image_upload_form('video[html5_video_poster_id]', $course->video_info('html5_video_poster_id')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="video-source-item video_source_wrap_external_url"
                            style="display: {{ $video_source == 'external_url' ? 'block' : 'none' }};">
                            <input type="text" name="video[source_external_url]" class="form-control"
                                value="{{ $course->video_info('source_external_url') }}"
                                placeholder="External Video URL">
                        </div>
                        <div class="video-source-item video_source_wrap_youtube"
                            style="display: {{ $video_source == 'youtube' ? 'block' : 'none' }};">
                            <input type="text" name="video[source_youtube]" class="form-control"
                                value="{{ $course->video_info('source_youtube') }}" placeholder="YouTube Video URL">
                        </div>
                        {{-- <div class="video-source-item video_source_wrap_vimeo"
                            style="display: {{ $video_source == 'vimeo' ? 'block' : 'none' }};">
                            <input type="text" name="video[source_vimeo]" class="form-control"
                                value="{{ $course->video_info('source_vimeo') }}" placeholder="Vimeo Video URL">
                        </div> --}}
                        {{-- <div class="video-source-item video_source_wrap_vimeo"
                        style="display: {{ $video_source == 'vimeo' ? 'block' : 'none' }};">
                       @if($course->video_info('source_vimeo')) <a target="_blank" href="{{$course->video_info('source_vimeo')}}">view vimeo video</a>@endif

                       <select name="video[source_vimeo]"  class="form-control">
                           <option value="">Select Vimeo Ttile</option>
                           @if ($vimeoTitle)
                          
                               @foreach ($vimeoTitle as $vimeoTitleitem)
                                   <option @if($course->video_info('source_vimeo') == "https://player.vimeo.com/video/{{$vimeoTitleitem->code}}") selected @endif 
                                    value="https://player.vimeo.com/video/{{ $vimeoTitleitem->code }}">{{ucwords($vimeoTitleitem->title)}}</option>
                               @endforeach
                           @endif
                       </select>
                    </div> --}}


                        <div class="video-source-item video_source_wrap_embedded"
                            style="display: {{ $video_source == 'embedded' ? 'block' : 'none' }};">
                            <textarea name="video[source_embedded]" class="form-control"
                                placeholder="Place your embedded code here">{!! $course->video_info('source_embedded') !!}</textarea>
                        </div>
                    </div>
                    @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin')
                        <div class="form-group">
                            <label for="">Trainers</label>
                            <select name="trainer[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                @if ($trainer)
                                    @foreach ($trainer as $trainerList)
                                        <option @if ($trainerList->trainers($trainerList->id, $course->id)) selected @endif value="{{ $trainerList->id }}">
                                            {{ $trainerList->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    @endif
                      {{-- <div class="col-md-6"> --}}

                        <div class="form-group {{ $errors->has('available_student') ? ' has-error' : '' }}">
                            <label for="available_student">Number Of Seat</label>
                            <div class="input-group mb-3">
                                <input type="text" name="available_student" class="form-control" id="available_student"
                                    placeholder=" enter number seat" value="{{ $course->available_student }}"
                                    >
                                
                            </div>
                            <span class="form-text text-muted">Hint: if it is unlimited leave the text blank</span>

                            @if ($errors->has('available_student'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('available_student') }}</strong></span>
                            @endif
                        </div>
                    {{-- </div> --}}
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Skills</label>
                            <select name="skills[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->id }}" @if ($selSkills && in_array($skill->id, $selSkills)) selected @endif>{{ $skill->en_skill }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Occupation</label>
                            <select name="occupation[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}" @if ($selOccupations && in_array($occupation->id, $selOccupations)) selected @endif>{{ $occupation->en_occupation }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Industry</label>
                            <select name="industry[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}" @if ($selIndustries && in_array($industry->id, $selIndustries)) selected @endif>{{ $industry->en_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @php do_action('course_information_after_form_fields', $course); @endphp

                <button type="submit" class="btn btn-primary" name="save" value="save"> <i class="la la-save"></i>
                    {{ __t('save') }}</button>
                <button type="submit" class="btn btn-primary" name="save" value="save_next"> <i class="la la-save"></i>
                    {{ __t('save_next') }}</button>
            </form>


        </div>
    </div>

@endsection

@section('page-css')
    <link href="{{ asset('assets/plugins/select2-4.0.3/css/select2.css') }}" rel="stylesheet" />
@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/select2-4.0.3/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $('.js-example-basic-multiple').select2();
        });

    </script>
    <script src="{{ asset('assets/js/filemanager.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/adapters/jquery.js') }}"></script>

    <script>
        //CKEDITOR.replace( 'description' );

    </script>
@endsection
