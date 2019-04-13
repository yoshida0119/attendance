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
@csrf
<div class="card col-sm-3 mx-auto mb-3">
    <div class="row">
        <img class="card-img-top" src="https://placehold.jp/300x350.png" alt="">
        <div class="card-body">
            <h5 class="card-title">スタッフ名</h5>
            <p>{!! $staff->staff_name !!}</p>
        </div>
    </div>
</div>
@component('components.errors',['errors'=>$errors])
@endcomponent
{!! Form::open(['autocomplete'=>'off']) !!}
    @method('PUT')
    {!! Form::hidden('staff_id', $staff->id)  !!}
    <table class="table table-light">
        <thead class="thead-light">
            <tr class="d-flex">
                <th class="col-sm-4">日</th>
                <th class="col-sm-4">開始時間</th>
                <th class="col-sm-4">終了時間</th>
            </tr>
        </thead>
        <tbody>
            {{-- 一週間分表示 --}}
            @for ($i = 0; $i <= 6; $i++)
            <tr class="d-flex">
                <td class="col-sm-4">
                    {{ $time[$i]['work_dt'] }}
                    <input type="hidden" name="work_dt[{{$i}}]" value="{{ $time[$i]['work_dt'] }}">
                </td>
                <td class="col-sm-4">
                    {!! Form::text('start_time[' . $i . ']', $time[$i]['start_time'] , ['class'=>'timepicker_edit form-control col-sm-5']) !!}
                </td>
                <td class="col-sm-4">
                    {!! Form::text('end_time[' . $i . ']', $time[$i]['end_time'] , ['class'=>'timepicker_edit form-control col-sm-5']) !!}
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
    @component('components.button-multi',['url1'=>'time/' . $staff->id,'url2'=>'time','message'=>'更新'])@endcomponent
{!! Form::close() !!}
@endsection
