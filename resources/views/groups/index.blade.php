@extends('theme')

@section('content')

<section class="vbox bg-white">
	<section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-key"></i>
	            จัดการกลุ่มผู้ใช้</h2>
	        </div>
			@permission('create-group')
	        <div class="pull-right">
	            <a class="btn btn-success" href="{{ URL::to('groups/create') }}"><i class="fa fa-plus-square"></i>  เพิ่มกลุ่ม</a>
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
	    {!! Form::open(['method'=>'GET','url'=>'groups','role'=>'search']) !!}
		<div class="input-group">
			<input type="text" class="form-control" name="search" placeholder="ค้นหา...">
			<span class="input-group-btn">
				<button class="btn btn-default" type="submit">
				        <i class="fa fa-search"></i>
				</button>
			</span>
		</div>
	{!! Form::close() !!}
	<br/>
	<table class="table table-striped table-bordered m-b-none">
		<tr>
			<th>ชื่อกลุ่ม</th>
			<th>คำอธิบาย</th>
			<th class="text-center" width="140px">จำนวนสมาชิก</th>
			<th width="150px"></th>
		</tr>
	@if(!empty($data))
		@foreach ($data as $key => $group)
			@if($group->deleted_at == '')
				<tr>
					<td>{{ $group->name }}</td>
					<td>{{ $group->description }}</td>
					<td class="text-center">{{ $group->users->count() }}</td>
					<td>
					@permission('view-group')
						<a class="btn btn-default" href="{{ route('groups.show',$group->id) }}"><i class="fa fa-file-text-o"></i></a>
					@endpermission
					@permission('edit-group')
						<a class="btn btn-default" href="{{ route('groups.edit',$group->id) }}"><i class="fa fa-edit"></i></a>
					@endpermission	
					@permission('delete-group')
						{!! Form::open(['method' => 'DELETE','route' => ['groups.destroy', $group->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
			            {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger']) !!}
			        	{!! Form::close() !!}
					@endpermission
					</td>
				</tr>
			@endif
		@endforeach
	@endif
	</table>

	{!! $data->render() !!}
	</section>
</section>
</section>
@endsection