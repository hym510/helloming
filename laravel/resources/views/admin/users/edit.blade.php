@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\UsersController@getIndex')}}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">添加</a></li>
                </ul>
            </div>
            <form class="card form" action="{{ action('Admin\UsersController@postStore')}}" accept-charset="utf-8" method="post">
                    {!! csrf_field() !!}
                <div class="card-body form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-control-static">
                                    <img src="{{ $user->icon or config('main.placeholders.default_img') }}" class="upload-img" data-name="icon" height="120px">
                                </div>
                                <input type="file" name="icon" value="{{ $user->icon or '' }}">
                                <label>图像</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" value="{{ $user->name or '' }}">
                                <label>姓名</label>
                            </div>
                            <div class="form-group">
                                <select name="gender" class="form-control" data-val="{{ $user->gender or '' }}">
                                    <option>填写性别</option>
                                    <option value="female">女</option>
                                    <option value="male">男</option>
                                </select>
                                <label>性别</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone or '' }}">
                                <label>手机</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="age" class="form-control" value="{{ $user->age or '' }}">
                                <label>年龄</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="height" class="form-control" value="{{ $user->height or '' }}">
                                <label>身高</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="weight" class="form-control" value="{{ $user->weight or '' }}">
                                <label>体重</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="job_id" class="form-control" value="{{ $user->job_id or '' }}">
                                <label>职业</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="online_time" class="form-control" value="{{ $user->online_time or '' }}">
                                <label>在线时间</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select multiple name="zodiac" class="form-control" data-val="{{ $user->zodiac or '' }}">
                                    <option value="aries">白羊座</option>
                                    <option value="taurus">金牛座</option>
                                    <option value="gemini">双子座</option>
                                    <option value="cancer">巨蟹座</option>
                                    <option value="leo">狮子座</option>
                                    <option value="virgo">处女座</option>
                                    <option value="libra">天秤座</option>
                                    <option value="scorpio">天蝎座</option>
                                    <option value="sagittarius">射手座</option>
                                    <option value="capricorn">摩羯座</option>
                                    <option value="aquarius">水瓶座</option>
                                    <option value="pisces">双鱼座</option>
                                </select>
                                <label>星座</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@stop
