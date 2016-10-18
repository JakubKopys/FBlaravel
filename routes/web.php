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
    if (Auth::guest())
        return view('auth.login');
    else
        return Redirect::to('/home');
});

Auth::routes();

// User routes
Route::get('/home', 'HomeController@index');
Route::get('/users', 'UsersController@index');
Route::get('/users/{user}', 'UsersController@show');
Route::get('/users/{user}/edit', 'UsersController@edit');
Route::patch('/users/{user}', 'UsersController@update');

// Post routes
Route::get('/posts/{post}', 'PostsController@show')->name('show_post_path');
Route::get('/posts/{post}/edit', 'PostsController@edit');
Route::patch('/posts/{post}', 'PostsController@update');
Route::post('/posts', 'PostsController@create');
Route::delete('/posts/{post}', 'PostsController@destroy');
Route::get('/posts/{post}/more_comments', 'PostsController@more_comments');

//Comment routes
Route::post('/posts/{post}/comments', 'CommentsController@create');

//Likes routes
Route::post('/posts/{post}/likes', 'PostLikeController@create');
Route::delete('/posts/{post}/likes', 'PostLikeController@destroy');
Route::post('/comments/{comment}/likes', 'CommentLikeController@create');
Route::delete('/comments/{comment}/likes', 'CommentLikeController@destroy');

//Friendship routes
Route::post('/users/{friend}/friendships', 'FriendshipsController@create');
Route::patch('/users/{friend}/friendships', 'FriendshipsController@update');
Route::delete('/users/{friend}/friendships', 'FriendshipsController@destroy');