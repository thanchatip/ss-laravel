<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>COFFEE DASHBOARD | MAE FAH LUANG FOUNDATION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="theme/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/icon.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/font.css" type="text/css" />
  <link rel="stylesheet" href="theme/css/app.css" type="text/css" />
</head>

<body class="">

  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="text-center">
        <img src="{{asset('theme/images/mflf.png')}}" width="400px">
    </div>
    <hr>
    <div class="container aside-xl">
      <section class="m-b-lg">
        {!!Form::open(array('action'=>'AuthController@postLogin','id'=>'loginForm', 'role'=>'form', 'class'=>'form-signin'))!!}
          <div class="list-group">
            <div class="list-group-item">
              {!!Form::text('username',Input::old('username'),
                array('id'=>'username','placeholder'=>'username','class'=>'form-control no-border','required'=>'required'))!!}
            </div>
            <div class="list-group-item">
               {!!Form::password('password',
                array('id'=>'password','class'=>'form-control no-border','placeholder'=>'password'))!!}
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">SIGN IN</button>
          <div class="line line-dashed"></div>
          <span class="clearfix"></span>
        {!!Form::close()!!}
      </section>
    </div>
  </section>


  <script src="theme/js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="theme/js/bootstrap.js"></script>
  <!-- App -->
  <script src="theme/js/app.js"></script>
  <script src="theme/js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="theme/js/app.plugin.js"></script>
</body>
</html>