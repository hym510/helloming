@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\MonstersController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">{{ isset($monster) ? '修改' : '添加' }}</a></li>
                </ul>
            </div>
            @if (isset($monster))
                {!! Form::open([ 'method' => 'post', 'action' => ['Admin\MonstersController@postUpdate', $monster->id], 'class' => 'form'])!!}
            @else
                {!! Form::open([ 'method' => 'post', 'action' => 'Admin\MonstersController@postStore', 'class' => 'form'])!!}
            @endif
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-control-static">
                                <img src="" class="upload-img" data-name="icon" height="120">
                            </div>
                                <input type="hidden" name="icon" value="{{ $monster->icon or '' }}" required>
                                <label>封面图</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="{{ $monster->name or '' }}">
                            <label>怪物名称</label>
                        </div>
                        <div class="form-group">
                            <select name="type" class="form-control" data-val="{{ $monster->type or '' }}">
                                <option value="empty">类型为空</option>
                                <option value="normal">普通类型</option>
                                <option value="boss">boss类型</option>
                            </select>
                            <label>怪物类型</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="level" class="form-control" value="{{ $monster->level or '' }}">
                            <label>怪物等级</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="hp" class="form-control" value="{{ $monster->hp or '' }}">
                            <label>怪物血量</label>
                        </div>
                        <div class="form-group">
                            <select name="kill_limit" class="form-control" data-val="{{ $monster->kill_limit or ''}}">
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                            <label>是否限时击杀</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="kill_limit_time" class="form-control" value="{{ $monster->kill_limit_time or ''}}" placeholder='秒'>
                            <label>限时击杀时间</label>
                        </div>
                    </div>
                </div>
                <div class="card-actionbar">
                    <div class="card-actionbar-row">
                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop