@extends('admin.widget.base')

@section('body')
    <header id="header">
        <div class="headerbar">
            <div class="headerbar-left">
                <ul class="header-nav header-nav-options">
                    <li class="header-nav-brand" >
                        <div class="brand-holder">
                            <a href="">
                                <span class="text-lg text-bold text-primary">find</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="headerbar-right">
                <ul class="header-nav header-nav-profile">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                            <span class="profile-info">
                                {{ auth()->user()->email }}
                                <small>{{ auth()->user()->name }}</small>
                            </span>
                        </a>
                        <ul class="dropdown-menu animation-dock">
                            <li><a href="{{ action('Admin\ResetPasswordController@getReset') }}">重置密码</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ action('Admin\AuthController@getLogout') }}"><i class="fa fa-fw fa-power-off text-danger" aria-hidden="true"></i> 退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div id="base">
        <div id="content">
            @yield('content')
        </div>
        <div id="menubar" class="menubar-inverse">
            <div class="menubar-scroll-panel">
                <ul id="main-menu" class="gui-controls">
                    <li>
                        <a href="{{ action('Admin\AdminController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-folder"></i></div>
                            <span class="title">管理员管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\UsersController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-users"></i></div>
                            <span class="title">玩家管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\XmlManagementController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-navicon"></i></div>
                            <span class="title">版本管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\PushMsgController@getPushMsg') }}">
                            <div class="gui-icon"><i class="fa fa-comment"></i></div>
                            <span class="title">全局推送</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\DiamondController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-diamond"></i></div>
                            <span class="title">钻石管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\ItemsController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-paw"></i></div>
                            <span class="title">道具管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\MonstersController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-bell"></i></div>
                            <span class="title">打怪事件</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\EventsController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-gears"></i></div>
                            <span class="title">事件管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\EquipmentsController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-cubes"></i></div>
                            <span class="title">装备管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\ShopController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
                            <span class="title">商店管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\LevelController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-location-arrow"></i></div>
                            <span class="title">等级管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\JobsController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-flag"></i></div>
                            <span class="title">职业管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\StateController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-cloud"></i></div>
                            <span class="title">境界管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Admin\ExchangeGoldController@getIndex') }}">
                            <div class="gui-icon"><i class="fa fa-filter"></i></div>
                            <span class="title">金币兑换人民币</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@stop
