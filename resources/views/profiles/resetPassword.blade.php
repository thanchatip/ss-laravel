@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>เปลี่ยนรหัสผ่าน</h2>
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

	{!! Form::model($user, ['method' => 'POST','url' => 'profile/resetPassword']) !!}
	<div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>รหัสผ่านใหม่:</strong>
                {!! Form::password('password', array('placeholder' => 'รหัสผ่าน','class' => 'form-control')) !!}
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ยืนยันรหัสผ่านใหม่:</strong>
                {!! Form::password('confirm-password', array('placeholder' => 'ยืนยันรหัสผ่าน','class' => 'form-control')) !!}
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