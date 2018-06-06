@extends('layouts.app')

@section('content')

@include('includes.head-manager')

<div class="col-md-12">
	@if (\Session::has('message'))
      <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
      </div><br />
  	@endif

  	<div class="table-responsive">
    <table id="mytable" class="table table-bordred table-striped">
      <thead>
          <th>№</th>
          <th>@lang('messages.title')</th>
          <th>@lang('messages.category')</th>
          <th>@lang('messages.group_count')</th>
          <th>@lang('messages.add_child')</th>
          <th>@lang('messages.show')</th>
      </thead>
    <tbody>
      @foreach($groups as $key => $group) <!-- Main FOREACH start-->
        <tr>
          <td>{{++$key}}</td>
          <td>{{$group->title}}</td>
          <td>{{$group->category}}</td>
          <td>{{$group->child_count}}</td>
          <td>
          	<a id="modal-1{{$group->id}}" href="#modal-container-1{{$group->id}}" role="button" class="btn btn-small btn-success" data-toggle="modal">@lang('messages.add')</a>
          </td>
          <td>
            <a id="modal-2{{$group->id}}" href="#modal-container-2{{$group->id}}" role="button" class="btn btn-info" data-toggle="modal">@lang('messages.show')</a>
			
			<div class="modal fade bd-example-modal-lg" id="modal-container-2{{$group->id}}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								{{$group->title}}
							</h5> 
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="table-responsive">
							    <table class="table table-bordred table-striped">
							    	<thead class="table-success">
							    		<th>№</th>
							    		<th>@lang('messages.child_fio')</th>
							    		<th>@lang('messages.child_iin')</th>
							    		<th>@lang('messages.parent_fio')</th>
							    		<th>@lang('messages.telephone')</th>
							    		<th>@lang('messages.edit')</th>
							    	</thead>
							    	<tbody>
							    		@foreach($group->children as $key => $children)
							    		<tr class="table-warning">
							    			<td>{{++$key}}</td>
							    			<td>{{$children->name}}</td>
							    			<td>{{$children->iin}}</td>
							    			<td>{{$children->parent->name}}</td>
							    			<td>{{$children->parent->telephone}}</td>
							    			<td>
							    				<a class="btn btn-small btn-info" href="{{ action('ManagerController@editChild',$children->id) }}">@lang('messages.edit')</a>
							    			</td>
							    		</tr>
							    		@endforeach
							    	</tbody>
							    </table>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								@lang('messages.back')
							</button>
						</div>
					</div>
					
				</div>
				
			</div>
          </td>
        </tr>
        <div class="modal fade" id="modal-container-1{{$group->id}}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myModalLabel">
								@lang('messages.add_child')
						</h5> 
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
				<form role="form" method="post">
                		@csrf
                	<div class="form-group">
                  		<label>
                    	@lang('messages.child_fio')
                  		</label>
                  	<input type="text" class="form-control" name="children_name" required="required" />
						<label>
                    	@lang('messages.child_iin')
                  		</label>
                  	<input type="tel" class="form-control" name="children_iin" required="required" data-mask="000000000000" data-mask-selectonfocus="true"/>
                  	<label>
                    	@lang('messages.parent_fio')
                  		</label>
                  	<input type="text" class="form-control" name="parent_name" required="required" />
                  	<label>
                    	@lang('messages.telephone')
                  		</label>
                  	<input type="tel" class="form-control" name="parent_telephone" required="required" data-mask="+7(000)000 00 00" data-mask-selectonfocus="true" placeholder="+7(___)__ __ __"/>
                  	<input type="hidden" name="group_id" value="{{$group->id}}">
             
                	</div>
                	<button type="submit" name="child-submit" class="btn btn-primary">
                  	@lang('messages.add')
                	</button>
              	</form>
					</div>
						
				</div>
					
			</div>
		</div>
        
      @endforeach <!-- Main foreach end-->
    </tbody>     
  </table>

</div>
@stop