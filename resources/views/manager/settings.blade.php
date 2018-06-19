@extends('layouts.app')

@section('content')

@include('includes.head-manager')

<div class="col-md-12">
	@if (\Session::has('message'))
      <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
      </div><br />
  	@endif

  	@if (\Session::has('oops'))
      <div class="alert alert-danger">
        <p>{{ \Session::get('oops') }}</p>
      </div><br />
  	@endif
    <div class="page-header">
      <h3>
        @lang('messages.settings')
      </h3>
    </div>

    <div class="col-md-6">
      <form role="form" action="{{action('ManagerController@storeSettings',['id' => $kindergarten->kindergarten_id])}}" method="post">
      @csrf
      <!-- Group settings -->
        <div class="form-group row">         
          <label class="col-6 col-form-label">
            @lang('messages.groups')
          </label>
          <div class="col-6">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="is_group_module" value="0" {{(isset($setting) && $setting->is_group_module == 0 ) ? 'checked' : ''}}>
              <label class="form-check-label">
                @lang('messages.give_rights_to_you')
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="is_group_module" value="1" {{(isset($setting) && $setting->is_group_module == 1 ) ? 'checked' : ''}}>
              <label class="form-check-label">
                @lang('messages.give_rights_to') @lang('messages.to_methodist')
              </label>
            </div>
          </div>
        </div>
        <!-- User database settings -->
        <div class="form-group row">         
          <label class="col-6 col-form-label">
            @lang('messages.users')
          </label>
          <div class="col-6">
            <div class="form-check">
              <input class="form-check-input" name="is_user_module" type="radio" value="0" {{(isset($setting) && $setting->is_user_module == 0 ) ? 'checked' : ''}}>
              <label class="form-check-label">@lang('messages.give_rights_to_you')</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" name="is_user_module" type="radio" value="1" {{(isset($setting) && $setting->is_user_module == 1 ) ? 'checked' : ''}}>
                <label class="form-check-label">@lang('messages.give_rights_to') @lang('messages.to_mentors')</label>
            </div>
          </div>
        </div>
        <!-- Menu settings -->
        <div class="form-group row">         
          <label class="col-6 col-form-label">
            @lang('messages.menu')
          </label>
          <div class="col-6">
            <div class="form-check">
              <input class="form-check-input" name="is_menu_module" type="radio" value="0" {{(isset($setting) && $setting->is_menu_module == 0 ) ? 'checked' : ''}}>
              <label class="form-check-label">@lang('messages.give_rights_to_you')</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" name="is_menu_module" type="radio" value="1" {{(isset($setting) && $setting->is_menu_module == 1 ) ? 'checked' : ''}}>
                <label class="form-check-label">@lang('messages.give_rights_to') @lang('messages.to_nurse')</label>
            </div>
          </div>
        </div>
        <!-- PP settings -->
        <div class="form-group row">         
          <label class="col-6 col-form-label">
            @lang('messages.pp')
          </label>
          <div class="col-6">
            <div class="form-check">
              <input class="form-check-input" name="is_pp_module" type="radio" value="0" {{(isset($setting) && $setting->is_pp_module == 0 ) ? 'checked' : ''}}>
              <label class="form-check-label">@lang('messages.give_rights_to_you')</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" name="is_pp_module" type="radio" value="1" {{(isset($setting) && $setting->is_pp_module == 1 ) ? 'checked' : ''}}>
                <label class="form-check-label">@lang('messages.give_rights_to') @lang('messages.to_accountant')</label>
            </div>
          </div>
        </div>
        <!-- Prolongation settings -->
        <div class="form-group row">         
          <label class="col-6 col-form-label">
            @lang('messages.have_prolongation')
          </label>
          <div class="col-6">
            <div class="form-check">
              <input class="form-check-input" name="is_prolongation" type="radio" value="1" {{(isset($setting) && $setting->is_prolongation == 1 ) ? 'checked' : ''}}>
              <label class="form-check-label">@lang('messages.yes')</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" name="is_prolongation" type="radio" value="0" {{(isset($setting) && $setting->is_prolongation == 0 ) ? 'checked' : ''}}>
                <label class="form-check-label">@lang('messages.no')</label>
            </div>
          </div>
        </div>
        
        <button type="submit" class="btn btn-primary">
          @lang('messages.submit')
        </button>
        <a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager')}}" class="btn btn-secondary">
          @lang('messages.back')
        </a>
      </form>
  </div>
</div>
@stop