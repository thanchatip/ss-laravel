@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>Question Detail</h2>
	        </div>

	        <div class="pull-right">
	        	<a class="btn btn-default" href="{{ route('forms.index') }}">
	        	<i class="fa fa-backward"></i> Back</a>
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
                @foreach($question as $key => $questions)
                    <div class="col-xs-12">
                        <h4>
                            <strong>Title :</strong>
                            {{ $questions['title'] }}
                        </h4>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            <strong>Updated At :</strong>
                            {{ $questions['updatedAtDate'] }}
                        </h4>
                    </div>
                @endforeach
            </li>
        </div>
    </div>

    <footer class="panel-footer dk no-border">
            <div class="row pull-out">
                <div class="col-xs-12">
                    <h4>
                        <i class="fa fa-list-ul"></i>
                        <strong> Answer List :</strong>
                    </h4>
                    <div class="padder-v">
                    @foreach($answer as $key => $value)
                    <li class="list-group-item">
                        <div class="pull-right">
                            <a class="btn btn-default" href="{{ route('questions.show',$value['objectId']) }}"><i class="fa fa-file-text-o"></i></a>
                            <a class="btn btn-default" href="{{ route('questions.edit',$value['objectId']) }}"><i class="fa fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE','route' => ['questions.destroy', $value['objectId']], 'style'=>'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit','class' => 'btn btn-default']) !!}
                            {!! Form::close() !!}
                        </div>
                            <span class="m-b-xs h4 block">{{ $value['stringValue'] }}</span>
                            <small>Updated At : {{ $value['updatedAtDate']}}</small>
                    </li>
                    @endforeach
                    </div>
                </div>
            </div>
        </footer>
    </section>
        </div>
    </div>

	</section>
	</section>
</section>
@endsection