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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('auth/posts', 'HomeController@getPosts');

// get images

Route::get('/images', 'ImageController@getgalleryimages');
Route::post('/uploadimage', 'ImageController@uploadimage');

Route::get('gallery', 'ImageController@index')->middleware('auth')->name('gallery');

Route::get('/404', 'HomeController@notFound');

Route::get('auth/gallery', 'ImageController@getImages');

Route::get('image/{id}/islikedbyme', 'ImageController@isLikedByMe');
Route::post('image/like/{image}', 'ImageController@like');


// Route::get('auth/userposts/{user}', 'HomeController@usergetPosts');

Route::post('auth/post', 'PostController@storePost')->name('add.post');
Route::delete('auth/post/{post}', 'PostController@destroy');

Route::post('auth/upost/{post}', 'PostController@update')->name('update.post');

Route::get('post/{id}/islikedbyme', 'PostController@isLikedByMe');
Route::post('post/like/{post}', 'PostController@like');


Route::post('user/follow/{id}', 'UserController@my_follow');


Route::post('post/{post}/comment', 'CommentController@create');
Route::get('comments', 'CommentController@index');


Route::post('/upload', 'UserController@uploadpic');

Route::get('confirmation/resend');
Route::get('confirmation/{id}/{token}');

Route::get('post/{post}/getTotalLikes', 'PostController@getTotalLikes');
Route::get('profile/{user}', 'UserController@getProfile')->middleware('auth')->name('profile');



Route::get('auth/login', 'UserController@getLogin')->name('login');
Route::post('auth/login', 'UserController@userSignIn')->name('signin');
Route::get('auth/register', 'UserController@getRegister')->name('register');
Route::post('auth/register', 'UserController@userSignUp')->name('signup');

