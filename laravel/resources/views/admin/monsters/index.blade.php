@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\MonstersController@getAdd')}}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <form class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="怪物名称">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查找</button>
                </form>
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>怪物id</th>
                            <th>怪物名称</th>
                            <th>怪物图片</th>
                            <th>怪物类型</th>
                            <th>怪物等级</th>
                            <th>怪物血量</th>
                            <th>是否限时击杀</th>
                            <th>击杀时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($monsters as $monster)
                        <tr>
                            <td>{{ $monster->id }}</td>
                            <td>{{ $monster->name }}</td>
                            <td><img src="{{ $monster->icon }}" height="50px"></td>
                            <td>{{ $monster->type_name }}</td>
                            <td>{{ $monster->level }}</td>
                            <td>{{ $monster->hp }}</td>
                            <td>{{ $monster->kill_limit ? '是' : '否' }}</td>
                            <td>{{ $monster->kill_limit_time.'秒' }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $monster->id }}">删除</a>
                                <a href="{{ action('Admin\MonstersController@getEdit', $monster->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $monsters->total() }}">
                    {!! $monsters->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('script')
<script type="text/javascript">
    $('.del').click(function() {
        var id = $(this).data('id'),
            msg ='确认删除?';
        layer.msg(msg, {
            time: 0,
            btn: ['确定','取消'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\MonstersController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop

