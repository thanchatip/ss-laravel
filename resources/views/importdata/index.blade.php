@extends('theme')
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Import Data</h2>
                    </div>
                </div>
            </div>
            <hr>
            <h3 id="typetemplate" class="text-success">Documentation<small> </small></h3>
              <p>สามารถเข้าไปดูวิธีการใช้งานได้ที่ <strong><a target="_blank" href="{{ URL::to('/import/data/documents') }}">Documentation</a></strong></p>
            <div class="row">
                <div class="col-sm-6">
                  <section class="panel panel-default">
                    <header class="panel-heading font-bold">Download Template</header>
                    <div class="panel-body">
                        @if(session()->has('templateRequired'))
                            <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>Required !</strong></h4><h5>{{ session()->get('templateRequired') }}</h5>
                            </div>
                        @endif
                        {!! Form::open(array('class'=>'bs-example form-horizontal','id'=>'template','enctype'=>'multipart/form-data','url' => 'import/template/download','method'=>'POST')) !!}
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Form</label>
                          <div class="col-lg-10">
                            <select name='formId' style='width:200px;'  class="chosen-select">
                                <optgroup label="Form">
                                    <option value="" selected></option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form['objectId'] }}">{{ $form['title'] }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <button type="submit" form="template" class="btn btn-primary btn-s-xs"> Download</button>
                            <span class="help-block m-b-none">template จะเป็นไฟล์ .xlsx</span>
                          </div>
                        </div>
                        {!! Form::close() !!}
                        <hr>
                        @if(session()->has('templateChoiceRequired'))
                            <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>Required !</strong></h4><h5>{{ session()->get('templateChoiceRequired') }}</h5>
                            </div>
                        @endif
                        {!! Form::open(array('class'=>'bs-example form-horizontal','id'=>'templateChoice','enctype'=>'multipart/form-data','url' => 'import/templateChoice/download','method'=>'POST')) !!}
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Form</label>
                          <div class="col-lg-10">
                            <select name='Choice' style='width:200px;'  class="chosen-select">
                                <optgroup label="Form">
                                    <option value="" selected></option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form['objectId'] }}">{{ $form['title'] }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <button type="submit" form="templateChoice" class="btn btn-primary btn-s-xs"> Download</button>
                            <span class="help-block m-b-none">Choice ของคำถามใน ฟอร์ม</span>
                          </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <footer class="panel-footer text-right bg-light lter">
                        
                    </footer>
                  </section>
                </div>
                <div class="col-sm-6">
                  <section class="panel panel-default">
                    <header class="panel-heading font-bold">Import Data</header>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session()->has('templateError'))
                            <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>รุปแบบเทลมเพลตผิดพลาด !</strong></h4><h5>{{ session()->get('templateError') }}</h5>
                            </div>
                        @elseif (session()->has('answerFormError'))
                            <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>รูปแบบคำตอบผิดพลาด !</strong></h4><h5>{{ session()->get('answerFormError') }}</h5>
                            </div>
                        @elseif (session()->has('importSuccess'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>นำเข้าข้อมูลสำเร็จ !</strong></h4><h5>{{ session()->get('importSuccess') }}</h5>
                        </div>
                        @endif
                        {!! Form::open(array('class'=>'bs-example form-horizontal','id'=>'importData','enctype'=>'multipart/form-data','url' => 'import/data','method'=>'POST')) !!}
                        <div class="form-group">
                          <label class="col-lg-2 control-label">File</label>
                          <div class="col-lg-10">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="fileupload" type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <span class="help-block m-b-none">อัพโหลไฟล์ .xlsx เพื่มเพิ่มข้อมูลในฐานข้อมูล</span>
                          </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <footer class="panel-footer text-right bg-light lter">
                        <button type="submit" form="importData" class="btn btn-primary btn-s-xs" id="btn-upload" data-loading-text="<i class='fa fa-spinner fa-spin'></i> กำลังอัพโหลด"> Upload</button>
                    </footer>
                  </section>
                </div>
            </div>
            <!--
            <div class="row">
                <div class="col-sm-12">
                  <section class="panel panel-default">
                    <header class="panel-heading font-bold">แมทค่า MSI ของวิจัยชาน้ำมัน</header>
                    <div class="panel-body">
                        @if(session()->has('msiSuccess'))
                            <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>Import Success</strong></h4><h5>{{ session()->get('msiSuccess') }}</h5>
                            </div>
                        @elseif (session()->has('msiError'))
                            <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>Wrong Data !</strong></h4><h5>{{ session()->get('msiError') }}</h5>
                            </div>
                        @endif
                        {!! Form::open(array('class'=>'bs-example form-horizontal','id'=>'matchMSI','enctype'=>'multipart/form-data','url' => 'import/matchMSI','method'=>'POST')) !!}
                        <div class="form-group">
                          <label class="col-lg-2 control-label">File</label>
                          <div class="col-lg-10">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="fileupload" type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <span class="help-block m-b-none">อัพโหลไฟล์ .xlsx เพื่มเพิ่มข้อมูลในฐานข้อมูล</span>
                          </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <footer class="panel-footer text-right bg-light lter">
                        <button type="submit" form="matchMSI" class="btn btn-primary btn-s-xs" id="btn-upload" data-loading-text="<i class='fa fa-spinner fa-spin'></i> กำลังอัพโหลด"> Upload</button>
                    </footer>
                  </section>
                </div>
            </div>
            -->

            
            <div class="row">
                <div class="col-sm-12">
                  <section class="panel panel-default">
                    <header class="panel-heading font-bold">แมทรหัสครัวเรือนโครงการห้วยส้าน</header>
                    <div class="panel-body">
                        @if(session()->has('msiSuccess'))
                            <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>Import Success</strong></h4><h5>{{ session()->get('msiSuccess') }}</h5>
                            </div>
                        @elseif (session()->has('msiError'))
                            <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><strong>Wrong Data !</strong></h4><h5>{{ session()->get('msiError') }}</h5>
                            </div>
                        @endif
                        {!! Form::open(array('class'=>'bs-example form-horizontal','id'=>'importHuaisanData','enctype'=>'multipart/form-data','url' => 'import/importHuaisanData','method'=>'POST')) !!}
                        <div class="form-group">
                          <label class="col-lg-2 control-label">File</label>
                          <div class="col-lg-10">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="fileupload" type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <span class="help-block m-b-none">อัพโหลไฟล์ .xlsx เพื่มเพิ่มข้อมูลในฐานข้อมูล</span>
                          </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <footer class="panel-footer text-right bg-light lter">
                        <button type="submit" form="importHuaisanData" class="btn btn-primary btn-s-xs" id="btn-upload" data-loading-text="<i class='fa fa-spinner fa-spin'></i> กำลังอัพโหลด"> Upload</button>
                    </footer>
                  </section>
                </div>
            </div>
            
        </section>
    </section>
</section>
<script>
        $(document).ready(function () {
            $('.chzn-select').chosen();
        });
</script>
@endsection