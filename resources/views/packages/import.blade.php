@extends('theme')
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-file"></i>
	            Import json package</h2>
	        </div>
	    </div>
	</div>
<hr>
	<div class="row">
    	<div class="col-lg-4 col-lg-offset-4">
        	<div class="input-group">
            	<input type="file" id="jsonpackage" name="jsonpackage" class="form-control" />
            		<span class="input-group-btn">
            			<button id="btnImport" class="btn btn-warning">Import!</button>
            		</span>
			</div>
		</div>
	</div>


		</section>
	</section>
</section>
<!-- Service -->
  <script src="{{asset('service/importjson.js')}}"></script>
@endsection