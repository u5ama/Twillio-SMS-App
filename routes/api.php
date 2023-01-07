<?php

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
Route::prefix('v1')->name('api.v1.')->namespace('Api\V1')->group(function(){

    // User Register
    Route::post('register', 'UserController@register')->name('register');

    //verify OTP
    Route::post('verify_otp', 'UserController@verifyOTP')->name('verify_otp');

    // User Login
    Route::post('login', 'UserController@loginUser')->name('login');

    // Social Links
    Route::get('socialLinks', 'SocialLinkController');

    // Pages
    Route::get('allPages', 'PageController@allPages')->name('allPages');
    Route::get('page/{id}', 'PageController@index')->name('index');


    Route::post('twillioSms', 'TwilioController@receiveSMS')->name('twillioSms');

    Route::group(['middleware' => ['jwt.verify']], function(){
            // User Profile Image
            Route::post('profile_image', 'UserController@profileImage')->name('profile_image');

            // user edit profile
            Route::post('editProfile', 'UserController@editProfile')->name('editProfile');

            // log out
            Route::get('logout', 'UserController@logout')->name('logout');

        });
});
