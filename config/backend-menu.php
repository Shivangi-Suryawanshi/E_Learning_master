<?php
return ['menus' =>
array(
    array(
        'Name' => 'aaa',
        'slug' => '/',
        'icon-class' => 'fa fa-dashboard',
        'permission' => '',
        'child' => ''
    ),

    array(
        'Name' => 'Roles & permission',
        'slug' => 'roles',
        'icon-class' => 'fa fa-lock',
        'permission' => 'roles',
        'child' => ''
    ),
    array(
        'Name' => 'Module Management',
        'slug' => 'module',
        'icon-class' => 'fa fa-clone',
        'permission' => 'module',
        'child' => ''
    ),

    array(
        'Name' => 'Company Management',
        'slug' => '',
        'icon-class' => 'fa fa-university',
        'permission' => '',
        'child' => array(
            array(
                'Name' => 'Company',
                'slug' => 'company-info',
                'icon-class' => 'fa fa-building',
                'permission' => 'company',
                'child' => ''
            ),
        ),

    ),
    array(
        'Name' => 'Lookup Tables',
        'slug' => '',
        'icon-class' => 'fa fa-archive',
        'permission' => '',
        'child' => array(
            array(
                'Name' => 'Industry',
                'slug' => 'industry',
                'icon-class' => 'fa fa-cogs',
                'permission' => 'module',
                'child' => ''
            ),
            array(
                'Name' => 'Occupation',
                'slug' => 'occupation',
                'icon-class' => 'fa fa-bullhorn',
                'permission' => 'module',
                'child' => ''
            ),
        ),

    ),

    array(
        'Name' => 'User Management',
        'slug' => '',
        'icon-class' => 'fa fa-user',
        'permission' => '',
        'child' => array(
            // array(
            //     'Name' => 'Create User',
            //     'slug' => 'user/create',
            //     'icon-class' => 'fa fa-user',
            //     'permission' => 'module',
            //     'child' => ''),
        ),

    ),
    // array(
    //     'Name' => 'Email templates',
    //     'slug' => '/email_templates',
    //     'icon-class' => 'fa fa-envelope',
    //     'permission' => '',
    //     'child' => ''),

    array(
        'Name' => 'Website Translation',
        'slug' => 'website-languages',
        'icon-class' => 'fa fa-language',
        'permission' => 'module',
        'child' => ''
    ),

    array(
        'Name' => 'Testimonials',
        'slug' => 'testimonials',
        'icon-class' => 'fa fa-comments',
        'permission' => 'testimonials',
        'child' => ''
    ),

    array(
        'Name' => 'Courses',
        'slug' => 'courses',
        'icon-class' => 'fa fa-address-card',
        'permission' => 'course',
        'child' => ''
    ),


    array(
        'Name' => 'CMS',
        'slug' => '',
        'icon-class' => 'fa fa-user',
        'permission' => '',
        'child' => array(
            array(
                'Name' => 'Pages',
                'slug' => 'pages',
                'icon-class' => 'fa fa-file',
                'permission' => 'module',
                'child' => ''
            ),

            array(
                'Name' => 'Page Banners',
                'slug' => 'banner-images',
                'icon-class' => 'fa fa-file',
                'permission' => 'module',
                'child' => ''
            ),




            array(
                'Name' => 'Home Page Sections',
                'slug' => 'home-page-sections',
                'icon-class' => 'fa fa-language',
                'permission' => 'module',
                'child' => ''
            ),

            array(
                'Name' => 'Home Section Contents',
                'slug' => 'home-banner-images',
                'icon-class' => 'fa fa-language',
                'permission' => 'module',
                'child' => ''
            ),
        ),

    ),



    // array(
    //      'Name' => 'Pages',
    //      'slug' => 'pages',
    //      'icon-class' => 'fa fa-file',
    //      'permission' => 'page',
    //      'child' => ''),

    //   array(
    //      'Name' => 'Page Banners',
    //      'slug' => 'banner-images',
    //      'icon-class' => 'fa fa-file',
    //      'permission' => 'page',
    //      'child' => ''),




    //       array(
    //      'Name' => 'Home Page Sections',
    //      'slug' => 'home-page-sections',
    //      'icon-class' => 'fa fa-language',
    //      'permission' => 'module',
    //      'child' => ''),

    //        array(
    //      'Name' => 'Home Section Contents',
    //      'slug' => 'home-banner-images',
    //      'icon-class' => 'fa fa-language',
    //      'permission' => 'module',
    //      'child' => ''),

    array(
        'Name' => 'Free Resources',
        'slug' => 'free-resources',
        'icon-class' => 'fa fa-address-card',
        'permission' => 'module',
        'child' => ''
    ),


)];
