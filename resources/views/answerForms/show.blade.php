@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>รายละเอียดคำตอบ</h2>
	        </div>

	        <div class="pull-right">
	        	<a class="btn btn-default" href="{{ url('answerForms',$formId) }}">
	        	<i class="fa fa-backward"></i> กลับ</a>
	        </div>
	    </div>
	</div>
<hr>
    <div class="row">
        <div class="col-lg-12 col-md-6">
        <section class="panel b-a">
            <li class="list-group-item">
            <div class="panel-body">
                <div class="row m-t">
                @foreach($answerForms as $key => $answerForm)
                    @if($answerForm['answerPreview'] == null)
                    <div class="col-xs-12">
                        <h4>
                            <strong>Answer Preview :</strong>
                            <strong class="text-danger">ไม่มีพรีวิว</strong>
                        </h4>
                    </div>
                    @else
                    <div class="col-xs-12">
                        <h4>
                            <strong>Answer Preview :</strong>
                            {{ $answerForm['answerPreview'] }}
                        </h4>
                    </div>
                    @endif
                    <div class="col-xs-12">
                        <h4>
                            <strong>ตอบเมื่อ :</strong>
                            {{ DateThai((date('Y-m-d H:i:s', strtotime($answerForm['createdAt'] . " +7 hour")))) }} 
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>ตอบโดย :</strong>
                            {{ $answerForm['createdBy'] }}
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>แก้ไขล่าสุด :</strong>
                            {{ DateThai((date('Y-m-d H:i:s', strtotime($answerForm['updatedAt'] . " +7 hour")))) }} 
                        </h4>
                    </div>
                @endforeach
            </li>
            </div>
        </div>

        <table class="table table-striped table-bordered m-b-none">
            <tr>
                <th width="138px">คำถาม</th>
                <th width="200px">คำตอบ</th>
            </tr>
            @foreach ($questions[0] as $question)
                @foreach ($pages[0] as $page)
                    @if ($page['objectId'] == $question['pageId'])
                        <tr>
                            <td>{{ $question['title'] }}</td>
                            @if (!empty($answers[$question['objectId']]))
                                <td>
                                    {{ implode(',',$answers[$question['objectId']]) }}   
                                </td>
                            @else
                                <td>
                                    <span class="label label-danger">ไม่มีคำตอบ</span>
                                </td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            @endforeach

        </table>
    </div>
</div>
        {!! $pages->render() !!}
            </section>
    	</section>
    </section>
</section>
@endsection