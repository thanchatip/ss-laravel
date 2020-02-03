@extends('theme')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        	<div class="row">
        	    <div class="col-lg-12 margin-tb">
        	        <div class="pull-left">
        	            <h2>เพิ่มลิสต์</h2>
        	        </div>
        	        <div class="pull-right">
        	            <a class="btn btn-default" href="{{ route('masterlists.index') }}">
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

            {!! Form::open(array('route' => 'masterlists.store','method'=>'POST')) !!}
        	<div class="row">
        		<div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <h4><strong>ชื่อลิสต์: </strong></h4>
                    {!! Form::text('title', null, array('placeholder' => 'ชื่อ','class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <h4><strong>คำอธิบาย: </strong></h4>
                    {!! Form::textarea('description', null, array('placeholder' => 'คำอธิบาย','class' => 'form-control','style'=>'height:100px')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="button" class="btn circle btn-success add_button">เพิ่มรายการ
                    </button>
                    <div class="field_wrapper">
                    <br>
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
<script type="text/javascript">

$(document).ready(function(){
    var maxField = 100; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="form-group"><input class="form-control" type="input" name="items[]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
@endsection