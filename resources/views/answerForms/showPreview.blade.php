<!DOCTYPE HTML>
<html>
    <title>MFLF | Smart Survey</title>
    <head>
        <script src="{{asset('theme/js/jquery.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('theme/css/handsontable/handsontable.min.css')}}" type="text/css" />
        <link rel="stylesheet" href="{{asset('theme/css/handsontable/main.css')}}" type="text/css" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.js"></script>
        <script src="{{asset('theme/js/handsontable/handsontable.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('theme/css/bootstrap.css')}}" type="text/css" />
        <script src="{{asset('js/ajax-loading.js')}}"></script>
    </head>
    <body>
        <style type="text/css">
            body {
                background-color: #ECF0F1;
            }
            .handontable table {
  max-width : none;
  max-height: none;
}
        </style>
        <input type="hidden" value="{{$id}}" id="formId">
        <input type="hidden" value="{{$startdate}}" id="startdate">
        <input type="hidden" value="{{$enddate}}" id="enddate">
 

        <div class="panel-body">
            <a href="Excelanswer/{{$id}}?startdate={{$startdate}}&enddate={{$enddate}}"><button type="button" class="btn btn-md btn-default pull-left">Export Excel</button></a>
        </div>
        <div class="panel-body">            
            <ul class="nav nav-tabs" id="myTab">
            </ul>
        </div> 
        <div class="tab-content" id="tabs">
        </div>

        <script type="text/javascript" charset="utf-8">
            //init
            var loading = $.loading({
                id: 'ajaxLoading',
            });

            getData();
            function getData () {
                loading.open()
                var formId = $('#formId').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();
                $.ajax({
                    url: '/showDataPreviewExcel/' + formId ,
                    data: {
                        id: formId,
                        startdate: startdate,
                        enddate: enddate
                    },
                    dataType: 'json',
                    success: getTable,
                    error: function(jqXHR, errorType) { 
                        loading.close();
                        alert('Error: ' + errorType);
                        close();
                    }
                });
            }
            
            function getTable (data) {
                var i = 0;
                if(data == '') {
                    loading.close();
                    alert("ไม่มีคำตอบในฟอร์ม")
                    close();
                }
                Object.keys(data).forEach(function(key) {
                    //console.log(key, data[key]);
                    var answers = data[key]['answer']
                    var questions = data[key]['question']
                    if (answers == null) {
                        var answers = new Array();
                        for (i=0;i<1;i++) {
                            answers[i] = new Array();
                            for (j=0;j<questions.length;j++) {
                                answers[i][j] = "";
                            }
                        }
                    }
                    var key = key.replace(/[\/. ,:-]+/g,'');

                    if(i == 0) {
                        $( "#myTab" ).append( 
                            '<li><a data-target="#'+key+'" data-toggle="tab">'+key+'</a></li>'
                        );
                        $( "#tabs" ).append( 
                            '<div class="tab-pane active" id="'+key+'">\
                                <div id="'+key+'" class="hot handsontable htColumnHeaders"></div>\
                            </div>'
                        );
                    } else {
                        $( "#myTab" ).append( 
                            '<li><a data-target="#'+key+'" data-toggle="tab">'+key+'</a></li>'
                        );
                        $( "#tabs" ).append( 
                            '<div class="tab-pane active" id="'+key+'">\
                            <div class="row"></div>\
                                <div id="'+key+'" class="hot handsontable htColumnHeaders"></div>\
                            </div>'
                        );
                    }
                    var container = "container";
                    var hot = "hot";

                    window[container+i] = document.getElementById(key);

                    window[hot+i] = new Handsontable(window[container+i], {
                        data: answers,
                        //strict: true,
                        //stretchH: 'all',
                        rowHeaders: true,
                        autoColumnSize: true,
                        readOnly: true,
                        autoRowSize: false,
                        autoColSize: false,
                        colHeaders: questions,
                    });
                    i++;

                });
            }
        </script>
    </body>
</html>
