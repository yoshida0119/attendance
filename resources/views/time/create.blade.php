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
{!! Form::open(['autocomplete'=>'off']) !!}
<div class="card col-sm-3 mx-auto mb-3">
    <div class="row">
        <img class="card-img-top" src="https://placehold.jp/300x350.png" alt="">
        <div class="card-body">
            <h5 class="card-title">スタッフ名</h5>
            {!! Form::select('staff_id', ['' => '選択してください']+array_pluck($staff, 'staff_name', 'id'), old('staff_id'), ['class'=>'form-control']) !!}
        </div>
    </div>
</div>

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
                    {{ date("Y/m/d" , strtotime('+' . $i . ' day')) }}
                    <input type="hidden" name="work_dt[{{$i}}]" value="{{ date("Y/m/d" , strtotime('+' . $i . ' day')) }}">
                </td>
                <td class="col-sm-4"><input type="text" class="timepicker_edit form-control col-sm-5" name="start_time[{{ $i }}]" value="{{ old('start_time.' . $i) }}"></td>
                <td class="col-sm-4"><input type="text" class="timepicker_edit form-control col-sm-5" name="end_time[{{ $i }}]" value="{{ old('end_time.' . $i) }}"></td>
            </tr>
            @endfor
        </tbody>
    </table>
    @component('components.button-multi',['url1'=>'time','url2'=>'time','message'=>'登録'])@endcomponent
{!! Form::close() !!}
@endsection
