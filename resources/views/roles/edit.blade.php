@extends('theme')

@section('content')

<section class="vbox bg-white">
	<section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">

	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>แก้ไขสิทธิ์การใช้งาน</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ route('roles.index') }}">
	        	<i class="fa fa-backward"></i> กลับ</a>
	        </div>
	    </div>
	</div>
<hr>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>

			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	{!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ชื่อสิทธิ์:</strong></h4>

                {!! Form::text('display_name', null, array('class' => 'form-control')) !!}

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>คำอธิบาย:</strong></h4>

                {!! Form::textarea('description', null, array('class' => 'form-control','style'=>'height:100px')) !!}

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>การอนุญาต:</strong></h4>

                @foreach($permission as $value)
                <div class="col-md-3">
                	<label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'checkbox-inline i-checks')) }}

                	{{ $value->display_name }}</label>

                	<br/>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-primary btn-block">บันทึก</button>
        </div>

	</div>

	{!! Form::close() !!}
		</section>
	</section>
</section>
@endsection