@extends(theme('dashboard.layouts.dashboard'))

<style>
    .generated-star-rating-wrap {
    color: #f2b827 !important;
}
    </style>

@section('content')

<div class="page-header">
    <h5 class="page-header-left mt5"> Reviews </h5>
    <hr>
</div>

    @php
    $reviews = $auth_user->reviews()->with('course')->orderBy('created_at', 'desc')->get();
    @endphp

    @if($reviews->count())
        @foreach($reviews as $review)
            <div class="my-review p-4 mb-3 bg-white border">
                <a href="{{route('review', $review->id)}}" class="text-muted mb-3 d-block" >{{$review->created_at->diffForHumans()}}</a>

                <a href="{{route('course', $review->course->slug)}}" class="mb-3 d-block"><h5>{{$review->course->title}}</h5></a>

                {!! star_rating_generator($review->rating) !!}

                @if($review->review)
                    <div class="review-desc mt-3">
                        {!! nl2br($review->review) !!}
                    </div>
                @endif
            </div>
        @endforeach
    @else
        {!! no_data(null, null, 'my-5' ) !!}
    @endif

@endsection
