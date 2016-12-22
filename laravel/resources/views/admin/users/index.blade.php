@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="" class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="姓名/手机">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查询</button>
                </form>
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>姓名</th>
                            <th>图像</th>
                            <th>电话</th>
                            <th>经验值</th>
                            <th>会员经验值</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td><img src="{{ $user->avatar }}"></td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->exp }}</td>
                            <td>{{ $user->vip_exp }}</td>
                            <td>
                                <a href="{{ action('Admin\UsersController@getShow', $user->id) }}" class="btn btn-xs btn-default-bright">详情</a>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $user->id }}" data-type="delete">删除</a>
                                @if ($user->activate == 1)
                                <a href="{{ action('Admin\UsersController@getDelete', ['id' => $user->id, 'type' => 'freeze']) }}" class="btn btn-xs btn-default-bright">冻结</a>
                                @else
                                <a href="{{ action('Admin\UsersController@getDelete', ['id' => $user->id, 'type' => 'unfreeze']) }}" class="btn btn-xs btn-default-bright">取消冻结</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $users->total() }}">
                    {!! $users->links() !!}
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
            type = $(this).data('type'),
            msg = '确认删除?';
        layer.msg(msg, {
            time: 0,
            btn: ['确认', '删除'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\UsersController@getDelete', ['id' => '', 'type' => '']) }}/" + id + "/" +type, function() {
                    layer.alert('删除成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop
