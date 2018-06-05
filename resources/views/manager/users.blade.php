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
			
			<div class="modal fade" id="modal-container-2{{$group->id}}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
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
							    <table id="mytable" class="table table-bordred table-striped">
							    	<thead>
							    		<th>1</th>
							    		<th>2</th>
							    		<th>3</th>
							    	</thead>
							    	<tbody>
							    		<td>1</td>
							    		<td>3</td>
							    		<td>4</td>
							    	</tbody>
							    </table>
							</div>
						</div>
						<div class="modal-footer">
							 
							<button type="button" class="btn btn-primary">
								Save changes
							</button> 
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Close
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
                  	<input type="text" class="form-control" name="children_name" required="true" />
						<label>
                    	@lang('messages.child_iin')
                  		</label>
                  	<input type="tel" class="form-control" name="children_iin" required="true" data-mask="0000 0000 0000" data-mask-selectonfocus="true"/>
                  	<label>
                    	@lang('messages.parent_fio')
                  		</label>
                  	<input type="text" class="form-control" name="parent_name" required="true" />
                  	<label>
                    	@lang('messages.telephone')
                  		</label>
                  	<input type="tel" class="form-control" name="parent_telephone" required="true" data-mask="+7(000)000 00 00" data-mask-selectonfocus="true" placeholder="+7(___)__ __ __"/>
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