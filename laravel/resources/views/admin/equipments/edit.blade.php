@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\EquipmentsController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">{{ isset($equipment) ? '修改' : '添加' }}</a></li>
                </ul>
            </div>
            @if (isset($equipment))
                {!! Form::open([ 'method' => 'post', 'action' => ['Admin\EquipmentsController@postUpdate', $equipment->id], 'class' => 'form'])!!}
            @else
                {!! Form::open([ 'method' => 'post', 'action' => 'Admin\EquipmentsController@postStore', 'class' => 'form'])!!}
            @endif
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="{{ $equipment->name or '' }}">
                            <label>装备名称</label>
                        </div>
                        <div class="form-group">
                            <div class="form-control-static">
                                <img src="{{ $equipment->icon or config('main.placeholders.default_img') }}" class="upload-img" data-name="icon" height="120">
                            </div>
                            <input type="hidden" name="icon" value="{{ $equipment->icon or '' }}" required>
                            <label>封面图</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="level" class="form-control" value="{{ $equipment->level or ''}}">
                            <label>装备等级</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="power" class="form-control" value="{{ $equipment->power or ''}}">
                            <label>装备力量</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="job_id" class="form-control" value="{{ $equipment->job_id or ''}}">
                            <label>职业id</label>
                        </div>
                        <div class="form-group">
                            <select name="type" class="form-control" data-val="{{ $equipment->position or '' }}">
                                <option value="1">位置1</option>
                                <option value="2">位置2</option>
                                <option value="3">位置3</option>
                            </select>
                            <label>装备位置</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="upgrade" class="form-control" value="{{ $equipment->upgrade or ''}}">
                            <label>装备升级</label>
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


