<div class="col-md-12">
@if (Route::has('login'))
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="btn btn-primary" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/general')}}">@lang('messages.general_info')</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-secondary" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/roles')}}">@lang('messages.roles')</a>
            </li>

            @if(App\Models\Setting::where('kindergarten_id',4)->pluck('is_group_module')->first() === 0)
                <li class="nav-item">
                    <a class="btn btn-success" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/groups')}}">@lang('messages.groups')</a>
                </li>
            @endif
            
            @if(App\Models\Setting::where('kindergarten_id',4)->pluck('is_user_module')->first() === 0)
                <li class="nav-item">
                    <a class="btn btn-warning" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/childrens')}}">@lang('messages.users')</a>
                </li>
            @endif

            @if(App\Models\Setting::where('kindergarten_id',4)->pluck('is_pp_module')->first() === 0)
                <li class="nav-item">
                    <a class="btn btn-info" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/pp')}}">@lang('messages.contractors_and_foods')</a>
                </li>
            @endif
            
            <li class="nav-item">
                <a class="btn btn-danger" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/settings')}}">@lang('messages.settings')</a>
            </li>
        </ul>
        
        <ul class="navbar-nav ml-md-auto">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle btn" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown">@lang('messages.language')</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item btn btn-warning" href="{{route('setlocale', ['lang' => 'kz'])}}"><span class="flag-icon flag-icon-kz"></span> Қазақ</a> 
                    <a class="dropdown-item btn btn-danger" href="{{route('setlocale', ['lang' => 'ru'])}}"><span class="flag-icon flag-icon-ru"></span> Русский</a> 
                </div>
            </li>
        @auth
            <li class="nav-item">
                <a class="btn btn-primary" href="#">{{ \Auth::user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-danger" href="{{ url('logout') }}" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">@lang('messages.logout')
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="navbar-nav"></ul>
    </div>
</nav>
@endif
</div>