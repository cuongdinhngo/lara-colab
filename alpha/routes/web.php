<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/lang/{locale}', 'Language\LanguageController@generate');

Route::put('/put-cache', 'Language\LanguageController@putCache');

Route::group(['middleware' => ['locale']], function () {
    Route::get('/get-cache/{key}', 'Language\LanguageController@getCache');
});

Route::get("/notify", function(){
    return App\Models\User::find(1)->notify(new App\Authentication\SendOtp('twilio', 4, 10));
});

Route::get("/check-otp/{otp}", function(){
    dump(request()->otp);
    // return auth()->user->checkOtp(request()->otp);
    return App\Models\User::find(1)->checkOtp(request()->otp);
});

Route::get("/check-otp/{otp}", function(){
    dump(request()->otp);
    return App\Models\User::authByOtp(request()->otp, '84905279285');
});

Route::get("/bot", function () {
    // detect user-agents of  crawlers and block via .htaccess
    dd($_SERVER);
});
