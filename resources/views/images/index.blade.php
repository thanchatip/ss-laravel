@extends('theme')

@section('content')

<section class="vbox bg-white">
    <section class="scrollable padder">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2><i class="fa fa-lock"></i>
	            Images Upload</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-success" href="{{ route('permissions.create') }}">
	            <i class="fa fa-pencil"></i> อัพโหลดรูปภาพ</a>
	        </div>
	    </div>
	</div>

            <form action="{{ URL::to('/images/add') }}" method="post" enctype="multipart/form-data" >
            <div class="input-group">
                <input type="file" name="filefield" accept=".csv" class="form-control" />
                <span class="input-group-btn">
                  {!! Form::token(); !!}
                    {!! csrf_field() ; !!}
                  <button id="btnImport" class="btn btn-default">Import</button>
                </span>
            </div>
            </form>
 </div>

	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif


		<hr>
	<table class="table table-striped table-bordered m-b-none">
		<tr>
			<th>ชื่อภาพ</th>
			<th>พาทการเก็บ</th>
			<th>ตัวอย่าง</th>
		</tr>

	@foreach ($images as $key => $image)
	<tr>
		<td>{{ $image->filename }}</td>
		<td>{{ $image->path }}</td>
        <td>
        <ul class="thumbnails">
            @foreach($images as $entry)
            <div class="col-md-2">
                <div class="thumbnail">
                    <img src="{{URL::to('images/get/', $entry->filename)}}" alt="" class="img-responsive" />
                    <div class="caption">
                        <p>{{$entry->original_filename}}</p>
                    </div>
                </div>
            </div>
            @endforeach
            </ul>
        </td>
	</tr>
	@endforeach

	</table>

	</section>
	</section>
</section>
@endsection