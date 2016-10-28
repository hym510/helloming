@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->id }}
                            </div>
                            <label>编号</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->name }}
                            </div>
                            <label>玩家姓名</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->gender }}
                            </div>
                            <label>玩家性别</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->age }}
                            </div>
                            <label>玩家年龄</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                <img src="{{ $user->avatar }}">
                            </div>
                            <label>玩家图像</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->experience }}
                            </div>
                            <label>经验</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->vip_experience }}
                            </div>
                            <label>会员经验</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->height.'cm' }}
                            </div>
                            <label>玩家身高</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->weight }}
                            </div>
                            <label>玩家体重</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->online_time }}
                            </div>
                            <label>在线时间</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->job->title }}
                            </div>
                            <label>玩家职业</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->zodiac }}
                            </div>
                            <label>玩家星座</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->power }}
                            </div>
                            <label>玩家人气</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
