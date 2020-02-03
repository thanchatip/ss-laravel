@extends('theme')

@section('content')

<section class="vbox bg-white">
	<section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-key"></i>
	            จัดการสิทธิ์การใช้งาน</h2>
	        </div>
			@permission('create-role')
	        <div class="pull-right">
	            	<a class="btn btn-success" href="{{ route('roles.create') }}">
	            	<i class="fa fa-pencil"></i> เพิ่มสิทธิ์การใช้งาน</a>
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
			<th>ชื่อสิทธิ์</th>
			<th>คำอธิบาย</th>
			<th>การอนุญาต</th>
			<th width="150px"></th>
		</tr>

	@foreach ($roles as $key => $role)
	<tr>
		<td>{{ $role->display_name }}</td>
		<td>{{ $role->description }}</td>
		<td>
			@if(!empty($role->perms))
				@foreach($role->perms as $v)
					<span class="label label-default label-sm">{{ $v->display_name }}</span>
				@endforeach
			@endif
		</td>
		<td>
		@permission('view-role')
			<a class="btn btn-default" href="{{ route('roles.show',$role->id) }}"><i class="fa fa-file-text-o"></i></a>
		@endpermission
		@permission('edit-role')
			<a class="btn btn-default" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-edit"></i></a>
		@endpermission
		@permission('delete-role')
			{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
            {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger']) !!}
        	{!! Form::close() !!}
		@endpermission
		</td>
	</tr>

	@endforeach

	</table>

	{!! $roles->render() !!}
	</section>
</section>
</section>
@endsection