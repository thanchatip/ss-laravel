<!DOCTYPE html>
<html lang="en" class="app">
<head>

  <meta charset="utf-8" />
  

  <title>SMART SURVEY | MAE FAH LUANG FOUNDATION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
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
                 <!-- <img src="{{asset('theme/images/mflf.png')}}" width="400px"> -->
                 <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=10"> -->
            <img src="{{asset('theme/images/mflf.png')}}" class="img-fluid" alt="Responsive image">
    </div>
    <hr>
    <div class="container aside-xl">
      <section class="m-b-lg">
        {!!Form::open(array('id'=>'loginForm', 'role'=>'form', 'class'=>'form-signin'))!!}
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="list-group">
            <div class="list-group-item">
              {!!Form::text('email',Input::old('email'),
                array('id'=>'email','placeholder'=>'email','class'=>'form-control no-border','required'=>'required'))!!}
            </div>
            <div class="list-group-item">
               {!!Form::password('password',
                array('id'=>'password','class'=>'form-control no-border','placeholder'=>'password'))!!}
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">SIGN IN</button>
          <div class="line line-dashed"></div>
          <span class="clearfix"></span>
          @if(count($errors))
            @foreach($errors->all() as $error)
              <div class="text-center text-danger">
                <h4>{{ $error }}</h4>
              </div>
            @endforeach
          @endif
        {!!Form::close()!!}
        <div class="text-center">
          <a href="/password/reset">Forget password? (ลืมรหัสผ่าน)</a>
        </div>
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