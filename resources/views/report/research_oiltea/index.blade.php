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

		<strong><h2>โครงการสำรวจและวิจัยชาน้ำมัน</h2></strong>
					<p><b><u>คำแนะนำ</u></b></p>
					<p>1. เลือกหมู่บ้าน</p>
					<p>2. กดปุ่ม "ส่ง"</p>
					<p>3. เมื่อกดปุ่ม "ส่ง" สามารถปิดหน้านี้ได้ทันที ระบบจะสร้างรายงานแล้วส่งให้ทางอีเมล์เมื่อรายงานเสร็จ</p>
					{!! Form::open(['method' => 'POST','id'=>'formReport','class'=>'form-inline']) !!}
						<meta name="csrf-token" content="{{ csrf_token() }}" />
						<input type="hidden" value="{{Auth::user()->_id}}" name="userId">
						<input type="hidden" value="{{Auth::user()->email}}" name="userEmail">
						<select name="zone" class="form-control" required>
							<option value="" selected disabled>เลือกชีท</option>
							<option value="puna">ปูนะ</option>
							<option value="pangmahun">ปางมะหัน</option>
						</select>
						@if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
						<button class="btn btn-primary form-control" type="submit" value="Submit">
						@else 
						<button class="btn btn-primary form-control" type="submit" value="Submit" disabled>
						@endif
							ส่ง
						</button>
				{!! Form::close() !!} 
			<div class="col-lg-7 col-lg-offset-3">

			</div><!-- /.col-lg-4 -->
			<div class="col-lg-4 col-lg-offset-4">

			</div>

	</section>
	</section>
</section>
<script>
$("#formReport").submit(function(event){
	var baseUrl = {!! json_encode($baseUrl) !!};
	event.preventDefault();
	var $form = $(this);
	var $inputs = $form.find("input, select, button, textarea");
	var serializedData = $form.serialize();

	request = $.ajax({
		url: baseUrl + "/report/researchoiltea/download",
		type: "get",
		data: serializedData
	});

	alert('ระบบจะทำการส่งรายงานให้ทางอีเมล์เมื่อรายงานเสร็จแล้ว')
	
	/*request.done(function (response, textStatus, jqXHR){
		
	});*/
});
</script>
@endsection
