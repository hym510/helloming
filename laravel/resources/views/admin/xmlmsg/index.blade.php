@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="input-group">
                        <div class="form-group">
                            <label class="control-label">服务器地址:</label>
                            <p style="display:inline; text-decoration:underline;" class="form-control-static">{{ $xmlurl->urlname or '' }}</p>
                        </div>
                        <span class="input-group-btn" style="width:0;">
                            <a href="javascript:;" class="btn btn-primary btn-md del" data-id="{{ $xmlurl->id or '' }}" type="button">修改</a>
                        </span>
                    </div>
                <table class="table table-striped table-hover table-condensed no-margin">
                    <thead>
                        <tr>
                            <th>文件名</th>
                            <th>版本号</th>
                            <th>版本时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($xmlmsgs as $xmlmsg)
                        <tr>
                            <td>{{ $xmlmsg->xmlname }}</td>
                            <td>{{ $xmlmsg->version }}</td>
                            <td>{{ $xmlmsg->created_at}}</td>
                            <td>
                                <a href="{{ action('Admin\XmlManagementController@getEdit', $xmlmsg->id) }}" class="btn btn-xs btn-default-bright">更新</a>
                                <a href="{{ action('Admin\XmlManagementController@getShow', $xmlmsg->id) }}" class="btn btn-xs btn-default-bright">查看</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $xmlmsgs->total() }}">
                    {!! $xmlmsgs->links() !!}
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script type="text/javascript">
        $('.del').click(function() {
            var id = $(this).data('id');
            layer.prompt({
                title: '修改url',
            }, function(val, index) {
                layer.close(index);
                $.ajax({
                    type: 'POST',
                    url: "{{ action('Admin\XmlManagementController@postModifyUrl', ['id' => '']) }}/" + id,
                    data: {
                        'val': val,
                    },
                });
                location.reload();
            })
        })
    </script>
@stop
