@extends('layouts.app')

@section('content')

@include('includes.head-koordinator')

<div class="col-md-12">
	<div class="page-header">
		<h1>
			Show <small>{{$kindergarten->name}}</small>
		</h1>
	</div>
</div>
@stop