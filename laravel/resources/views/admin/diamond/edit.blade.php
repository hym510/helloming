@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <ul class="nav nav-tabs nav-justified">
                        <li><a href="{{ action('Admin\DiamondController@getIndex') }}">列表</a></li>
                        <li class="active"><a href="{{ url()->current() }}">{{ isset($diamond) ? '修改' : '添加' }}</a></li>
                    </ul>
                </div>
                @if (isset($diamond))
                    {!! Form::open([ 'method' => 'post', 'action' => ['Admin\DiamondController@postUpdate', $diamond->id], 'class' => 'form']) !!}
                @else
                    {!! Form::open([ 'method' => 'post', 'action' => 'Admin\DiamondController@postStore', 'class' => 'form']) !!}
                @endif
                <div class="card-body form">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_id" value="{{ $diamond->product_id or '' }}">
                                <label>钻石</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="price" value="{{ $diamond->price or '' }}">
                                <label>价格</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="quantity" value="{{ $diamond->quantity or '' }}">
                                <label>数量</label>
                            </div>
                            <div class="form-group">
                                <div class="form-control-static">
                                    <img src="{{ $diamond->icon or config('main.placeholders.default_img') }}" class="upload-img" data-name="icon" height="120">
                                </div>
                                <input type="hidden" name="icon" value="{{ $diamond->icon or '' }}" required>
                                <label>封面图</label>
                            </div>
                            <div class="card-actionbar">
                                <div class="text-center">
                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script_link')
    <script src="assets/lib/plupload/plupload.full.min.js"></script>
@stop

@section('script')
<script type="text/javascript">
    Helper.plupload(function () {
            $('.upload-img').each(function () {
                var o = $(this);
                o.plupload({
                    success: function (json) {
                        o.attr('src', json.url);
                        $('[name="' + o.data('name') + '"]').val(json.url);
                    }
                });
            });
        });
</script>
@stop
