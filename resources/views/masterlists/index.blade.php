@extends('theme')
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-user"></i>จัดการประเภทรายการ</h2>
	        </div>
			@permission('create-masterlist')
	        <div class="dropdown pull-right">
	            <a class="btn btn-success" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus-square"></i>  เพิ่มประเภทรายการ</a>
			    <ul class="dropdown-menu animated fadeInRight">
			       	<li>
			            <span class="arrow top"></span>
			            <a href="{{ route('masterlists.create') }}">เพิ่มประเภทรายการ</a>
			        </li>
			        <li>
			            <a href="{{ URL::to('masterlists/import/csv') }}">นำเข้าประเภทรายการ</a>
			        </li>
			   	</ul>
	        </div>
			@endpermission
	        <div class="pull-right">
			</div>
		</div>
	</div>
		<hr>
	        	{!! Form::open(['method'=>'GET','url'=>'masterlists','role'=>'search']) !!}
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
		
	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif

	<table class="table table-striped table-bordered m-b-none">
		<tr>

			<th>ประเภทรายการ</th>
			<th>คำอธิบาย</th>
			<th width="200px"></th>
		</tr>
	@if(Auth::user()->firstname == 'admin')
		@foreach ($masterlists as $key => $masterlist)
		<tr>
			<td>{{ $masterlist['data']['title'] }}</td>
			<td>{{ $masterlist['data']['description'] }}</td>
			<td>
				<a class="btn btn-default" href="{{ route('masterlists.show',$masterlist['data']['objectId']) }}">
						<i class="fa fa-file-text-o"></i>
					</a>
					<a class="btn btn-default" href="{{ route('masterlists.edit',$masterlist['data']['objectId']) }}">
						<i class="fa fa-edit"></i>
					</a>
					{!! Form::open(['method' => 'DELETE','route' => ['masterlists.destroy', $masterlist['data']['objectId']],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
						{!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger']) !!}
					{!! Form::close() !!}
				
					<a class="btn btn-primary" href="{{ URL('masterlists/admin/access',$masterlist['data']['objectId'])}}">
						<i class="i i-user2"></i>
					</a>				
			</td>
		@endforeach
	@elseif(Auth::user()->firstname != 'admin')
	@foreach ($masterlists as $key => $masterlist)
	<tr>
		<td>{{ $masterlist['data']['title'] }}</td>
		<td>{{ $masterlist['data']['description'] }}</td>
		<td>
		@foreach($AuthMasterlists as $AuthMasterlist)
				@if($AuthMasterlist['masterlistRoleCode'] == '6' && $AuthMasterlist['masterList_id'] == $masterlist['data']['objectId'])
					<a class="btn btn-default" href="{{ route('masterlists.show',$masterlist['data']['objectId']) }}">
						<i class="fa fa-file-text-o"></i>
					</a>
					<a class="btn btn-default" href="{{ route('masterlists.edit',$masterlist['data']['objectId']) }}">
						<i class="fa fa-edit"></i>
					</a>
				@elseif($AuthMasterlist['masterlistRoleCode'] == '5' && $AuthMasterlist['masterList_id'] == $masterlist['data']['objectId'])
					<a class="btn btn-default" href="{{ route('masterlists.show',$masterlist['data']['objectId']) }}">
						<i class="fa fa-file-text-o"></i>
					</a>
					<a class="btn btn-default" href="{{ route('masterlists.edit',$masterlist['data']['objectId']) }}">
						<i class="fa fa-edit"></i>
					</a>
					{!! Form::open(['method' => 'DELETE','route' => ['masterlists.destroy', $masterlist['data']['objectId']],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
						{!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger']) !!}
					{!! Form::close() !!}
				
					<a class="btn btn-primary" href="{{ URL('masterlists/admin/access',$masterlist['data']['objectId'])}}">
						<i class="i i-user2"></i>
					</a>
				@elseif($AuthMasterlist['masterlistRoleCode'] == '7' && $AuthMasterlist['masterList_id'] == $masterlist['data']['objectId'])
					<a class="btn btn-default" href="{{ route('masterlists.show',$masterlist['data']['objectId']) }}">
						<i class="fa fa-file-text-o"></i>
					</a>
				@endif
			@endforeach
		</td>
	</tr>
	@endforeach
	@endif
	</table>
	@if(!empty($masterlists))
	{!! $masterlists->render() !!}
	@endif
	</section>
	</section>
</section>
@endsection