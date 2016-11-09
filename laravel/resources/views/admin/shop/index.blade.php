@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\ShopController@getAdd') }}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <form class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查找</button>
                </form>
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>道具id</th>
                            <th>道具类型</th>
                            <th>道具位置</th>
                            <th>道具位置</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shops as $shop)
                        <tr>
                            <td>{{ $shop->item_id }}</td>
                            <td>{{ $shop->type }}</td>
                            <td>{{ $shop->priority }}</td>
                            <td>{{ $shop->price }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $shop->id }}">删除</a>
                                <a href="{{ action('Admin\ShopController@getEdit', $shop->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $shops->total() }}">
                {!! $shops->links() !!}
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
        var msg = '确认删除?';
        layer.msg(msg, {
            time: 0,
            btn: ['确认', '取消'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\ShopController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop


