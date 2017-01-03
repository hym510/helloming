@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>事件类型</th>
                            <th>事件等级</th>
                            <th>事件奖励道具</th>
                            <th>事件奖励经验</th>
                            <th>事件开启等级</th>
                            <th>事件文字描述</th>
                            <th>是否限时击杀</th>
                            <th>击杀时间</th>
                            <th>立即完成所需道具</th>
                            <th>立即完成所需道具数量</th>
                            <th>权重</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->type_name }}</td>
                            <td>{{ $event->level or '' }}</td>
                            <td>{{ json_encode($event->prize) }}</td>
                            <td>{{ $event->exp or ''}}</td>
                            <td>{{ $event->unlock_level or '' }}</td>
                            <td>{{ mb_substr($event->info, 0, 8).'......' }}</td>
                            <td>{{ $event->time_limit or '' }}</td>
                            <td>{{ $event->time or '' }}</td>
                            <td>{{ $event->finish_item_id or '' }}</td>
                            <td>{{ $event->item_quantity or '' }}</td>
                            <td>{{ $event->weight }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@stop
