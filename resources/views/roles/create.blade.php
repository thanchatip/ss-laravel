@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>เพิ่มสิทธิ์การใช้งาน</h2>
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

	{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ชื่อสิทธิ์:</strong></h4>


                {!! Form::text('name', null, array('placeholder' => 'ชื่อ','class' => 'form-control')) !!}

            </div>
        </div>

		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ชื่อสิทธิ์ (สำหรับแสดง):</strong></h4>


                {!! Form::text('display_name', null, array('placeholder' => 'ชื่อสิทธิ์ (สำหรับแสดง)','class' => 'form-control')) !!}

            </div>
        </div>


        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ประเภทสิทธิ์:</strong></h4>


                {!! Form::text('type', null, array('placeholder' => 'ประเภทสิทธิ์','class' => 'form-control')) !!}

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">

                <h4><strong>คำอธิบาย:</strong></h4>

                {!! Form::textarea('description', null, array('placeholder' => 'คำอธิบาย','class' => 'form-control','style'=>'height:100px')) !!}

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>การอนุญาต:</strong></h4>
                <br/>

                @foreach($permission as $value)
                    <div class="col-md-3">
                	   <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'checkbox-inline i-checks')) }}

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