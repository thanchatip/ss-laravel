<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Group;
use App\Masterlist;
use App\Role;
use DB;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', -1);

class StatisticController extends Controller
{
    public function index () {

        return view('statistic.index');
    }

    public function getAllCount () {
        $countUsers = User::timeout(-1)->count();
        $countGroups = Group::timeout(-1)->count();
        $countForms = DB::collection('form')->timeout(-1)->count();
        $countAnswerForms = DB::collection('answerForm')->timeout(-1)->count();
        $countAnswers = DB::collection('answer')->timeout(-1)->count();
        $countMasterLists = Masterlist::timeout(-1)->count();

        return response()->json([
            'countUsers' => number_format($countUsers),
            'countGroups' => number_format($countGroups),
            'countForms' => number_format($countForms),
            'countAnswerForms' => number_format($countAnswerForms),
            'countAnswers' => number_format($countAnswers),
            'countMasterLists' => number_format($countMasterLists),
        ]);
    }

    public function getAllDelete () {
        $countUsers = User::where('deleted_at','exists',true)->count();
        $countGroups = Group::where('deleted_at','exists',true)->count();
        $countForms = DB::collection('form')->where('data.deletedAt','<>','')->count();
        $countAnswerForms = DB::collection('answerForm')->where('data.deletedAt','<>','')->timeout(-1)->count();
        $countAnswers = DB::collection('answer')->where('data.deletedAt','<>','')->timeout(-1)->count();
        $countMasterLists = Masterlist::where('deleted_at','exists',true)->count();

        return response()->json([
            'countUsers' => number_format($countUsers),
            'countGroups' => number_format($countGroups),
            'countForms' => number_format($countForms),
            'countAnswerForms' => number_format($countAnswerForms),
            'countAnswers' => number_format($countAnswers),
            'countMasterLists' => number_format($countMasterLists),
        ]);
    }

    public function moreDetail (Request $request) {
        if ($request['contentType'] == "USERS") {
            $roles = Role::get();
            foreach ($roles as $role) {
                $users[$role->display_name] = User::whereNull('deleted_at')->where('role_ids',$role->_id)->count();
            }

            return response()->json([
                'contentType' => $request['contentType'],
                'users' => $users
            ]);
        } else if ($request['contentType'] == "GROUPS") {
            $groups = Group::whereNull('deleted_at')->get();
   
            foreach ($groups as $group) {
                $groupLists[$group['name']] = count($group['user_ids']);
            }
            return response()->json([
                'contentType' => $request['contentType'],
                'groupLists' => $groupLists
            ]);
        } else if ($request['contentType'] == "FORMS") {
            $form = DB::collection('form')->where('data.deletedAt','');
            $forms = $form->pluck('data');
            $formsObjectId = $form->pluck('data.objectId');
            $i = 0;
            foreach ($forms as $form) {
                $formLists[$i]['title'] = $form['title'];
                $answerForm = DB::collection('answerForm')->where('data.deletedAt','')->where('data.formId',$form['objectId'])->timeout(-1)->pluck('data.objectId');
                $formLists[$i]['answerForm'] = number_format(count($answerForm));
                //$answer = DB::collection('answer')->where('data.deletedAt','')->whereIn('data.answerFormId',$answerForm)->timeout(-1)->count();
                //$formLists[$i]['answer'] = number_format($answer);
                $i++;
            }
            return response()->json([
                'contentType' => $request['contentType'],
                'formLists' => $formLists
            ]);
        } else if ($request['contentType'] == "MASTER LISTS") {
            return response()->json([
                'contentType' => $request['contentType']
            ]);
        } else {
            return response()->json([
                'contentType' => $request['contentType']
            ]);
        }
    }
}
