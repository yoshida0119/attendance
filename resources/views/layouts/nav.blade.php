@section('nav')
{{-- ############################################################################################ --}}
<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="#">勤怠管理システム</a>

    {{-- ログイン時の表示 --}}
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('登録') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('time') }}">スケジュール管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('dept')}}">部署管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('staff')}}">スタッフ管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endguest
        </ul>
    </div>
</nav>
{{-- ############################################################################################ --}}
@endsection
