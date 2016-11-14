<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('auth/signin', ['uses' => 'AuthController@postSignin']);
        Route::post('auth/signup', ['uses' => 'AuthController@postSignup']);
        Route::post('auth/signup/sms', ['uses' => 'AuthController@postSignupSms']);
    });

    Route::group(['namespace' => 'Data'], function () {
        Route::get('job/all', ['uses' => 'JobController@getAll']);
    });

    Route::group(['namespace' => 'Event', 'middleware' => ['auth.api']], function () {
        Route::get('chest/open/{eventId}', ['uses' => 'ChestController@getOpen']);
        Route::get('event/refresh', ['uses' => 'EventController@getRefresh']);
        Route::get('host/mine', ['uses' => 'HostController@getMine']);
        Route::get('mining/start/{eventId}', ['uses' => 'MiningController@getStart']);
        Route::get('mining/complete/{hostEventId}', ['uses' => 'MiningController@getComplete']);
        Route::post('monster/atk', ['uses' => 'MonsterController@postAtk']);
    });

    Route::group(['namespace' => 'Profile', 'middleware' => ['auth.api']], function () {
        Route::get('backpack/tool', ['uses' => 'BackpackController@getTool']);
        Route::get('equip/upgrade/{position}', ['uses' => 'EquipController@getUpgrade']);
        Route::get('profile/detail', ['uses' => 'ProfileController@getDetail']);
        Route::post('profile/update', ['uses' => 'ProfileController@postUpdate']);
        Route::get('wechat/bind/{openid}', ['uses' => 'WechatController@getBind']);
    });
});
