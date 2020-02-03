@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>ข้อมูลผู้ใช้</h2>
	        </div>

	        <div class="pull-right">
	        	<a class="btn btn-default" href="{{ URL::previous() }}">
	        	<i class="fa fa-backward"></i> กลับ</a>
	        </div>
	    </div>
	</div>
<hr>
<div class="row">
        <div class="col-lg-12 col-md-6">
            <section class="panel b-a">
            <div class="panel-body">
                <div class="col-lg-6">
                    <div class="padder-v text-center">
                        <span class="m-b-xs h3 block text-dark">
                        @if(!empty($user['group_ids']))
                        @foreach($user['group_ids'] as $v)	
			                @foreach($groups as $group)
                                @if($v == $group['_id'])	
                                    <span class="label label-default label-md">{{ $group['name'] }}</span>
                                @endif
                            @endforeach
                        @endforeach
                        @endif
                        </span><br>
                        <small class="h4 text-muted">กลุ่ม</small>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="padder-v text-center">
                        <span class="m-b-xs h3 block text-dark">
                        @if(!empty($user->roles))
                            @foreach($user->roles as $v)
                            <span class="label label-default label-md">{{ $v->display_name }}</span>
                            @endforeach
                        @endif</span><br>
                        <small class="h4 text-muted">สิทธิ์การใช้งาน</small>
                    </div>
                </div>
            </div>
            <footer class="panel-footer dk text-center no-border">
                <div class="row pull-out">
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <span class="m-b-xs h3 block text-dark">{{ $user->code }}</span>
                            <small class="h4 text-muted">รหัสพนักงาน</small>
                        </div>
                    </div>
                    <div class="col-xs-4 dker">
                        <div class="padder-v">
                            <span class="m-b-xs h3 block text-dark">{{ $user->prefix }} {{ $user->firstname }} {{ $user->lastname }}</span>
                            <small class="h4 text-muted">ชื่อ-สกุล</small>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="padder-v">
                            <span class="m-b-xs h3 block text-dark">{{ $user->email }}</span>
                            <small class="h4 text-muted">อีเมล์</small>
                        </div>
                    </div>
                </div>
            </footer>
            </section>
        </div>
    </div> 

@if(Auth::user()->firstname == 'admin')
    <div class="row">
        <div class="col-lg-12 col-md-6">
            <div class="pull-left">
                <h2>ฟอร์มการใช้งาน</h2>
            </div>
            <table class="table table-striped b-t b-light">
                <tbody>
                @if(!empty($user->form_ids))
                @foreach($user->form_ids as $formIds)
                    <tr>
                    @foreach($forms as $form)
                        @if($form['objectId'] == $formIds['form_id'])
                            <td>{{ $form['title'] }}</td>
                        @endif
                    @endforeach
                    @foreach($questionRoleCode as $key => $questionRole)
                    <td width="100px">
                    {!! Form::open(['method' => 'POST','action' => array('FormsController@updateAccessQuestion', $formIds['form_id'],$user->id)]) !!}
                        <input name="questionFormRoleCode" value="{{$questionRole['roleCode']}}" type="hidden">
                        @if($questionRole['roleCode'] == $formIds['questionFormRoleCode'])
                            <button class="btn btn-sm btn-primary" type="submit">{{$questionRole['display_name']}}</button>
                        @else
                            <button class="btn btn-sm btn-default" type="submit">{{$questionRole['display_name']}}</button>
                        @endif
                    </td>
                    {!! Form::close() !!}
		            @endforeach
                    @foreach($answerRoleCode as $key => $answerRole)
                    {!! Form::open(['method' => 'POST','action' => array('FormsController@updateAccessAnswer', $formIds['form_id'],$user->id)]) !!}
                        <td width="100px">	
                            <input name="answerFormRoleCode" value="{{$answerRole['roleCode']}}" type="hidden">
                            @if($answerRole['roleCode'] == $formIds['answerFormRoleCode'])
                                <button class="btn btn-sm btn-primary" type="submit">{{$answerRole['display_name']}}</button>
                            @else
                                <button class="btn btn-sm btn-default" type="submit">{{$answerRole['display_name']}}</button>
                            @endif
                        </td>
                    {!! Form::close() !!}
                    @endforeach
                        <td>
                            {!! Form::open(['method' => 'DELETE','action' => array('FormsController@destroyPermission', $formIds['form_id'],$user->id),'onsubmit' => 'return ConfirmDelete()']) !!}
			                {!! Form::button('<i class="fa fa-times"></i>', ['type' => 'submit','class' => 'btn btn-default no-border']) !!}
        	                {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endif 

	</section>
	</section>
</section>
@endsection