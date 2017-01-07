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
        Route::post('auth/sign/sms', ['uses' => 'AuthController@postSignSms']);
    });

    Route::group(['namespace' => 'Consume', 'middleware' => ['auth.api']], function () {
        Route::get('consume/action/{action}', ['uses' => 'ConsumeController@getAction']);
    });

    Route::group(['namespace' => 'Data'], function () {
        Route::get('data/exchange/gold', ['uses' => 'ExchangeController@getGold']);
        Route::get('data/log/online', ['uses' => 'LogController@getOnLine']);
        Route::get('data/log/offline', ['uses' => 'LogController@getOffLine']);
        Route::get('data/qiniu/token', ['uses' => 'QiniuController@getToken']);
        Route::get('data/qiniu/domain', ['uses' => 'QiniuController@getDomain']);
    });

    Route::group(['namespace' => 'Event', 'middleware' => ['auth.api']], function () {
        Route::get('chest/open/{eventId}', ['uses' => 'ChestController@getOpen']);
        Route::get('event/all', ['uses' => 'EventController@getAll']);
        Route::post('event/add', ['uses' => 'EventController@postAdd']);
        Route::post('event/open', ['uses' => 'EventController@postOpen']);
        Route::get('event/life', ['uses' => 'EventController@getLifeCycle']);
        Route::get('event/refresh/{count}/{out}', ['uses' => 'EventController@getRefresh']);
        Route::get('host/mine', ['uses' => 'HostController@getMine']);
        Route::get('host/prize/{hostEventId}', ['uses' => 'HostController@getPrize']);
        Route::get('mining/start/{eventId}', ['uses' => 'MiningController@getStart']);
        Route::get('mining/complete/{hostEventId}', ['uses' => 'MiningController@getComplete']);
        Route::post('monster/atk', ['uses' => 'MonsterController@postAtk']);
        Route::get('monster/prize/{eventId}', ['uses' => 'MonsterController@getPrize']);
    });

    Route::group(['namespace' => 'Purchase', 'middleware' => ['auth.api']], function () {
        Route::post('purchase/verify', ['uses' => 'PurchaseController@postVerify']);
    });

    Route::group(['namespace' => 'Replenish', 'middleware' => ['auth.api']], function () {
        Route::get('replenish/power/{quantity}', ['uses' => 'ReplenishController@getPower']);
        Route::get('replenish/space/{quantity}', ['uses' => 'ReplenishController@getSpace']);
        Route::get('replenish/action/{quantity}', ['uses' => 'ReplenishController@getAction']);
    });

    Route::group(['namespace' => 'Profile', 'middleware' => ['auth.api']], function () {
        Route::get('backpack/tool', ['uses' => 'BackpackController@getTool']);
        Route::get('equip/upgrade/{position}', ['uses' => 'EquipController@getUpgrade']);
        Route::get('profile/detail', ['uses' => 'ProfileController@getDetail']);
        Route::post('profile/update', ['uses' => 'ProfileController@postUpdate']);
        Route::post('wechat/bind', ['uses' => 'WechatController@postBind']);
        Route::post('wechat/unbind', ['uses' => 'WechatController@postUnbind']);
    });

    Route::group(['namespace' => 'Shop', 'middleware' => ['auth.api']], function () {
        Route::get('shop/goods', ['uses' => 'ShopController@getGoods']);
        Route::get('shop/diamond', ['uses' => 'DiamondController@getDiamond']);
    });

    Route::group(['namespace' => 'Wechat'], function () {
        Route::get('wechat/subscribe', ['uses' => 'WechatController@getSubscribe']);
        Route::post('wechat/subscribe', ['uses' => 'WechatController@postSubscribe']);
    });

    Route::group(['namespace' => 'Withdraw', 'middleware' => ['auth.api']], function () {
        Route::post('withdraw/sms', ['uses' => 'WithdrawController@postSms']);
        Route::post('withdraw/password', ['uses' => 'WithdrawController@postPassword']);
        Route::post('withdraw/update/password', ['uses' => 'WithdrawController@postUpdatePwd']);
        Route::post('withdraw/redpack', ['uses' => 'WithdrawController@postRedpack']);
    });

    Route::group(['namespace' => 'Xml'], function () {
        Route::get('xml/download/{file}', ['uses' => 'XmlController@getDownload']);
    });
});
