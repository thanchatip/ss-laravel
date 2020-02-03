@extends('theme')
@section('content')
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
		<div class="m-b-sm">
		    <div class="btn-group btn-group-justified">
		        <a href="#" class="btn btn-primary disabled"><font size="4">USERS</font></a>
		    	<a href="{{ URL('forms/admin/group/access',$formData[0]['objectId']) }}" class="btn btn-default"><font size="4">GROUPS</font></a>
		    </div>
		</div>
<div class="tab-content">
	{!! Form::open(array('URL' => 'forms/admin/access/{formId}','method'=>'POST')) !!}
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-user"></i>
	            รายชื่อผู้มีสิทธิ์เข้าถึงฟอร์ม : {{ $formData[0]['title'] }}</h2>
	        </div>
			<div class="pull-right">
				<a class="btn btn-default" href="{{ route('forms.show',$formData[0]['objectId']) }}">
				<i class="fa fa-backward"></i> กลับ</a>
			</div>
	    </div>
	</div>
		<hr>
	@if (Session::has('message'))
   		<div class="alert alert-danger">{{ Session::get('message') }}</div>
  	@endif
	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif

<!--table user access-->
	<table class="table table-responsive no-bordered m-b-none">
		<thead>
		<tr>
			<th width="40%">
				<h4>
				{!! Form::open(['method'=>'GET','url'=>'/forms/admin/access','role'=>'search']) !!}
				<div class="input-group col-lg-12" >
					<input type="text" class="typeahead form-control no-border" name="query" placeholder="Name...." >
				</div>
				
				</h4>
			</th>
			<th>
				<div id="alertQuestionRoles">
				</div>
				<h4>
					สิทธิ์ในฟอร์มคำถาม: 
					<select id="questionFormRoleCode" name="questionFormRoleCode" class="form-control">
					 	<option value="">กรุณาเลือกสิทธิ์</option>
				    	@foreach($questionRoleCode as $key => $questionRole)
					 		<option value="{{$questionRole['roleCode']}}">{{$questionRole['display_name']}}
					 		</option>
						@endforeach
					</select>
				</h4>
			</th>
			<th>
				<div id="alertAnswerRoles">
				</div>
				<h4>
					สิทธิ์ในฟอร์มคำตอบ:
					<select width="100px" id="answerFormRoleCode" name="answerFormRoleCode" class="form-control">
						<option value="">กรุณาเลือกสิทธิ์</option>
				    	@foreach($answerRoleCode as $key => $answerRole)
					 	<option value="{{$answerRole['roleCode']}}">{{$answerRole['display_name']}}
					 	</option>
						@endforeach
					</select>
				</h4>
			</th>
			<th>
				<h4>
					<button type="submit" class="btn btn-success">
	            		เพิ่มสิทธิ์  <i class="i i-plus2"></i>
	            	</button>
	            </h4>
			</th>
		</tr>
		</thead>
	</table>
	<br>
	{!! Form::close() !!}
	<table class="table table-responsive no-table-bordered m-b-none">

	@foreach ($users as $key => $user)
		@if(!empty($user->form_ids[0]['form_id']))
			@foreach($user->form_ids as $form)
				@if($form['form_id'] == $formId)
				@if($form['answerFormRoleCode'] != '' || $form['questionFormRoleCode'] != '')
	<tr>
		<td>{{ $user->code }}</td>
		<td>
			<a href="{{ route('users.show',$user->_id) }}">
			{{ $user->prefix }} {{ $user->firstname }} {{ $user->lastname }} <br>({{ $user->email }})
			</a>
		</td>
		@foreach($questionRoleCode as $key => $questionRole)
			<td width="100px">
		{!! Form::open(['method' => 'POST','action' => array('FormsController@updateAccessQuestion', $formId,$user->id)]) !!}
			@if(Auth::user()->_id == '58fd6cc13fd89d8b529e4acf')
				<input name="questionFormRoleCode" value="{{$questionRole['roleCode']}}" type="hidden">
				@if($questionRole['roleCode'] == $form['questionFormRoleCode'])
					<button class="btn btn-sm btn-primary" type="submit">{{$questionRole['display_name']}}</button>
				@else
					<button class="btn btn-sm btn-default" type="submit">{{$questionRole['display_name']}}</button>
				@endif
			@else
				@if($formData[0]['createdBy'] != $user->_id)
					<input name="questionFormRoleCode" value="{{$questionRole['roleCode']}}" type="hidden">
					@if($questionRole['roleCode'] == $form['questionFormRoleCode'])
						<button class="btn btn-sm btn-primary" type="submit">{{$questionRole['display_name']}}</button>
					@else
						<button class="btn btn-sm btn-default" type="submit">{{$questionRole['display_name']}}</button>
					@endif
				@else
					<input name="questionFormRoleCode" value="{{$questionRole['roleCode']}}" type="hidden">
					@if($questionRole['roleCode'] == $form['questionFormRoleCode'])
						<button class="btn btn-sm btn-primary disabled" type="submit">{{$questionRole['display_name']}}</button>
					@else
						<button class="btn btn-sm btn-default disabled" type="submit">{{$questionRole['display_name']}}</button>
					@endif				
				@endif	
			@endif
			</td>
		{!! Form::close() !!}
		@endforeach
		@foreach($answerRoleCode as $key => $answerRole)
		<td width="100px">
		{!! Form::open(['method' => 'POST','action' => array('FormsController@updateAccessAnswer', $formId,$user->id)]) !!}
			@if(Auth::user()->_id == '58fd6cc13fd89d8b529e4acf')
					<input name="answerFormRoleCode" value="{{$answerRole['roleCode']}}" type="hidden">
					@if($answerRole['roleCode'] == $form['answerFormRoleCode'])
						<button class="btn btn-sm btn-primary" type="submit">{{$answerRole['display_name']}}</button>
					@else
						<button class="btn btn-sm btn-default" type="submit">{{$answerRole['display_name']}}</button>
					@endif	
				
			@else
					@if($formData[0]['createdBy'] != $user->_id)	
						<input name="answerFormRoleCode" value="{{$answerRole['roleCode']}}" type="hidden">
						@if($answerRole['roleCode'] == $form['answerFormRoleCode'])
							<button class="btn btn-sm btn-primary" type="submit">{{$answerRole['display_name']}}</button>
						@else
							<button class="btn btn-sm btn-default" type="submit">{{$answerRole['display_name']}}</button>
						@endif
					@else
						<input name="answerFormRoleCode" value="{{$answerRole['roleCode']}}" type="hidden">
						@if($answerRole['roleCode'] == $form['answerFormRoleCode'])
							<button class="btn btn-sm btn-primary disabled" type="submit">{{$answerRole['display_name']}}</button>
						@else
							<button class="btn btn-sm btn-default disabled" type="submit">{{$answerRole['display_name']}}</button>
						@endif				
					@endif			
			@endif
		</td>
		{!! Form::close() !!}
		@endforeach
		@if(Auth::user()->_id == '58fd6cc13fd89d8b529e4acf')
			<td width="80px">
		        {!! Form::open(['method' => 'DELETE','action' => array('FormsController@destroyPermission', $formId,$user->id),'onsubmit' => 'return ConfirmDelete()']) !!}
				{!! Form::button('<i class="fa fa-times"></i>', ['type' => 'submit','class' => 'btn btn-default no-border']) !!}
		        {!! Form::close() !!}
			</td>
		@else
			<td width="80px">
				@if($formData[0]['createdBy'] != $user->_id)
		        	{!! Form::open(['method' => 'DELETE','action' => array('FormsController@destroyPermission', $formId,$user->id),'onsubmit' => 'return ConfirmDelete()']) !!}
					{!! Form::button('<i class="fa fa-times"></i>', ['type' => 'submit','class' => 'btn btn-default no-border']) !!}
		        	{!! Form::close() !!}
	        	@endif
			</td>		
		@endif
	</tr>
				@endif
				@endif
			@endforeach
		@endif
	@endforeach
	</table>
    <!-- Initialize the plugin: -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#questionFormRoleCode').multiselect();
            $('#answerFormRoleCode').multiselect();

			$('#questionFormRoleCode').change(function () {
				var questionRoles = $(this).val();
				if (questionRoles == '') {
					$("#questionRoles0").remove();
					$("#questionRoles1").remove();
				} else if (questionRoles == 0) {
					$("#questionRoles1").remove();
					$("#alertQuestionRoles").append(" \
						<div id='questionRoles0' class='alert alert-warning' > \
							<h5><strong>Admin Question Form</strong></h5> \
							- สร้างคำถามในฟอร์ม <br> \
							- แก้ไขคำถามในฟอร์ม <br> \
							- ลบคำถามในฟอร์ม <br> \
						</div> \
					");
				} else if (questionRoles == 1) {
					$("#questionRoles0").remove();
					$("#alertQuestionRoles").append(" \
						<div id='questionRoles1' class='alert alert-warning' > \
							<h5><strong>Write Question Form</strong></h5> \
							- สร้างฟอร์มคำถามได้ <br> \
							- แก้ไขคำถามในฟอร์ม <br> \
						</div> \
					");
				}
			});

			$('#answerFormRoleCode').change(function () {
				var answerRoles = $(this).val();
				if (answerRoles == '') {
					$("#answerRoles2").remove();
					$("#answerRoles3").remove();
					$("#answerRoles4").remove();
				} else if (answerRoles == 2) {
					$("#answerRoles3").remove();
					$("#answerRoles4").remove();
					$("#alertAnswerRoles").append(" \
						<div id='answerRoles2' class='alert alert-warning' > \
							<h5><strong>Admin Answer Form</strong></h5> \
							- เห็นคำตอบทั้งหมดในฟอร์ม <br> \
							- แก้ไขคำตอบทั้งหมดในฟอร์ม <br> \
							- ลบคำตอบทั้งหมดในฟอร์ม <br> \
						</div> \
					");
				} else if (answerRoles == 3) {
					$("#answerRoles2").remove();
					$("#answerRoles4").remove();
					$("#alertAnswerRoles").append(" \
						<div id='answerRoles3' class='alert alert-warning' > \
							<h5><strong>Write Answer Form</strong></h5> \
							- เห็นเฉพาะคำตอบของตัวเอง <br> \
							- แก้ไขคำตอบของตัวเอง <br> \
							- ลบคำตอบของตัวเอง <br> \
						</div> \
					");
				} else if (answerRoles == 4) {
					$("#answerRoles2").remove();
					$("#answerRoles3").remove();
					$("#alertAnswerRoles").append(" \
						<div id='answerRoles4' class='alert alert-warning' > \
							<h5><strong>Read Question Form</strong></h5> \
							- เห็นคำตอบของตัวเอง <br> \
						</div> \
					");
				}
			});
        });
	</script>
	<script type="text/javascript">
	    var path = "{{ URL::to('/autocomplete') }}";
	    $('input.typeahead').typeahead({
	        source:  function (query, process) {
	        return $.get(path, { query: query }, function (data) {
	                return process(data);
	            });
	        }
	    });
	</script>
{!! Form::close() !!}

	</section>
	</section>
</section>
@endsection