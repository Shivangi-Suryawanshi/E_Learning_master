
    
               
                    <div class="inbox_chat">
                        @if (count($userSearch) > 0)
                            @foreach ($userSearch as $key => $user)

                                <div class="chat_list @if ($key==0) active_chat @endif" data-id="{{ $user->id }}">
                                    <div class="chat_people">
                                        <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png"
                                                alt="sunil"> </div>
                                        <div class="chat_ib">
                                            <h5>{{ ucwords($user->name) }}
                                                {{-- <span class="chat_date">{{ $today }}</span> --}}
                                            </h5>
                                            @if (unreadReciverMessages($user->id)) <span
                                                    class='badge badge-warning float-right hide-count{{ $user->id }}'>
                                                    {{ unreadReciverMessages($user->id) }} </span> @endif
                                            <p>{{ $user->user_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if(Auth::user()->user_type == "company")
                            @if (count($contactorSearch) > 0)
                            @foreach ($contactorSearch as $key => $contactorSearchuser)

                                <div class="chat_list @if ($key==0) active_chat @endif" data-id="{{ $contactorSearchuser->id }}">
                                    <div class="chat_people">
                                        <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png"
                                                alt="sunil"> </div>
                                        <div class="chat_ib">
                                            <h5>{{ ucwords($contactorSearchuser->name) }}
                                                {{-- <span class="chat_date">{{ $today }}</span> --}}
                                            </h5>
                                            @if (unreadReciverMessages($contactorSearchuser->id)) <span
                                                    class='badge badge-warning float-right hide-count{{ $contactorSearchuser->id }}'>
                                                    {{ unreadReciverMessages($contactorSearchuser->id) }} </span> @endif
                                            <p>{{ $contactorSearchuser->user_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                            @endif
                            {{-- @else
                            <p>no user found</p> --}}
                        @endif
                    </div>
          

