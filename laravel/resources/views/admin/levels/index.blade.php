@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\LevelController@getAdd') }}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>等级</th>
                            <th>经验</th>
                            <th>力量</th>
                            <th>行动力</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($levels as $level)
                        <tr>
                            <td>{{ $level->level }}</td>
                            <td>{{ $level->exp }}</td>
                            <td>{{ $level->power }}</td>
                            <td>{{ $level->action }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $level->id }}">删除</a>
                                <a href="{{ action('Admin\LevelController@getEdit', $level->id) }}" class="btn btn-xs btn-default-bright">修改</a>
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
        var msg ='确认删除?';
        layer.msg(msg, {
            time: 0,
            btn: ['确定','取消'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\LevelController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop
