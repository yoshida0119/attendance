{{--
    @使用方法
        下記をbladeから呼び出し
        @component('components.button-multi',['url1'=>'','url2'=>'','message'=>''])@endcomponent
--}}
<div class="col-sm-3 mx-auto">
    <button class="btn btn-primary mr-5" type="submit" formaction="{{ url($url1) }}">{{$message}}</button>
    <a href="{{ url($url2) }}">
        <button type="button" class="btn btn-primary">戻る</button>
    </a>
</div>
