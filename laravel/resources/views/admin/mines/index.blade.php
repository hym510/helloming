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
                            <th>矿物id</th>
                            <th>矿物名称</th>
                            <th>消耗钻石</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($mines as $mine)
                        <tr>
                            <td>{{ $mine->id }}</td>
                            <td>{{ $mine->name }}</td>
                            <td>{{ $mine->consume_diamond }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $mines->total() }}">
                    {!! $mines->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@include('admin.upload.file-mines')
@stop


