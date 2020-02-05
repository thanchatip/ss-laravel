@extends('theme')
@section('content')
<style>
/* .tooltip {
  font-size: 1em;
} */
</style>
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-user"></i>	จัดการข้อมูลผู้ใช้</h2>
	        </div>
			@permission('create-user')
	        <div class="dropdown pull-right">
	            <a class="btn btn-success" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus-square"></i>  เพิ่มผู้ใช้</a>
			    <ul class="dropdown-menu animated fadeInRight">
			       	<li>
			            <span class="arrow top"></span>
			            <a href="{{ route('users.create') }}">เพิ่มผู้ใช้</a>
			        </li>
			        <li>
			            <a href="{{ URL::to('import/users') }}">นำเข้าผู้ใช้ (.CSV)</a>
			        </li>
			   	</ul>
	        </div>
			@endpermission
	        <div class="pull-right">
	        </div>
	    </div>
	</div>
		<hr>
	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>  
	@elseif (Session::has('message'))
   		<div class="alert alert-danger">{{ Session::get('message') }}</div>
	@endif
    {!! Form::open(['method'=>'GET','url'=>'users','role'=>'search']) !!}
		<div class="input-group">
			<input type="text" class="form-control" name="search" placeholder="Search...">
			<span class="input-group-btn">
				<button class="btn btn-default" type="submit">
				    <i class="fa fa-search"></i>
				</button>
			</span>
		</div>
	{!! Form::close() !!}
	<br>
	<table class="table table-striped table-bordered m-b-none">
		<tr>
			<th>รหัสพนักงาน</th>
			<th>ชื่อผู้ใช้</th>
			<th>ชื่อ-สกุล</th>
			<th>แผนก</th>
			<th>ตำแหน่ง</th>
			<th>กลุ่ม</th>
			<th width="150px">			
				<a class="btn btn-primary form-control" href="{{ url('/export/users')}}"> Export Users</a>
			</th>
		</tr>
	@foreach ($users as $key => $user)
	@if($user->deleted_at == '')
	<tr>
		<td>{{ $user->code }}</td>
		<td>{{ $user->email }}</td>
		<td>{{ $user->prefix }} {{ $user->firstname }} {{ $user->lastname }}</td>
		<td>{{ $user->department }}</td>
		<td>{{ $user->position }}</td>
		<td>
		@if(!empty($user['group_ids']))
			@foreach($user['group_ids'] as $v)
				@foreach($groups as $vgroup)
					@if(Auth::user()->firstname == 'admin' && $v == $vgroup['_id'])
						<span class="label label-default label-sm">{{ $vgroup['name'] }}</span><br>
					@else
					@foreach($adminGroup as $adminGroups)
						@if($v == $vgroup['_id'] && $adminGroups == $vgroup['_id'])	
							<span class="label label-default label-sm">{{ $vgroup['name'] }}</span><br>
						@endif
					@endforeach
					@endif
				@endforeach
			@endforeach
		@endif
		</td>
		<td>
		@permission('view-user')
			<a href="{{ route('users.show',$user->id) }}">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="ข้อมูลผู้ใช้">
					<i class="fa fa-file-text-o"></i>
				</button>
			</a>
		@endpermission
		@permission('edit-user')
			<a href="{{ route('users.edit',$user->id) }}">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="แก้ไขข้อมูล">
					<i class="fa fa-edit"></i>
				</button>
			</a>
		@endpermission
		@permission('delete-user')
			{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
            {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger','data-toggle'=>'tooltip','placement'=>'top','title'=>'ลบข้อมูล']) !!}
        	{!! Form::close() !!}
		@endpermission
		</td>
	</tr>
	@endif
	@endforeach
	</table>

	{!! $users->render() !!}
	</section>
	</section>
</section>
@endsection