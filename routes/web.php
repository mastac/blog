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
 * Post
 */
Route::get('posts/scroll/{skip}', 'PostController@scroll');

Route::get('posts/create', 'PostController@create');
Route::post('posts/store', 'PostController@store');
Route::get('posts/edit/{id}', 'PostController@edit');
Route::get('posts/delete/{id}', 'PostController@destroy');

Route::get('ajax/posts/{state}/{post_id}', 'PostController@setLikeAndDislike');

// Search
Route::post('posts/{search}', 'PostController@searchRedirect');
Route::get('posts/search/{search}', 'PostController@search');
Route::get('posts/search/{search}/scroll/{skip}', 'PostController@scrollSearch');


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

Route::get('ajax/comments/delete/{comment_id}', 'CommentController@deleteComment');
Route::get('ajax/comments/{state}/{comment_id}', 'CommentController@setLikeAndDislike');

Route::get('test', 'PostController@test');


/**
 * Admin
 */
Route::get('/admin/login', array('as' => 'login', 'uses' => 'Admin\AuthController@showLoginForm'))
    ->name('admin.login')->middleware('admin.guest');

Route::post('/admin/login', array('as' => 'login', 'uses' => 'Admin\AuthController@login'));

Route::post('/admin/logout', 'Admin\AuthController@logout')->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'namespace' => 'Admin'], function ()
{

    Route::get('/', 'UserController@index');
    Route::get('home', 'UserController@index')->name('admin.home');

    Route::resource('users', 'UserController');
    Route::resource('posts', 'PostController');
    Route::resource('comments', 'CommentController');

});
