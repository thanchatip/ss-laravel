@extends('theme')
@section('content')
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.chosen-container{
    width: 375px !important;
}
</style>
<div class="modal fade" id="insertSheet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="insertSheet"><strong><i class="fa fa-plus"></i> เพิ่มชีท</strong></h3>
      </div>
      <div class="modal-body">
          {!! Form::open(['method' => 'POST','route' => ['customtable.store'],'id'=>'ForminsertSheet']) !!}
              <meta name="csrf-token" content="{{csrf_token()}}">
              <label class="col-form-label"><strong>ฟอร์ม :</strong></label>
              <select name="formData" class="form-control" id="formData">
              </select>
              <label class="col-form-label"><strong>ชื่อชีท :</strong></label>
              <input type="hidden" name="formId" id="formId" value="{{$form['data']['objectId']}}">
              <input type="text" name="sheetName" maxlength="31" class="form-control" required>
              <span class="label label-danger">
                * ชื่อชีทจำกัดแค่ 31 ตัวอักษร
              </span>
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" form="ForminsertSheet" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>
@if (!empty($customTableShow))
<div class="modal fade" id="editSheet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="editSheet"><strong><i class="fa fa-edit"></i> แก้ไขชื่อชีท</strong></h3>
      </div>
      <div class="modal-body">
          {!! Form::open(['method' => 'PATCH','route' => ['customtable.update', $customTableShow['data']['objectId']],'id'=>'editSheetName']) !!}
              <meta name="csrf-token" content="{{csrf_token()}}">
              <label class="col-form-label"><strong>ชื่อชีท :</strong></label>
                <input type="hidden" name="formId" value="{{$form['data']['objectId']}}">
                <input type="text" name="sheetName" maxlength="31" class="form-control" value="{{$customTableShow['data']['title']}}" required>
              <span class="label label-danger">
                * ชื่อชีทจำกัดแค่ 31 ตัวอักษร
              </span>
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" form="editSheetName" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="insertColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="insertColumn"><strong><i class="fa fa-plus"></i> เพิ่ม Column ของชีท {{$customTableShow['data']['title']}} </strong></h3>
      </div>
      <div class="modal-body">
          {!! Form::open(['method' => 'POST','route' => ['customtableitems.store', $customTableShow['data']['objectId']],'id'=>'insertCustomtableItems']) !!}
              <meta name="csrf-token" content="{{csrf_token()}}">
                <label class="col-form-label"><strong>คำถาม :</strong></label> 
                <select multiple class="chzn-select" id="questionData" name="questionData[]" required>
                  @foreach ($choiceQuestions as $key => $choiceQuestion) 
                    <optgroup label="{{ $key }}">
                      @foreach ($choiceQuestion as $keyQuestionId => $value)
                        <option value="{{ $keyQuestionId }}">{{ $value }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
                <input type="hidden" id="formId" name="formId" value="{{$form['data']['objectId']}}">
                <input type="hidden" name="customTableId" id="customTableId" value="{{ app('request')->input('objectId') }}">      
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
      <button id="buttonInsertSheet" type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" form="insertCustomtableItems" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>
@endif
<section class="hbox stretch">
  <!-- .aside -->
  <aside class="aside-lg" id="email-list">
    <section class="vbox">
      <header class="dker header clearfix">
          <button data-toggle="modal" data-target="#insertSheet" class="btn btn-md btn-bg btn-default" style="width: 100% !important;">
            <i class="fa fa-plus"></i> เพิ่มชีท
          </button>
      </header>
      <section class="scrollable hover w-f">
        <ul class="list-group auto no-radius m-b-none m-t-n-xxs list-group-lg">
          @if (count($errors) > 0)
            <li class="list-group-item">
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </li>
          @endif

        </ul>
      </section>
      <footer class="footer dk clearfix">
        <form class="m-t-sm">
          <div class="input-group">
            <input type="text" class="input-md form-control input-s-sm" placeholder="ค้นหาชีท">
            <div class="input-group-btn">
              <button class="btn btn-md btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </form>
      </footer>
    </section>
  </aside>
  <!-- /.aside -->
  <!-- .aside -->
  <aside id="email-content" class="bg-light lter">
    <section class="vbox">
      <section class="scrollable">
        <div>
          <div class="block clearfix wrapper b-b">
            <div class="pull-right inline"> 
              <a href="{{ config('app.ss_report') }}/customtable/{{$form['data']['objectId']}}?userId={{\Auth::user()->_id}}&type=csv" class="btn btn-s-sm btn-default"><i class="i i-file"></i> CSV</a>
              <a href="{{ config('app.ss_report') }}/customtable/{{$form['data']['objectId']}}?userId={{\Auth::user()->_id}}&type=xlsx" class="btn btn-s-sm btn-default"><i class="i i-file-excel"></i> EXCEL</a>                       
              <a class="btn btn-default" href="{{ url('report',$form['data']['objectId']) }}">
              <i class="fa fa-backward"></i> กลับ</a>
            </div>
            <h2>ตั้งค่า Custom Table {{ $form['data']['title'] }}</h2>
            <a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > 
            <a href="{{ route('forms.show',$form['data']['objectId']) }}"><u>{{ $form['data']['title'] }}</u></a> > 
            <a href="{{ URL('report',$form['data']['objectId']) }}"><u>รายงาน</u></a> >
            ตั้งค่า Custom Table
          </div>
        </div>
        @if (!empty($customTableShow))
        <div class="wrapper">
            <div class="pull-right inline">   
              <a class="btn btn-default" data-toggle="modal" data-target="#insertColumn" href="#">
                <i class="fa fa-plus"></i> เพิ่ม Column
              </a> 
              <a class="btn btn-default" data-toggle="modal" data-target="#editSheet" href="#">
                <i class="fa fa-edit"></i> แก้ไขชื่อชีท
              </a>                
						  {!! Form::open(['method' => 'DELETE','route' => ['customtable.destroy', $customTableShow['data']['objectId']],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
			            {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-danger','data-toggle'=>'tooltip','placement'=>'top','title'=>"ลบชีท"]) !!}
			        {!! Form::close() !!}
            </div>
            <font size="3">
              เวลาที่สร้าง : {{ DateThai((date('Y-m-d H:i:s', strtotime($customTableShow['data']['updatedAt'] . " +7 hour")))) }} |
              ผู้สร้าง : {{ $customTableShow['data']['createdBy'] }}
            </font>
            <br>
            <h3><strong>{{ $customTableShow['data']['title'] }}</strong></h3>
              <table class="table table-striped table-bordered m-b-none">
                <tbody>
                  @if (!empty($customTableItems))
                    @foreach ($customTableItems as $customTableItem)
                      <tr id="{{ $customTableItem['objectId'] }}">
                        <td> 
                        {{ $customTableItem['title'] }}
                          <div class="pull-right inline">
                            {!! Form::open(['method' => 'DELETE','route' => ['customtableitems.destroy', $customTableItem['objectId']],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                              {!! Form::button('ลบ Column', ['type' => 'submit','class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
        </div>
        @endif
      </section>
    </section>
  </aside>
  <!-- /.aside -->  
</section>
</section>
<script type="text/javascript">
  var formId = $('#formId').val();
  getData(formId);

  function getData (formId) {
    $.ajax({
      url: 'getFormsAndQuestions/' + formId ,
        dataType: 'json',
        success: getTable,
        error: function (request, error) {
          alert("AJAX Call Error: " + error);
        }
    });
  }

  function getSheet (formId) {
    $.ajax({
      url: 'getCustomTable/' + formId ,
        dataType: 'json',
        success: getCustomTable,
        error: function (request, error) {
          alert("AJAX Call Error: " + error);
        }
    });
  }

  function getCustomTable (data) {
    var customTableId = $('#customTableId').val();
    n = data.length 
    for (i=0;i<data.length;i++) {
      if (data[i]["objectId"] == customTableId) {
        $( ".list-group" ).append( 
          '<li id="'+data[i]["objectId"]+'" class="list-group-item list-group-item-success"> \
                  <a href="?objectId='+data[i]["objectId"]+'" class="clear text-ellipsis"> \
                    <strong class="block">' + data[i]["title"] + '<div class="pull-right"></div></strong> \
                  </a> \
          </li>'
        );
      } else {
        $( ".list-group" ).append( 
          '<li  id="'+data[i]["objectId"]+'" class="list-group-item"> \
                  <a href="?objectId='+data[i]["objectId"]+'" class="clear text-ellipsis"> \
                    <strong class="block">' + data[i]["title"] + '<div class="pull-right"></div></strong> \
                  </a> \
          </li>'
        );
      }
      n--;
    }
    $('.list-group').sortable();
  }

  function getTable (data) {
    //var id;
    var forms = new Array();

    Object.keys(data).forEach(function(key) {
      //id = data['formId']
      forms = data['choiceForms'];
      //questions = data['choiceQuestions'];
      //masterQuestions = data['choiceQuestions'][id];
    });
    for (key in forms) {
      $('#formData')
         .append($("<option></option>")
                    .attr("value",key)
                    .text(forms[key])); 

    }
    /*for (key in masterQuestions) {
      $('#questionData')
          .append($("<option></option>")
                      .attr("value",key)
                      .text(masterQuestions[key]));
      
    }*/
  }

	$( document ).ready(function() {  
    $('.chzn-select').chosen();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    getSheet(formId);
    $('tbody').sortable();

    $( "tbody" ).on( "sortupdate", function( event, ui ) {
      var listdata = $("tbody").sortable("toArray");
      var list = Object.values(listdata[0]['rows']);
      var customtableItemsId = [];
      for (i=0;i<list.length;i++) {
        if (list[i]['id']) {
          customtableItemsId.push(list[i]['id']);
        }
      } 
      $.ajax({
        type: "POST",
        url: "sortAble/customtableItems",
        data: {customtableItemsId:customtableItemsId},
        success: function(data){
          console.log(data);
        },
        error: function (xhr) {  }
      });
    });

    $( ".list-group" ).on( "sortupdate", function( event, ui ) {
      var listdata = $(".list-group li").sortable("toArray");
      var list = Object.values(listdata);
      var customtableId = [];
      for (i=0;i<list.length;i++) {
        if (list[i]['id']) {
          customtableId.push(list[i]['id']);
        }
      } 
      $.ajax({
        type: "POST",
        url: "sortAble/customtable",
        data: {customtableId:customtableId},
        success: function(data){

        },
        error: function (xhr) {  }
      });
    });


		/*$('#formData').change(function () {
		    var formId = $(this).val();
		    var formName = $('option:selected', this).text(); //to get selected text
        $('#questionData option').each(function() {
          $(this).remove();
        });
        for (key in questions[formId]) {
          $('#questionData')
              .append($("<option></option>")
                          .attr("value",key)
                          .text(questions[formId][key]));
        }
		    /*if(formId == '20170923133340-527866420224209-1749826') {
		    	$('#selectzone').hide().prop('required',false);
		    	$('#selectzone').prop('selectedIndex',0);
		    }
		    else {
		    	$('#selectzone').show().prop('required',true);
		    }
		});*/
	});
</script>
@endsection
