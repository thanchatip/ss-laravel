@extends('theme')
@section('content')
<style type="text/css">
	input[type=date]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    display: none;

	}
</style>
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
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
{!! Form::open(['method' => 'GET','url'=>array("$baseUrl/report/macca/download"),'class'=>'form-inline','id'=>'formsdate']) !!}
			<div class="pull-left">
			    <div class="form-group">
					<select name="idforms" id="selectform" class="form-control m-b" required>
						  <option value="" selected disabled>เลือกรายงาน</option>
						  @foreach ($forms as $form)
						  <option value="{{ $form['objectId'] }}" selected>{{ $form['title'] }}</option>
						  @endforeach
					</select>
					<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
					<label>StartDate : </label>
				  	<input name="startdate" id="start"  class="input-md datepicker-input form-control m-b" 
				   	onkeydown="return false" required size="16" type="text" data-date-format="yyyy-mm-dd">
					<label>EndDate : </label>
				  	<input name="enddate" id="end" class="input-md datepicker-input form-control m-b" 
				   	onkeydown="return false" required size="16" type="text" data-date-format="yyyy-mm-dd">
				</div>
				@if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2') 
					<button class="btn btn-default form-control m-b" type="submit" form="formsdate" value="Submit">
				@else
					<button class="btn btn-default form-control m-b" type="submit" form="formsdate" value="Submit" disabled>
				@endif
					<i class="i i-file-excel"></i>
						Export
					</button>
			</div>
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
			{!! Form::open(['method' => 'GET','url'=>array("$baseUrl/report/macca/download"),'class'=>'form-inline']) !!}
			<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
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
@endsection
