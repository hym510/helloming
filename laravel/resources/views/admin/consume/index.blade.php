@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="" class="form-inline" method="get">
                    <div class="form-group">
                        <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="姓名">
                        <label>搜索</label>
                    </div>
                    <button type="submit" class="btn btn-default-bright">查询</button>
                </form>
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>姓名</th>
                            <th>消耗事件</th>
                            <th>消耗钻石数量</th>
                            <th>消耗时间</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($consumes as $consume)
                        <tr>
                            <td>{{ $consume->id }}</td>
                            <td>{{ $consume->user->name }}</td>
                            <td>{{ $consume->content }}</td>
                            <td>{{ $consume->quantity }}</td>
                            <td>{{ $consume->consume_date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $consumes->total() }}">
                    {!! $consumes->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
