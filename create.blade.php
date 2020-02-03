@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>เพิ่มผู้ใช้</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ route('users.index') }}">
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

	{!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
	<div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>คำนำหน้า:</strong>
                {!! Form::select('prefix', $prefix,[], array('class' => 'form-control')) !!}
            </div>
        </div>

		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ชื่อ:</strong>
                {!! Form::text('firstname', null, array('placeholder' => 'ชื่อ','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>นามสกุล:</strong>
                {!! Form::text('lastname', null, array('placeholder' => 'นามสกุล','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>แผนก:</strong>
                {!! Form::text('department', null, array('placeholder' => 'แผนก','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ตำแหน่ง:</strong>
                {!! Form::text('position', null, array('placeholder' => 'ตำแหน่ง','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>รหัสพนักงาน:</strong>
                {!! Form::text('code', null, array('placeholder' => 'รหัสพนักงาน','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>อีเมล์:</strong>
                {!! Form::text('email', null, array('placeholder' => 'อีเมล์','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>รหัสผ่าน:</strong>
                {!! Form::password('password', array('placeholder' => 'รหัสผ่าน','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ยืนยันรหัสผ่าน:</strong>
                {!! Form::password('confirm-password', array('placeholder' => 'ยืนยันรหัสผ่าน','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>การสร้างฟอร์ม:</strong><br>
                {{ Form::radio('allowCreateForm','1', ['class' => 'form-inline']) }}
                อนุญาติ
            
                {{ Form::radio('allowCreateForm','0', ['class' => 'form-inline']) }}
                ไม่อนุญาติ
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>สิทธิ์การใช้งาน:</strong>
                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="pull-right btn btn-primary btn-block">บันทึก</button>
        </div>

	</div>
	{!! Form::close() !!}
    </section>
    </section>
</section>
@endsection