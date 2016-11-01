@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\ItemsController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">{{ $item->id ? '修改' : '添加' }}</a></li>
                </ul>
            </div>
            @if ($item->id)
                {!! Form::open([ 'method' => 'post', 'action' => ['Admin\ItemsController@postUpdate', $item->id], 'class' => 'form'])!!}
            @else
                {!! Form::open([ 'method' => 'post', 'action' => 'Admin\ItemsController@postStore', 'class' => 'form'])!!}
            @endif
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-control-static">
                                <img src="{{ $item->icon ?: config('main.placeholders.default_img') }}" class="upload-img" data-name="icon" height="120">
                            </div>
                                <input type="hidden" name="icon" value="{{ $item->icon or '' }}" required>
                                <label>封面图</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="{{ $item->name }}">
                            <label>道具名称</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="info" class="form-control" value="{{ $item->info }}">
                            <label>道具描述</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="type" class="form-control" value="{{ $item->type }}">
                            <label>道具类型</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="priority" class="form-control" value="{{ $item->priority }}">
                            <label>道具排序</label>
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
