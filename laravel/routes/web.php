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
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', ['uses' => 'AuthController@getLogin']);
    Route::post('login', ['uses' => 'AuthController@postLogin']);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth.admin'], function () {
    Route::get('logout', ['uses' => 'AuthController@getLogout']);
    Route::get('admin/home', ['uses' => 'HomeController@getIndex']);
    Route::get('admin/resetpwd', ['uses' => 'ResetPasswordController@getReset']);
    Route::put('admin/updatepwd', ['uses' => 'ResetPasswordController@putReset']);
    Route::get('admin/auth', ['uses' => 'AdminController@getIndex']);
    Route::get('admin/add', ['uses' => 'AdminController@getAdd']);
    Route::post('admin/store', ['uses' => 'AdminController@postStore']);
    Route::post('admin/update/{adminId}', ['uses' => 'AdminController@postUpdate']);
    Route::get('admin/edit/{adminId}', ['uses' => 'AdminController@getEdit']);
    Route::get('admin/delete/{adminId}', ['uses' => 'AdminController@getDelete']);

    Route::get('chests', ['uses' => 'ChestsController@getIndex']);
     Route::post('chests/xml', ['uses' => 'ChestsController@postImportXml']);

    Route::get('equipments', ['uses' => 'EquipmentsController@getIndex']);
    Route::post('equipments/xml', ['uses' => 'EquipmentsController@postImportXml']);

    Route::get('events', ['uses' => 'EventsController@getIndex']);
    Route::post('events/xml', ['uses' => 'EventsController@postImportXml']);

    Route::get('item', ['uses' => 'ItemsController@getIndex']);
    Route::post('item/xml', ['uses' => 'ItemsController@postImportXml']);

    Route::get('level', ['uses' => 'LevelController@getIndex']);
    Route::post('level/xml', ['uses' => 'LevelController@postImportXml']);

    Route::get('mines', ['uses' => 'MinesController@getIndex']);
    Route::post('mines/xml', ['uses' => 'MinesController@postImportXml']);

    Route::get('monsters', ['uses' => 'MonstersController@getIndex']);
    Route::post('monsters/xml', ['uses' => 'MonstersController@postImportXml']);

    Route::get('msg', ['uses' => 'PushMsgController@getPushMsg']);
    Route::post('pushmsg', ['uses' => 'PushMsgController@postPushMsg']);

    Route::get('shop', ['uses' => 'ShopController@getIndex']);
     Route::post('shop/xml', ['uses' => 'ShopController@postImportXml']);

    Route::get('users', ['uses' => 'UsersController@getIndex']);
    Route::get('users/delete/{userId}/{type}', ['uses' => 'UsersController@getDelete']);
    Route::get('users/show/{userId}', ['uses' => 'UsersController@getShow']);
    Route::get('users/add', ['uses' => 'UsersController@getAdd']);
    Route::post('users/store', ['uses' => 'UsersController@postStore']);

    Route::get('jobs', ['uses' => 'JobsController@getIndex']);
    Route::post('jobs/xml', ['uses' => 'JobsController@postImportXml']);
});


