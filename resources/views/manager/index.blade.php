@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Native navbar START -->
@if (Route::has('login'))
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          
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
                <a class="btn btn-primary" style="margin-right:5%;" href="#">{{ \Auth::user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-danger"  style="margin-left:5%;" href="{{ url('logout') }}" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">@lang('messages.logout')
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                    </form>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ url(App\Http\Middleware\LocaleMiddleware::getLocale() .'/'.'login') }}">@lang('messages.login')</a>
            </li>
        @endauth 
        </ul>
    </div>
</nav>
@endif
@if (\Session::has('message'))
    <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
    </div><br />
@endif

@if (\Session::has('oops'))
    <div class="alert alert-success">
        <p>{{ \Session::get('oops') }}</p>
    </div><br />
@endif
    <!-- Native navbar END -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="btn btn-primary btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$general_info_link)}}">@lang('messages.general_info')</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-secondary btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$roles_link)}}">@lang('messages.roles')</a>
            </li>
            @isset($right_settings)
                @if($right_settings->is_group_module == 0)
                    <li class="nav-item">
                        <a class="btn btn-success btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$groups_link)}}">@lang('messages.groups')</a>
                    </li>
                @endif
            @endisset

            @isset($right_settings)
                @if($right_settings->is_user_module == 0)
                    <li class="nav-item">
                        <a class="btn btn-warning btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$user_base_link)}}">@lang('messages.users')</a>
                    </li>
                @endif
            @endisset
            <li class="nav-item">
                <a class="btn btn-danger btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$settings_link)}}">@lang('messages.settings')</a>
            </li>
        </ul>
    </div>
</nav>
</div>
@stop