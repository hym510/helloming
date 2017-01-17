@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="card">
                <form action="{{ action('Admin\VersionController@postStore', ['id' => $version->id]) }}" method="post">
                        {!! csrf_field() !!}
                    <div class="card-body form">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <input type="text" name="app_version" class="form-control" value="{{ $version->app_version or '' }} ">
                                    <label>版本号</label>
                                </div>
                                <div class="card-actionbar">
                                    <div class="text-center">
                                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop
