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

    Route::get('users', ['uses' => 'UsersController@getIndex']);
    Route::get('users/delete/{userId}/{type}', ['uses' => 'UsersController@getDelete']);
    Route::get('users/show/{userId}', ['uses' => 'UsersController@getShow']);
    Route::get('users/add', ['uses' => 'UsersController@getAdd']);
    Route::post('users/store', ['uses' => 'UsersController@postStore']);

    Route::get('item', ['uses' => 'ItemsController@getIndex']);
    Route::get('item/add', ['uses' => 'ItemsController@getAdd']);
    Route::get('item/edit/{itemId}', ['uses' => 'ItemsController@getEdit']);
    Route::get('item/delete/{itemId}', ['uses' => 'ItemsController@getDelete']);
    Route::get('item/update/{itemId}', ['uses' => 'ItemsController@postUpdate']);
    Route::post('item/store', ['uses' => 'ItemsController@postStore']);

    Route::get('msg', ['uses' => 'PushMsgController@getPushMsg']);
    Route::post('pushmsg', ['uses' => 'PushMsgController@postPushMsg']);

    Route::get('monsters', ['uses' => 'MonstersController@getIndex']);
    Route::get('monsters/add', ['uses' => 'MonstersController@getAdd']);
    Route::get('monsters/edit/{monsterId}', ['uses' => 'MonstersController@getEdit']);
    Route::post('monsters/store', ['uses' => 'MonstersController@postStore']);
    Route::post('monsters/update/{monsterId}', ['uses' => 'MonstersController@postUpdate']);
    Route::get('monsters/delete/{monsterId}', ['uses' => 'MonstersController@getDelete']);

    Route::get('mines', ['uses' => 'MinesController@getIndex']);
    Route::get('mines/add', ['uses' => 'MinesController@getAdd']);
    Route::get('mines/edit/{mineId}', ['uses' => 'MinesController@getEdit']);
    Route::post('mines/store', ['uses' => 'MinesController@postStore']);
    Route::post('mines/update/{mineId}', ['uses' => 'MinesController@postUpdate']);
    Route::get('mines/delete/{mineId}', ['uses' => 'MinesController@getDelete']);

    Route::get('chests', ['uses' => 'ChestsController@getIndex']);
    Route::get('chests/add', ['uses' => 'ChestsController@getAdd']);
    Route::get('chests/edit/{chestId}', ['uses' => 'ChestsController@getEdit']);
    Route::post('chests/store', ['uses' => 'ChestsController@postStore']);
    Route::post('chests/update/{chestId}', ['uses' => 'ChestsController@postUpdate']);
    Route::get('chests/delete/{chestId}', ['uses' => 'ChestsController@getDelete']);

    Route::get('events', ['uses' => 'EventsController@getIndex']);
    Route::get('events/add', ['uses' => 'EventsController@getAdd']);
    Route::post('events/store', ['uses' => 'EventsController@postStore']);
    Route::post('events/update/{eventId}', ['uses' => 'EventsController@postUpdate']);
    Route::get('events/edit/{eventId}', ['uses' => 'EventsController@getEdit']);
    Route::get('events/delete/{eventId}', ['uses' => 'EventsController@getDelete']);

    Route::get('equipments', ['uses' => 'EquipmentsController@getIndex']);
    Route::get('equipments/add', ['uses' => 'EquipmentsController@getAdd']);
    Route::post('equipments/store', ['uses' => 'EquipmentsController@postStore']);
    Route::post('equipments/update/{equipId}', ['uses' => 'EquipmentsController@postUpdate']);
    Route::get('equipments/edit/{equipId}', ['uses' => 'EquipmentsController@getEdit']);
    Route::get('equipments/delete/{equipId}', ['uses' => 'EquipmentsController@getDelete']);

    Route::get('shop', ['uses' => 'ShopController@getIndex']);
    Route::get('shop/add', ['uses' => 'ShopController@getAdd']);
    Route::get('shop/price/{id}/{value}', ['uses' => 'ShopController@getSetPrice']);
    Route::post('shop/store/{id}', ['uses' => 'ShopController@postStore']);
    Route::post('shop/update/{id}', ['uses' => 'ShopController@postUpdate']);
    Route::get('shop/edit/{id}', ['uses' => 'ShopController@getEdit']);
    Route::get('shop/delete/{id}', ['uses' => 'ShopController@getDelete']);

});


