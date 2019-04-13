{{--
    @使用方法
        下記をbladeから呼び出し
        @component('components.errors',['type_message'=>'エラー'])
          ログイン情報が間違っています。
        @endcomponent
--}}

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
