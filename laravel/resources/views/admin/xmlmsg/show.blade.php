@extends('admin.widget.body')

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="card">
                        <div class="card-body form">
                            <h3 class="text-center">{{ $xmlmsg->xmlname }}版本信息</h3>
                            <table class="table table-striped table-hover table-condensed no-margin">
                                <thead>
                                    <tr>
                                        <th>版本号</th>
                                        <th>版本时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($xmldatas as $xmldata)
                                    <tr>
                                        <td>{{ $xmldata['version'] or '' }}</td>
                                        <td>{{ $xmldata['created_at'] or '' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
