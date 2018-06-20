@extends('layouts.app')

@section('content')
<div class="col-md-12">
      @include('includes.head-manager')  
</div>
<div class="col-md-12">
  @if (\Session::has('oops'))
      <div class="alert alert-danger">
        <p>{{ \Session::get('oops') }}</p>
      </div><br />
  @endif
  @if (\Session::has('message'))
      <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
      </div><br />
  @endif
	<div class="page-header">
		<h3>
			@lang('messages.foods')
		</h3>
	</div>
</div>
<div class="col-md-12">
<form role="form" action="{{action('ManagerController@storeFoods',[])}}" method="post">
  @csrf
  @isset($foods)
  <div class="table-responsive">
      <table id="mytable" class="table table-bordred table-striped">
        <thead>
            <th>№</th>
            <th>@lang('messages.title')</th>
            <th>@lang('messages.title')</th>
            <th>@lang('messages.contractor')</th>
            <th>@lang('messages.price')</th>
            <th>@lang('messages.balance')</th>
        </thead>
        <tbody>
          @foreach($foods as $key => $food)
          <tr>
            <td>{{++$key}}</td>
            <td>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{$food->id}}" name="foods[]">
                <label class="form-check-label">
                  {{$food->name_ru}}
                </label>
              </div>
            </td>
            <td>
              <input type="text" class="form-control" name="food_name{{$food->id}}">
            </td>
            <td>
              <input type="text" class="form-control" name="contractor{{$food->id}}">
            </td>
            <td>
              <input type="text" class="form-control" name="price{{$food->id}}">
            </td>
            <td>
              <input type="text" class="form-control" name="balance{{$food->id}}">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  @endisset
  <button type="submit" class="btn btn-primary" name="food-submit" >@lang('messages.submit')</button>
  <a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager')}}" class="btn btn-secondary">
      @lang('messages.back')
    </a>
</form>
</div>
@stop