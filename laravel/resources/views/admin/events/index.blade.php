@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
                            <i class="fa fa-upload"></i>上传
                </button>
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
                            <td>{{ $event->weight }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@include('admin.upload.file-event')
@stop
