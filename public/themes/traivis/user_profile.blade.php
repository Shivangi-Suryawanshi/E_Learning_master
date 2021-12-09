@extends('layouts.website')

@section('content')

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

    <section class="my-account-area ptb-700">
        <div class="container">
            <div class="myAccount-profile">
                <div class="row align-items-center">
                    <div class="col-lg-3" align="center">
                        <div class="profile-image">
                            <img src="@if ($user->profile_pic) {!! asset('assets/profile_pics/' . $user->profile_pic) !!}
                        @else {!! asset('assets/img/user.png') !!} @endif" alt="image" style="box-shadow: 0px 0px 0px
                            0px rgb(0 0 0 / 20%);border-radius: 50%;margin-left: 15px;margin: 10px;" class="img-responsive">
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="profile-content">
                            <h3>{{ $user->name }}</h3>
                            <h6 style="color: #2daae1;
                                                                                                    font-size: 14px;
                                                                                                    margin-top: -5px;">
                                @if ($user->user_type == 'student')
                                    Student
                                @elseif($user->user_type=='company')
                                    Company
                                @elseif($user->user_type == "instructor")
                                   Training Center

                                @endif
                            </h6>
                            @php
                         $trainingCenter = App\TrainingCenter::whereUserId($user->id)->first();
                                
                            @endphp
                            
                                <p> 
                                    @if(Auth::user()->user_type == "instructor") 
                                    @if($trainingCenter) 
                                    {{$trainingCenter->about_me}} 
                                    @endif 
                                    @else 
                                    {!! $user->about_me !!}  @endif 
                                  </p>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="contact-info mtm00">
                                        <li><i class="la la-envelope"></i> <a >
                                            @if ($user->email) {{ $user->email }} @endif
                                        
                                         </a></li>
                                         <li>
                                             @if($traininCenterLaganguages)
                                             <i class="la la-building"></i> <a href="">
                                            @if(all_languages())
                                            @foreach (all_languages() as $key => $language)
                                             @if (in_array($language->id, $traininCenterLaganguages))
                                            {{$language->en_language}},
                                             @endif 
                                             @endforeach @endif </a></li>
                                             @endif

                                             @if($trainerLaganguages)
                                             <i class="la la-building"></i> <a href="">
                                            @if(all_languages())
                                            @foreach (all_languages() as $key => $language)
                                             @if (in_array($language->id, $trainerLaganguages))
                                            {{$language->en_language}},
                                             @endif 
                                             @endforeach @endif </a></li>
                                             @endif

                                         {{-- @if ($user->address)
                                            <li><i class="la la-building"></i> <a href="#">{{ $user->address }}</a></li>
                                         @endif
                                         @if ($user->address_2)
                                            <li><i class="la la-map-marker" aria-hidden="true"></i> <a
                                                    href="#">{{ $user->address_2 }}</a></li>
                                         @endif --}}






                                        {{-- <li><i class="bx bx-world"></i> <a href="#" target="_blank">{{ $user->email }}</a></li> --}}
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="contact-info mtm20">
                                        @if ($user->phone)
                                            <li><i class="la la-phone"></i> <a href="#">{{ $user->phone }}</a></li>
                                        @endif

                                        {{-- @if ($user->website) --}}
                                            <li><i class="la la-globe"></i> <a href="#">  
                                                @if(Auth::user()->user_type == "instructor") 
                                                @if($trainingCenter) 
                                                {{$trainingCenter->website_url}} 
                                                @endif  @else {{ $user->website }} @endif</a></li>
                                        {{-- @endif --}}



                                        {{-- <li><i class="bx bx-world"></i> <a href="#" target="_blank">{{ $user->email }}</a></li> --}}
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="container">
            <h3>My Courses</h3>
            <div class="row">

                <div class="col-md-12">
                    @if ($courses->count())
                        <p class="txt-black  mb-3"> Showing {{ $courses->count() }} from {{ $courses->total() }}
                            results
                        </p>

                        <div class="row">
                            @foreach ($courses as $course)
                                {!! course_card($course, 'col-md-3') !!}
                            @endforeach
                        </div>
                    @else
                        {!! no_data() !!}
                    @endif

                    {!! $courses->links() !!}

                </div>
            </div>
        </div>


    </section>



@endsection
