@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="card">
                        <form action="{{ action('Admin\XmlManagementController@postStoreVersion', ['id' => $xmlmsg->id]) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="card-body form">
                                <h3 class="text-center">{{ $xmlmsg->xmlname }}版本更新</h3>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="version">
                                    <label>版本号</label>
                                </div>
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
    </section>
@stop
