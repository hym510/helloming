@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
                    <i class="fa fa-upload"></i>上传
                </button>
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>道具id</th>
                            <th>道具类型</th>
                            <th>道具位置</th>
                            <th>道具价格</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                        <tr>
                            <td>{{ $shop->item_id }}</td>
                            <td>{{ $shop->type }}</td>
                            <td>{{ $shop->quantity }}</td>
                            <td>{{ $shop->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@include('admin.upload.file-shop')
@stop


