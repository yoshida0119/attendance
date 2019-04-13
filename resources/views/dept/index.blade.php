@extends('layouts.app')
@section('content')
    <h2 class="center">Example heading</h2>
    {!! Form::open() !!}
    <div class="row">
        @csrf
        @if (session('message'))
            <div class="alert alert-success col-sm-12">
                {{ session('message') }}
            </div>
        @endif
        <table class="table table-light">
            <thead class="thead-light">
                <tr class="d-flex">
                    <th class="col-sm-1"></th>
                    <th class="col-sm-1"></th>
                    <th class="col-sm-3">部署名</th>
                    <th class="col-sm-3">作成日</th>
                    <th class="col-sm-3">作成者</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deptArray as $item)

                <tr  class="d-flex align-items-center">
                    <td class="col-sm-1">
                        <a href="{{ url('dept/' . $item->id . '/edit') }}">
                            <button type="button" name="_method" value="get" class="btn btn-primary btn-sm">編集</button>
                        </a>
                    </td>
                    <td class="col-sm-1">
                        <button type="submit" name="_method" value="delete" formaction="{{ url('dept/' . $item->id . '/') }}" class="btn btn-primary btn-sm">削除</button>
                    </td>
                    <td class="col-sm-3">{{ $item->dept_name }}</td>
                    <td class="col-sm-3">{{ $item->created_at }}</td>
                    <td class="col-sm-3">{{ $item->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @component('components.button',['url' => url('dept/create'),'type' => 'get', 'message' => '新規登録'])@endcomponent
    </div>
    {!! Form::close() !!}
@endsection
