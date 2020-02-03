<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
    <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
          <i class="fa fa-bars"></i>
        </a>
        <a href="{{ config('app.url') }}" class="navbar-brand">
          <img src="{{asset('theme/images/logo.png')}}" class="m-r-sm" alt="scale">
          <span class="hidden-nav-xs">MFLF</span>
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
          <i class="fa fa-cog"></i>
        </a>
      </div>

      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight"> 
            @if (Auth::guest())
            <li><a href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
            @else           
            <li>
              <li>
                <a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i> 
                {{ trans('sidebar.profile') }}
                </a>
              </li>
            </li>
            <li class="divider"></li>
            <li>
              <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>
               {{ trans('sidebar.logout') }}</a></li>
            </li>
            @endif
          </ul>
        </li>
      </ul> 
      @if (Auth::user()->_id == '58fd6cc13fd89d8b529e4acf')
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
        <li class="dropown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Log <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">
              <li>
                <a href="{{ url('/log') }}"><i class="i i-browser"></i> 
                  Log-Webportal
                </a>
              </li>
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
      @endif
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
        <li class="dropown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('sidebar.language') }}
                <b>{{ Config::get('languages')[App::getLocale()] }}</b>  <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInRight">
                @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                        <li>
                            <a href="{{ route('lang.switch', $lang) }}">{{ $language }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
      </ul>
      <!-- Right Side Of Navbar -->
</header>
