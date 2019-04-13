@extends('layouts.app')
@section('content')
<table class="table table-bordered">
  <thead>
    <tr>
      @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
      <th>{{ $dayOfWeek }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($dates as $date)
    @if ($date->dayOfWeek == 0)
    <tr>
    @endif
      <td
        @if ($date->month != $currentMonth)
        class="bg-secondary"
        @endif
      >
        {{ $date->day }}
        @php
            $year  = str_pad($date->year, 4, "0", STR_PAD_LEFT);
            $month   = str_pad($date->month, 2, "0", STR_PAD_LEFT);
            $day = str_pad($date->day, 2, "0", STR_PAD_LEFT);
            $targetDay = $year . '-' . $month . '-' . $day;
        @endphp
        @if ($staffs->count() > 0)
            @foreach ($staffs as $item)
                {{-- この日に出勤している人を出力 --}}
                @if ($item->work_dt == $targetDay)
                    <br>
                    <a href="{{ url("time/" . $item->staff_id . '/edit') }}">
                        <small>{{ $item->staff->staff_name }}</small>
                    </a>
                @endif
            @endforeach
        @endif
      </td>
    @if ($date->dayOfWeek == 6)
    </tr>
    @endif
    @endforeach
  </tbody>
</table>
@endsection
