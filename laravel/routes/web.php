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

    Route::get('equipments', ['uses' => 'EquipmentsController@getIndex']);

    Route::get('events', ['uses' => 'EventsController@getIndex']);

    Route::get('item', ['uses' => 'ItemsController@getIndex']);

    Route::get('level', ['uses' => 'LevelController@getIndex']);

    Route::get('monsters', ['uses' => 'MonstersController@getIndex']);

    Route::get('msg', ['uses' => 'PushMsgController@getPushMsg']);
    Route::post('pushmsg', ['uses' => 'PushMsgController@postPushMsg']);

    Route::get('shop', ['uses' => 'ShopController@getIndex']);

    Route::get('users', ['uses' => 'UsersController@getIndex']);
    Route::get('users/delete/{userId}/{type}', ['uses' => 'UsersController@getDelete']);
    Route::get('users/show/{userId}', ['uses' => 'UsersController@getShow']);

    Route::get('jobs', ['uses' => 'JobsController@getIndex']);

    Route::get('state', ['uses' => 'StateController@getIndex']);

    Route::get('exchange', ['uses' => 'ExchangeGoldController@getIndex']);
    Route::post('exchange/store', ['uses' => 'ExchangeGoldController@postStore']);

    Route::get('helper/qiniu-token', ['uses' => 'HelperController@getQiniuToken']);

    Route::get('order', ['uses' => 'OrdersController@getIndex']);

    Route::get('consume', ['uses' => 'ConsumeController@getIndex']);

    Route::get('diamond', ['uses' => 'DiamondController@getIndex']);
    Route::get('diamond/add', ['uses' => 'DiamondController@getAdd']);
    Route::get('diamond/edit/{diamondId}', ['uses' => 'DiamondController@getEdit']);
    Route::post('diamond/update/{diamondId}', ['uses' => 'DiamondController@postUpdate']);
    Route::post('diamond/store', ['uses' => 'DiamondController@postStore']);

    Route::get('xml_management', ['uses' => 'XmlManagementController@getIndex']);
    Route::get('xml_management/adit/{xmlId}', ['uses' => 'XmlManagementController@getEdit']);
    Route::get('xml_management/show/{xmlId}', ['uses' => 'XmlManagementController@getShow']);
    Route::post('xml_management/postStoreVersion/{xmlId}', ['uses' => 'XmlManagementController@postStoreVersion']);
    Route::post('xml_management/postModifyUrl/{xmlId}', ['uses' => 'XmlManagementController@postModifyUrl']);
    Route::get('xml_management/add', ['uses' => 'XmlManagementController@getAdd']);
    Route::post('xml_management/postStoreFilename', ['uses' => 'XmlManagementController@postStoreFilename']);

});


