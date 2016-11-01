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
    });

    Route::group(['namespace' => 'Event', 'middleware' => ['auth.api']], function () {
        Route::get('event', ['uses' => 'EventController@getIndex']);
        Route::get('monster/atk/{eventId}/{atk}', ['uses' => 'MonsterController@getAtk']);
    });

    Route::group(['namespace' => 'Profile', 'middleware' => ['auth.api']], function () {
        Route::get('backpack/tool', ['uses' => 'BackpackController@getTool']);
        Route::get('profile/detail', ['uses' => 'ProfileController@getDetail']);
        Route::post('profile/update', ['uses' => 'ProfileController@postUpdate']);
    });
});
