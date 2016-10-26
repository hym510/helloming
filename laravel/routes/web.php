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
    Route::get('admin/auth', ['uses' => 'AdminController@getIndex']);
    Route::get('admin/edit', ['uses' => 'AdminController@getEdit']);
    Route::post('admin/store', ['uses' => 'AdminController@postStore']);
    Route::post('admin/update', ['uses' => 'AdminController@postUpdate']);
    Route::get('admin/data/{id}', ['uses' => 'AdminController@getData']);
    Route::get('admin/delete/{id}', ['uses' => 'AdminController@getDelete']);
});

