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

Route::group(['as'=>'home.', 'namespace'=>'Front'], function(){
    Route::get('/', 'HomeController@index')->name('index');
});

Auth::routes();

Route::get('dashboard', function () {return redirect()->route('dashboard.index');});

Route::group(['as'=>'dashboard.', 'prefix'=>'dashboard', 'namespace'=>'Dashboard'], function(){
    Route::get('home', 'HomeController@index')->name('index');

    Route::group(['prefix' => 'appointment'], function() {
        Route::get('table', 'AppointmentController@tableView');
        Route::get('calendar', 'AppointmentController@calendar');
        Route::get('calendarView', 'AppointmentController@calendarView');
        Route::get('view', 'AppointmentController@getView');
        Route::get('get', 'AppointmentController@getAppointment');
        Route::get('profile', 'AppointmentController@profileVIew');
        Route::get('pending', 'AppointmentController@pendingAppointment');
        Route::get('pending/data', 'AppointmentController@pendingData');
        Route::get('confirm', 'AppointmentController@confirmAppointment');
    });

    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', 'UserController@profile')->name('profile');
        Route::post('updateProfileImage', 'UserController@updateProfileImage')->name('updateProfileImage');
        Route::get('edit', 'UserController@edit')->name('profileEdit');
        Route::post('update1', 'UserController@updateProfile1');
        Route::post('update2', 'UserController@updateProfile2');
        Route::post('update3', 'UserController@updateProfile3');
        Route::post('update4', 'UserController@updateProfile4');
        Route::get('doctor-profile/{id}', 'UserController@doctorProfile');
    });

    Route::group(['prefix' => 'chat'], function() {
        Route::get('/', 'ChatController@index');
        Route::get('page', 'ChatController@page')->name('chat');
        Route::post('initData', 'ChatController@getInitData');
        Route::post('data', 'ChatController@chatData')->name('chatData');
    });

    Route::group(['prefix' => 'notify'], function() {
        Route::get('modal', 'NotifyController@modal');
        Route::get('get', 'NotifyController@get');
        Route::post('video', 'NotifyController@setVideo');
        Route::get('video', 'NotifyController@getVideo');
        Route::get('call', 'NotifyController@setCall');
        Route::get('click', 'NotifyController@read');
        Route::get('readAll', 'NotifyController@readAll');
        Route::post('send', 'NotifyController@send');
    });

    Route::group(['prefix' => 'user'], function() {
        Route::get('/doctors', 'UserController@getDoctors');
        Route::get('/patients', 'UserController@getPatients');
        Route::post('like', 'UserController@likeUser');
        Route::get('search', 'UserController@searchUser');
    });

    Route::get('video/call/{roomName}', 'ChatController@joinRoom');

    Route::get('jobs/get', 'JobsController@getJobs');
    Route::resource('jobs', 'JobsController');
});

Route::group(['prefix'=>'dashboard', 'namespace'=>'Dashboard'], function() {
    Route::get('explore', 'ExploreController@index')->name('doctor-explore');
    Route::post('addStory', 'ExploreController@addStory')->name('add-story');
    Route::post('addComment', 'ExploreController@addComment')->name('add-comment');
});

Route::group(['prefix' => 'blogs'], function() {
    Route::get('explore/{story}', 'Dashboard\ExploreController@show')->name('blog-explore');
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['prefix' => 'ajax'], function() {
    Route::post('story-video-upload', 'FilehandleController@uploadStoryVideo')->name('ajax-video-story-upload');
    Route::post('story-image-upload', 'FilehandleController@uploadStoryImage')->name('ajax-image-story-upload');
});
