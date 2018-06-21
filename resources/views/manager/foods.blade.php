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
  @if (\Session::has('message'))
      <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
      </div><br />
  @endif
  <div class="page-header">
    <h3>
      @lang('messages.foods')
    </h3>
  </div>
</div>
<div class="col-md-12">
<form role="form" action="{{action('ManagerController@storeFoods',[])}}" method="post">
  @csrf
  
  <div class="table-responsive">
      <table id="mytable" class="table table-bordred table-striped">
        <thead>
            <th>№</th>
            <th>@lang('messages.title')</th>
            <th>@lang('messages.title_by_contract')</th>
            <th>@lang('messages.contractor')</th>
            <th>@lang('messages.price')</th>
            <th>@lang('messages.balance')</th>
        </thead>
        <tbody>
          @if(count($kfoods) > 0)
          @foreach($kfoods as $key => $kfood)
          <tr>
            <td>{{++$key}}</td>
            <td>{{$kfood->food->name_ru}}</td>
            <td>
              <input type="text" class="form-control" name="food_name{{$kfood->id}}" value="{{$kfood->food_name}}">
            </td>
            <td>
              @if(count($contractors) > 0)
                <select class="form-control" name="contractor{{$kfood->id}}">
                  @foreach($contractors as $contractor)
                    <option value="{{$contractor->id}}" {{$contractor->id == $kfood->contractor_id ? 'selected' : ''}}>{{$contractor->title}}</option>
                  @endforeach
                </select>
              @else
              @lang('messages.please_add_contractors')
              @endif
            </td>
            <td>
              <input type="number" class="form-control" name="price{{$kfood->id}}" value="{{$kfood->price}}">
            </td>
            <td>
              <input type="number" class="form-control" name="balance{{$kfood->id}}" value="{{$kfood->balance}}">
            </td>
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
  <button type="submit" class="btn btn-primary" name="kfood-submit" >@lang('messages.submit')</button>
  <a id="modal-22" href="#modal-container-22" role="button" class="btn btn-info" data-toggle="modal">@lang('messages.add_from_foods')</a>
  <a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/manager')}}" class="btn btn-secondary">
      @lang('messages.back')
    </a>
</form>
   
<div class="modal fade" id="modal-container-22" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">
          @lang('messages.add_from_foods')
        </h5> 
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="post">
          @csrf
          <div class="form-group">
            @foreach($foods as $food)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{$food->id}}" name="foods[]">
                <label class="form-check-label">{{$food->name_ru}}</label>
              </div>
            @endforeach
          </div>
          <button type="submit" name="add-food-submit" class="btn btn-primary">
            @lang('messages.add')
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
@stop