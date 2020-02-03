
$('body').on('click', '#btn-upload', function() {
    var formData = new FormData($('#uploadMasterData')[0]);
    var sheetName = [];
    var i=0;
    var $btn = $('#btn-upload');
    $btn.button('reset', function() {
        $(this).attr('disabled', 'disabled');
    });
    $("input[name='sheetName']").each(function() {
        if(!$(this).val() ) {
            i++;
        }
        
        formData.append('sheetTitle[]', $(this).val());
    });
    console.log(formData);
    uploadFileSubmit(formData,i);
});

$("#btn-submitForm").click(function(){
    if( document.getElementById("fileupload").files.length == 0 ){
        alert('กรุณาเลือกไฟล์ที่ต้องการ')
    }
    else {
        var formData = new FormData($('#uploadMasterData')[0]);
        upLoadFile(formData);
        $('#btn-submitForm').prop('disabled', true);
    }
});

$('body').on('click', '#btn-cancel', function() {
    $( "#test" ).remove();
    $('#btn-submitForm').prop('disabled', false);
    xhr.abort();  
});

function uploadFileSubmit (formData,i) {
        xhr = $.ajax({
            url: '/masterdata',
            type: 'POST',
            data: formData,
            dataType: 'text',
            beforeSend: function () {
                if (i > 0) {
                    alert('กรุณาตั้งชื่อ master data');
                    $('#btn-upload').button('reset');
                }
            },
            success: function (data){

                    $('#btn-upload').button('reset');
                    alert(data);
                    window.location.replace("http://localhost:8000/masterdata");
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#btn-upload').button('reset');
                // Here the responseText contains the file content before the correct json object
                alert("Error: jqXHR " + JSON.stringify(jqXHR) + " - textStatus " + JSON.stringify(textStatus) + " - errorThrown " + JSON.stringify(errorThrown));
            },
            cache: false,
            contentType: false,
            processData: false
        });
}

function upLoadFile (formData) {
    xhr = $.ajax({
        url: '/masterdatafileupload',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data){
            var fileName = data['fileName'];
            var sheetTitle = data['sheetTitle'];
            var buttonload = "<i class='fa fa-spinner fa-spin'></i> กำลังอัพโหลด";
            $('#uploadsuccess')
                .append(
                    '<div id="test" class="col-xs-12 col-sm-12 col-md-8"> \
                        <div id="modalBody" class="modal-content"> \
                            <div class="modal-header"> \
                                \
                                <h4 class="modal-title"><span class="label label-success">ตรวจสอบ</span><strong> พบ '+sheetTitle.length+' master data กรุณาตรวจสอบ และแก้ไขชื่อ masterdata</strong></h4> \
                            </div> \
                            <div class="modal-body"> \
                            </div> \
                            <div class="modal-footer"> \
                                <button type="button" id="btn-cancel" class="btn btn-default">ยกเลิก</button> \
                                <button type="button"  class="btn btn-primary" id="btn-upload" data-loading-text="'+buttonload+'">ยืนยัน</button> \
                            </div> \
                        </div> \
                    </div>'
                );
                for (i=0;i<sheetTitle.length;i++) {
                $('.modal-body')
                    .append(
                        '<div class="form-group">\
                            <input type="text" name="sheetName" value="'+sheetTitle[i]+'" class="form-control" id="input-id-1" required>  \
                        </div>'
                    );
                }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#btn-submitForm').prop('disabled', false);
            // Here the responseText contains the file content before the correct json object
            alert("Error: jqXHR " + JSON.stringify(jqXHR) + " - textStatus " + JSON.stringify(textStatus) + " - errorThrown " + JSON.stringify(errorThrown));
        },
        cache: false,
        contentType: false,
        processData: false
    });
    
}


