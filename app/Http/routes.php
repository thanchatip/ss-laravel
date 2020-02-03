<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
use App\Group;

/*Login Page for web application*/
Route::get('/login', function() {
    return View::make('login');
});

Route::get('test','testController@test');

/*Authenticate for using web application*/
Route::auth();

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::group(['middleware' => ['auth', 'admin']], function()
{
    Route::get('statistic','StatisticController@index');
    Route::get('statistic/getallcount','StatisticController@getAllCount');
    Route::get('statistic/getalldelete','StatisticController@getAllDelete');
    Route::get('statistic/moredetail','StatisticController@moreDetail');

    Route::get(
        'import/data/index',
        'ImportdataController@index'
    );
    Route::get('import/data/documents','ImportdataController@documents');

    Route::post('import/template/download','ImportdataController@templateDumData');
    Route::post('import/templateChoice/download','ImportdataController@templateChoice');
    Route::post('import/data','ImportdataController@import');
    Route::post('import/matchMSI','ImportdataController@matchMSI');
    Route::post('import/importHuaisanData','ImportdataController@importHuaisanData');

    #Script For Aadmin
    // Route::get('script/main/hardDeleteMainForm','scriptController@hardDeleteMainForm');
    // Route::get('script/main/update','scriptController@update');

    // Route::get('script/coffee/hardDeleteTruck','scriptController@hardDeleteTruck');
    // Route::get('script/coffee/updateTruck','scriptController@updateTruck');
    // Route::get('script/coffee/clearDeletedCoffee','scriptController@clearDeletedCoffee');

    #Route::get('script/huaisan/dumpdata','scriptController@dumpDataHuaisan');
    #Route::get('script/huaisan/changeDateHuaisan','scriptController@changeDateHuaisan');
    #Route::get('script/huaisan/genAnswerFormPreview','scriptController@genAnswerFormPreview');
    #Route::get('script/huaisan/clearDataHuaisan','scriptController@clearDataHuaisan');
    #Route::get('script/huaisan/updatedDate','scriptController@updatedDate');
    #Route::get('script/huaisan/updateData','scriptController@updateData');
    #Route::get('script/huaisan/checkDataHuaisarn','scriptController@checkDataHuaisarn');
    #Route::get('script/huaisan/clearInnerFormHuaisarn','scriptController@clearInnerFormHuaisarn');
    #Route::get('script/dumpdata/jsonDumpData/{formId}','scriptController@jsonDumpData');
    #Route::get('script/oiltea/clearMarkDeletedOiltea','scriptController@clearMarkDeletedOiltea');
    #Route::get('script/oiltea/changeDateHuaisan','scriptController@changeDateHuaisan');
    #Route::get('script/doitung/updatedAnswerStartEnd','scriptController@updatedAnswerStartEnd');
    #Route::get('script/oiltea/orderbyPlant','scriptController@orderbyPlant');
    #Route::get('script/macca/changeUser','scriptController@changeUser');
    #Route::get('script/macca/addAnswer','scriptController@addAnswer');
    #Route::get('script/macca/adminLock','scriptController@adminLock');
    #Route::get('script/doitung/updateCheckFlat','scriptController@updateCheckFlat');
    #Route::get('script/macca/clearMarkDeleted','scriptController@clearMarkDeleted');
    #Route::get('script/macca/unMarkDeleted','scriptController@unMarkDeleted');
    #Route::get('script/oiltea/addAnswerFormIdValue','scriptController@addAnswerFormIdValue');
    #Route::get('script/macca/switchDetailTree','scriptController@switchDetailTree');
    #Route::get('script/oiltea/unmarkDeleteTree/{objectId}','scriptController@unmarkDeleteTree');
    #Route::get('script/macca/changeNumberTree','scriptController@changeNumberTree');
    #Route::get('script/oiltea/removeDeatailTree','scriptController@removeDeatailTree');
    Route::get('script/macca/adminUnlockForms','scriptController@adminUnlockForms');
    Route::get('script/macca/fixBreed','scriptController@fixBreed');
    Route::get('script/oiltea/clearAnswers','scriptController@clearAnswers');
    Route::get('script/oiltea/adminUnLock','scriptController@adminUnLock');
    Route::get('script/oiltea/orderbyTree','scriptController@orderbyTree');
    Route::get('script/oiltea/clearDupGrade','scriptController@clearDupGrade');
    Route::get('script/oiltea/orderTreeByPlant','scriptController@orderTreeByPlant');
    Route::get('script/oiltea/fixShape','scriptController@fixShape');
});

Route::group(['middleware'=>['auth']],function(){

/*Menu with home page*/
Route::get('/', function() {
    if (\Auth::user()->firstname == "admin") {
        return Redirect::to('/statistic');
    } else {
        return Redirect::to('/forms');
    }
});


/*Users Management*/
    Route::get('users',[
                        'as'=>'users.index', 
                        'uses'=>'UsersController@index',
                        'middleware' => [
                            'permission:users-menu|create-user|edit-user|delete-user'
                        ]
                ]);
    Route::get('users/create',[
                        'as'=>'users.create',
                        'uses'=>'UsersController@create',
                        'middleware' => [
                            'permission:create-user'
                        ]
                ]);
    Route::post('users/create',[
                        'as'=>'users.store',
                        'uses'=>'UsersController@store',
                        'middleware' => [
                            'permission:create-user'
                        ]
                ]);
    Route::get('users/{id}',[
                        'as'=>'users.show',
                        'uses'=>'UsersController@show',
                        'middleware' => [
                            'permission:view-user'
                        ]
                ]);
    Route::get('users/{id}/edit',[
                        'as'=>'users.edit',
                        'uses'=>'UsersController@edit',
                        'middleware' => [
                            'permission:edit-user'
                        ]
                ]);
    Route::patch('users/{id}',[
                        'as'=>'users.update',
                        'uses'=>'UsersController@update',
                        'middleware' => [
                            'permission:edit-user'
                        ]
                ]);
    Route::delete('users/{id}',[
                        'as'=>'users.destroy',
                        'uses'=>'UsersController@destroy',
                        'middleware' => [
                            'permission:delete-user'
                        ]
                ]);

/*EditallowCreateForm*/
    Route::get(
        'users/edit/allowCreateForm/{id}/{status}',
        'UsersController@editallowCreateForm'
    );

/*Groups Management*/
    Route::get('groups',[
                        'as'=>'groups.index', 
                        'uses'=>'GroupsController@index',
                        'middleware' => [
                            'permission:groups-menu|create-group|edit-group|delete-group'
                        ]
                ]);
    Route::get('groups/create',[
                        'as'=>'groups.create',
                        'uses'=>'GroupsController@create',
                        'middleware' => [
                            'permission:create-group'
                        ]
                ]);
    Route::post('groups/create',[
                        'as'=>'groups.store',
                        'uses'=>'GroupsController@store',
                        'middleware' => [
                            'permission:create-group'
                        ]
                ]);
    Route::get('groups/{id}',[
                        'as'=>'groups.show',
                        'uses'=>'GroupsController@show',
                        'middleware' => [
                            'permission:view-group'
                        ]
                ]);
    Route::get('groups/{id}/edit',[
                        'as'=>'groups.edit',
                        'uses'=>'GroupsController@edit',
                        'middleware' => [
                            'permission:edit-group'
                        ]
                ]);
    Route::patch('groups/{id}',[
                        'as'=>'groups.update',
                        'uses'=>'GroupsController@update',
                        'middleware' => [
                            'permission:edit-group'
                        ]
                ]);
    Route::delete('groups/{id}',[
                        'as'=>'groups.destroy',
                        'uses'=>'GroupsController@destroy',
                        'middleware' => [
                            'permission:delete-group'
                        ]
                ]);



    Route::post(
        'groups/adduser/{id}',
        'GroupsController@adduser'
    );
    Route::post(
        'groups/updatepermission/{groupid}',
        'GroupsController@updatepermission'
    );
    Route::get(
        'groups/deleteuser/{id}/{groupid}',
        'GroupsController@deleteuser'
    );
    Route::get(
        'groups/edituser/{id}/{groupid}',
        'GroupsController@editUser'
    );
    Route::post(
        'groups/updateUser/{id}',
        'GroupsController@updateUser'
    );

    /*Import User to group File .csv*/
    Route::get('/import/groups/users/{id}', function($id) {
        $group = Group::find($id);
            return View::make('groups.showaddusers',compact('group'));
    });
    /*Create User with .csv File*/
    Route::post(
        '/importCsv/groups/user/{id}',
        'GroupsController@importCsv'
    );
    /*export user in group*/
    Route::get(
        '/export/users/group/{id}', 
        'GroupsController@export'
    );
    Route::get(
        'groups/showaddusers/{id}',
        'GroupsController@createAllUser'
    );
    Route::post(
        'groups/storeAllUser/{id}',
        'GroupsController@storeAllUser'
    );
    Route::post(
        'groups/importusers/{id}',
        'GroupsController@importusers'
    );



/*Permissions Management*/
    Route::get('permissions',[
                        'as'=>'permissions.index', 
                        'uses'=>'PermissionsController@index',
                        'middleware' => [
                            'permission:permissions-menu|create-permission|edit-permission|delete-permission'
                        ]
                ]);
    Route::get('permissions/create',[
                        'as'=>'permissions.create',
                        'uses'=>'PermissionsController@create',
                        'middleware' => [
                            'permission:create-permission'
                        ]
                ]);
    Route::post('permissions/create',[
                        'as'=>'permissions.store',
                        'uses'=>'PermissionsController@store',
                        'middleware' => [
                            'permission:create-permission'
                        ]
                ]);
    Route::get('permissions/{id}',[
                        'as'=>'permissions.show',
                        'uses'=>'PermissionsController@show',
                        'middleware' => [
                            'permission:view-permission'
                        ]
                ]);
    Route::get('permissions/{id}/edit',[
                        'as'=>'permissions.edit',
                        'uses'=>'PermissionsController@edit',
                        'middleware' => [
                            'permission:edit-permission'
                        ]
                ]);
    Route::patch('permissions/{id}',[
                        'as'=>'permissions.update',
                        'uses'=>'PermissionsController@update',
                        'middleware' => [
                            'permission:edit-permission'
                        ]
                ]);
    Route::delete('permissions/{id}',[
                        'as'=>'permissions.destroy',
                        'uses'=>'PermissionsController@destroy',
                        'middleware' => [
                            'permission:delete-permission'
                        ]
                ]);



/*Roles Management*/
    Route::get('roles',[
                        'as'=>'roles.index', 
                        'uses'=>'RolesController@index',
                        'middleware' => [
                            'permission:roles-menu|create-role|edit-role|delete-role'
                        ]
                ]);
    Route::get('roles/create',[
                        'as'=>'roles.create',
                        'uses'=>'RolesController@create',
                        'middleware' => [
                            'permission:create-role'
                        ]
                ]);
    Route::post('roles/create',[
                        'as'=>'roles.store',
                        'uses'=>'RolesController@store',
                        'middleware' => [
                            'permission:create-role'
                        ]
                ]);
    Route::get('roles/{id}',[
                        'as'=>'roles.show',
                        'uses'=>'RolesController@show',
                        'middleware' => [
                            'permission:view-role'
                        ]
                ]);
    Route::get('roles/{id}/edit',[
                        'as'=>'roles.edit',
                        'uses'=>'RolesController@edit',
                        'middleware' => [
                            'permission:edit-role'
                        ]
                ]);
    Route::patch('roles/{id}',[
                        'as'=>'roles.update',
                        'uses'=>'RolesController@update',
                        'middleware' => [
                            'permission:edit-role'
                        ]
                ]);
    Route::delete('roles/{id}',[
                        'as'=>'roles.destroy',
                        'uses'=>'RolesController@destroy',
                        'middleware' => [
                            'permission:delete-role'
                        ]
                ]);



/*Forms Management*/
    Route::group([
        'middleware' => [
            'permission:|forms-menu|create-form|edit-form|delete-form'
        ]
    ], function () {
        Route::resource('forms','FormsController');
        Route::get(
            'myforms',
            'FormsController@myForms'
        );
        Route::get(
            'forms/download/image/{id}',
            'FormsController@download'
        );
        Route::get(
            'forms/trash/deleted',
            'FormsController@deleted'
        );
        Route::get(
            'forms/redelete/{id}',
            'FormsController@redelete'
        );
        /*Answer Forms Management*/
            /*Route::resource(
                'answerForms',
                'AnswerFormsController'
            );*/
        Route::get(
            'answerForms/{idform}',
            'AnswerFormsController@index'
        );
        Route::get(
            'answerForms/{id}/{idform}',
            'AnswerFormsController@show'
        );
        /*Report Management*/
            Route::get(
                'report/{id}',
                'ReportController@index'
            );
        /*BasicReport Management */
            Route::resource('basicreport','BasicReportController');
            Route::get(
                'report/basicreport/{id}',
                'BasicReportController@index'
            );            
            Route::get(
                'report/basicreport/show/{settingId}',
                'BasicReportController@show'
            );
        /*CustomTable Management */
            Route::resource('customtable','CustomTableController');
            Route::get(
                'report/customtable/{id}',
                'CustomTableController@index'
            );
        
            Route::get(
                'report/customtable/getCustomTable/{id}',
                'CustomTableController@getCustomTable'
            );
        
            Route::get(
                'report/customtable/getFormsAndQuestions/{id}',
                'CustomTableController@getFormsAndQuestions'
            );
        
            Route::post(
                'report/customtable/sortAble/customtable',
                'CustomTableController@sortAbleCustomTable'
            );
        
            Route::post(
                'report/customtable/sortAble/customtableItems',
                'CustomTableItemsController@sortAbleCustomtableItems'
            );
        /*CustomTable Management */
            Route::resource('customtableitems','CustomTableItemsController');
        /*User access : permission for forms Management*/
            Route::get(
                '/forms/admin/access/{formId}', 
                'FormsController@access'
            );
            Route::post(
                '/forms/admin/access/{formId}', 
                'FormsController@storeAccessPermission'
            );
            Route::delete(
                '/forms/admin/access/{formId}/{userId}', 
                'FormsController@destroyPermission'
            );
            Route::post(
                '/forms/admin/accessquestion/{formId}/{userId}', 
                'FormsController@updateAccessQuestion'
            );
            Route::post(
                '/forms/admin/accessanswer/{formId}/{userId}', 
                'FormsController@updateAccessAnswer'
            );

            Route::get(
                '/forms/admin/group/access/{formId}', 
                'FormsController@groupAccess'
            );
            Route::post(
                '/forms/admin/group/access/{formId}', 
                'FormsController@groupStoreAccessPermission'
            );
            Route::delete(
                '/forms/admin/group/access/{formId}/{groupId}', 
                'FormsController@groupDestroyPermission'
            );
            Route::post(
                '/forms/admin/group/accessquestion/{formId}/{groupId}', 
                'FormsController@groupUpdateAccessQuestion'
            );
            Route::post(
                '/forms/admin/group/accessanswer/{formId}/{groupId}', 
                'FormsController@groupUpdateAccessAnswer'
            );
    });

/*Excel Forms */
   /* Route::get(
        '/showExcel/{id}',
        'AnswerFormsController@downloadExcel'
    );*/

    /*Route::get(
        'forms/showPreviewExcel/Excelanswer/{id}',
        'FormsController@Excelanswer'
    );

    Route::get(
        '/Excelpage/{id}',
        'FormsController@Excelpage'
    );*/

/*Questions Management*/
    Route::resource(
        'questions',
        'QuestionsController'
    );

/*MasterList Management*/
    Route::group([
                    'middleware' => [
                        'permission:|masterlists-menu|create-masterlist|edit-masterlist|delete-masterlist'
                    ]
                ], function () {
                    Route::resource('masterlists','MasterlistsController');
            });
    Route::post(
        'updateitem/{id}',
        'MasterlistsController@updateitem'
    );
    Route::get(
        'showitem/{id}/{idmasterlist}',
        'MasterlistsController@showitem'
    );
    Route::get(
        'deleteitems/{id}/{idmasterlist}',
        'MasterlistsController@deleteitems'
    );
    Route::post(
        'fixitems/{id}/{idmasterlist}',
        'MasterlistsController@fixitems'
    );
    Route::get(
        '/masterlists/admin/access/{masterListId}', 
        'MasterlistsController@access'
    );
    Route::post(
        '/masterlists/admin/access/{masterListId}', 
        'MasterlistsController@storeAccessPermission'
    );
    Route::delete(
        '/masterlists/admin/access/{masterListId}/{userId}', 
        'MasterlistsController@destroyPermission'
    );
    Route::post(
        '/masterlists/admin/access/{masterListId}/{userId}', 
        'MasterlistsController@updateAccessPermission'
    );
    Route::get(
        '/masterlists/import/csv', 
        'MasterlistsController@importmasterlist'
    );
    Route::post(
        '/masterlists/import', 
        'MasterlistsController@import'
    );
    Route::get(
        '/masterlists/export/{id}',
        'MasterlistsController@export'
    );

/*MasterData Management*/
    Route::resource(
        'masterdata',
        'MasterDataController'
    );
    Route::get(
        '/mymasterdata', 
        'MasterDataController@mymasterdata'
    );
    Route::get(
        '/masterdata/seach/{id}', 
        'MasterDataController@seachMasterdataItems'
    );
    Route::get(
        '/masterdata/download/{id}', 
        'MasterDataController@download'
    );
    Route::post(
        '/masterdata/editReccord/{id}', 
        'MasterDataController@editReccord'
    );
    Route::get(
        '/masterdata/admin/access/{masterDataId}', 
        'MasterDataController@access'
    );
    Route::post(
        '/masterdata/admin/access/{masterDataId}', 
        'MasterDataController@storeAccessPermission'
    );
    Route::post(
        '/masterdata/checktitle/', 
        'MasterDataController@checktitle'
    );
    Route::delete(
        '/masterdata/admin/access/{masterDataId}/{userId}', 
        'MasterDataController@destroyPermission'
    );
    Route::post(
        '/masterdata/admin/access/{masterDataId}/{userId}', 
        'MasterDataController@updateAccessPermission'
    );

    Route::get(
        '/masterdata/admin/group/access/{masterDataId}', 
        'MasterDataController@groupAccess'
    );
    Route::post(
        '/masterdata/admin/group/access/{masterDataId}', 
        'MasterDataController@groupStoreAccessPermission'
    );
    Route::delete(
        '/masterdata/admin/group/access/{masterDataId}/{groupId}', 
        'MasterDataController@groupDestroyPermission'
    );
    Route::post(
        '/masterdata/admin/group/update/{masterDataId}/{groupId}', 
        'MasterDataController@groupUpdateAccessPermission'
    );
    
/*Import User File .csv*/
    Route::get('/import/users', function() {
        return View::make('usersimport');
    });
    Route::get(
        '/export/users', 
        'UsersController@export'
    );
/*Create User with .csv File*/
    Route::post(
        '/importCsv', 
        'UsersController@importCsv'
    );

/*Show preview export excel*/
    /*Route::get(
        'forms/showPreviewExcel/{id}',
        'FormsController@showPreviewExcel'
    );
    Route::get(
        'showDataPreviewExcel/{id}',
        'FormsController@showDataPreviewExcel'
    );*/
/*Download csv templete import user*/
    Route::get('/import/users/download', function(){
        $headers = array( 'Content-Type' => 'text/csv');
            return Response::download(storage_path('officer.csv'), 'officer.csv', $headers);
    });
    Route::get('/masterlists/import/download', function(){
        $headers = array( 'Content-Type' => 'text/csv');
            return Response::download(storage_path('csvmasterlist.csv'), 'csvmasterlist.csv', $headers);
    });

/*Auto complete web service*/
    Route::get('/autocomplete',
            array(
                'as'=>'autocomplete',
                'uses'=>'MasterlistsController@autocomplete'
            )
        );

    Route::get('access/group/autocomplete',
        array(
            'as'=>'autocomplete',
            'uses'=>'FormsController@autocomplete'
        )
    );
    Route::get(
        '/testexport',
        'FormsController@testExport'
    );

/*Images upload*/
    Route::post(
        'users/testimport',
        'UsersController@testimport'
    );

    Route::get(
        '/profile',
        'ProfileController@show'
    );
    Route::get(
        '/profile/edit',
        'ProfileController@edit'
    );
    Route::post(
        '/profile/update', 
        'ProfileController@update'
    );
    Route::get(
        '/profile/resetPassword',
        'ProfileController@reset'
    );
    Route::post(
        '/profile/resetPassword', 
        'ProfileController@resetPassword'
    );

    
    /*Report Oiltea*/
    Route::get(
        'report/oiltea/index',
        'CustomizeExcel\oiltea\RawdataController@index'
    );
    Route::post(
        'report/oiltea/rawdata',
        'CustomizeExcel\oiltea\RawdataController@SelectConfig'
    );
    Route::post(
        'report/oiltea/oiltearawdata',
        'CustomizeExcel\oiltea\RawdataController@Oilteadata'
    );

    /*Report Oiltea - Jeelong*/
    Route::get(
        'report/oiltea_jeelong/index',
        'CustomizeExcel\oiltea_jeelong\RawdataController@index'
    );
    Route::post(
        'report/oiltea_jeelong/rawdata',
        'CustomizeExcel\oiltea_jeelong\RawdataController@OilteaJeelongdata'
    );

    /*Report huaisan*/
    Route::get(
        'report/huaisan/index',
        'CustomizeExcel\huaisan\SummaryController@index'
    );

    /*Report coffee*/
    Route::get(
        'report/coffee/index/{formId}',
        'CustomizeExcel\coffee\customizeExcelController@index'
    );
    
    /*Report forest*/
    Route::get(
        'report/forestSurvey/index',
        'CustomizeExcel\forestSurvey\customizeExcelController@index'
    );

    #Report Macca
    Route::get(
        'report/macca/index',
        'CustomizeExcel\macca\customizeExcelController@index'
    );

    #Report Oilteav2
    Route::get(
        'report/oilteav2/index',
        'CustomizeExcel\oilteav2\customizeExcelController@index'
    );
    Route::get(
        'report/oilteav2/setting',
        'CustomizeExcel\oilteav2\customizeExcelController@setting'
    );
    Route::get(
        'report/oilteav2/validate',
        'CustomizeExcel\oilteav2\validateController@index'
    );
    Route::post(
        'report/oilteav2/validate',
        'CustomizeExcel\oilteav2\validateController@validateData'
    );
    #Report research_oiltea
    Route::get(
        'report/researchoiltea/index',
        'CustomizeExcel\research_oiltea\customizeExcelController@index'
    );
});

/*Route::get(
    '/flat/data/{answerFormId}',
    'FlatDataController@index'
);

#production query test
Route::get(
    '/production/test',
    'ProductionController@index'
);*/
