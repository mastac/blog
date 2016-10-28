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

/**
 * Auth
 */
Auth::routes();

/**
 * Activation user from sending link in email
 */
Route::get('/user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');

/**
 * SocialAuth
 */
Route::get('auth/redirect', 'Auth\SocialAuthController@redirect');
Route::get('auth/callback', 'Auth\SocialAuthController@callback');

/**
 * Home page
 */
Route::get('/', 'HomeController@home');
Route::get('home', 'HomeController@home');
Route::get('home/scroll/{skip}', 'HomeController@scroll');
// Search
Route::post('home/search', 'HomeController@searchRedirect');
Route::get('home/search/{search}', 'HomeController@search');
Route::get('home/search/{search}/scroll/{skip}', 'HomeController@scrollSearch');

/**
 * Profile
 */
Route::get('profile', 'ProfileController@index');
Route::post('profile', 'ProfileController@store');

Route::get('profile/changepassword', 'ProfileController@changepassword');
Route::post('profile/changepassword', 'ProfileController@storechangepassword');

/**
 * My Posts
 */
Route::get('myposts', 'MyPostController@index');
Route::get('myposts/scroll/{skip}', 'MyPostController@scroll');

Route::get('myposts/create', 'MyPostController@create');
Route::post('myposts/store', 'MyPostController@store');
Route::get('myposts/edit/{id}', 'MyPostController@edit');
Route::get('myposts/delete/{id}', 'MyPostController@destroy');

// Search
Route::post('myposts/{search}', 'MyPostController@searchRedirect');
Route::get('myposts/search/{search}', 'MyPostController@search');
Route::get('myposts/search/{search}/scroll/{skip}', 'MyPostController@scrollSearch');

/**
 * Post
 */
Route::get('posts/{id}', 'PostController@show');

/**
 * Tag
 */
Route::get('tags/{tag}', 'TagController@tagByName');
Route::get('tags/{tag}/scroll/{skip}', 'TagController@scrollByTagName');
// Search
Route::post('tags/{tag}/search', 'TagController@searchRedirect');
Route::get('tags/{tag}/search/{search}', 'TagController@searchByTagName');
Route::get('tags/{tag}/search/{search}/scroll/{skip}', 'TagController@scrollSearchByTagName');

/**
 * User
 */
Route::get('user/{username}', 'UserController@postByUsername');
Route::get('user/{username}/scroll/{skip}', 'UserController@scrollByUsername');
// Search
Route::get('user/{username}/search', 'UserController@searchEmpty');
Route::post('user/{username}/search', 'UserController@searchRedirect');
Route::get('user/{username}/search/{search}', 'UserController@searchByUsername');
Route::get('user/{username}/search/{search}/scroll/{skip}', 'UserController@scrollSearchByUsername');

/**
 * Comment
 */
Route::post('comment/add', 'CommentController@store');
Route::get('comments/{id}', 'CommentController@getComments');

Route::get('test', 'PostController@test');