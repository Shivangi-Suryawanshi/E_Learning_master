<?php

use Illuminate\Support\Facades\Auth;

function dashboard_menu(){

    $menu = [];

    //$menu['route_name'] = 'value';


    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user->isInstructor()) {

        $pendingDiscusionBadge = '';
        $pendingDiscussionCount = $user->instructor_discussions->where('replied', 0)->count();
        if ($pendingDiscussionCount){
            $pendingDiscusionBadge = "<span class='badge badge-warning float-right'> {$pendingDiscussionCount} </span>";
        }


        $menu = apply_filters('dashboard_menu_for_instructor', [
            // 'create_course' => [
            //     'name' => __t('create_new_course'),
            //     'icon' => '<i class="la la-chalkboard-teacher"></i>',
            //     'is_active' => request()->is('dashboard/courses/new'),
            // ],
            // 'my_courses' => [
            //     'name' => __t('my_courses'),
            //     'icon' => '<i class="la la-graduation-cap"></i>',
            //     'is_active' => request()->is('dashboard/my-courses'),
            // ],

            // 'vimeo_manager' => [
            //     'name' => __t('vimeo_manager'),
            //     'icon' => '<i class="la la-video"></i>',
            //     'is_active' => request()->is('dashboard/vimeo-manager'),
            // ],
            // 'bidding_request' => [
            //     'name' => __t('bidding_request'),
            //     'icon' => '<i class="la la-graduation-cap"></i>',
            //     'is_active' => request()->is('dashboard/bidding-request'),
            // ],
            // 'earning' => [
            //     'name' => __t('earnings'),
            //     'icon' => '<i class="la la-comment-dollar"></i>',
            //     'is_active' => request()->is('dashboard/earning*')
            // ],
            // 'withdraw' => [
            //     'name' => __t('withdraw'),
            //     'icon' => '<i class="la la-wallet"></i>',
            //     'is_active' => request()->is('dashboard/withdraw*'),
            // ],
            // 'my_courses_reviews' => [
            //     'name' => __t('my_courses_reviews'),
            //     'icon' => '<i class="la la-star"></i>',
            //     'is_active' => request()->is('dashboard/my-courses-reviews*'),
            // ],
            // 'calender' => [
            //     'name' => __t('calender'),
            //     'icon' => '<i class="la la-calendar"></i>',
            //     'is_active' => request()->is('dashboard/calender'),
            // ],
            // 'packages' => [
            //     'name' => __t('packages'),
            //     'icon' => '<i class="la la-server"></i>',
            //     'is_active' => request()->is('dashboard/packages'),
            // ],
            // 'functionality' => [
            //     'name' => __t('functionality'),
            //     'icon' => '<i class="la la-cubes"></i>',
            //     'is_active' => request()->is('dashboard/functionality'),
            // ],
            

            // 'courses_has_quiz' => [
            //     'name' => __t('quiz_attempts'),
            //     'icon' => '<i class="la la-check-double"></i>',
            //     'is_active' => request()->is('dashboard/courses-has-quiz*'),
            // ],
            // 'courses_has_assignments' => [
            //     'name' => __t('assignments'),
            //     'icon' => '<i class="la la-star"></i>',
            //     'is_active' => request()->is('dashboard/assignments*'),
            // ],
            // 'instructor_discussions' => [
            //     'name' => __t('discussions') . $pendingDiscusionBadge,
            //     'icon' => '<i class="la la-question-circle-o"></i>',
            //     'is_active' => request()->is('dashboard/discussions*'),
            // ]
        ]);

    }
    $totalMsgCount  = unreadMessages();
    if(Auth::user()->user_type =="student")
    {
    $msgCount= "";
        if($totalMsgCount > 0)
        {
            $msgCount = "<span class='badge badge-warning float-right hide-count'> {$totalMsgCount} </span>";
        }

    $menu = $menu + apply_filters('dashboard_menu_for_users', [
        'company_request' => [
            'name' => __t('company_request'),
            'icon' => '<i class="la la-pencil-square-o"></i>',
            'is_active' => request()->is('dashboard/company-request*'),
        ],
        'enrolled_courses' => [
            'name' => __t('enrolled_courses'),
            'icon' => '<i class="la la-pencil-square-o"></i>',
            'is_active' => request()->is('dashboard/enrolled-courses*'),
        ],
        'wishlist' => [
            'name' => __t('wishlist'),
            'icon' => '<i class="la la-heart-o"></i>',
            'is_active' => request()->is('dashboard/wishlist*'),
        ],
        'reviews_i_wrote' => [
            'name' => __t('reviews'),
            'icon' => '<i class="la la-star-half-alt"></i>',
            'is_active' => request()->is('dashboard/reviews-i-wrote*'),
        ],
        'my_quiz_attempts' => [
            'name' => __t('my_quiz_attempts'),
            'icon' => '<i class="la la-question-circle-o"></i>',
            'is_active' => request()->is('dashboard/my-quiz-attempts*'),
        ],
        'purchase_history' => [
            'name' => __t('purchase_history'),
            'icon' => '<i class="la la-history"></i>',
            'is_active' => request()->is('dashboard/purchases*'),
        ],
        'messages' => [
            'name' => __t('message')  . $msgCount,
            'icon' => '<i class="la la-envelope"></i>',
            'is_active' => request()->is('dashboard/messages*'),
        ],
        'profile_settings' => [
            'name' => __t('settings'),
            'icon' => '<i class="la la-tools"></i>',
            'is_active' => request()->is('dashboard/settings*'),
        ],
        'certificate' => [
                'name' => __t('certificate'),
                'icon' => '<i class="la la-graduation-cap"></i>',
                'is_active' => request()->is('dashboard/certificate*'),
            ],
    ]);
    }
    if ($user->is_admin){
        $menu['admin'] = [
            'name' => __t('go_to_admin'),
            'icon' => '<i class="la la-cogs"></i>',
        ];
    }



    return apply_filters('dashboard_menu_items', $menu);
}


function course_edit_navs(){

    $nav_items = apply_filters('course_edit_nav_items', [
        'edit_course_information' => [
            'name' => __t('information'),
            'icon' => '<i class="la la-info-circle"></i>',
            'is_active' => request()->is('dashboard/courses/*/information'),
        ],
        'edit_course_curriculum' => [
            'name' => __t('curriculum'),
            'icon' => '<i class="la la-th-list"></i>',
            'is_active' => request()->is('dashboard/courses/*/curriculum'),
        ],
        'edit_course_pricing' => [
            'name' => __t('pricing'),
            'icon' => '<i class="la la-cart-arrow-down"></i>',
            'is_active' => request()->is('dashboard/courses/*/pricing'),
        ],
        'edit_course_drip' => [
            'name' => __t('drip'),
            'icon' => '<i class="la la-fill-drip"></i>',
            'is_active' => request()->is('dashboard/courses/*/drip'),
        ],

    ]);


    return $nav_items;
}
