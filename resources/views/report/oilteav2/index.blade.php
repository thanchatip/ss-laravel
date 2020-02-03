@extends('theme')
@section('content')
<link rel="stylesheet" href="{{asset('theme/css/daterangepicker.css')}}" type="text/css" />
<style type="text/css">

</style>
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
		<div class="btn-group">
		    <button type="button" class="btn btn-dark" disabled>Menu</button>
		    <button type="button" class="btn btn-default active"><a href="{{ url('/report/oilteav2/index') }}">Report</a></button>
		    <button type="button" class="btn btn-default"><a href="{{ url('/report/oilteav2/validate') }}">Check Data</a></button>
		</div>
		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div class="pull-left">
					<h2><i class="fa fa-user"></i>
						รายงาน {{ $forms[0]['title'] }}
					</h2>
					<a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > 
					<a href="{{ route('forms.show',$forms[0]['objectId']) }}"><u>{{ $forms[0]['title'] }}</u></a> > 
					<a href="{{ URL('report',$forms[0]['objectId']) }}"><u>รายงาน</u></a> > CUSTOM REPORT
				</div>
				<div class="pull-right">
					<a class="btn btn-default" href="{{ URL('report',$forms[0]['objectId']) }}">
					<i class="fa fa-backward"></i> กลับ</a>
				</div>
			</div>
		</div>
		<hr>
	@if (Session::has('message'))
   		<div class="alert alert-danger">{{ Session::get('message') }}</div>
  	@endif
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h3><i class="fa fa-file-text-o"></i>
	            เลือกรายงานตามวันที่
	            </h3>
	        </div>
	    </div>
	</div>
{!! Form::open(['method' => 'GET','url'=>array("$baseUrl/report/oilteav2/download"),'class'=>'form-inline','id'=>'formsdate']) !!}

			    <div class="form-group">
					<input type="hidden" name="sheetName" value="rawdata">
					<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
					<input type="hidden" value="{{Auth::user()->email}}" name="userEmail">
					<select name="idforms" id="selectform" class="form-control" required>
						  <option value="" selected disabled>เลือกรายงาน</option>
						  @foreach ($forms as $form)
						  <option value="{{ $form['objectId'] }}" selected>{{ $form['title'] }}</option>
						  @endforeach
					</select>
					<label>StartDate : </label>
					<input name="dateRange" id="dateRange"  class="input-md form-control" onkeydown="return false" size="16" type="text" value="" required>
				</div>
				@if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
				<button class="btn btn-default form-control" type="submit" value="Submit">
				@else 
				<button class="btn btn-default form-control" type="submit" value="Submit" disabled>
				@endif
					<i class="i i-file-excel"></i>
					Export
				</button>
		
{!! Form::close() !!}	
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h3><i class="fa fa-file-text-o"></i>
	            รายงานทั้งหมด
	            </h3>
	        </div>
	    </div>
	</div>
	<table class="table table-striped table-bordered m-b-none">
		<tr>
			<th>ชื่อฟอร์ม</th>
			<th>คำอธิบาย</th>
			<th width="20%"></th>
		</tr>
	@foreach ($forms as $key => $form)
	<tr>
		<td>{{ $form['title'] }}</td>
		<td>{{ $form['formDescription'] }}</td>
		<td>
			{!! Form::open(['method' => 'GET','id'=>'formReport','class'=>'form-inline']) !!}
			<meta name="csrf-token" content="{{ csrf_token() }}" />
			<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
			<input type="hidden" value="{{Auth::user()->email}}" name="userEmail">
			<select name="sheetName" class="form-control" required>
				<option value="" selected disabled>เลือกชีท</option>
				<option value="rawdata">ข้อมูลดิบ</option>
				<option value="summarydata">ข้อมูลสรุป</option>
			</select>
			@if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
			<button class="btn btn-default form-control" type="submit" value="Submit">
			@else 
			<button class="btn btn-default form-control" type="submit" value="Submit" disabled>
			@endif
				<i class="i i-file-excel"></i>
				Export
			</button>
			{!! Form::close() !!} 				
		</td>
	</tr>
	@endforeach
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
		url: baseUrl + "/report/oilteav2/download",
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
