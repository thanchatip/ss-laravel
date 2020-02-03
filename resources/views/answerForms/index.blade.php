@extends('theme')
@section('content')
<link rel="stylesheet" href="{{asset('theme/css/daterangepicker.css')}}" type="text/css" />
<style type="text/css">
.i-info {
  color: #87ceeb;
}
</style>
<section class="vbox bg-white">
    <section class="scrollable padder">
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
<div class="row">
     <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-default" href="{{ route('forms.index') }}">
            <i class="fa fa-backward"></i> กลับ</a>
        </div>
        <div class="pull-left">
             <h2>{{ $form['data']['title'] }}</h2>
             <a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > {{ $form['data']['title'] }}
        </div>
     </div>
 </div>
<hr>
<div class="row m-t">
    <div class="col-md-12">
        <div class="doc-buttons">
            <a href="{{ route('forms.show',$form['data']['objectId']) }}" class="btn btn-s-xl btn-default">รายละเอียดฟอร์ม</a> 
            <a href="#" class="btn btn-s-xl btn-primary disabled">คำตอบทั้งหมด</a>
            <a href="{{ URL('report',$form['data']['objectId']) }}" class="btn btn-s-xl btn-default">รายงาน</a>               
        </div> 
    </div>
</div>   
  @if (Session::has('message'))
   <div class="alert alert-danger"><h4>{{ Session::get('message') }}</h4></div>
  @endif
        <footer class="panel-footer dk no-border">
            <div class="row pull-out">
                <div class="col-xs-12">
                    <div class="padder-v">
                        <li class="list-group-item">
                        <strong>ค้นหาคำตอบ</strong>
                            <hr>
                            {!! Form::open(['method' => 'GET','url' => ['answerForms',$id],'class'=>'form-inline','id'=>'formFilter']) !!}
                            <div class="checkbox i-checks">
                                    <label>
                                        <input type="checkbox" id="checkFromDate">
                                        <i></i>
                                        จากช่วงเวลา
                                    </label>
                                </div><br>
                                <div id="fromDate">
                                    <label>เลือกตาม : </label>
                                    <select name="typedate" class="form-control" id="type">
                                        @if ($data['typedate'] == "isoCreatedAt")
                                            <option value="isoCreatedAt" selected>วันที่สร้าง</option>
                                            <option value="isoUpdatedAt">วันที่แก้ไข</option>
                                        @elseif ($data['typedate'] == "isoUpdatedAt")
                                            <option value="isoUpdatedAt" selected>วันที่แก้ไข</option>
                                            <option value="isoCreatedAt">วันที่สร้าง</option>
                                        @else 
                                            <option value="isoCreatedAt" selected>วันที่สร้าง</option>
                                            <option value="isoUpdatedAt">วันที่แก้ไข</option>                                    
                                        @endif
                                    </select>
                                    <label>ตั้งแต่วันที่ : </label>
                                    <input name="dateRange" id="dateRange"  class="input-md form-control" onkeydown="return false" size="16" type="text" value="{{ $data['dateRange'] }}">
                                </div>
                                <div class="checkbox i-checks">
                                    <label>
                                        <input type="checkbox" id="checkFromPreview">
                                        <i></i>
                                        จากฟอร์มพรีวิว
                                    </label>
                                </div>
                                <a href="#" data-toggle="tooltip" data-placement="right" title="ค้นหาจากคำที่แสดงบนชุดคำถาม"><i class="i i-info"></i></a>
                                <br>
                                <div id="fromPreview">
                                    <label>ต้องมีคำนี้ : </label> <input type="text" name="preview" id="preview" value="{{ $data['preview'] }}" class="form-control">
                                </div>
                                <br>
                            {!! Form::close() !!}
                                <button class="btn btn-s-xl btn-primary" type="submit" form="formFilter" value="Submit" id="submitForm">
                                    ค้นหา
                                </button>
                                @if (!empty($data['dateRange'])|| !empty($data['preview']))
                                    <a href="{{ URL('answerForms',$form['data']['objectId']) }}" class="btn btn-s-xl btn-default">แสดงคำตอบทั้งหมด</a>
                                @endif
                        </li>
                        <div class="padder-v">
                            <li class="list-group-item">
                                <strong><i class="fa fa-list-ul"></i> คำตอบทั้งหมด {{ $answerForm->total() }} คำตอบ</strong>
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-s-md btn-success dropdown-toggle" data-toggle="dropdown">
                                            Export Data
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ config('app.ss_report') }}/autoExcelLv1/{{$id}}?userId={{$userId}}&typedate={{ substr($data['typedate'],5) }}&dateRange={{$data['dateRange']}}&preview={{$data['preview']}}&type=xlsx" target="_blank"><i class="i i-file-excel"></i> Excel</a></li>
                                            <li><a href="{{ config('app.ss_report') }}/customtable/{{$id}}?userId={{$userId}}&typedate={{ substr($data['typedate'],5) }}&dateRange={{$data['dateRange']}}&preview={{$data['preview']}}&type=xlsx" target="_blank"><i class="i i-file-excel"></i> Custom Table</a></li>
                                            <li><a href="{{ config('app.ss_report') }}/autoExcelLv1/downloadImg/{{$id}}?userId={{$userId}}"><i class="i i-images"></i> Images </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>        
                            @foreach($answerForm as $key => $value)
                            <li class="list-group-item">
                                <div class="pull-right">
                                    <a class="btn btn-default" href="{{ url('answerForms', array('id' => $value['objectId'],'idform' => $id) ) }}">
                                    <i class="fa fa-file-text-o"></i></a>
                                </div>
                                    <span style="color: black;" class="m-b-xs h4 block">{{ $value['answerPreview'] }}</span>
                                        <small>
                                            วันที่สร้าง : {{ DateThai((date('Y-m-d H:i:s', strtotime($value['createdAt'] . " +7 hour")))) }} | 
                                            วันที่แก้ไข : {{ DateThai((date('Y-m-d H:i:s', strtotime($value['updatedAt'] . " +7 hour")))) }} | 
                                            โดย : {{ $value['createdBy'] }}
                                        </small>
                            </li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {!! $answerForm->appends([
            'dateRange' => $data['dateRange'],
            'typedate' => $data['typedate'],
            'preview' => $data['preview'],
         ])->render() !!}
    </section>
        </div>
    </div>
 </section>
 </section>
</section>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<script type="text/javascript">  
    var dateRange = '{{$data['dateRange']}}';
    var preview = '{{$data['preview']}}';
    $('#dateRange').daterangepicker();
	$( document ).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        if (!dateRange) {
            $('#fromDate').hide();
            $("#dateRange").val("");
        } else {
            $('#checkFromDate').attr('checked', true); // Checks it
            $('#fromDate').show();
        }

        if (!preview) {
            $('#fromPreview').hide();
        } else {
            $('#checkFromPreview').attr('checked', true); // Checks it
            $('#fromPreview').show();
        }

        $('#checkFromDate').on('change', function(){ // on change of state
            if ($('input[type="checkbox"]:checked').length) {
                $('#submitForm').show();
            } else {
                $('#submitForm').hide();
            }
            if(this.checked) {
                $('#dateRange').prop('required',true);
                $('#fromDate').show();
            } else {
                $('#dateRange').prop('required',false);
                $("#dateRange").val("");
                $('#fromDate').hide();
            }
        })

        $('#checkFromPreview').on('change', function(){ // on change of state
            if ($('input[type="checkbox"]:checked').length) {
                $('#submitForm').show();
            } else {
                $('#submitForm').hide();
            }
            if(this.checked) {
                $('#preview').prop('required',true);
                $('#fromPreview').show();
            } else {
                $('#preview').prop('required',false);
                $("#preview").val("");
                $('#fromPreview').hide();
            }
        })
        if ($('input[type="checkbox"]:checked').length) {
            $('#submitForm').show();
        } else {
            $('#submitForm').hide();
        }
	});

</script>
@endsection