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
{!! Form::open(['method' => 'POST','action'=>array('CustomizeExcel\oiltea\RawdataController@SelectConfig'),'class'=>'form-inline','id'=>'formsdate']) !!}
			<div class="pull-left">
			    <div class="form-group">
					<select name="idforms" id="selectform" class="form-control m-b" required>
						  <option value="" selected disabled>เลือกรายงาน</option>
						  @foreach ($forms as $key => $form)
						  		<option value="{{ $form['objectId'] }}">{{ $form['title'] }}</option>
						  @endforeach
					</select>
					<select name="zone" id="selectzone" class="form-control m-b" required>
						  <option value="" selected disabled>เลือกโซน</option>
						  <option value="ปูนะ">ปูนะ</option>
						  <option value="ปางมะหัน">ปางมะหัน</option>
					</select>
					<label>StartDate : </label>
				  	<input name="startdate" id="start"  class="input-md datepicker-input form-control m-b" 
				   	onkeydown="return false" required size="16" type="text" data-date-format="yyyy-mm-dd">
					<label>EndDate : </label>
				  	<input name="enddate" id="end" class="input-md datepicker-input form-control m-b" 
				   	onkeydown="return false" required size="16" type="text" data-date-format="yyyy-mm-dd">
				</div>

				<button class="btn btn-default form-control m-b" type="submit" form="formsdate" value="Submit">
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
			<th width="18%"></th>
		</tr>
	@foreach ($forms as $key => $form)
	<tr>
		<td>{{ $form['title'] }}</td>
		<td>{{ $form['formDescription'] }}</td>
		@if($form['objectId'] == '20170923133340-527866420224209-1749826')
			<td>
				{!! Form::open(['method' => 'POST','action'=>array('CustomizeExcel\oiltea\RawdataController@Oilteadata'),'class'=>'form-inline']) !!}
				<input type="hidden" name="idforms" value="{{ $form['objectId'] }}">
				<select name="type" class="form-control" required>
					<option value="" selected disabled>ประเภท</option>
					<option value="rawdata">ข้อมูลรวม</option>
					<option value="summary">ข้อมูลสรุป</option>
				</select>
				<button class="btn btn-default form-control" type="submit" value="Submit">
				<i class="i i-file-excel"></i>
					Export
				</button>
				{!! Form::close() !!} 				
			</td>
		@else			
			<td>
				{!! Form::open(['method' => 'POST','action'=>array('CustomizeExcel\oiltea\RawdataController@SelectConfig'),'class'=>'form-inline']) !!}
				<input type="hidden" name="idforms" value="{{ $form['objectId'] }}">
				<select name="zone" class="form-control" required>
					<option value="" selected disabled>เลือกโซน</option>
					<option value="ปูนะ">ปูนะ</option>
					<option value="ปางมะหัน">ปางมะหัน</option>
				</select>
				<button class="btn btn-default form-control" type="submit" value="Submit">
				<i class="i i-file-excel"></i>
					Export
				</button>
				{!! Form::close() !!} 				
			</td>		
		@endif
	</tr>
	@endforeach
	</table>

	</section>
	</section>
</section>
<script type="text/javascript">
	$( document ).ready(function() {
		$('#selectzone').hide().prop('required',false);
		$('#selectform').change(function () {
		    var formId = $(this).val();
		    var formName = $('option:selected', this).text(); //to get selected text
		    if(formId == '20170923133340-527866420224209-1749826') {
		    	$('#selectzone').hide().prop('required',false);
		    	$('#selectzone').prop('selectedIndex',0);
		    }
		    else {
		    	$('#selectzone').show().prop('required',true);
		    }
		});
	});
</script>
@endsection
