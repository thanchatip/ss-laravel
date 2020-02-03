<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\User;
use log;
use App\BasicReport;

ini_set('max_execution_time', '-1');
ini_set('memory_limit', '-1');

class BasicReportController extends Controller
{
    public function index($id) {
        $form = DB::collection('form')->where('data.objectId',$id)->first();
        $basicReports = BasicReport::where('data.deletedAt','')->where('data.formId',$id)->orderBy('data.createdAt','DESC')->pluck('data');

        return view('report.basicreport.index',compact('form','basicReports'));
    }

    public function store(Request $request) {
        $dateRange = explode('-',$request->input('dateRange'));
        $startDate = isoDateConvert(preg_replace('/\s+/', '', $dateRange[0]));
        $endDate = isoDateConvert( date('Y-m-d 23:59:59', strtotime(preg_replace('/\s+/', '', $dateRange[1]))) );

        $dateNow = date('Y-n-d H:i:s');
        $isoDateNow = isoDateConvert($dateNow);

        $title = $request['title'];
        $formId = $request['formId'];
        $dateBetween = [$startDate,$endDate];
        $datenow = date('Y-n-d H:i:s');
        $randomString = generateRandomString();
        $basicReportSetting = new BasicReport();
        $basicReportSetting['data.objectId'] = $randomString;
        $basicReportSetting['data.formId'] = $formId; 
        $basicReportSetting['data.title'] = $title;
        $basicReportSetting['data.createdBy'] = \Auth::user()->_id;
        $basicReportSetting['data.updatedBy'] = \Auth::user()->_id;
        $basicReportSetting['data.deletedAt'] = "";
        $basicReportSetting['data.deletedBy'] = "";
        $basicReportSetting['data.dateBetween'] = $dateBetween;
        $questions = DB::collection('question')
                    ->where('data.deletedAt','')
                    ->where('data.formId',$formId)
                    #->whereIn('data.type')
                    ->pluck('data');
        $flatData = DB::collection('flatData')
                    ->where('formId',$formId)
                    ->whereBetween('isoCreatedAt',$dateBetween)
                    ->get();

        if (!empty($flatData)) {
            $fields = array_map(function($var) use ($questions) {
                $data = [];
                $sum = 0;
                foreach ($questions as $question) {
                    if (!empty($var[$question['objectId']])) {
                        $sum = array_sum($var[$question['objectId']]);
                        $data['number'][$question['objectId']] = $sum;
                        for ($i=0;$i<count($var[$question['objectId']]);$i++) {
                            $data['choice'][$question['objectId']][] = $var[$question['objectId']][$i];
                        }  
                    } 
                }
                return $data;
            }, $flatData);

            foreach ($questions as $question) {
                if ($question['type'] == 1 || $question['type'] == 5 || $question['type'] == 13) {
                    $fieldLast = typeNumber($fields,$question);
                    if (!empty($fieldLast)) {
                        $data[$question['objectId']] = [
                            'sum' => array_sum($fieldLast),
                            'max' => max($fieldLast),
                            'min' => min($fieldLast),
                            'avg' => array_sum($fieldLast) / count($fieldLast)    
                        ];
                    }
                } if ($question['type'] == 2) {
                    $choice = typeChoice($fields,$question);
                    if (!empty($choice)) {
                        $data[$question['objectId']] = $choice;
                    }
                } if ($question['type'] == 0 || $question['type'] == 4) {
                    $text = array_column(array_column($fields,'choice'),$question['objectId']);
                    if (!empty($text)) {
                        $answersText = [];
                        foreach ($text as $texts) {
                            $answersText[] = dataToValue($texts);
                        }
                        $data[$question['objectId']] = $answersText;
                    }
                }
            }
            if (!empty($data)) {
                DB::collection('basicReport')->where('data.formId',$formId)->update([
                    'data.'.$randomString => $data,
                    'data.updatedAt' => $dateNow,
                    'data.isoUpdatedAt' => $isoDateNow
                ],['upsert' => true]);
            }
        }
        $basicReportSetting->save();
             
        return redirect()->action(
            'BasicReportController@index', ['id' => $formId]
        )->with('success',"เพิ่ม setting $title สำเร็จ");  
    }

    public function destroy($id) {
        $datenow = isoDateConvert(date('Y-n-d H:i:s'));
        $basicReportSetting = BasicReport::where('data.objectId',$id)->firstOrFail();
        $formId = $basicReportSetting['data']['formId'];
        $basicReportSetting['data.deletedAt'] = $datenow;
        $basicReportSetting['data.deletedBy'] = \Auth::user()->_id;
        DB::collection('basicReport')->where('data.formId',$formId)->unset('data.'.$id);
        $basicReportSetting->save();
        return redirect()->action(
            'BasicReportController@index', ['id' => $formId]
        )->with('success',"ลบ setting สำเร็จ");  
    }

    public function show($settingId) {
        $data = [];
        $basicReportSetting = BasicReport::where('data.objectId',$settingId)->first();
        $createdBy = User::where('_id',$basicReportSetting['data']['createdBy'])->first();
        $updatedBy = User::where('_id',$basicReportSetting['data']['updatedBy'])->first();
        $nameCreatedBy = $createdBy->prefix.$createdBy->firstname." ".$createdBy->lastname;
        $nameUpdatedBy = $updatedBy->prefix.$updatedBy->firstname." ".$updatedBy->lastname;
        $format = 'm/d/Y';
        $datetime = new \DateTime();
        $updatedAt = $datetime->setTimestamp($basicReportSetting['data']['updatedAt']->sec)->format('Y-m-d H:i:s');
        $createdAt = $datetime->setTimestamp($basicReportSetting['data']['createdAt']->sec)->format('Y-m-d H:i:s');
        $dateBetween = $datetime->setTimestamp($basicReportSetting['data']['dateBetween'][0]->sec)->format($format)." - ".$datetime->setTimestamp($basicReportSetting['data']['dateBetween'][1]->sec)->format($format);

        $data = [
            "objectId" => $settingId, 
            "formId" => $basicReportSetting['data']['formId'], 
            "title" => $basicReportSetting['data']['title'], 
            "createdBy" => $nameCreatedBy, 
            "updatedBy" => $nameUpdatedBy, 
            "deletedAt" => $basicReportSetting['data']['deletedAt'], 
            "deletedBy" => $basicReportSetting['data']['deletedBy'], 
            "dateBetween" => $dateBetween,
            "updatedAt" => DateThai((date('Y-m-d H:i:s', strtotime($updatedAt . " +7 hour")))), 
            "createdAt" => DateThai((date('Y-m-d H:i:s', strtotime($createdAt . " +7 hour"))))
        ];

        return response()->json($data);
    }

    public function update(Request $request,$formId) {
        $dateNow = date('Y-n-d H:i:s');
        $isoDateNow = isoDateConvert($dateNow);
        $dateRange = explode('-',$request->input('dateRange'));
        $startDate = isoDateConvert( preg_replace('/\s+/', '', $dateRange[0]) );
        $endDate = isoDateConvert( date('Y-m-d 23:59:59', strtotime(preg_replace('/\s+/', '', $dateRange[1]))) );
        $dateBetween = [$startDate,$endDate];

        $basicReportSetting = BasicReport::where('data.objectId',$request->objectId)->firstOrFail();
        $basicReportSetting['data.title'] = $request->title;
        $basicReportSetting['data.updatedBy'] = \Auth::user()->_id;
        $basicReportSetting['data.dateBetween'] = $dateBetween;

        $questions = DB::collection('question')
                    ->where('data.deletedAt','')
                    ->where('data.formId',$formId)
                    #->whereIn('data.type')
                    ->pluck('data');
        $flatData = DB::collection('flatData')
                    ->where('formId',$formId)
                    ->whereBetween('isoCreatedAt',$dateBetween)
                    ->get();
        $data = [];
        #if (!empty($flatData)) {
            $fields = array_map(function($var) use ($questions) {
                $data = [];
                $sum = 0;
                foreach ($questions as $question) {
                    if (!empty($var[$question['objectId']])) {
                        $sum = array_sum($var[$question['objectId']]);
                        $data['number'][$question['objectId']] = $sum;
                        for ($i=0;$i<count($var[$question['objectId']]);$i++) {
                            $data['choice'][$question['objectId']][] = $var[$question['objectId']][$i];
                        }  
                    } 
                }
                return $data;
            }, $flatData);

            foreach ($questions as $question) {
                if ($question['type'] == 1 || $question['type'] == 5 || $question['type'] == 13) {
                    $fieldLast = typeNumber($fields,$question);
                    if (!empty($fieldLast)) {
                        $data[$question['objectId']] = [
                            'sum' => array_sum($fieldLast),
                            'max' => max($fieldLast),
                            'min' => min($fieldLast),
                            'avg' => array_sum($fieldLast) / count($fieldLast)    
                        ];
                    }
                } if ($question['type'] == 2) {
                    $choice = typeChoice($fields,$question);
                    if (!empty($choice)) {
                        $data[$question['objectId']] = $choice;
                    }
                } if ($question['type'] == 0 || $question['type'] == 4) {
                    $text = array_column(array_column($fields,'choice'),$question['objectId']);
                    if (!empty($text)) {
                        $answersText = [];
                        foreach ($text as $texts) {
                            $answersText[] = dataToValue($texts);
                        }
                        $data[$question['objectId']] = $answersText;
                    }
                }
            }
            
            if (!empty($data)) {
                DB::collection('basicReport')->where('data.formId',$formId)->update([
                    'data.'.$request->objectId => $data,
                    'data.updatedAt' => $dateNow,
                    'data.isoUpdatedAt' => $isoDateNow
                ],['upsert' => true]);
            } else {
                DB::collection('basicReport')->where('data.formId',$formId)->unset('data.'.$request->objectId);
            }
        #}
        $basicReportSetting->save();

        return redirect()->action(
            'BasicReportController@index', ['id' => $formId]
        )->with('success',"แก้ไข setting $request->title สำเร็จ");  
    }
}
