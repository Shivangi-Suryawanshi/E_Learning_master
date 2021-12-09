@extends('layouts.website')

@section('content')

    <style>
        .default-btn {
            -webkit-transition: 0.5s;
            transition: 0.5s;
            display: inline-block;
            padding: 13px 25px 12px 55px;
            position: relative;
            background-color: #fff !important;
            color: #0045ed !important;
            border-width: 2px;
            border-style: solid;
            border-color: #fff !important;
            border-radius: 1px;
            font-size: 14.5px;
            font-weight: 700;
        }

    </style>


    {{-- <link rel="stylesheet" href="{{ asset('css/jquery.rateyo.min.css') }}"> --}}
    <!-- Latest compiled and minified CSS -->



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
                        <input type="text" class="input-search" placeholder="Search here...">
                        <button type="submit"><i class='bx bx-search-alt'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <input type="hidden" name="existRate" id="existRate" value="@if ($rating) {{ $rating->rating }} @else 2.5 @endif"> --}}
    <!-- End Search Box Layout -->


    <!-- Start Courses Details Area -->
    <section class="courses-details-area ptb-1100" style="padding-top:0px;">

        <div class="container-fluid pl10">
            <div class="courses-details-header">
                <div class="row align-items-center">
                    <div class="col-lg-8">

                        <div class="page-title-content">


                        </div>


                        <div class="courses-title">
                            <h2 class="cwhite">@if(Session::get('locale') == "ar") {!! $free_resource->title_ar !!} @else
                                {!! $free_resource->title_en !!}
                            @endif</h2>
                            <p class="cwhite">
                                @if(Session::get('locale') == "ar")
                                {!! $free_resource->short_desc_ar !!}
                                @else
                                {!! $free_resource->short_desc_en !!}

                                @endif
                            </p>
                        </div>

                        <div class="courses-meta">
                            <ul>
                                <li>
                                    <i class='bx bx-calendar'></i>
                                    <span class="cwhite">Last Updated</span>
                                    <a class="cwhite"> {{ date('d-M-Y', strtotime($free_resource->updated_at)) }}</a>
                                </li>


                                <li>
                                    <i class='bx bx-file'></i>
                                    <span class="cwhite">Document Type</span>
                                    <a class="cwhite">{!! strtoupper($free_resource->doc_type) !!}</a>
                                </li>

                                <li>
                                    <i class='bx bx-server'></i>
                                    <span class="cwhite">Category</span>
                                    <a class="cwhite">@if($free_resource->category) {{ $free_resource->category->category_name }} @endif</a>
                                </li>

                                <br>


                                <li>
                                    <i class='bx bx-edit'></i>
                                    <span class="cwhite">Posted by</span>
                                    <a class="cwhite" @if($free_resource->author) href="{{ URL::to('user-profile/' . $free_resource->author->id) }}" @endif>
                                        @if ($free_resource->author)
                                            {{ $free_resource->author->name }}
                                        @endif
                                    </a>
                                </li>

                                <li>
                                    <i class='bx bx-folder-open'></i>
                                    <span class="cwhite">Language</span>
                                    @if($free_resource->getLanguages())
                                    @foreach ($free_resource->getLanguages()->get() as $key => $free_lan)
                                        <a class="cwhite">{{ getAllLanguage($free_lan->language_id)->en_language }}</a>
                                        @if (!$loop->last)<b class="cwhite"> ,</b>
                                        @endif
                                    @endforeach
                                    @endif
                                </li>


                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="courses-price">
                            <div class="courses-review">

                            </div>



                            <div class="price"></div>
                            <a href="@if ($free_resource->document) {!! asset('uploads/free_resources_documents/' . $free_resource->document) !!} @endif" target="_blank"
                                class="default-btn"><i class='bx bx-download icon-arrow before'></i><span
                                    class="label">Download</span><i class="bx bx-download icon-arrow after"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">


            <div class="row">
                <div class="col-lg-8">
                    <div class="courses-details-image text-center">
                    <img src="@if ($free_resource->img) {!! asset('uploads/free_resources_images/' . $free_resource->img) !!} @else
                        {!! asset('images/noimage.jpg') !!} @endif" alt="image">
                    </div>

                    <div class="courses-details-desc">



                        <h3>Description</h3>

                        <p>
                            @if (Session::get('locale') == "ar")
                            {!! $free_resource->description_ar !!}
                                
                            @else
                            {!! $free_resource->description_en !!}
                            @endif
                        </p>


                    </div>


                </div>





                <div class="col-lg-4">

                    @if (count($freeResources) > 0)
                        <!----------preview videos----------->
                        <aside class="widget-area">

                            <section class="widget widget_raque_posts_thumb">
                                <h3 class="widget-title">Related Resources</h3>
                                @if($freeResources)
                                @foreach ($freeResources as $fr)
                                    <article class="item prlt">
                                        <a class="thumb" href="{{ URL::to('/free-resource-detail/') . '/' . $fr->id }}">
                                            {{-- <span class="fullimage cover bg1" role="img"></span> --}}
                                        <img src="@if ($fr->img) {!! asset('uploads/free_resources_images/' . $fr->img) !!} @else
                                            {!! asset('images/noimage.jpg') !!} @endif">
                                        </a>

                                        <div class="info">


                                            <h5 class="title usmall"><a
                                                    href="{{ URL::to('/free-resource-detail/') . '/' . $fr->id }}">
                                                    
                                                    @if(Session::get('locale') == "ar") {!! $fr->title_ar !!} @else
                                                    {!! $fr->title_en !!}
                                                    @endif
                                                
                                                </a>
                                            </h5>
                                            <time datetime="2019-06-30">{!! strtoupper($fr->doc_type) !!}</time>
                                        </div>

                                        <div class="clear"></div>
                                    </article>
                                @endforeach
                            @endif        
                                {{-- <article class="item prlt">
                                    <a class="thumb">
                                        <span class="fullimage cover bg2" role="img"></span>
                                    </a>
                                    <div class="info">

                                        <time datetime="2019-06-30">PDF</time>
                                        <h5 class="title usmall"><a href="#!">Certified Supervisor Safety Awareness Course</a></h5>
                                    </div>

                                    <div class="clear"></div>
                                </article>

                                <article class="item prlt">
                                    <a class="thumb">
                                        <span class="fullimage cover bg3" role="img"></span>
                                    </a>
                                    <div class="info">

                                        <time datetime="2019-06-30">PDF</time>
                                        <h5 class="title usmall"><a href="#!">Certified Supervisor Safety Awareness Course</a></h5>
                                    </div>

                                    <div class="clear"></div>
                                </article> --}}

                                <br>
                            </section>
                        </aside>
                    @endif

                    <!----------preview videos----------->


                </div>
            </div>
        </div>

    </section>
    <!-- End Courses Details Area -->


    <!-- Latest compiled and minified JavaScript -->


@endsection
@section('additional_scripts')

@endsection
