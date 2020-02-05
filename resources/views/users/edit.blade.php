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
	            <a class="btn btn-default" href="{{ route('users.index') }}">
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

	{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
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
                <h4><strong>แผนก:</strong></h4>
                {!! Form::text('department', null, array('placeholder' => 'แผนก','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ตำแหน่ง:</strong></h4>
                {!! Form::text('position', null, array('placeholder' => 'ตำแหน่ง','class' => 'form-control')) !!}
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

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <h4><strong>รหัสผ่าน:</strong></h4>
                {!! Form::password('password', array('placeholder' => 'รหัสผ่าน','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <h4><strong>ยืนยันรหัสผ่าน:</strong></h4>
                {!! Form::password('confirm-password', array('placeholder' => 'ยืนยันรหัสผ่าน','class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <h4><strong>การสร้างฟอร์ม:</strong></h4><br>
                {{ Form::radio('allowCreateForm', 1, ['class' => 'form-inline']) }}
                อนุญาติ
            
                {{ Form::radio('allowCreateForm', 0, ['class' => 'form-inline']) }}
                ไม่อนุญาติ
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>กลุ่ม:</strong></h4>

                @foreach($group as $value)
                <div class="col-md-4">
                    <label>{{ Form::checkbox('group[]', $value->id, in_array($value->id, $userGroups) ? true : false, array('class' => 'checkbox-inline i-checks')) }}

                    {{ $value->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>สิทธิ์การใช้งาน:</strong></h4>
                {!! Form::select('roles[]',$roles, $userRole, array('class' => 'form-control','multiple')) !!}
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