@extends('layouts.app')
@section('content')
    {!! Form::open() !!}
    @csrf
    @component('components.errors')@endcomponent
    <div class="form-group">
        <label for="staff_name">スタッフ名</label>
        {!! Form::text('staff_name', '', ['class'=>'form-control','id' => 'staff_name']) !!}
    </div>
    <div class="form-group">
        <label for="dept_id">部署名</label>
        {!! Form::select('dept_id', ['' => '選択してください']+array_pluck($dept, 'dept_name', 'id'), old('dept_id'), ['class'=>'form-control']) !!}
    </div>

    @component('components.button',['url' => url('staff'),'type' => 'submit', 'message' => '登録'])@endcomponent
    {!! Form::close() !!}
@endsection
