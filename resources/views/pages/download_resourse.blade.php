@extends('layouts.website')

@section('content')

    <!-- Search Box Layout -->
    <div class="search-overlay">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>

                <div class="search-overlay-close">
                    <span class="search-overlay-close-line"></span>
                    <span class="search-overlay-close-line"></span>
                </div>

                <div class="search-overlay-form">
                    <form>
                        <input type="text" class="input-search" placeholder="Search hereaa...">
                        <button type="submit"><i class='bx bx-search-alt'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Search Box Layout -->




    <!-- Start Courses Area -->
    <section class="courses-area ptb-1100 ptbm30">
        <div class="container">

            <div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="about-text">
                            <h3> Free Resources</h3>
                            <br>
                        </div>
                    </div>
                </div>
            </div>


            <div class="courses-topbar">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3">
                        <div class="topbar-ordering">
                            <select>
                                <option>Sort by popularity</option>
                                <option>Sort by latest</option>
                                <option>Default sorting</option>
                                <option>Sort by rating</option>
                                <option>Sort by new</option>
                            </select>
                        </div>

                    </div>

                    <div class="col-lg-9 col-md-9">
                        <div class="topbar-ordering-and-search">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-6 mt10">
                                    <div class="topbar-search">
                                        <form>
                                            <label><i class="bx bx-search"></i></label>
                                            <input type="text" class="input-search" id="search_text" name="keyword"
                                                placeholder="Search here..." value="@if (\Request::get('keyword')) {{ \Request::get('keyword') }} @endif">
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-5 offset-lg-4 offset-md-1">
                                    <div class="topbar-result-count">
                                        <p>Showing - <span id="fr_count">{{ count($free_resources) }} </span> results</p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <aside class="widget-area">


                        <!------------------------------>
                        <div class="faq-accordion">
                            <ul class="accordion">

                                <li class="accordion-item">
                                    <a class="accordion-title active" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        Category
                                    </a>

                                    <div class="accordion-content show acxs">
                                        @foreach ($categories as $category)
                                            @if ($category->sub_categories->count())
                                                @foreach ($category->sub_categories as $sub_category)
                                                    <div class="form-check mb10">
                                                        <input type="checkbox" name="cats[]" @if (\Request::get('cats') && in_array($sub_category->id, \Request::get('cats'))) checked @endif
                                                            class="form-check-input cats_class"
                                                            value="{{ $sub_category->id }}">
                                                        <label class="form-check-label" for="create-an-account">
                                                            {{ $sub_category->category_name }}</label>

                                                    </div>


                                                @endforeach
                                            @endif
                                        @endforeach




                                    </div>
                                </li>

                                <li class="accordion-item">
                                    <a class="accordion-title" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        Languages
                                    </a>

                                    <div class="accordion-content acxs">
                                        @foreach ($all_languages as $language)
                                            <div class="form-check mb10">
                                                <input type="checkbox" class="form-check-input lang_class" @if (\Request::get('selLan') && in_array($language->id, \Request::get('selLan'))) checked @endif name="selLan[]"
                                                    value="{{ $language->id }}">
                                                <label class="form-check-label" for="create-an-account">
                                                    {!! $language->language !!}</label>
                                            </div>
                                        @endforeach
                                        {{-- <div class="form-check mb10">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account"> Arabic</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                     <label class="form-check-label" for="create-an-account"> French</label>
                                        </div> --}}

                                    </div>
                                </li>









                                <li class="accordion-item">
                                    <a class="accordion-title" href="javascript:void(0)">
                                        <i class='bx bx-chevron-down'></i>
                                        Skills
                                    </a>

                                    <div class="accordion-content acxs">
                                        @foreach ($skills as $skill)
                                            <div class="form-check mb10">
                                                <input type="checkbox" name="skills[]" @if (\Request::get('skills') && in_array($skill->id, \Request::get('skills'))) checked @endif
                                                    class="form-check-input skill_class" value="{{ $skill->id }}">
                                                <label class="form-check-label" for="create-an-account">
                                                    {!! $skill->skill !!}</label>
                                            </div>
                                        @endforeach


                                    </div>
                                </li>



                            </ul>
                        </div>
                        <!-------------------------------->


                    </aside>
                </div>


                <div class="col-lg-9 col-md-12">

                    <div class="row" id="tag_container">

                        @include('pages.resourse_render')


                    </div>

                    <div>


                        <!--------------new----------->



                    </div>
                </div>


            </div>
        </div>

    </section>
    <!-- End Courses Area -->
    <!-- End Become Instructor & Partner Area -->
@endsection
@section('page-js')
    <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').on('change', function(e) {
                var data = [],
                    loc = $('<a>', {
                        href: window.location
                    })[0];
                $('input[type="checkbox"]').each(function(i) {
                    if (this.checked) {
                        data.push(this.name + '=' + this.value);
                    }
                });
                if ($('#search_text').val() != '') {
                    data.push('keyword=' + $('#search_text').val());
                }
                data = data.join('&');
                //console.log(data);
                fetchData(data);

                $.get('/download-resourses', data);
                if (history.pushState) {
                    history.pushState(null, null, loc.pathname + '?' + data);
                }
            });


            $('#search_text').on('keyup keydown blur', function(event) {
                var data = [];
                loc = $('<a>', {
                    href: window.location
                })[0];
                $('input[type="checkbox"]').each(function(i) {
                    if (this.checked) {
                        data.push(this.name + '=' + this.value);
                    }
                });

                if ($('#search_text').val() != '') {
                    data.push('keyword=' + $('#search_text').val());
                }
                data = data.join('&');
                $.get('/download-resourses', data);
                console.log(data);
                if (history.pushState) {
                    history.pushState(null, null, loc.pathname + '?' + data);
                }
                fetchData();
            });

            $('.listing_type').change(function() {

                fetchData();

            });

            $('.price_class').click(function() {

                fetchData();

            });



            $('.skill_class').click(function() {

                //fetchData();

            });

            $('.learning_class').click(function() {

                // fetchData();

            });
            $('.lang_class').click(function() {

                //fetchData();

            });
        });

        function fetchData(request) {
            //console.log($('.skill_class:checkbox:checked'));

            var skills = [];
            $.each($('.skill_class:checkbox:checked'), function() {
                skills.push($(this).val());
            });


            var cats = [];
            $.each($('.cats_class:checkbox:checked'), function() {
                cats.push($(this).val());
            });


            var learning_approach = [];
            $.each($('.learning_class:checkbox:checked'), function() {
                learning_approach.push($(this).val());
            });

            var selLan = [];
            $.each($('.lang_class:checkbox:checked'), function() {
                selLan.push($(this).val());
            });



            var price = '';
            if ($("input:radio.price_class:checked").val()) {
                price = $("input:radio.price_class:checked").val();
            }

            var keyword = '';
            if (request) {
                keyword = request.term;
            }
            if ($('#search_text').val() != '') {
                keyword = $('#search_text').val();
            }

            var list_type = '';

            if ($('#listing_type').val() != '') {
                list_type = $('#listing_type').val();
            }

            var listing_variation = '';

            if ($('#listing_variation').val() != '') {
                listing_variation = $('#listing_variation').val();
            }


            $.ajax({
                url: "{{ url('/download-resourses') }}",
                method: "get",
                data: {
                    price: price,
                    keyword: keyword,
                    skills: skills,
                    cats: cats,
                    learning_approach: learning_approach,
                    selLan: selLan,

                    list_type: list_type,
                    listing_variation: listing_variation
                },
                success: function(data) {
                    console.log(data.fr_count);
                    $("#resultCount").text(data.count + ' ' + 'results');
                    $('#tag_container').html(data.html);
                    $('#fr_count').html(data.fr_count);


                }
            });
        }

    </script>
    <script type="text/javascript">
        $(document).ready(function() {


            $(document).on('click', '.pagination a', function(event) {

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                getData($(this).attr('href').split('page=')[1]);
                event.preventDefault();
            });


        });

        function getData(page) {
            //console.log($("input:radio.price_class:checked").val());
            var favorite = [];
            $.each($('.skill_class:checkbox:checked'), function() {
                favorite.push($(this).val());
            });
            //alert(favorite);

            var price = '';
            if ($("input:radio.price_class:checked").val()) {
                price = $("input:radio.price_class:checked").val();
            }
            var keyword = '';
            if ($('#search_text').val() != '') {
                keyword = $('#search_text').val();
            }
            var learning = [];
            $.each($('.learning_class:checkbox:checked'), function() {
                learning.push($(this).val());
            });

            var langs = [];
            $.each($('.lang_class:checkbox:checked'), function() {
                langs.push($(this).val());
            });


            $.ajax({
                url: '?page=' + page,
                type: "get",
                data: {
                    price: price,
                    keyword: keyword,
                    favorite: favorite,
                    learning: learning,
                    langs: langs,

                },
                datatype: "html"
            }).done(function(data) {

                // console.log(data.courses.data[i].avg_p);
                var keyword = '';
                if ($('#search_text').val() != '') {
                    keyword = $('#search_text').val();
                }
                $("#tag_container").empty().html(data.html);

                // console.log(stars);

                // location.hash = page;
                // var url = $(this).attr('href');
                //  window.history.pushState("", "", url);
                //  window.history.pushState('', '', '?keyword='+keyword);

            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }

    </script>
@endsection
