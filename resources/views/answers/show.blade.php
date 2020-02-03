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
	        	<a class="btn btn-default" href="{{ URL::previous() }}">
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
                    <div class="col-xs-12">
                        <h4>
                            <strong>Answer Preview :</strong>
                            {{ $answerForm['answerPreview'] }}
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>Updated At :</strong>
                            {{ date('Y-m-j H:m:s', strtotime($answerForm['updatedAt'] . " +7 hour")) }}
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
            @foreach($questions as $question)
            <tr>
                <td>{{ $question['title'] }}</td>
                
                <td>
                    @foreach($answers as $answer)
                        @if($answer['questionId'] == $question['objectId'])
                            {{ $answer['stringValue'] }}
                        @endif
                    @endforeach
                </td>
                
                    
        
            </tr>
            @endforeach

        </table>
    </div>
</div>
            </section>
    	</section>
    </section>
</section>
@endsection