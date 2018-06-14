@extends('layouts.app')

@section('content')

<div class="col-md-12">

    <!-- Native navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="btn btn-success btn-lg" style="margin-left: 10%;" href="{{$kindergarten_link}}">@lang('messages.kindergarten_link')</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-warning btn-lg" style="margin-left: 15%;" href="{{$report_link}}">@lang('messages.reports')</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-md-auto">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle btn" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown">Язык</a>
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

@stop