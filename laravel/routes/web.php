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
    Route::post('auth/login', ['uses' => 'AuthController@postLogin']);
});

Route::group(['namespace' => 'Admin', 'middleware' => 'auth.admin'], function () {
    Route::get('admin/logout', ['uses' => 'AuthController@getLogout']);
    Route::get('admin/home', ['uses' => 'HomeController@getIndex']);
    Route::get('admin/resetpwd', ['uses' => 'ResetPasswordController@getReset']);
    Route::put('admin/updatepwd', ['uses' => 'ResetPasswordController@putReset']);
    Route::get('admin/auth', ['uses' => 'AdminController@getIndex']);
    Route::get('admin/add', ['uses' => 'AdminController@getAdd']);
    Route::post('admin/store', ['uses' => 'AdminController@postStore']);
    Route::post('admin/update/{id}', ['uses' => 'AdminController@postUpdate']);
    Route::get('admin/edit/{id}', ['uses' => 'AdminController@getEdit']);
    Route::get('admin/delete/{id}', ['uses' => 'AdminController@getDelete']);

    Route::get('users/', ['uses' => 'UsersController@getIndex']);
    Route::get('users/delete/{id}/{type}', ['uses' => 'UsersController@getDelete']);
    Route::get('users/show/{id}', ['uses' => 'UsersController@getShow']);
    Route::get('users/add', ['uses' => 'UsersController@getAdd']);
    Route::post('users/store', ['uses' => 'UsersController@postStore']);

    Route::get('item/', ['uses' => 'ItemsController@getIndex']);
    Route::get('item/add', ['uses' => 'ItemsController@getAdd']);
    Route::get('item/edit/{id}', ['uses' => 'ItemsController@getEdit']);
    Route::get('item/delete/{id}', ['uses' => 'ItemsController@getDelete']);
    Route::get('item/update/{id}', ['uses' => 'ItemsController@postUpdate']);
    Route::post('item/store', ['uses' => 'ItemsController@postStore']);

    Route::get('msg/', ['uses' => 'PushMsgController@getPushMsg']);
    Route::post('pushmsg', ['uses' => 'PushMsgController@postPushMsg']);

    Route::get('monsters/', ['uses' => 'MonstersController@getIndex']);
    Route::get('monsters/add', ['uses' => 'MonstersController@getAdd']);
    Route::get('monsters/edit/{id}', ['uses' => 'MonstersController@getEdit']);
    Route::post('monsters/store', ['uses' => 'MonstersController@postStore']);
    Route::post('monsters/update/{id}', ['uses' => 'MonstersController@postUpdate']);
    Route::get('monsters/delete/{id}', ['uses' => 'MonstersController@getDelete']);

    Route::get('mines/', ['uses' => 'MinesController@getIndex']);
    Route::get('mines/add', ['uses' => 'MinesController@getAdd']);
    Route::get('mines/edit/{id}', ['uses' => 'MinesController@getEdit']);
    Route::post('mines/store', ['uses' => 'MinesController@postStore']);
    Route::post('mines/update/{id}', ['uses' => 'MinesController@postUpdate']);
    Route::get('mines/delete/{id}', ['uses' => 'MinesController@getDelete']);

    Route::get('chests/', ['uses' => 'ChestsController@getIndex']);
    Route::get('chests/add', ['uses' => 'ChestsController@getAdd']);
    Route::get('chests/edit/{id}', ['uses' => 'ChestsController@getEdit']);
    Route::post('chests/store', ['uses' => 'ChestsController@postStore']);
    Route::post('chests/update/{id}', ['uses' => 'ChestsController@postUpdate']);
    Route::get('chests/delete/{id}', ['uses' => 'ChestsController@getDelete']);

    Route::get('events/', ['uses' => 'EventsController@getIndex']);
    Route::get('events/add', ['uses' => 'EventsController@getAdd']);
    Route::post('events/store', ['uses' => 'EventsController@postStore']);
    Route::post('events/update/{id}', ['uses' => 'EventsController@postUpdate']);
    Route::get('events/edit/{id}', ['uses' => 'EventsController@getEdit']);
    Route::get('events/delete/{id}', ['uses' => 'EventsController@getDelete']);

    Route::get('equipments/', ['uses' => 'EquipmentsController@getIndex']);
    Route::get('equipments/add', ['uses' => 'EquipmentsController@getAdd']);
    Route::post('equipments/store', ['uses' => 'EquipmentsController@postStore']);
    Route::post('equipments/update/{id}', ['uses' => 'EquipmentsController@postUpdate']);
    Route::get('equipments/edit/{id}', ['uses' => 'EquipmentsController@getEdit']);
    Route::get('equipments/delete/{id}', ['uses' => 'EquipmentsController@getDelete']);

    Route::get('shop/', ['uses' => 'ShopController@getIndex']);
    Route::get('shop/add', ['uses' => 'ShopController@getAdd']);
    Route::post('shop/store', ['uses' => 'ShopController@postStore']);
    Route::post('shop/update/{id}', ['uses' => 'ShopController@postUpdate']);
    Route::get('shop/edit/{id}', ['uses' => 'ShopController@getEdit']);
    Route::get('shop/delete/{id}', ['uses' => 'ShopController@getDelete']);

});


