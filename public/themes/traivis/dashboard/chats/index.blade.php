@extends(theme('dashboard.layouts.dashboard'))
<link rel="stylesheet" href="{{asset('assets/css/chat.css')}}">


@section('content')
    <div class="page-header px-4">
        <h4 class="page-header-left mt5"> Messaging </h4>
    </div>
    <div class="container">
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        <div class="recent_heading">
                            <h4>Recent</h4>
                        </div>
                        <div class="srch_bar">
                            <div class="stylish-input-group">
                                <input type="text" class="search-bar keyword livesearch search-user" name="" placeholder="Search">
                                <span class="input-group-addon">
                                    <button type="button"> <i class="fa fa-search search-btn" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="inbox_chat">
                        {{-- <div class="chat_list active_chat">
                            <div class="chat_people">
                                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png"
                                        alt="sunil"> </div>
                                <div class="chat_ib">
                                    <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                                    <p>Test, which is a new approach to have all solutions
                                        astrology under one roof.</p>
                                </div>
                            </div>
                        </div> --}}

                        @if ($users)
                            @if (count($users) > 0)
                                @foreach ($users as $key => $user)
                                {{$user->parent_company}}
                                    <div class="chat_list @if ($key==0) active_chat @endif" data-id="{{ $user->id }}">
                                        <div class="chat_people">
                                            @if($user->profile_pic )
                                        <div class="chat_img"> <img
                                                src="{{asset('website/assets/profile_pics/'.$user->profile_pic)}}" alt="sunil">
                                        </div>
                                        @else
                                        <div class="chat_img"> <img
                                            src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                    </div>
                                        @endif
                                            @php
                                            $chatTime = App\Chat::orWhere('sender_id',$user->id)->orWhere('receiver_id',$user->id)->latest()->first();
                                        @endphp

                                            <div class="chat_ib">
                                                <h5>{{ ucwords($user->name) }}   <span class="chat_date">@if($chatTime){{Carbon\Carbon::parse($chatTime->date)->format('M d')}} @else  @endif</span>
                                                </h5>
                                            @if(unreadReciverMessages($user->id))   <span class='badge badge-warning float-right hide-count{{$user->id}}'> {{unreadReciverMessages($user->id)}} </span> @endif

                                                <p>{{ $user->user_type }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif

                        @if ($parentCompany)
                        @if (count($parentCompany) > 0)
                            @foreach ($parentCompany as $key => $parentCompanyList)
                           
                                <div class="chat_list @if ($key==0) active_chat @endif" data-id="{{ $parentCompanyList->id }}">
                                    <div class="chat_people">
                                        @if($parentCompanyList->profile_pic )
                                        <div class="chat_img"> <img
                                                src="{{asset('website/assets/profile_pics/'.$parentCompanyList->profile_pic)}}" alt="sunil">
                                        </div>
                                        @else
                                        <div class="chat_img"> <img
                                            src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                    </div>
                                        @endif
                                        <div class="chat_ib">
                                            <h5>{{ ucwords($parentCompanyList->name) }}  <span class="chat_date">{{ $today }}</span>
                                            </h5>
                                        @if(unreadReciverMessages($parentCompanyList->id))   <span class='badge badge-warning float-right hide-count{{$parentCompanyList->id}}'> {{unreadReciverMessages($parentCompanyList->id)}} </span> @endif

                                            <p>{{ $parentCompanyList->user_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif


                    {{-- training center  --}}
                    @if ($student)
                    @if (count($student) > 0)
                        @foreach ($student as $key => $studentPortal)
                        @if($studentPortal->author)
                            <div class="chat_list @if ($key==0) active_chat @endif" data-id="{{ $studentPortal->author->id }}">
                                <div class="chat_people">
                                    @if($studentPortal->author->profile_pic )
                                    <div class="chat_img"> <img
                                            src="{{asset('website/assets/profile_pics/'.$studentPortal->author->profile_pic)}}" alt="sunil">
                                    </div>
                                    @else
                                    <div class="chat_img"> <img
                                        src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                </div>
                                    @endif
                                    <div class="chat_ib">
                                        @php
                                        $chatTime = App\Chat::orWhere('sender_id',$user->id)->orWhere('receiver_id',$studentPortal->author->id)->latest()->first();
                                    @endphp
                                        <h5>{{ ucwords($studentPortal->author->name) }} 
                                            <span class="chat_date">@if($chatTime){{Carbon\Carbon::parse($chatTime->date)->format('M d')}} @else  @endif</span>
                                        </h5>
                                    @if(unreadReciverMessages($studentPortal->author->id))   <span class='badge badge-warning float-right hide-count{{$studentPortal->author->id}}'> {{unreadReciverMessages($studentPortal->author->id)}} </span> @endif

                                        <p>{{ $studentPortal->author->user_type }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
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
    {{-- https://www.positronx.io/laravel-autocomplete-search-with-select2-example/
    --}}
@endsection

@section('page-js')

<script src="{{asset('assets/js/chat.js')}}"></script>
 

@endsection
