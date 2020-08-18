<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
	
Route::group(['prefix' => '/', 'namespace' => 'Api'], function() {
    Route::post('login_with_phone', 'ApiController@login_with_phone');
    Route::post('register_with_phone', 'ApiController@register_with_phone');
    Route::post('register', 'ApiController@register');
    Route::post('login', 'ApiController@login');
    Route::post('doctor_category', 'ApiController@doctor_category');
    Route::post('test', 'ApiController@test');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('post_job', 'ApiController@post_job');
        Route::post('job_meta', 'ApiController@job_meta');
        Route::post('job_sub_meta', 'ApiController@job_sub_meta');
        Route::post('get_job_shift', 'ApiController@get_job_shift');
        Route::post('get_applications_by_date', 'ApiController@get_applications_by_date');
        Route::post('action_application', 'ApiController@action_application');
        Route::post('logout', 'ApiController@logout');
        Route::post('get_candidate', 'ApiController@get_candidate');
        Route::post('get_candidate_by_category', 'ApiController@get_candidate_by_category');
        Route::post('get_candidate_by_skills', 'ApiController@get_candidate_by_skills');
        Route::post('get_candidate_details', 'ApiController@get_candidate_details');
        Route::post('get_profile', 'ApiController@get_profile');
        Route::post('get_pending_applications', 'ApiController@get_pending_applications');
        Route::post('get_applications', 'ApiController@get_applications');
        Route::post('get_application_details', 'ApiController@get_application_details');
        Route::post('cancel_job', 'ApiController@cancel_job');
        Route::post('create_chat', 'ApiController@create_chat');
        Route::post('update_info', 'ApiController@update_info');
        Route::post('chat_notification', 'ApiController@chat_notification');
        Route::post('update_job', 'ApiController@update_job');
        Route::post('get_notification', 'ApiController@get_notification');
        Route::post('read_notification', 'ApiController@read_notification');
        Route::post('doctor_home', 'ApiController@doctor_home');
        Route::post('doctor_job_listing', 'ApiController@doctor_job_listing');
        Route::post('apply_job', 'ApiController@apply_job');
        Route::post('doctor_applications_by_date', 'ApiController@doctor_applications_by_date');
        Route::post('doctor_cancel_job', 'ApiController@doctor_cancel_job');
        Route::post('generate_token', 'ApiController@generate_token');
        Route::post('user_match_by_phone', 'ApiController@user_match_by_phone');
        Route::post('doctor_by_category', 'ApiController@doctor_by_category');
        Route::post('add_fav_doctor', 'ApiController@add_fav_doctor');
        Route::post('add_friend', 'ApiController@add_friend');
        Route::post('friends_list', 'ApiController@friends_list');  
    });
});

// URL::forceScheme('https');
