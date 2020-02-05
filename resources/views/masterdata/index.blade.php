@extends('theme')
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-user"></i>	จัดการประเภทรายการ</h2>
	        </div>
	        <div class="dropdown pull-right">
		        <div class="pull-right">
		            <a class="btn btn-success" href="{{ URL::to('masterdata/create') }}"><i class="fa fa-plus-square"></i>  เพิ่มข้อมูล</a>
		        </div>
	        </div>
	    </div>
	</div>
		<hr>
	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif
	<table class="table table-striped table-bordered m-b-none">
		<tr>
			<th>รายการ</th>
			<th width="15%"></th>
		</tr>
		@foreach ($masterdata as $masterdatum)
		<tr>
			<td> {{ $masterdatum['title'] }} </td>
			<td>
				<a class="btn btn-default" href="{{ route('masterdata.show',$masterdatum['objectId']) }}">
					<i class="fa fa-file-text-o"></i>
				</a>
				<a class="btn btn-primary" href="{{ URL('masterdata/admin/access',$masterdatum['objectId'])}}">
					<i class="i i-user2"></i>
				</a>
				{!! Form::open(['method' => 'DELETE','route' => ['masterdata.destroy', $masterdatum['objectId']],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
				{!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger','data-toggle'=>'tooltip','placement'=>'top','title'=>'ลบข้อมูล']) !!}
				{!! Form::close() !!}				
			</td>
		</tr>
		@endforeach
	</table>
	</section>
	</section>
</section>
@endsection