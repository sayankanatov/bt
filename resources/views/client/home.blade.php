@extends('layouts.app')

@section('content')
<div class="col-md-12">

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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="navbar-nav">
                @isset($right_settings)
                @if($right_settings->is_group_module == 1)
                    @if($user->role_id == Config::get('constants.roles.methodist'))
                    <li class="nav-item">
                        <a class="btn btn-secondary btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$metodist_link)}}">@lang('messages.groups')</a>
                    </li>
                    @endif
                @endif
                @endisset


                @if($user->role_id == Config::get('constants.roles.nurse'))
                <li class="nav-item">
                    <a class="btn btn-success btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$nurse_link)}}">@lang('messages.groups')</a>
                </li>
                @endif

                @isset($right_settings)
                @if($right_settings->is_pp_module == 1)
                    @if($user->role_id == Config::get('constants.roles.accountant'))
                    <li class="nav-item">
                        <a class="btn btn-info btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$pp_link)}}">@lang('messages.contractors_and_foods')</a>
                    </li>
                    
                    @endif
                @endif
                @endisset

                @if($user->role_id == Config::get('constants.roles.storekeeper'))
                <li class="nav-item">
                    <a class="btn btn-warning btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$storekeeper_link)}}">@lang('messages.users')</a>
                </li>
                @endif

                @isset($right_settings)
                @if($right_settings->is_user_module == 1)
                    @if($user->role_id == Config::get('constants.roles.mentor'))
                    <li class="nav-item">
                        <a class="btn btn-warning btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$mentor_link)}}">@lang('messages.users')</a>
                    </li>
                    @endif
                @endif
                @endisset


                @if($user->role_id == Config::get('constants.roles.parent'))
                <li class="nav-item">
                    <a class="btn btn-warning btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$parent_link)}}">@lang('messages.users')</a>
                </li>
                @endif
                
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
                    <a class="btn btn-danger" href="{{ url('/user/logout') }}"
                        onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                        @lang('messages.logout')
                    </a>
                    
                    <form id="logout-form" action="{{ url('/user/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ url(App\Http\Middleware\LocaleMiddleware::getLocale() .'/'.'user/login') }}">@lang('messages.login')</a>
                </li>
            @endauth 
            </ul>
        </div>
    </nav>  
</div>
@endsection
