@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> รายละเอียดกลุ่ม</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('groups.index') }}">
                <i class="fa fa-backward"></i> กลับ</a>
            </div>
        </div>
    </div>
        <hr>
    <div class="row">
        <div class="col-lg-12 col-md-6">
            <section class="panel b-a">
                <div class="panel-heading no-border bg-default lt">
                    <a href="#" class="h4 text-lt m-t-sm m-b-sm block font-bold">ชื่อกลุ่ม : {{ $group->name }}</a>
                </div>
                <div class="panel-body">
                    <div id="b-c" class="text-center">
                        <div class="easypiechart inline m-b m-t" data-percent= "{{ $group->users->count() }}" data-line-width="10" data-bar-Color="#c2f0f1" data-track-Color="#f2f4f8" data-scale-Color="false" data-size="150" data-line-cap='butt' data-animate="2000">
                        <div>
                            <span class="h1 m-l-sm step font-bold"></span>
                            <div class="text text-xs text-muted">จำนวนสมาชิก</div>
                        </div>
                    </div>
                </div>
            </div>
            @if($status == 1 || Auth::user()->firstname == 'admin')
                <div class="clearfix panel-footer">
                    <h4 class="font-bold pull-left"><i class="fa fa-users text-muted"></i> สมาชิกในกลุ่ม
                    </h4>
                    <div class="pull-right">
                        <a class="btn btn-white form-control" href="{{ url('/import/groups/users',$group->_id) }}"><i class="fa fa-plus"></i> นำเข้าสมาชิก</a>		
				        <a class="btn btn-white form-control" href="{{ url('/export/users/group',$group->_id) }}"><i class="fa fa-download"></i> ส่งออกไฟล์สมาชิก</a>
                    </div>
                </div>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th width="150px">รหัสพนักงาน</th>
                        <th>ชื่อ-สกุล</th>
                        <th>อีเมล์</th>
                        <th width="150px">สิทธิ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $users)
                    @foreach($users->users as $user)
                    @if($user->deleted_at == '')
                    <tr>
                        <td>{{ $user->code }}</td>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td width="100px">
            
                        @foreach($users['user_ids'] as $status)
                        {!! Form::open(['method' => 'POST','onsubmit' => 'return ConfirmAddStatus()','action' => array('GroupsController@updatepermission',"$group->_id")]) !!}
                                @if($status['user_id'] == $user->_id && $status['status'] == '1')
                                <input type="hidden" name="permission" value="1">
                                <input type="hidden" name="userid" value="<?php echo $user->_id ?>">
                                <button class="btn btn-sm btn-success" type="submit" >
                                admin
                                </button>
                                @elseif($status['user_id'] == $user->_id && $status['status'] == '0')
                                <input type="hidden" name="permission" value="0">
                                <input type="hidden" name="userid" value="<?php echo $user->_id ?>">
                                <button class="btn btn-sm btn-default" type="submit" >
                                user
                                </button>
                                @endif
                        {!! Form::close() !!}
                        @endforeach   
                        </td>
                        <td>
                            <a href="{{ url('groups/edituser', array('id'=>$user->_id,'groupid'=>$group->_id) ) }}" title="Edit field"><i class="fa fa-edit"></i></a>  
                            <a href="{{ url('groups/deleteuser', array('userid'=>$user->_id,'groupid'=>$group->_id) ) }}" class="remove_button" onClick="return ConfirmDelete()" title="Remove field"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    @endif 
                   @endforeach
                @endforeach

                {!! Form::open(array('action' => array('GroupsController@adduser', $group->_id))) !!}
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="text" class="typeahead form-control" name="username" placeholder="Input firstname...." >
                        </td>
                        <td>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                            {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            @if ($message = Session::get('danger'))
                                <div class="alert alert-danger">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
            </section>
                <button type="submit" class="btn btn-primary btn-block">เพิ่มสมาชิก</button>
            {!! Form::close() !!}
            @else
                    <div class="clearfix panel-footer">
                        <h4 class="font-bold pull-left"><i class="fa fa-users text-muted"></i> สมาชิกในกลุ่ม
                        </h4>
                    </div>
                    <table class="table table-striped b-t b-light">
                        <tr>
                            <th>รหัสพนักงาน</th>
                            <th>ชื่อ-สกุล</th>
                            <th>อีเมล์</th>
                        </tr>
            @foreach ($users as $users)
                @foreach($users->users as $user)
                @if($user->deleted_at == '')
                        <tr>
                            <td>{{ $user->code }}</td>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                @endif
                @endforeach
            @endforeach
            @endif
                 </table>
        </div>
    </div>
        </section>
</section>
</section>
    <script type="text/javascript">
        var path = "{{ URL::to('/autocomplete?username={username}') }}";
            $('input.typeahead').typeahead({
                source:  function (query, process) {
                    return $.get(path, { query: query }, function (data) {
                        return process(data);
                });
            }
        });
    </script>
<script src="{{asset('js/app.js')}}"></script>
@endsection