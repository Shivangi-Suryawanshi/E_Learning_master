@extends('layouts.admin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">

@endsection
@section('content')


    <div class="container-fluid ">
        <div class="messaging ">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Recent</h4>
                        </div>
                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar keyword livesearch search-user" id="search-user"
                                    placeholder="Search">

                                <span class="input-group-addon">
                                    <button type="button"> <i class="fa fa-search search-btn" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="inbox_chat">
                        @if (count($users) > 0)
                            @foreach ($users as $key => $user)

                                <div class="chat_list @if ($key==0) active_chat @endif" data-id="{{ $user->id }}">
                                    <div class="chat_people">
                                        <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png"
                                                alt="sunil">  </div>
                                        <div class="chat_ib">
                                            <h5>{{ ucwords($user->name) }}
                                                @php
                                                $chatTime = App\Chat::orWhere('sender_id',$user->id)->orWhere('receiver_id',$user->id)->latest()->first();
                                            @endphp
                                               <span class="chat_date">@if($chatTime){{Carbon\Carbon::parse($chatTime->date)->format('M d')}} @else  @endif</span></h5>
                                                {{-- <span class="chat_date">@if($user->messsageLastTime){{Carbon\Carbon::parse($user->messsageLastTime->date)->format('M d')}} @else {{$today}} @endif</span> --}}
                                          
                                            @if (unreadReciverMessages($user->id)) <span
                                                    class='badge badge-warning float-right hide-count{{ $user->id }}'>
                                                    {{ unreadReciverMessages($user->id) }} </span> @endif
                                            <p>{{ $user->user_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="mesgs down-message">
                    <div class="msg_history down-message" id="msg_history">
                        <div align="center">
                        <img src="assets/images/chat.png" class="mt50">
                        <h4 classs="text-center">Messages, Keep Connected.</h4>
                        </div>
                    </div>
                    <div class="type_msg" style="display: none;">
                        <form id="sendMsg">
                            <div class="input_msg_write">
                                <input type="hidden" name="receiver_id" id="receiver_id" value="">
                                <input type="text" name="msg" id="msg" class="write_msg" placeholder="Type a message" />
                                <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o"
                                        aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>

@endsection

@section('page-js')
    <script src="{{ asset('assets/js/chat.js') }}"></script>

@endsection
