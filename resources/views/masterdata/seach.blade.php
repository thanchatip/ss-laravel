@extends('theme')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@section('content')
<style>

</style>
<section class="vbox bg-white">
<section class="scrollable padder">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>
                    <i class="i i-search"></i> ค้นหาและแก้ไข Master Data
                </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ URL('masterdata',$masterdata['data.objectId']) }}">
                <i class="fa fa-backward"></i> กลับ</a>
            </div>
        </div>
    </div>
    <hr>
    <section class="panel panel-default">
        <header class="panel-heading font-bold">
            ค้นหา Master Data Name : {{ $masterdata['data.title'] }}
        </header>
        <div class="panel-body">
            {!! Form::open(array('data-validate'=>'parsley','id'=>'formSearch','class'=>'form-horizontal','url' => ['/masterdata/seach',$masterdata['data.objectId']],'method'=>'GET')) !!}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Attribute</label>
                    <div class="col-sm-10">
                        <select class="chzn-select" id="attribute" class="form-control" name="attribute" data-required="true">
                            @foreach ($attributes as $key => $attribute) 
                                @if ($key == app('request')->input('attribute'))
                                    <option value="{{ $key }}" selected>{{ $attribute }}</option>
                                @endif
                                <option value="{{ $key }}">{{ $attribute }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Value</label>
                    <div class="col-sm-10">
                        <div class="col-lg-4 m-l-n">
                            <input id="value" type="text" name="value" class="form-control" value="{{ app('request')->input('value') }}" data-required="true">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Value Type</label>
                    <div class="col-sm-10">
                        <div class="col-lg-2 m-l-n">
                            <select name="valueType" class="form-control m-b">
                                @if (app('request')->input('valueType') == 'numeric')
                                    <option value="string">อักขระ</option>
                                    <option value="numeric" selected>ตัวเลข</option>
                                @else
                                    <option value="string" selected>อักขระ</option>
                                    <option value="numeric">ตัวเลข</option>
                                @endif
                            </select>
                        </div>
                      </div>
                    </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button id="btn-reset" type="button" class="btn btn-default reset" value="Reset">ล้าง</button>
                        <button type="submit" class="btn btn-primary"><i class="i i-search"></i> ค้นหา</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </section>
    @if (!empty(app('request')->input('attribute')) && !empty(app('request')->input('value')))
    @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-ok-sign"></i> {{ session()->get('message') }}
        </div>
    @endif 	
    <section class="panel panel-default">
        <header class="panel-heading">
            ผลการค้นหา {{ count($masterdataItem) }}	ไอเท็ม
        </header>
        @if (count($masterdataItem) > 0)
        <div class="table-responsive" style="overflow-x:scroll;">
            <table class="table table-striped m-b-none">
            {!! Form::open(array('id'=>'formedit','class'=>'form-horizontal','url' => ['masterdata',$masterdata['data.objectId']],'method'=>'PUT','onsubmit' => 'return confirmEdit()')) !!}
                <thead>
                    <tr>
                        <th width="20"><label class="checkbox m-n i-checks"><input type="checkbox"><i></i></label></th>
                        @foreach ($masterdata['data']['attribute'] as $key => $attribute)
                        <th>{{ $attribute }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($masterdataItem as $masterdataValue)
                        <tr> 
                            <td><label class="checkbox m-n i-checks"><input type="checkbox" class="form-control"  value="{{$key}}" name="ids[]"><i></i></label></td>
                            @foreach ($masterdataValue['items'] as $key => $items) 
                                @if (gettype($items) == 'string')
                                    <td><input type="text" name="{{ $masterdataValue['objectId'] }}[]" class="form-control" value="{{ $items }}"></td>
                                @elseif (gettype($items) == 'double' || gettype($items) == 'integer')
                                    <td><input step="0.1" type="number" name="{{ $masterdataValue['objectId'] }}[]" class="form-control" value="{{ $items }}"></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            {!! Form::close() !!}
            </table>
        </div>
        @endif
    </section>
        @if (count($masterdataItem) > 0)
        <button type="submit" form="formedit" class="btn btn-primary btn-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i>"><i class="fa fa-edit"></i> แก้ไข</button>
        @else

        @endif
    @endif
</section>
</section>
</section>
<script>
        $(document).ready(function () {
            $('.chzn-select').chosen();
            $("#btn-reset").click(function () {
                $('input[name=attribute').val('');
                $('input[name=value').val('');
            });
        });
</script>
@endsection