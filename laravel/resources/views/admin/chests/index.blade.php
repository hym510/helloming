@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\ChestsController@getAdd')}}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>宝箱id</th>
                            <th>奖励道具</th>
                            <th>消耗类型</th>
                            <th>消耗数量</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($chests as $chest)
                        <tr>
                            <td>{{ $chest->id }}</td>
                            <td>{{ json_encode($chest->prize) }}</td>
                            <td>{{ $chest->type_name }}</td>
                            <td>{{ $chest->cost }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $chest->id }}">删除</a>
                                <a href="{{ action('Admin\ChestsController@getEdit', $chest->id) }}" class="btn btn-xs btn-default-bright">修改</a>
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
        var id = $(this).data('id'),
            msg ='确认删除?';
        layer.msg(msg, {
            time: 0,
            btn: ['确定','取消'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\ChestsController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop

