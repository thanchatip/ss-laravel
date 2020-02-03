@extends('log._template.master')

@section('content')
    <h1 class="page-header">Log [{{ DateThaiNotTime((date('Y-m-d', strtotime($log->date  . " +7 hour")))) }}]</h1>
    <div class="row">
        <div class="col-md-2">
            @include('log._partials.menu')
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Log info :
                    <div class="group-btns pull-right">
                        <a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn btn-xs btn-success">
                            <i class="fa fa-download"></i> DOWNLOAD
                        </a>
                        <a href="#delete-log-modal" class="btn btn-xs btn-danger" data-toggle="modal">
                            <i class="fa fa-trash-o"></i> DELETE
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <td>File path :</td>
                                <td colspan="5">{{ $log->getPath() }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Log entries : </td>
                                <td>
                                    <span class="label label-primary">{{ $entries->total() }}</span>
                                </td>
                                <td>Size :</td>
                                <td>
                                    <span class="label label-primary">{{ $log->size() }}</span>
                                </td>
                                <td>Created at :</td>
                                <td>
                                    <span class="label label-primary">{{ DateThai((date('Y-m-d H:i:s', strtotime($log->createdAt() . " +7 hour")))) }} </span>
                                </td>
                                <td>Updated at :</td>
                                <td>
                                    <span class="label label-primary">{{ DateThai((date('Y-m-d H:i:s', strtotime($log->updatedAt() . " +7 hour")))) }} </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! Form::open(['method' => 'GET','url' => ['log-webportal/logs',$date],'class'=>'form-inline','id'=>'formFilter']) !!}
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">ระดับ</label>
                            &nbsp;
                            <select class="form-control" id="exampleFormControlSelect1" name="logLevel">
                                @foreach($log->menu() as $level => $item)
                                    @if (app('request')->input('logLevel') == $level)
                                        <option value="{{ $level }}" selected>{{ $item['name'] }}</option>
                                    @else
                                        <option value="{{ $level }}">{{ $item['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        &nbsp;
                        <div class="form-group">
                            <label for="email">เวลาเริ่มต้น:</label>
                            &nbsp;
                            <input name="timeStart" id="timeStart" value="{{app('request')->input('timeStart')}}" class="input-md form-control" onkeydown="return false" size="14" type="text" value="" required>
                        </div>
                        &nbsp;
                        <div class="form-group">
                            <label for="pwd">เวลาสิ้นสุด:</label>
                            &nbsp;
                            <input name="timeEnd" id="timeEnd" value="{{app('request')->input('timeEnd')}}" class="input-md form-control" onkeydown="return false" size="14" type="text" value="" required>
                        </div>
                        &nbsp;
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="panel panel-default">
                @if ($entries->hasPages())
                    <div class="panel-heading">
                        {!! $entries->appends([
                            'logLevel' => app('request')->input('logLevel'),
                            'timeStart' => app('request')->input('timeStart'),
                            'timeEnd' => app('request')->input('timeEnd'),
                        ])->render() !!}

                        <span class="label label-info pull-right">
                            Page {!! $entries->currentPage() !!} of {!! $entries->lastPage() !!}
                        </span>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="entries" class="table table-condensed">
                        <thead>
                            <tr>
                                <th style="width: 60px;">Level</th>
                                <th style="width: 65px;">Time</th>
                                <th>Header</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entries as $key => $entry)
                                <tr>
                                    <td>
                                        <span class="level level-{{ $entry['level'] }}">
                                            {!! $entry['level'] !!}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="label label-default">
                               
                                            {{ TimeThai((date('Y-m-d H:i:s', strtotime($entry['datetime'] . " +7 hour")))) }}
                                        </span>
                                    </td>
                                    <td>
                                        <p>{{ $entry['header'] }}</p>
                                    </td>
                                    <td class="text-right">
                                        @if ($entry['stack'])
                                            <a class="btn btn-xs btn-default" role="button" data-toggle="collapse" href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                                <i class="fa fa-toggle-on"></i> Stack
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @if ($entry['stack'])
                                    <tr>
                                        <td colspan="5" class="stack">
                                            <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                                {!! $entry['stack'] !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($entries->hasPages())
                    <div class="panel-footer">
                        {!! $entries->appends([
                            'logLevel' => app('request')->input('logLevel'),
                            'timeStart' => app('request')->input('timeStart'),
                            'timeEnd' => app('request')->input('timeEnd'),
                        ])->render() !!}

                        <span class="label label-info pull-right">
                            Page {!! $entries->currentPage() !!} of {!! $entries->lastPage() !!}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- DELETE MODAL --}}
    <div id="delete-log-modal" class="modal fade">
        <div class="modal-dialog">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="date" value="{{ $log->date }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">DELETE LOG FILE</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to <span class="label label-danger">DELETE</span> this log file <span class="label label-primary">{{ $log->date }}</span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">DELETE FILE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#timeStart').datetimepicker({
                format:'HH:mm'
            }); 
            $('#timeEnd').datetimepicker({
                format:'HH:mm'
            }); 
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            deleteLogForm.on('submit', function(event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url:      $(this).attr('action'),
                    type:     $(this).attr('method'),
                    dataType: 'json',
                    data:     $(this).serialize(),
                    success: function(data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.replace("{{ route('log-viewer::logs.list') }}");
                        }
                        else {
                            alert('OOPS ! This is a lack of coffee exception !')
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });
        });
    </script>
@endsection
