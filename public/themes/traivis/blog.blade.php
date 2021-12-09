@extends('layouts.theme')

@section('content')


    <div class="blog-post-page-header bg-dark-blue text-white text-center py-5">
        <div class="container py-3">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="mb-3">{{$title}}</h1>
                </div>
            </div>
        </div>
    </div>


    @if($posts->total())
    <div class="blog-posts-wrapper py-5">
        <div class="container">

            <div class="row">
                @foreach($posts as $post)

                    <div class="{{$loop->first? 'col-md-12 blog-feature-post ' : 'col-md-4 blog-regular-post'}} mb-4">
                        <div class="blog-card">
                            <div class="blog-card-thumbnail-wrapper">
                                <a href="{{$post->url}}">
                                    <img src="{{$post->thumbnail_url->image_md}}" alt="{{$post->title}}" class="img-fluid">
                                </a>
                            </div>
                            <div class="excerpt">
                                <h2><a href="{{$post->url}}">{{$post->title}}</a></h2>
                                <div class="post-meta d-flex justify-content-between">
                                    <span>
                                        <i class="la la-user"></i>
                                        <a href="{{route('profile', $post->user_id)}}">
                                            {{$post->author->name}}
                                        </a>
                                    </span>
                                    <span>&nbsp;<i class="la la-calendar"></i>&nbsp; {{$post->published_time}}</span>
                                </div>

                                <div class="excerpt-content my-4">
                                    {!! str_limit(strip_tags($post->post_content), 300) !!}
                                </div>

                                <p class="mt-4">
                                    <a href="{{$post->url}}"><strong>READ MORE <i class="la la-arrow-right"></i> </strong></a>
                                </p>
                            </div>
                        </div>
                    </div>


                @endforeach
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="pagination-wrapper">
                        {!! $posts->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

    @else

        {!! no_data() !!}

    @endif


@endsection
