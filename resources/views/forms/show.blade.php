@extends('theme')
@section('content')
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
            <a href="#" class="btn btn-s-xl btn-primary disabled">รายละเอียดฟอร์ม</a> 
            <a href="{{ URL('answerForms',$form['data']['objectId']) }}" class="btn btn-s-xl btn-default">คำตอบทั้งหมด</a>
            <a href="{{ URL('report',$form['data']['objectId']) }}" class="btn btn-s-xl btn-default">รายงาน</a>
            <a class="pull-right btn btn-primary"  href="{{ URL('forms/admin/access',$form['data']['objectId'])}}">
				<i class="i i-user2"></i>
                    ผู้ใช้ที่สามารถเข้าถึงได้
			</a>               
        </div> 
    </div>
</div> 
    <div class="row m-t">
        <div class="col-xs-12">
        <section class="panel b-a">
        <li class="list-group-item">
            <div class="panel-body">
                    <div class="col-xs-12">
                        <h4>
                            <strong>คำอธิบาย :</strong>
                            @if (empty($form['data']['formDescription']))
                                <span class="label label-danger">ไม่มี</span>
                            @else
                                {{ $form['data']['formDescription'] }}
                            @endif
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>สร้างโดย :</strong>
                            {{ $form['data']['createdBy'] }}
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>ตัวอย่างพรีวิว :</strong>
                            {{ $form['data']['previewExample'] }}
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>แก้ไขล่าสุด :</strong>
                            {{ DateThai((date('Y-m-d H:i:s', strtotime($form['data']['updatedAt'] . " +7 hour")))) }}
                        </h4>
                    </div>
             </div>
        </li>
        </section>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4">
            <center>
                <font size="24">{{$countAnswerForm}}</font>
                <br>คำตอบ            
            </center>
        </div>
        <div class="col-xs-4">
            <center>
                <font size="24">{{$countAnswerFormDeleted}}</font>
                <br>คำตอบที่ถูกลบ
            </center>
        </div>
        <div class="col-xs-4">
            <center>
                <font size="24">{{$countUserPermission}}</font>
                <br>คนที่เข้าถึงได้ 
            </center>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4">
            <center>
                <font size="24">0</font>
                <br>Master Data            
            </center>
        </div>
        <div class="col-xs-4">
            <center>
                <font size="24">{{$countMasterLists}}</font>
                <br>Master List
            </center>
        </div>
        <div class="col-xs-4">
            <center>
                <font size="24">{{$countInnerForms}}</font>
                <br>Inner Form 
            </center>
        </div>
    </div>
 </section>
 </section>
</section>
@endsection