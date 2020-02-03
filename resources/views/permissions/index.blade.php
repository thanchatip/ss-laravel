@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-lock"></i>
	            จัดการการอนุญาตให้แก่สิทธิ์</h2>
	        </div>
			@permission('create-permission')
	        <div class="pull-right">
	            <a class="btn btn-success" href="{{ route('permissions.create') }}">
	            <i class="fa fa-pencil"></i> เพิ่มการอนุญาตให้แก่สิทธิ์</a>
	        </div>
			@endpermission
	    </div>
	</div>

	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif
		<hr>
	<table class="table table-striped table-bordered m-b-none">
		<tr>
			<th>การอนุญาต</th>
			<th>คำอธิบาย</th>
			<th width="150px"></th>
		</tr>

	@foreach ($permissions as $key => $permission)
	<tr>
		<td>{{ $permission->name }}</td>
		<td>{{ $permission->description }}</td>
		<td>
		@permission('view-permission')
			<a class="btn btn-default" href="{{ route('permissions.show',$permission->id) }}"><i class="fa fa-file-text-o"></i></a>
		@endpermission
		@permission('edit-permission')
			<a class="btn btn-default" href="{{ route('permissions.edit',$permission->id) }}"><i class="fa fa-edit"></i></a>
		@endpermission
		@permission('delete-permission')	
			{!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
            {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger']) !!}
        	{!! Form::close() !!}
		@endpermission
		</td>
	</tr>

	@endforeach

	</table>

	{!! $permissions->render() !!}
	</section>
	</section>
</section>
@endsection