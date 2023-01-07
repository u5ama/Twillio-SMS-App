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

Route::get('/email', function () {
    return view('emails.welcomeEmail');
});
Route::get('reset-password/{token}', 'ResetPasswordController@resetPasswordForm')->name('reset-password');
Route::post('resetPasswordSubmit', 'ResetPasswordController@resetPasswordSubmit')->name('resetPassword.update');
Route::get('/clear', function() {
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    echo "success";
});
