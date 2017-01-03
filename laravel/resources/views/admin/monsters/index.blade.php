@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>怪物id</th>
                            <th>怪物名称</th>
                            <th>怪物等级</th>
                            <th>怪物血量</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($monsters as $monster)
                        <tr>
                            <td>{{ $monster->id }}</td>
                            <td>{{ $monster->name }}</td>
                            <td>{{ $monster->level }}</td>
                            <td>{{ $monster->hp }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $monsters->total() }}">
                    {!! $monsters->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop

