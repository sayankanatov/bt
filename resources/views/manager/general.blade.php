@extends('layouts.app')

@section('content')
<div class="col-md-12">
      @include('includes.head-manager')  
</div>
<div class="col-md-12">
	<div class="page-header">
		<h3>
			@lang('messages.general_info')
		</h3>
	</div>

	<form role="form" action="{{action('ManagerController@storeGeneral',['id' => $kindergarten->kindergarten_id])}}" method="post">
		@csrf
		<div class="form-group row">				 
			<label class="col-2 col-form-label">
				Наименование
			</label>
			<div class="col-10">
				<select class="form-control" name="kindergarten_category">
				@foreach($categories as $category)
			    	<option value="{{$category}}" {{($kinder_info->category == $category ? 'selected' : '')}}>{{$category}}</option>
			    @endforeach
			</select>
			</div>
		</div>
		@if(!empty($kindergarten_types))
		<div class="form-group row">
			<label for="sel1" class="col-2 col-form-label">Тип</label>
			<div class="col-10">
			<select class="form-control" name="kindergarten_types">
				@foreach($kindergarten_types as $type)
			    	<option value="{{$type->title}}" {{($kinder_info->type == $type->title ? 'selected' : '')}}>{{$type->title}}</option>
			    @endforeach
			</select>
			</div>
		</div>
		@endif
		<div class="form-group row">	
			<label for="exampleInputNum" class="col-2 col-form-label">
				№
			</label>
			<div class="col-10">
				<input type="text" class="form-control" id="exampleInputNum" value="{{$kindergarten->num}}" readonly="true"/>
			</div>
		</div>
		<div class="form-group row">
			<label for="exampleInputName" class="col-2 col-form-label">
				Название
			</label>
			<div class="col-10">
				<input type="text" class="form-control" id="exampleInputName" value="{{$kindergarten->name}}" readonly="true"/>
			</div>
		</div>
		<!-- <h4>
			Реквизиты
		</h4>
		<div class="form-group row">	
			<label for="exampleInputIIK" class="col-2 col-form-label">
				ИИК
			</label>
			<div class="col-10">
				<input type="text" class="form-control" value="{{$kinder_info->iik}}" id="exampleInputIIK" name="iik" required="required" />
			</div>
		</div>
		@if(!empty($banks))
		<div class="form-group row">
			<label for="sel1" class="col-2 col-form-label">Банк</label>
			<div class="col-10">
			<select class="form-control" name="bank">
				@foreach($banks as $bank)	
			    	<option value="{{$bank->title}}" {{($kinder_info->bank == $bank->title ? 'selected' : '')}}>{{$bank->title}}</option>
			    @endforeach
			</select>
			</div>
		</div>
		@endif
		<div class="form-group row">	
			<label for="exampleInputBIN" class="col-2 col-form-label">
				БИН
			</label>
			<div class="col-10">
				<input type="text" class="form-control" id="exampleInputBIN" value="{{$kinder_info->bin}}" name="bin" required="required"/>
			</div>
		</div> -->
		<h4>
			Контакты
		</h4>
		
		<div class="form-group row" style="display: none;">
			<label class="col-2 col-form-label">Область</label>
			<div class="col-10">
				<input type="hidden" class="form-control" name="region" value="{{$kindergarten->region_ru}}" readonly="true" />
			</div>
		</div>
		
		<div class="form-group row">	
			<label for="exampleInputCity" class="col-2 col-form-label">
				Город
			</label>
			<div class="col-10">
				<input type="text" class="form-control" id="exampleInputCity" name="city" value="{{$kindergarten->description}}" readonly="true" />
			</div>
		</div>
		
		<div class="form-group row">	
			<label for="exampleInputAddress" class="col-2 col-form-label">
				Адрес
			</label>
			<div class="col-10">
				<input type="text" class="form-control" id="exampleInputAddress" value="{{$kinder_info->address}}" name="address" required="required"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-2 col-form-label">
				Тел/Факс
			</label>

			<div class="input-group col-10">
			  <div class="input-group-prepend">
			    <span class="input-group-text">+7</span>
			  </div>
			  <input type="tel" class="form-control phone_with_ddd" data-mask="(0000)00 00 00" data-mask-selectonfocus="true" placeholder="(____)__ __ __" aria-label="(____)__ __ __" value="{{isset($kindergarten->telephone) ? $kindergarten->telephone : $kindergarten->tel_code}}" name="telephone">
			</div>

		</div>
		<div class="form-group row">
			<label for="exampleInputEmail" class="col-2 col-form-label">
				E-mail
			</label>
			<div class="col-10">
				<input type="text" class="form-control" id="exampleInputEmail" value="{{$kindergarten->email}}" name="email" readonly="true"/>
			</div>
		</div>
		@if(!empty($kindergarten_langs))
		<div class="form-group row">
			<label for="sel1" class="col-2 col-form-label">Язык обучения</label>
			<div class="col-10">
			<select class="form-control" name="lang">
				@foreach($kindergarten_langs as $lang)	
			    	<option value="{{$lang->title}}" {{($kinder_info->lang == $lang->title ? "selected" : " ")}}>{{$lang->title}}</option>
			    @endforeach
			</select>
			</div>
		</div>
		@endif
		<h4>
			Режим работы
		</h4>
		
		<div class="form-group row">
			<label for="sel1" class="col-2 col-form-label">Начало</label>
			<div class="col-10">
			<select class="form-control" name="worktime_start">
			@isset($worktime_start)
				@foreach($worktime_start as $key => $value)	
			    	<option value="{{$key}}" {{($kinder_info->worktime_start == $key ? "selected" : " ")}}>{{$value}}</option>
			    @endforeach
			@endisset
			</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="sel1" class="col-2 col-form-label">Конец</label>
			<div class="col-10">
			<select class="form-control" name="worktime_end">
			@isset($worktime_end)
				@foreach($worktime_end as $key => $value)	
			    	<option value="{{$key}}" {{($kinder_info->worktime_end == $key ? "selected" : " ")}}>{{$value}}</option>
			    @endforeach
			@endisset
			</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="sel1" class="col-2 col-form-label">Время окончания приема детей</label>
			<div class="col-10">
			<select class="form-control" name="child_reception">
			@isset($worktime_end)
				@foreach($child_reception as $key => $value)	
			    	<option value="{{$key}}" {{($kinder_info->child_reception == $key ? "selected" : " ")}}>{{$value}}</option>
			    @endforeach
			@endisset
			</select>
			</div>
		</div>
		
		<div class="form-group row">
			<label for="exampleInputGroup" class="col-2 col-form-label">Количество групп</label>
			<div class="col-10">
			<input type="number" class="form-control" id="exampleInputGroup" value="{{$kinder_info->group_count}}" name="group_count" required="required"/>
			</div>
		</div>
		
		<div class="form-group row">	
			<label for="exampleInputCapacity" class="col-2 col-form-label">
				Проектная мощность
			</label>
			<div class="col-10">
				<input type="number" class="form-control" id="exampleInputCapacity" name="project_capacity" value="{{$kinder_info->project_capacity}}" required="required"/>
			</div>
		</div>

		<button type="submit" class="btn btn-primary">
			@lang('messages.submit')
		</button>
		<a href="{{url('manager')}}" class="btn btn-secondary">
			@lang('messages.back')
		</a>
	</form>
</div>

@stop