@extends('layouts.app')

@section('content')

@include('includes.head-koordinator')

<div class="col-md-6">
	<div class="page-header">
		<h4>
			@lang('messages.update_kindergarten'): <small>{{$kindergarten->name}}</small>
		</h4>
	</div>

<form role="form" action="{{action('AccountController@update',['id' => $kindergarten->id])}}" method="post">
	@csrf
	<div class="form-group">				 
		<label for="exampleInputName">
			@lang('messages.title')
		</label>
		<input type="text" class="form-control" id="exampleInputName" name="KindergartenName" value="{{$kindergarten->name}}" />
	</div>
	<div class="form-group">				 
		<label for="exampleInputNum">
			№
		</label>
		<input type="text" class="form-control" id="exampleInputNum" name="num" value="{{$kindergarten->num}}" />
	</div>
	<button type="submit" class="btn btn-primary">
		@lang('messages.submit')
	</button>
	<a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/account/kindergarten')}}" class="btn btn-secondary">
		@lang('messages.back')
	</a>
</form>
</div>
@stop