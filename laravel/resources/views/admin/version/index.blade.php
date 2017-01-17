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
                            <th>版本号</th>
                            <th>版本进程</th>
                            <th>版本时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($versions as $version)
                        <tr>
                            <td>{{ $version->id }}</td>
                            <td>{{ $version->app_version }}</td>
                            <td>{{ $version->mark_type }}</td>
                            <td>{{ $version->created_at }}</td>
                            <td>
                                <a href="{{ action('Admin\VersionController@getEdit', $version->id) }}" class="btn btn-xs btn-default-bright">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $versions->total() }}">
                    {!! $versions->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
