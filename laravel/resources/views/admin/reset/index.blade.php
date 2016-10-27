@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <form class="card form" action="{{ action('Admin\ResetPasswordController@putReset') }}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="put">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                <label>邮箱</label>
                                <div class="help-block">登录帐号</div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password">
                                <label>密码</label>
                                <div class="help-block">不填写不修改密码</div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation">
                                <label>确认密码</label>
                                <div class="help-block">再次输入密码防止输错</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-actionbar">
                    <div class="card-actionbar-row">
                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@stop
