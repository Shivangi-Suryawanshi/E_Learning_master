@extends(theme('dashboard.layouts.dashboard'))

<style>
.profile-text-photo {    padding: 10px;
    border-radius: 5px;
    margin-right: 10px;}

    .generated-star-rating-wrap {color: #ff9800;}

    .bg-default {    background-color: #efeff1!important;
        padding: 10px;
        border-radius: 5px;}

        .mtm15 { margin-top: -15px;}

    </style>

@section('content')

    @php
    $reviews = $auth_user->get_reviews()->with('course', 'user', 'user.photo_query')->orderBy('created_at', 'desc')->paginate(20);
    @endphp

    @if($reviews->total())

        <p class="text-muted mb-3"> Showing {{$reviews->count()}} from {{$reviews->total()}} results </p>


        @foreach($reviews as $review)
            <div class="my-review p-4 mb-3 bg-white border">

                <div class="d-flex mb-2">


                    <div class="reviewed-user-photo">
                        <a href="{{route('profile', $review->user_id)}}">
                            @if($review->user)
                            {!! $review->user->get_photo !!}
                            @endif
                        </a>
                    </div>

                    <div class="reviewed-user-detail mtm15">

                        <a href="{{route('profile', $review->user_id)}}" class="mb-2 d-block">
                            @if($review->user)
                            {!! $review->user->name !!}
                            @endif
                        </a>

                        <div class="d-flex">
                            {!! star_rating_generator($review->rating) !!}
                            <span class="ml-2">({{$review->rating}})</span>
                            <a href="{{route('review', $review->id)}}" class="text-muted d-block ml-3" >{{$review->created_at->diffForHumans()}}</a>
                        </div>

                    </div>

                </div>


                <h5><a href="{{route('course', $review->course->slug)}}" class="mb-3 d-block">{{$review->course->title}}</a></h5>

                @if($review->review)
                    <div class="review-desc bg-default mt-3">
                        {!! nl2br($review->review) !!}
                    </div>
                @endif
            </div>
        @endforeach

        {!! $reviews->links(); !!}
    @else
        {!! no_data(null, null, 'my-5' ) !!}
    @endif

@endsection


{{-- location ~ \.php$ {
    try_files $uri /index.php =404;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
} --}}

