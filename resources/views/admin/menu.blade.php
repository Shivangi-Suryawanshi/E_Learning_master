<div class="navbar-default sidebar" role="navigation">
    <div id="adminmenuback"></div>
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('admin') }}"><i class="la la-dashboard fa-fw"></i> @lang('admin.admin_home')</a>
            </li>

            @php
                do_action('admin_menu_item_before');
            @endphp
            {{-- User Management --}}
            @if (can('browse_users'))
                <li>
                    <a href="#"><i class="la la-newspaper-o fa-fw"></i> {{ __a('user_management') }}<span
                            class="la arrow"></span></a>
                    <ul class="nav nav-second-level" style="display: none;">
                        @if (can('browse_users'))
                            <li> <a href="{{ route('users') }}"> {{ __a('users') }}</a>
                            </li>
                        @endif
                        @if (can('browse_sub_admin'))
                            <li>
                                <a href="{{ url('/register?type=sub-admin') }}">
                                    @lang('admin.sub_admin')</a>
                            </li>
                        @endif
                    </ul><!-- /.nav-second-level -->
                </li>
            @endif
            {{-- Course Management --}}
            @if (can('browse_course'))
                <li>
                    <a href="#"><i class="la la-book fa-fw"></i> {{ __a('course_management') }}<span
                            class="la arrow"></span></a>
                    <ul class="nav nav-second-level" style="display: none;">
                        @if (can('browse_categories'))
                            <li>
                                <a href="{{ route('category_index') }}">
                                    @lang('admin.categories')</a>
                            </li>
                        @endif
                        @if (can('browse_course'))
                            <li> <a href="{{ route('admin_courses') }}">
                                    {{ __a('courses') }}</a> </li>
                        @endif
                        @if (can('browse_live_schedule_details'))
                            <li> <a href="{{ route('live_schedule') }}">
                                    {{ __a('live_schedule') }}</a> </li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- CMS Management --}}
            @if (can('browse_cms'))
                <li>
                    <a href="#"><i class="la la-edit fa-fw"></i> @lang('admin.cms')<span class="la arrow"></span></a>
                    <ul class="nav nav-second-level" style="display: none;">
                        {{-- <li> <a href="{{ route('posts') }}">@lang('admin.posts')</a>
                </li> --}}
                        <li> <a href="{{ route('admin_pages') }}"> @lang('admin.pages')</a> </li>
                        <li> <a href="{{ route('admin_banners') }}"> Page Banners</a> </li>
                        <li> <a href="{{ URL::to('/admin/home-page-sections') }}">Home Page Sections</a> </li>
                        <li> <a href="{{ URL::to('/admin/home-banner-images') }}">Home Page Banners</a> </li>
                        <li> <a href="{{ URL::to('/admin/testimonials') }}">Testimonials</a> </li>
                    </ul><!-- /.nav-second-level -->
                </li>
            @endif
            {{-- Payment Mnagement --}}
            @if (can('browse_payments'))
                <li>
                    <a href="#"><i class="la la-wallet fa-fw"></i> {{ __a('payment_management') }}<span
                            class="la arrow"></span></a>
                    <ul class="nav nav-second-level" style="display: none;">
                        @if (can('browse_payments'))
                            <li> <a href="{{ route('payments') }}"><i class=""></i>
                                    {{ __a('payments') }}</a>
                            </li>

                            @if (can('browse_payment_gatway'))
                                <li> <a href="{{ route('payment_gateways') }}">@lang('admin.payment_gateways')</a>
                                </li>
                            @endif
                            @if (can('browse_withdraws'))
                                <li> <a href="{{ route('withdraws') }}"><i></i> {{ __a('withdraws') }}</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </li>
            @endif

            {{-- Subscription --}}
            @if (can('browse_cms'))
                <li>
                    <a href="#"><i class="la la-edit fa-fw"></i><span
                            class="la arrow"></span>{{ __a('subscription') }}</a>
                    <ul class="nav nav-second-level" style="display: none;">
                        {{-- <li> <a href="{{ route('posts') }}">@lang('admin.posts')</a>
                </li> --}}
                        <li> <a href="{{ url('admin/functionality') }}"> {{ __a('functionality') }}</a> </li>
                        <li> <a href="{{ url('admin/packages') }}"> {{ __a('packages') }}</a> </li>
                        <li> <a href="{{ route('package_subscription') }}"> {{ __a('subscription') }}</a> </li>

                    </ul><!-- /.nav-second-level -->
                </li>
            @endif


            {{-- Settings --}}
            @if (can('browse_settings'))
                <li>
                    <a href="#"><i class="la la-tools fa-fw"></i> @lang('admin.settings')<span
                            class="la arrow"></span></a>
                    <ul class="nav nav-second-level" style="display: none;">
                        @php
                            do_action('admin_menu_settings_item_before');
                        @endphp
                        {{-- @if (can('browse_module'))
                         <li>
                             <a href="{{ route('module') }}"><i class="la la-photo-video"></i> @lang('admin.module')</a>
                         </li>
                     @endif --}}
                        @if (can('browse_roles'))
                            <li>
                                <a href="{{ route('roles') }}"><i></i> @lang('admin.roles')</a>
                            </li>
                        @endif
                        @if (can('browse_payment_settings'))
                            <li> <a href="{{ route('payment_settings') }}">@lang('admin.payment_settings')</a> </li>
                        @endif
                        @if (can('browse_genaral_settings'))
                            <li> <a href="{{ route('general_settings') }}">@lang('admin.general_settings')</a> </li>
                        @endif
                        @if (can('browse_lms_settings'))
                            <li> <a href="{{ route('lms_settings') }}">@lang('admin.lms_settings')</a> </li>
                        @endif


                        @if (can('browse_theme_settings'))
                            <li> <a href="{{ route('theme_settings') }}">@lang('admin.theme_settings')</a> </li>
                        @endif
                        {{-- <li> <a
                            href="{{ route('invoice_settings') }}">@lang('admin.invoice_settings')</a> </li> --}}
                        {{-- <li> <a href="{{ route('social_settings') }}">
                            {{ __a('social_login_settings') }} </a> </li> --}}
                        @if (can('browse_storage_setting'))
                            <li> <a href="{{ route('storage_settings') }}"> {{ __a('storage') }} </a> </li>
                        @endif

                        @if (can('browse_withdraw_setting'))
                            <li> <a href="{{ route('withdraw_settings') }}">@lang('admin.withdraw')</a> </li>
                        @endif
                        @if (can('browse_translation'))
                            <li> <a href="{{ route('translation') }}"><i></i> {{ __a('translation') }}</a>
                            </li>
                        @endif
                        @if (can('browse_translation'))
                            <li> <a href="{{ route('contact-list') }}"><i></i> {{ __a('contact') }}</a>
                            </li>
                        @endif
                        @php
                            do_action('admin_menu_settings_item_after');
                        @endphp




                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            @endif


            <li> <a href="{{ URL::to('admin/free-resources') }}"><i class="la la-cubes"></i> Free Resources</a>
            </li>


            <li> <a href="{{ route('messages') }}"><i class="la la-envelope"></i> {{ __a('message') }}
                    @if (unreadMessages()) <span
                            class='badge badge-warning float-right hide-count'> {{ unreadMessages() }} </span>
                    @endif
                </a> </li>
            @if (can('browse_email_template'))
                <li c> <a href="{{ route('email_template') }}"> <i class="la la-envelope"></i>
                        {{ __t('email_template') }}</a> </li>
            @endif



            {{-- <li> <a href="{{ route('change_password') }}"><i class="la la-lock"></i>
                    @lang('admin.change_password')</a>
            </li> --}}


            @php
                do_action('admin_menu_item_after');
            @endphp

            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="la la-sign-out"></i> {{ __a('logout') }}
                </a>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
