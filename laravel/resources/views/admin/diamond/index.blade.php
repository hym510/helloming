@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="{{ url()->current() }}">列表</a></li>
                    <li><a href="{{ action('Admin\DiamondController@getAdd') }}">添加</a></li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>配图</th>
                            <th>钻石</th>
                            <th>价格</th>
                            <th>数量</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($diamonds as $diamond)
                        <tr>
                            <td>{{ $diamond->id }}</td>
                            <td><img src="{{ $diamond->icon }}" height="50px"></td>
                            <td>{{ $diamond->diamond }}</td>
                            <td>{{ $diamond->price }}</td>
                            <td>{{ $diamond->count }}</td>
                            <td>
                                <a href="{{ action('Admin\DiamondController@getEdit', $diamond->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $diamonds->total() }}">
                    {!! $diamonds->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
