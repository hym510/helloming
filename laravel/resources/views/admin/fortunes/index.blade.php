@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\FortunesController@getAdd')}}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <form class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="宝箱id">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查找</button>
                </form>
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
                    @foreach($fortunes as $fortune)
                        <tr>
                            <td>{{ $fortune->id }}</td>
                            <td>{{ $fortune->prize }}</td>
                            <td>{{ $fortune->cost_type }}</td>
                            <td>{{ $fortune->cost }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $fortune->id }}">删除</a>
                                <a href="{{ action('Admin\FortunesController@getEdit', $fortune->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $fortunes->total() }}">
                    {!! $fortunes->links() !!}
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
                $.get("{{ action('Admin\FortunesController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop

