@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\AdminController@getAdd') }}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>邮箱</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $admin->id }}">删除</a>
                                <a href="{{ action('Admin\AdminController@getEdit', $admin->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $admins->total() }}">
                    {!! $admins->links() !!}
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
                $.get("{{ action('Admin\AdminController@getDelete', ['id' => '']) }}/" + id, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop
