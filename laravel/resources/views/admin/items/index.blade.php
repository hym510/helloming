@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div style="display:inline-block">
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
                        <i class="fa fa-upload"></i>xml上传
                    </button>
                </div>
                <div style="display:inline-block">
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-item-file-upload">
                        <i class="fa fa-upload"></i>图像上传
                    </button>
                </div>
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>编号</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $items->total() }}">
                    {!! $items->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@include('admin.upload.file-item')
@include('admin.upload.file-item-img')
@stop
