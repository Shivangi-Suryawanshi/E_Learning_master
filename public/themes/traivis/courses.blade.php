@extends('layouts.website')

<style>
    .form-control {
        height: 30px !important;
        padding: 2px 0 0 4px !important;
        line-height: initial;
        min-width: 50px !important;

        background-color: #ffffff;
        border: 1px solid #e6e9fc !important;
        box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2);
        border-radius: 3px;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        font-size: 14px !important;
        font-weight: 400;
    }

    .w100 {
        width: 100% !important;
    }

    @media (max-width: 1200px) {
        .col-md-4 {

            -ms-flex: 0 0 33.33% !important;
            flex: 0 0 33.33% !important;
            max-width: 33.33% !important;
        }

        .col-md-8 {

            -ms-flex: 0 0 66.666667% !important;
            flex: 0 0 66.666667% !important;
            max-width: 66.666667% !important;
        }

        .col-xs-12 {
            -ms-flex: 0 0 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            width: 100% !important;
        }





    }

    @media (max-width: 1200px) {
        .form-inline .form-control {
            display: inline-block;
            width: 100% !important;
            vertical-align: middle;
        }
    }

</style>

@section('content')

    @php
    $path = request()->path();
    @endphp

    <div class="page-header-wrapper bg-light-sky py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="about-text">
                        <h3 class="mb-0">{{ $title }}</h3>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="courses-container-wrap">

        <form action="" id="course-filter-form" method="get">

            <div class="container">

                <div class="row">


                    <div class="col-md-3">


                        <div class="course-filter-wrap">

                            @if (request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            @php
                                $old_cat_id = request('category');
                                $old_topic_id = request('topic');
                                $old_level = (array) request('level');
                                $old_price = (array) request('price');
                                $levelSections = (array) request('level_section');
                            @endphp


                            @if ($categories->count())

                                <div class="course-filter-form-group box-shadow p-3">
                                    <div class="form-group mb-5">
                                        <div class="about-text">
                                            <h3 class="mb-3 fs14">{{ __t('category') }}</h3>
                                        </div>

                                        <form action="{{ route('courses') }}" class="form-inline " method="get">

                                            <select name="category" id="course_category" class="form-control select2">
                                                <option value="">{{ __t('select_category') }}</option>
                                                @foreach ($categories as $category)
                                                    <optgroup label="{{ $category->category_name }}">
                                                        @if ($category->sub_categories->count())
                                                            @foreach ($category->sub_categories as $sub_category)
                                                                <option value="{{ $sub_category->id }}"
                                                                    {{ selected($sub_category->id, $old_cat_id) }}>
                                                                    {{ $sub_category->category_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </optgroup>
                                                @endforeach
                                            </select>


                                            <button class="btn header-search-btn form-control" type="submit"
                                                style="box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2);margin-top:10px;">GO</button>



                                        </form>

                                    </div>

                                    <div class="form-group">
                                        <div class="about-text">
                                            <h3 class="mb-3 fs14">{{ __t('topic') }} <span class="show-loader"></span>
                                            </h3>
                                        </div>
                                        <form action="{{ route('courses') }}" class="form-inline " method="get">

                                            <select name="topic" id="course_topic" class="form-control select2 w100">
                                                <option value="">{{ __t('select_topic') }}</option>

                                                @foreach ($topics as $topic)
                                                    <option value="{{ $topic->id }}"
                                                        {{ selected($topic->id, $old_topic_id) }}>
                                                        {{ $topic->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>



                                            <button class="btn header-search-btn form-control w100" type="submit"
                                                style="box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2);margin-top: 10px !important;">GO</button>

                                        </form>
                                    </div>
                                </div>
                            @endif


                            <div class="course-filter-form-group box-shadow p-3">
                                <div class="form-group">
                                    <div class="about-text">
                                        <h3 class="mb-3 fs14">{{ __t('course_level') }}</h3>
                                    </div>
                                    @foreach (course_levels() as $key => $level)
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="level[]"
                                                value="{{ $key }}"
                                                {{ in_array($key, $old_level) ? 'checked="checked"' : '' }}>
                                            <span class="custom-control-label">{{ $level }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>


                            <div class="course-filter-form-group box-shadow p-3">
                                <div class="form-group">
                                    <div class="about-text">
                                        <h3 class="mb-3 fs14">{{ __t('course_section') }}</h3>
                                    </div>

                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="level_section[]" value="1"
                                            {{ in_array(1, $levelSections) ? 'checked="checked"' : '' }}>
                                        <span class="custom-control-label">Face to face</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">

                                        <input type="checkbox" class="custom-control-input" name="level_section[]" value="2"
                                            {{ in_array(2, $levelSections) ? 'checked="checked"' : '' }}>
                                        <span class="custom-control-label">Recorderd</span>
                                    </label>
                                    <label class="custom-control custom-checkbox">

                                        <input type="checkbox" class="custom-control-input" name="level_section[]" value="3"
                                            {{ in_array(3, $levelSections) ? 'checked="checked"' : '' }}>

                                        <span class="custom-control-label">Live</span>
                                    </label>
                                </div>
                            </div>



                            <div class="course-filter-form-group box-shadow p-3">
                                <div class="form-group">
                                    <div class="about-text">
                                        <h3 class="mb-3 fs14">{{ __t('price') }}</h3>
                                    </div>


                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="price[]" value="paid"
                                            {{ in_array('paid', $old_price) ? 'checked="checked"' : '' }}>
                                        <span class="custom-control-label">{{ __t('paid') }}</span>
                                    </label>

                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="price[]" value="free"
                                            {{ in_array('free', $old_price) ? 'checked="checked"' : '' }}>
                                        <span class="custom-control-label">{{ __t('free') }}</span>
                                    </label>

                                </div>
                            </div>

                            <div class="course-filter-form-group box-shadow p-3">
                                <div class="form-group">
                                    <div class="about-text">
                                        <h3 class="mb-3 fs14">{{ __t('ratings') }}</h3>
                                    </div>

                                    <div class="filter-form-by-rating-field-wrap">
                                        <label class="d-flex">
                                            <input type="radio" name="rating" value="4.5" class="mr-2"
                                                {{ checked('4.5', request('rating')) }}>
                                            {!! star_rating_generator(4.5) !!}
                                            <span class="ml-2">4.5 & Up</span>
                                        </label>
                                        <label class="d-flex">
                                            <input type="radio" name="rating" value="4" class="mr-2"
                                                {{ checked('4', request('rating')) }}>
                                            {!! star_rating_generator(4) !!}
                                            <span class="ml-2">4.0 & Up</span>
                                        </label>
                                        <label class="d-flex">
                                            <input type="radio" name="rating" value="3" class="mr-2"
                                                {{ checked('3', request('rating')) }}>
                                            {!! star_rating_generator(3) !!}
                                            <span class="ml-2">3.0 & Up</span>
                                        </label>
                                        <label class="d-flex">
                                            <input type="radio" name="rating" value="2" class="mr-2"
                                                {{ checked('2', request('rating')) }}>
                                            {!! star_rating_generator(2) !!}
                                            <span class="ml-2">2.0 & Up</span>
                                        </label>
                                        <label class="d-flex">
                                            <input type="radio" name="rating" value="1" class="mr-2"
                                                {{ checked('1', request('rating')) }}>
                                            {!! star_rating_generator(1) !!}
                                            <span class="ml-2">1.0 & Up</span>
                                        </label>


                                    </div>
                                </div>
                            </div>


                            <div class="course-filter-form-group box-shadow p-3">
                                <div class="form-group">
                                    <div class="about-text">
                                        <h3 class="mb-3 fs14">{{ __t('video_duration') }}</h3>
                                    </div>


                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="video_duration" value="0_2"
                                            {{ checked('0_2', request('video_duration')) }}>
                                        <span class="custom-control-label">{{ __t('0_2_hours') }}</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="video_duration" value="3_5"
                                            {{ checked('3_5', request('video_duration')) }}>
                                        <span class="custom-control-label">{{ __t('3_5_hours') }}</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="video_duration" value="6_10"
                                            {{ checked('6_10', request('video_duration')) }}>
                                        <span class="custom-control-label">{{ __t('6_10_hours') }}</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="video_duration" value="11_20"
                                            {{ checked('11_20', request('video_duration')) }}>
                                        <span class="custom-control-label">{{ __t('11_20_hours') }}</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="video_duration" value="21"
                                            {{ checked('21', request('video_duration')) }}>
                                        <span class="custom-control-label">{{ __t('21_hours') }}</span>
                                    </label>

                                </div>
                            </div>



                        </div>



                    </div>

                    <div class="col-md-9">


                        <div class="">
                            <div class="course-sorting-form-wrap form-inline mb-4">

                                <div class="col-lg-2 col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <button type="button" id="hide-course-filter-sidebar"
                                            class="btn btn-outline-dark w100 mt10">
                                            <i class="la la-filter"></i> Filter
                                            {{ count(array_except(array_filter(request()->input()), 'q')) }}
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-4 col-xs-12">
                                    <div class="form-group w100">
                                        <label class="mt10">Sort: &nbsp;</label>
                                        <select class="form-control" name="perpage">
                                            @for ($i = 10; $i <= 100; $i = $i + 10)
                                                <option value="{{ $i }}"
                                                    {{ selected($i, request('perpage')) }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <select class="form-control w100" name="sort">
                                            <option value="relevance" {{ selected('relevance', request('sort')) }}>Most
                                                Relevant</option>
                                            <option value="most-reviewed"
                                                {{ selected('most-reviewed', request('sort')) }}>
                                                Most Reviewed</option>
                                            <option value="highest-rated"
                                                {{ selected('highest-rated', request('sort')) }}>
                                                Highest Rated</option>
                                            <option value="newest" {{ selected('newest', request('sort')) }}>Newest
                                            </option>
                                            <option value="price-low-to-high"
                                                {{ selected('price-low-to-high', request('sort')) }}>Lowest
                                                Price
                                            </option>
                                            <option value="price-high-to-low"
                                                {{ selected('price-high-to-low', request('sort')) }}>
                                                Highest Price
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-8 col-xs-12">
                                    <div class="header-search-wrap mt6">
                                        <form action="{{ route('courses') }}" class="form-inline mb0" method="get">
                                            <input class="form-control" type="search" name="q" value="{{ request('q') }}"
                                                placeholder="Search">
                                            <button class="btn my-2 my-sm-0 header-search-btn" type="submit"
                                                style="border: 1px solid
                                                                                                                                        height: 30px;    box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2);"><i
                                                    class="la la-search"></i></button>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-4 col-xs-12">
                                    <div class="form-group ml-auto mt6">
                                        <a href="{{ route('courses') }}" class="btn"><b> <i class="la la-refresh"></i>
                                                Clear </b></a>
                                    </div>
                                </div>
                            </div>
                        </div>





                        @if ($courses->count())
                            <p class="txt-black  mb-3"> Showing {{ $courses->count() }} from {{ $courses->total() }}
                                results </p>

                            <div class="row">
                                @foreach ($courses as $course)
                                    {!! course_card($course, 'col-lg-4') !!}
                                @endforeach
                            </div>
                        @else
                            {!! no_data() !!}
                        @endif

                        {!! $courses->links() !!}

                    </div>

                </div>

            </div>



        </form>

    </div>


@endsection
