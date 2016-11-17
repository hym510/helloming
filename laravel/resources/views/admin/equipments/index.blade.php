@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\EquipmentsController@getAdd')}}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <form class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="装备名称">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查找</button>
                </form>
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>装备名称</th>
                            <th>装备图像</th>
                            <th>装备等级</th>
                            <th>是否最高等级</th>
                            <th>装备力量</th>
                            <th>职业id</th>
                            <th>装备位置</th>
                            <th>装备升级</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($equipments as $equipment)
                        <tr>
                            <td>{{ $equipment->name }}</td>
                            <td><img src="{{ $equipment->icon }}" height="50px"></td>
                            <td>{{ $equipment->level }}</td>
                            <td>{{ $equipment->max_level }}</td>
                            <td>{{ $equipment->power }}</td>
                            <td>{{ $equipment->job_id }}</td>
                            <td>{{ $equipment->position }}</td>
                            <td>{{ $equipment->upgrade }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $equipment->id }}">删除</a>
                                <a href="{{ action('Admin\EquipmentsController@getEdit', $equipment->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $equipments->total() }}">
                    {!! $equipments->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('script')
<script type="text/javascript">
    $('.del').click(function() {
        var id = $(this).data('id');
        var msg ='确认删除?';
        layer.msg(msg, {
            time: 0,
            btn: ['确定','取消'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\EquipmentsController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop

