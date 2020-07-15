<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|rr
*/

Auth::routes();




/*########################
    My Routes           ##
 ##########################
 */

//#####################
//Guest Routes
//#####################
Route::get('login', 'UserController@showLoginForm')->name('login');
Route::post('login', 'UserController@login');
Route::get('logout', 'UserController@logout')->name('logout');
Route::get('about_us', 'HomeController@aboutUs')->name('about_us');

//#####################
//View Invoice from email
//#####################
Route::get('view_invoice/{invoice_id}/{user_id}', 'InvoiceController@checkUser')->name('view_invoice');

// PayStack Payment WebHook
Route::post('/paystack_hook', 'PaymentController@veryHook')->name('/paystack_hook');
// 52.31.139.75, 52.49.173.169, 52.214.14.220 (PayStack IPs)
//#####################
//HOME PAGE
//#####################
Route::get('search_category','CategoriesController@searchCategory')->name('search_category');

// Route::get('cat-tile-request/{search_term}','ServiceController@requestBySlug')->name('cat-tile-request');
Route::get('accept_order/{id}', 'ArtisanController@accept')->name('accept_order');
Route::get('decline_order/{id}', 'ArtisanController@accept')->name('decline_order');

//#####################
//Authenticated Routes
//#####################
Route::group(['middleware'=>'auth:web'], function(){
    Route::group(['prefix'=>'u'], function(){
        //Route::get('user-acount', 'UserController@getAccount')->name('user-acount');
        Route::get('account', 'UserController@getAccount')->name('account');
        Route::get('change-password', ['as' => 'change_password', 'uses' => 'UserController@changePassword']);
        Route::post('change-password', 'UserController@changePasswordPost');
        Route::get('messages', 'UserController@flaggedMessage')->name('messages');
    });

    Route::group(['prefix'=>'service'], function(){
        Route::get('request', 'ServiceController@requestService')->name('request');
        Route::post('send-request', 'ServiceController@requestServicePost')->name('send-request');
        Route::get('request-service/{search_term}','ServiceController@requestBySlug')->name('request-service');
        Route::post('request_service','ServiceController@requestBySlug')->name('request_service');
    });

    Route::group(['prefix'=>'jobs'], function(){
        Route::get('all','ServiceController@allUserJobs')->name('all');
        Route::get('new','ServiceController@newJobs')->name('new');
        Route::get('in-progress','ServiceController@jobsInProgress')->name('in-progress');
        Route::get('pending','ServiceController@pendingJobs')->name('pending');
        Route::get('completed','ServiceController@completedJobs')->name('completed');
        Route::get('cancelled','ServiceController@cancelledJobs')->name('cancelled');
        Route::get('invoice','ServiceController@invoice')->name('invoice');
        Route::get('reschedule-visit','ServiceController@rescheduleVisit')->name('reschedule-visit');
        Route::post('reschedule-visit', 'ServiceController@rescheduleVisitPost');
        Route::get('get_jobs_for_reschedule', 'ServiceController@getJobForReschedule')->name('get_jobs_for_reschedule');
        Route::post('mark-job', 'ServiceController@markJobPost')->name('mark-job');
        Route::get('flag_job/{id}', 'ServiceController@flagJob')->name('flag_job');
        Route::post('flag_job/{id}', 'ServiceController@flagJobPost');
        Route::get('my_flagged_jobs', 'ServiceController@userFlaggedJobs')->name('my_flagged_jobs');
        Route::post('flag_reply_modal/{id}', 'ServiceController@flagReplyModal')->name('flag_reply_modal');
    });

    Route::group(['prefix'=>'payments'], function(){
        Route::post('pay', 'PaymentController@redirectToGateway')->name('pay');
        Route::get('callback', 'PaymentController@handleGatewayCallback')->name('/payment/callback');
        Route::get('/', 'PaymentController@index')->name('payments'); 
    });
     
    Route::group(['prefix'=>'admin','middleware'=>'only_admin_access'], function(){
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('all-jobs','ServiceController@allJobs')->name('all-jobs');
        //Route::get('/', ['as'=>'service-categories', 'uses' => 'CategoriesController@index']);
        //Route::post('/', ['uses' => 'CategoriesController@store']);
        Route::get('service-categories', 'CategoriesController@index')->name('service-categories');
        Route::post('service-categories', 'CategoriesController@store');
        Route::get('edit/{id}', ['as'=>'edit_categories', 'uses' => 'CategoriesController@edit']);
        Route::post('edit/{id}', ['uses' => 'CategoriesController@update']);
        Route::post('delete-categories', ['as'=>'delete_categories', 'uses' => 'CategoriesController@destroy']);
         //#####################
        //SETTINGS
        //#####################
        Route::group(['prefix'=>'settings'], function(){
            Route::get('/', 'SettingsController@GeneralSettings')->name('general_settings');

            Route::get('theme-settings', 'SettingsController@ThemeSettings')->name('theme_settings');
            Route::get('gateways', 'SettingsController@GatewaySettings')->name('gateways_settings');
            Route::get('pricing', 'SettingsController@PricingSettings')->name('pricing_settings');
            Route::post('pricing', 'SettingsController@PricingSave');

            //Save settings / options
            Route::post('save-settings', ['as'=>'save_settings', 'uses' => 'SettingsController@update']);
        });
        //#####################
        //JOBS
        //#####################
        Route::get('jobs/{tag}','ServiceController@showJobsAdmin')->name('jobs');
        Route::get('mark_job','ServiceController@markJob')->name('mark_job');
        Route::get('assign_artisan/{artisan_id}/{job_id}', 'ArtisanController@assignArtisan')->name('assign-artisan');
        Route::get('view_job/{id}', 'ServiceController@show')->name('view_job');
        Route::get('flagged_jobs', 'ServiceController@flaggedJobs')->name('flagged_jobs');
        Route::post('reply-flag', 'ServiceController@replyFlag')->name('reply-flag');

        //#####################
        //INVOICING
        //#####################
        Route::get('new-invoice','InvoiceController@create')->name('new-invoice');
        Route::get('get_account', 'InvoiceController@getAccount')->name('get_account');
        Route::get('get_services', 'InvoiceController@getServices')->name('get_services');
        Route::post('store-invoice', 'InvoiceController@store')->name('store-invoice');
        Route::get('all-invoices', 'InvoiceController@index')->name('all-invoices');
        Route::get('edit-invoice/{id}', 'InvoiceController@edit')->name('edit-invoice');
        Route::get('delete_edit_invoice_item', 'ItemsController@deleteInvoiceItem')->name('delete_edit_invoice_item');
        Route::post('update_invoice/{id}', 'InvoiceController@update')->name('update_invoice');
        Route::get('delete_invoice', 'InvoiceController@destroyAjax')->name('delete_invoice');
        Route::get('delete_invoice_from_all','InvoiceController@destroyAjaxFromAll')->name('delete_invoice_from_all');
        Route::get('flag-invoice/{id}','InvoiceController@flag')->name('flag-invoice');
        Route::get('admin_view_invoice/{invoice_id}', 'InvoiceController@viewInvoiceAdmin')->name('admin_view_invoice');
    });

        //#####################
        //ROUTES FOR USERS IN THE SYSTEM
        //#####################
        //
        //(Clients)
        Route::group(['prefix'=>'user'], function(){
            Route::get('clients', 'UserController@index')->name('clients');
            Route::get('view/{id}','UserController@show')->name('view');
            Route::get('user_status/{id}/{status}', 'UserController@statusChange')->name('user_status');

            //Edit
            Route::get('edit/{id}', ['as'=>'users_edit', 'uses' => 'UserController@profileEdit']);
            Route::post('edit/{id}', ['uses' => 'UserController@profileEditPost']);
            Route::get('profile/change-avatar/{id}', ['as'=>'change_avatar', 'uses' => 'UserController@changeAvatar']);
            //(Artisans)
            Route::get('artisans', 'ArtisanController@index')->name('artisans');
            Route::get('artisan/add', 'ArtisanController@create')->name('artisan/add');
            Route::post('artisan/add', 'ArtisanController@store');
            Route::get('view_artisan/{id}', 'ArtisanController@show')->name('view_artisan');
            Route::get('check_artisan_assigned', 'InvoiceController@checkArtisanAssigned')->name('check_artisan_assigned');
        });

});

//Ends//
Route::get('/', 'HomeController@index')->name('home');
Route::get('search', 'HomeController@search')->name('search');
Route::get('clear', 'HomeController@clearCache')->name('clear_cache');

Route::get('new_register', 'UserController@register')->name('new_register');
//Route::get('individual_register', 'UserController@register')->name('register');
Route::post('new-register', 'UserController@registerPost');//->name('individual_register');

Route::get('employer-register', 'UserController@registerEmployer')->name('register_employer');
Route::post('employer-register', 'UserController@registerEmployerPost');

Route::get('agent-register', 'UserController@registerAgent')->name('register_agent');
Route::post('agent-register', 'UserController@registerAgentPost');

Route::post('get-states-options', 'LocationController@getStatesOption')->name('get_state_option_by_country');

Route::get('apply_job', function (){
    return redirect(route('home'));
});
Route::post('apply_job', ['as' => 'apply_job', 'uses'=>'JobController@applyJob']);
//Route::post('flag-job/{id}', ['as' => 'flag_job_post', 'uses'=>'JobController@flagJob']);
Route::post('share-by-email', ['as' => 'share_by_email', 'uses'=>'JobController@shareByEmail']);
Route::get('employer/{user_name}/jobs', 'JobController@jobsByEmployer')->name('jobs_by_employer');
Route::post('follow-unfollow', 'FollowerController@followUnfollow')->name('follow_unfollow');


Route::get('jobs/', 'JobController@jobsListing')->name('jobs_listing');

Route::get('p/{slug}', ['as' => 'single_page', 'uses' => 'PostController@showPage']);

Route::get('blog', 'PostController@blogIndex')->name('blog_index');
Route::get('blog/{slug}', 'PostController@view')->name('blog_post_single');

Route::get('pricing', 'HomeController@pricing')->name('pricing');

Route::get('contact-us', 'HomeController@contactUs')->name('contact_us');
Route::post('contact-us', 'HomeController@contactUsPost');


//checkout
/*Route::get('checkout/{package_id}', 'PaymentController@checkout')->name('checkout')->middleware('auth');
Route::post('checkout/{package_id}', 'PaymentController@checkoutPost')->middleware('auth');

Route::get('payment/{transaction_id}', 'PaymentController@payment')->name('payment');
Route::post('payment/{transaction_id}', 'PaymentController@paymentPost');

Route::any('payment/{transaction_id}/success', 'PaymentController@paymentSuccess')->name('payment_success');
Route::any('payment-cancel', 'PaymentController@paymentCancelled')->name('payment_cancel');

//PayPal
Route::post('payment/{transaction_id}/paypal', 'PaymentController@paypalRedirect')->name('payment_paypal_pay');
Route::any('payment/paypal-notify/{transaction_id?}', 'PaymentController@paypalNotify')->name('paypal_notify');


Route::post('payment/{transaction_id}/stripe', 'PaymentController@paymentStripeReceive')->name('payment_stripe_receive');

Route::post('payment/{transaction_id}/bank-transfer', 'PaymentController@paymentBankTransferReceive')->name('bank_transfer_submit');*/


//Dashboard Route
Route::group(['prefix'=>'dashboard', 'middleware' => 'dashboard'], function(){
    

    Route::get('applied-jobs', 'DashboardController@dashboard')->name('applied_jobs');


    Route::group([], function(){

        Route::group(['prefix'=>'employer'], function(){

            /*Route::group(['prefix'=>'job'], function(){
                Route::get('new', 'JobController@newJob')->name('post_new_job');
                Route::post('new', 'JobController@newJobPost');
                Route::get('edit/{job_id}', 'JobController@edit')->name('edit_job');
                Route::post('edit/{job_id}', 'JobController@update');
                Route::get('posted', 'JobController@postedJobs')->name('posted_jobs');
            });*/

            Route::get('applicant', 'UserController@employerApplicant')->name('employer_applicant');
            Route::get('shortlisted', 'UserController@shortlistedApplicant')->name('shortlisted_applicant');
            Route::get('applicant/{application_id}/shortlist', 'UserController@makeShortList')->name('make_short_list');

            

        });
        Route::group(['prefix'=>'jobs'], function(){
            Route::get('/', 'JobController@pendingJobs')->name('pending_jobs');
            Route::get('pending', 'JobController@approvedJobs')->name('approved_jobs');
            Route::get('blocked', 'JobController@blockedJobs')->name('blocked_jobs');
            Route::get('status/{id}/{status}', 'JobController@statusChange')->name('job_status_change');

            Route::get('applicants/{job_id}', 'JobController@jobApplicants')->name('job_applicants');
        });


       


        Route::group(['prefix'=>'cms'], function(){
            Route::get('/', 'PostController@index')->name('pages');
            Route::get('page/add', 'PostController@addPage')->name('add_page');
            Route::post('page/add', 'PostController@store');

            Route::get('page/edit/{id}', 'PostController@pageEdit')->name('page_edit');
            Route::post('page/edit/{id}', 'PostController@pageEditPost');

            Route::get('posts', 'PostController@indexPost')->name('posts');
            Route::get('post/add', 'PostController@addPost')->name('add_post');
            Route::post('post/add', 'PostController@storePost');

            Route::get('post/edit/{id}', 'PostController@postEdit')->name('post_edit');
            Route::post('post/edit/{id}', 'PostController@postUpdate');

        });

    });


    Route::group(['middleware'=>'only_admin_access'], function(){

        Route::group(['prefix'=>'categories'], function(){
            
        });

        //Settings
        
    });

    Route::group(['prefix'=>'u'], function(){
        Route::get('applied-jobs', 'UserController@appliedJobs')->name('applied_jobs');
        Route::get('profile', 'UserController@profile')->name('profile');
        Route::get('profile/edit', 'UserController@profileEdit')->name('profile_edit');
        Route::post('profile/edit', 'UserController@profileEditPost');

        /**
         * Change Password route
         */
        Route::group(['prefix' => 'account'], function() {
            
        });

    });

    Route::group(['prefix' => 'account'], function() {
        
    });

});


//Single Sigment View
Route::get('{slug}', 'JobController@view')->name('job_view');

