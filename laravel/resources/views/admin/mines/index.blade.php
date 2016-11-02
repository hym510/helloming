@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\MinesController@getAdd')}}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <form class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="矿物名称">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查找</button>
                </form>
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>矿物id</th>
                            <th>矿物名称</th>
                            <th>矿物图片</th>
                            <th>开矿时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($mines as $mine)
                        <tr>
                            <td>{{ $mine->id }}</td>
                            <td>{{ $mine->name }}</td>
                            <td><img src="{{ $mine->icon }}" height="50px"></td>
                            <td>{{ $mine->time}}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $mine->id }}">删除</a>
                                <a href="{{ action('Admin\MinesController@getEdit', $mine->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $mines->total() }}">
                    {!! $mines->links() !!}
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
                $.get("{{ action('Admin\MinesController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop

