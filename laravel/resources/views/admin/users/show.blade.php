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
                                {{ $user->id or '' }}
                            </div>
                            <label>编号</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->name or '' }}
                            </div>
                            <label>玩家姓名</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->gender or '' }}
                            </div>
                            <label>玩家性别</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->age or '' }}
                            </div>
                            <label>玩家年龄</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                <img src="{{ $user->avatar or '' }}">
                            </div>
                            <label>玩家图像</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->experience or '' }}
                            </div>
                            <label>经验</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->vip_experience or '' }}
                            </div>
                            <label>会员经验</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->height or '' }}
                            </div>
                            <label>玩家身高</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->weight or '' }}
                            </div>
                            <label>玩家体重</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->online_time or '' }}
                            </div>
                            <label>在线时间</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->job }}
                            </div>
                            <label>玩家职业</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->zodiac or '' }}
                            </div>
                            <label>玩家星座</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                {{ $user->power or '' }}
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
