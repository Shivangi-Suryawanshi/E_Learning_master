<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('register', 'AuthController@register');
Route::get('/', 'HomeController@index')->name('home');
Route::get('clear', 'HomeController@clearCache')->name('clear_cache');
// Route::get('/loginas/{key}', 'LoginController@loginasadmin');


Route::get('installations', 'InstallationController@installations')->name('installations');
Route::get('installations/step/2', 'InstallationController@installationsTwo')->name('installations_step_two');
Route::post('installations/step/2', 'InstallationController@installationPost');
Route::get('installations/step/final', 'InstallationController@installationFinal')->name('installation_final');

/**
 * Authentication
 */


Route::get('login', 'AuthController@login')->name('login')->middleware('guest');
Route::post('login', 'AuthController@loginPost');
Route::any('logout', 'AuthController@logoutPost')->name('logout');

Route::get('register/{user_type?}', 'AuthController@register')->name('user_register')->middleware('guest');
Route::post('register', 'AuthController@registerPost')->name('register');

Route::get('forgot-password', 'AuthController@forgotPassword')->name('forgot_password');
Route::post('forgot-password', 'AuthController@sendResetToken');
Route::get('forgot-password/reset/{token}', 'AuthController@passwordResetForm')->name('reset_password_link');
Route::post('forgot-password/reset/{token}', 'AuthController@passwordReset');

Route::get('profile/{id}', 'UserController@profile')->name('profile');
Route::get('review/{id}', 'UserController@review')->name('review');


Route::get('courses', 'HomeController@courses')->name('courses');
Route::get('featured-courses', 'HomeController@courses')->name('featured_courses');
Route::get('popular-courses', 'HomeController@courses')->name('popular_courses');



Route::get('courses/{slug?}', 'CourseController@view')->name('course');
Route::get('courses/{slug}/lecture/{lecture_id}', 'CourseController@lectureView')->name('single_lecture');
Route::get('courses/{slug}/assignment/{assignment_id}', 'CourseController@assignmentView')->name('single_assignment');
Route::get('courses/{slug}/quiz/{quiz_id}', 'QuizController@quizView')->name('single_quiz');


Route::get('topics', 'CategoriesController@home')->name('categories');
Route::get('topics/{category_slug}', 'CategoriesController@show')->name('category_view');
//Get Topics Dropdown for course creation category select
Route::post('get-topic-options', 'CategoriesController@getTopicOptions')->name('get_topic_options');

Route::post('courses/free-enroll', 'CourseController@freeEnroll')->name('free_enroll');

//Attachment Download
Route::get('attachment-download/{hash}', 'CourseController@attachmentDownload')->name('attachment_download');

Route::get('payment-thank-you', 'PaymentController@thankYou')->name('payment_thank_you_page');

Route::get('user-profile/{user_id}', 'HomeController@userProfile')->name('user_profile');

Route::group(['prefix' => 'login'], function () {
    //Social login route
    Route::get('facebook', 'AuthController@redirectFacebook')->name('facebook_redirect');
    Route::get('facebook/callback', 'AuthController@callbackFacebook')->name('facebook_callback');

    Route::get('google', 'AuthController@redirectGoogle')->name('google_redirect');
    Route::get('google/callback', 'AuthController@callbackGoogle')->name('google_callback');

    Route::get('twitter', 'AuthController@redirectTwitter')->name('twitter_redirect');
    Route::get('twitter/callback', 'AuthController@callbackTwitter')->name('twitter_callback');

    Route::get('linkedin', 'AuthController@redirectLinkedIn')->name('linkedin_redirect');
    Route::get('linkedin/callback', 'AuthController@callbackLinkedIn')->name('linkin_callback');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('no-access', 'Admin\UserController@noAcess')->name('no-access');

        Route::get('messages', 'Admin\MessageController@index')->name('messages');
        Route::post('get_messages', 'Admin\MessageController@getMessages')->name('get_messages');
        Route::post('search-result', 'Admin\MessageController@searchResult');
        Route::post('send_message', 'Admin\MessageController@sendMessage')->name('send_message');
        Route::post('search-user', 'Admin\MessageController@searchUser');
       

    Route::post('courses/{slug}/assignment/{assignment_id}', 'CourseController@assignmentSubmitting');
    Route::get('content_complete/{content_id}', 'CourseController@contentComplete')->name('content_complete');
    Route::post('courses-complete/{course_id}', 'CourseController@complete')->name('course_complete');

    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/', 'CartController@checkout')->name('checkout');
        Route::post('bank-transfer', 'GatewayController@bankPost')->name('bank_transfer_submit');
        Route::post('paypal', 'GatewayController@paypalRedirect')->name('paypal_redirect');
        Route::post('offline', 'GatewayController@payOffline')->name('pay_offline');
    });
    Route::post('coupon-apply', 'CartController@couponApply');
    Route::post('save-review/{course_id?}', 'CourseController@writeReview')->name('save_review');
    Route::post('update-wishlist', 'UserController@updateWishlist')->name('update_wish_list');

    Route::post('discussion/ask-question', 'DiscussionController@askQuestion')->name('ask_question');
    Route::post('discussion/reply/{id}', 'DiscussionController@replyPost')->name('discussion_reply_student');

    Route::post('quiz-start', 'QuizController@start')->name('start_quiz');
    Route::get('quiz/{id}', 'QuizController@quizAttempting')->name('quiz_attempt_url');
    Route::post('quiz/{id}', 'QuizController@answerSubmit');

    //Route::get('quiz/answer/submit', 'QuizController@answerSubmit')->name('quiz_answer_submit');


});
// %4!q9)nhYsTT5XR
/**
 * Add and remove to Cart
 */
Route::post('add-to-cart', 'CartController@addToCart')->name('add_to_cart');
Route::post('remove-cart', 'CartController@removeCart')->name('remove_cart');

/**
 * Payment Gateway Silent Notification
 * CSRF verification skipped
 */
Route::group(['prefix' => 'gateway-ipn'], function () {
    Route::post('stripe', 'GatewayController@stripeCharge')->name('stripe_charge');
    Route::any('paypal/{transaction_id?}', 'IPNController@paypalNotify')->name('paypal_notify');
});

/**
 * Users,Instructor dashboard area
 */

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('notification/view', 'DashboardController@view');
    Route::get('/notifications', 'DashboardController@notifications')->name('notifications');
    // trainers 
   
    // Route::get('/message', 'MessageController@inbox')->name('message');
    /**
     * Only instructor has access in this group
     */
    Route::group(['middleware' => ['instructor']], function () {
        Route::get('certificate', 'CertificateController@index')->name('certificate');
        Route::get('certificate/Upload/{id}', 'CertificateController@uploadCertificate')->name('certificate_upload');
        Route::post('certificate/Upload/{id}', 'CertificateController@uploadCertificateCreate');

        Route::post('update-section/{id}', 'CourseController@updateSection')->name('update_section');
        Route::post('delete-section', 'CourseController@deleteSection')->name('delete_section');


        Route::get('coupon/create', 'CouponController@createCoupon')->name('create_coupon');
        Route::post('coupon/create', 'CouponController@saveCoupon')->name('save_coupon');
        Route::get('coupons', 'CouponController@index')->name('coupons');

        Route::get('assingned-courses', 'CourseController@assignedCourse')->name('assingned_courses');
        Route::get('requested-trainer', 'CourseController@requestTrainer')->name('requested-trainer');
        Route::post('status-chage-training-center', 'CourseController@statusChageTrainingcenter');

        Route::post('status-chage-assigned-user', 'CourseController@statusChangesAssignedCourse');

        Route::group(['prefix' => 'courses'], function () {
            Route::get('new', 'CourseController@create')->name('create_course');
            Route::post('new', 'CourseController@store');

            Route::get('{course_id}/information', 'CourseController@information')->name('edit_course_information');
            Route::post('{course_id}/information', 'CourseController@informationPost');

            Route::get('live-schedule/{slug}', 'LiveScheduleController@index');
            Route::get('create-live-schedule/{slug}', 'LiveScheduleController@createForm')->name('create_live_schedule');
            Route::post('create-live-schedule/{slug}', 'LiveScheduleController@create')->name('create_live_schedule');
            Route::get('live-schedule/edit/{id}', 'LiveScheduleController@edit');
            Route::post('live-schedule/edit/{id}', 'LiveScheduleController@update');

            Route::group(['prefix' => '{course_id}/curriculum'], function () {
                Route::get('', 'CourseController@curriculum')->name('edit_course_curriculum');
                Route::get('new-section', 'CourseController@newSection')->name('new_section');
                Route::post('new-section', 'CourseController@newSectionPost');

                Route::post('new-lecture', 'CourseController@newLecture')->name('new_lecture');
                Route::post('update-lecture/{id}', 'CourseController@updateLecture')->name('update_lecture');

                Route::post('new-assignment', 'CurriculumController@newAssignment')->name('new_assignment');
                Route::post('update-assignment/{id}', 'CurriculumController@updateAssignment')->name('update_assignment');

                Route::group(['prefix' => 'quiz'], function () {
                    Route::post('create', 'QuizController@newQuiz')->name('new_quiz');
                    Route::post('update/{id}', 'QuizController@updateQuiz')->name('update_quiz');

                    Route::post('{quiz_id}/create-question', 'QuizController@createQuestion')->name('create_question');
                });
            });

            Route::post('quiz/edit-question', 'QuizController@editQuestion')->name('edit_question_form');
            Route::post('quiz/update-question', 'QuizController@updateQuestion')->name('edit_question');
            Route::post('load-quiz-questions', 'QuizController@loadQuestions')->name('load_questions');
            Route::post('sort-questions', 'QuizController@sortQuestions')->name('sort_questions');
            Route::post('delete-question', 'QuizController@deleteQuestion')->name('delete_question');
            Route::post('delete-option', 'QuizController@deleteOption')->name('option_delete');

            Route::post('edit-item', 'CourseController@editItem')->name('edit_item_form');
            Route::post('delete-item', 'CourseController@deleteItem')->name('delete_item');
            Route::post('curriculum_sort', 'CurriculumController@sort')->name('curriculum_sort');

            Route::post('delete-attachment', 'CurriculumController@deleteAttachment')->name('delete_attachment_item');

            Route::post('load-section-items', 'CourseController@loadContents')->name('load_contents');

            Route::get('{id}/pricing', 'CourseController@pricing')->name('edit_course_pricing');
            Route::post('{id}/pricing', 'CourseController@pricingSet');
            Route::get('{id}/drip', 'CourseController@drip')->name('edit_course_drip');
            Route::post('{id}/drip', 'CourseController@dripPost');
            Route::get('{id}/publish', 'CourseController@publish')->name('publish_course');
            Route::post('{id}/publish', 'CourseController@publishPost');
        });
        //instructor bidding request
        Route::get('bidding-request', 'Admin\BiddingController@index')->name('bidding_request');
        Route::post('accept-bidding-request/{id}', 'Admin\BiddingController@acceptRequest');
        Route::post('coupon-code-create', 'Admin\BiddingController@couponCodeCreate');

        Route::get('my-courses', 'CourseController@myCourses')->name('my_courses');
        Route::get('my-courses-reviews', 'CourseController@myCoursesReviews')->name('my_courses_reviews');
        Route::get('vimeo-manager', 'VimeoController@index')->name('vimeo_manager');
        Route::post('vimeo-upload', 'VimeoController@postVimeoUploadsApi')->name('vimeo_upload');

        Route::get('my-biddings', 'BiddingController@myBiddings')->name('my_biddings');
        //calender
        Route::group(['prefix' => 'calender'], function () {
            
            Route::get('/', 'CalenderController@index')->name('calender');
            Route::get('get-list', 'CalenderController@getList')->name('get-list-calender');

        });


                Route::get('free-resources', 'ResourceController@index')->name('free_resourses');
        Route::get('get-free-resources', 'ResourceController@getFreeResources');
        Route::get('free-resources/create', 'ResourceController@createForm');
        Route::post('free-resources/create', 'ResourceController@create');
        Route::get('free-resources/edit/{id}', 'ResourceController@updateForm');
        Route::post('free-resources/edit/{id}', 'ResourceController@update');
        Route::get('free-resources/view/{id}', 'ResourceController@viewForm');
        


        Route::group(['prefix' => 'trainers'], function () {
            Route::get('/', 'TrainersController@index')->name('trainers');
            Route::get('request', 'TrainersController@requestedTrainer')->name('request_trainer');
            Route::post('search-trainer', 'TrainersController@searchTrainer');
            Route::post('request-to-another-trainer', 'TrainersController@requestAnotherTrainer');




        });

             

        Route::group(['prefix' => 'courses-has-quiz'], function () {
            Route::get('/', 'QuizController@quizCourses')->name('courses_has_quiz');
            Route::get('quizzes/{id}', 'QuizController@quizzes')->name('courses_quizzes');
            Route::get('attempts/{quiz_id}', 'QuizController@attempts')->name('quiz_attempts');
            Route::get('attempt/{attempt_id}', 'QuizController@attemptDetail')->name('attempt_detail');
            Route::post('attempt/{attempt_id}', 'QuizController@attemptReview');
        });

        Route::group(['prefix' => 'assignments'], function () {
            Route::get('/', 'AssignmentController@index')->name('courses_has_assignments');
            Route::get('course/{course_id}', 'AssignmentController@assignmentsByCourse')->name('courses_assignments');
            Route::get('submissions/{assignment_id}', 'AssignmentController@submissions')->name('assignment_submissions');
            Route::get('submission/{submission_id}', 'AssignmentController@submission')->name('assignment_submission');
            Route::post('submission/{submission_id}', 'AssignmentController@evaluation');
        });

        Route::group(['prefix' => 'earning'], function () {
            Route::get('/', 'EarningController@earning')->name('earning');
            Route::get('report', 'EarningController@earningReport')->name('earning_report');
        });
        Route::group(['prefix' => 'withdraw'], function () {
            Route::get('/', 'EarningController@withdraw')->name('withdraw');
            Route::post('/', 'EarningController@withdrawPost');

            Route::get('preference', 'EarningController@withdrawPreference')->name('withdraw_preference');
            Route::post('preference', 'EarningController@withdrawPreferencePost');
        });

        Route::group(['prefix' => 'discussions'], function () {
            Route::get('/', 'DiscussionController@index')->name('instructor_discussions');
            Route::get('reply/{id}', 'DiscussionController@reply')->name('discussion_reply');
            Route::post('reply/{id}', 'DiscussionController@replyPost');
        });
    });

    Route::group(['prefix' => 'media'], function () {
        Route::post('upload', 'MediaController@store')->name('post_media_upload');
        Route::get('load_filemanager', 'MediaController@loadFileManager')->name('load_filemanager');
        Route::post('delete', 'MediaController@delete')->name('delete_media');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'DashboardController@profileSettings')->name('profile_settings');
    Route::post('/', 'DashboardController@profileSettingsPost');
    Route::post('/tc-profile', 'DashboardController@tCProfileSettingsPost'); 
    Route::post('/tr-profile', 'DashboardController@tRProfileSettingsPost');

        

        Route::get('reset-password', 'DashboardController@resetPassword')->name('profile_reset_password');
        Route::post('reset-password', 'DashboardController@resetPasswordPost');
    });
    //indidual certificate list
    Route::get('certificate', 'CertificateController@index')->name('certificate');
        Route::get('certificate/Upload/{id}', 'CertificateController@uploadCertificate')->name('certificate_upload');
        Route::post('certificate/Upload/{id}', 'CertificateController@uploadCertificateCreate');

    Route::get('company-request', 'CompanyRequestController@index')->name('company_request');

    Route::post('status-chage-assigned-individual', 'CompanyRequestController@statusChangeIndividual');
    Route::get('student-portal', 'CompanyRequestController@studentPortal')->name('my_student_portal');

    Route::get('enrolled-courses', 'DashboardController@enrolledCourses')->name('enrolled_courses');
    Route::get('reviews-i-wrote', 'DashboardController@myReviews')->name('reviews_i_wrote');
    Route::get('wishlist', 'DashboardController@wishlist')->name('wishlist');

    Route::get('my-quiz-attempts', 'QuizController@myQuizAttempts')->name('my_quiz_attempts');

    Route::group(['prefix' => 'purchases'], function () {
        Route::get('/', 'DashboardController@purchaseHistory')->name('purchase_history');
        Route::get('view/{id}', 'DashboardController@purchaseView')->name('purchase_view');
    });


});



/**
 * Admin Area
 */


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::post('users/login', 'Admin\UserController@userLogin');
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('view-details/{id}', ['as' => 'users', 'uses' => 'UserController@viewDetails']);
    Route::post('company-status-change', ['as' => 'users', 'uses' => 'UserController@statusChange']);
   	/********** Email templates *********/
		Route::get('email-templates', 'Admin\EmailTemplatesController@index')->name('email_template');
		Route::get('email-templates-data', 'Admin\EmailTemplatesController@getEmailtemplatesData');
		Route::get('email-templates/create', 'Admin\EmailTemplatesController@create_form');
		Route::post('email-templates/create', 'Admin\EmailTemplatesController@create');
		Route::get('email-templates/edit/{id}', 'Admin\EmailTemplatesController@edit_form')->name('email_template_edit');
		Route::post('email-templates/edit/{id}', 'Admin\EmailTemplatesController@edit');
		Route::post('email-templates/delete', 'Admin\EmailTemplatesController@delete');


        
        /********** testimonials*********/
        Route::get('testimonials', 'Admin\TestimonialController@index');
        Route::get('testimonial_data', 'Admin\TestimonialController@get_testimonial_data');
        Route::get('testimonials/create', 'Admin\TestimonialController@create_form');
        Route::post('testimonials/create',  'Admin\TestimonialController@create');
        Route::post('testimonials/media', 'Admin\TestimonialsController@rtestimonialMedia')
            ->name('testimonial-images.testimonialMedia');
        Route::get('testimonials/edit/{id}', 'Admin\TestimonialController@editTestimonial');
        Route::post('testimonials/edit/{id}',  'Admin\TestimonialController@updateTestimonial');
        Route::post('testimonials/delete',  'Admin\TestimonialController@deleteTestimonial');
        Route::post('/ajax/changeTestimonialStatus', 'Admin\TestimonialController@changeTestimonialStatus');


        Route::get('free-resources', 'Admin\ResourceController@index')->name('free_resourses');
        Route::get('get-free-resources', 'Admin\ResourceController@getFreeResources');
        Route::get('free-resources/create', 'Admin\ResourceController@createForm');
        Route::post('free-resources/create', 'Admin\ResourceController@create');
        Route::get('free-resources/edit/{id}', 'Admin\ResourceController@updateForm');
        Route::post('free-resources/edit/{id}', 'Admin\ResourceController@update');
        Route::get('free-resources/view/{id}', 'Admin\ResourceController@viewForm');
        

        Route::get('add-items', 'ItemController@addItem')->name('add_items');


        		/* Manage CMS page Content */
		Route::get('home-page-sections', 'Admin\CmsController@homeSectionIndex');
		Route::get('home-page-sections/get-data', 'Admin\CmsController@homeSection_getdata');
		Route::get('home-page-sections/create', 'Admin\CmsController@homeSectionCreate');
		Route::post('home-page-sections/url-slug', 'Admin\CmsController@homeSectionUrl_slug');
		Route::get('home-page-sections/view/{id}', 'Admin\CmsController@homeSectionView');
		Route::post('home-page-sections/view/{id}', 'Admin\CmsController@homeSectionEdit');
		Route::post('home-page-sections/create', 'Admin\CmsController@homeSectionDo_create');
		Route::post('/ajax/changehomeSectionStatus', 'Admin\AjaxController@changeHomeSectionStatus');

		/**********  Directory category *********/
		Route::get('home-banner-images', 'Admin\BannerController@homeBannerIndex');
		Route::get('home_banner_images_data', 'Admin\BannerController@homeGetBannerData');
		Route::get('home-banner-images/create', 'Admin\BannerController@homeCreateBanner');
		Route::post('home-banner-images/create',  'Admin\BannerController@homeSaveBanner');
		Route::get('home-banner-images/edit/{id}',  'Admin\BannerController@homeEditBanner');
		Route::post('home-banner-images/edit/{id}', 'Admin\BannerController@homeUpdateBanner');
		Route::post('/ajax/changeBannerStatus', 'Admin\BannerController@changeHomeBannerStatus');



   	/********** CMS *********/

    Route::group(['prefix' => 'cms'], function () {
        Route::get('/', 'PostController@posts')->name('posts');
        Route::get('post/create', 'PostController@createPost')->name('create_post');
        Route::post('post/create', 'PostController@storePost');
        Route::get('post/edit/{id}', 'PostController@editPost')->name('edit_post');
        Route::post('post/edit/{id}', 'PostController@updatePost');

        // Route::get('page', 'PostController@index')->name('pages');
        // Route::get('page/create', 'PostController@create')->name('create_page');
        // Route::post('page/create', 'PostController@store');
        // Route::get('page/edit/{id}', 'PostController@edit')->name('edit_page');
        // Route::post('page/edit/{id}', 'PostController@updatePage');
    });

    /* Manage CMS page Content */
    // Route::get('pages', 'Admin\CmsController@index')->name('pages');
    // Route::get('pages/get-data', 'Admin\CmsController@cms_getdata');
    // Route::get('pages/create', 'Admin\CmsController@create');
    // Route::post('pages/url-slug', 'Admin\CmsController@url_slug');
    // Route::get('pages/view/{id}', 'Admin\CmsController@view');
    // Route::post('pages/view/{id}', 'Admin\CmsController@edit');
    // Route::post('pages/create', 'Admin\CmsController@do_create');
    // Route::post('/ajax/changePageStatus', 'Admin\AjaxController@changePageStatus');

    Route::group(['prefix' => 'media_manager'], function () {
        Route::get('/', 'MediaController@mediaManager')->name('media_manager');
        Route::post('media-update', 'MediaController@mediaManagerUpdate')->name('media_update');
    });

    // Roles management section
    Route::group(['module' => 'roles'], function () {
        Route::get('roles', 'Admin\RoleController@index')->name('roles');
        Route::get('role/create', ['permission' => 'add', 'uses' => 'Admin\RoleController@createForm']);
        Route::post('role/create', ['permission' => 'add', 'uses' =>  'Admin\RoleController@create']);
        Route::get('role/edit/{id}', ['permission' => 'edit', 'uses' =>  'Admin\RoleController@updateForm']);
        Route::post('role/edit/{id}', ['permission' => 'edit', 'uses' => 'Admin\RoleController@update']);
        Route::post('role/change_status/{id}', ['permission' => 'edit', 'uses' => 'Admin\RoleController@changeStatus']);
        Route::post('role/delete/{id}', ['permission' => 'delete', 'uses' => 'Admin\RoleController@delete']);
    });

    // Module management section
    Route::group(['module' => 'module'], function () {
        Route::get('module', 'Admin\ModuleController@index')->name('module');
        Route::get('module/create', ['permission' => 'add', 'uses' => 'Admin\ModuleController@createForm']);
        Route::post('module/create', ['permission' => 'add', 'uses' => 'Admin\ModuleController@create']);
        Route::get('module/edit/{id}', ['permission' => 'edit', 'uses' => 'Admin\ModuleController@updateForm']);
        Route::post('module/edit/{id}', ['permission' => 'edit', 'uses' => 'Admin\ModuleController@update']);
    });
    //chat  in admin dashboard
    // Route::get('chats', 'Admin\ChatController@index')->name('chats');
    // Route::post('get_messages', 'Admin\ChatController@getMessages')->name('get_messages');
    // Route::post('search-result', 'Admin\ChatController@searchResult');
    // Route::post('send_message', 'Admin\ChatController@sendMessage')->name('send_message');
    Route::get('contact', 'CategoriesController@contact')->name('contact-list');

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoriesController@index')->name('category_index');
        Route::get('create', 'CategoriesController@create')->name('category_create');
        Route::post('create', 'CategoriesController@store');
        Route::get('edit/{id}', 'CategoriesController@edit')->name('category_edit');
        Route::post('edit/{id}', 'CategoriesController@update');
        Route::post('delete', 'CategoriesController@destroy')->name('delete_category');
    });

    //packages
    Route::group(['prefix' => 'packages'], function () {
        Route::get('/', 'PackagesController@index')->name('packages');
        Route::get('create', 'PackagesController@createForm')->name('create_package');
        Route::post('create', 'PackagesController@create');
        Route::get('edit/{id}', 'PackagesController@edit');
        Route::post('edit/{id}', 'PackagesController@update');
        Route::get('functionality/{id}', 'PackagesController@functionality');
        Route::post('functionality/{id}', 'PackagesController@functionalityCreate');
        Route::get('subscription', 'PackagesController@subscription')->name('package_subscription');
    });
    // functionality
    Route::group(['prefix' => 'functionality'], function () {
        Route::get('/', 'FunctionalityController@index')->name('functionality');
        Route::get('create', 'FunctionalityController@createForm')->name('create_functionality');
        Route::post('create', 'FunctionalityController@create');
        Route::get('edit/{id}', 'FunctionalityController@edit');
        Route::post('edit/{id}', 'FunctionalityController@update');
    });
    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', 'AdminController@adminCourses')->name('admin_courses');
        Route::get('popular', 'AdminController@popularCourses')->name('admin_popular_courses');
        Route::get('featured', 'AdminController@featureCourses')->name('admin_featured_courses');
    });

    Route::group(['prefix' => 'pages'], function () {
        Route::get('/', 'AdminController@adminPages')->name('admin_pages');
        Route::get('pages/view/{id}', 'Admin\CmsController@view')->name('edit.admin_pages');
        Route::post('pages/view/{id}', 'Admin\CmsController@edit');
    });

    /**********  Directory category *********/
    Route::get('banner-images', 'AdminController@bannerIndex')->name('admin_banners');
    Route::get('banner_images_data', 'Admin\BannerController@getBannerData');
    Route::get('banner-images/create', 'Admin\BannerController@createBanner');
    Route::post('banner-images/create',  'Admin\BannerController@saveBanner');
    Route::get('banner-images/edit/{id}',  'Admin\BannerController@editBanner')->name('edit.banners');
    Route::post('banner-images/edit/{id}', 'Admin\BannerController@updateBanner');
    Route::post('/ajax/changeBannerStatus', 'Admin\BannerController@changeBannerStatus');



    Route::get('free-resources', 'Admin\ResourceController@index');
    Route::get('get-free-resources', 'Admin\ResourceController@getFreeResources');
    Route::get('free-resources/create', ['permission' => 'add', 'uses' => 'Admin\ResourceController@createForm']);
    Route::post('free-resources/create', ['permission' => 'add', 'uses' => 'Admin\ResourceController@create']);
    Route::get('free-resources/edit/{id}', ['permission' => 'edit', 'uses' => 'Admin\ResourceController@updateForm']);
    Route::post('free-resources/edit/{id}', ['permission' => 'edit', 'uses' => 'Admin\ResourceController@update']);
    Route::get('free-resources/view/{id}', ['permission' => 'edit', 'uses' => 'Admin\ResourceController@viewForm']);


    Route::group(['prefix' => 'plugins'], function () {
        Route::get('/', 'ExtendController@plugins')->name('plugins');
        Route::get('find', 'ExtendController@findPlugins')->name('find_plugins');
        Route::get('action', 'ExtendController@pluginAction')->name('plugin_action');
    });
    Route::group(['prefix' => 'themes'], function () {
        Route::get('/', 'ExtendController@themes')->name('themes');
        Route::post('activate', 'ExtendController@activateTheme')->name('activate_theme');
        Route::get('find', 'ExtendController@findThemes')->name('find_themes');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('theme-settings', 'SettingsController@ThemeSettings')->name('theme_settings');
        Route::get('invoice-settings', 'SettingsController@invoiceSettings')->name('invoice_settings');
        Route::get('general', 'SettingsController@GeneralSettings')->name('general_settings');
        Route::get('lms-settings', 'SettingsController@LMSSettings')->name('lms_settings');

        Route::get('social', 'SettingsController@SocialSettings')->name('social_settings');
        //Save settings / options
        Route::post('save-settings', 'SettingsController@update')->name('save_settings');
        Route::get('payment', 'PaymentController@PaymentSettings')->name('payment_settings');
        Route::get('storage', 'SettingsController@StorageSettings')->name('storage_settings');
    });

    Route::get('gateways', 'PaymentController@PaymentGateways')->name('payment_gateways');
    Route::get('withdraw', 'SettingsController@withdraw')->name('withdraw_settings');
    Route::get('live-schedule', 'LiveScheduleController@adminLiveIndex')->name('live_schedule');
    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', 'PaymentController@index')->name('payments');
        Route::get('view/{id}', 'PaymentController@view')->name('payment_view');
        Route::get('delete/{id}', 'PaymentController@delete')->name('payment_delete');

        Route::post('update-status/{id}', 'PaymentController@updateStatus')->name('update_status');
    });

    Route::group(['prefix' => 'withdraws'], function () {
        Route::get('/', 'AdminController@withdrawsRequests')->name('withdraws');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['as' => 'users', 'uses' => 'UserController@users']);
        Route::get('create', ['as' => 'add_administrator', 'uses' => 'UserController@addAdministrator']);
        Route::post('create', ['uses' => 'UserController@storeAdministrator']);
        Route::post('block-unblock', ['as' => 'administratorBlockUnblock', 'uses' => 'UserController@administratorBlockUnblock']);
    });

    /* Website Languages */
Route::get('website-languages/', 'Admin\WebsiteLanguageController@translations')->name('translation');
Route::post('website-languages/', 'Admin\WebsiteLanguageController@save_translations');


    /**
     * Change Password route
     */
    Route::group(['prefix' => 'account'], function () {
        Route::get('change-password', 'UserController@changePassword')->name('change_password');
        Route::post('change-password', 'UserController@changePasswordPost');
    });
});

// Route::get('getSection/', 'Admin\PageController@getSection');

/**
 * Single Page
 */
//Route::get('{slug}', 'PostController@singlePage')->name('page');


Route::get('blog', 'PostController@blog')->name('blog');
//Route::get('{slug}', 'PostController@postSingle')->name('post');
Route::get('post/{id?}', 'PostController@postProxy')->name('post_proxy');

Route::get('/change-language/{code}', 'FrontController@changeLanguage');
Route::get('for-enterprises', 'FrontController@enterprise');
Route::get('download-resourses', 'FrontController@downloadResourses');
Route::get('free-resource-detail/{id}', 'FrontController@resourceDetail');
Route::get('course-detail/{id}', 'FrontController@courseDetail');
Route::post('resource/rating', 'FrontController@setRating');
Route::get('courses-listing', 'FrontController@listCourses');
Route::get('course/all-rating', 'FrontController@allCourseRating');
Route::get('checkout/{id}', 'PaymentController@checkout');
Route::get('complete-payment', 'PaymentController@completePayment');
Route::get('payment-success', 'PaymentController@successPayment')->name('payment_success');
Route::post('ajax/addToWishlist', 'FrontController@addToWishlist');

// Route::get('{slug}', 'PostController@postSingle')->name('post');

// ****************************************************************************
// *                           COMPANY SECTION                                  *
// ****************************************************************************

Route::group(['prefix' => 'company'], function () {

    Route::get('/login', function () {
        return view('company.company-login');
    });
    Route::post('sign-in', 'Auth\AuthController@loginFn')->name('sign-in');
    // Route::post('sign-out', 'Auth\AuthController@logoutFn')->name('logout');

    Route::group(['middleware' => ['auth', 'company']], function () {
        Route::post('set-language', 'CommonController@setLanguage')->name('set-language');

        Route::get('/', function () {
            return view('company.company-dashboard');
        })->name('company');
        Route::get('request-individual-user', 'Company\WorkForceController@requestForm');

        Route::post('search-indidual', 'Company\WorkForceController@searchIndidual');
        Route::post('request-to-individual', 'Company\WorkForceController@individualStatus');

        Route::post('set-language', 'CommonController@setLanguage')->name('set-language');
        Route::get('workforces', 'Company\WorkForceController@index')->name('workforces');
        Route::get('get-workforce-data', 'Company\WorkForceController@getWorkforceData')->name('get-workforce-data');
        Route::post('add-workforce', 'Company\WorkForceController@addWorkforceFn')->name('add-workforce');
        Route::post('user/checkemail', 'Company\WorkForceController@userEmailCheck')->name('check-mail');
        // sub contractor 
        Route::group(['prefix' => 'sub-contractor'], function () {
            Route::get('/', 'Company\SubContractorController@index')->name('sub-contractor');
            Route::get('get-contractor-data', 'Company\SubContractorController@getContractorData');

        });
        Route::group(['prefix' => 'project-manager'], function () {
            Route::get('/', 'Company\SubContractorController@projectManagerIndex')->name('project-manager');
            Route::get('get-project-manager-data', 'Company\SubContractorController@getProjectManagerData');

        });

        Route::get('positions', 'Company\SettingsController@positions')->name('positions');
        Route::get('get-company-positions', 'Company\SettingsController@getPositionsFn')->name('get-company-positions');
        Route::post('save-company-positions', 'Company\SettingsController@saveCompanyPosition')->name('save-company-positions');
        Route::post('delete-company-positions', 'Company\SettingsController@deletePosition')->name('delete-company-positions');

        Route::get('departments', 'Company\SettingsController@departments')->name('departments');
        Route::get('get-company-departments', 'Company\SettingsController@getDepartmentsFn')->name('get-company-departments');
        Route::post('save-company-departments', 'Company\SettingsController@saveCompanyDepartment')->name('save-company-departments');
        Route::post('delete-company-departments', 'Company\SettingsController@deleteDepartment')->name('delete-company-departments');

        Route::get('projects', 'Company\SettingsController@projects')->name('projects');
        Route::get('get-company-projects', 'Company\SettingsController@getProjectsFn')->name('get-company-projects');
        Route::post('save-company-projects', 'Company\SettingsController@saveCompanyProject')->name('save-company-projects');
        Route::post('delete-company-projects', 'Company\SettingsController@deleteProject')->name('delete-company-projects');

        Route::get('profile', 'Company\ProfileController@profileViewPage')->name('profile');
        Route::get('get-profile-data', 'Company\ProfileController@getProfileData')->name('get-profile-data');

        Route::get('add-profile', 'Company\ProfileController@getProfile')->name('add-profile');
        Route::post('create-profile', 'Company\ProfileController@createProfile')->name('create-profile');
        Route::get('edit-profile', 'Company\ProfileController@getProfile')->name('edit-profile');
        Route::post('update-profile', 'Company\ProfileController@updateProfile')->name('update-profile');

        Route::get('training-matrix-structure', 'Company\TrainingMatrixController@matrixStructure')->name('training-matrix-structure');
        Route::get('get-training-matrix-structure', 'Company\TrainingMatrixController@getMatrixStructureFn')->name('get-training-matrix-structure');
        Route::post('save-training-matrix-structure', 'Company\TrainingMatrixController@saveMatrixStructure')->name('save-training-matrix-structure');
        Route::post('delete-training-matrix-structure', 'Company\TrainingMatrixController@deleteMatrixStructure')->name('delete-training-matrix-structure');

        Route::get('training-matrix', 'Company\TrainingMatrixController@trainingMatrix')->name('training-matrix');
        Route::get('get-training-matrix-data', 'Company\TrainingMatrixController@getMatrixData')->name('get-training-matrix-data');
        Route::post('assign-required-course', 'Company\TrainingMatrixController@assignRequiredCourse')->name('assign-required-course');

        Route::get('course-bulk-assign', 'Company\RequiredCourseController@bulkAssignCourses')->name('course-bulk-assign');
        //Route::post('add-workforce', 'Company\WorkForceController@addWorkforceFn')->name('add-workforce');

        Route::get('progress-report', 'Company\ProgressGraphController@progressTable')->name('progress-report');
        Route::get('get-progress-report-data', 'Company\ProgressGraphController@getProgressData')->name('get-progress-report-data');

        Route::get('upcoming-courses', 'Company\UpcomingCoursesController@upcomingCourses')->name('upcoming-courses');
        Route::get('get-upcoming-courses-data', 'Company\UpcomingCoursesController@getUpcomingCoursesData')->name('get-upcoming-courses-data');

        Route::get('graphs', 'Company\ProgressGraphController@graphs')->name('graphs');
        Route::get('get-graph-1-data', 'Company\ProgressGraphController@getGraph1Data')->name('get-graph-1-data');
        Route::get('get-graph-2-data', 'Company\ProgressGraphController@getGraph2Data')->name('get-graph-2-data');
        Route::get('get-graph-3-data', 'Company\ProgressGraphController@getGraph3Data')->name('get-graph-3-data');
        Route::get('get-graph-4-data/{category}/{id}', 'Company\ProgressGraphController@getGraph4Data')->name('get-graph-4-data');
        Route::get('get-graph-02-data', 'Company\ProgressGraphController@getGraph02Data')->name('get-graph-02-data');
        Route::get('get-graph-03-data', 'Company\ProgressGraphController@getGraph03Data')->name('get-graph-03-data');
        Route::get('get-graph-04-data', 'Company\ProgressGraphController@getGraph04Data1')->name('get-graph-04-data');
        Route::get('get-graph-04-data-2', 'Company\ProgressGraphController@getGraph04Data2')->name('get-graph-04-data-2');
        Route::get('get-graph-04-data-3', 'Company\ProgressGraphController@getGraph04Data3')->name('get-graph-04-data-3');
        
        //Download graph
        Route::get('download-expired-totalCerit', 'Company\ProgressGraphController@dowloadExpiredTotalCerrtificate')->name('download-expired-totalCerit');
        Route::get('download-expired-certificate', 'Company\ProgressGraphController@dowloadExpiredCerrtificate')->name('download-expired-certificate');
        Route::get('download-expired-certificate-project', 'Company\ProgressGraphController@dowloadExpiredCerrtificateProject')->name('download-expired-certificate-project');
        Route::get('download-cost-spend', 'Company\ProgressGraphController@downloadCostSpend')->name('download-cost-spend');
        Route::get('course-department', 'Company\ProgressGraphController@courseDepartment')->name('course-department');
        Route::get('certificate-status', 'Company\ProgressGraphController@certificateStatus')->name('certificate-status');




        Route::post('get-positions-with-selected', 'Company\CommonController@getPositionsSelected')->name('get-positions-with-selected');
        Route::post('get-departments-with-selected', 'Company\CommonController@getDepartmentsSelected')->name('get-departments-with-selected');
        Route::post('get-projects-with-selected', 'Company\CommonController@getProjectsSelected')->name('get-projects-with-selected');
        Route::post('get-courses-with-selected', 'Company\CommonController@getCoursesSelected')->name('get-courses-with-selected');
        Route::post('get-employee-with-filters', 'Company\CommonController@getEmployees')->name('get-employee-with-filters');
        Route::post('get-skills-with-selected', 'Company\CommonController@getSkillsSelected')->name('get-skills-with-selected');
        Route::post('get-occupations-with-selected', 'Company\CommonController@getOccupationsSelected')->name('get-occupations-with-selected');
        Route::post('get-industries-with-selected', 'Company\CommonController@getIndustriesSelected')->name('get-industries-with-selected');

        //list category 
        Route::post('get-category', 'Company\CommonController@getCategory');
        Route::post('get-category-course', 'Company\CommonController@getCategoryCourse');
        Route::post('get-category-course-type', 'Company\CommonController@getCategoryCourseType');



        Route::get('search-courses', 'Company\CourseController@searchCourses')->name('search-courses');
        Route::get('bidding', 'Company\BiddingController@index')->name('bidding');
        Route::get('bidding-list', 'Company\BiddingController@list')->name('bidding_list');
        Route::get('get-bidding-list', 'Company\BiddingController@getBiddingList');


        // project manager request to bidding 
        Route::get('bidding-request-list', 'Company\BiddingController@requestList')->name('bidding_request_list');
        Route::get('get-bidding-list-detail', 'Company\BiddingController@requestBiddingList');
        Route::post('accept-project-manager-bidding-request', 'Company\BiddingController@acceptBiddingRequest');


        Route::post('search-course-items', 'Company\CourseController@searchCourseItems')->name('search_course_items');
        Route::post('save-purchase-course-relation', 'Company\CourseController@saveCoursePurchaseRelation')->name('save-purchase-course-relation');
        Route::get('course-payment', 'Company\CourseController@coursePayment')->name('course-payment');
        Route::post('save-purchase-course-payment', 'Company\CourseController@saveCoursePayment')->name('save-purchase-course-payment');

        Route::get('purchased-courses', 'Company\CourseController@purchasedCourses')->name('purchased-courses');
        Route::get('get-purchased-courses', 'Company\CourseController@getPurchasedCourses')->name('get-purchased-courses');

        Route::post('save-bidding-price', 'Company\CourseController@saveBiddingPrice')->name('save-bidding-price');
        Route::get('enrolled-courses', 'Company\CourseController@enrolledCourses')->name('company-enrolled-course');

        // certificate 
        Route::get('certificate', 'CertificateController@certificateView')->name('certificate-view');
        Route::get('get-certified-courses', 'CertificateController@getCertifiedCourse');
        Route::get('get-entrolled-course', 'Company\CourseController@getEnrolledCourses');
        Route::post('certificate-approve', 'CertificateController@approveCertificate');
        // exam result 
        Route::get('exam-result', 'CertificateController@examResult')->name('exam-result');
        Route::get('get-result', 'CertificateController@getResult');




        Route::get('change-password', 'Company\ProfileController@changePassword');
        Route::post('change-password', 'Company\ProfileController@updateChangePassword');
        // Route::get('logout', 'Institute\CourseController@logout');

    });
    // End : CHECKING AUTHENTICATION //
});
Route::get('{slug}', 'FrontController@viewPage')->name('page');
Route::get('subscription/{packageId}', 'FrontController@packageId')->name('subscription');
Route::post('contact', 'FrontController@contact');

// $2y$10$tdIN0OB9NFNxyvRcT/6UkuGjk2b4pmF5RZPNnjApX.D363sTHE.HG