@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\EventsController@getAdd') }}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>事件类型</th>
                            <th>读取怪物</th>
                            <th>读取矿物</th>
                            <th>读取宝箱</th>
                            <th>事件奖励道具</th>
                            <th>事件奖励经验</th>
                            <th>事件开启等级</th>
                            <th>事件文字描述</th>
                            <th>权重</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->type_name }}</td>
                            <td>{{ $event->monster_id or '' }}</td>
                            <td>{{ $event->mine_id or '' }}</td>
                            <td>{{ $event->fortune_id or '' }}</td>
                            <td>{{ json_encode($event->prize) }}</td>
                            <td>{{ $event->exp or ''}}</td>
                            <td>{{ $event->unlock_level or '' }}</td>
                            <td>{{ mb_substr($event->info, 0, 8).'......'}}</td>
                            <td>{{ $event->weight }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $event->id }}">删除</a>
                                <a href="{{ action('Admin\EventsController@getEdit', $event->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@stop

@section('script')
<script type="text/javascript">
$('.del').click(function() {
        var id = $(this).data('id');
        var msg = '确认删除?';
        layer.msg(msg, {
            time: 0,
            btn: ['确认', '取消'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\EventsController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop
