@extends('theme')
@section('content')
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-user"></i>
	            รายการฟอร์ม</h2>
	        </div>
	        <div class="pull-right">
	        	{!! Form::open(['method'=>'GET','url'=>'forms','role'=>'search']) !!}
				<div class="input-group">
				    <input type="text" class="form-control" name="search" placeholder="ค้นหา...">
				    <span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
				            <i class="fa fa-search"></i>
				        </button>
				    </span>
				</div>
				{!! Form::close() !!}
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
			<th>ชื่อฟอร์ม</th>
			<th>คำอธิบาย</th>
			<th width="17%">สิทธิ์ในฟอร์มคำถาม</th>
			<th width="17%">สิทธิ์ในฟอร์มคำตอบ</th>
			<!--<th width="7%">mark delete</th>-->
		</tr>
	@foreach ($data as $key => $idata)
		@if($idata['deletedBy'] == '')
			<tr>
				<td>
					<a href="{{ route('forms.show',$idata['objectId']) }}">
						{{ $idata['title'] }}
					</a>
				</td>
				<td>{{ $idata['formDescription'] }}</td>
				@if ($idata['questionForm'] == "")
					<td><center><span class="label label-danger">ไม่มี</span></center></td>
				@else
					<td><center>{{ $idata['questionForm'] }}</center></td>
				@endif
				@if ($idata['answerForm'] == "")
					<td><center><span class="label label-danger">ไม่มี</center></span></center></td>
				@else
					<td><center>{{ $idata['answerForm'] }}</td>
				@endif				
			</tr>
		@endif
	@endforeach
	
	</table>
	</section>
	</section>
</section>
<script src="{{asset('js/app.js')}}"></script>
@endsection
