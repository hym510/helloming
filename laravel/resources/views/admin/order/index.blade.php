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
                            <th>商品</th>
                            <th>商品图像</th>
                            <th>购买金额</th>
                            <th>购买数量</th>
                            <th>交易id</th>
                            <th>交易时间</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id or '' }}</td>
                            <td>{{ $order->user->name or '' }}</td>
                            <td>{{ $order->product->product_id or '' }}</td>
                            <td><img src="{{ $order->product->icon or '' }}" height="50px"></td>
                            <td>{{ $order->product->price or '' }}</td>
                            <td>{{ $order->product->quantity or '' }}</td>
                            <td>{{ $order->transaction_id or '' }}</td>
                            <td>{{ $order->purchase_date or '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $orders->total() }}">
                    {!! $orders->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
