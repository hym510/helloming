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
                            <th>等级</th>
                            <th>力量</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($stateattrs as $state)
                        <tr>
                            <td>{{ $state->id }}</td>
                            <td>{{ $state->level }}</td>
                            <td>{{ $state->power }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $stateattrs->total() }}">
                    {!! $stateattrs->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
