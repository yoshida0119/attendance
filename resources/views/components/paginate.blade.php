{{--
    @使用方法
        下記をbladeから呼び出し
        @component('components.paginate',['pre_url'=>'', 'next_url'=>'', 'pre_message'=>'', 'next_message'=>''])@endcomponent
--}}

<nav class="float-right" aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item" aria-current="page">
            <a class="page-link" href="{{ url($pre_url) }}">{{ $pre_message }}</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ url( $next_url ) }}">{{$next_message}}</a>
        </li>
    </ul>
</nav>
