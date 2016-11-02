@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\MinesController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">{{ isset($mine) ? '修改' : '添加' }}</a></li>
                </ul>
            </div>
            @if (isset($mine))
                {!! Form::open([ 'method' => 'post', 'action' => ['Admin\MinesController@postUpdate', $mine->id], 'class' => 'form'])!!}
            @else
                {!! Form::open([ 'method' => 'post', 'action' => 'Admin\MinesController@postStore', 'class' => 'form'])!!}
            @endif
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-control-static">
                                <img src="" class="upload-img" data-name="icon" height="120">
                            </div>
                                <input type="hidden" name="icon" value="{{ $mine->icon or '' }}" required>
                                <label>封面图</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="{{ $mine->name or '' }}">
                            <label>矿物名称</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="time" class="form-control" value="{{ $mine->time or ''}}">
                            <label>开矿时间</label>
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
