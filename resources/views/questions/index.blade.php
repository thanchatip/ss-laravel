@extends('theme')
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-user"></i>
	            Questions Management</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ URL('questions/create') }}">
	            	<i class="fa fa-plus-square"></i>
	            	CREATE NEW QUESTION
	            </a>
	        </div>
	        <div class="pull-right">
	        {!! Form::open(['method'=>'GET','url'=>'forms','role'=>'search']) !!}
				<div class="input-group">
				    <input type="text" class="form-control" name="search" placeholder="Search...">
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
			<th width="20">
				<label class="checkbox m-n i-checks">
					<input type="checkbox"><i></i>
				</label>
			</th>
			<th>Title</th>
			<th width="183px"></th>
		</tr>
	@foreach ($questions as $question)
	<tr>
		<td><label class="checkbox m-n i-checks"><input type="checkbox" name="post[]"><i></i></label></td>
		<td>{{ $question['title'] }}</td>
		<td>
			<a class="btn btn-default" href="{{ route('questions.show',$question['objectId']) }}">
				<i class="fa fa-file-text-o"></i>
			</a>
			<a class="btn btn-default" href="{{ route('questions.edit',$question['objectId']) }}">
				<i class="fa fa-edit"></i>
			</a>
			{!! Form::open(['method' => 'DELETE','route' => ['questions.destroy', $question['objectId']],'style'=>'display:inline']) !!}
            	{!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-default']) !!}
        	{!! Form::close() !!}
        	<a class="btn btn-primary" href="{{ URL('forms/user/access') }}">
        		<i class="i i-user2"></i>
        	</a>
		</td>
	</tr>
	@endforeach
	</table>

	</section>
	</section>
</section>
@endsection