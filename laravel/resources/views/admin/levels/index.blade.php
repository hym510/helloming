@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>等级</th>
                            <th>经验</th>
                            <th>体力</th>
                            <th>行动力</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($levels as $level)
                        <tr>
                            <td>{{ $level->level }}</td>
                            <td>{{ $level->exp }}</td>
                            <td>{{ $level->power }}</td>
                            <td>{{ $level->action }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@stop

