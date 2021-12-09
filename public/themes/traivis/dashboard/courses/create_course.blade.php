@extends(theme('dashboard.layouts.dashboard'))


@section('content')

    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: text;
            box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
            border: 1px solid #e2e5ec !important;
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e2e5ec !important;
            border-radius: .25rem;
            box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
            box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
            border: 1px solid #e2e5ec !important;
        }


        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 25px;
            font-size: .92rem !important;
        }

        .img-thumbnail {
            width: 25% !important;
        }

        .input-group-text {
            background: #000 !important;
            color: #fff !important;
        }

        label {

            font-size: .92rem !important;
            font-weight: 400 !important;
            color: #646c9a !important;
        }

    </style>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">



    <div class="card">
        <div class="card-body">

            <form method="post">
                @csrf

                <h5>Create Course</h5>
                <hr>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">{{ __t('title') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="{{ __t('course_title_eg') }}" value="{{ old('title') }}"
                                    data-maxlength="120">
                                <div class="input-group-append">
                                    <span class="input-group-text">120</span>
                                </div>
                            </div>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="level" class="mr-4">{{ __t('course_level') }}</label>
                            <select name="level" class="form-control">
                                @foreach (course_levels() as $key => $level)
                                    <option value="{{ $key }}" {{ selected(1, $key) }}>{{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="mb-3">{{ __t('category') }}</label>

                            @if ($categories->count())
                                <select name="category_id" id="course_category" class="form-control select2">
                                    <option value="">{{ __t('select_category') }}</option>
                                    @foreach ($categories as $category)
                                        <optgroup label="{{ $category->category_name }}">
                                            @if ($category->sub_categories->count())
                                                @foreach ($category->sub_categories as $sub_category)
                                                    <option value="{{ $sub_category->id }}">
                                                        {{ $sub_category->category_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    @endforeach
                                </select>
                            @endif
                            @if ($errors->has('category_id'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('category_id') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">


                        <div class="form-group {{ $errors->has('topic_id') ? ' has-error' : '' }}">
                            <label class="mb-3">{{ __t('topic') }}</label>

                            @if ($categories->count())
                                <select name="topic_id" id="course_topic" class="form-control select2">
                                    <option value="">{{ __t('select_topic') }}</option>
                                </select>
                            @endif
                            @if ($errors->has('topic_id'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('topic_id') }}</strong></span>
                            @endif
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="form-row my-3">
                            <div>
                                <div class="form-group">
                                    <label for="requirements">{{ __t('course_thumbnail') }}</label>
                                    {!! image_upload_form('thumbnail_id', null, [750, 422]) !!}
                                    <span class="form-text text-muted"> {{ __t('course_img_guide') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div>

                            <div class="form-group">
                                <label for="short_description">{{ __t('short_description') }}</label>
                                <div class="input-group">
                                    <textarea name="short_description" rows="8" id="short_description" class="form-control"
                                        placeholder="{{ __t('course_short_desc_eg') }}"
                                        data-maxlength="220">{{ old('short_description') }}</textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text">220</span>
                                    </div>
                                </div>
                            </div>






                        </div>
                    </div>




                    <div class="lecture-video-upload-wrap col-md-6">
                        @php
                            $videoSrc = old('video_source');
                        @endphp


                        <label>Video Manager</label>

                        <select hidden name="video[source]" class="lecture_video_source form-control mb-2">
                            {{-- <option value="-1">Select Video Source</option> --}}
                            {{-- <option value="html5" {{ selected($videoSrc, 'html5') }}>HTML5 (mp4)</option> --}}
                            {{-- <option value="external_url" {{ selected($videoSrc, 'external_url') }}>External URL</option>
                            <option value="youtube" {{ selected($videoSrc, 'youtube') }}>YouTube</option> --}}
                            <option value="vimeo" selected {{ selected($videoSrc, 'vimeo') }}>Vimeo</option>
                            {{-- <option value="embedded" {{ selected($videoSrc, 'embedded') }}>Embedded</option> --}}
                        </select>
<br>

                        <div class="video-source-item video_source_wrap_vimeo"
                       >
                      
                       <select name="video[source_vimeo]"  class="form-control">
                           <option value="">Select Video Ttile</option>
                           @if ($vimeoTitle)
                               @foreach ($vimeoTitle as $vimeoTitleitem)
                                   <option  value="https://player.vimeo.com/video/{{ $vimeoTitleitem->code }}">{{ucwords($vimeoTitleitem->title)}}</option>
                               @endforeach
                           @endif
                       </select>
                    </div>
<br>
                        {{-- <p class="video-file-type-desc">
                            <span class="text-muted">Select your preferred video type. (.mp4, YouTube, Vimeo etc.) </span>
                        </p> --}}

                        <div class="video-source-input-wrap mb-5" style="display: {{ $videoSrc ? 'block' : 'none' }};">

                            <div class="video-source-item video_source_wrap_html5 border bg-white p-4"
                                style="display: {{ $videoSrc == 'html5' ? 'block' : 'none' }};">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="video-upload-wrap text-center">
                                            <i class="fa fa-cloud-upload text-muted"></i>
                                            <h5>{{ __t('upload_video') }}</h5>
                                            <p class="mb-2">File Format: .mp4</p>
                                            {!! media_upload_form('video[html5_video_id]', __t('upload_video'), null) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="video-poster-upload-wrap text-center">
                                            <i class="fa fa-image text-muted"></i>
                                            <h5>{{ __t('video_poster') }}</h5>
                                            <small class="text-muted mb-3 d-block">Size: 700x430 pixels. Supports: jpg,jpeg,
                                                or png</small>

                                            {!! image_upload_form('video[html5_video_poster_id]') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="video-source-item video_source_wrap_external_url"
                                style="display: {{ $videoSrc == 'external_url' ? 'block' : 'none' }};">
                                <input type="text" name="video[source_external_url]" class="form-control" value=""
                                    placeholder="External Video URL">
                            </div>
                            <div class="video-source-item video_source_wrap_youtube"
                                style="display: {{ $videoSrc == 'youtube' ? 'block' : 'none' }};">
                                <input type="text" name="video[source_youtube]" class="form-control" value=""
                                    placeholder="YouTube Video URL">
                            </div>
                            {{-- <div class="video-source-item video_source_wrap_vimeo"
                                style="display: {{ $videoSrc == 'vimeo' ? 'block' : 'none' }};">
                                <input type="text" name="video[source_vimeo]" class="form-control" value=""
                                    placeholder="Vimeo Video URL">
                            </div> --}}

                            {{-- <div class="video-source-item video_source_wrap_vimeo"
                            style="display: {{ $videoSrc == 'vimeo' ? 'block' : 'none' }};">
                          
                           <select name="video[source_vimeo]"  class="form-control">
                               <option value="">Select Vimeo Ttile</option>
                               @if ($vimeoTitle)
                                   @foreach ($vimeoTitle as $vimeoTitleitem)
                                       <option  value="https://player.vimeo.com/video/{{ $vimeoTitleitem->code }}">{{ucwords($vimeoTitleitem->title)}}</option>
                                   @endforeach
                               @endif
                           </select>
                        </div> --}}
                            <div class="video-source-item video_source_wrap_embedded"
                                style="display: {{ $videoSrc == 'embedded' ? 'block' : 'none' }};">
                                <textarea name="video[source_embedded]" class="form-control"
                                    placeholder="Place your embedded code here"></textarea>
                            </div>
                        </div>
                        @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin')
                            <div class="form-group">
                                <label for="">Trainers</label>
                                <select name="trainer[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                    @if ($trainer)
                                        @foreach ($trainer as $trainerList)
                                            <option value="{{ $trainerList->id }}">{{ $trainerList->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">

                        <div class="form-group {{ $errors->has('available_student') ? ' has-error' : '' }}">
                            <label for="available_student">Number Of Seat</label>
                            <div class="input-group mb-3">
                                <input type="text" name="available_student" class="form-control" id="available_student"
                                    placeholder=" enter number seat" value="{{ old('available_student') }}"
                                    >
                            </div>
                            <span class="form-text text-muted">Hint: if it is unlimited leave the text blank</span>

                            @if ($errors->has('available_student'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('available_student') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Skills</label>
                            <select name="skills[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                @if ($skills)
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}">{{ $skill->en_skill }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Occupation</label>
                            <select name="occupation[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                @if ($occupations)
                                    @foreach ($occupations as $occupation)
                                        <option value="{{ $occupation->id }}">{{ $occupation->en_occupation }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Industry</label>
                            <select name="industry[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                @if ($industries)
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}">{{ $industry->en_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>



                    <div class="col-md-12" align="right">
                        <button type="submit" class="btn btn-primary"> <i class="la la-save"></i>
                            {{ __t('create_course') }}</button>
                    </div>

                </div>
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
@endsection
