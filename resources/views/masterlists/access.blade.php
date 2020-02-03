@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">

	{!! Form::open(array('URL' => 'masterlists/admin/access/{masterListId}','method'=>'POST')) !!}
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-user"></i>
	            กำหนดสิทธิ์การใช้งานมาสเตอร์ลิสต์ : {{$masterlists[0]['title']}}</h2>
	        </div>
	       	<div class="pull-right">
	        	<a class="btn btn-default" href="{{ route('masterlists.index') }}">
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
<!--bit bucket ui desigend-->

		

<!--table user access-->
	<table class="table table-responsive no-bordered m-b-none">
		<thead>
		<tr>
			<th width="1000px">
				<h4>
				{!! Form::open(['method'=>'GET','url'=>'/masterlists/admin/access','role'=>'search']) !!}
				<div class="input-group col-lg-12" >
					<input type="text" class="typeahead form-control no-border" name="query" placeholder="Username" >
				</div>
				{!! Form::close() !!}
				</h4>
			</th>
			<th>
				<h4>
					<select id="masterlistRoleCode" name="masterlistRoleCode" class="form-control">
				    	@foreach($masterlistRoleCode as $key => $masterlistRole)
					 		<option value="{{$masterlistRole['roleCode']}}">{{$masterlistRole['display_name']}}
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

	<table class="table table-responsive no-table-bordered m-b-none">

	@foreach ($users as $key => $user)
		@if(!empty($user->masterlist_ids[0]['masterList_id']))
			@foreach($user->masterlist_ids as $masterlist)
				@if($masterlist['masterList_id'] == $masterListId)
					<tr>
						<td>{{ $user->code }}</td>
						<td>{{ $user->prefix }} {{ $user->firstname }} {{ $user->lastname }}</td>
						@foreach($masterlistRoleCode as $key => $masterlistRole)
						<td width="100px">
							{!! Form::open(['method' => 'POST','action' => array('MasterlistsController@updateAccessPermission', $masterListId,$user->id)]) !!}
							<input name="masterlistCode" value="{{$masterlistRole['roleCode']}}" type="hidden">
								@if($masterlistRole['roleCode'] == $masterlist['masterlistRoleCode'])
									<button class="btn btn-sm btn-primary" type="submit">{{$masterlistRole['display_name']}}</button>
								@else
									<button class="btn btn-sm btn-default" type="submit">{{$masterlistRole['display_name']}}</button>
								@endif
							{!! Form::close() !!}
						</td>
						@endforeach
						<td width="80px">
				        	{!! Form::open(['method' => 'DELETE','action' => array('MasterlistsController@destroyPermission', $masterListId,$user->id),'onsubmit' => 'return ConfirmDelete()']) !!}
							{!! Form::button('<i class="fa fa-times"></i>', ['type' => 'submit','class' => 'btn btn-default no-border']) !!}
				        	{!! Form::close() !!}
						</td>
					</tr>
				@endif
			@endforeach
		@endif
	@endforeach
	</table>

    <!-- Initialize the plugin: -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#masterlistRoleCode').multiselect();
        });
	</script>
	<script type="text/javascript">
    	var path = "{{ URL::to('/autocomplete?query={query}') }}";
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