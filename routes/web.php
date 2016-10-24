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

Route::get('/', 'HomeController@index');

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

/**
 * Post
 */
Route::get('posts', 'PostController@index');
Route::get('post/create', 'PostController@create');
Route::post('post/store', 'PostController@store');

Route::get('post/edit/{id}', 'PostController@edit');
Route::get('post/{id}', 'PostController@show');
Route::get('post/delete/{id}', 'PostController@destroy');
Route::get('posts/getposttoscroll/{offset}/{count}', 'PostController@getPostToScroll');

// For testing / temporary
Route::get('test', 'PostController@test');

/**
 * Comment
 */
Route::post('comment/add', 'CommentController@store');
Route::get('comments/{id}', 'CommentController@getComments');

/**
 * Tags
 */

Route::get('tag/add', 'TagController@store');
Route::get('tag/{tag}', 'TagController@getPostByTag');
