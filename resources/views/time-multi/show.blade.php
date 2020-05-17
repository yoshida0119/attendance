@extends('layouts.app')
@section('content')
@section('addCss')
@endsection
@section('addJs')
@endsection
{!! Form::open(['method' => 'get']) !!}
@csrf
<table class="table table-light">
    <thead class="thead-light">
    <tr>
        {{-- 指定日時から一週間分を表示 --}}
        <th></th>
        @foreach ($weekArray as $weekItem)
            <th>{{ date('m/d', strtotime($weekItem)) }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    {{-- スタッフごとに回す --}}
    {{-- メモ：後でmiddlewareに処理を移動させること middlewareからArrayで処理を渡す--}}
    @foreach (App\Staff::all() as $item)
        <tr>
            <td>{{ $item->staff_name }}</td>
            @foreach ($weekArray as $weekItem)
                @php
                    //スタッフで絞り込み
                    //インスタンスを編集するためコピーを作成
                    $staffInfo = clone $staff;
                    $staffInfo = $staffInfo->where('work_dt','like', "%" . date('Y-m-d', strtotime($weekItem)) . "%")
                                       ->where('staff_id', $item->id)
                                       ->get();
                @endphp
                @if ($staffInfo->count() > 0)
                    <td>
                        @foreach ($staffInfo as $staffItem)
                            開始時間：{{ $staffItem->start_time }}<br>
                            終了時間：{{ $staffItem->end_time }}<br>
                        @endforeach
                    </td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
    @endforeach

    </tbody>
</table>
@component('components.paginate',['pre_url' => 'time-multi/' . date('Y-m-d', strtotime('-7 days', strtotime($targetDay))),
                                  'next_url'=> 'time-multi/' . date('Y-m-d', strtotime('+7 days', strtotime($targetDay))),
                                  'pre_message'=>'前の週',
                                  'next_message'=>'次の週'
                                  ])
@endcomponent
<div>
    @component('components.button-multi',['url1'=> 'time-multi/' . $targetDay . '/edit' , 'url2'=>url('time'),'message'=>'編集'])@endcomponent
</div>
{!! Form::close() !!}
@endsection
