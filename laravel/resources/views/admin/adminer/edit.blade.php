@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <ul class="nav nav-tabs nav-justified">
                        <li><a href="{{ action('Admin\AdminController@getIndex') }}">列表</a></li>
                        <li class="active"><a href="{{ url()->current() }}">{{ isset($admin) ? '修改' : '添加' }}</a></li>
                    </ul>
                </div>
                @if (isset($admin))
                    {!! Form::open([ 'method' => 'post', 'action' => ['Admin\AdminController@postUpdate', $admin->id], 'class' => 'form']) !!}
                @else
                    {!! Form::open([ 'method' => 'post', 'action' => 'Admin\AdminController@postStore', 'class' => 'form']) !!}
                @endif
                <div class="card-body form">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" value="{{ $admin->email or '' }} ">
                                <label>邮箱</label>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control">
                                <label>密码</label>
                                @if (isset($admin))
                                <div class="help-block">不填写不修改密码</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control">
                                <label>确认密码</label>
                            </div>
                            <div class="card-actionbar">
                                <div class="text-center">
                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
