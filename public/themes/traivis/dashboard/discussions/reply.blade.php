@extends(theme('dashboard.layouts.dashboard'))


@section('content')

<div class="page-header">
    <h5 class="page-header-left mt5"> Discussions </h5>
    <hr>
</div>


    <div class="discussion-single-wrap border p-3 mb-4 bg-white">
        <div class="discussion-user d-flex mb-4">
            {{-- <div class="reviewed-user-photo">
                <a href="{{route('profile', $discussion->user->id)}}">
                    {!! $discussion->user->get_photo !!}
                </a>
            </div> --}}
            <div class="discussion-user-name flex-grow-1">
                <a><h4>{!! $discussion->user->name !!} </h4></a>
                <p class="">
                    <a href="{{route('review', $discussion->id)}}" class="text-muted " >{{$discussion->created_at->diffForHumans()}}</a>
                </p>

                <a href="{{route('discussion_reply', $discussion->id)}}">
                    <h5><i class="la la-question-circle-o"></i> {{$discussion->title}}</h5>
                </a>

                <div class="discusison-details-wrap">
                    {!! nl2br($discussion->message) !!}
                </div>

                @if($discussion->replies->count())
                    @foreach($discussion->replies as $reply)
                        <div class="discussion-single-wrap border p-3 mb-3 mt-4 bg-white">
                            <div class="discussion-user d-flex mb-4">
                                <div class="reviewed-user-photo">
                                    <a>
                                        {!! $reply->user->get_photo !!}
                                    </a>
                                </div>
                                <div class="discussion-user-name flex-grow-1">
                                    <a >{!! $reply->user->name !!}</a>
                                    <p class="">
                                        <a  class="text-muted " >{{$reply->created_at->diffForHumans()}}</a>
                                    </p>

                                    <a href="{{route('discussion_reply', $reply->id)}}">
                                        <h4>{{$reply->title}}</h4>
                                    </a>

                                    <div class="discusison-details-wrap">
                                        {!! nl2br($reply->message) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>



    <div class="discussion-reply-form bg-white my-4 p-4">
        <form action="" method="post">
            @csrf

            <div class="form-group {!! form_error($errors, 'message')->class !!}">
                <textarea class="form-control" name="message" rows="5"></textarea>
                {!! form_error($errors, 'message')->message !!}
            </div>
            <button type="submit" class="btn btn-primary"><i class="la la-question-circle-o"></i> {{__t('send_reply')}} </button>
        </form>
    </div>

@endsection
