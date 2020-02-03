@extends('theme')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@section('content')

<section class="vbox bg-white">
<section class="scrollable padder">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> แก้ไข </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('masterlists', array('id' => $idmasterlist) ) }}">
                <i class="fa fa-backward"></i> กลับ</a>
            </div>
        </div>
    </div>
    {!! Form::open(array('action' => array('MasterlistsController@fixitems', $id,$idmasterlist))) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4><strong>ชื่อรายการ: </strong></h4>
                @foreach($items as $item)
                    {!! Form::text('title', $item['title'], array('placeholder' => 'ชื่อ','class' => 'form-control')) !!}
                 @endforeach
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-block">บันทึก</button>
        </div>        
    </div>
   
    {!! Form::close() !!}
</section>
</section>
</section>
@endsection