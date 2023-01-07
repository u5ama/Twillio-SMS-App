<?php


use Illuminate\Support\Facades\Route;


Route::get('/', 'LoginController@index')->name('login');
Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@loginCheck')->name('loginCheck');

Route::group(['middleware' => ['auth:admin', 'adminLanguage']], function () {

    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    // Admin Panel drivers Resource
    Route::resource('drivers', 'DriverController');

    Route::resource('stations', 'StationsController');

    Route::resource('buses', 'BusController');

    // Admin Panel Company Status Get Method
    Route::get('getDriverStatus/{company_id}', 'DriverController@getDriverStatus')->name('getDriverStatus');

    // Admin Panel Company Status Change Method
    Route::get('driver/{id}/{status}', 'DriverController@status')->name('driverStatus');

//    Route::resource('categories', 'CategoriesController');

//    Route::resource('gifts', 'GiftsController');
//
//    Route::resource('gifts_sent', 'GiftsManageController');
//
//    Route::resource('payments', 'WithdrawRequestsController');


    Route::resource('admin', 'AdminController');

    Route::get('admin/status/{id}/{status}', 'AdminController@changeStatus')->name('admin.status.change');

    Route::post('getChart', 'AdminController@getChart')->name('getChart');
    Route::post('getUserChart', 'AdminController@getUserChart')->name('getUserChart');

    Route::get('user/status/{id}/{status}', 'UserController@changeStatus')->name('user.status.change');
    Route::get('userDetails/{id}', 'UserController@userDetails')->name('userDetails');

    Route::get('profile', 'HomeController@profile')->name('profile');
    Route::post('editProfile', 'HomeController@editProfile')->name('editProfile');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('password', 'PasswordController@index')->name('password');
    Route::post('changePassword', 'PasswordController@changePassword')->name('changePassword');

    Route::get('changeThemes/{id}', 'HomeController@changeThemes')->name('changeThemes');
    Route::get('changeThemesMode/{local}', 'HomeController@changeThemesMode')->name('changeThemesMode');

    Route::resource('role', 'RoleController');
    Route::resource('user', 'UserController');

    Route::resource('permission', 'PermissionController');
    Route::resource('smtp-credential', 'SmtpCredentialController');
    Route::get('smtp-credential/status/{id}/{status}', 'SmtpCredentialController@changeStatus')->name('smtp-credential.status.change');
    Route::resource('fcm-credential', 'FcmCredentialController');
    Route::get('fcm-credential/status/{id}/{status}', 'FcmCredentialController@changeStatus')->name('fcm-credential.status.change');

    Route::resource('language', 'LanguageController');
    Route::get('language/status/{id}/{status}', 'LanguageController@changeStatus')->name('language.status.change');

    Route::resource('language-screen', 'LanguageScreenController');
    Route::post('getLanguageScreen', 'LanguageStringController@getLanguageScreen')->name('getLanguageScreen');
    Route::get('view-language-screen/{id}', 'LanguageScreenController@viewLanguageScreen')->name('view-language-screen');

    Route::get('viewScreenString', 'LanguageScreenController@viewScreenString')->name('viewScreenString');
    Route::get('language-screen/status/{id}/{status}', 'LanguageScreenController@changeStatus')->name('languageScreen.status.change');
    Route::resource('language-string', 'LanguageStringController');
    Route::get('language-string/status/{id}/{status}', 'LanguageStringController@changeStatus')->name('languageString.status.change');

    Route::resource('drivers_notifications', 'DriverNotificationsController');
    Route::resource('locations_notifications', 'LocationsNotificationsController');
    Route::resource('buses_notifications', 'BusesNotificationsController');

//    Route::get('report-problem', 'ReportProblemController@index')->name('report-problem');
//    Route::delete('reportProblemDelete/{id}', 'ReportProblemController@destroy')->name('reportProblemDelete');
//    Route::get('reportProblemDetails/{id}', 'ReportProblemController@show')->name('reportProblemDetails');
//    Route::get('contact-us', 'ContactUsController@index')->name('contact-us');
//    Route::delete('contactUsDelete/{id}', 'ContactUsController@destroy')->name('contactUsDelete');

//    Route::resource('app-control', 'AppControlController');
//    Route::resource('app-menu', 'AppMenusController');
//    Route::get('app-menu/{id}/{status}', 'AppMenusController@changeWebView')->name('changeWebView');
//    Route::post('app-menu_saveOrder','AppMenusController@saveOrder');
//    Route::resource('social-link', 'SocialLinkController');

//    Route::post('getChart', 'AdminController@getChart')->name('getChart');
//    Route::post('getUserChart', 'AdminController@getUserChart')->name('getUserChart');
//    Route::post('settingUpdate', 'SettingController@settingUpdate')->name('settingUpdate');
//    Route::get('setting', 'SettingController@index')->name('setting');

    Route::resource('panel-color', 'PanelColorController');
    Route::get('panelColorChangeStatus/{id}/{status}', 'PanelColorController@appColorChangeStatus')->name('panelColorChangeStatus');

    Route::get('appControlChangeStatus/{id}/{status}', 'AppControlController@appControlChangeStatus')->name('appControlChangeStatus');
    Route::get('socialLinkChangeStatus/{id}/{status}', 'SocialLinkController@socialLinkChangeStatus')->name('socialLinkChangeStatus');

});
