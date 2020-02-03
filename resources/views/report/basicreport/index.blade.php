@extends('theme')
@section('content')
<link rel="stylesheet" href="{{asset('theme/css/daterangepicker.css')}}" type="text/css" />
<div class="modal fade" id="insertColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="insertColumn"><strong><i class="fa fa-plus"></i> เพิ่มการตั้งค่าวันที่ Basic Report  </strong></h3>
      </div>
      <div class="modal-body">
          {!! Form::open(['method' => 'POST','route' => ['basicreport.store'],'id'=>'insertBasicReportSetting']) !!}
              <meta name="csrf-token" content="{{csrf_token()}}">
                <label class="col-form-label"><strong>ชื่อของข้อมูล</strong></label> 
                <input name="title" class="input-md form-control" type="text" required>
                <label class="col-form-label"><strong>ช่วงเวลาของชุดคำตอบ</strong></label> 
                <input name="dateRange" id="dateRange"  class="input-md form-control" onkeydown="return false" size="16" type="text">
                <input type="hidden" id="formId" name="formId" value="{{$form['data']['objectId']}}">     
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
      <button id="buttonInsertSheet" type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" form="insertBasicReportSetting" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="edit"><strong><i class="fa fa-edit"></i> แก้ไขการตั้งค่า Basic Report  </strong></h3>
      </div>
      <div class="modal-body">
          {!! Form::open(['method' => 'PATCH','route' => ['basicreport.update',$form['data']['objectId']],'id'=>'updateBasicReportSetting']) !!}
              <meta name="csrf-token" content="{{csrf_token()}}">
                <input id="objectId" name="objectId" class="input-md form-control" type="hidden" required>
                <label class="col-form-label"><strong>title</strong></label> 
                <input id="title" name="title" class="input-md form-control" type="text" required>
                <label class="col-form-label"><strong>ช่วงเวลาของชุดคำตอบ</strong></label> 
                <input name="dateRange" id="dateBetween"  class="input-md form-control" onkeydown="return false" size="16" type="text" required>
                <label class="col-form-label"><strong>สร้างเมื่อ</strong></label> 
                <input id="createdAt" name="createdAt" class="input-md form-control" type="text" disabled>
                <label class="col-form-label"><strong>สร้างโดย</strong></label> 
                <input id="createdBy" name="createdBy" class="input-md form-control" type="text" disabled>
                <label class="col-form-label"><strong>แก้ไขเมื่อ</strong></label> 
                <input id="updatedAt" name="updatedAt" class="input-md form-control" type="text" disabled>
                <label class="col-form-label"><strong>แก้ไขโดย</strong></label> 
                <input id="updatedBy" name="updatedBy" class="input-md form-control" type="text" disabled>     
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
      <button id="buttonInsertSheet" type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" form="updateBasicReportSetting" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-default" href="{{ url('report',$form['data']['objectId']) }}">
                    <i class="fa fa-backward"></i> กลับ</a>
                </div>
                <div class="pull-left">
                  <h2>ตั้งค่า Basic Report {{ $form['data']['title'] }}</h2>
                  <a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > 
                  <a href="{{ route('forms.show',$form['data']['objectId']) }}"><u>{{ $form['data']['title'] }}</u></a> > 
                  <a href="{{ URL('report',$form['data']['objectId']) }}"><u>รายงาน</u></a> >
                  ตั้งค่า Basic Report
                </div>
            </div>
        </div>
        <hr>
              <div class="pull-right">
                  <a class="btn btn-primary" data-toggle="modal" data-target="#insertColumn" href="#">
                    <i class="fa fa-plus"></i> เพิ่มการตั้งค่า Basic Report
                  </a> 
              </div>
              <table class="table">
                <thead>
                  <tr>
                    <th>ชื่อ</th>
                    <th width="50"></th>
                    <th width="50"></th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($basicReports as $basicReport)
                  <tr>
                    <a><td>{{ $basicReport['title'] }}</td></a>
                    <td>
                      <a 
                        id="modalEdit"
                        class="btn btn-default" 
                        data-toggle="modal" 
                        data-target="#edit" 
                        href="#" 
                        title="แก้ไขข้อมูล"
                        data-objectId="{{ $basicReport['objectId'] }}"
                        data-title="{{ $basicReport['title'] }}"
                        data-createdBy="{{ $basicReport['createdBy'] }}"
                        data-updatedBy="{{ $basicReport['updatedBy'] }}"
                        data-updatedAt="{{ $basicReport['updatedAt'] }}"
                        data-createdAt="{{ $basicReport['createdAt'] }}"
                        data-dateStart="{{ $basicReport['dateBetween'][0] }}"
                        data-dateEnd="{{ $basicReport['dateBetween'][1] }}"
                      >
                        <i class="fa fa-edit"></i>
                      </a>  
                    </td>
                    <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['basicreport.destroy', $basicReport['objectId']],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                      {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger','data-toggle'=>'tooltip','placement'=>'top','title'=>'ลบข้อมูล']) !!}
                    {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
    </section>
 </section>
</section>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<script>
  $('#dateRange').daterangepicker();
  $('#dateBetween').daterangepicker();

$(document).on("click", "#modalEdit", function () {
    $.ajax({
        url: 'show/'+$(this).data('objectid') ,
        dataType: 'json',
        success: function (data) {
          $(".modal-body #objectId").val(data['objectId']);
          $(".modal-body #title").val(data['title']);
          $(".modal-body #createdAt").val(data['createdAt']);
          $(".modal-body #createdBy").val(data['createdBy']);
          $(".modal-body #updatedAt").val(data['updatedAt']);
          $(".modal-body #updatedBy").val(data['updatedBy']);
          $(".modal-body #dateBetween").val(data['dateBetween']);
        },
        error: function (request, error) {
          alert("AJAX Call Error: " + error);
        }
    });
      

     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});
</script>
@endsection