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


Route::get('/test',function(){
    dump(session('confirmPassword'));
});

Route::get('/getEnv',function(){
    echo getEnv('APP_KEY');
});

Route::get('/makePassword',function(){
    return bcrypt('123456');
});

Route::get('/','StaticPagesController@home')->name("home");

Route::get('/help','StaticPagesController@help')->name("help");

Route::get('/about','StaticPagesController@about')->name("about");

Route::get('/signup','UsersController@create')->name('signup');

Route::resource('users','UsersController');

Route::get('/login','SessionsController@create')->name('login');

Route::post('/login','SessionsController@store')->name('login');

Route::delete('/logout','SessionsController@destroy')->name('logout');


Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');

Route::post('/password/email','ForgotPasswordController@sendEmail')->name('password.email');

Route::get('/password/reset/token','ForgotPasswordController@resetToken')->name('password.token');

Route::post('/password/check','ForgotPasswordController@check')->name('password.check');

//微博的发布和删除
Route::resource('/statuses','StatusesController',['only'=>['store','destory']]);
