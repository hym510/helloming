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
                        <ul class="dropdown-menu animation-dock">
                            <li><a href="">重置密码</a></li>
                            <li class="divider"></li>
                            <li><a href=""><i class="fa fa-fw fa-power-off text-danger" aria-hidden="true"></i> 退出</a></li>
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
                            <div class="gui-icon"><i class="fa fa-paw"></i></div>
                            <span class="title">管理员管理</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@stop
