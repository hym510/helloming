@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\ShopController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current()}}">{{ isset($shop) ? '修改': '添加' }}</a></li>
                </ul>
            </div>
            @if (isset($shop))
                {!! Form::open([ 'method' => 'post', 'action' => ['Admin\ShopController@postUpdate', $shop->id], 'class' => 'form']) !!}
            @else
                {!! Form::open([ 'method' => 'post', 'action' => 'Admin\ShopController@postStore', 'class' => 'form']) !!}
            @endif
            <div class="card-body form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="item_id" class="form-control" value="{{ $shop->item_id or '' }}">
                            <label>道具id</label>
                        </div>
                        <div class="form-group">
                            <select name="type" class="form-control" value="{{ $shop->type or '' }}">
                                <option value="tool">工具</option>
                                <option value="building">建筑</option>
                                <option value="nei_dan">内丹</option>
                            </select>
                            <label>道具类型</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="priority" class="form-control" value="{{ $shop->priority or '' }}">
                            <label>道具位置</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="price" class="form-control" value="{{ $shop->price or '' }}">
                            <label>道具价格</label>
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
