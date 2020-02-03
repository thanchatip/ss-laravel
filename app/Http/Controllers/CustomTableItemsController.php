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

class CustomTableItemsController extends Controller
{
    public function store(Request $request) {

        $id = $request['formId'];
        $questionId = $request['questionData'];
        $customTableId = $request['customTableId'];
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        $countCustomTableItems = CustomTableItems::whereNull('deleted_at')->where('data.customTableId',$customTableId)->get();
        $countCustomTableItems = count($countCustomTableItems);

        $i = $countCustomTableItems + count($questionId);

        foreach ($questionId as $questionId) {
            $randomString = generateRandomString();
            $customtableitems = new customtableitems();
            $questions = DB::collection('question')->where('data.deletedAt','')->where('data.objectId',$questionId)->first();
            $questionTitle = $questions['data']['title'];
            $customtableitems['data.objectType'] = 'customtableitems';
            $customtableitems['data.objectId'] = $randomString;
            $customtableitems['data.customTableId'] = $customTableId;
            $customtableitems['data.questionId'] = $questionId;
            $customtableitems['data.title'] = $questionTitle;
            $customtableitems['data.orderIndex'] = $i;
            $customtableitems['data.createdBy'] = \Auth::user()->_id;
            $customtableitems['data.updatedBy'] = \Auth::user()->_id;
            $customtableitems['data.createdAt'] = $dateTime;
            $customtableitems['data.updatedAt'] = $dateTime;
            $customtableitems['data.deletedBy'] = "";
            $customtableitems->save();
            $i--;
        }
             
        return redirect()->action(
            'CustomTableController@index', ['id' => $id,'objectId' => $customTableId]
        );  
    }
    public function sortAbleCustomtableItems (Request $request) {
        $customtableItemsId = $request['customtableItemsId'];

        if (!empty($customtableItemsId)) {
            $i = count($customtableItemsId);
            foreach ($customtableItemsId as $customtableItemsId) {
                $data = [
                    'data.orderIndex' => $i,
                ];
                $CustomTableItems = CustomTableItems::where('data.objectId',$customtableItemsId)->update($data, ['upsert' => true]);
                $i--;
            }
        }
    }

    public function destroy($id)
    {
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        $customtableitems = CustomTableItems::where('data.objectId',$id)->firstOrFail();
        $title = $customtableitems['data']['title'];
        $customTableId = $customtableitems['data']['customTableId'];
        $customtable = CustomTable::where('data.objectId',$customTableId)->firstOrFail();
        $customtableitems['data.updatedAt'] = $dateTime;
        $customtableitems['data.deletedBy'] = \Auth::user()->_id;
        $customtableitems->save();
        $customtableitems->delete();

        return redirect()->action(
            'CustomTableController@index', ['id' => $customtable['data']['formId'],'objectId' => $customTableId]
        );
    }
}
