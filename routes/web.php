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
 * My Posts
 */
Route::get('myposts', 'MyPostController@index');
Route::get('myposts/scroll/{skip}', 'MyPostController@scroll');
Route::get('myposts/create', 'MyPostController@create');
Route::post('myposts/store', 'MyPostController@store');
Route::get('myposts/edit/{id}', 'MyPostController@edit');
Route::get('myposts/delete/{id}', 'MyPostController@destroy');
Route::get('myposts/{search}', 'MyPostController@search');

/**
 * Post
 */
Route::get('posts/{id}', 'PostController@show');


/**
 * Tag
 */
Route::get('tag/{tag}', 'TagController@tagName');
Route::get('tags/{tag}/scroll/{skip}', 'TagController@scroll');
Route::get('tag/search/{search}', 'TagController@search');

/**
 * Need scroll to home, tag, user, search
 */
Route::get('posts/getposttoscroll/{offset}/{count}', 'PostController@getPostToScroll');

Route::get('home/scroll/{skip}', 'HomeController@scroll');

Route::get('user/{username}/scroll/{skip}', 'UserController@scroll');

Route::get('search/{search}/scroll/{skip}', 'SearchController@scroll');

Route::get('posts/{entry}/{param}/scroll/{offset}/{count}', 'PostController@scroll');

Route::get('search', 'PostController@search');
Route::get('user/{name}', 'PostController@getPostByUserName');

Route::get('test', 'PostController@test');

/**
 * Comment
 */
Route::post('comment/add', 'CommentController@store');
Route::get('comments/{id}', 'CommentController@getComments');

