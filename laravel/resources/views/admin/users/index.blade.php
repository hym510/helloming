@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\UsersController@getAdd') }}">添加</a></li>
                </ul>
            </div>
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
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td><img src="{{ $user->avatar }}"></td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->experience }}</td>
                            <td>{{ $user->vip_experience }}</td>
                            <td>
                                <a href="{{ action('Admin\UsersController@getShow', $user->id) }}" class="btn btn-xs btn-default-bright">详情</a>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $user->id }}" data-type="forcedelete">删除</a>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright forcedel" data-id="{{ $user->id }}" data-type="delete">冻结</a>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
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
        var type = $(this).data('type');
        var msg = '确认删除?';
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

    $('.forcedel').click(function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var msg = '确认屏蔽?';
        layer.msg(msg, {
            time: 0,
            btn: ['确认', '删除'],
            yes: function(index) {
                layer.close(index);
                $.get("{{ action('Admin\UsersController@getDelete', ['id' => '', 'type' => '']) }}/" + id + "/" +type, function() {
                    layer.alert('屏蔽成功', function() {
                        location.reload();
                    })
                });
            }
        })
    });
</script>
@stop
