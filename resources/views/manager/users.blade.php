@extends('layouts.app')

@section('content')

@include('includes.head-manager')

<div class="col-md-12">
	<a id="modal-835846" href="#modal-container-835846" role="button" class="btn" data-toggle="modal">@lang('messages.add')</a>
			
			<div class="modal fade" id="modal-container-835846" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								@lang('messages.add')
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
                    @lang('messages.name')
                  </label>
                  <input type="text" class="form-control" name="children_name" required="true" />

                  <label>
                    @lang('messages.iin')
                  </label>
                  <input type="number" class="form-control" name="children_iin" required="true" />
              
                </div>
                <button type="submit" name="child-submit" class="btn btn-primary">
                  @lang('messages.add')
                </button>
              </form>
						</div>
						
					</div>
					
				</div>
				
			</div>
</div>
@stop