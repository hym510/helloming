@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="card">
                        <form action="{{ action('Admin\PushMsgController@postPushMsg') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="card-body form">
                                <h3 class="text-center">发布全局推送</h3>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="time" placeholder="格式为 YYYY-MM-DDTHH:MM:SS.MMMZ 的 UTC 时间">
                                    <label>推送时间</label>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" rows="5" class="form-control"></textarea>
                                    <label>内容</label>
                                </div>
                            </div>
                            <div class="card-actionbar">
                                <div class="text-center">
                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary">推送</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

