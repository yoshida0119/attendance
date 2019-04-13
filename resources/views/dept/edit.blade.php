@extends('layouts.app')
@section('content')
{!! Form::open() !!}
    @csrf
    @method('PATCH')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="input-group m-5">
        <div class="input-group-prepend">
            <span class="input-group-text" id="test">部署名</span>
        </div>
        {!! Form::text('dept_name', $dept->dept_name, ['class'=>'form-control','id' => 'dept_name','aria-label'=>'Recipient', 'aria-describedby'=>'test']) !!}
    </div>
    @component('components.button-multi',['url1'=>url('dept/' . $dept->id), 'url2'=>url('dept'),'message'=>'更新'])@endcomponent
{!! Form::close() !!}
@endsection
