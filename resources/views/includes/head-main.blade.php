<div class="col-md-12">
@if (Route::has('login'))
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
        <ul class="navbar-nav ml-md-auto">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle btn" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown">Язык</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item btn btn-warning" href="{{route('setlocale', ['lang' => 'kz'])}}"><span class="flag-icon flag-icon-kz"></span> KZ</a> 
                    <a class="dropdown-item btn btn-danger" href="{{route('setlocale', ['lang' => 'ru'])}}"><span class="flag-icon flag-icon-ru"></span> RU</a> 
                </div>
            </li>
        @auth
            <li class="nav-item">
                <a class="btn btn-primary" style="margin-right:5%;" href="#">{{ \Auth::user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-danger"  style="margin-left:5%;" href="{{ route('logout') }}" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">@lang('messages.logout')
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                    </form>
            </li>
        @else
            <li class="nav-item">
                <a class="btn btn-primary" href="{{ url(App\Http\Middleware\LocaleMiddleware::getLocale() .'/'.'login') }}">@lang('messages.login')</a>
            </li>
        @endauth 
        </ul>
    </div>
</nav>
@endif