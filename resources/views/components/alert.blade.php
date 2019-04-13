{{--
    @使用方法
        下記をbladeから呼び出し
        @component('components.alert',['type_message'=>'エラー'])
          ログイン情報が間違っています。
        @endcomponent
--}}

<div class="alert alert-danger">
    <strong>{{$type_message}}！</strong><br>
</div>


