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
	<div class="page-header">
		<h3>
			@lang('messages.roles')
		</h3>
	</div>
</div>
<div class="col-md-12">
<form role="form" action="{{action('ManagerController@storeRoles',[])}}" method="post">
	@csrf
	<!-- FIRST ROW -->
	<div class="form-row">
  	<div class="form-group col-md-4">
      <label>Описание</label>
      <input type="text" class="form-control" readonly="true" value="{{isset($deputy->description) ? $deputy->description : ''}}">
    </div>
    <div class="form-group col-md-4">
      <label>по умолчанию Заведующий</label>
      <input type="text" class="form-control" name="role_name1" value="{{isset($deputy) ? $deputy->role_name : ''}}" placeholder="Заведующий">
    </div>
    <div class="form-group col-md-4">

      <label>@lang('messages.id_and_tel')</label>
      <div class="input-group md-4">
        <div class="input-group-prepend">
          <span class="input-group-text">+7</span>
        </div>
        <input type="tel" class="form-control form-control-sm" aria-describedby="basic-addon3" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __" name="tel1" value="{{isset($deputy) ? $deputy->telephone : ''}}">
      </div>
      <label>ФИО</label>
        <input type="text" class="form-control form-control-sm" name="fio1" value="{{isset($deputy) ? $deputy->name : ''}}" required="required">

    </div>
  </div>
  
  <!-- SECOND ROW -->
  <div class="form-row">
  	<div class="form-group col-md-4">
      <label>Описание</label>
      <input type="text" class="form-control" readonly="true" value="{{isset($methodist->description)  ? $methodist->description : ''}}">
    </div>
    <div class="form-group col-md-4">
      <label>по умолчанию Методист</label>
      <input type="text" class="form-control" name="role_name2" placeholder="Методист" value="{{isset($methodist) ? $methodist->role_name : ''}}">
    </div>
    <div class="form-group col-md-4">

      <label>@lang('messages.id_and_tel')</label>
      <div class="input-group md-4">
        <div class="input-group-prepend">
          <span class="input-group-text">+7</span>
        </div>
        <input type="tel" class="form-control form-control-sm" name="tel2" value="{{isset($methodist) ? $methodist->telephone : ''}}" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __">
      </div>
      
      <label>ФИО</label>
      <input type="text" class="form-control form-control-sm" name="fio2" value="{{isset($methodist) ? $methodist->name : ''}}" required="required">

    </div>
  </div>
  <!-- THIRD ROW -->
  <div class="form-row">
  	<div class="form-group col-md-4">
      <label>Описание</label>
      <input type="text" class="form-control" readonly="true" value="{{isset($nurse->description)  ? $nurse->description : ''}}">
    </div>
    <div class="form-group col-md-4">
      <label>по умолчанию Медицинская сестра</label>
      <input type="text" class="form-control" name="role_name3" value="{{isset($nurse) ? $nurse->role_name : ''}}" placeholder="Медицинская сестра">
    </div>
    <div class="form-group col-md-4">
      <label>@lang('messages.id_and_tel')</label>
      <div class="input-group md-4">
        <div class="input-group-prepend">
          <span class="input-group-text">+7</span>
        </div>
        <input type="tel" class="form-control form-control-sm" name="tel3" value="{{isset($nurse) ? $nurse->telephone : ''}}" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __">
      </div>
      
      <label>ФИО</label>
      <input type="text" class="form-control form-control-sm" name="fio3" value="{{isset($nurse) ? $nurse->name : ''}}" required="true">
    </div>
  </div>
  <!-- FOURTH ROW -->
  <div class="form-row">
  	<div class="form-group col-md-4">
      <label>Описание</label>
      <input type="text" class="form-control" readonly="true" value="{{isset($accountant->description)  ? $accountant->description : ''}}">
    </div>
    <div class="form-group col-md-4">
      <label>по умолчанию Бухгалтер</label>
      <input type="text" class="form-control" name="role_name4" placeholder="Бухгалтер" value="{{isset($accountant) ? $accountant->role_name : ''}}">
    </div>
    <div class="form-group col-md-4">
      <label>@lang('messages.id_and_tel')</label>
      <div class="input-group md-4">
        <div class="input-group-prepend">
          <span class="input-group-text">+7</span>
        </div>
        <input type="tel" class="form-control form-control-sm" name="tel4" value="{{isset($accountant) ? $accountant->telephone : ''}}" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __">
      </div>
      <label>ФИО</label>
      <input type="text" class="form-control form-control-sm" name="fio4" value="{{isset($accountant) ? $accountant->name : ''}}" required="required">
    </div>
  </div>
  <!-- FIFTH ROW -->
  <div class="form-row">
  	<div class="form-group col-md-4">
      <label>Описание</label>
      <input type="text" class="form-control" readonly="true" value="{{isset($storekeeper->description)  ? $storekeeper->description : ''}}">
    </div>
    <div class="form-group col-md-4">
      <label>по умолчанию Кладовщик</label>
      <input type="text" class="form-control" name="role_name5" value="{{isset($storekeeper) ? $storekeeper->role_name : ''}}" placeholder="Кладовщик">
    </div>
    <div class="form-group col-md-4">
      <label>@lang('messages.id_and_tel')</label>
      <div class="input-group md-4">
        <div class="input-group-prepend">
          <span class="input-group-text">+7</span>
        </div>
        <input type="tel" class="form-control form-control-sm" name="tel5" value="{{isset($storekeeper) ? $storekeeper->telephone : ''}}" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __">
      </div>
      <label>ФИО</label>
      <input type="text" class="form-control form-control-sm" name="fio5" value="{{isset($storekeeper) ? $storekeeper->name : ''}}" required="required">
    </div>
  </div>
  <!-- SIXTH ROW -->
  @if($mentors->isEmpty())
  <div class="form-row">
    <div class="form-group col-md-4">
      <label>Описание</label>
      <input type="text" class="form-control" readonly="true" value="Работа в группах">
    </div>
    <div class="form-group col-md-4">
      <label>Роль</label>
      <input type="text" class="form-control" name="role_name6" value="Воспитатель" readonly="true">
    </div>
    <div class="form-group col-md-4">
      <label>@lang('messages.id_and_tel')</label>
      <div class="input-group md-4">
        <div class="input-group-prepend">
          <span class="input-group-text">+7</span>
        </div>
        <input type="tel" class="form-control form-control-sm" name="tel6" required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __" value="+7">
      </div>
      <label>ФИО</label>
      <input type="text" class="form-control form-control-sm" name="fio6" required="required">
    </div>
  </div>
  @endif
  <!-- SEVEN ROW -->
  @if(!empty($mentors))
  @foreach($mentors as $mentor)
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputDesc">Описание</label>
      <input type="text" class="form-control" id="inputDesc" readonly="true" value="{{isset($mentor->description)  ? $mentor->description : ''}}">
    </div>
    <div class="form-group col-md-4">
      <label for="inputRole">Роль</label>
      <input type="text" class="form-control" id="inputRole" value="{{isset($mentor) ? $mentor->role_name : ''}}" readonly="true">
    </div>
    <div class="form-group col-md-4">
      <label for="inputTel">@lang('messages.id_and_tel')</label>
      <div class="input-group md-4">
        <div class="input-group-prepend">
          <span class="input-group-text">+7</span>
        </div>
        <input type="tel" class="form-control form-control-sm" id="inputTel" name="mentortel_{{$mentor->id}}" value="{{isset($mentor) ? $mentor->telephone : ''}}" required="true" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __">
      </div>
      <label for="inputFIO">ФИО</label>
      <input type="text" class="form-control form-control-sm" id="inputFIO" name="mentorfio_{{$mentor->id}}" value="{{isset($mentor) ? $mentor->name : ''}}" required="required">
    </div>
  </div>
  @endforeach
  @endif
  <!-- MODAL BUTTON -->
  <a id="modal-583626" href="#modal-container-583626" role="button" class="btn float-right btn-success" data-toggle="modal">@lang('messages.add_mentor')</a>
  <button type="submit" class="btn btn-primary">@lang('messages.submit')</button>
  <a href="{{url('manager')}}" class="btn btn-secondary">
			@lang('messages.back')
		</a>
</form>
 <!-- MODAL START -->    
      <div class="modal fade" id="modal-container-583626" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">
                @lang('messages.add_mentor')
              </h5> 
            </div>
            <div class="modal-body">
              <form role="form" method="post">
                @csrf
                <div class="form-group">
                  <label>@lang('messages.telephone')</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">+7</span>
                    </div>
                    <input type="tel" class="form-control" name="mentor_tel"required="required" data-mask="(000)000 00 00" data-mask-selectonfocus="true" placeholder="(___)__ __ __">
                  </div>
                  <label for="exampleInputFIO">
                    @lang('messages.fio')
                  </label>
                  <input type="text" class="form-control" id="exampleInputFIO" name="mentor_fio" required="required"/>
                </div>
                <button type="submit" class="btn btn-primary">
                  @lang('messages.add')
                </button>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>
  <!-- MODAL END -->
</div>
@stop