@extends('admin.widget.body')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-condensed table-striped no-margin">
                    <thead>
                        <tr>
                            <th>编号</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($xmlitems as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center" data-total="{{ $xmlitems->total() }}">
                    {!! $xmlitems->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
