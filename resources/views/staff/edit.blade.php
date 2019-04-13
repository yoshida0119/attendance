@extends('layouts.app')
@section('content')
{!! Form::open() !!}
    @csrf
    @method('PUT')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">スタッフ名</span>
        </div>
        {!! Form::text('staff_name', $staff->staff_name, ['class'=>'form-control','id' => 'staff_name']) !!}
    </div>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">部署名</span>
        </div>
        {!! Form::select('dept_id', ['' => '選択してください']+array_pluck($dept, 'dept_name', 'id'), $staff->dept_id, ['class'=>'form-control']) !!}
    </div>
    @component('components.button',['url' => url('staff/' . $staff->id),'type' => 'submit', 'message' => '更新'])@endcomponent
{!! Form::close() !!}
@endsection
