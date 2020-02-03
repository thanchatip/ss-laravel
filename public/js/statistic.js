
$('.btn').on('click', function( event ){
    contentType = $(this).attr("id");
    tagI = $(this).find('i')[0].outerHTML;

    getModalData(contentType,tagI);
});
$('.loader').hide();
//getAllCount();

function getAllCount() {
    $.ajax({
        url: 'statistic/getallcount',
        dataType: 'json',
        success: showAllCount,
        beforeSend: function(){
            $('#loadDataCount').show();
        },
        error: function (request, error) {
            alert("AJAX Call Error: " + error);
            $('#loadDataCount').hide();
        }
    });
}

function getAllDelete() {
    $.ajax({
        url: 'statistic/getalldelete',
        dataType: 'json',
        success: showAllDelete,
        beforeSend: function(){
            $('#loadDataDelete').show();
        },
        error: function (request, error) {
            alert("AJAX Call Error: " + error);
            $('#loadDataDelete').hide();
        }
    });
}

function getModalData(contentType,tagI) {
    $.ajax({
        url: 'statistic/moredetail',
        dataType: 'json',
        data: { 
            contentType: contentType, 
        },
        success: showMoreData,
        beforeSend: function(){
            $('#modalBody')
                .replaceWith(
                    '<div id="modalBody" class="modal-content"> \
                        <div class="modal-header"> \
                            <button type="button btn-default" class="close" data-dismiss="modal">&times;</button> \
                            <h4 class="modal-title"><strong>Loading... !</strong></h4> \
                        </div> \
                        <div class="modal-body"> \
                            <center><div id="loadDataMore" class="loader"></div></center> \
                        </div> \
                        <div class="modal-footer"> \
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> \
                        </div> \
                    </div>'
                );
        },
        error: function (request, error) {
            alert("AJAX Call Error: " + error);
            $('#loadDataMore').hide();
        }
    });
}

function showMoreData (data) {
    $('#modalBody')
        .replaceWith(
        '<div id="modalBody" class="modal-content"> \
            <div class="modal-header"> \
                <button type="button btn-default" class="close" data-dismiss="modal">&times;</button> \
                <h4 class="modal-title"><strong>'+ tagI +' ภาพรวม '+data['contentType']+' </strong></h4> \
            </div> \
            <div class="modal-body"> \
                <ol id="body-content"></ol>\
            </div> \
            <div class="modal-footer"> \
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> \
            </div> \
        </div>' 
    );
    if (data['contentType'] == "USERS") {
        var users = data['users'];
        Object.keys(users).forEach(function(key) {
            $('#body-content')
            .append(
                '<li><strong>'+key+' : </strong>  '+users[key]+' คน</li>' 
            );
        });
    } else if (data['contentType'] == "GROUPS") {
        var groupLists = data['groupLists'];
        Object.keys(groupLists).forEach(function(key) {
            $('#body-content')
            .append(
                '<li><strong>'+key+' : </strong>  '+groupLists[key]+' คน</li>' 
            );
        });    
    } else if (data['contentType'] == "FORMS") {
        var formLists = data['formLists'];
        var i = 0;
        Object.keys(formLists).forEach(function(key) {
            $('#body-content')
            .append(
                '<li><strong>'+formLists[i]['title']+' : </strong>  '+formLists[i]['answerForm']+' คำตอบ</li>' 
            );
           i++;
        }); 
    } else if (data['contentType'] == "MASTER LISTS") {
        var formLists = data['formLists'];
        var i = 0;
        Object.keys(formLists).forEach(function(key) {
            $('#body-content')
            .append(
                '<li><strong>'+formLists[i]['title']+' : </strong>  '+formLists[i]['answerForm']+' คำตอบ</li>' 
            );
           i++;
        }); 
    }
    $('#loadDataMore').hide();
}

function showAllCount(data) {
    $('#showDataCount')
        .append(
        '<div class="row text-center no-gutter"> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countUsers']+'</p> \
                <p class="text-muted">USERS</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countGroups']+'</p> \
                <p class="text-muted">GROUPS</p> \
            </div> \
            <div class="col-xs-6 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countForms']+'</p> \
                <p class="text-muted">FORMS</p> \
            </div> \
        </div> \
        <div class="row text-center no-gutter"> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countMasterLists']+'</p> \
                <p class="text-muted">MASTER LISTS</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">0</p> \
                <p class="text-muted">MASTER DATA</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countAnswerForms']+'</p> \
                <p class="text-muted">ANSWER FORMS</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countAnswers']+'</p> \
                <p class="text-muted">ANSWERS</p> \
            </div> \
        </div>' 
    );
    $('#loadDataCount').hide();
    getAllDelete();
}

function showAllDelete(data) {
    $('#showDataDelete')
        .append(
        '<div class="row text-center no-gutter"> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countUsers']+'</p> \
                <p class="text-muted">USERS</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countGroups']+'</p> \
                <p class="text-muted">GROUPS</p> \
            </div> \
            <div class="col-xs-6 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countForms']+'</p> \
                <p class="text-muted">FORMS</p> \
            </div> \
        </div> \
        <div class="row text-center no-gutter"> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countMasterLists']+'</p> \
                <p class="text-muted">MASTER LISTS</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">0</p> \
                <p class="text-muted">MASTER DATA</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countAnswerForms']+'</p> \
                <p class="text-muted">ANSWER FORMS</p> \
            </div> \
            <div class="col-xs-3 b-r b-light"> \
                <p class="h3 font-bold m-t">'+data['countAnswers']+'</p> \
                <p class="text-muted">ANSWERS</p> \
            </div> \
        </div>' 
    );
    $('#loadDataDelete').hide();
}