@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\ChestsController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">{{ isset($chest) ? '修改' : '添加' }}</a></li>
                </ul>
            </div>
            @if (isset($chest))
                {!! Form::open([ 'method' => 'post', 'action' => ['Admin\ChestsController@postUpdate', $chest->id], 'class' => 'form']) !!}
            @else
                {!! Form::open([ 'method' => 'post', 'action' => 'Admin\ChestsController@postStore', 'class' => 'form']) !!}
            @endif
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="prize" class="form-control" value="{{ $chest->prize or '' }}">
                            <label>奖励道具</label>
                        </div>
                        <div class="form-group">
                            <select name="cost_type" class="form-control" data-val="{{ $chest->cost_type or '' }}">
                                <option value="none">不消耗</option>
                                <option value="gold">消耗金币</option>
                                <option value="diamond">消耗钻石</option>
                            </select>
                            <label>消耗类型</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="cost" class="form-control" value="{{ $chest->cost or ''}}">
                            <label>消耗数量</label>
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
