@extends('layouts.app')
@section('content')
@section('addCss')
  <link href="http://code.jquery.com/ui/1.12.1/themes/hot-sneaks/jquery-ui.css" rel="stylesheet" type="text/css">
  <link href="@addtimestamp(/css/jquery.timepicker.min.css)" rel="stylesheet" type="text/css">
@endsection
@section('addJs')
  {{-- @addtimestampでタイムスタンプを生成 appSerciceProvider.phpで設定 --}}
  <script src="@addtimestamp(js/jquery-timepicker/jquery.timepicker.min.js)" type="text/javascript"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" type="text/javascript"></script>
  <script src="@addtimestamp(js/page/date.js)" type="text/javascript"></script>
@endsection
{!! Form::open() !!}
    @csrf
    @method('PUT')
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
            <tr>
                {{-- スタッフごとに回す --}}
                {{-- メモ：後でmiddlewareに処理を移動させること middlewareからArrayで処理を渡す--}}
                {{-- postで送るときの形式はstart_time[スタッフID][weekArrayのindex] --}}
                @foreach (App\Staff::all() as $staffItem)
                    <td>{{ $staffItem->staff_name }}</td>
                    {!! Form::hidden('staff_id[' . $loop->index . ']', $staffItem->id)  !!}
                    @foreach ($weekArray as $weekItem)
                        @php
                            //インスタンスを編集するためコピーを作成
                            $staffInfo = clone $staff;
                            $staffInfo = $staffInfo->where('work_dt','like', "%" . date('Y-m-d', strtotime($weekItem)) . "%")
                                               ->where('staff_id', $staffItem->id)
                                               ->get();
                            $index = $loop->index;
                        @endphp
                        @if ($staffInfo->count() > 0)
                            <td>
                                @foreach ($staffInfo as $staffInfoItem)
                                        開始時間：{!! Form::text('start_time[' . $staffItem->id . '][' . $index . ']', $staffInfoItem->start_time, ['class'=>'timepicker_edit form-control']) !!}<br>
                                        終了時間：{!! Form::text('end_time[' . $staffItem->id . '][' . $index . ']', $staffInfoItem->end_time, ['class'=>'timepicker_edit form-control']) !!}
                                        {!! Form::hidden('work_dt[' . $staffItem->id . '][' . $index . ']', date('Y-m-d', strtotime($weekItem)))  !!}
                                @endforeach
                            </td>
                        @else
                            <td>
                                開始時間：{!! Form::text('start_time[' . $staffItem->id . '][' . $index . ']', '', ['class'=>'timepicker_edit form-control']) !!}<br>
                                終了時間：{!! Form::text('end_time[' . $staffItem->id . '][' . $index . ']', '', ['class'=>'timepicker_edit form-control']) !!}
                                {!! Form::hidden('work_dt[' . $staffItem->id . '][' . $index . ']', date('Y-m-d', strtotime($weekItem)))  !!}
                            </td>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        </tbody>
    </table>
    @component('components.paginate',[
        'pre_url'=>url('time-multi/' . date('Y-m-d', strtotime('-7 days', strtotime($targetDay))) . '/edit'),
        'next_url'=>url('time-multi/' . date('Y-m-d', strtotime('+7 days', strtotime($targetDay))) . '/edit'),
        'pre_message'=>'前の週',
        'next_message'=>'次の週'
        ])@endcomponent
    @if (App\Staff::all()->count() > 0)
        @component('components.button-multi',['url1'=>url('time-multi/' . $targetDay ),'url2'=>url('time'),'message'=>'編集確定'])@endcomponent
    @endif
@endsection
