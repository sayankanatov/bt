@extends('layouts.app')

@section('content')

@include('includes.head-koordinator')

<div class="col-md-12">
  @if (\Session::has('message'))
      <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
      </div><br />
  @endif
  <!-- TEST Start -->
@if(!empty($kindergartens))
<div class="table-responsive">
    <table id="mytable" class="table table-bordred table-striped">
      <thead>
          <th>№</th>
          <th>@lang('messages.kinder_number')</th>
          <th>@lang('messages.title')</th>
          <th>@lang('messages.email')</th>
          <th>@lang('messages.edit')</th>
          <!-- <th>@lang('messages.destroy')</th> -->
      </thead>
    <tbody>
      @foreach($kindergartens as $key => $kindergarten) <!-- Main FOREACH start-->
        <tr>
          <td>{{++$key}}</td>
          <td>{{$kindergarten->num}}</td>
          <td>{{$kindergarten->name}}</td>
          

          @if(!empty($managers))
            @foreach($managers as $manager)
              @if($kindergarten->id == $manager->id)
                <td>{{$manager->email}}</td>
              @endif
            @endforeach
          @endif

          <td>
            <a class="btn btn-small btn-info" href="{{ action('AccountController@edit',$kindergarten->id) }}">@lang('messages.edit')</a>
          </td>
          <!-- <td>
          <form action="{{action('AccountController@destroy', $kindergarten->id)}}" method="post">
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td> -->
        </tr>
        
      @endforeach <!-- Main foreach end-->
    </tbody>     
  </table>
  {{$kindergartens->links()}}
</div>
</div>
@endif
<div class="col-md-12">
  <a id="modal-769746" href="#modal-container-769746" role="button" class="btn btn-success" data-toggle="modal">@lang('messages.add_kindergarten')</a>
  <a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/account')}}" class="btn btn-secondary">
    @lang('messages.back')
  </a>
      
      <div class="modal fade" id="modal-container-769746" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">
                @lang('messages.add_kindergarten')
              </h5> 
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" method="post">
                @csrf
                <div class="form-group">
                   
                  <label for="exampleInputKinderGarten">
                    @lang('messages.title')
                  </label>
                  <input type="text" class="form-control" id="exampleInputKinderGarten" name="kindergarten_name" required="required" />
                  <label for="exampleInputKinderGartenNumber">
                    @lang('messages.kinder_number')
                  </label>
                  <input type="number" class="form-control" id="exampleInputKinderGartenNumber" name="kindergarten_number" required="required" />
                  <label for="exampleInputUserEmail">
                    @lang('messages.email')
                  </label>
                  <input type="email" class="form-control" id="exampleInputUserEmail" name="email" required="required" />
                  <!-- <label for="exampleInputUserTel">
                    @lang('messages.number')
                  </label>
                  <input type="number" class="form-control" id="exampleInputUserTel" name="tel" required="required" /> -->
                </div>
                <button type="submit" class="btn btn-primary">
                  @lang('messages.add')
                </button>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>
</div>

@stop