@extends('admin.widget.base')

@section('body')
<section class="section-account">
    <div class="spacer">
        <div class="logo"><img src=""></div>
    </div>
    <div class="card contain-sm style-transparent">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <br/>
                    <span class="text-lg text-bold text-primary">find后台</span>
                    <br/><br/>
                    <form class="form" accept-charset="utf-8" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="email">
                            <label for="name">邮箱</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password">
                            <label for="password">密码</label>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <div class="checkbox checkbox-inline checkbox-styled">
                                    <label>
                                        <input type="checkbox" name="remember_token" value="1"> <span>记住我</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button class="btn btn-primary btn-raised" type="submit">登录</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</section>
@stop
