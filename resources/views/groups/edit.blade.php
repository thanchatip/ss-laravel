@extends('theme')

@section('content')

<section class="vbox bg-white">
	<section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">

	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>แก้ไขกลุ่ม</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ route('groups.index') }}">
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

	{!! Form::model($group, ['method' => 'PATCH','route' => ['groups.update', $group->id]]) !!}

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ชื่อกลุ่ม:</strong></h4>

                {!! Form::text('name', null, array('placeholder' => 'ชื่อกลุ่ม','class' => 'form-control')) !!}

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