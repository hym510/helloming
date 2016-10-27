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
Route::group(['namespace' => 'Admin'], function () {
    Route::get('auth/login', ['uses' => 'AuthController@getLogin']);
    Route::post('auth/logint', ['uses' => 'AuthController@postLogin']);
});

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('admin/logout', ['uses' => 'AuthController@getLogout']);
    Route::get('admin/home', ['uses' => 'HomeController@getIndex']);
    Route::get('admin/resetpassword', ['uses' => 'ResetPasswordController@getReset']);
    Route::put('admin/updatapassword', ['uses' => 'ResetPasswordController@putReset']);
    Route::get('admin/auth', ['uses' => 'AdminController@getIndex']);
    Route::get('admin/edit', ['uses' => 'AdminController@getEdit']);
    Route::post('admin/store', ['uses' => 'AdminController@postStore']);
    Route::post('admin/update/{id}', ['uses' => 'AdminController@postUpdate']);
    Route::get('admin/data/{id}', ['uses' => 'AdminController@getData']);
    Route::get('admin/delete/{id}', ['uses' => 'AdminController@getDelete']);
});

