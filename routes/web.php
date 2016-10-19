<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('auth/redirect', 'Auth\SocialAuthController@redirect');
Route::get('auth/callback', 'Auth\SocialAuthController@callback');

Auth::routes();

Route::get('/user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');

Route::get('home', 'HomeController@index');

/**
 * Profile
 */
Route::get('profile', 'ProfileController@index');
Route::post('profile', 'ProfileController@store');

Route::get('profile/changepassword', 'ProfileController@changepassword');
Route::post('profile/changepassword', 'ProfileController@storechangepassword');

