
        <!-- .aside -->
        <aside class="bg-black aside-md hidden-print" id="nav">
          <section class="vbox">
            <section class="w-f scrollable">
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav nav-main" data-ride="collapse">
                  @if (\Auth::user()->firstname == "admin")
                  <li>
                      <a href="{{ url('statistic') }}" class="auto">
                        <i class="i i-statistics">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.statistics') }}</span>
                      </a>
                  </li>
                  @endif
                  @permission('users-menu')
                    <li>
                      <a href="{{ route('users.index') }}" class="auto">
                        <i class="fa fa-user icon">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.users') }}</span>
                      </a>
                    </li>
                  @endpermission
                  @permission('groups-menu')
                    <li>
                      <a href="{{ route('groups.index') }}" class="auto">
                        <i class="fa fa-group icon"></i>
                        <span class="font-bold">{{ trans('sidebar.groups') }}</span>
                      </a>
                    </li>
                  @endpermission
                  @permission('roles-menu')
                    <li>
                      <a href="{{ route('roles.index') }}" class="auto">
                        <i class="fa fa-key icon">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.roles') }}</span>
                      </a>
                    </li>
                  @endpermission
                  @permission('permissions-menu')
                    <li>
                      <a href="{{ route('permissions.index') }}" class="auto">
                        <i class="fa fa-lock icon">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.permissions') }}</span>
                      </a>
                    </li>
                  @endpermission
                  @permission('forms-menu')
                    <li>
                      <a href="{{ URL('forms') }}" class="auto">
                        <i class="fa fa-list-ul">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.forms') }}</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ URL('myforms') }}" class="auto">
                        <i class="fa fa-list-ul">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.myforms') }}</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ URL('masterdata') }}" class="auto">
                      <i class="i i-data2 icon"></i>
                        <span class="font-bold">{{ trans('sidebar.masterdata') }}</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ URL('mymasterdata') }}" class="auto">
                      <i class="i i-data2 icon"></i>
                        <span class="font-bold">{{ trans('sidebar.mymasterdata') }}</span>
                      </a>
                    </li>
                  @endpermission
                 <!-- @permission('forms-menu')
                    <li >
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="fa fa-archive icon">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.forms') }}</span>
                      </a>
                      <ul class="nav dk">
                        <li >
                          <a href="{{ URL('forms') }}" class="auto">
                            <i class="fa fa-list-ul"></i>
                            <span>{{ trans('sidebar.formlists') }}</span>
                          </a>
                        </li>
                        @if(!empty(Auth::user()->group_ids) && in_array('5993d8e53fd89d497105c2ef',Auth::user()->group_ids) == true || Auth::user()->firstname == 'admin')
                        <li >
                          <a href="{{ URL('report/oiltea/index') }}" class="auto">
                            <i class="fa fa-file-text-o"></i>
                            <span>{{ trans('sidebar.reportoiltea') }}</span>
                          </a>
                        </li>
                        @endif
                        @if(!empty(Auth::user()->group_ids) && in_array('59df0a403fd89ddc172d798a',Auth::user()->group_ids) == true || Auth::user()->firstname == 'admin')  

                        <li >
                          <a href="{{ URL('report/oiltea_jeelong/index') }}" class="auto">
                            <i class="fa fa-file-text-o"></i>
                            <span>{{ trans('sidebar.reportoilteajeelong') }}</span>
                          </a>
                        </li>                   
                        @endif
                        <li >
                          <a href="{{ URL('forms/trash/deleted') }}" class="auto">
                            <i class="fa fa-trash-o"></i>
                            <span>{{ trans('sidebar.trash') }}</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                  @endpermission-->
                  @permission('masterlists-menu')
                    <li>
                      <a href="{{ URL('masterlists') }}" class="auto">
                        <i class="fa fa-list-alt icon"></i>
                        <span class="font-bold">{{ trans('sidebar.masterlists') }}</span>
                      </a>
                    </li>
                  @endpermission
                  @if (Auth::user()->_id == '58fd6cc13fd89d8b529e4acf')
                  <li>
                    <a href="{{ URL('import/data/index') }}" class="auto">
                        <i class="fa fa-cloud">
                        </i>
                        <span class="font-bold">IMPORT DATA</span>
                      </a>
                  </li>
                  @endif
                  <!--
                    <li>
                      <a href="{{ URL('masterdata') }}" class="auto">
                        <i class="fa fa-list icon">
                        </i>
                        <span class="font-bold">{{ trans('sidebar.masterdata') }}</span>
                      </a>
                    </li>
                   -->
                  </ul>
                </nav>
                <!-- / nav -->
            </section>
            </footer>
          </section>
        </aside>
        <!-- /.aside -->