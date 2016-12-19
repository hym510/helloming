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
                            <th>装备id</th>
                            <th>装备名称</th>
                            <th>装备等级</th>
                            <th>是否最高等级</th>
                            <th>装备力量</th>
                            <th>职业id</th>
                            <th>装备位置</th>
                            <th>装备升级</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($equipments as $equipment)
                        <tr>
                            <td>{{ $equipment->id }}</td>
                            <td>{{ $equipment->name }}</td>
                            <td>{{ $equipment->level }}</td>
                            <td>{{ $equipment->max_level }}</td>
                            <td>{{ $equipment->power }}</td>
                            <td>{{ $equipment->job_id }}</td>
                            <td>{{ $equipment->position }}</td>
                            <td>{{ json_encode($equipment->upgrade) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $equipments->total() }}">
                    {!! $equipments->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@include('admin.upload.file-equipments')
@stop


