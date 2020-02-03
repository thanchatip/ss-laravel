@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>รายละเอียดการอนุญาต</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-primary" href="{{ route('permissions.index') }}">
	        	<i class="fa fa-backward"></i> กลับ</a>
	        </div>
	    </div>
	</div>

	<hr>
	<div class="row">
        <div class="col-lg-12 col-md-6">
            <section class="panel b-a">
            <div class="panel-body">
            <footer class="panel-footer dk text-center no-border">
                <div class="row pull-out">
                    <div class="col-xs-12">
                        <div class="padder-v">
                            <span class="m-b-xs h4 block"><strong>การอนุญาต :</strong> {{ $permission->display_name }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 dker">
                        <div class="padder-v">
                            <span class="m-b-xs h4 block"><strong>ประเภท :</strong> {{ $permission->type }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 dker">
                        <div class="padder-v">
                            <span class="m-b-xs h4 block"><strong>คำอธิบาย :</strong> {{ $permission->description }}</span>
                        </div>
                    </div>
                </div>
            </footer>
            </div>
            </section>
        </div>
    </div>

	<!--<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>Name:</strong>
                {{ $permission->display_name }}</h4>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>Description:</strong>
                {{ $permission->description }}</h4>
            </div>
        </div>
	</div>-->
		</section>
	</section>
</section>
@endsection