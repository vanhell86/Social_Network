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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('profile/{user}/edit', 'UserController@showProfileUpdateForm')->name('profile.update')->middleware('auth');
Route::get('profile/{user}', 'UserController@show')->name('show.user.info');
Route::post('profile/{user}', 'UserController@update_avatar')->name('update.avatar')->middleware('auth');
Route::put('profile/{user}', 'UserController@edit')->name('user.info.update')->middleware('auth');

Route::resource('posts', 'PostsController')->middleware('verified');




