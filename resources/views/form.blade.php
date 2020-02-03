@extends('theme')
@section('content')

<!-- Content Wrapper. Contains page content -->
    <section class="vbox bg-white">
      <section class="scrollable padder">
      	<div class="row">
	    	<div class="col-lg-12 margin-tb">
	        	<div class="pull-left">
	            	<h2><i class="fa fa-archive"></i> Form</h2>
	        	</div>
	    	</div>
	    	<button id="backButton" class="pull-right btn btn-default btn-s-md" onclick="javascript:window.location.href = '/form'; return false;"><< BACK
	        </button>
		</div>

	<!--formList-->
	<div id="formList" class="list-group no-radius no-border no-bg m-t-n-xxs m-b-none"></div>

	<!--answerForm form-->
    <section id="answerFormList" class="hbox stretch" class="m-t-lg wrapper-md animated fadeInUp">
        	<section class="vbox">
            	<section class="scrollable hover">
                  <div id="answerForm" class="list-group no-radius no-border no-bg m-t-n-xxs m-b-none">
                  </div>
                </section>
            </section>

	    <!--answer form-->
	    <!--<section id="page" class="vbox">
	        <section class="scrollable padder bg-white">
	        <button class="pull-right btn btn-info btn-s-md" onclick="javascript:window.location.href = '/form'; return false;">BACK</button>
	        <h4>คำตอบทั้งหมด</h4>
		        <div class="line line-dashed b-b line-lg pull-in"></div>
					<div id="answer"></div>
	    	</section>
		</section>

    </section>--><!--close section answerForm-->
    </section>
  </section>

<script src="{{asset('service/form.js')}}"></script>
@endsection