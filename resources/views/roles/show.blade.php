@extends('theme')

@section('content')

<section class="vbox bg-white">
	<section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2> รายละเอียดสิทธิ์</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ route('roles.index') }}">
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
                            <span class="m-b-xs h4 block"><strong>สิทธิ์ :</strong> {{ $role->display_name }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 dker">
                        <div class="padder-v">
                            <span class="m-b-xs h4 block"><strong>คำอธิบาย :</strong> {{ $role->description }}</span>
                        </div>
                    </div>
                </div>
            </footer>
                <div class="col-lg-12">
                    <div class="padder-v text-center">
                        <span class="m-b-xs h3 block text-dark">
                        @if(!empty($rolePermissions))
							@foreach($rolePermissions as $v)
							<span class="label label-default label-sm">{{ $v->display_name }}</span>
							@endforeach
						@endif</span><br>
                        <small class="h4 text-muted"><strong>การอนุญาต</strong></small>
                    </div>
                </div>
            </div>
            </section>
        </div>
    </div>
	<!--<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>Name:</strong>
                {{ $role->display_name }}</h4>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>Description:</strong>
                {{ $role->description }}</h4>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>Permissions:</strong>

                @if(!empty($rolePermissions))

					@foreach($rolePermissions as $v)

						<span class="label label-success label-md">{{ $v->display_name }}</span>

					@endforeach
				</h4>
				@endif

            </div>
        </div>
	</div>-->
		</section>
</section>
</section>
@endsection