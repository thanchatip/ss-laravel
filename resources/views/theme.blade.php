<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>MFLF | Smart Survey</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/animate.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/font-awesome.min.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/icon.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/font.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/app.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/js/datepicker/datepicker.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/bootstrap-multiselect.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/js/calendar/bootstrap_calendar.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/js/chosen/chosen.css')}}" type="text/css" />
  <script type="text/javascript" src="http://www.datejs.com/build/date.js"></script>
  <script src="//code.jquery.com/jquery-3.0.0.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<style>
.tooltip {
  font-size: 17px;
}
</style>
</head>
<body class="">
      <!-- Header -->
    <section class="vbox">
      @include('header')

    <section>
      <section class="hbox stretch">
      @include('sidebar')



    <section id="content">
      <!-- Your Page Content Here -->
      @yield('content')
    </section>
  </section>
</section>
</section>



  <script src="{{asset('theme/js/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{asset('theme/js/bootstrap.js')}}"></script>
  <!-- App -->
  <script src="{{asset('theme/js/app.js')}}"></script>
  <script src="{{asset('theme/js/bootstrap-multiselect.js')}}"></script>
  <script src="{{asset('theme/js/slimscroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('theme/js/charts/easypiechart/jquery.easy-pie-chart.js')}}"></script>
  <script src="{{asset('theme/js/charts/sparkline/jquery.sparkline.min.js')}}"></script>
  <script src="{{asset('theme/js/charts/flot/jquery.flot.min.js')}}"></script>
  <script src="{{asset('theme/js/charts/flot/jquery.flot.tooltip.min.js')}}"></script>
  <script src="{{asset('theme/js/charts/flot/jquery.flot.spline.js')}}"></script>
  <script src="{{asset('theme/js/charts/flot/jquery.flot.pie.min.js')}}"></script>
  <script src="{{asset('theme/js/charts/flot/jquery.flot.resize.js')}}"></script>
  <script src="{{asset('theme/js/charts/flot/jquery.flot.grow.js')}}"></script>
  <script src="{{asset('theme/js/charts/flot/demo.js')}}"></script>
  <script src="{{asset('theme/js/file-input/bootstrap-filestyle.min.js')}}"></script>
  <script src="{{asset('theme/js/calendar/bootstrap_calendar.js')}}"></script>
  <script src="{{asset('theme/js/calendar/demo.js')}}"></script>
  <script src="{{asset('theme/js/chosen/chosen.jquery.min.js')}}"></script>
  <script src="{{asset('theme/js/sortable/jquery.sortable.js')}}"></script>
  <script src="{{asset('theme/js/app.plugin.js')}}"></script>
  <script src="{{asset('theme/js/table2csv.js')}}"></script>
  <script src="{{asset('theme/js/datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('theme/js/parsley/parsley.min.js')}}"></script>
  <script src="{{asset('theme/js/parsley/parsley.extend.js')}}"></script>
  <script src="{{asset('js/jquery.blockUI.js')}}"></script>
  <script src="{{asset('js/jquery.form.js')}}"></script>
  <script src="{{asset('js/app.js')}}"></script>

</body>
</html>