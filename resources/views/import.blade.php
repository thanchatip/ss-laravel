<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>SMART SURVEY | MAE FAH LUANG FOUNDATION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="theme/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/icon.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/font.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/app.css" type="text/css" />
  <link rel="stylesheet" href="theme/js/calendar/bootstrap_calendar.css" type="text/css" />
  <script type="text/javascript" src="http://www.datejs.com/build/date.js"></script>

</head>

 <body class="" >

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
            			<button id="btnImport" class="btn btn-default">Import!</button>
            		</span>
			</div>
		</div>
	</div>


		</section>
	</section>
</section>

<script src="theme/js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="theme/js/bootstrap.js"></script>
  <!-- App -->
  <script src="theme/js/app.js"></script>
  <script src="theme/js/slimscroll/jquery.slimscroll.min.js"></script>

  <!-- Service -->
  <script src="service/importjson.js"></script>
</body>
</html>