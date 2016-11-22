@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\LevelController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">{{ isset($level) ? '修改' : '添加' }}</a></li>
                </ul>
            </div>
            @if (isset($level))
                {!! Form::open([ 'method' => 'post', 'action' => ['Admin\LevelController@postUpdate', $level->id], 'class' => 'form']) !!}
            @else
                {!! Form::open([ 'method' => 'post', 'action' => 'Admin\LevelController@postStore', 'class' => 'form']) !!}
            @endif
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="level" class="form-control" value="{{ $level->level or '' }}">
                            <label>等级</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="exp" class="form-control" value="{{ $level->exp or ''}}">
                            <label>经验</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="power" class="form-control" value="{{ $level->power or '' }}">
                            <label>体力</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="action" class="form-control" value="{{ $level->action or '' }}">
                            <label>行动力</label>
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
