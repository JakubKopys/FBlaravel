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
Route::get('/posts/{post}', 'PostsController@show');
Route::post('/users/{user}/posts', 'PostsController@create');
Route::get('/posts/{post}/edit', 'PostsController@edit');
Route::patch('/users/{user}/posts', 'PostsController@update');
Route::get('test', 'PostsController@testfunction');
Route::post('test', 'PostsController@testfunction');
Route::post('/posts', 'PostsController@ajaxcreate');