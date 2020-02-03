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
                            <a class="btn btn-warning" href="{{ URL::to('/profile/resetPassword') }}">
                            <i class="fa fa-edit"></i> เปลี่ยนรหัสผ่าน</a>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ URL::to('/profile/edit') }}">
                            <i class="fa fa-edit"></i> แก้ไขข้อมูลส่วนตัว</a>
                        </div>
                    </div>
                </div>
            <hr>


            <section class="panel no-border bg-primary lt">
                <div class="panel-body">
                    <div class="row m-t-xl">
                        <div class="col-xs-3 text-right padder-v"></div>
                        <div class="col-xs-6 text-center">
                            <div class="inline">
                                <div class="easypiechart" data-percent="100" data-line-width="6" data-bar-color="#fff" data-track-Color="#2796de" data-scale-Color="false" data-size="140" data-line-cap='butt' data-animate="1000">
                                    <div class="thumb-lg avatar">
                                      <img src="" class="dker">
                                    </div>
                                </div>
                                <div class="h1 m-t m-b-xs font-bold text-lt">{{ $user->prefix }} {{ $user->firstname }} {{ $user->lastname }}</div>
                                <h4 class="text-muted m-b">{{ $user->position }}</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                        <footer class="panel-footer dk text-center no-border">
                        <div class="row pull-out">
                            <div class="col-xs-6">
                                <div class="padder-v">
                                @if(!empty($user['group_ids']))
                                    @foreach($user['group_ids'] as $v)	
			                        @foreach($groups as $group)
                                        @if($v == $group['_id'])	
                                            <span class="m-b-xs h3 text-white">{{ $group['name'] }}</span>
                                        @endif
                                    @endforeach
                                    @endforeach
                                @endif
                                    <br>
                                    <small class="text-muted">กลุ่ม</small>
                                </div>
                            </div>
                            <div class="col-xs-6 dker">
                                <div class="padder-v">
                                  <span class="m-b-xs h3 text-white">{{ $user->email }}</span>
                                  <br>
                                  <small class="text-muted">อีเมล์</small>
                                </div>
                            </div>
                        </div>
                        </footer>
                    </section>
	            </section>
	        </section>
        </section>
@endsection