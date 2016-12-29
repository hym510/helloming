@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="card">
                        <form action="{{ action('Admin\ExchangeGoldController@postStore') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="card-body form">
                                <h3 class="text-center">金币兑换人民币比例设置</h3>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="gold">
                                    <label>金币数</label>
                                    <div class="help-block">金币与人民币比例为100:1</div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="money">
                                    <label>人民币数</label>
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
