<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ url('/log') }}" class="navbar-brand">
                <i class="fa fa-fw fa-book"></i> Log - Webportal
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li class="{{ Route::is('log-viewer::dashboard') ? 'active' : '' }}">
                    <a href="{{ route('log-viewer::dashboard') }}">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="{{ Route::is('log-viewer::logs.list') ? 'active' : '' }}">
                    <a href="{{ route('log-viewer::logs.list') }}">
                        <i class="fa fa-archive"></i> Logs
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon glyphicon-user"></span> {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu"> 
                        <li><a href="{{ url('/') }}"><i class="fa fa fa-television"></i>
                            MFLF WEBPORTAL</a></li>
                        </li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>
                        {{ trans('sidebar.logout') }}</a></li>
                        </li>
                    </ul>
                </li>
            </ul> 
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                         Log <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ config('app.ss_report') }}/log"><i class="i i-browser"></i> 
                            Log-Report
                            </a>
                        </li>
                        <li>
                            <a href="{{ config('app.ss_api') }}/log"><i class="i i-browser"></i> 
                            Log-Api
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> 
        </div>
    </div>
</nav>
