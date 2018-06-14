@extends('layouts.app')

@section('content')
<div class="col-md-12">
      @include('includes.head-client')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="navbar-nav">
                @if($user->role_id == Config::get('constants.roles.deputy'))
                <li class="nav-item">
                    <a class="btn btn-primary btn-lg" href="{{$deputy_link}}">@lang('messages.general_info')</a>
                </li>
                @endif
                @if($user->role_id == Config::get('constants.roles.methodist'))
                <li class="nav-item">
                    <a class="btn btn-secondary btn-lg" style="margin-left: 10%;" href="{{$metodist_link}}">@lang('messages.groups')</a>
                </li>
                @endif
                @if($user->role_id == Config::get('constants.roles.nurse'))
                <li class="nav-item">
                    <a class="btn btn-success btn-lg" style="margin-left: 15%;" href="{{$nurse_link}}">@lang('messages.groups')</a>
                </li>
                @endif
                @if($user->role_id == Config::get('constants.roles.accountant'))
                <li class="nav-item">
                    <a class="btn btn-warning btn-lg" style="margin-left: 15%;" href="{{$accountant_link}}">@lang('messages.users')</a>
                </li>
                @endif
                @if($user->role_id == Config::get('constants.roles.storekeeper'))
                <li class="nav-item">
                    <a class="btn btn-warning btn-lg" style="margin-left: 15%;" href="{{$storekeeper_link}}">@lang('messages.users')</a>
                </li>
                @endif
                @if($user->role_id == Config::get('constants.roles.mentor'))
                <li class="nav-item">
                    <a class="btn btn-warning btn-lg" style="margin-left: 15%;" href="{{$mentor_link}}">@lang('messages.users')</a>
                </li>
                @endif
                @if($user->role_id == Config::get('constants.roles.parent'))
                <li class="nav-item">
                    <a class="btn btn-warning btn-lg" style="margin-left: 15%;" href="{{$parent_link}}">@lang('messages.users')</a>
                </li>
                @endif
                
            </ul>
        </div>
    </nav>  
</div>
@endsection
