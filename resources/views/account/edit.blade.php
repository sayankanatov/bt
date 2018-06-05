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
			Name
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
		Submit
	</button>
	<a href="{{url('account/kindergarten')}}" class="btn btn-secondary">
		Back
	</a>
</form>
</div>
@stop