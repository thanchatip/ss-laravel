@extends('theme')
@section('content')
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="btn-group">
            <button type="button" class="btn btn-dark" disabled>Menu</button>
            <button type="button" class="btn btn-default"><a href="{{ url('/report/oilteav2/index') }}">Report</a></button>
            <button type="button" class="btn btn-default active"><a href="{{ url('/report/oilteav2/validate') }}">Check Data</a></button>
        </div>
        <div class="row">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2><i class="fa fa-user"></i>
                รายงาน {{ $forms[0]['title'] }}
              </h2>
              <a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > 
              <a href="{{ route('forms.show',$forms[0]['objectId']) }}"><u>{{ $forms[0]['title'] }}</u></a> > 
              <a href="{{ URL('report',$forms[0]['objectId']) }}"><u>รายงาน</u></a> > CUSTOM REPORT
            </div>
            <div class="pull-right">
              <a class="btn btn-default" href="{{ URL('report',$forms[0]['objectId']) }}">
              <i class="fa fa-backward"></i> กลับ</a>
            </div>
          </div>
        </div>
        <hr>
        @if (Session::has('message'))
          <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <div style="font-size: 17.5px;">{{ Session::get('message') }}</div> 
          </div>
        @endif
              @if (!empty($answerForms))
              <div class="row">
                <div class="col-sm-12">
                    <section class="panel panel-default">
                      <header class="panel-heading">
                        <span class="h4">answerPreview : {{ $answerForms['answerPreview'] }}</span>
                      </header>
                    </section>
                </div>
              </div>
              @endif
              <div class="row">
                <div class="col-sm-3">
                  {!! Form::open(['method' => 'POST','action'=>array('CustomizeExcel\oilteav2\validateController@validateData')]) !!}
                    <section class="panel panel-default">
                      <div class="panel-body">
                        <div class="form-group">
                          <label>เลขที่แปลง</label>
                          <input type="text" value="{{request()->get('plantNumber')}}" name="plantNumber" class="form-control" placeholder="required field" required>                        
                        </div>
                      </div>
                      <footer class="panel-footer text-right bg-light lter">
                        @if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
                        <button type="submit" class="btn btn-success btn-s-xs">ตกลง</button>
                        @else
                        <button type="submit" class="btn btn-success btn-s-xs" disabled>ตกลง</button>
                        @endif
                      </footer>
                    </section>
                  {!! Form::close() !!}
                </div>
                <div class="col-sm-9">
                    <section class="panel panel-default">
                    @if (!empty($countTree))
                      <header class="panel-heading">
                        <span class="h3"><center>ต้นชาน้ำมันทั้งหมดของเลขแปลง {{ request()->get('plantNumber') }} จำนวน {{ $countTree }} ต้น</center></span>
                      </header>
                    @endif
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                  ต้นชาน้ำมันที่ไม่มีข้อมูลปี 2562
                                  @if(!empty($notYear2562)) 
                                    (จำนวน {{count($notYear2562)}} ต้น) 
                                  @else
                                    (จำนวน 0 ต้น) 
                                  @endif
                                </th> 
                                <th>
                                  ต้นชาน้ำมันที่มีข้อมูลปี 2562 มากกว่า 1 คำตอบ
                                  @if(!empty($than2Year2562)) 
                                    (จำนวน {{count($than2Year2562)}} ต้น) 
                                  @else
                                    (จำนวน 0 ต้น) 
                                  @endif
                                </th>
                            </tr>
                          </thead>
                          <tbody>
                            @if (!empty($notYear2562) || !empty($than2Year2562))
                              <tr>
                                @if(!empty($notYear2562)) 
                                <td>
                                  <center>
                                  @foreach ($notYear2562 as $notYear2562)
                                    เลขต้น : {{$notYear2562}} <br>
                                  @endforeach
                                  </center>
                                </td>
                                @else
                                  <td>
                                  </td>
                                @endif
                                @if(!empty($than2Year2562))
                                  <td>
                                    <center>
                                    @foreach ($than2Year2562 as $than2Year2562)
                                      เลขต้น : {{$than2Year2562}} <br>
                                    @endforeach
                                    </center>
                                  </td>
                                @else
                                  <td>
                                  </td>
                                @endif
                              </tr>
                            @elseif (empty(request()->get('plantNumber')))
                              <td colspan="2"><center>เมื่อกรอกเลขที่แปลง และกดปุ่มตกลงข้อมูลจะแสดงที่นี่ !</center></td>
                            @else
                              <td><center>-</center></td>
                              <td><center>-</center></td>
                            @endif
                            </tr>
                          </tbody>
                      </table>
                    </section>
                </div>
              </div>

	</section>
	</section>
</section>
@endsection
