@extends(theme('dashboard.layouts.dashboard'))


<style>
    .fs16 {font-size: 16px !important;}
    </style>

@section('content')
    @include(theme('dashboard.courses.course_nav'))

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1 fs16" style="font-weight: bolder; margin-top: 7px;"><i class="la la-list-alt"></i> {{ __t('curriculum') }} </h4>
        <a href="{{ route('new_section', $course->id) }}" class="btn btn-primary">{{ __t('new_section') }}</a>
    </div>

    @if ($course->sections->count())
        <div class="dashboard-curriculum-wrap">

            <div id="dashboard-curriculum-sections-wrap">
                @foreach ($course->sections as $section)
                    <div id="dashboard-section-{{ $section->id }}" class="dashboard-course-section bg-white border mb-4">
                        <div class="dashboard-section-header p-3 border-bottom d-flex">
                            <i class="la la-bars section-move-handler" style="padding-top:5px;"></i>

                            <span class="dashboard-section-name flex-grow-1 ml-2 fs16"><strong>{{ $section->section_name }}
                                </strong>
                            </span>
                        <span>{{ __t('section_type') }} : @if ($section->section_type == 1) Face to face @elseif($section->section_type
                                ==2)Recorderd @elseif($section->section_type == 3) Live @endif
                                </span>

                            <button class="section-item-btn-tool btn px-1 py-0 section-edit-btn "><i
                                    class="la la-pencil"></i> </button>

                            <button
                                class="section-item-btn-tool btn btn-outline-danger text-danger px-1 py-0 section-delete-btn ml-3"
                                data-section-id="{{ $section->id }}"><i class="la la-trash"></i> </button>
                        </div>


                        <!-- Section Edit Form -->
                        <div class="card-body section-edit-form-wrap" style="display: none;">
                            <form action="{{ route('update_section', $section->id) }}" method="post"
                                class="section-edit-form">
                                @csrf
                                <div class="form-group">
                                    <label for="section_name">{{ __t('section_name') }}</label>
                                    <input type="text" name="section_name" class="form-control"
                                        value="{{ $section->section_name }}">
                                    <div>
                                        @if ($errors->has('section_type'))
                                            <span
                                                class="invalid-feedback"><strong>{{ $errors->first('section_type') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">

                                    <select name="section_type" class="form-control">
                                        <option value="">Choose Type</option>
                                        <option @if ($section->section_type == 1) selected @endif value="1">Face To Face</option>
                                        <option @if ($section->section_type == 2) selected @endif value="2">Recorderd</option>
                                        <option @if ($section->section_type == 3) selected @endif value="3">Live</option>
                                    </select>
                                    <div>
                                        @if ($errors->has('section_type'))
                                            <span
                                                class="invalid-feedback"><strong>{{ $errors->first('section_type') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" name="save" value="save">
                                    <i class="la la-save"></i> {{ __t('update_section') }}
                                </button>
                            </form>
                        </div>
                        <!-- END #Section Edit Form -->


                        <div class="dashboard-section-body bg-light p-3">
                            @include(theme('dashboard.courses.section-items'))
                        </div>

                        <div class="section-item-form-wrap"></div>

                        <div class="section-add-item-wrap p-3 bg-primary">
                            <a href="javascript:;" class="add-item-lecture mr-3 text-white"> <i
                                    class="la la-plus-square"></i> {{ __t('lecture') }}</a>
                            <a href="javascript:;" class="create-new-quiz mr-3 text-white"> <i
                                    class="la la-plus-square"></i> {{ __t('quiz') }}</a>
                            <a href="javascript:;" class="new-assignment-btn mr-3 text-white"> <i
                                    class="la la-plus-square"></i> {{ __t('assignments') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!--  New Lecture Hidden Form HTML -->
            <div id="section-lecture-form-html" style="display: none;">
                <div class="section-item-form-html  p-4 border">
                    <div class="new-lecture-form-header d-flex mb-3 pb-3 border-bottom">
                        <h5 class="flex-grow-1">{{ __t('add_lecture') }}</h5>
                        <a href="javascript:;" class="btn btn-outline-dark btn-sm btn-cancel-form"><i
                                class="la la-close"></i> </a>
                    </div>

                    <form class="curriculum-lecture-form" action="{{ route('new_lecture', $course->id) }}" method="post">

                        <div class="lecture-request-response"></div>

                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __t('title') }}</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __t('description') }}</label>
                            <textarea name="description" class="form-control ajaxCkeditor" rows="5"></textarea>
                        </div>

                        <div class="form-group d-flex">
                            <span class="mr-4">{{ __t('free_preview') }}</span>
                            <label class="switch">
                                <input type="checkbox" name="is_preview" value="1">
                                <span></span>
                            </label>
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-outline-danger btn-cancel-form">
                                {{ __t('cancel') }}</button>
                            <button type="submit" class="btn btn-primary btn-add-lecture" name="save" value="save_next"> <i
                                    class="la la-save"></i> {{ __t('add_lecture') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!--  New Quiz Hidden Form HTML -->
            <div id="section-quiz-form-html" style="display: none;">
                <div class="section-item-form-html p-4 border">
                    <div class="new-quiz-form-header d-flex mb-3 pb-3 border-bottom">
                        <h5 class="flex-grow-1">{{ __t('create_quiz') }}</h5>
                        <a href="javascript:;" class="btn btn-outline-dark btn-sm btn-cancel-form"><i
                                class="la la-close"></i> </a>
                    </div>

                    <form class="curriculum-quiz-form" action="{{ route('new_quiz', $course->id) }}" method="post">

                        <div class="quiz-request-response"></div>

                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __t('title') }}</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __t('description') }}</label>
                            <textarea name="description" class="form-control ajaxCkeditor" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-outline-danger btn-cancel-form">
                                {{ __t('cancel') }}</button>
                            <button type="submit" class="btn btn-info btn-add-quiz" name="save" value="save_next"> <i
                                    class="la la-save"></i> {{ __t('create_new_quiz') }}</button>
                        </div>
                    </form>
                </div>
            </div>


            <!--  New Assignment Hidden Form HTML -->
            <div id="new-assignment-form-html" style="display: none;">
                <div class="section-item-form-html p-4 border">
                    <div class="new-assignment-form-header d-flex mb-3 pb-3 border-bottom">
                        <h5 class="flex-grow-1">{{ __t('new_assignment') }}</h5>
                        <a href="javascript:;" class="btn btn-outline-dark btn-sm btn-cancel-form"><i
                                class="la la-close"></i> </a>
                    </div>

                    <form class="new-assignment-form" action="{{ route('new_assignment', $course->id) }}" method="post">

                        <div class="assignment-request-response"></div>

                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __t('title') }}</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __t('description') }}</label>
                            <textarea name="description" class="form-control ajaxCkeditor" rows="5"></textarea>
                        </div>

                        <div class="form-group border-bottom py-3">

                            <div class="form-row">
                                <div class="col">
                                    <label>{{ __t('time_duration') }}</label>
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="number" class="form-control"
                                                name="assignment_option[time_duration][time_value]" value="0">
                                        </div>

                                        <div class="col">
                                            <select class="form-control" name="assignment_option[time_duration][time_type]">
                                                <option value="weeks">Weeks</option>
                                                <option value="days">Days</option>
                                                <option value="hours">Hours</option>
                                            </select>
                                        </div>
                                    </div>
                                    <small class="text-muted">Assignment time duration, set 0 for no limit.</small>
                                </div>

                                <div class="col">
                                    <label>{{ __t('total_number') }}</label>
                                    <input type="text" name="assignment_option[total_number]" value="10"
                                        class="form-control">
                                    <small class="text-muted">{{ __t('total_number_desc') }}</small>
                                </div>
                                <div class="col">
                                    <label>{{ __t('minimum_pass_number') }}</label>
                                    <input type="text" name="assignment_option[pass_number]" value="5" class="form-control">
                                    <small class="text-muted">{{ __t('minimum_pass_number_desc') }}</small>
                                </div>

                            </div>
                        </div>


                        <div class="form-group py-3">

                            <div class="form-row">

                                <div class="col">
                                    <label>{{ __t('upload_attachment_limit') }}</label>
                                    <input type="text" name="assignment_option[upload_attachment_limit]" value="1"
                                        class="form-control">
                                    <small class="text-muted">
                                        {{ __t('max_attach_size_limit') }}
                                    </small>
                                </div>

                                <div class="col">
                                    <label>{{ __t('max_attach_size_limit') }}</label>
                                    <input type="text" name="assignment_option[upload_attachment_size_limit]" value="5"
                                        class="form-control">
                                    <small class="text-muted">
                                        {{ __t('max_attach_size_limit_desc') }}
                                    </small>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="dashboard-attachments-upload-body border bg-white p-4 mb-4">

                                <div class="attachment-upload-forms-wrap d-flex flex-wrap justify-content-between"></div>

                                <div id="upload-attachments-hidden-form" style="display: none">
                                    <div class="single-attachment-form mb-3 border">
                                        <div class="d-flex p-3">
                                            {!! media_upload_form('attachments[]', __t('upload_attachments')) !!}
                                            <a href="javascript:;"
                                                class="btn btn-outline-danger btn-sm btn-remove-lecture-attachment-form ml-4"><i
                                                    class="la la-close"></i> </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" id="add_more_attachment_btn"
                                    class="mt-4 mb-2 d-inline-block btn btn-outline-danger"> <i class="la la-plus"></i>
                                    {{ __t('attachments') }} </a>

                                <p class="m-0"> <small class="text-muted">{{ __t('assignment_resources_desc') }}</small>
                                </p>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-outline-danger btn-cancel-form">
                                {{ __t('cancel') }}</button>
                            <button type="submit" class="btn btn-info btn-add-assignment" name="save" value="save_next"> <i
                                    class="la la-save"></i> {{ __t('new_assignment') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    @else

        <div class="card">
            <div class="card-body">
                {!! no_data(null, null, 'my-5') !!}
                <div class="no-data-wrap text-center my-5">
                    <a href="{{ route('new_section', $course->id) }}"
                        class="btn btn-lg btn-primary">{{ __t('new_section') }}</a>
                </div>
            </div>
        </div>
    @endif


@endsection

@section('page-js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/filemanager.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/adapters/jquery.js') }}"></script>
@endsection
