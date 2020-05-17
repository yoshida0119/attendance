@extends('layouts.app')
@section('content')
    {!! Form::open() !!}
    @csrf
    @method('PATCH')
    @component('components.errors')@endcomponent
    <div class="form-group">
        <label for="dept_name">部署名</label>
        {!! Form::text('dept_name', $dept->dept_name, ['class'=>'form-control','id' => 'dept_name','aria-label'=>'Recipient', 'aria-describedby'=>'test']) !!}
    </div>
    @component('components.button-multi',['url1'=>url('dept/' . $dept->id), 'url2'=>url('dept'),'message'=>'更新'])@endcomponent
    {!! Form::close() !!}
@endsection
