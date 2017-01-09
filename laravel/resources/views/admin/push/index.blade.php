@extends('admin.widget.body')

@section('style_link')
    <link href="assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@stop

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
                                    <div class="input-group date" id="datetimepicker">
                                        <div class="input-group-content">
                                            <input type="text" class="form-control" name="time">
                                            <label>推送时间</label>
                                        </div>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
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

@section('script_link')
    <script src="assets/lib/single_file/moment.min.js"></script>
    <script src="assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
@stop
@section('script')
    <script type="text/javascript">
        $('#datetimepicker').datetimepicker({
            'format': 'YYYY-MM-DD HH:mm:ss',
            'locale': 'zh-CN',
        });
    </script>
@stop

