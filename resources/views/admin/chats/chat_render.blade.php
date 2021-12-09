<div class="headind_srch down-message">
    <div class="recent_heading txtlft">
        <h4>{{ ucwords($user->name) }}</h4>
    </div>
    <div class="srch_bar">

    </div>
</div>
@if ($completeChats)

    @foreach ($completeChats as $key => $completeChat)

        @if ($completeChat->sender_id == $auth && $completeChat->receiver_id == $receiverUserId)

            <div class="outgoing_msg ">
                <div class="sent_msg">
                    <p>{!! $completeChat->message !!}</p>
                    <span class="time_date"> {{ $completeChat->time }} |
                        {{ $completeChat->created_at->format('D') }}
                       | {{ Carbon\Carbon::parse($completeChat->date)->format('Y M d') }}</span>
                </div>
            </div>
        @endif
        @if ($completeChat->receiver_id == $auth && $completeChat->sender_id == $receiverUserId)

            <div class="incoming_msg mt10 ml30 ">
                <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                </div>

                <div class="received_msg">
                    <div class="received_withd_msg">
                        <p> {!! $completeChat->message !!} </p>
                        <span class="time_date"> {{ $completeChat->time }} |
                            {{ $completeChat->created_at->format('D') }}
                        | {{ Carbon\Carbon::parse($completeChat->date)->format('Y M d') }}</span>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif
{{-- 
<a class="gotobottom"> <i class="fa fa-chevron-down" aria-hidden="true"></i>  </a>
<div class="cnt">2</div> --}}

