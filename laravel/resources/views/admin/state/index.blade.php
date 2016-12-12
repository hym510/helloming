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
                            <th>等级</th>
                            <th>力量</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($states as $state)
                        <tr>
                            <td>{{ $state->id }}</td>
                            <td>{{ $state->level }}</td>
                            <td>{{ $state->power }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $states->total() }}">
                    {!! $states->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@include('admin.upload.file-state')
@stop
