@extends('layouts.app')

@section('content')
<div class="col-md-12">
      @include('includes.head-manager')  
</div>
<div class="col-md-12">
	<div class="page-header">
		<h3>
			@lang('messages.edit')
		</h3>
	</div>
</div>

<div class="col-md-6">
	<form role="form" action="{{action('ManagerController@updateChild',['id' => $children->id] ) }}" method="post">
		@csrf
		<div class="form-group">				 
			<label>
				@lang('messages.child_fio')
			</label>
			<input type="text" class="form-control" name="child_name" value="{{$children->name}}" required="required"/>
		</div>
		<div class="form-group">
			<label>
                @lang('messages.child_iin')
            </label>
            <input type="tel" class="form-control" name="child_iin" value="{{$children->iin}}" data-mask="000000000000" data-mask-selectonfocus="true"required="required" />
		</div>
		<h4>
			Родители
		</h4>
		@isset($parents)
		@foreach($parents as $key => $parent)
			<div class="form-group row">
				<label class="col-2 col-form-label">
	                @lang('messages.parent_fio')
	            </label>
	            <div class="col-10">
	            	<input type="text" class="form-control" name="parent_name{{$parent->id}}" value="{{$parent->name}}" required="required" />
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
				  <input type="text" class="form-control" name="parent_telephone{{$parent->id}}" value="{{$parent->telephone}}" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __"/>
				</div>
			</div>
		@endforeach
		@endisset
		
		<button type="submit" class="btn btn-primary">
			@lang('messages.submit')
		</button>
		<a href="{{url('manager/childrens')}}" class="btn btn-secondary">
			@lang('messages.back')
		</a>
	</form>
</div>

@stop