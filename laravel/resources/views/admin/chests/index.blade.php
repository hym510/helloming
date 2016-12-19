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
                            <th>道具id</th>
                            <th>消耗数量</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($chests as $chest)
                        <tr>
                            <td>{{ $chest->id }}</td>
                            <td>{{ $chest->item_id }}</td>
                            <td>{{ $chest->cost }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@include('admin.upload.file-chests')
@stop

