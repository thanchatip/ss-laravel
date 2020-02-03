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
	            รายงานทั้งหมด
	            </h3>
	        </div>
	    </div>
	</div>
	<table class="table table-striped table-bordered m-b-none">
		<tr>
			<th>ชื่อฟอร์ม</th>
			<th>คำอธิบาย</th>
			<th width="40%"></th>
		</tr>
	@foreach ($forms as $key => $form)
	<tr>
		<td>{{ $form['title'] }}</td>
		<td>{{ $form['formDescription'] }}</td>
		<td>
			{!! Form::open(['method' => 'GET','url'=>array("$baseUrl/report/huaisan/download"),'class'=>'form-inline']) !!}
			<input type="hidden" value="20171018011853-529982333425753-1281522" name="idforms">
			<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
			<select name="sheetName" class="form-control" required>
				<option value="" selected disabled>เลือกชีท</option>
				<option value="sheetFacts">Factsheet</option>
				<option value="sheetSurveyStatus">สถานะการสำรวจ</option>
				<option value="sheetPopulation">ประชากร</option>
				<option value="sheetDataHome">ข้อมูลรายบ้าน,รายได้เทียบเส้นความยากจน</option>
				<option value="sheetIncome">รายได้</option>
				<option value="sheetRatioHouse">สัดส่วนครัวเรือน</option>
				<option value="sheetCost">ค่าใช้จ่าย</option>
				<option value="sheetAsset">ทรัพย์สิน</option>
				<option value="sheetLivestockValue">มูลค่าปศุสัตว์</option>
				<option value="sheetDebts">หนี้สิน</option>
				<option value="sheetPerson">บุคคล</option>
				<option value="sheetListPerson">ข้อมูลรายประชากร</option>
			</select>
			<select name="year" class="form-control" required>
				<option value="" selected disabled>เลือกปี</option>
				<option value="2018">ปี 2561</option>
				<option value="2019">ปี 2562</option>
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
	<br>
	<button data-toggle="collapse" class="btn btn-danger" data-target="#waringButton"> * สิ่งที่ไม่มีในบางSheet</button>
	<div id="waringButton" class="collapse">
		<font color="black" size="3">
			sheet สัดส่วนครัวเรือน <br>
			- ไม่มีสัดส่วน <br>

			sheet รายได้<br>  
			- ไม่มีรายได้อื่นๆของน้ำผึ้ง <br>
			- รายได้จากหัตถกรรม ไม่มีอื่นๆ ระบุ<br>
			- รายได้จากการค้าขายบริการ ไม่มีอื่นๆ ระบุ<br>
			- รายได้จากช่องทางอื่นๆ รายเดือน ไม่มีเบี้ยเด็กเล็ก<br>

			sheet ทรัพย์สิน<br>
			- เครื่องใช้ในบ้าน ไม่มีอื่นๆ ระบุ<br>
			- ค่าซื้อเครื่องจักการเกษตร ไม่มีอื่นๆ ระบุ<br>

			sheet ค่าใช้จ่าย<br>
			- ค่าเครื่องใช้ในบ้าน ไม่มีอื่นๆ ระบุ<br>
			- ค่าใช้จ่ายเบ็ดเตล็ดอื่นๆ ไม่มีค่าใช้จ่ายเบ็ดเตล็ดอื่นๆ<br>
			- ค่าซื้อเครื่องจัดการเกษตร ไม่มีอื่นๆ ระบุ<br>
		</font>
	</div>
	</section>
	</section>
</section>
@endsection
