@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <ul class="nav nav-tabs nav-justified">
                        <li><a href="{{ action('Admin\EventsController@getIndex') }}">列表</a></li>
                        <li class="active"><a href="{{ url()->current() }}">{{ isset($event) ? '修改' : '添加' }}</a></li>
                    </ul>
                </div>
                @if (isset($event))
                    {!! Form::open([ 'method' => 'post', 'action' => ['Admin\EventsController@postUpdate', $event->id], 'class' => 'form'])!!}
                @else
                    {!! Form::open([ 'method' => 'post', 'action' => 'Admin\EventsController@postStore', 'class' => 'form'])!!}
                @endif
                <div class="card-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="type" class="form-control" value="{{ $event->type_Name or '' }}">
                                    <option value="monster">打怪事件</option>
                                    <option value="mine">挖矿事件</option>
                                    <option value="fortune">宝箱事件</option>
                                </select>
                                <label>事件类型</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="level" class="form-control" value="{{ $event->level or '' }}">
                                <label>事件等级</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="monster_id" class="form-control" value="{{ $event->monster_id or '' }}">
                                <label>读取怪物</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="mine_id" class="form-control" value="{{ $event->mine_id or '' }}">
                                <label>读取挖矿</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="fortune_id" class="form-control" value="{{ $event->fortune_id or '' }}">
                                <label>宝箱事件</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="prize" class="form-control" value="{{ $event->prize or '' }}">
                                <label>奖励道具</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="exp" class="form-control" value="{{ $event->exp or '' }}">
                                <label>奖励经验</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="unlock_level" class="form-control" value="{{ $event->unlock_level or '' }}">
                                <label>开启事件等级</label>
                            </div>
                            <div class="form-group">
                                 <textarea name="info" class="form-control" rows="2">{{ $event->info or '' }}</textarea>
                                <label>事件描述</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <button type="submit" class="btn ink-reaction btn-raised btn-primary">提交</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
<script type="text/javascript">
    $(function() {
        var dMonster = $('input[name="monster_id"]').parent();
        var dMine = $('input[name="mine_id"]').parent();
        var dFortune = $('input[name="fortune_id"]').parent();
        $('select[name="type"]').on('change', function() {
            switch ($(this).val()) {
                case 'monster':
                    dMonster.css('display', 'block');
                    dMine.css('display', 'none');
                    dFortune.css('display', 'none');
                    break;
                case 'mine':
                    dMine.css('display', 'block');
                    dMonster.css('display', 'none');
                    dFortune.css('display', 'none');
                    break;
                case 'fortune':
                    dFortune.css('display', 'block');
                    dMine.css('display', 'none');
                    dMonster.css('display', 'none');
                    break;
            }
        }).triggerHandler('change');
    });
</script>
@stop
