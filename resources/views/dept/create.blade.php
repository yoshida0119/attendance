@extends('layouts.app')
@section('content')
{!! Form::open() !!}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @csrf
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="test">部署名</span>
        </div>
        {!! Form::text('dept_name', '', ['class'=>'form-control','id' => 'dept_name','aria-label'=>'Recipient', 'aria-describedby'=>'test']) !!}
    </div>
    @component('components.button',['url' => url('dept'),'type' => 'submit', 'message' => '登録'])@endcomponent
{!! Form::close() !!}
@endsection
