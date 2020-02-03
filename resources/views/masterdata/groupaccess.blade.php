@extends('theme')
@section('content')
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
		<div class="m-b-sm">
		    <div class="btn-group btn-group-justified">
		        <a href="{{ URL('/masterdata/admin/access',$masterdata[0]['objectId']) }}" class="btn btn-default"><font size="4">USERS</font></a>
		    	<a href="#" class="btn btn-primary disabled"><font size="4">GROUPS</font></a>
		    </div>
		</div>
<div class="tab-content">
	{!! Form::open(array('URL' => '/masterdata/admin/group/access','method'=>'POST')) !!}
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-group icon"></i>
	            รายชื่อกลุ่มที่มีสิทธิ์เข้าถึงมาสเตอร์ดาต้า : {{ $masterdata[0]['title'] }}</h2>
	        </div>
			<div class="pull-right">
				<a class="btn btn-default" href="{{ route('masterdata.index',$masterdata[0]['objectId']) }}">
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
			<th width="70%">
				<h4>
				<div class="input-group col-lg-12" >
					<input type="text" class="typeahead form-control no-border" name="query" placeholder="ชื่อกลุ่ม">
				</div>
				</h4>
			</th>
			<th>
				<h4>
					สิทธิ์ในการเข้าถึงมาสเตอร์ดาต้า: 
					<select id="masterdataRoleCode" name="masterdataRoleCode" class="form-control" data-required="true">
					 	<option value="">กรุณาเลือกสิทธิ์</option>
				    	@foreach($masterdataRoleCodes as $key => $masterdataRoleCode)
					 		<option value="{{$masterdataRoleCode['roleCode']}}">{{$masterdataRoleCode['display_name']}}
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

	@foreach ($groups as $key => $group)
		@if(!empty($group->masterdata_ids[0]['masterdata_id']))
			@foreach($group->masterdata_ids as $master)
                @if($master['masterdata_id'] == $masterDataId)
				@if($master['masterdataRoleCode'] != '')
                    <tr>
                        <td>กลุ่ม</td>
                        <td>
                            <a href="#">
                            {{ $group->name }}
                            </a>
                        </td>
                        @foreach($masterdataRoleCodes as $key => $masterdataRoleCode)
                        <td width="100px">
                        {!! Form::open(['method' => 'POST','action' => array('MasterDataController@groupUpdateAccessPermission', $masterDataId,$group->id)]) !!}
                            <input name="masterdataRoleCode" value="{{$masterdataRoleCode['roleCode']}}" type="hidden">
                            @if($masterdataRoleCode['roleCode'] == $master['masterdataRoleCode'])
                                <button class="btn btn-sm btn-primary" type="submit">{{$masterdataRoleCode['display_name']}}</button>
                            @else
                                <button class="btn btn-sm btn-default" type="submit">{{$masterdataRoleCode['display_name']}}</button>
                            @endif
                        </td>
                        {!! Form::close() !!}
                        @endforeach
                        <td width="80px">
                            {!! Form::open(['method' => 'DELETE','action' => array('MasterDataController@groupDestroyPermission', $masterDataId,$group->id),'onsubmit' => 'return ConfirmDelete()']) !!}
                            {!! Form::button('<i class="fa fa-times"></i>', ['type' => 'submit','class' => 'btn btn-default no-border']) !!}
                            {!! Form::close() !!}
                        </td>		
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
            $('#masterdataRoleCode').multiselect();
            $('#answerFormRoleCode').multiselect();
        });
	</script>
	<script type="text/javascript">
	    var path = "{{ URL::to('/access/group/autocomplete') }}";
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