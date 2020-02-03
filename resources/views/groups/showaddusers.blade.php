@extends('theme')
@section('content')
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-file"></i>
	            นำเข้าสมาชิกในกลุ่ม (csv file)</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-default" href="{{ route('users.index') }}">
                <i class="fa fa-backward"></i> กลับ</a>
	        </div>
	    </div>
	</div>
<hr>
  @if (Session::has('message'))
   <div class="alert alert-success">{{ Session::get('message') }}</div>
  @endif
	<div class="row">
    	<div class="col-lg-4 col-lg-offset-4">
        	<form action="{{ URL::to('/importCsv/groups/user',$group->id) }}" method="post" enctype="multipart/form-data" >
        		<div class="input-group">
            		<input type="file" name="usersImport" class="form-control" />
            		<span class="input-group-btn">
	            		{!! Form::token(); !!}
	                 	{!! csrf_field() ; !!}
            			<button id="btnImport" class="btn btn-default">Import</button>
            		</span>
            	</div>
            </form>
		</div>
	</div>

		</section>
	</section>
</section>

@endsection