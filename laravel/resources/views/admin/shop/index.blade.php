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
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>道具id</th>
                            <th>道具类型</th>
                            <th>道具位置</th>
                            <th>道具价格</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shops as $shop)
                        <tr>
                            <td>{{ $shop->item_id }}</td>
                            <td>{{ $shop->type_name }}</td>
                            <td>{{ $shop->priority }}</td>
                            <td>{{ $shop->price }}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright price" data-id="{{ $shop->id }}">设置价格</a>
                                <a href="javascript:;" class="btn btn-xs btn-default-bright del" data-id="{{ $shop->id }}">删除</a>
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

    $('.price').click(function (){
        var id = $(this).data('id');
        layer.prompt({
            formType: 0,
            value: '',
            title: '请输入价格',
        }, function(value, index, elem){
            if(value < 0 || isNaN(value)){
                layer.alert('请输入数字');
                return false;
            }
            layer.close(index);
            $.get("{{ action('Admin\ShopController@getSetPrice',['id' => '', 'value' => '']) }}/"+ id +"/"+ value, function (data){
                if(data.message == 403){
                    layer.alert('请输入数字');
                    return false;
                } else {
                    layer.alert('设置成功', function(){
                        location.reload();
                    });
                }
            });
        })
    });

</script>
@stop


