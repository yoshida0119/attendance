@extends('layouts.app')
@section('content')
    <h2 class="center">Example heading</h2>
    {!! Form::open(["method" => "get"]) !!}
    @csrf
    @foreach ($todayStaff as $item)
        <div class="row">
            <div class="card mx-auto col-sm-2 m-5">
                <div class="row">
                    <img class="card-img-top" src="https://placehold.jp/150x150.png" alt="">
                    <div class="card-body">
                        <h5 class="card-title">スタッフ名</h5>
                        <p class="card-text">{{ $item->staff->staff_name }}</p>
                        @component('components.button',['url' => url('time/' . $item->staff->id . '/edit'), 'type' => 'button', 'message' => '編集'])@endcomponent
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @component('components.button',['url' => url('time/create'),'type' => 'button', 'message' => '新規登録'])@endcomponent
    @component('components.button',['url' => url('time-multi/' . Carbon\Carbon::now()->toDateString()),'type' => 'button', 'message'=>'一週間分のスケジュール'])@endcomponent
    {!! Form::close() !!}
@endsection
