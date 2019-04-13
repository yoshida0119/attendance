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
                    <th class="col-sm-3">スタッフ名</th>
                    <th class="col-sm-3">作成日</th>
                    <th class="col-sm-3">作成者</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staff as $item)

                <tr  class="d-flex align-items-center">
                    <td class="col-sm-1">
                        <a href="{{ url('staff/' . $item->id . '/edit') }}">
                            <button type="button" name="_method" value="get" class="btn btn-primary btn-sm">編集</button>
                        </a>
                    </td>
                    <td class="col-sm-1">
                        <button type="submit" name="_method" value="delete" formaction="{{ url('staff/' . $item->id . '/') }}" class="btn btn-primary btn-sm">削除</button>
                    </td>
                    <td class="col-sm-3">{{ $item->staff_name }}</td>
                    <td class="col-sm-3">{{ $item->created_at }}</td>
                    <td class="col-sm-3">{{ $item->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @component('components.button',['url' => url('staff/create'),'type' => 'get', 'message' => '新規登録'])@endcomponent
    {!! Form::close() !!}
@endsection
