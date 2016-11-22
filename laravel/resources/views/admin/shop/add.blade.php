@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="{{ action('Admin\ShopController@getIndex') }}">列表</a></li>
                    <li class="active"><a href="{{ url()->current() }}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>道具类型</th>
                            <th>道具排序</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->type_name }}</td>
                            <td>{{ $item->priority }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $item->id }}">添加</a>
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
            msg = '确认添加?';
        layer.msg(msg, {
            time: 0,
            btn: ['确认', '取消'],
            yes: function(index) {
                layer.close(index);
                $.post("{{ action('Admin\ShopController@postStore', ['id' => ''] ) }}/" + id, function() {
                    layer.alert('添加成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop
