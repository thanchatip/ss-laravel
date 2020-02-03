@extends('theme')
@section('content')
<section class="vbox bg-white">
    <section class="scrollable padder">
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
  <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2><i class="fa fa-trash-o"></i>
              ฟอร์มที่ถูกลบ</h2>
          </div>
          <div class="pull-right">
            {!! Form::open(['method'=>'GET','url'=>'forms','role'=>'search']) !!}
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="ค้นหา...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
        {!! Form::close() !!}
          </div>
      </div>
  </div>
    <hr>
    <ul class="list-group">
    @if(!empty($forms))
    @foreach($forms as $forms)
      <li class="list-group-item">
        @if(Auth::user()->firstname == 'admin')
            <a onClick="return ConfirmreturnDelete()"  href="{{ URL('forms/redelete',$forms['objectId'])}}">
              <div class="pull-right text-success m-t-sm">
                <i class="fa fa-reply"></i>
              </div>
            </a>
        @endif
        @foreach($AuthForms as $AuthForm)
          @if($AuthForm['questionFormRoleCode'] == '0' && $AuthForm['form_id'] == $forms['objectId'])
            <a onClick="return ConfirmreturnDelete()"  href="{{ URL('forms/redelete',$forms['objectId'])}}">
              <div class="pull-right text-success m-t-sm">
                <i class="fa fa-reply"></i>
              </div>
            </a>     
          @endif
        @endforeach

        <div class="media-body">
          <div style="color:red;">{{ $forms['title'] }}</div>
          <small class="text-muted">Deleted at : {{$forms['deletedAt'] }} | Deleted by : {{ $forms['deletedBy'] }}</small>
        </div>
      </li>
    @endforeach
    @endif
    </ul>
  </section>
  </section>
</section>
<script src="{{asset('js/app.js')}}"></script>
@endsection
