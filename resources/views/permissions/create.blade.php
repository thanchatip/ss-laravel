@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>เพิ่มการอนุญาตให้แก่สิทธิ์</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ route('permissions.index') }}">
	        	<i class="fa fa-backward"></i> กลับ</a>
	        </div>
	    </div>
	</div>

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

	{!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ชื่อการอนุญาต:</strong>

                {!! Form::text('name', null, array('placeholder' => 'ชื่อ','class' => 'form-control')) !!}

            </div>
        </div>

		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ชื่อการอนุญาต (สำหรับใช้แสดง):</strong>

                {!! Form::text('display_name', null, array('placeholder' => 'สำหรับใช้แสดง','class' => 'form-control')) !!}

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ประเภทการอนุญาต:</strong>

                {!! Form::text('type', null, array('placeholder' => 'ประเภท','class' => 'form-control')) !!}

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">

                <strong>คำอธิบาย:</strong>

                {!! Form::textarea('description', null, array('placeholder' => 'คำอธิบาย','class' => 'form-control','style'=>'height:100px')) !!}

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