@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>แก้ไขข้อมูล</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ URL::to('profile') }}">
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

	{!! Form::model($user, ['method' => 'POST','url' => 'profile/update']) !!}
	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ชื่อ:</strong></h4>
                {!! Form::text('firstname', null, array('placeholder' => 'ชื่อ','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>นามสกุล:</strong></h4>
                {!! Form::text('lastname', null, array('placeholder' => 'นามสกุล','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ตำแหน่ง:</strong></h4>
                {!! Form::text('department', null, array('placeholder' => 'นามสกุล','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>แผนก:</strong></h4>
                {!! Form::text('position', null, array('placeholder' => 'นามสกุล','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>รหัสพนักงาน:</strong></h4>
                {!! Form::text('code', null, array('placeholder' => 'รหัสพนักงาน','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>อีเมล์:</strong></h4>
                {!! Form::text('email', null, array('placeholder' => 'อีเมล์','class' => 'form-control')) !!}
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