@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\ItemsController@getAdd')}}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <form class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="道具名称">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查找</button>
                </form>
                <form class="form-inline" enctype="multipart/form-data" method="post" action="{{ action('Admin\ItemsController@postImportExcel') }}">
                {!! csrf_field() !!}
                    <input type="file" name="excel">
                    <button type="submit" class="btn btn-default-bright">提交</button>
                </form>
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>道具名称</th>
                            <th>道具图标</th>
                            <th>道具品质</th>
                            <th>道具描述</th>
                            <th>道具类型</th>
                            <th>道具排序</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td><img src="{{ $item->icon }}" height="50px"></td>
                            <td>{{ $item->quality_Name }}</td>
                            <td>{{ $item->info }}</td>
                            <td>{{ $item->type_name }}</td>
                            <td>{{ $item->priority }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $item->id }}">删除</a>
                                <a href="{{ action('Admin\ItemsController@getEdit', $item->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $items->total() }}">
                    {!! $items->links() !!}
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
                $.get("{{ action('Admin\ItemsController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop
