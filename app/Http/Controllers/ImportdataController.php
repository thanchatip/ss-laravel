<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use carbon\Carbon;
use Artisan;
use Excel;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
use App\User;
use Session;
use Redirect;
use Log;
use PHPExcel_Worksheet;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', -1);

class ImportdataController extends Controller
{
	public function index() {
		$forms = DB::collection('form')->where('data.deletedAt','')->orderBy('data.createdAt','DESC')->pluck('data');
		return view('importdata.index',compact('forms'));
	}
	public function documents() {
		return view('importdata.documents');
	}

	/*public function import(Request $request) {
		$this->validate($request, [
            'fileupload' => 'required',
        ]);   
		$fileInput = $request->file('fileupload'); 
		#if ($fileType == "csv") {
			#$reader = ReaderFactory::create(Type::CSV); 
		#} else {
			$reader = ReaderFactory::create(Type::XLSX);
		#}
		$date = date('Y-n-d H:i:s');
		$reader->open($fileInput);
		$innerAnswers = [];
		$answers = [];
		$answerForms = [];
		$l = 0;
		foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
			$newQuestions = [];
			if ($sheetIndex > 1) {
				$i = 0;
				if (!empty($innerAnswers)) {
					foreach ($sheet->getRowIterator() as $rows) {
						if ($i == 1) {
							$formId = dataToValue(array_slice($rows,0,1));
							$question = DB::collection('question')->where('data.deletedAt','')->whereIn('data.objectId',$rows)->orderBy('data.orderIndex','ASC')->pluck('data');
							$questionForAnswerPreview = DB::collection('question')->where('data.deletedAt','')->where('data.usedForAnswerPreview',true)->whereIn('data.objectId',$rows)->orderBy('data.usedForAnswerPreviewOrderIndex','ASC')->pluck('data');
							$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$formId)->orderBy('data.orderIndex','ASC')->pluck('data');
							foreach ($pages as $page) {
								foreach ($question as $questions) {
									if ($page['objectId'] == $questions['pageId']) {
										$newQuestions[] = $questions;
									}
								}
							}
							if (empty($question)) {
								return redirect()->back()->with('templateError', '(ขาด column quetionId)');
							}
						} else if ($i > 1) {
							if (!empty($innerAnswers[$formId][$i])) {
								$answerFormPreview = [];
								if ($rows[0] != '') {
									$date = date('Y-n-d H:i:s',strtotime($rows[0]));
								}
								$lastRows = strval(array_pop($rows));
								$users = User::where('code',$lastRows)->first();
								if (empty($users)) {
									return redirect()->back()->with('answerFormError', "ไม่มีรหัสพนักงาน $lastRows");
								}
								$answerForms[$l][$i]['data']['formId'] = $formId;
								$answerForms[$l][$i]['data']['objectId'] = $innerAnswers[$formId][$i]['objectId'];
								$answerForms[$l][$i]['data']['objectType'] = "answerForm";
								$answerForms[$l][$i]['data']['createdAtQuestionFormVersion'] = 1;
								$answerForms[$l][$i]['data']['parentAnswerFormId'] = $innerAnswers[$formId][$i]['parentAnswerFormId'];
								$answerForms[$l][$i]['data']['answerPreview'] = "";
								$answerForms[$l][$i]['data']['createdAt'] = $date;
								$answerForms[$l][$i]['data']['updatedAt'] = $date;
								$answerForms[$l][$i]['data']['createdBy'] = $users->_id;
								$answerForms[$l][$i]['data']['updatedBy'] = $users->_id;
								$answerForms[$l][$i]['data']['updatedAt'] = $date;
								$answerForms[$l][$i]['data']['deletedAt'] = '';
								$answerForms[$l][$i]['data']['deletedBy'] = '';
								$answerForms[$l][$i]['data']['isoCreatedAt'] = isoDateConvert($date);
								$answerForms[$l][$i]['data']['isoUpdatedAt'] = isoDateConvert($date);
								$rows = array_slice($rows,1);
								$o = 0;
								for ($s=0;$s<count($rows);$s++) {
									if (!empty($rows[$s])) {
										$answerPerRows = explode(',',$rows[$s]);
										if (empty($newQuestions[$s])) {
											return redirect()->back()->with('templateError', '(ขาด column quetionId)');
										}
										if ($newQuestions[$s]['type'] == 0) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => preg_replace('/\s+/', '', strval($value)),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => 0,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => ""
												];
												$o++;
											}
										}
										if ($newQuestions[$s]['type'] == 1) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => $value,
													'doubleValue' => $value,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => ""
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 2 || 
											$newQuestions[$s]['type'] == 15 || 
											$newQuestions[$s]['type'] == 3 || 
											$newQuestions[$s]['type'] == 12) {
											$choice = DB::collection('choice')
														->where('data.questionId',$newQuestions[$s]['objectId'])
														->pluck('data');
											if(!empty($choice)){
												foreach ($choice as $choice) {
													foreach ($answerPerRows as $value) {
														if ($choice['title'] == $value) {
															$answers[$l][$i][$o]['data'] = [
																'objectId' => generateObjectId(),
																'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
																'questionId' => $newQuestions[$s]['objectId'],
																'createdAt' => $date,
																'createdBy' => $users->_id,
																'updatedAt' => $date,
																'updatedBy' => $users->_id,
																'isoCreatedAt' => isoDateConvert($date),
																'isoUpdatedAt' => isoDateConvert($date),
																'orderIndex' => 0,
																'objectType' => "answer",
																'deletedBy' =>  "",
																'deletedAt' => "",
																'stringValue' => strval($choice['title']),
																'answerFormIdValue' => "",
																'integerValue' => 0,
																'doubleValue' => 0,
																'dateValue' => 0,
																'latitude' => null,
																'longtitude' => null,
																'choiceId' => $choice['objectId']
															];
															$o++;
														}
													}
												}
											}
										} else if ($newQuestions[$s]['type'] == 5) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => $value,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => ""
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 6) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => 0,
													'dateValue' => $value,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => ""
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 7) {
											if (empty($answerPerRows[1])) {
												$answerPerRows[1] = $answerPerRows[0];
											}
											for ($k=$answerPerRows[0];$k<=$answerPerRows[1];$k++) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => "",
													'answerFormIdValue' => generateObjectId(),
													'integerValue' => 0,
													'doubleValue' => 0,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => ""
												];
												$innerAnswers[$newQuestions[$s]['questionFormId']][$k-1]['parentAnswerFormId'] = $answerForms[$l][$i]['data']['objectId'];
												$innerAnswers[$newQuestions[$s]['questionFormId']][$k-1]['objectId'] = $answers[$l][$i][$o]['data']['answerFormIdValue'];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 8) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => 0,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => "",
													'AnswerText' => $value
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 9) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => 0,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => "",
													'AnswerNumber' => $value
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 10) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => 0,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => "",
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 11) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => 0,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => "",
													'runningNumberList' => $value
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 13) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => $value,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => "",
												];
												$o++;
											}
										} else if ($newQuestions[$s]['type'] == 14) {
											foreach ($answerPerRows as $value) {
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => $value,
													'dateValue' => 0,
													'latitude' => null,
													'longtitude' => null,
													'choiceId' => "",
													'imagePath' => $value
												];
												$o++;
											}
										} /*else if ($newQuestions[$s]['type'] == 16) {
											foreach (explode('-',$rows[$s]) as $value) {
												$latLong = explode(',',$value);
												$answers[$l][$i][$o]['data'] = [
													'objectId' => generateObjectId(),
													'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
													'questionId' => $newQuestions[$s]['objectId'],
													'createdAt' => $date,
													'createdBy' => $users->_id,
													'updatedAt' => $date,
													'updatedBy' => $users->_id,
													'isoCreatedAt' => isoDateConvert($date),
													'isoUpdatedAt' => isoDateConvert($date),
													'orderIndex' => 0,
													'objectType' => "answer",
													'deletedBy' =>  "",
													'deletedAt' => "",
													'stringValue' => strval($value),
													'answerFormIdValue' => "",
													'integerValue' => 0,
													'doubleValue' => $value,
													'dateValue' => 0,
													'latitude' => $latLong[0],
													'longtitude' => $latLong[1],
													'choiceId' => "",
												];
												$o++;
											}
										}*/
										/*$o++;
									}
								}
								sort($answers[$l][$i]);
								for ($b=0;$b<count($questionForAnswerPreview);$b++) {
									if ($questionForAnswerPreview[$b]['type'] == 7) {
										$answerFormPreview = "ตอบเมื่อ ".dateThai($answerForms[$l][$i]['data']['createdAt']);
									} else {
										for ($a=0;$a<count($answers[$l][$i]);$a++) {
											if ($answers[$l][$i][$a]['data']['questionId'] == $questionForAnswerPreview[$b]['objectId']) {
												$answerFormPreview[] = $questionForAnswerPreview[$b]['title']." : ".$answers[$l][$i][$a]['data']['stringValue'];
											}
										}
										$answerForms[$l][$i]['data']['answerPreview'] = implode(' ',$answerFormPreview);
									}
								}
							}
						}
						$i++;
					}
					$l++;
				}
			} else {
				$i = 0;
				foreach ($sheet->getRowIterator() as $rows) {
					if ($i == 1) {
						$formId = dataToValue(array_slice($rows,0,1));
						$question = DB::collection('question')->where('data.deletedAt','')->whereIn('data.objectId',$rows)->orderBy('data.orderIndex','ASC')->pluck('data');
						$questionForAnswerPreview = DB::collection('question')->where('data.deletedAt','')->where('data.usedForAnswerPreview',true)->whereIn('data.objectId',$rows)->orderBy('data.usedForAnswerPreviewOrderIndex','ASC')->pluck('data');
						$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$formId)->orderBy('data.orderIndex','ASC')->pluck('data');
						foreach ($pages as $page) {
							foreach ($question as $questions) {
								if ($page['objectId'] == $questions['pageId']) {
									$newQuestions[] = $questions;
								}
							}
						} 
						if (empty($question)) {
							return redirect()->back()->with('templateError', 'column quetionId ไม่มี หรือรูปแบบผิด');
						}
					} else if ($i > 1) {
						$answerFormPreview = [];
						if ($rows[0] != '') {
							$date = date('Y-n-d H:i:s',strtotime($rows[0]));
						}
						$lastRows = strval(array_pop($rows));
						$users = User::where('code',$lastRows)->first();
						if (empty($users)) {
							return redirect()->back()->with('answerFormError', "ไม่มีรหัสพนักงาน $lastRows");
						}

						$answerForms[$l][$i]['data']['formId'] = $formId;
						$answerForms[$l][$i]['data']['objectId'] = generateObjectId();
						$answerForms[$l][$i]['data']['objectType'] = "answerForm";
						$answerForms[$l][$i]['data']['createdAtQuestionFormVersion'] = 1;
						$answerForms[$l][$i]['data']['parentAnswerFormId'] = '';
						$answerForms[$l][$i]['data']['answerPreview'] = "";
						$answerForms[$l][$i]['data']['createdAt'] = $date;
						$answerForms[$l][$i]['data']['updatedAt'] = $date;
						$answerForms[$l][$i]['data']['createdBy'] = $users->_id;
						$answerForms[$l][$i]['data']['updatedBy'] = $users->_id;
						$answerForms[$l][$i]['data']['updatedAt'] = $date;
						$answerForms[$l][$i]['data']['deletedAt'] = '';
						$answerForms[$l][$i]['data']['deletedBy'] = '';
						$answerForms[$l][$i]['data']['isoCreatedAt'] = isoDateConvert($date);
						$answerForms[$l][$i]['data']['isoUpdatedAt'] = isoDateConvert($date);
						$rows = array_slice($rows,1);
						$o=0;
						for ($s=0;$s<count($rows);$s++) {
							if (!empty($rows[$s])) {
								$answerPerRows = explode(',',$rows[$s]);
								if (empty($newQuestions[$s])) {
									return redirect()->back()->with('templateError', 'column quetionId ไม่มี หรือรูปแบบผิด');
								}
								if ($newQuestions[$s]['type'] == 0) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								}
								if ($newQuestions[$s]['type'] == 1) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => $value,
											'doubleValue' => $value,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 2 || 
									$newQuestions[$s]['type'] == 15 || 
									$newQuestions[$s]['type'] == 3 || 
									$newQuestions[$s]['type'] == 12) {
									$choice = DB::collection('choice')
												->where('data.questionId',$newQuestions[$s]['objectId'])
												->pluck('data');
									if(!empty($choice)){
										foreach ($choice as $choice) {
											foreach ($answerPerRows as $value) {
												if ($choice['title'] == $value) {
													$answers[$l][$i][$o]['data'] = [
														'objectId' => generateObjectId(),
														'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
														'questionId' => $newQuestions[$s]['objectId'],
														'createdAt' => $date,
														'createdBy' => $users->_id,
														'updatedAt' => $date,
														'updatedBy' => $users->_id,
														'isoCreatedAt' => isoDateConvert($date),
														'isoUpdatedAt' => isoDateConvert($date),
														'orderIndex' => 0,
														'objectType' => "answer",
														'deletedBy' =>  "",
														'deletedAt' => "",
														'stringValue' => strval($choice['title']),
														'answerFormIdValue' => "",
														'integerValue' => 0,
														'doubleValue' => 0,
														'dateValue' => 0,
														'latitude' => null,
														'longtitude' => null,
														'choiceId' => $choice['objectId']
													];
													$o++;
												}
											}
										}
									}
								} else if ($newQuestions[$s]['type'] == 5) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => $value,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 6) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => $value,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 7) {
									if (empty($answerPerRows[1])) {
										$answerPerRows[1] = $answerPerRows[0];
									}
									for ($k=$answerPerRows[0];$k<=$answerPerRows[1];$k++) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => "",
											'answerFormIdValue' => generateObjectId(),
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$innerAnswers[$newQuestions[$s]['questionFormId']][$k-1]['parentAnswerFormId'] = $answerForms[$l][$i]['data']['objectId'];
										$innerAnswers[$newQuestions[$s]['questionFormId']][$k-1]['objectId'] = $answers[$l][$i][$o]['data']['answerFormIdValue'];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 8) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'AnswerText' => $value
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 9) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'AnswerNumber' => $value
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 10) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 11) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'runningNumberList' => $value
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 13) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => $value,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 14) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => $value,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'imagePath' => $value
										];
										$o++;
									}
								} /*else if ($newQuestions[$s]['type'] == 16) {
									foreach (explode('-',$rows[$s]) as $value) {
										$latLong = explode(',',$value);
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $users->_id,
											'updatedAt' => $date,
											'updatedBy' => $users->_id,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => "",
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => $value,
											'dateValue' => 0,
											'latitude' => $latLong[0],
											'longtitude' => $latLong[1],
											'choiceId' => "",
										];
										$o++;
									}
								}*/
								/*$o++;
							}
						}
						sort($answers[$l][$i]);
						for ($b=0;$b<count($questionForAnswerPreview);$b++) {
							if ($questionForAnswerPreview[$b]['type'] == 7) {
								$answerFormPreview = "ตอบเมื่อ ".DateThai((date('Y-m-d H:i:s', strtotime($answerForms[$l][$i]['data']['createdAt'] . " +7 hour"))));
								$answerForms[$l][$i]['data']['answerPreview'] = $answerFormPreview;
							} else {
								for ($a=0;$a<count($answers[$l][$i]);$a++) {
									if ($answers[$l][$i][$a]['data']['questionId'] == $questionForAnswerPreview[$b]['objectId']) {
										$answerFormPreview[] = $questionForAnswerPreview[$b]['title']." : ".$answers[$l][$i][$a]['data']['stringValue'];
									}
								}
								$answerForms[$l][$i]['data']['answerPreview'] = implode(' ',$answerFormPreview);
							}
						}
					
					}
					$i++;
				}
				$l++;
			}
		}
		if (!empty($answerForms) && !empty($answers)) {
			foreach ($answerForms as $answerForm) {
				$data = array_map(function($var) {
					return array(
						'data' => [
							"objectId" => $var['data']['objectId'], 
							"objectType" => "answerForm", 
							"status" => "insert"
						]
					);
				}, $answerForm);
				if (!empty($data)) {
					$insert = DB::collection('checkFlatData')->insert($data,['upsert'=>true]);
				}
				DB::collection('answerForm')->insert($answerForm,['upsert'=>true]);
			}
			foreach ($answers as $answer) {
				if (!empty($answer)) {
					foreach ($answer as $value) {
						DB::collection('answer')->insert($value,['upsert'=>true]);
					}
				}
			}
			return redirect()->back()->with('importSuccess', "ข้อมูลจากไฟล์ที่คุณนำเข้า อยู่ในฐานข้อมูลแล้ว");
		} else {
			return redirect()->back()->with('answerFormError', 'ไม่มี answerForm หรือ answer ใน Excel');
		}
		$reader->close();


		return Back();
	}*/

	public function import(Request $request) {
		$this->validate($request, [
            'fileupload' => 'required',
        ]);   
		$fileInput = $request->file('fileupload'); 
		#if ($fileType == "csv") {
			#$reader = ReaderFactory::create(Type::CSV); 
		#} else {
			$reader = ReaderFactory::create(Type::XLSX);
		#}
		$date = date('Y-n-d H:i:s');
		$reader->open($fileInput);
		$answers = [];
		$answerForms = [];
		$answersInner = [];
		$l = 0;
		foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
			$newQuestions = [];
				$i = 0;
				foreach ($sheet->getRowIterator() as $rows) {
					if ($i == 1) {
						$formId = $rows[0];
						$questionInnerForms = $rows[2];
						unset($rows[0]);
						unset($rows[1]);
						unset($rows[2]);
						$question = DB::collection('question')->where('data.deletedAt','')->whereIn('data.objectId',$rows)->orderBy('data.orderIndex','ASC')->pluck('data');
						$questionForAnswerPreview = DB::collection('question')
													->where('data.deletedAt','')
													->where('data.usedForAnswerPreview',true)
													->whereIn('data.objectId',$rows)
													->orderBy('data.usedForAnswerPreviewOrderIndex','ASC')
													->pluck('data');
						$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$formId)->orderBy('data.orderIndex','ASC')->pluck('data');
						foreach ($pages as $page) {
							foreach ($question as $questions) {
								if ($page['objectId'] == $questions['pageId']) {
									$newQuestions[] = $questions;
								}
							}
						} 

						if (empty($question)) {
							return redirect()->back()->with('templateError', 'column quetionId ไม่มี หรือรูปแบบผิด');
						}
					} else if ($i > 1) {
						
						$answerFormPreview = [];
						$objectId = $rows[1];
						$parentAnswerFormId = $rows[2];
						
						if ($rows[0] != "") {
							$date = date('Y-n-d H:i:s',strtotime($rows[0]));
						} else {
							$date = date('Y-n-d H:i:s');
						}
						$users = [];
						#$lastRows = strval(array_pop($rows));
						#$users = User::where('code',$lastRows)->first();

						if (count($users) == 0) {
							$usersId = "";
							#return redirect()->back()->with('answerFormError', "ไม่มีรหัสพนักงาน $lastRows");
						} else {
							$usersId = $users->_id;
						}
						if ($questionInnerForms != "") {
							$answersInner[]['data'] = [
								'objectId' => generateObjectId(),
								'answerFormId' => $parentAnswerFormId,
								'questionId' => $questionInnerForms,
								'createdAt' => $date,
								'createdBy' => $usersId,
								'updatedAt' => $date,
								'updatedBy' => $usersId,
								'isoCreatedAt' => isoDateConvert($date),
								'isoUpdatedAt' => isoDateConvert($date),
								'orderIndex' => 0,
								'objectType' => "answer",
								'deletedBy' =>  "",
								'deletedAt' => "",
								'stringValue' => "",
								'answerFormIdValue' => $objectId,
								'integerValue' => 0,
								'doubleValue' => 0,
								'dateValue' => 0,
								'latitude' => null,
								'longtitude' => null,
								'choiceId' => ""
							];
						}
						$answerForms[$l][$i]['data']['formId'] = $formId;
						$answerForms[$l][$i]['data']['objectId'] = $objectId;
						$answerForms[$l][$i]['data']['objectType'] = "answerForm";
						$answerForms[$l][$i]['data']['createdAtQuestionFormVersion'] = 1;
						if ($parentAnswerFormId == "") {
							$answerForms[$l][$i]['data']['parentAnswerFormId'] = '';
						} else {
							$answerForms[$l][$i]['data']['parentAnswerFormId'] = $parentAnswerFormId;
						}
						$answerForms[$l][$i]['data']['answerPreview'] = "";
						$answerForms[$l][$i]['data']['createdAt'] = $date;
						$answerForms[$l][$i]['data']['updatedAt'] = $date;
						$answerForms[$l][$i]['data']['createdBy'] = $usersId;
						$answerForms[$l][$i]['data']['updatedBy'] = $usersId;
						$answerForms[$l][$i]['data']['updatedAt'] = $date;
						$answerForms[$l][$i]['data']['deletedAt'] = '';
						$answerForms[$l][$i]['data']['deletedBy'] = '';
						$answerForms[$l][$i]['data']['isoCreatedAt'] = isoDateConvert($date);
						$answerForms[$l][$i]['data']['isoUpdatedAt'] = isoDateConvert($date);
						$answerForms[$l][$i]['data']['answerStart'] = $date;
						$answerForms[$l][$i]['data']['answerEnd'] = $date;
						
						$rows = array_slice($rows,1);
						$rows = array_slice($rows,2);
					
						$o=0;
						for ($s=0;$s<count($rows);$s++) {
							if ($rows[$s] != "" && $rows[$s] != "NULL") {
								$answerPerRows = explode(',',$rows[$s]);
								if (empty($newQuestions[$s])) {
									return redirect()->back()->with('templateError', 'column quetionId ไม่มี หรือรูปแบบผิด');
								}
								if ($newQuestions[$s]['type'] == 0) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 1) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => intval($value),
											'doubleValue' => floatval($value),
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 2 || 
									$newQuestions[$s]['type'] == 15 || 
									$newQuestions[$s]['type'] == 3 || 
									$newQuestions[$s]['type'] == 12) {
									foreach ($answerPerRows as $value) {
										$value = rtrim($value, ' ');
										$choice = DB::collection('choice')
													->where('data.questionId',$newQuestions[$s]['objectId'])
													->where('data.title',$value)
													->where('data.deletedAt','')
													->first();
										if (count($choice) > 0) {
											$answers[$l][$i][$o]['data'] = [
												'objectId' => generateObjectId(),
												'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
												'questionId' => $newQuestions[$s]['objectId'],
												'createdAt' => $date,
												'createdBy' => $usersId,
												'updatedAt' => $date,
												'updatedBy' => $usersId,
												'isoCreatedAt' => isoDateConvert($date),
												'isoUpdatedAt' => isoDateConvert($date),
												'orderIndex' => 0,
												'objectType' => "answer",
												'deletedBy' =>  "",
												'deletedAt' => "",
												'stringValue' => strval($choice['data']['title']),
												'answerFormIdValue' => "",
												'integerValue' => 0,
												'doubleValue' => 0,
												'dateValue' => 0,
												'latitude' => null,
												'longtitude' => null,
												'choiceId' => $choice['data']['objectId']
											];
											$o++;
										}
									}
								} else if ($newQuestions[$s]['type'] == 5) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => floatval($value),
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 6) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => $value,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								} /*else if ($newQuestions[$s]['type'] == 7) {
									if (empty($answerPerRows[1])) {
										$answerPerRows[1] = $answerPerRows[0];
									}
									for ($k=$answerPerRows[0];$k<=$answerPerRows[1];$k++) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => "",
											'answerFormIdValue' => generateObjectId(),
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => ""
										];
										$o++;
									}
								}*/ else if ($newQuestions[$s]['type'] == 8) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'AnswerText' => $value
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 9) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'AnswerNumber' => $value
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 10) {
									foreach ($answerPerRows as $value) {
										$value = rtrim($value, ' ');
										$masterListItems = DB::collection('masterlistitem')
															->where('data.masterListId',$newQuestions[$s]['masterListId'])
															->where('data.title',$value)
															->whereNull('deleted_at')
															->first();
										
										if (count($masterListItems) > 0) {
											$answers[$l][$i][$o]['data'] = [
												'objectId' => generateObjectId(),
												'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
												'questionId' => $newQuestions[$s]['objectId'],
												'createdAt' => $date,
												'createdBy' => $usersId,
												'updatedAt' => $date,
												'updatedBy' => $usersId,
												'isoCreatedAt' => isoDateConvert($date),
												'isoUpdatedAt' => isoDateConvert($date),
												'orderIndex' => 0,
												'objectType' => "answer",
												'deletedBy' =>  "",
												'deletedAt' => "",
												'stringValue' => strval($masterListItems['data']['title']),
												'answerFormIdValue' => "",
												'integerValue' => 0,
												'doubleValue' => 0,
												'dateValue' => 0,
												'latitude' => null,
												'longtitude' => null,
												'choiceId' => "",
												'answerMasterListDetailId' => $masterListItems['data']['objectId']
											];
											$o++;
										}
									}
								} else if ($newQuestions[$s]['type'] == 11) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => 0,
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'runningNumberList' => $value
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 13) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => floatval($value),
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
										];
										$o++;
									}
								} else if ($newQuestions[$s]['type'] == 14) {
									foreach ($answerPerRows as $value) {
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => strval($value),
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => floatval($value),
											'dateValue' => 0,
											'latitude' => null,
											'longtitude' => null,
											'choiceId' => "",
											'imagePath' => $value
										];
										$o++;
									}
								} /*else if ($newQuestions[$s]['type'] == 16) {
									foreach (explode('-',$rows[$s]) as $value) {
										$latLong = explode(',',$value);
										$answers[$l][$i][$o]['data'] = [
											'objectId' => generateObjectId(),
											'answerFormId' => $answerForms[$l][$i]['data']['objectId'],
											'questionId' => $newQuestions[$s]['objectId'],
											'createdAt' => $date,
											'createdBy' => $usersId,
											'updatedAt' => $date,
											'updatedBy' => $usersId,
											'isoCreatedAt' => isoDateConvert($date),
											'isoUpdatedAt' => isoDateConvert($date),
											'orderIndex' => 0,
											'objectType' => "answer",
											'deletedBy' =>  "",
											'deletedAt' => "",
											'stringValue' => "",
											'answerFormIdValue' => "",
											'integerValue' => 0,
											'doubleValue' => $value,
											'dateValue' => 0,
											'latitude' => $latLong[0],
											'longtitude' => $latLong[1],
											'choiceId' => "",
										];
										$o++;
									}
								}*/
								$o++;
							}
						}
						if (!empty($answers[$l][$i])) {
							sort($answers[$l][$i]);
						
							for ($b=0;$b<count($questionForAnswerPreview);$b++) {
								if ($questionForAnswerPreview[$b]['type'] == 7) {
									$answerFormPreview = "ตอบเมื่อ ".DateThai((date('Y-m-d H:i:s', strtotime($answerForms[$l][$i]['data']['createdAt'] . " +7 hour"))));
									$answerForms[$l][$i]['data']['answerPreview'] = $answerFormPreview;
								} else {
									for ($a=0;$a<count($answers[$l][$i]);$a++) {
										if ($answers[$l][$i][$a]['data']['questionId'] == $questionForAnswerPreview[$b]['objectId']) {
											$questionConfigPreview = DB::collection('questionConfiguration')
																		->where('data.deletedAt','')
																		->where('data.objectId',$questionForAnswerPreview[$b]['settingId'])
																		->first();
																		
											$answerFormPreview[] = str_replace('%@', $answers[$l][$i][$a]['data']['stringValue'], $questionConfigPreview['data']['previewFormat']);
										}
									}
									$answerForms[$l][$i]['data']['answerPreview'] = implode('',$answerFormPreview);
								}
							}
							dd($answerForms[$l][$i]);
						}
					}
					$i++;
				}
				$l++;
			}
		if (!empty($answerForms) && !empty($answers)) {
			foreach ($answerForms as $answerForm) {
				$data = array_map(function($var) {
					return array(
						'data' => [
							"objectId" => $var['data']['objectId'], 
							"objectType" => "answerForm", 
							"status" => "insert"
						]
					);
				}, $answerForm);
				if (!empty($data)) {
					//$insert = DB::collection('checkFlatData')->insert($data,['upsert'=>true]);
				}
				DB::collection('answerForm')->insert($answerForm,['upsert'=>true]);
			}
			foreach ($answers as $answer) {
				if (!empty($answer)) {
					foreach ($answer as $value) {
						DB::collection('answer')->insert($value,['upsert'=>true]);
					}
				}
			}

			if (!empty($answersInner)) {
				DB::collection('answer')->insert($answersInner,['upsert'=>true]);
			}
	
			return redirect()->back()->with('importSuccess', "ข้อมูลจากไฟล์ที่คุณนำเข้า อยู่ในฐานข้อมูลแล้ว");
		} else {
			return redirect()->back()->with('answerFormError', 'ไม่มี answerForm หรือ answer ใน Excel');
		}
		$reader->close();


		return Back();
	}

	public function templateDumData(Request $request) {
		if (!$request->input('formId')) {
			return redirect()->back()->with('templateRequired', 'กรุณาเลือก Form ที่ต้องการ');
		}
		$id = $request['formId'];

		$form = DB::collection('form')->where('data.objectId',$id)->where('data.deletedAt','')->first();
		$question = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$form['data']['objectId'])->orderBy('data.orderIndex','ASC')->pluck('data');
		Excel::create('Template '.$form['data']['title'], function($excel) use ($form,$question)  {
			$excel->sheet($form['data']['title'], function($sheet) use ($form,$question) {
				$ans = [];
				$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$form['data']['objectId'])->orderBy('data.orderIndex','ASC')->pluck('data');
				$questionsOfExcel[] = 'formId';
				$questionsOfExcel[] = 'objectId';
				$questionsOfExcel[] = 'parentAnswerFormId';
				$questionIdOfExcel[] = $form['data']['objectId'];
				$questionIdOfExcel[] = '';
				$questionIdOfExcel[] = '';
				foreach ($pages as $page) {
					foreach ($question as $questions) {
						if ($page['objectId'] == $questions['pageId']) {
							$questionsOfExcel[] = $questions['title'].' (Type '.$questions['type'].')';
							$questionIdOfExcel[] = $questions['objectId'];
						}
					}
				}
				$questionsOfExcel[] = 'ผู้บันทึก';
				$sheet->row(1,$questionsOfExcel);
				$sheet->row(2,$questionIdOfExcel);
			});
			$this->innerTemplateDumpData($question,$excel);
		})->export('xlsx');
	}

	public function innerTemplateDumpData ($question,$excel) {
		$questionInners = array_filter($question,
			function ($question) {
				return $question['type'] == 7;
			}
		);
		if(!empty($questionInners)) {
			foreach($questionInners as $questionInner) { 
				$questionObjects = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$questionInner['questionFormId'])->orderBy('data.orderIndex','ASC')->pluck('data');
				$questionInnerForms = array_filter($questionObjects,
					function ($questionObjects) {
						return $questionObjects['type'] == 7;
					}
				);
				$excel->sheet($questionInner['title'], function($sheet) use ($questionInner,$questionObjects) {
					$pages = DB::collection('page')
							->where('data.deletedAt','')
							->where('data.formId',$questionInner['questionFormId'])
							->orderBy('data.orderIndex','ASC')
							->pluck('data');
					$questionsOfExcel[] = 'formId';
					$questionsOfExcel[] = 'objectId';
					$questionsOfExcel[] = 'parentAnswerFormId';
					$questionIdOfExcel[] = $questionInner['questionFormId'];
					$questionIdOfExcel[] = '';
					$questionIdOfExcel[] = '';
					foreach ($pages as $page) {
						foreach ($questionObjects as $questionObject) {
							if ($page['objectId'] == $questionObject['pageId']) {
								$questionsOfExcel[] = $questionObject['title'].' (Type '.$questionObject['type'].')';
								$questionIdOfExcel[] = $questionObject['objectId'];
							}
						}
					}
					$questionsOfExcel[] = 'ผู้บันทึก';
					$sheet->row(1,$questionsOfExcel);
					$sheet->row(2,$questionIdOfExcel);
				});
				if(!empty($questionInnerForms)) {
					$this->innerTemplateDumpData($questionObjects,$excel);
				}	
			}
		}	
	}

	public function templateChoice(Request $request) {
		if (!$request->input('Choice')) {
			return redirect()->back()->with('templateChoiceRequired', 'กรุณาเลือก Form ที่ต้องการ');
		}
		$id = $request['Choice'];

		$form = DB::collection('form')->where('data.objectId',$id)->where('data.deletedAt','')->first();
		$question = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$form['data']['objectId'])->orderBy('data.orderIndex','ASC')->pluck('data');
		Excel::create('ChoiceTitle '.$form['data']['title'], function($excel) use ($form,$question)  {
			$excel->sheet($form['data']['title'], function($sheet) use ($form,$question) {
				$dataChoice = [];
				$questionsOfExcel = [];
				$questionIdOfExcel = [];
				$choiecOfQuestions = [];
				foreach ($question as $questions) {
					$choices = DB::collection('choice')->where('data.deletedAt','')->where('data.questionId',$questions['objectId'])->pluck('data');
					if (!empty($choices)) {
						$questionsOfExcel[$questions['objectId']] = $questions['title'].' (Type '.$questions['type'].')';
						$questionIdOfExcel[$questions['objectId']] = $questions['objectId'];
						foreach ($choices as $choice) {
							$choiecOfQuestions[$questions['objectId']][] = $choice['title'];
						}
					}
				}

				if (!empty($choiecOfQuestions)) {
					foreach ($choiecOfQuestions as $key => $choiecOfQuestion) {
						$m = 0;
						$maxs = dataToValue(array_keys($choiecOfQuestions, max($choiecOfQuestions)));
		
						for ($i=0;$i<count($choiecOfQuestions[$maxs]);$i++) {
							if (empty($choiecOfQuestion[$i])) {
								$dataChoice[$m][] = '';
							} else {
								$dataChoice[$m][] = $choiecOfQuestion[$i];
							}
							$m++;
						}
						
					}
				}
			
				$sheet->row(1,$questionsOfExcel);
				$sheet->row(2,$questionIdOfExcel);
				$sheet->fromArray($dataChoice, null, 'A3', true , false);
			});
			$this->innerTemplateCoiceDumpData($question,$excel);
		})->export('xlsx');
	}

	public function innerTemplateCoiceDumpData ($question,$excel) {
		$questionInners = array_filter($question,
			function ($question) {
				return $question['type'] == 7;
			}
		);
		if(!empty($questionInners)) {
			foreach($questionInners as $questionInner) { 
				$questionObjects = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$questionInner['questionFormId'])->orderBy('data.orderIndex','ASC')->pluck('data');
				$questionInnerForms = array_filter($questionObjects,
					function ($questionObjects) {
						return $questionObjects['type'] == 7;
					}
				);
	
				$excel->sheet($questionInner['title'], function($sheet) use ($questionInner,$questionObjects) {
					$data = [];
					$dataChoice = [];
					$questionsOfExcel = [];
					$questionIdOfExcel = [];
					$choiecOfQuestions = [];
					foreach ($questionObjects as $questionObject) {
						$choices = DB::collection('choice')->where('data.deletedAt','')->where('data.questionId',$questionObject['objectId'])->pluck('data');
						if (!empty($choices)) {
							$questionsOfExcel[$questionObject['objectId']] = $questionObject['title'].' (Type '.$questionObject['type'].')';
							$questionIdOfExcel[$questionObject['objectId']] = $questionObject['objectId'];
							foreach ($choices as $choice) {
								$choiecOfQuestions[$questionObject['objectId']][] = $choice['title'];
							}
						}
					}
	
					if (!empty($choiecOfQuestions)) {
						foreach ($choiecOfQuestions as $key => $choiecOfQuestion) {
							$m = 0;
							$maxs = dataToValue(array_keys($choiecOfQuestions, max($choiecOfQuestions))[0]);
	
							for ($i=0;$i<count($choiecOfQuestions[$maxs]);$i++) {
								if (empty($choiecOfQuestion[$i])) {
									$dataChoice[$m][] = '';
								} else {
									$dataChoice[$m][] = $choiecOfQuestion[$i];
								}
								$m++;
							}
							
						}
					}

					$sheet->row(1,$questionsOfExcel);
					$sheet->row(2,$questionIdOfExcel);
					$sheet->fromArray($dataChoice, null, 'A3', true , false);
				});
				if(!empty($questionInnerForms)) {
					$this->innerTemplateCoiceDumpData($questionObjects,$excel);
				}	
			}
		}	
	}

	public function matchMSI(Request $request) {
		$this->validate($request, [
            'fileupload' => 'required',
		]);   
		$DETAILTREE_FORMID = '20180318002744-543025664027179-1857128';
		$TREE_CODE = '20180318151324-543078804894031-1989068';
		$TREE_COORDINATE = '20180318003025-543025825851041-1111915';
		$MSL = '20180704044324-552372204429101-1050208';
		$TREE_200 = '20180318151343-543078823150722-1189662';
		$TREE_PLANT = '20180318151355-54307883523262-1129799';
		$DIRECTION = '20180318143735-543076655490934-1859957';
		$X = '20180706042524-552543924051226-1229297';
		$Y = '20180706042553-552543953605446-1426034';
		$fileInput = $request->file('fileupload'); 
		$imports = Excel::load($fileInput)->toArray();
		$date = date('Y-n-d H:i:s');
		$isoDate = isoDateConvert($date);
		$userId = '5ab062973fd89d2b3e6e15e3';
		$i = 0;
		$data = [];
		if (!empty($imports)) {
			foreach ($imports as $import) {
				$answerFormId = DB::collection('answer')
							->where('data.deletedAt','')
							->where('data.questionId',$TREE_CODE)
							->where('data.stringValue',preg_replace('/\s+/', '', $import['tree_code']))
							->first();

				if (!empty($answerFormId)) {
					$answerFormsLv1 = DB::collection('answerForm')
									->where('data.deletedAt','')
									->where('data.objectId',$answerFormId['data']['answerFormId'])
									->first();
					$updateAnswerFormsLv1 = DB::collection('answerForm')
									->where('data.deletedAt','')
									->where('data.objectId',$answerFormId['data']['answerFormId'])
									->update([
										'data.updatedAt' => $date,
										'data.isoUpdatedAt' => $isoDate,
									]);
					if ($import['latitude'] != '' && $import['longitude'] != '' && $import['altitude'] != '' &&
						$import['garden_no'] != '' && $import['garden_id'] != '' && $import['direction'] != '' &&
						$import['x'] != '' && $import['y'] != ''
					) {
						$updateAnswerFormsLv1 = DB::collection('answerForm')
									->where('data.deletedAt','')
									->where('data.objectId',$answerFormId['data']['answerFormId'])
									->update([
										'data.answerStart' => $date,
										'data.answerEnd' => $date
									]);
					}
					$answerForms = DB::collection('answerForm')
									->where('data.deletedAt','')
									->where('data.objectId',$answerFormsLv1['data']['parentAnswerFormId'])
									->update([
										'data.answerPreview' => $answerFormsLv1['data']['answerPreview'],
										'data.updatedAt' => $date,
										'data.isoUpdatedAt' => $isoDate,
										'data.answerStart' => $date,
										'data.answerEnd' => $date
									]);
					if ($import['latitude'] != '' && $import['longitude'] != '' && $import['altitude'] != '') {
						$answers[$i]['data'] = [
							'objectId' => generateObjectId(),
							'answerFormId' => $answerFormId['data']['answerFormId'],
							'questionId' => $TREE_COORDINATE,
							'createdAt' => $date,
							'createdBy' => $userId,
							'updatedAt' => $date,
							'updatedBy' => $userId,
							'isoCreatedAt' => $isoDate,
							'isoUpdatedAt' => $isoDate,
							'orderIndex' => 0,
							'objectType' => "answer",
							'deletedBy' =>  "",
							'deletedAt' => "",
							'stringValue' => "",
							'answerFormIdValue' => "",
							'integerValue' => 0,
							'doubleValue' => $import['altitude'],
							'dateValue' => 0,
							'latitude' => $import['latitude'],
							'longtitude' => $import['longitude'],
							'choiceId' => "",
						];
						$i++;

						$answers[$i]['data'] = [
							'objectId' => generateObjectId(),
							'answerFormId' => $answerFormId['data']['answerFormId'],
							'questionId' => $MSL,
							'createdAt' => $date,
							'createdBy' => $userId,
							'updatedAt' => $date,
							'updatedBy' => $userId,
							'isoCreatedAt' => $isoDate,
							'isoUpdatedAt' => $isoDate,
							'orderIndex' => 0,
							'objectType' => "answer",
							'deletedBy' =>  "",
							'deletedAt' => "",
							'stringValue' => strval($import['altitude']),
							'answerFormIdValue' => "",
							'integerValue' => $import['altitude'],
							'doubleValue' => $import['altitude'],
							'dateValue' => 0,
							'latitude' => null,
							'longtitude' => null,
							'choiceId' => ""
						];	
						$i++;
					} if ($import['garden_no'] != '') {
						$answers[$i]['data'] = [
							'objectId' => generateObjectId(),
							'answerFormId' => $answerFormId['data']['answerFormId'],
							'questionId' => $TREE_200,
							'createdAt' => $date,
							'createdBy' => $userId,
							'updatedAt' => $date,
							'updatedBy' => $userId,
							'isoCreatedAt' => $isoDate,
							'isoUpdatedAt' => $isoDate,
							'orderIndex' => 0,
							'objectType' => "answer",
							'deletedBy' =>  "",
							'deletedAt' => "",
							'stringValue' => strval($import['garden_no']),
							'answerFormIdValue' => "",
							'integerValue' => 0,
							'doubleValue' => 0,
							'dateValue' => 0,
							'latitude' => null,
							'longtitude' => null,
							'choiceId' => ""
						];
						$i++;
					} if ($import['garden_id'] != '') {
						$answers[$i]['data'] = [
							'objectId' => generateObjectId(),
							'answerFormId' => $answerFormId['data']['answerFormId'],
							'questionId' => $TREE_PLANT,
							'createdAt' => $date,
							'createdBy' => $userId,
							'updatedAt' => $date,
							'updatedBy' => $userId,
							'isoCreatedAt' => $isoDate,
							'isoUpdatedAt' => $isoDate,
							'orderIndex' => 0,
							'objectType' => "answer",
							'deletedBy' =>  "",
							'deletedAt' => "",
							'stringValue' => strval($import['garden_id']),
							'answerFormIdValue' => "",
							'integerValue' => 0,
							'doubleValue' => 0,
							'dateValue' => 0,
							'latitude' => null,
							'longtitude' => null,
							'choiceId' => ""
						];
						$i++;
					} if ($import['direction'] != '') {
						$choice = DB::collection('choice')
									->where('data.questionId',$DIRECTION)
									->where('data.title',"ทิศ".$import['direction'])
									->first();

							$answers[$i]['data'] = [
								'objectId' => generateObjectId(),
								'answerFormId' => $answerFormId['data']['answerFormId'],
								'questionId' => $DIRECTION,
								'createdAt' => $date,
								'createdBy' => $userId,
								'updatedAt' => $date,
								'updatedBy' => $userId,
								'isoCreatedAt' => $isoDate,
								'isoUpdatedAt' => $isoDate,
								'orderIndex' => 0,
								'objectType' => "answer",
								'deletedBy' =>  "",
								'deletedAt' => "",
								'stringValue' => strval($choice['data']['title']),
								'answerFormIdValue' => "",
								'integerValue' => 0,
								'doubleValue' => 0,
								'dateValue' => 0,
								'latitude' => null,
								'longtitude' => null,
								'choiceId' => $choice['data']['objectId']
							];
						$i++;
					} if ($import['x'] != '') {
						$answers[$i]['data'] = [
							'objectId' => generateObjectId(),
							'answerFormId' => $answerFormId['data']['answerFormId'],
							'questionId' => $X,
							'createdAt' => $date,
							'createdBy' => $userId,
							'updatedAt' => $date,
							'updatedBy' => $userId,
							'isoCreatedAt' => $isoDate,
							'isoUpdatedAt' => $isoDate,
							'orderIndex' => 0,
							'objectType' => "answer",
							'deletedBy' =>  "",
							'deletedAt' => "",
							'stringValue' => strval($import['x']),
							'answerFormIdValue' => "",
							'integerValue' => $import['x'],
							'doubleValue' => $import['x'],
							'dateValue' => 0,
							'latitude' => null,
							'longtitude' => null,
							'choiceId' => ""
						];
						$i++;
					} if ($import['y'] != '') {
						$answers[$i]['data'] = [
							'objectId' => generateObjectId(),
							'answerFormId' => $answerFormId['data']['answerFormId'],
							'questionId' => $Y,
							'createdAt' => $date,
							'createdBy' => $userId,
							'updatedAt' => $date,
							'updatedBy' => $userId,
							'isoCreatedAt' => $isoDate,
							'isoUpdatedAt' => $isoDate,
							'orderIndex' => 0,
							'objectType' => "answer",
							'deletedBy' =>  "",
							'deletedAt' => "",
							'stringValue' => strval($import['y']),
							'answerFormIdValue' => "",
							'integerValue' => $import['y'],
							'doubleValue' => $import['y'],
							'dateValue' => 0,
							'latitude' => null,
							'longtitude' => null,
							'choiceId' => ""
						];		
						$i++;				
					}
					
					$objectId[] = $answerFormId['data']['answerFormId'];
					$checkFlat[$i]['data'] = [
						'objectId' => $answerFormId['data']['answerFormId'],
						"objectType" => "answerForm", 
						"status" => "insert"
					];
					$i++;
				}
			}
			$answerFormId = DB::collection('answer')
							->where('data.deletedAt','')
							->where('data.questionId',$TREE_CODE)
							->where('data.stringValue',"PMH0337W")
							->get();
			$answerFormsLv1 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->where('data.objectId',$answerFormId[1]['data']['answerFormId'])
							->first();
			
			$updateAnswerFormsLv1 = DB::collection('answerForm')
										->where('data.deletedAt','')
										->where('data.objectId',$answerFormsLv1['data']['objectId'])
										->update([
											'data.updatedAt' => $date,
											'data.isoUpdatedAt' => $isoDate,
										]);

			$answerForms = DB::collection('answerForm')
							->where('data.deletedAt','')
							->where('data.objectId',$answerFormsLv1['data']['parentAnswerFormId'])
							->update([
								'data.answerPreview' => $answerFormsLv1['data']['answerPreview'],
								'data.updatedAt' => $date,
								'data.isoUpdatedAt' => $isoDate,
								'data.answerStart' => $date,
								'data.answerEnd' => $date
							]);
			$objectId[] = $answerFormId[1]['data']['answerFormId'];
			$checkFlat[$i]['data'] = [
				'objectId' => $answerFormId[1]['data']['answerFormId'],
				"objectType" => "answerForm", 
				"status" => "insert"
			];
			if (!empty($answers)) {
				DB::collection('answer')->insert($answers,['upsert'=>true]);
				if (!empty($objectId)) {
					DB::collection('answerForm')
									->whereIn('data.objectId',$objectId)
									->update([
										'data.updatedAt' => $date,
										'data.isoUpdatedAt' => $isoDate,
									]);
				}
				if (!empty($checkFlat)) {
					DB::collection('checkFlatData')->insert($checkFlat,['upsert'=>true]);
					return redirect()->back()->with('msiSuccess', "นำเข้าข้อมูลสำเร็จ");
				}
			} else {
				return redirect()->back()->with('msiError', 'ไม่มีข้อมูล');
			}
		}
	}

	public function importHuaisanData(Request $request) {
		$this->validate($request, [
            'fileupload' => 'required',
		]);

		$fileInput = $request->file('fileupload'); 
		$imports = Excel::load($fileInput)->toArray();
		$date = date('Y-n-d H:i:s');
		$isoDate = isoDateConvert($date);
		$answersInsert = [];
		$answersDelete = [];
		$checkFlat = [];

		for ($i=0;$i<count($imports);$i++) {
			if (!empty($imports[$i]['objectId'])) {
				$answerForms = [];
				$answerFormsLv1 = DB::collection('answerForm')
								->timeout(-1)
								->where('data.objectId',$imports[$i]['objectId'])
								#->where('data.objectId','20180201062741-539159261680391-1451183')
								->where('data.deletedAt','');

				if (!empty($answerFormsLv1->get())) {
					$answerForms = $answerFormsLv1->first();
					if (!empty($imports[$i]['id'])) {
						$answersInsert[]['data'] = [
							"choiceId" => "", 
							"answerFormIdValue" => "", 
							"dateValue" => 0, 
							"deletedBy" => "", 
							"answerMasterListDetailId" => "", 
							"questionId" => "20171018012023-529982423958244-1286303", 
							"createdAt" => $answerForms['data']['createdAt'], 
							"orderIndex" => 0, 
							"objectType" => "answer", 
							"imagePath" => "", 
							"latitude" => null, 
							"thumbnailImagePath" => "", 
							"updatedBy" => $answerForms['data']['updatedBy'], 
							"deletedAt" => "", 
							"updatedAt" => $date, 
							"objectId" => generateObjectId(), 
							"longtitude" => null, 
							"answerFormId" => $answerForms['data']['objectId'], 
							"doubleValue" => 0, 
							"createdBy" => $answerForms['data']['createdBy'], 
							"integerValue" => 0, 
							"stringValue" => strval($imports[$i]['id']), 
							"isoCreatedAt" => $answerForms['data']['isoCreatedAt'], 
							"isoUpdatedAt" => $isoDate, 
						];
						
						$checkFlat[]['data'] = [
							'objectId' => $answerForms['data']['objectId'],
							"objectType" => "answerForm", 
							"status" => "update"
						];
					} else {
						$innerFormsLv1ObjectId = [];
						$innerFormsLv2ObjectId = [];
						$answerFormsUpdate = $answerFormsLv1->update([
							'data.deletedAt' => $date,
							'data.deletedBy' => $answerForms['data']['updatedBy'],
							'data.updatedAt' => $date,
							'data.isoUpdatedAt' => $isoDate,
						]);
						$answers = DB::collection('answer')
									->timeout(-1)
									->where('data.deletedAt','')
									->where('data.answerFormId',$answerForms['data']['objectId'])
									->update([
										'data.deletedAt' => $date,
										'data.deletedBy' => $answerForms['data']['updatedBy'],
										'data.updatedAt' => $date,
										'data.isoUpdatedAt' => $isoDate,
									]);
						$innerFormsLv1 = DB::Collection('answerForm')
											->timeout(-1)
											->where('data.parentAnswerFormId',$answerForms['data']['objectId'])
											->where('data.deletedAt','');
						if (!empty($innerFormsLv1->get())) {
							$innerFormsLv1ObjectId = $innerFormsLv1->pluck('data.objectId');
							$innerFormsLv1Update = $innerFormsLv1->update([
								'data.deletedAt' => $date,
								'data.deletedBy' => $answerForms['data']['updatedBy'],
								'data.updatedAt' => $date,
								'data.isoUpdatedAt' => $isoDate,
							]);
							$answersInnerLv1 = DB::collection('answer')
										->timeout(-1)
										->where('data.deletedAt','')
										->whereIn('data.answerFormId',$innerFormsLv1ObjectId)
										->update([
											'data.deletedAt' => $date,
											'data.deletedBy' => $answerForms['data']['updatedBy'],
											'data.updatedAt' => $date,
											'data.isoUpdatedAt' => $isoDate,
										]);
							$innerFormsLv2 = DB::Collection('answerForm')
											->timeout(-1)
											->whereIn('data.parentAnswerFormId',$innerFormsLv1ObjectId)
											->where('data.deletedAt','');

							
							if (!empty($innerFormsLv2->get())) {

								$innerFormsLv2ObjectId = $innerFormsLv2->pluck('data.objectId');
								$innerFormsLv2Update = $innerFormsLv2->update([
									'data.deletedAt' => $date,
									'data.deletedBy' => $answerForms['data']['updatedBy'],
									'data.updatedAt' => $date,
									'data.isoUpdatedAt' => $isoDate,
								]);

								$answersInnerLv2 = DB::collection('answer')
										->timeout(-1)
										->where('data.deletedAt','')
										->whereIn('data.answerFormId',$innerFormsLv2ObjectId)
										->update([
											'data.deletedAt' => $date,
											'data.deletedBy' => $answerForms['data']['updatedBy'],
											'data.updatedAt' => $date,
											'data.isoUpdatedAt' => $isoDate,
										]);
							}
							#DB::collection('flatData')->delete($innerFormsLv1ObjectId);
							#DB::collection('flatDataV2')->delete($innerFormsLv1ObjectId);
							#DB::collection('flatData')->delete($innerFormsLv2ObjectId);
							#DB::collection('flatDataV2')->delete($innerFormsLv2ObjectId);
						}
					}
				}
			}
		}
		DB::collection('answer')->timeout(-1)->insert($answersInsert,['upsert'=>true]);
		#DB::collection('checkFlatData')->insert($checkFlat,['upsert'=>true]);

		echo "finish !";

	}
}
