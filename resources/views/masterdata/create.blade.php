@extends('theme')
@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>อัพโหลดไฟล์ Master Data</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default" href="{{ route('masterdata.index') }}">
                        <i class="fa fa-backward"></i> กลับ</a>
                    </div>
                </div>
            </div>
            <hr>
            @if (empty($masterdata))
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <span class="help-block m-b-none">
                            <p>
                                - .xls ชื่อชีท จะถูกใช้เป็นชื่อ master data เป็นค่าเริ่มต้น
                            </p>
                            <p>
                                - .csv ชื่อไฟล์จะถูกใช้เป็นชื่อ master data เป็นค่าเริ่มต้น
                            </p>
                        </span>
                    </div>
                    {!! Form::open(array('enctype'=>'multipart/form-data','url' => 'masterdata','method'=>'POST')) !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">File input</label>
                        <div class="col-sm-10">
                            <input name="fileupload" type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit"  class="btn btn-primary" id="btn-upload" data-loading-text="<i class='fa fa-spinner fa-spin'></i> กำลังอัพโหลด"><i class="i i-upload2"></i> อัพโหลด</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @else
                <section class="panel panel-default">
                    <header class="panel-heading">                    
                      <span class="label bg-success">อัพโหลดสำเร็จ</span> พบ {{ count($masterdata) }} master data กรุณาตรวจสอบ เพิ่มเติม หรือแก้ไขชื่อของ master data ได้ดังนี้
                    </header>
                    {!! Form::open(array('enctype'=>'multipart/form-data','url' => 'masterdata/checktitle','method'=>'POST')) !!}
                    <section class="panel-body">
                        @foreach ($masterdata as $masterdata)
                        <div class="form-group">
                            <input type="text" name="title[{{$masterdata['objectId']}}]" class="form-control" value="{{ $masterdata['title'] }}" required>
                        </div>
                        @endforeach
                        <button type="submit"  class="btn btn-primary form-control" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">ยืนยัน</button>
                    </section>
                    {!! Form::close() !!}
                </section>
            @endif
        </section>
    </section>
</section>
@endsection