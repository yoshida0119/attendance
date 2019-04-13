{{--
    @使用方法
        下記をbladeから呼び出し
        @component('components.button',['url' => '','type' => '', 'message' => ''])@endcomponent
--}}

@if ($type == "submit")
    <div class="col-sm-12 m-3 btn-block text-center">
        <button class="btn btn-primary mr-5" type="submit" formaction="{{ url($url) }}">{{$message}}</button>
    </div>
@elseif($type == "get" || $type == "put" || $type == "head" || $type == "patch" || $type == "delete")
    <div class="col-sm-12 m-3 btn-block text-center">
    <button class="btn btn-primary mr-5" type="submit" name="_method" value="{{ $type }}" formaction="{{ url($url) }}">{{$message}}</button>
    </div>
@else
    <div class="col-sm-12 mx-auto m-3">
        <a class="btn-block text-center" href="{{ url($url) }}">
            <button type="button" class="btn btn-primary">{{$message}}</button>
        </a>
    </div>
@endif
