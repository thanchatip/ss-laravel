@extends('theme')
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        	<div class="row">
        	    <div class="col-lg-12 margin-tb">
        	        <div class="pull-left">
        	            <h2>แก้ไขลิสต์</h2>
        	        </div>
        	        <div class="pull-right">
        	            <a class="btn btn-default" href="{{ route('masterlists.index') }}">
                        <i class="fa fa-backward"></i> กลับ</a>
        	        </div>
        	    </div>
        	</div>
            <hr/>

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

        	
        	@foreach($masterlists as $masterlist)
            {!! Form::model($masterlists, ['method' => 'PATCH','route' => ['masterlists.update',$masterlist['objectId']]]) !!}
        	<div class="row">
        		<div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <h4><strong>ชื่อลิสต์: </strong></h4>
                    {!! Form::text('title', $masterlist['title'], array('placeholder' => 'ชื่อ','class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <h4><strong>คำอธิบาย: </strong></h4>
                    {!! Form::textarea('description', $masterlist['description'], array('placeholder' => 'คำอธิบาย','class' => 'form-control','style'=>'height:100px')) !!}
                    </div>
                </div>
            @endforeach
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        			<button type="submit" class="btn btn-primary btn-block">บันทึก</button>
                </div>
        	</div>
        	{!! Form::close() !!}

        </section>
    </section>
</section>
@endsection