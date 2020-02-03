@extends('theme')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                <i class="i i-data"></i> 
                โครงสร้างตาราง
            </h4>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-bordered m-b-none">
                <tr>
                    <th  style="text-align:center">Column</th>
                </tr>
                @if (!empty($items))
                    @foreach ($items as $key => $item)
                    <tr>
                        <td>{{ $item }}</td>
                    </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<section class="vbox bg-white">
<section class="scrollable padder">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>รายละเอียดรายการหลัก</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('masterdata.index') }}">
                <i class="fa fa-backward"></i> กลับ</a>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel panel-default">
                        <header class="panel-heading bg-light no-border">
                          <div class="clearfix">
                            <div class="clear">
                              <div class="h3 m-t-xs m-b-xs">
                                Master Data Name : {{ $masterdata['data']['title'] }} 
                              </div>
                              <small class="text-muted">สร้างเมื่อ : {{ DateThai((date('Y-m-d H:i:s', strtotime($masterdata['data']['createdAt'] . " +7 hour")))) }}</small>
                            </div>
                          </div>
                        </header>
                        <div class="list-group no-radius alt">
                          <a class="list-group-item" href="{{ URL('/masterdata/seach',$masterdata['data']['objectId']) }}">
                            <i class="i i-search"></i> 
                            ค้นหาและแก้ไข
                          </a>
                          <a class="list-group-item" href="#" data-toggle="modal" data-target="#myModal">
                            <i class="i i-data"></i>
                            โครงสร้างตาราง
                          </a>
                          <a class="list-group-item" href="{{ URL('/masterdata/download',$masterdata['data']['objectId']) }}">
                            <i class="i i-file-excel"></i> 
                            Download Master Data
                          </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
        @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-ok-sign"></i> {{ session()->get('message') }}
        </div>
         @endif 	
        @if (count($errors) > 0)
            <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
            <section class="panel panel-default">
                <header class="panel-heading bg-light no-border">
                    <strong>อัพโหลดไฟล์เพื่ออัพเดท Mater Data</strong>
                    <p>คุณสามารถอัพโหลดเฉพาะ record ที่ต้องการแก้ไขเท่านั้น และต้องมี column เหมือนกับ master data เดิมทั้งหมด</p>
                    {!! Form::open(array('enctype'=>'multipart/form-data','url' => ['masterdata/editReccord',$masterdata['data']['objectId']],'method'=>'POST')) !!}
                    <div class="form-group">
                        <label class=" control-label">เลือกไฟล์ที่ต้องการ</label>
                        <input name="fileupload" type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <button type="submit"  class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> กำลังอัพโหลด"><i class="i i-upload2"></i> อัพโหลด</button> 
                    </div>
                    {!! Form::close() !!}
                </header>
            </section>
        </div>
    </div>
</section>
</section>
</section>
@endsection