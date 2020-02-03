@extends('theme')
@section('content')
<link rel="stylesheet" href="{{asset('theme/css/daterangepicker.css')}}" type="text/css" />
<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2><i class="fa fa-user"></i>
                            ตั้งค่ารายการตรวจ {{ $forms[0]['title'] }}
                        </h2>
                        <a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > 
                        <a href="{{ route('forms.show',$forms[0]['objectId']) }}"><u>{{ $forms[0]['title'] }}</u></a> > 
                        <a href="{{ URL('report',$forms[0]['objectId']) }}"><u>รายงาน</u></a> > SETTING CUSTOM REPORT
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default" href="{{ URL('report',$forms[0]['objectId']) }}">
                        <i class="fa fa-backward"></i> กลับ</a>
                    </div>
                </div>
            </div>
            <hr>
            <header class="panel-heading font-bold">
                SETTING LISTS
            </header>
            <table class="table table-border">
                <tbody>
                    <tr class="bg-light">
                        <td>ช่วงเวลาของปี</td>
                        <td>ปี ของรายการตรวจ</td>
                        <td>ตรวจปีที่</td>
                        <td>EDIT</td>
                    </tr>
                    <tr>
                        <td>19 กันยายน 2561 - 21 กันยายน 2561</td>
                        <td>2561</td>
                        <td>3</td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <section class="panel panel">
                <header class="panel-heading font-bold">
                    SETTING CUSTOM REPORT
                </header>
                <div class="panel-body">
                    <form class="form-horizontal" method="get">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ช่วงเวลาของปี</label>
                            <div class="col-sm-10">
                                <input name="dateRange" id="dateRange"  class="input-md form-control" onkeydown="return false" size="16" type="text" value="">                      
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ปี ของรายการตรวจ</label>
                            <div class="col-sm-10">
                                <div class="col-lg-4 m-l-n">
                                    <select name="account" class="form-control m-b">
                                        <option disabled>2559</option>
                                        <option disabled>2560</option>
                                        <option>2561</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ตรวจปีที่</label>
                            <div class="col-sm-10">
                                <div class="col-lg-4 m-l-n">
                                    <select name="account" class="form-control m-b">
                                        <option disabled>1</option>
                                        <option disabled>2</option>
                                        <option>3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button type="submit" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </section>
	</section>
</section>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<script type="text/javascript">  
    $('#dateRange').daterangepicker();
</script>
@endsection