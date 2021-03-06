@extends('layouts.app')

@section('content')
<div class="col-md-12">
      @include('includes.head-client')  
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
	<form role="form" action="{{action('ClientController@updateGroup',['id' => $group->id])}}" method="post">
		@csrf
		<div class="form-group">				 
			<label>
				@lang('messages.title')
			</label>
			<input type="text" class="form-control" name="group_name" value="{{$group->title}}" required="required" />
		</div>
		<div class="form-group">				 
			<label>
                @lang('messages.category')
            </label>
            <select class="form-control" name="group_category">
                @isset($group_categories)
                  	@foreach($group_categories as $category)
				    <option value="{{$category->name}}" {{ $category->name == $group->category ? 'selected' : ''}}>{{$category->name}}</option>
				    @endforeach
				@endisset
			</select>
		</div>
		<div class="form-group">
			<label>
                @lang('messages.group_count')
            </label>
            <input type="number" class="form-control" name="child_count" value="{{isset($group->child_count) ? $group->child_count : ''}}" required="required" />
		</div>
		<div class="form-group">
			<label>
                @lang('messages.mentors')
            </label>
            <select class="form-control" name="first_mentor">
                @isset($notExistInFirstMentors)
                @foreach($mentors as $mentor)
	                @if($mentor->id == $group->first_mentor_id)
	                	<option value="{{$mentor->id}}" selected="selected">{{$mentor->name}}</option>
	                @endif
                @endforeach
                  	@foreach($notExistInFirstMentors as $mentor)
				    <option value="{{$mentor->id}}">{{$mentor->name}}</option>
				    @endforeach
				@endisset
			</select>
			<select class="form-control" name="second_mentor">
			@isset($notExistInSecondMentors)
				<option value="0">---</option>
				@foreach($mentors as $mentor)
	                @if($mentor->id == $group->second_mentor_id)
	                	<option value="{{$mentor->id}}" selected="selected">{{$mentor->name}}</option>
	                @endif
                @endforeach

	            @foreach($notExistInSecondMentors as $mentor)
				    <option value="{{$mentor->id}}" {{ $mentor->id == $group->second_mentor_id ? 'selected' : ''}}>{{$mentor->name}}</option>
				@endforeach
			@endisset
			</select>
		</div>
		<button type="submit" class="btn btn-primary">
			@lang('messages.submit')
		</button>
		<a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/user/groups')}}" class="btn btn-secondary">
			@lang('messages.back')
		</a>
	</form>
</div>

@stop