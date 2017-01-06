@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <ul class="nav nav-tabs nav-justified">
                        <li><a href="{{ action('Admin\XmlManagementController@getIndex') }}">列表</a></li>
                        <li class="active"><a href="{{ url()->current() }}">添加</a></li>
                    </ul>
                </div>
                <div class="card-body form">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <form action="{{ action('Admin\XmlManagementController@postStoreFilename') }}" method="post">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <input type="text" class="form-control" name="xmlname">
                                    <label>文件名</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="version">
                                    <label>版本号</label>
                                </div>
                                <div class="card-actionbar">
                                    <div class="text-center">
                                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
