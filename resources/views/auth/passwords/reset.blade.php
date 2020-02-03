<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>SMART SURVEY | MAE FAH LUANG FOUNDATION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/animate.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/font-awesome.min.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/icon.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/font.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/app.css')}}" type="text/css" />
</head>

<body class="">

<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="text-center">
        <<img src="{{asset('theme/images/mflf.png')}}" class="img-fluid" alt="Responsive image">
    </div>
    <hr>
    <div class="col-md-8 col-md-offset-2">
    <section class="m-b-lg">
        <div class="panel panel-default">
            <div class="panel-heading text-center">Reset Password | เปลี่ยนรหัสผ่าน</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-md btn-primary btn-block">
                                    <i class="fa fa-btn fa-refresh"></i> Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </section>
    </div>
  </section>

  <script src="{{asset('theme/js/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{asset('theme/js/bootstrap.js')}}"></script>
  <!-- App -->
  <script src="{{asset('theme/js/app.js')}}"></script>
  <script src="{{asset('theme/js/slimscroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('theme/js/app.plugin.js')}}"></script>
</body>
</html>