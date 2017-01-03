@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
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
                    @foreach ($equips as $equipment)
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
                <div class="text-center" data-total="{{ $equips->total() }}">
                    {!! $equips->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop


