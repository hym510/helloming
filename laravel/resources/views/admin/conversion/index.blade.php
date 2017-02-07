@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="card">
                        <form action="{{ action('Admin\ConversionController@postUpdate', [$conversion->id]) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="card-body form">
                                <h3 class="text-center">提现管理</h3>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" name="exchange" value="1">隐藏提现
                                    </label>
                                </div>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" name="exchange" value="0">取消隐藏
                                    </label>
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
