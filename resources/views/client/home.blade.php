@extends('layouts.app')

@section('content')
<div class="col-md-12">
    @include('includes.head-client')

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
                    <a class="btn btn-info btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$contractor_link)}}">@lang('messages.contractors')</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-light btn-lg" href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().$food_link)}}">@lang('messages.foods')</a>
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
        </div>
    </nav>  
</div>
@endsection
