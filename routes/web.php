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

Route::get('profile/{user}rou/edit', 'UserController@showProfileUpdateForm')->name('profile.update')->middleware('auth');
Route::put('profile/{user}/change_password', 'UserController@changePassword')->name('user.password.change')->middleware('auth');
Route::get('profile', 'UserController@index')->name('index.user')->middleware('auth');
Route::get('profile/{user}', 'UserController@show')->name('show.user.info');
Route::post('profile/{user}', 'UserController@updateAvatar')->name('update.avatar')->middleware('auth');
Route::put('profile/{user}', 'UserController@edit')->name('user.info.update')->middleware('auth');


Route::resource('posts', 'PostsController')->middleware('verified');


Route::post('follow/{user}', 'FollowerController@followUser')->name('follow')->middleware('auth');
Route::post('friendRequest/{user}', 'FriendsController@sendFriendRequest')->name('send.friend.request')->middleware('auth');
Route::patch('friendRequest/{user}', 'FriendsController@acceptFriend')->name('accept.friendship')->middleware('auth');
Route::delete('friendRequest/{user}', 'FriendsController@endFriendship')->name('end.friendship')->middleware('auth');

Route::get('albums', 'AlbumsController@index')->name('albums.index')->middleware('auth');
Route::get('albums/create', 'AlbumsController@create')->name('albums.create')->middleware('auth');
Route::post('albums', 'AlbumsController@store')->name('albums.store')->middleware('auth');
Route::get('albums/{album}', 'AlbumsController@show')->name('albums.show')->middleware('auth');


Route::get('photos/{album}/create', 'PhotosController@create')->name('photos.create')->middleware('auth');
Route::post('photos/store', 'PhotosController@store')->name('photos.store')->middleware('auth');
Route::get('photos/{photo}', 'PhotosController@show')->name('photos.show')->middleware('auth');
Route::delete('photos/{photo}', 'PhotosController@destroy')->name('photos.delete')->middleware('auth');




