<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CustomTable;
use DB;
use Carbon\Carbon;
use App\User;
use App\CustomTableItems;
use log;

class CustomTableController extends Controller
{
    public function index(Request $request,$id) {
        $form = DB::collection('form')->where('data.objectId',$id)->first();
        $customTableShow = [];
        if (!empty($request['objectId'])) {
            $customTableShow = CustomTable::whereNull('deleted_at')->where('data.objectId',$request['objectId'])->first();
            if (!empty($customTableShow)) {
                $userCreate = User::find($customTableShow['data']['createdBy']);
                $userCreate = $userCreate->prefix.$userCreate->firstname." ".$userCreate->lastname;
                $userUpdate = User::find($customTableShow['data']['updatedBy']);
                $userUpdate = $userUpdate->prefix.$userUpdate->firstname." ".$userUpdate->lastname;
                $customTableShow['data.createdBy'] =  $userCreate;
                $customTableShow['data.updatedBy'] =  $userUpdate;
                
                $pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$customTableShow['data.CustomTableFormId'])->orderBy('data.orderIndex','ASC')->pluck('data');
                $questionOfPages = DB::collection('question')
                                    ->where('data.deletedAt','')
                                    ->where('data.formId',$customTableShow['data.CustomTableFormId'])
                                    ->orderBy('data.orderIndex','ASC')
                                    ->pluck('data');
                foreach ($pages as $page) {
                    foreach ($questionOfPages as $questionOfPage) {
                        if ($page['objectId'] == $questionOfPage['pageId']) {
                            $choiceQuestions[$page['title']][$questionOfPage['objectId']] = $questionOfPage['title'];
                        }
                    }
                }               
            }
        }
        
        $customTableItems = CustomTableItems::whereNull('deleted_at')->where('data.customTableId',$request['objectId'])->orderby('data.orderIndex','DESC')->pluck('data');
        
        return view('report.customtable.index',compact('form','customTableShow','customTableItems','choiceQuestions'));
    }
    
    public function getCustomTable (Request $request,$id) {
        $customTables = CustomTable::whereNull('deleted_at')->where('data.formId',$id)->orderby('data.orderIndex','DESC')->pluck('data');
        
        return $customTables;
    }

    public function sortAbleCustomTable (Request $request) {
        $customtableId = $request['customtableId'];
        if (!empty($customtableId)) {
            $i = count($customtableId);
            foreach ($customtableId as $customtableId) {
                $data = [
                    'data.orderIndex' => $i,
                ];
                $customTable = CustomTable::where('data.objectId',$customtableId)->update($data, ['upsert' => true]);
                $i--;
            }
        }
        return $i;
    }

    public function getFormsAndQuestions ($id) {
        $choiceQuestions = [];
        $choiceForms = [];
        $questionFormId = [];
		$question = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$id);
		$questions = $question->pluck('data');

        $questionFormId[] = $this->filterInnerForm($questions,$questionFormId,$question);

        foreach ($questionFormId as $questionFormIds) {
            if (!empty($questionFormIds)) {
                for ($i=0;$i<count($questionFormIds);$i++) {
                    if (!empty($questionFormIds[$i])) {
                        $Forms = DB::collection('form')
                                        ->where('data.deletedAt','')
                                        ->where('data.objectId',$questionFormIds[$i][0])
                                        ->first();
                        $choiceForms[$questionFormIds[$i][0]] = $Forms['data']['title'];
                        /*$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$questionFormIds[$i][0])->orderBy('data.orderIndex','ASC')->pluck('data');
                        $questionOfPages = DB::collection('question')
                                        ->where('data.deletedAt','')
                                        ->where('data.formId',$questionFormIds[$i][0])
                                        ->orderBy('data.orderIndex','ASC')
                                        ->pluck('data');*
                        foreach ($pages as $page) {
                            foreach ($questionOfPages as $questionOfPage) {
                                if ($page['objectId'] == $questionOfPage['pageId']) {
                                    $choiceQuestions[$questionFormIds[$i][0]][$questionOfPage['objectId']] = $questionOfPage['title'];
                                }
                            }
                        }*/
                    }
                }
            }
        }
       
        return response()->json([
            'formId' => $id,
            'choiceForms' => $choiceForms,
            'choiceQuestions' => $choiceQuestions
        ]);
    }

	public function filterInnerForm ($question,$questionFormId,$questions) {
		$questionInners = array_filter($question,
			function ($question) {
				return $question['type'] == 7;
			}
        );
        $questionFormId[] = $questions->distinct('data.formId')->get();

		if(!empty($questionInners)) {
			foreach($questionInners as $questionInner) { 
				$questionFilter = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$questionInner['questionFormId']);
                $questionObjects = $questionFilter->pluck('data');
                $questionFormId[] = $questionFilter->distinct('data.formId')->get();
				$questionInnerForms = array_filter($questionObjects,
					function ($questionObjects) {
						return $questionObjects['type'] == 7;
					}
				);

				if(!empty($questionInnerForms)) {
                    $questionFormId = $this->filterInnerForm($questionObjects,$questionFormId,$questionFilter);
				}	
			}
		}

        return $questionFormId;	
	}

    public function update(Request $request,$id) {
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        $formId = $request['formId'];
        $title = $request['sheetName'];
        $data = [
            'data.title' => $title,
            'data.updatedAt' => $dateTime,
            'data.updatedBy' => \Auth::user()->_id
        ];
        $customTable = CustomTable::where('data.objectId',$id)->update($data, ['upsert' => true]);;

        return redirect()->action(
            'CustomTableController@index', ['id' => $formId,'objectId' => $id]
        )->with('success',"แก้ไขชีท $title สำเร็จ"); ;
    }

    public function store(Request $request) {
        $this->validate($request, [
            'sheetName' => 'required|regex:/^\S*$/u|max:31',
        ]);
        $CustomTableFormId = $request['formData'];
        $sheetName = $request['sheetName'];
        $formId = $request['formId'];
        $countCustomTables = CustomTable::whereNull('deleted_at')->where('data.formId',$formId)->orderby('data.createdAt','DESC')->get();
        $countCustomTables = count($countCustomTables);
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        $randomString = generateRandomString();
        $customtable = new customTable();
        $customtable['data.objectType'] = 'customtable';
        $customtable['data.objectId'] = $randomString;
        $customtable['data.formId'] = $formId;
        $customtable['data.CustomTableFormId'] = $CustomTableFormId;    
        $customtable['data.title'] = $sheetName;
        $customtable['data.createdBy'] = \Auth::user()->_id;
        $customtable['data.updatedBy'] = \Auth::user()->_id;
        $customtable['data.createdAt'] = $dateTime;
        $customtable['data.updatedAt'] = $dateTime;
        $customtable['data.deletedBy'] = "";
        $customtable['data.orderIndex'] = $countCustomTables+1;
        $customtable->save();
             
        return redirect()->action(
            'CustomTableController@index', ['id' => $formId,'objectId' => $randomString]
        )->with('success',"สร้างชีท $sheetName สำเร็จ");       
    }

    public function destroy($id)
    {
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        $customtable = CustomTable::where('data.objectId',$id)->firstOrFail();
        $title = $customtable['data']['title'];
        $formId = $customtable['data']['formId'];
        $customtable['data.updatedAt'] = $dateTime;
        $customtable['data.deletedBy'] = \Auth::user()->_id;
        $customtable->save();
        $customtable->delete();

        $customTableItems = CustomTableItems::where('data.customTableId',$id)->pluck('data.objectId');
        foreach ($customTableItems as $customTableItem) {
            $customTableItems = CustomTableItems::where('data.objectId',$customTableItem)->firstOrFail();
            $customTableItems['data.updatedAt'] = $dateTime;
            $customTableItems['data.deletedBy'] = \Auth::user()->_id;
            $customTableItems->save();
            $customTableItems->delete();
        }

        return redirect()->action(
            'CustomTableController@index', ['id' => $formId]
        )->with('success',"ลบชีท $title สำเร็จ"); ;
    }
}
