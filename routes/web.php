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
Route::put('profile/{user}/change_password', 'UserController@change_password')->name('user.password.change')->middleware('auth');
Route::get('profile', 'UserController@index')->name('index.user')->middleware('auth');
Route::get('profile/{user}', 'UserController@show')->name('show.user.info');
Route::post('profile/{user}', 'UserController@update_avatar')->name('update.avatar')->middleware('auth');
Route::put('profile/{user}', 'UserController@edit')->name('user.info.update')->middleware('auth');

Route::post('follow/{user}', 'FollowerController@followUser')->name('follow')->middleware('auth');
Route::post('friendRequest/{user}', 'FriendsController@sendFriendRequest')->name('send.friend.request')->middleware('auth');
Route::patch('friendRequest/{user}', 'FriendsController@acceptFriend')->name('accept.friendship')->middleware('auth');
Route::delete('friendRequest/{user}', 'FriendsController@endFriendship')->name('end.friendship')->middleware('auth');

Route::resource('posts', 'PostsController')->middleware('verified');




