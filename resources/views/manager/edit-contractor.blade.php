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
	<div class="page-header">
		<h3>
			@lang('messages.edit')
		</h3>
	</div>
</div>

<div class="col-md-6">
	<form role="form" action="{{action('ManagerController@updateContractor',['id' => $contractor->id])}}" method="post">
		@csrf
		<div class="form-group">				 
			<label>
				@lang('messages.title')
			</label>
			<input type="text" class="form-control" name="contractor_title" value="{{$contractor->title}}" required="required" />
		</div>
		<div class="form-group">				 
			<label>
                @lang('messages.telephone')
            </label>
            <div class="input-group col-14">
				<div class="input-group-prepend">
				    <span class="input-group-text">+7</span>
				</div>
				<input type="text" class="form-control" name="contractor_telephone" value="{{$contractor->telephone}}" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __"/>
			</div>

		</div>
		
		<button type="submit" class="btn btn-primary">
			@lang('messages.submit')
		</button>
		<a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/contractors')}}" class="btn btn-secondary">
			@lang('messages.back')
		</a>
	</form>
</div>

@stop