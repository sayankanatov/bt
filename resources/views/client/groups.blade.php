@extends('layouts.app')

@section('content')

@include('includes.head-client')

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
      @lang('messages.groups')
    </h3>
  </div>
  <!-- TEST Start -->
@if(!empty($groups))
<div class="table-responsive">
    <table id="mytable" class="table table-bordred table-striped">
      <thead>
          <th>№</th>
          <th>@lang('messages.title')</th>
          <th>@lang('messages.category')</th>
          <th>@lang('messages.group_count')</th>
          <th>@lang('messages.mentors')</th>
          <th>@lang('messages.edit')</th>
          <!-- <th>@lang('messages.destroy')</th> -->
      </thead>
    <tbody>
      @foreach($groups as $key => $group) <!-- Main FOREACH start-->
        <tr>
          <td>{{++$key}}</td>
          <td>{{$group->title}}</td>
          <td>{{$group->category}}</td>
          <td>{{$group->child_count}}</td>
          <td>
            @foreach($mentors as $first_mentor)
              @if($first_mentor->id == $group->first_mentor_id)
                {{$first_mentor->name}}<br>
              @endif
            @endforeach

            @foreach($mentors as $second_mentor)
              @if($second_mentor->id == $group->second_mentor_id)
                {{$second_mentor->name}}<br>
              @endif
            @endforeach
          </td>
          <td>
            <a class="btn btn-small btn-info" href="{{ action('ClientController@editGroup',$group->id) }}">@lang('messages.edit')</a>
          </td>
        </tr>
        
      @endforeach <!-- Main foreach end-->
    </tbody>     
  </table>
</div>
</div>
@endif
@if($kindergarten->group_count - $groups->count() > 0)
<div class="col-md-12">
  <a id="modal-769746" href="#modal-container-769746" role="button" class="btn btn-success" data-toggle="modal">@lang('messages.add_group')</a>
  <a href="{{url(App\Http\Middleware\LocaleMiddleware::getLocale().'/user/home')}}" class="btn btn-secondary">
    @lang('messages.back')
  </a>
      
      <div class="modal fade" id="modal-container-769746" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">
                @lang('messages.add_group')
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
                  <input type="text" class="form-control" name="group_name" required="required" />

                  <label>
                    @lang('messages.category')
                  </label>
                  <select class="form-control" name="group_category">
                  @isset($group_categories)
                  @foreach($group_categories as $category)
                      <option value="{{$category->name}}">{{$category->name}}</option>
                  @endforeach
                  @endisset
                  </select>
                 
                  <label>
                    @lang('messages.group_count')
                  </label>
                  <input type="number" class="form-control" name="child_count" required="required" />
                  <label>
                    @lang('messages.mentors')
                  </label>
                  <select class="form-control" name="first_mentor">
                    @isset($notExistInFirstMentors)
                    @foreach($notExistInFirstMentors as $mentor)
                        <option value="{{$mentor->id}}">{{$mentor->name}}</option>
                    @endforeach
                    @endisset
                  </select>
                  <select class="form-control" name="second_mentor">
                    @isset($notExistInSecondMentors)
                    <option value="0">---</option>
                    @foreach($notExistInSecondMentors as $mentor)
                    <option value="{{$mentor->id}}">{{$mentor->name}}</option>
                    @endforeach
                    @endisset
                  </select>
                </div>
                <button type="submit" name="add-group-submit" class="btn btn-primary" id="add-group-submit" onclick="getElementById('add-group-submit').style.display = 'none';">
                  @lang('messages.add_group')
                </button>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>
</div>
@endif

@stop