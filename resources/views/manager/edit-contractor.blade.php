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
		
		<div class="form-group row">				 
			<label class="col-2 col-form-label">
				@lang('messages.title')
			</label>
			<div class="col-10">
				<input type="text" class="form-control" name="contractor_title" value="{{$contractor->title}}" required="required" />
			</div>
		</div>
		<div class="form-group row">
			<label class="col-2 col-form-label">
				@lang('messages.telephone')
			</label>

			<div class="input-group col-10">
			  <div class="input-group-prepend">
			    <span class="input-group-text">+7</span>
			  </div>
			  <input type="text" class="form-control" name="contractor_telephone" value="{{$contractor->telephone}}" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __"/>
			</div>
		</div>

		<div class="table-responsive">
		    <table id="mytable" class="table table-bordred table-striped">
		        <thead>
		            <th>№</th>
		            <th>@lang('messages.title')</th>
		            <th>@lang('messages.title_by_contract')</th>
		            <th>@lang('messages.price')</th>
		            <th>@lang('messages.balance')</th>
		            <!-- <th>@lang('messages.destroy')</th> -->
		        </thead>
		        <tbody>
		        @if(count($contractor->kfood) > 0)
		          	
		          	@foreach($contractor->kfood as $key => $kfood)
				        <tr>
				            <td>{{$kfood->food_id}}</td>
				            <td>{{$kfood->food->name_ru}}</td>
				            <td>
				              <input type="text" class="form-control" name="food_name{{++$key}}" value="{{$kfood->food_name}}">
				            </td>
				            <td>
				              <input type="number" class="form-control" name="price{{++$key}}" value="{{$kfood->price}}">
				            </td>
				            <td>
				              <input type="number" class="form-control" name="balance{{++$key}}" value="{{$kfood->balance}}">
				            </td>
				            <!-- <td>
				              <form action="{{action('ManagerController@destroyFood', $kfood->food_id)}}" method="post">
				                @csrf
				                <input name="_method" type="hidden" value="DELETE">
				                <button class="btn btn-danger" type="submit">@lang('messages.destroy')</button>
				              </form>
				            </td> -->
				        </tr>
		          	@endforeach
		        @else
			        <tr>
			            <td></td>
			            <td>@lang('messages.foods_not_selected')</td>
			            <td></td>
			            <td></td>
			            <td></td>
			            <td></td>
			        </tr>
		        @endif

		        </tbody>
		    </table>
		</div>
		
		<button type="submit" class="btn btn-primary">
			@lang('messages.submit')
		</button>
		<a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager/pp')}}" class="btn btn-secondary">
			@lang('messages.back')
		</a>
	</form>
</div>

@stop