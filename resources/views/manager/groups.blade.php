@extends('layouts.app')

@section('content')

@include('includes.head-manager')

<div class="col-md-12">
  @if (\Session::has('message'))
      <div class="alert alert-success">
        <p>{{ \Session::get('message') }}</p>
      </div><br />
  @endif

  @if($kindergarten->group_count - $groups->count() > 0)
  <div class="alert alert-warning">
    <p>@lang('messages.you_must_add') {{$kindergarten->group_count - $groups->count()}} @lang('messages.group')</p>
  </div>
  @elseif($groups->count() - $kindergarten->group_count > 0)
  <div class="alert alert-warning">
    <p>@lang('messages.you_must_edit_general_info') {{$groups->count() - $kindergarten->group_count}} @lang('messages.group')</p>
  </div>
  @endif
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
            @foreach($mentors as $mentor)
            @if($mentor->id == $group->first_mentor_id)
            {{$mentor->name}}<br>
            @elseif($mentor->id == $group->second_mentor_id)
            {{$mentor->name}}<br>
            @endif
            @endforeach
          </td>
          <td>
            <a class="btn btn-small btn-info" href="{{ action('ManagerController@editGroup',$group->id) }}">@lang('messages.edit')</a>
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
  <a href="{{url('manager')}}" class="btn btn-secondary">
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
              <form role="form" method="post">
                @csrf
                <div class="form-group">
                  <label>
                    @lang('messages.title')
                  </label>
                  <input type="text" class="form-control" name="group_name" required="true" />

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
                  <input type="number" class="form-control" name="child_count" required="true" />
                  <label>
                    @lang('messages.mentors')
                  </label>
                  <select class="form-control" name="first_mentor">
                    @isset($mentors)
                    @foreach($mentors as $mentor)
                    <option value="{{$mentor->id}}">{{$mentor->name}}</option>
                    @endforeach
                    @endisset
                  </select>
                  <select class="form-control" name="second_mentor">
                    @isset($mentors)
                    <option value="0">---</option>
                    @foreach($mentors as $mentor)
                    <option value="{{$mentor->id}}">{{$mentor->name}}</option>
                    @endforeach
                    @endisset
                  </select>
                </div>
                <button type="submit" name="add-group-submit" class="btn btn-primary">
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