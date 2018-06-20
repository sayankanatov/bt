@extends('layouts.app')

@section('content')

@include('includes.head-manager')

<div class="col-md-12">
  @if (\Session::has('message'))
      <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
      </div><br />
  @endif

  @if (\Session::has('warning'))
      <div class="alert alert-warning">
        <p>{{ \Session::get('warning') }}</p>
      </div><br />
  @endif
  
  <div class="page-header">
    <h3>
      @lang('messages.contractors')
    </h3>
  </div>

  @if(!empty($contractors))
  <div class="table-responsive">
      <table id="mytable" class="table table-bordred table-striped">
        <thead>
            <th>№</th>
            <th>@lang('messages.title')</th>
            <th>@lang('messages.telephone')</th>
            <th>@lang('messages.edit')</th>
            <th>@lang('messages.destroy')</th>
        </thead>
      <tbody>
        @foreach($contractors as $key => $contractor) <!-- Main FOREACH start-->
          <tr>
            <td>{{++$key}}</td>
            <td>{{$contractor->title}}</td>
            <td>+7 {{$contractor->telephone}}</td>
            <td>
              <a class="btn btn-small btn-info" href="{{ action('ManagerController@editContractor',$contractor->id) }}">@lang('messages.edit')</a>
            </td>
            <td>
              <form action="{{action('ManagerController@destroyContractor', $contractor->id)}}" method="post">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-danger" type="submit">@lang('messages.destroy')</button>
              </form>
            </td>
          </tr>
          
        @endforeach <!-- Main foreach end-->
      </tbody>     
    </table>
  </div>
  </div>
  @endif
  <div class="col-md-12">
  <a id="modal-769746" href="#modal-container-769746" role="button" class="btn btn-success" data-toggle="modal">@lang('messages.add_contractor')</a>
  <a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager')}}" class="btn btn-secondary">
    @lang('messages.back')
  </a>
      
      <div class="modal fade" id="modal-container-769746" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">
                @lang('messages.add_contractor')
              </h5> 
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" method="post" id="my-form">
                @csrf
                <div class="form-group">
                  <label>
                    @lang('messages.title')
                  </label>
                  <input type="text" class="form-control" name="contractor_title" required="required" />

                  <label>
                    @lang('messages.telephone')
                  </label>
                  <div class="input-group md-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text">+7</span>
                    </div>
                    <input type="tel" class="form-control" name="contractor_telephone" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __">
                  </div>
                </div>
                <button type="submit" name="add-contractor-submit" class="btn btn-primary" id="add-group-submit" onclick="getElementById('add-group-submit').style.display = 'none';">
                  @lang('messages.add_contractor')
                </button>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>
</div>
</div>
@stop