@extends('theme')
@section('content')
<link rel="stylesheet" href="{{asset('theme/css/daterangepicker.css')}}" type="text/css" />
<style type="text/css">

</style>
<section class="vbox bg-white">
	<section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div class="pull-left">
					<h2><i class="fa fa-user"></i>
						รายงานฟอร์มเก็บข้อมูลสำรวจป่า
					</h2>
					<a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > 
					<a href="{{ route('forms.show',$masterForms['data']['objectId']) }}"><u>{{ $masterForms['data']['title'] }}</u></a> > 
					<a href="{{ URL('report',$masterForms['data']['objectId']) }}"><u>รายงาน</u></a> > CUSTOM REPORT
				</div>
				<div class="pull-right">
					<a class="btn btn-default" href="{{ URL('report',$masterForms['data']['objectId']) }}">
					<i class="fa fa-backward"></i> กลับ</a>
				</div>
			</div>
		</div>
		<hr>
			{!! Form::open(['method' => 'GET','url'=>array("$baseUrl/report/forestSurvey/export"),'class'=>'form-inline','id'=>'formsdate']) !!}
			
			    <div class="form-group">
					<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
					<select name="formId" id="selectform" class="form-control" required>
						  <option value="" selected disabled>เลือกรายงาน</option>

					</select>
					<label>เลือกจากวันที่สร้าง : </label>
					<input name="dateRange" id="dateRange"  class="input-md form-control" onkeydown="return false" size="16" type="text" value="" required>
				</div>
					<button class="btn btn-default form-control" type="submit" value="Submit">
					<i class="i i-file-excel"></i>
					Export
				</button>
			
			{!! Form::close() !!}
			<h3><i class="fa fa-file-text-o"></i>
	            รายงานข้อมูลดิบ
	            </h3>
		<table class="table table-striped table-bordered m-b-none">
			<tr>
				<th>ชื่อฟอร์ม</th>
				<th width="15%"></th>
			</tr>
		<tr>
		{!! Form::open(['method' => 'GET','id'=>'formReport','class'=>'form-inline']) !!}
			<td>
				<select name="formId" id="selectform" class="form-control" required>
					<option value="" selected disabled>เลือกรายงาน</option>
					@foreach ($forms as $form)
						@if ($form['rolesCode'] == 'admin' || $form['rolesCode']['questionFormRoleCode'] == '0' || $form['rolesCode']['answerFormRoleCode'] == '2')
							<option value="{{ $form['objectId'] }}">{{ $form['title'] }}</option>
						@else
							<option value="{{ $form['objectId'] }}" disabled>{{ $form['title'] }}</option>
						@endif
					@endforeach
				</select>
			</td>
			<td>
				
				<meta name="csrf-token" content="{{ csrf_token() }}" />
				<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
				<button class="btn btn-default form-control" type="submit" value="Submit">
					<i class="i i-file-excel"></i>
					Send Email
				</button>				
			</td>
		{!! Form::close() !!} 
		</tr>
		</table>
	</section>
	</section>
</section>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>

<script>
$('#dateRange').daterangepicker();
$("#formReport").submit(function(event){
	var baseUrl = {!! json_encode($baseUrl) !!};
	event.preventDefault();
	var $form = $(this);
	var $inputs = $form.find("input, select, button, textarea");
	var serializedData = $form.serialize();
	
	request = $.ajax({
		url: baseUrl + "/report/forestSurvey/download",
		type: "get",
		data: serializedData
	});

	alert('ไฟล์จะถูกส่งเข้าเมลของคุณประมาณ 10-15 นาที')
	
	/*request.fail(function (jqXHR, textStatus, errorThrown){
		alert("เกิดข้อผิดพลาดบางอย่าง กรุราติดต่อทีมงาน")
	});*/

	/*request.done(function (response, textStatus, jqXHR){
		
	});*/
});
</script>
@endsection
