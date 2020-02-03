@extends('theme')
@section('content')
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="row">
        <div class="col-md-12">

        @permission('users-menu')

        <div class="col-md-3 col-sm-6">

            <div class="panel b-a">
                <div class="panel-heading no-border bg-success lt text-center">
                    <a href="{{ route('users.index') }}">
                        <i class="fa fa-user fa fa-4x m-t m-b text-white"></i>
                    </a>
                </div>
                <div class="padder-v text-center clearfix">
                    <div class="h3 font-bold">USERS</div>
                </div>
            </div>
        </div>
        @endpermission
        @permission('groups-menu')
        <div class="col-md-3 col-sm-6">
            <div class="panel b-a">
                <div class="panel-heading no-border bg-warning lt text-center">
                    <a href="{{ route('groups.index') }}">
                        <i class="fa fa-plus fa fa-4x m-t m-b text-white"></i>
                    </a>
                </div>
                <div class="padder-v text-center clearfix">
                    <div class="h3 font-bold">GROUPS</div>
                </div>
            </div>
        </div>
        @endpermission
        @permission('roles-menu')
        <div class="col-md-3 col-sm-6">
            <div class="panel b-a">
                <div class="panel-heading no-border bg-primary lt text-center">
                    <a href="{{ route('roles.index') }}">
                        <i class="fa fa-key fa fa-4x m-t m-b text-white"></i>
                    </a>
                </div>
                <div class="padder-v text-center clearfix">
                    <div class="h3 font-bold">ROLES</div>
                </div>
            </div>
        </div>
        @endpermission
        @permission('permissions-menu')
        <div class="col-md-3 col-sm-6">
            <div class="panel b-a">
                <div class="panel-heading no-border bg-info lt text-center">
                    <a href="{{ route('permissions.index') }}">
                        <i class="fa fa-lock fa fa-4x m-t m-b text-white"></i>
                    </a>
                </div>
                <div class="padder-v text-center clearfix">
                    <div class="h3 font-bold">PERMISSIONS</div>
                </div>
            </div>
        </div>
        @endpermission
        @permission('forms-menu')
        <div class="col-md-3 col-sm-6">
            <div class="panel b-a">
                <div class="panel-heading no-border bg-danger lt text-center">
                    <a href="{{ route('forms.index') }}">
                        <i class="fa fa-archive fa fa-4x m-t m-b text-white"></i>
                    </a>
                </div>
                <div class="padder-v text-center clearfix">
                    <div class="h3 font-bold">FORMS</div>
                </div>
            </div>
        </div>
        @endpermission
        @permission('masterlists-menu')
        <div class="col-md-3 col-sm-6">
            <div class="panel b-a">
                <div class="panel-heading no-border bg-dark lt text-center">
                    <a href="{{ route('masterlists.index') }}">
                        <i class="fa fa-list fa fa-4x m-t m-b text-white"></i>
                    </a>
                </div>
                <div class="padder-v text-center clearfix">
                    <div class="h3 font-bold">MASTER LIST</div>
                </div>
            </div>
        </div>
        @endpermission
        
    </div>
</div>
</section>
@endsection
