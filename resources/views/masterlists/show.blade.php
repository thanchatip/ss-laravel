@extends('theme')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@section('content')

<section class="vbox bg-white">
<section class="scrollable padder">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>รายละเอียดรายการหลัก</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('masterlists.index') }}">
                <i class="fa fa-backward"></i> กลับ</a>
            </div>
        </div>
    </div>
<div class="row">
        <div class="col-lg-12 col-md-6">
        <section class="panel b-a">
        <li class="list-group-item">
            <div class="panel-body">
                <div class="row m-t">
                @foreach($masterlists as $masterlist)
                    <div class="col-xs-12">
                        <h4>
                            <strong>Title :</strong>
                            {{ $masterlist['data']['title'] }}
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>Description :</strong>
                            {{ $masterlist['data']['description'] }}
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>Updated At :</strong>
                            {{ Carbon\Carbon::parse($masterlist['data']['updatedAt'])->format('d-M-Y H:i:s') }}
                        </h4>
                    </div>
                @endforeach
            </li>
            <li class="list-group-item">
                <div class="pull-left">
                    <h4><i class="fa fa-user"></i>  ผู้มีสิทธิ์เข้าใช้งาน</h4>
                </div>
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="300px">รหัสพนักงาน</th>
                        <th>ชื่อ-สกุล</th>
                    </tr>
                </thead>
                    <tbody>
                @foreach($userMasterlists as $userMasterlist)
                    <tr>
                        <td>{{ $userMasterlist['code'] }}</td>
                        <td>{{ $userMasterlist['firstname'] }} {{ $userMasterlist['lastname'] }}</td>
                    </tr>
                @endforeach
                    </tbody>
            </table>
            </li>
            
        </div>
    </div>
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
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
                <h2> รายการ  
                    <div class="pull-right">                  
                        <a class="btn btn-default" href="{{ URL('masterlists/export',$masterlist['data']['objectId'])}}">
                            <i class="i i-file-excel"></i> Export Items
                        </a>
                    </div>
                </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-6">
        {!! Form::open(array('action' => array('MasterlistsController@updateitem', $id))) !!}
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th width="20"><label class="checkbox m-n i-checks"><input type="checkbox"><i></i></label></th>
                        <th width="150px">ลำดับ</th>
                        <th>รายการ</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody class="tbd">
                @php($i=0) 
                @foreach($items as $key => $item)
                    @if(empty($item['deleted_at']))
                @php($i++)
                    <tr>
                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{ $i }}</td>
                        <td>{{ $item['data']['title'] }}</td>
                        <td>
                            <a href="{{ url('showitem', array('id' => $item['data']['objectId'],'idmasterlist'=>$id) ) }}" class="remove_button" title="Remove field"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <a href="{{ url('deleteitems', array('id' => $item['data']['objectId'],'idmasterlist'=>$id) ) }}" class="remove_button" onClick="return ConfirmDelete()" title="Remove field"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="button" class="btn circle btn-success add_button">เพิ่มรายการ
                </button>
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div class="test1">
        <br>
            <button type="submit" class="btn btn-primary btn-block submit">บันทึก</button>
        </div>
        </div>
        {!! Form::close() !!}
    </div> 
    
</section>
</section>
</section>
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 100; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.tbd'); //Input field wrapper
    var fieldHTML = '<tr id="myTableRow"><td></td><td></td><td><input class="form-control" type="text" name="items[]" value="" /></td><td><a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a></td><td></td></tr>'; //New input field html 
    var x = 1; //Initial field counter is 1
    if(x == 1){
        $( ".test1" ).hide();
    }
    $(addButton).click(function(){ //Once add button is clicked
        $( ".test1" ).show();
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        $(this).closest('#myTableRow').remove();
        x--; //Decrement field counter
        if(x == 1){
            $( ".test1" ).hide();
        }
    });

  

});
</script>
@endsection
