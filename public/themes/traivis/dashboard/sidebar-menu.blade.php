@if (Auth::check())
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#!">

            <style>
                .sidebar ul li a:not(.active):hover,
                .sidebar ul li a:not(.active):focus {
                    background-color: transparent;
                    color: #fff;
                }

                .sidebar .nav-item:last-child {
                    margin-bottom: 0rem;
                }


                @media (min-width: 768px) {
                    .sidebar .nav-item .nav-link span {
                        font-size: 0.85rem;
                        display: inline;
                        border-radius: 50px;
                        margin-top: 5px !important;
                        margin-right: 15px;
                    }
                }

                .bbt:hover {
                    background-color: rgba(0, 0, 0, 0.05);
                    opacity: 1;
                }

            </style>

            <link
                href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300;400;500;523;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
                rel="stylesheet">



            <div class="sidebar-user">
                @if (Auth::user()->profile_pic != null)
                    <img src="{!! asset('assets/profile_pics/' . Auth::user()->profile_pic) !!}" class="avatar rounded-circle w10" alt="Avatar image">

                @else
                    <img src="{{ theme_asset('website/img/user.png') }}" class="avatar rounded-circle w10"
                        alt="Avatar image">
                @endif
                @if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'instructor')
                    <div>
                        <div class="user-name">{{ ucwords(Auth::user()->name) }}</div>
                        @if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'instructor')
                            <span class="badge badge-primary user-name2">Training Center </span>
                        @endif
                        {{-- @if (Auth::user()->user_type == 'instructor')
                       <span class="badge badge-primary user-name2">Instructor Profile</span>
                       @endif --}}

                    </div>
                @endif
                @if (Auth::user()->user_type == 'student')
                    <div>
                        <div class="user-name">{{ ucwords(Auth::user()->name) }}</div>
                        <span class="badge badge-primary user-name2">Individual </span>
                    </div>
                @endif
                @if (Auth::user()->user_type == 'trainer')
                    <div>
                        <div class="user-name">{{ ucwords(Auth::user()->name) }}</div>
                        <span class="badge badge-primary user-name2">Trainers </span>
                    </div>
                @endif
            </div>

        </a>



        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}"><a style="margin-top: 20px;"
                class="nav-link" href="{{ route('dashboard') }}"> <i class="fa fa-tachometer" aria-hidden="true"></i>
                {{ __t('dashboard') }} </a></li>
       
        {{-- course management --}}
        @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'trainer')



            <div>
                <ul class="nav in" id="side-menu" style="margin-top: 0px;">
                    {{-- Assigned Course --}}
                    @if (Auth::user()->user_type == 'trainer')
                        <li class="nav-item">
                            <a href="#!" class="nav-link"><i class="fa fa-book"></i>
                                {{ __t('assinged_course') }}<span class="la arrow"></span></a>
                            <ul class="nav nav-second-level" style="display: none;">
                                <li class="{{ request()->is('dashboard/assingned-courses') ? 'active' : '' }}"><a
                                        href="{{ route('assingned_courses') }}"> {{ __t('assinged_course_list') }} </a>
                                </li>

                                <li class="{{ request()->is('dashboard/my-courses?assigned_type=assigned-course') ? 'active' : '' }}"><a
                                    href="{{ url('dashboard/my-courses?assigned_type=assigned-course') }}"> {{ __t('accepted_assigned_course') }} </a></li>
                                  
                                    {{-- <li class="{{ request()->is('dashboard/courses-has-quiz?assigned_type=assigned-course-quiz') ? 'active' : '' }}"><a
                                        href="{{ url('dashboard/courses-has-quiz?assigned_type=assigned-course-quiz') }}"> {{ __t('quiz_attempts') }} </a></li> --}}
                                        {{-- <li class="{{ request()->is('dashboard/assignments?assignment_type=assignment_type') ? 'active' : '' }}"><a
                                            href="{{ url('dashboard/assignments?assignment_type=assignment_type') }}"> {{ __t('assignments') }} </a>
                                    </li> --}}

                                    {{-- <li class="{{ request()->is('dashboard/discussions?type=discution_type') ? 'active' : '' }}"><a
                                        href="{{ url('dashboard/discussions?type=discution_type') }}"> {{ __t('discussions') }} </a>
                                </li> --}}
                            </ul>
                        </li>

                    @endif

                    {{-- Course management --}}
                    <li class="nav-item">
                        <a href="#!" class="nav-link"><i class="fa fa-book"></i> {{ __t('my_course') }}<span
                                class="la arrow"></span></a>
                        <ul class="nav nav-second-level" style="display: none;">

                            <li class="{{ request()->is('dashboard/courses/new') ? 'active' : '' }}"> <a
                                    href="{{ route('create_course') }}"> {{ __t('create_course') }}</a> </li>

                            <li class="{{ request()->is('dashboard/my-courses') ? 'active' : '' }}"><a
                                    href="{{ route('my_courses') }}"> {{ __t('my_courses') }} </a></li>
                            <li class="{{ request()->is('dashboard/my-courses-reviews') ? 'active' : '' }}"><a
                                    href="{{ route('my_courses_reviews') }}"> {{ __t('my_courses_reviews') }} </a>
                            </li>

                            <li class="{{ request()->is('dashboard/certificate') ? 'active' : '' }}"><a
                                    href="{{ route('certificate') }}"> {{ __t('certificate') }} </a></li>

                            <li class="{{ request()->is('dashboard/courses-has-quiz') ? 'active' : '' }}"><a
                                    href="{{ route('courses_has_quiz') }}"> {{ __t('quiz_attempts') }} </a></li>
                            <li class="{{ request()->is('dashboard/assignments') ? 'active' : '' }}"><a
                                    href="{{ route('courses_has_assignments') }}"> {{ __t('assignments') }} </a>
                            </li>

                            <li class="{{ request()->is('dashboard/discussions') ? 'active' : '' }}"><a
                                    href="{{ route('instructor_discussions') }}"> {{ __t('discussions') }} </a>
                            </li>
                            <li class="{{ request()->is('dashboard/vimeo-manager') ? 'active' : '' }}"><a
                                    href="{{ route('vimeo_manager') }}"> {{ __t('vimeo_manager') }} </a></li>

                       

                                    <li class="{{ request()->is('my-student-portal') ? 'active' : '' }}"><a
                                        href="{{ route('my_student_portal') }}"> {{ __t('purchased_student') }} </a>
                                </li>
                            {{-- @if (Auth::user()->user_type == 'trainer')
                                <li class="{{ request()->is('dashboard/assingned-courses') ? 'active' : '' }}"><a
                                        href="{{ route('assingned_courses') }}"> {{ __t('assinged_course') }} </a>
                                </li>
                                {{-- <li class="{{ request()->is('dashboard/requested-trainer') ? 'active' : '' }}"><a
                                        href="{{ route('requested-trainer') }}"> {{ __t('request_trainer') }} </a>
                                </li> --}}

                            {{-- @endif --}}


                        </ul>
                    </li>
                    @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin')

                    <li class="nav-item {{ request()->is('dashboard/register') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('trainers') }}"> <i class="fa fa-user" aria-hidden="true"></i>
                            {{ __t('my_team') }} </a></li>
                @endif
                    <li class="nav-item {{ request()->is('dashboard/bidding-request') ? 'active' : '' }}"><a
                            class="nav-link" href="{{ route('bidding_request') }}"> <i class="fa fa-credit-card"
                                aria-hidden="true"></i> {{ __t('bidding_request') }} </a></li>




                    {{-- payment management --}}

                    <li class="nav-item">
                        <a href="#!" class="nav-link"><i class="fa fa-credit-card"></i>
                            {{ __t('payments_and_funds') }}<span class="la arrow"></span></a>
                        <ul class="nav nav-second-level" style="display: none;">


                            {{-- <li class="{{ request()->is('dashboard/bidding-request') ? 'active' : '' }}"><a
                                    href="{{ route('bidding_request') }}"> {{ __t('bidding_request') }} </a></li> --}}
                            <li class="{{ request()->is('dashboard/earning') ? 'active' : '' }}"><a
                                    href="{{ route('earning') }}"> {{ __t('earning') }} </a></li>
                            <li class="{{ request()->is('dashboard/withdraw') ? 'active' : '' }}"><a
                                    href="{{ route('withdraw') }}"> {{ __t('withdraw') }} </a></li>
                            <li class="{{ request()->is('dashboard/purchase_history') ? 'active' : '' }}"><a
                                    href="{{ route('purchase_history') }}"> {{ __t('purchase_history') }} </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item {{ request()->is('dashboard/calender') ? 'active' : '' }}"><a
                            class="nav-link" href="{{ route('calender') }}"> <i class="la la-calendar"
                                aria-hidden="true"></i>
                            {{ __t('calender') }} </a></li>

                    <li class="nav-item {{ request()->is('messages') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('messages') }}"> <i class="fa fa-envelope" aria-hidden="true"></i>
                            {{ __t('message') }} </a></li>

                            {{-- Student portal  --}}
                            <li class="nav-item">
                                <a href="#!" class="nav-link"><i class="fa fa-credit-card"></i>
                                    {{ __t('my_student_portal') }}<span class="la arrow"></span></a>
                                <ul class="nav nav-second-level" style="display: none;">
        
                               
                                 
                               

                                <li class="{{ request()->is('dashboard/enrolled-courses') ? 'active' : '' }}"><a
                                    href="{{ route('enrolled_courses') }}"> {{ __t('enrolled_courses') }} </a>
                            </li>

                            <li class="{{ request()->is('dashboard/wishlist') ? 'active' : '' }}"><a
                                    href="{{ route('wishlist') }}"> {{ __t('wishlist') }} </a></li>
                            <li class="{{ request()->is('dashboard/reviews') ? 'active' : '' }}"><a
                                    href="{{ route('reviews_i_wrote') }}"> {{ __t('reviews') }} </a></li>
                            <li class="{{ request()->is('dashboard/my_quiz_attempts') ? 'active' : '' }}"><a
                                    href="{{ route('my_quiz_attempts') }}"> {{ __t('my_quiz_attempts') }} </a>
                            </li>
                                </ul>
                            </li>
                            



                    @if (Auth::user()->user_type == 'trainer')
                        <li class="nav-item {{ request()->is('dashboard/requested-trainer') ? 'active' : '' }}"><a
                                class="nav-link" href="{{ route('requested-trainer') }}"> <i class="fa fa-user"
                                    aria-hidden="true"></i>
                                {{ __t('request_trainer') }} </a></li>
                    @endif


                     @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'trainer')

                             <li  class="nav-item"> <a href="{{ URL::to('dashboard/free-resources') }}"  class="nav-link"><i class="la la-cubes"></i> Free Resources</a>
                        </li>

                     @endif
                    <li class="nav-item {{ request()->is('dashboard/settings') ? 'active' : '' }}"><a
                            class="nav-link" href="{{ url('dashboard/settings') }}"> <i class="fa fa-user"
                                aria-hidden="true"></i>
                            {{ __t('Profile') }} </a></li>
                    <li class="nav-item "><a class="nav-link" href="{{ URL::to('/logout') }}"> <i
                                class="fa fa-sign-out" aria-hidden="true"></i> {{ __t('logout') }} </a></li>




                </ul>
            </div>


        @endif
        @php
            $menus = dashboard_menu();
        @endphp

        @if (is_array($menus) && count($menus))
            @foreach ($menus as $key => $instructor_menu)

                <li class="nav-item {{ array_get($instructor_menu, 'is_active') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route($key) }}"> {!! array_get($instructor_menu, 'icon') !!} {!! array_get($instructor_menu, 'name') !!}
                    </a>
                </li>
            @endforeach
        @endif
        @if (Auth::user()->user_type != 'admin')
            <li class="nav-item "><a class="nav-link"> <i class="fa fa-phone" aria-hidden="true"></i>
                    Contact : @if (contactSupport())
                        {{ contactSupport()->option_value }} @endif </a></li>
            <li class="text-center">
                @if (contactSupport()) <a
                        href="mailto:{{ contactSupport()->option_value }}?Subject=neew%20support"
                        class="btn btn-primary bbt"
                        style="font-size:smaller;    padding: 16px 8px;width: 90%;margin-bottom: 10px;" target="_blank">
                        Support </a> @endif

            </li>
        @endif
        <hr class="sidebar-divider">





    </ul>
@endif


<script src="{{ asset('assets/js/admin.js') }}"></script>
