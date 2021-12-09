@if (count($free_resources) > 0)
    @foreach ($free_resources as $free)
        <div class="col-lg-4 col-md-6 mix business design language">
            <div class="single-courses-box mb-30">
                <div class="courses-image resimg">
                    <a href="{{ URL::to('/free-resource-detail/') . '/' . $free->id }}" class="d-block"><img
                        src="@if ($free->img) {!! asset('uploads/free_resources_images/' . $free->img) !!} @else
                        {!! asset('images/noimage.png') !!} @endif" alt="image"></a>

                </div>

                <div class="courses-desc">
                    <div class="courses-content freef min160">


                        <h3 class="fs14"><a href="{{ URL::to('/free-resource-detail/') . '/' . $free->id }}"
                                class="d-inline-block">
                                @if (Session::get('locale') =="ar")
                                @if (isset($free->title_ar)) {!! substr($free->title_ar, 0, 60) !!}
                                @endif
                                @else
                                @if (isset($free->title_en)) {!! substr($free->title_en, 0, 60) !!}
                                @endif
                                @endif
                                
                            </a></h3>



                        <p class="cp">

                            @if (Session::get('locale') =="ar")
                            @if (isset($free->short_desc_ar)) {!! substr($free->short_desc_ar, 0, 85) !!}...
                            @endif
                                @else
                                @if (isset($free->short_desc_en)) {!! substr($free->short_desc_en, 0, 85) !!}...
                            @endif
                                @endif
                           
                        </p>
                    </div>
                    <div class="course-card-info-wrap pad102">
                        <p class="course-card-author d-flex justify-content-between fs13">
                            <span>
                                <i class="la la-user fs18"></i> by <a
                                    href="{{ URL::to('user-profile/' . $free->author->id) }}">
                                    @if ($free->author){{ $free->author->name }}
                                    @endif
                                </a>
                            </span>

                        </p>

                        <p class="course-card-author d-flex justify-content-between fs13">
                            @if ($free->category)
                                <span>
                                    <i class="la la-file fs18"></i> in
                                    <a>{{ $free->category->category_name }}</a>
                                </span>
                            @endif
                        </p>

                    </div>

                    <div class="courses-box-footer footerpad">
                        <div align="center"><a href="@if ($free->document) {!! asset('uploads/free_resources_documents/' . $free->document) !!} @endif" target="_blank"><i
                                    class="bx bx-download"></i> Download</a></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif









<!--------------new----------->
{!! $free_resources->render() !!}
