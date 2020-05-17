@extends('layouts.app')
@section('content')
    {!! Form::open() !!}
    @component('components.errors')@endcomponent
    @csrf
    <div class="form-group">
        <label for="dept_name">部署名</label>
        {!! Form::text('dept_name', '', ['class'=>'form-control','id' => 'dept_name','aria-label'=>'Recipient']) !!}
    </div>
    @component('components.button',['url' => url('dept'),'type' => 'submit', 'message' => '登録'])@endcomponent
    {!! Form::close() !!}
@endsection
