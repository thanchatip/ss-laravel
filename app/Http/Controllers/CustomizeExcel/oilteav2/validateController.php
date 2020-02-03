<?php

namespace App\Http\Controllers\CustomizeExcel\oilteav2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Group;
use DB;
use Hash;
use Carbon\Carbon;
use Session;
use Redirect;
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use App\FLatdata;
use Zipper;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', -1);

class validateController extends Controller
{
    public function index() {
        $MASTER_FORM_ID = '20180420042816-5458912969862-1630781';
		$userId = \Auth::user()->_id;
        $forms = DB::collection('form')->where('data.objectId',$MASTER_FORM_ID)->pluck('data');
        $formIds = \Auth::user()->form_ids;

		if (\Auth::user()->firstname == 'admin') {
			$rolesCode = 'admin';
		} else {
			$rolesCode = checkRoles($MASTER_FORM_ID);
		}
        
        return view('report.oilteav2.validate',compact('rolesCode','forms'));    
    }

    public function validateData(Request $request) {
        $MASTER_FORMID = '20180420042816-5458912969862-1630781';
		$OWNER_PREFIX = '20180420042943-545891383981358-1006592';
		$OWNER_FIRSTNAME = '20180420043018-545891418928817-1755141';
		$OWNER_LASTNAME = '20180420043035-545891435376014-1825115';
		$VILLAGE_NAME = '20180420043213-545891533602968-1450070';
        $PLANT_NUMBER = '20180420043459-545891699115738-1658770';
        
        $LEVEL1_FORMID = '20180420043900-545891940380689-1758617';
        $TREE_NUMBER_2559 = '20180611083158-550398718495163-1470223';
        $TREE_NUMBER = '20180420043952-545891992032667-1260127';

		$LEVEL2_FORMID = '20180420044238-545892158295872-1326596';
		$GRADE_OF_TREE = '20180420044320-545892200765139-1063742'; 
		$HEIGHT_TREE = '20180420044404-545892244285336-1644447';
		$DIAMETER = '20180420044435-545892275044222-1794789';
		$BRANCH_TREE = '20180420044505-545892305313971-1194988';
		$NATURE_SHAPE = '20180420044654-545892414578524-1389900'; 
		$OTHER_SHAPE = '20180420044745-545892465774446-1006060';
        $REPAIR_YEAR = '20180420045213-545892733153395-1535699';
        $TYPE_REPAIR = '20180610114027-550323627415636-1324248';
        $IMAGE_TREE = '20180420044809-545892489077919-1169040';
        $plantNumber = $request['plantNumber'];
		$userId = \Auth::user()->_id;
        $forms = DB::collection('form')->where('data.objectId',$MASTER_FORMID)->pluck('data');
        $formIds = \Auth::user()->form_ids;

		if (\Auth::user()->firstname == 'admin') {
			$rolesCode = 'admin';
		} else {
			$rolesCode = checkRoles($MASTER_FORMID);
        }
        
        $flatData = DB::collection('flatData')
                    ->where('formId',$MASTER_FORMID)
                    ->where($PLANT_NUMBER,$plantNumber);
        $answerForms = $flatData->first();
        $objectId = $flatData->pluck('objectId');

        if (empty($objectId)) {
            Session::flash('message', "ไม่มีข้อมูลของเลขแปลง $plantNumber");
            return Redirect::back();
        }

        $answerFormsLv1 = DB::collection('flatData')
                            ->whereIn('parentAnswerFormId',$objectId)
                            ->orderBy($TREE_NUMBER,'ASC')
                            ->get();
                        
        if (!empty($answerFormsLv1)) {
            $startDate2559 = new \MongoDate(strtotime("2016-05-01 00:00:00"));
            $endDate2559 = new \MongoDate(strtotime("2017-05-01"));
            $startDate2560 = new \MongoDate(strtotime("2017-10-01 00:00:00"));
            $endDate2560 = new \MongoDate(strtotime("2018-05-01"));
            $date2561 = new \MongoDate(strtotime("2018-06-01 00:00:00"));
            $date2562 = new \MongoDate(strtotime("2019-04-01 00:00:00"));
            $notYear2562 = [];
            $than2Year2562 = [];
            $i = 0;
            $n = 0;
            $countTree = 0;
            foreach ($answerFormsLv1 as $answerFormLv1) {
                $treeNumber = '';
                if (!empty($answerFormLv1[$TREE_NUMBER])) {
                    $treeNumber = dataToValue($answerFormLv1[$TREE_NUMBER]);
                }
                $answerFormsLv22562 = DB::collection('flatData')
                                    ->where('parentAnswerFormId',$answerFormLv1['objectId'])
                                    ->whereRaw([
                                        'isoCreatedAt' => ['$gte' => $date2562]
                                    ])
                                    ->get();
                /*$answerFormsLv22560 = DB::collection('flatData')
                                    ->where('parentAnswerFormId',$answerFormLv1['objectId'])
                                    ->whereRaw([
                                        'isoCreatedAt' => ['$gte' => $startDate2560, '$lt' => $endDate2560]
                                    ])
                                    ->get();*/
                /*$answerFormsLv22559 = DB::collection('answerForm')
                                    ->where('data.parentAnswerFormId',$answerFormLv1['objectId'])
                                    ->whereRaw([
                                        'data.isoCreatedAt' => ['$gte' => $startDate2559, '$lt' => $endDate2559]
                                    ])
                                    ->get();*/
                $countTree++;
                if (count($answerFormsLv22562) == 0) {
                    $notYear2562[$i] = $treeNumber;
                    $i++;      
                } else if (count($answerFormsLv22562) > 1) {
                    $than2Year2562[$n] = $treeNumber;
                    $n++;
                }
                /*if (count($answerFormsLv22562) > 1) {
                    $data[$i]['2561Than2'] = $treeNumber;
                }
                if (empty($answerFormsLv22560)) {
                    $data[$i]['2560'] = $treeNumber;
                }
                if (empty($answerFormsLv22559)) {
                    $data[$i]['2559'] = $treeNumber;
                }*/
            }
        }

        return view('report.oilteav2.validate',compact('notYear2562','than2Year2562','answerForms','rolesCode','countTree','forms'));  
    }
}