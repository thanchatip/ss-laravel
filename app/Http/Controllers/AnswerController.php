<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Group;
use DB;
use Hash;
use Carbon\Carbon;

class AnswerController extends Controller
{
    public function show($id,$idform)
    {

        $answerForms = DB::collection('answerForm')->where('data.objectId',$id);
        $answerForms = $answerForms->pluck('data');

        foreach ($answerForms as $answerForm) {
            $pages = DB::collection('page')->where('data.formId',$answerForm['formId'])->orderBy('data.orderIndex', 'ASC');
            $pages = $pages->pluck('data');    
        }

            $questions = DB::collection('question')->where('data.formId',$answerForm['formId']);
            $questions = $questions->pluck('data');

            $answers = DB::collection('answer')->where('data.answerFormId',$id);
            $answers = $answers->pluck('data');
            
                return view('answerForms.show',compact('answerForms', 'answers', 'questions','pages','data','idform','$id'));

    }
}
