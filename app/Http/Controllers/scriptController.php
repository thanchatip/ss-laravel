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
ini_set('max_execution_time', 1200);
ini_set('memory_limit', '-1');

class scriptController extends Controller
{
	public function switchAnswer() {
	/*try {
			$datetime = isoDateConvert(date('2018-01-23'));
			$answers = DB::collection('answer')
						->where('data.isoCreatedAt','>=',$datetime)
						->where('data.questionId','20180117124501-537885901825474-1272237')
						->pluck('data');
				$current = Carbon::tomorrow();
				$dateTomorrow = date_format($current,"Y-n-d H:i:s");
				$answerFormId = [];
			foreach ($answers as $answer) {
				$updateAnswer = DB::collection('answer')
									->where('data.objectId',$answer['objectId'])
									->update([
										'data.integerValue' => $answer['doubleValue'],
										'data.updatedAt' => $dateTomorrow,
										'data.isoUpdatedAt' => isoDateConvert($dateTomorrow),
									]);
				if ($updateAnswer) {
					$answerFormIds[] = $answer['answerFormId'];
				}
			}
			
			if (!empty($answerFormIds)) {
				foreach ($answerFormIds as $answerFormId) {
					$data[]['data'] = [
						'objectId' => $answerFormId,
						'status' => 'update'
					];
				}
			}

			if (!empty($data)) {
				$insert = DB::collection('checkFlatData')->insert($data);
			}

		} catch (\Exception $e) {
			return \API::response()->array([
			  'error' => array('code' => '30xx' , 'message' => $e->getMessage())
			]);
		}*/
	}

	#huaisan markdeletedAt
	public function markDeletedAtAnswer() {
		/*$objectIds = [
			'20180201015637-539142997038214-1722171',
			'20180201015819-539143099961628-1788894',
			'20180201015827-539143107181464-1210550',
			'20180201015948-539143188003678-1298801',
			'20180201020113-539143273394721-1399513',
			'20180201020144-539143304587958-1348748',
			'20180201020648-539143608549957-1413810',
			'20180201024442-53914588284998-1700843',
			'20180201024557-539145957141898-1849833',
			'20180201025939-539146779064924-1596732',
			'20180201032657-539148417534921-1736864'
		];
		#หมู่ที่ '20171227090843-536058523771856-1153138' 
		#ชื่อหมู่บ้าน (หมู่ที่11) '20180108065203-537087123424853-1460894'
		foreach($objectIds as $objectId) {
			$villageNumbers = DB::collection('answer')
					->where('data.answerFormId',$objectId)
					->where('data.questionId','20171227090843-536058523771856-1153138')
					->where('data.deletedAt','')
					->orderBy('data.updatedAt','ASC')
					->pluck('data');

			$villageNames = DB::collection('answer')
					->where('data.answerFormId',$objectId)
					->where('data.questionId','20180108065203-537087123424853-1460894')
					->where('data.deletedAt','')
					->orderBy('data.updatedAt','ASC')
					->pluck('data');


				if (count($villageNumbers) == 2) {
					$updateVillageNumbers = DB::collection('answer')
											->where('data.objectId',$villageNumbers[0]['objectId'])
											->update([
												'data.deletedAt' => $villageNumbers[0]['updatedAt'],
												'data.deletedBy' => $villageNumbers[0]['updatedBy']
											]);					
				}
			
				if (count($villageNames) == 2) {
					$updateVillageNames = DB::collection('answer')
										->where('data.objectId',$villageNames[0]['objectId'])
										->update([
											'data.deletedAt' => $villageNames[0]['updatedAt'],
											'data.deletedBy' => $villageNames[0]['updatedBy']
										]);
				}

				$data[]['data'] = [
					'objectId' => $objectId,
					'status' => 'update'
				];
		}

		if (!empty($data)) {
			$insert = DB::collection('checkFlatData')->insert($data);
			if ($insert) {
				return "answer of answerForm fix !";
			}
		}*/
	}

	public function insertColumn () {
		/*$answerForms = DB::collection('answerForm')->pluck('data');

		$now = date('Y-n-d H:m:s');
		if (count($answerForms) > 0) {
			foreach ($answerForms as $answerForm) {
				DB::collection('answerForm')
					->where('data.objectId',$answerForm['objectId'])
					->update([
						'data.answerStart' => $answerForm['createdAt'],
						'data.answerEnd' => $answerForm['updatedAt'],
						'data.updatedAt' => $now,
						'data.isoUpdatedAt' => isoDateConvert($now)
					]);	
			}
			return "success";
		} else {
			return "have no answerForm !";
		}*/
	}

	public function dumpData ($limit) {
		/*$callcommand = Artisan::call("oilteav2:dumpdata",['limit' => $limit]);
		if ($callcommand) {
			return "Dumpdata Success $limit AnswerForm";
		}*/
		#Artisan::queue("oilteav2:dumpdata");
		# OLD VERSION
		$MASTER_OILTEA_LV1 = '20170923133340-527866420224209-1749826';
		$INNER_OILTEA_LV1 = '20170924051930-527923170847862-1797275';

		$OWNER_PREFIX_LV1 = '20170927035437-528177277140892-1456683';
		$OWNER_FIRSTNAME_LV1 = '20170927035050-528177050079481-1208383';
		$OWNER_LASTNAME_LV1 = '20170927035405-528177245844387-1945347';
		$VILLAGE_NAME_LV1 = '20170923133938-527866778466936-1673062';
		$PLANT_NUMBER_LV1 = '20170923133359-527866439397654-1906985';
		$QUESTION_INNER_LV1 = '20170924055643-527925403438996-1541374';
		$TREE_NUMBER_LV1 = '20170924051946-527923186856328-1818442';

        $GRADE_OF_TREE = '20170924052009-527923209216053-1393981'; 
        $BRANCH_TREE = '20170928064746-528274066156638-1855247';
        $HEIGHT_TREE = '20170924052356-527923436402867-1527983'; 
        $DIAMETER = '20170924052420-527923460685421-1506424'; 
        $NATURE_SHAPE = '20170924052527-527923527114575-1199551'; 
        $OTHER_SHAPE = '20170924052624-527923584636773-1020211';
        $REPAIR_YEAR = '20170930132742-528470862371504-1932568';
		$IMAGE_TREE = '20170924052756-527923676209237-1301131';
		
		# NEW VERSION
		$MASTER_OILTEA_LV2 = '20180420042816-5458912969862-1630781';
		$INNER_OILTEA_LV2 = '20180420043900-545891940380689-1758617';
		$INNERLV2_OILTEA_LV2 = '20180420044238-545892158295872-1326596';

		$OWNER_PREFIX_LV2 = '20180420042943-545891383981358-1006592';
		$OWNER_FIRSTNAME_LV2 = '20180420043018-545891418928817-1755141';
		$OWNER_LASTNAME_LV2 = '20180420043035-545891435376014-1825115';
		$VILLAGE_NAME_LV2 = '20180420043213-545891533602968-1450070';
		$PLANT_NUMBER_LV2 = '20180420043459-545891699115738-1658770';
		$QUESTION_INNER_LV2 = '20180420050224-545893344686709-1048117';
		$TREE_NUMBER_LV2 = '20180420043952-545891992032667-1260127';

		$MSTER_OILTEA_LV3 = '20180420044238-545892158295872-1326596';

		$GRADE_OF_TREE_LV3 = '20180420044320-545892200765139-1063742'; 
		$HEIGHT_TREE_LV3 = '20180420044404-545892244285336-1644447';
		$DIAMETER_LV3 = '20180420044435-545892275044222-1794789';
		$BRANCH_TREE_LV3 = '20180420044505-545892305313971-1194988';
		$NATURE_SHAPE_LV3 = '20180420044654-545892414578524-1389900'; 
		$OTHER_SHAPE_LV3 = '20180420044745-545892465774446-1006060';
		$REPAIR_YEAR_LV3 = '20180420045213-545892733153395-1535699';
		$IMAGE_TREE_LV3 = '20180420044809-545892489077919-1169040';
		
		$checkScript = DB::collection('checkScript')->pluck('objectId');
		if (!empty($checkScript)) {
			$answerFormOilTeaLv1 = DB::collection('answerForm')
			->where('data.formId',$MASTER_OILTEA_LV1)
			#->where('data.objectId','20171025025741-530593061283564-1219273')
			->whereNotIn('data.objectId',$checkScript)
			->where('data.deletedAt','')
			->limit($limit)
			->project(['_id' => 0]);
		} else {
			$answerFormOilTeaLv1 = DB::collection('answerForm')
			->where('data.formId',$MASTER_OILTEA_LV1)
			#->where('data.objectId','20171025025741-530593061283564-1219273')
			->where('data.deletedAt','')
			->limit($limit)
			->project(['_id' => 0]);
		}
		$answerFormOilTeaLv1 = $answerFormOilTeaLv1->get();
		if (count($answerFormOilTeaLv1) > 0) {
			for ($i=0;$i<count($answerFormOilTeaLv1);$i++) {
				$answerOilTeaLv1 = DB::collection('answer')
									->where('data.answerFormId',$answerFormOilTeaLv1[$i]['data']['objectId'])
									->where('data.deletedAt','')
									->project(['_id' => 0])
									->get();
				$oldObjectId = $answerFormOilTeaLv1[$i]['data']['objectId'];
				$answerFormId = generateObjectId();
				$answerFormOilTeaLv1[$i]['data']['formId'] = $MASTER_OILTEA_LV2;
				$answerFormOilTeaLv1[$i]['data']['objectId'] = $answerFormId;
				$answerFormOilTeaLv1[$i]['data']['answerStart'] = date('Y-n-d H:m:s');
				$answerFormOilTeaLv1[$i]['data']['answerEnd'] = date('Y-n-d H:m:s');
				$prefix = '';
				$firstname = '';
				$lastname = '';
				if (count($answerOilTeaLv1) > 0) {
					for ($m=0;$m<count($answerOilTeaLv1);$m++) {
						$checkFlatAnswerFormAnswers = [];
						$questionId = $answerOilTeaLv1[$m]['data']['questionId'];
						$answerOilTeaLv1[$m]['data']['answerFormId'] = $answerFormId;
						$answerOilTeaLv1[$m]['data']['objectId'] = generateObjectId();
						if ($questionId == $OWNER_PREFIX_LV1) {
							$answerOilTeaLv1[$m]['data']['questionId'] = $OWNER_PREFIX_LV2;
							$prefix = $answerOilTeaLv1[$m]['data']['stringValue'];
						} else if ($questionId == $OWNER_FIRSTNAME_LV1) {
							$answerOilTeaLv1[$m]['data']['questionId'] = $OWNER_FIRSTNAME_LV2;
							$firstname = $answerOilTeaLv1[$m]['data']['stringValue'];
						} else if ($questionId == $OWNER_LASTNAME_LV1) {
							$answerOilTeaLv1[$m]['data']['questionId'] = $OWNER_LASTNAME_LV2;
							$lastname = $answerOilTeaLv1[$m]['data']['stringValue'];
						} else if ($questionId == $VILLAGE_NAME_LV1) {
							$answerOilTeaLv1[$m]['data']['questionId'] = $VILLAGE_NAME_LV2;
						} else if ($questionId == $PLANT_NUMBER_LV1) {
							$answerOilTeaLv1[$m]['data']['questionId'] = $PLANT_NUMBER_LV2;
						} else if ($questionId == $QUESTION_INNER_LV1) {
							$answerOilTeaLv1[$m]['data']['questionId'] = $QUESTION_INNER_LV2;
							$answerFormAnswers = DB::collection('answerForm')
												->where('data.deletedAt','')
												->where('data.objectId',$answerOilTeaLv1[$m]['data']['answerFormIdValue'])
												->project(['_id' => 0])
												->get();
							$answerFormIdValue = generateObjectId();
							$answerOilTeaLv1[$m]['data']['answerFormIdValue'] = $answerFormIdValue;
							if (count($answerFormAnswers) > 0) {
								for ($l=0;$l<count($answerFormAnswers);$l++) {
									$answers = DB::collection('answer')
												->where('data.deletedAt','')
												->where('data.answerFormId',$answerFormAnswers[$l]['data']['objectId'])
												->project(['_id' => 0])
												->get();
									$answerFormAnswers[$l]['data']['parentAnswerFormId'] = $answerFormId;
									$answerFormAnswers[$l]['data']['objectId'] = $answerFormIdValue;
									$answerFormAnswers[$l]['data']['formId'] = $INNER_OILTEA_LV2;
									$answerFormAnswers[$l]['data']['answerStart'] = date('Y-n-d H:m:s');
									$answerFormAnswers[$l]['data']['answerEnd'] = date('Y-n-d H:m:s');
									$answerPreviewsLv2 = '';
									if ($answerFormAnswers[$l]['data']['answerPreview'] != '') {
										$answerPreviewsLv2 = mb_substr($answerFormAnswers[$l]['data']['answerPreview'],18,7);
										$answerPreviewsLv2 = mb_substr($answerFormAnswers[$l]['data']['answerPreview'],20);
										$numberOilTea = mb_substr($answerFormAnswers[$l]['data']['answerPreview'],20,4);
										$answerPreviewsLv2 = mb_substr($answerFormAnswers[$l]['data']['answerPreview'],26);
										$answerFormAnswers[$l]['data']['answerPreview'] = 'เลขที่ต้นชาน้ำมัน : '.$numberOilTea;
									}
									if (count($answers) > 0) {
										$newAnswers = [];
										$newAnswerForms = [];
										$newAnswersLevelEnd = [];
										$objectIdNEwAnswerForm = generateObjectId();
										for ($u=0;$u<count($answers);$u++) {
											if ($answers[$u]['data']['questionId'] == $TREE_NUMBER_LV1) {
												$newAnswers[$u]['data'] = [
													"choiceId" => "", 
													"answerFormIdValue" => "", 
													"dateValue" => 0, 
													"deletedBy" => "", 
													"answerMasterListDetailId" => "", 
													"questionId" => $TREE_NUMBER_LV2, 
													"createdAt" => $answers[$u]['data']['createdAt'], 
													"orderIndex" => 0, 
													"objectType" => "answer", 
													"imagePath" => "", 
													"latitude" => null, 
													"thumbnailImagePath" => "", 
													"updatedBy" => $answers[$u]['data']['updatedBy'], 
													"deletedAt" => "", 
													"updatedAt" => $answers[$u]['data']['updatedAt'], 
													"objectId" => generateObjectId(), 
													"longtitude" => null, 
													"answerFormId" => $answerFormAnswers[$l]['data']['objectId'], 
													"doubleValue" => 0, 
													"createdBy" => $answers[$u]['data']['createdBy'], 
													"integerValue" => 0, 
													"stringValue" => $answers[$u]['data']['stringValue'], 
													"isoCreatedAt" => $answers[$u]['data']['isoCreatedAt'], 
													"isoUpdatedAt" => $answers[$u]['data']['isoUpdatedAt'], 
												];
												if (!empty($newAnswers[0])) {
													$checkFlatNewAnswerForms = [];
													$newAnswers[$u+1]['data'] = [
														"choiceId" => "", 
														"answerFormIdValue" => $objectIdNEwAnswerForm, 
														"dateValue" => 0, 
														"deletedBy" => "", 
														"answerMasterListDetailId" => "", 
														"questionId" => "20180420050130-545893290063516-1424194", #คำถาม innerform lv3
														"createdAt" => $newAnswers[0]['data']['createdAt'], 
														"orderIndex" => 0, 
														"objectType" => "answer", 
														"imagePath" => "", 
														"latitude" => null, 
														"thumbnailImagePath" => "", 
														"updatedBy" => $newAnswers[0]['data']['updatedBy'], 
														"deletedAt" => "", 
														"updatedAt" => $newAnswers[0]['data']['updatedAt'], 
														"objectId" => generateObjectId(), 
														"longtitude" => null, 
														"answerFormId" => $answerFormAnswers[$l]['data']['objectId'], 
														"doubleValue" => 0, 
														"createdBy" => $newAnswers[0]['data']['createdBy'], 
														"integerValue" => 0, 
														"stringValue" => "", 
														"isoCreatedAt" => $newAnswers[0]['data']['isoCreatedAt'], 
														"isoUpdatedAt" => $newAnswers[0]['data']['isoCreatedAt'], 
													];
													$insertNewAnswers = DB::collection('answer')->insert($newAnswers, ['upsert' => true]);
													$newAnswerForms[0]['data'] = [
														"createdAt" => $answerFormAnswers[$l]['data']['createdAt'], 
														"formId" => $MSTER_OILTEA_LV3, 
														"objectType" => "answerForm", 
														"answerPreview" => "รายการตรวจ : ณ วันที่ %t - ".$answerPreviewsLv2, 
														"createdAtQuestionFormVersion" => 1, 
														"updatedBy" => $answerFormAnswers[$l]['data']['updatedBy'], 
														"deletedAt" => "", 
														"answerEnd" => date('Y-n-d H:m:s'), 
														"updatedAt" => $answerFormAnswers[$l]['data']['updatedAt'], 
														"objectId" => $objectIdNEwAnswerForm, 
														"parentAnswerFormId" => $answerFormAnswers[$l]['data']['objectId'], 
														"answerFormValue" => 0, 
														"answerStart" => date('Y-n-d H:m:s'), 
														"createdBy" => $answerFormAnswers[$l]['data']['createdBy'], 
														"deletedBy" => "", 
														"isoCreatedAt" => $answerFormAnswers[$l]['data']['isoCreatedAt'], 
														"isoUpdatedAt" => $answerFormAnswers[$l]['data']['isoUpdatedAt'], 
														"syncTimestamp" => date('Y-m-d H:m:s')
													];
													$insertNewAnswerForms = DB::collection('answerForm')->insert($newAnswerForms, ['upsert' => true]);
													if ($insertNewAnswerForms) {
														$checkFlatNewAnswerForms[]['data'] = [
															'objectId' => $newAnswerForms[0]['data']['objectId'],
															'status' => 'insert'
														];
														DB::collection('checkFlatData')->insert($checkFlatNewAnswerForms, ['upsert' => true]);
													}
												}
											} else {
												$newAnswersLevelEnd[$u]['data'] = $answers[$u]['data'];
												if ($answers[$u]['data']['questionId'] == $GRADE_OF_TREE) {
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $GRADE_OF_TREE_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
													if ($newAnswersLevelEnd[$u]['data']['choiceId'] == '20170924052029-527923229201352-1991636') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045312-545892792777766-1916121';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052029-527923229399136-1889340') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045312-545892792995503-1815749';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052029-527923229582144-1103779') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045313-545892793184269-1107684';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052029-527923229748417-1487192') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045313-545892793668595-1142645';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052204-52792332492869-1035050') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045313-545892793840947-1067041';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052205-527923325247337-1596126') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045610-545892970781212-1280894';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052315-527923395561551-1800508') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045624-54589298428996-1150355';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052315-527923395758179-1677544') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045624-545892984497247-1897122';
													} else if ($answers[$u]['data']['choiceId'] == '20170924084136-527935296119601-1077517') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045624-54589298469838-1901266';
													} else if ($answers[$u]['data']['choiceId'] == '20170924084145-52793530504505-1047442') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420045740-545893060937886-1007075';
													}
												} else if ($answers[$u]['data']['questionId'] == $BRANCH_TREE) {
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $BRANCH_TREE_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
													if ($newAnswersLevelEnd[$u]['data']['choiceId'] == '20170928064801-528274081331914-1029176') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420044609-545892369216443-1932556';
													} else if ($answers[$u]['data']['choiceId'] == '20170928064801-528274081616468-1927489') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420044609-54589236948746-1371180';
													}
												} else if ($answers[$u]['data']['questionId'] == $HEIGHT_TREE) {
													
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $HEIGHT_TREE_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
													$newAnswersLevelEnd[$u]['data']['integerValue'] = $newAnswersLevelEnd[$u]['data']['doubleValue'];
												} else if ($answers[$u]['data']['questionId'] == $DIAMETER) {
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $DIAMETER_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
													$newAnswersLevelEnd[$u]['data']['integerValue'] = $newAnswersLevelEnd[$u]['data']['doubleValue'];
												} else if ($answers[$u]['data']['questionId'] == $NATURE_SHAPE) {
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $NATURE_SHAPE_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
													if ($answers[$u]['data']['choiceId'] == '20170924052555-5279235556977-1504255') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420044718-545892438404886-1833659';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052555-527923555944855-1267756') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420044718-545892438611916-1705364';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052556-527923556151537-1557017') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420044718-54589243877754-1339119';
													} else if ($answers[$u]['data']['choiceId'] == '20170924052613-527923573497407-1390516') {
														$newAnswersLevelEnd[$u]['data']['choiceId'] = '20180420044718-545892438969367-1293893';
													}
												} else if ($answers[$u]['data']['questionId'] == $OTHER_SHAPE) {
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $OTHER_SHAPE_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
												} else if ($answers[$u]['data']['questionId'] == $REPAIR_YEAR) {
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $REPAIR_YEAR_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
												} else if ($answers[$u]['data']['questionId'] == $IMAGE_TREE) {
													$newAnswersLevelEnd[$u]['data']['answerFormId'] = $objectIdNEwAnswerForm;
													$newAnswersLevelEnd[$u]['data']['questionId'] = $IMAGE_TREE_LV3;
													$newAnswersLevelEnd[$u]['data']['objectId'] = generateObjectId();
												}
											}
										}
										$insertNewAnswerLevelEnd = DB::collection('answer')->insert($newAnswersLevelEnd, ['upsert' => true]);
									}
									$checkFlatAnswerFormAnswers[]['data'] = [
										'objectId' => $answerFormIdValue,
										'status' => 'insert'
									];
								}
								$insertAnswerFormAnswers = DB::collection('answerForm')->insert($answerFormAnswers, ['upsert' => true]);
								if ($insertAnswerFormAnswers) {
									DB::collection('checkFlatData')->insert($checkFlatAnswerFormAnswers, ['upsert' => true]);
								}
							}
						}
					}
					$insertAnswerOilTeaLv1 = DB::collection('answer')->insert($answerOilTeaLv1, ['upsert' => true]);		
				}
				$answerFormOilTeaLv1[$i]['data']['answerPreview'] = $prefix.' '.$firstname.' '.$lastname.' : '.$answerFormOilTeaLv1[$i]['data']['answerPreview'];
				$dataAnswerFormOilTeaLv1 = [];
				$dataAnswerFormOilTeaLv1[] = $answerFormOilTeaLv1[$i];
				$insertAnswerFormOilTeaLv1 = DB::collection('answerForm')->insert($dataAnswerFormOilTeaLv1,['upsert' => true]);
				if ($insertAnswerFormOilTeaLv1) {
					$checkFlatAnswerFormOilTeaLv1 = [];
					$checkFlatAnswerFormOilTeaLv1[]['data'] = [
						'objectId' => $answerFormOilTeaLv1[$i]['data']['objectId'],
						'status' => 'insert'
					];
					DB::collection('checkScript')->insert([
						'objectId' => $oldObjectId
					],['upsert' => true]);
					DB::collection('checkFlatData')->insert($checkFlatAnswerFormOilTeaLv1, ['upsert' => true]);
				}
			}
		}
	}

	public function import(Request $request,$formId) {
		$fileInput = $request->file('usersImport');
            
		#if ($fileType == "csv") {
			#$reader = ReaderFactory::create(Type::CSV); 
		#} else {
			$reader = ReaderFactory::create(Type::XLSX);
		#}
		$date = date('Y-n-d H:m:s');
		$reader->open($fileInput);
		$answerForms = [];
		$answers = [];
		foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
			if ($sheetIndex > 1) {
				if (!empty($innerAnswers)) {
					dd($innerAnswers[$sheetIndex-1]);
				}
			}
			$i = 0;
			$m = 0;
			$newQuestions = [];
			$innerAnswers = [];
			foreach ($sheet->getRowIterator() as $rows) {
				if ($i == 1) {
					$formId = dataToValue(array_slice($rows,0,1));
					$question = DB::collection('question')->where('data.deletedAt','')->whereIn('data.objectId',$rows)->orderBy('data.orderIndex','ASC')->pluck('data');
					$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$formId)->orderBy('data.orderIndex','ASC')->pluck('data');
					foreach ($pages as $page) {
						foreach ($question as $questions) {
							if ($page['objectId'] == $questions['pageId']) {
								$newQuestions[] = $questions;
							}
						}
					}
				} else if ($i != 0 && $i != 1) {
					$n = 0;
					$answerForms[$formId][$m]['data']['formId'] = $formId;
					$answerForms[$formId][$m]['data']['objectId'] = generateObjectId();
					$answerForms[$formId][$m]['data']['parentAnswerFormId'] = '';
					$answerForms[$formId][$m]['data']['answerPreview'] = "test$m";
					$answerForms[$formId][$m]['data']['createdAt'] = $date;
					$answerForms[$formId][$m]['data']['updatedAt'] = $date;
					$answerForms[$formId][$m]['data']['createdBy'] = \Auth::user()->_id;
					$answerForms[$formId][$m]['data']['updatedBy'] = \Auth::user()->_id;
					$answerForms[$formId][$m]['data']['updatedAt'] = $date;
					$answerForms[$formId][$m]['data']['deletedAt'] = '';
					$answerForms[$formId][$m]['data']['deletedBy'] = '';
					$answerForms[$formId][$m]['data']['isoCreatedAt'] = isoDateConvert($date);
					$answerForms[$formId][$m]['data']['isoUpdatedAt'] = isoDateConvert($date);
					$rows = array_slice($rows,1);
					for ($s=0;$s<count($rows);$s++) {
						if (!empty($rows[$s])) {
							$answers[$formId][$s]['data']['objectId'] = generateObjectId();
							$answers[$formId][$s]['data']['answerFormId'] = $answerForms[$formId][$m]['data']['objectId'];
							$answers[$formId][$s]['data']['questionId'] = $newQuestions[$s]['objectId'];
							$answers[$formId][$s]['data']['createdAt'] = $date;
							$answers[$formId][$s]['data']['createdBy'] = \Auth::user()->_id;
							$answers[$formId][$s]['data']['updatedAt'] = $date;
							$answers[$formId][$s]['data']['updatedBy'] = \Auth::user()->_id;
							$answers[$formId][$s]['data']['isoCreatedAt'] = isoDateConvert($date);
							$answers[$formId][$s]['data']['isoUpdatedAt'] = isoDateConvert($date);
							$answers[$formId][$s]['data']['orderIndex'] = 0;
							$answers[$formId][$s]['data']['objectType'] = "answer";
							$answers[$formId][$s]['data']['deletedBy'] = "";
							$answers[$formId][$s]['data']['deletedAt'] = "";
							$answers[$formId][$s]['data']['stringValue'] = $rows[$s];
							$answers[$formId][$s]['data']['answerFormIdValue'] = '';
							$answers[$formId][$s]['data']['integerValue'] = 0;
							$answers[$formId][$s]['data']['doubleValue'] = 0;
							$answers[$formId][$s]['data']['dateValue'] = 0;
							$answers[$formId][$s]['data']['latitude'] = null;
							$answers[$formId][$s]['data']['longtitude'] = null;
							$answers[$formId][$s]['data']['choiceId'] = '';
							if ($newQuestions[$s]['type'] == 1) {
								$answers[$formId][$s]['data']['integerValue'] = $rows[$s];
								$answers[$formId][$s]['data']['doubleValue'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 2 || 
								$newQuestions[$s]['type'] == 15 || 
								$newQuestions[$s]['type'] == 3 || 
								$newQuestions[$s]['type'] == 12) {
								$choice = DB::collection('choice')
											->where('data.questionId',$newQuestions[$s]['objectId'])
											->pluck('data');
								if(!empty($choice)){
									foreach ($choice as $choice) {
										if ($choice['title'] == $rows[$s]) {
											$answers[$formId][$s]['data']['choiceId'] = $choice['objectId'];
											$answers[$formId][$s]['data']['stringValue'] = $choice['title'];
										}
									}
								}
							} else if ($newQuestions[$s]['type'] == 5) {
								$answers[$formId][$s]['data']['doubleValue'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 6) {
								$answers[$formId][$s]['data']['dateValue'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 7) {
								$answers[$formId][$s]['data']['answerFormIdValue'] = generateObjectId();
								$answers[$formId][$s]['data']['stringValue'] = '';
								$innerAnswers[$sheetIndex] = explode(',',$rows[$s]);
							} else if ($newQuestions[$s]['type'] == 8) {
								$answers[$formId][$s]['data']['AnswerText'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 9) {
								$answers[$formId][$s]['data']['AnswerNumber'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 10) {
								$answers[$formId][$s]['data']['stringValue'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 11) {
								$answers[$formId][$s]['data']['runningNumberList'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 13) {
								$answers[$formId][$s]['data']['doubleValue'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 14) {
								$answers[$formId][$s]['data']['imagePath'] = $rows[$s];
							} else if ($newQuestions[$s]['type'] == 16) {
								$answers[$formId][$s]['data']['latitude'] = $rows[$s];
								$answers[$formId][$s]['data']['longtitude'] = $rows[$s];
							}
						}
					}
					$m++;
				}
				$i++;
			}
		}
		dd($innerAnswers);
		$reader->close();
	}

	public function templateDumData($id) {
		$form = DB::collection('form')->where('data.objectId',$id)->where('data.deletedAt','')->first();
		$question = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$form['data']['objectId'])->orderBy('data.orderIndex','ASC')->pluck('data');

		Excel::create('Template '.$form['data']['title'], function($excel) use ($form,$question)  {
			$excel->sheet($form['data']['objectId'], function($sheet) use ($form,$question) {
				$ans = [];
				$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$form['data']['objectId'])->orderBy('data.orderIndex','ASC')->pluck('data');
				$OfExcel[] = 'formId';
				$questionIdOfExcel[] = $form['data']['objectId'];
				foreach ($pages as $page) {
					foreach ($question as $questions) {
						if ($page['objectId'] == $questions['pageId']) {
							$questionsOfExcel[] = $questions['title'];
							$questionIdOfExcel[] = $questions['objectId'];
						}
					}
				}
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
				$excel->sheet($questionInner['objectId'], function($sheet) use ($questionInner,$questionObjects) {
					$pages = DB::collection('page')
							->where('data.deletedAt','')
							->where('data.formId',$questionInner['questionFormId'])
							->orderBy('data.orderIndex','ASC')
							->pluck('data');
					$questionsOfExcel[] = 'formId';
					$questionIdOfExcel[] = $questionInner['questionFormId'];
					foreach ($pages as $page) {
						foreach ($questionObjects as $questionObject) {
							if ($page['objectId'] == $questionObject['pageId']) {
								$questionsOfExcel[] = $questionObject['title'];
								$questionIdOfExcel[] = $questionObject['objectId'];
							}
						}
					}
					$sheet->row(1,$questionsOfExcel);
					$sheet->row(2,$questionIdOfExcel);
				});
				if(!empty($questionInnerForms)) {
					$this->innerTemplateDumpData($questionObjects,$excel);
				}	
			}
		}	
	}

	public function genAnswerForms($limit) {
		$date = date('2016-n-d H:m:s');
		$dateNow = date('Y-n-d H:m:s');
		$formIdLv1 = '20180420043900-545891940380689-1758617';
		$formIdLv2 = '20180420044238-545892158295872-1326596';

		$data = DB::collection('answerForm')
						->where('data.deletedAt','')
						->where('data.formId',$formIdLv2)
						->where('data.adminLock', 'exists', false)
						->whereRaw([
							'data.isoCreatedAt' => ['$gte' => isoDateConvert(date('2017-07-01'))]
						]);
						#->limit($limit);
		
		$oilTeasLv2 = $data->pluck('data');
		#$oilTeasLv2ObjectId = $data->distinct('data.parentAnswerFormId')->get();

		if (!empty($oilTeasLv2)) {
			foreach ($oilTeasLv2 as $oilTeasLv2) {
				$addFieldAnswerForms = DB::collection('answerForm')
										->where('data.objectId',$oilTeasLv2['objectId'])
										->update([
											'data.adminLock' => true,
										],['upsert' => true]);
			}
		}

		$oilTeasLv1 = DB::collection('answerForm')
						->where('data.deletedAt','')
						#->whereIn('data.objectId',$oilTeasLv2ObjectId)
						->where('data.formId',$formIdLv1)
						->pluck('data');
		if (!empty($oilTeasLv1)) {
			foreach ($oilTeasLv1 as $oilTeaLv1) {
				$genObjectId = generateObjectId();
				$newAnswerForms = [
					"createdAt" => $date,
					"formId" => $formIdLv2,
					"objectType" => "answerForm",
					"answerPreview" => "รายการตรวจ : ณ วันที่ %t",
					"createdAtQuestionFormVersion" => 1,
					"updatedBy" => $oilTeaLv1['updatedBy'],
					"deletedAt" => "",
					"updatedAt" => $date,
					"objectId" => $genObjectId,
					"parentAnswerFormId" => $oilTeaLv1['objectId'],
					"answerFormValue" => 0,
					"createdBy" => $oilTeaLv1['createdBy'],
					"deletedBy" => "",
					"answerStart" => $dateNow,
					"answerEnd" => $dateNow,
					"isoCreatedAt" => isoDateConvert($date),
					"isoUpdatedAt" => isoDateConvert($date),
				];
				$newAnswers = [
					"choiceId" => "", 
					"answerFormIdValue" => $genObjectId, 
					"dateValue" => 0, 
					"deletedBy" => "", 
					"answerMasterListDetailId" => "", 
					"questionId" => "20180420050130-545893290063516-1424194", 
					"createdAt" => $date, 
					"orderIndex" => 0, 
					"objectType" => "answer", 
					"imagePath" => "", 
					"latitude" => null, 
					"thumbnailImagePath" => "", 
					"updatedBy" => $oilTeaLv1['updatedBy'], 
					"deletedAt" => "", 
					"updatedAt" => $date, 
					"objectId" => generateObjectId(), 
					"longtitude" => null, 
					"answerFormId" => $oilTeaLv1['objectId'], 
					"doubleValue" => 0, 
					"createdBy" => $oilTeaLv1['createdBy'], 
					"integerValue" => 0, 
					"stringValue" => "", 
					"isoCreatedAt" => isoDateConvert($date), 
					"isoUpdatedAt" => isoDateConvert($date)
				];
				$insertNewAnswerForms = DB::collection('answerForm')->insert([array('data'=>$newAnswerForms)]);
				$insertNewAnswers = DB::collection('answer')->insert([array('data'=>$newAnswers)]);
			}
		}
	}

	public function clearDataOilteaV2() {
		$dateNow = date('Y-n-d H:m:s');
		$isoDateNow = isoDateConvert($dateNow);

		$masterFormID = '20180420042816-5458912969862-1630781';
		$formIdLv1 = '20180420043900-545891940380689-1758617';
		$formIdLv2 = '20180420044238-545892158295872-1326596';
		$dataAnswerForms = DB::collection('answerForm')
							->timeout(-1)
							->where('data.formId',$masterFormID)
							->orWhere('data.formId',$formIdLv1)
							->orWhere('data.formId',$formIdLv2)
							->where('data.deletedAt','')
							->whereRaw([
								'data.isoCreatedAt' => ['$gte' => isoDateConvert(date('2018-06-11'))]
							]);
		$answerForms = $dataAnswerForms->get();
		$answerFormsObjectId = $dataAnswerForms->pluck('data.objectId');
		if (!empty($answerForms)) {
			for ($i=0;$i<count($answerForms);$i++) {
				DB::collection('answerForm')
						->where('data.objectId', $answerForms[$i]['data']['objectId'])
						->update([
							'data.updatedAt' => $dateNow,
							'data.deletedAt' => $dateNow,
							'data.deletedBy' => $answerForms[$i]['data']['updatedBy'],
							'data.isoUpdatedAt' => $isoDateNow
						],['upsert' => true]);
			}
		}

		$answers = DB::collection('answer')
						->timeout(-1)
						->whereIn('data.answerFormId',$answerFormsObjectId)
						->where('data.deletedAt','')
						->whereRaw([
							'data.isoCreatedAt' => ['$gte' => isoDateConvert(date('2018-06-11'))]
						])->get();

		if (!empty($answers)) {
			for ($i=0;$i<count($answers);$i++) {
				DB::collection('answer')
								->where('data.objectId', $answers[$i]['data']['objectId'])
								->update([
									'data.updatedAt' => $dateNow,
									'data.deletedAt' => $dateNow,
									'data.deletedBy' => $answers[$i]['data']['updatedBy'],
									'data.isoUpdatedAt' => $isoDateNow
								],['upsert' => true]);
			}
		}

		if (!empty($answerFormsObjectId)) {
			foreach ($answerFormsObjectId as $answerFormObjectId) {
				$insertCheckFlat[]['data'] = [
					'objectId' => $answerFormObjectId,
					'status' => 'delete'
				];
			}
			DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);
		}

		return "<b>finish !</b>";
	}

	public function orderIndex() {
		$MASTER_OILTEA = '20180420042816-5458912969862-1630781';
	  
		$OWNER_PREFIX = '20180420042943-545891383981358-1006592';
		$OWNER_FIRSTNAME = '20180420043018-545891418928817-1755141';
		$OWNER_LASTNAME = '20180420043035-545891435376014-1825115';
		$VILLAGE_NAME = '20180420043213-545891533602968-1450070';
		$PLANT_NUMBER = '20180420043459-545891699115738-1658770';
		$QUESTION_INNER = '20180420050224-545893344686709-1048117';
		$TREE_NUMBER = '20180420043952-545891992032667-1260127';
	  
		$answerForms = [
			
		];

		#$answerForms = DB::collection('answerForm')->where('data.deletedAt','')->whereIn('data.objectId',$objectId)->pluck('data.objectId');
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		if (!empty($answerForms)) {
			foreach ($answerForms as $answerForm) {
				$answerFormsLv1 = DB::collection('flatData')->where('parentAnswerFormId',$answerForm)->orderBy($TREE_NUMBER,'ASC')->pluck('objectId');
				if (!empty($answerFormsLv1)) {
					for ($i=0;$i<count($answerFormsLv1);$i++) {
						$answers = DB::collection('answer')
									->where('data.deletedAt','')
									->where('data.answerFormId',$answerForm)
									->where('data.answerFormIdValue',$answerFormsLv1[$i])
									->update([
										'data.orderIndex' => $i,
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
									]);
					}
				
					DB::collection('answerForm')
									->where('data.objectId',$answerForm)
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
									]);;
					}
			}

			return "<b>Success !</b>";
		} else {
			return "<b>ไม่มีแปลง</b>";
		}
	}

	public function clearAnswerTree() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$answerFormId = [
			'20180430150435-256212888138445-8243688',
			'20180430150435-131755159976719-7182005',
			'20180430150435-421479014349857-9154132',
		];

		$TREE_NUMBER = '20180420043952-545891992032667-1260127';
		$answerForms = DB::collection('answerForm')
					->where('data.deletedAt','')
					->whereIn('data.objectId',$answerFormId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
					]);

		$answers = DB::collection('answer')
					->where('data.deletedAt','')
					->whereIn('data.answerFormId',$answerFormId)
					->where('data.questionId',$TREE_NUMBER)
					->whereRaw([
						'data.isoCreatedAt' => ['$gte' => isoDateConvert(date('2018-06-26')) ,'$lt' => isoDateConvert(date('2018-06-27'))],
					])
					->update([
						'data.deletedAt' => $datenow,
						'data.deletedBy' => '59bb86743fd89d8f2a5aaaf9',
						'data.updatedBy' => '59bb86743fd89d8f2a5aaaf9',
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
					]);
		
		if ($answerForms > 0 && $answers > 0) {
			foreach ($answerFormId as $answerFormIds) {
				$data[]['data'] = [
					'objectId' => $answerFormIds,
					'status' => 'update'
				];
			}
			$insert = DB::collection('checkFlatData')->insert($data,['upsert'=>true]);
			if ($insert) {
				echo "success";
			}
		} else {
			echo "ไม่มีAnswerFormและAnswerให้อัพเดท";
		}
	}

	public function transferUser() {
		$objectId = [
			#'20180430150406-783702957593649-0309457', #ph254
			'20180430150415-647683186466587-3184193', #ph250
			#'20180430150444-183510526464026-1832312', #ph238
			#'20180430140410-767291641123494-3045139', #ph230
		];
		$userId = '59a77d443fd89d7c1df9a801';
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);

		$answerForms = DB::collection('answerForm')
						->where('data.deletedAt','')
						->whereIn('data.objectId',$objectId)
						->get();
		if (!empty($answerForms)) {
			for ($i=0;$i<count($answerForms);$i++) {
				$answerForms[$i]['data']['createdBy'] = $userId;
				$answerForms[$i]['data']['updatedAt'] = $datenow;
				$answerForms[$i]['data']['isoUpdatedAt'] = $isoDatenow;
				DB::collection('answerForm')
								->where('data.objectId',$answerForms[$i]['data']['objectId'])
								->update($answerForms[$i],['upsert'=>true]);

				$answerFormsLv1 = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.parentAnswerFormId',$answerForms[$i]['data']['objectId']);
				$answerFormsLv1Update = $answerFormsLv1->update([
									'data.createdBy' => $userId,
									'data.updatedAt' => $datenow,
									'data.isoUpdatedAt' => $isoDatenow,
								]);
				$answerFormsLv1Distinct = $answerFormsLv1->distinct('data.objectId')->get();


				$answerFormsLv2 = DB::collection('answerForm')
								->where('data.deletedAt','')
								->whereIn('data.parentAnswerFormId',$answerFormsLv1Distinct);

				$answerFormsLv2Update = $answerFormsLv2->update([
									'data.createdBy' => $userId,
									'data.updatedAt' => $datenow,
									'data.isoUpdatedAt' => $isoDatenow,
								]);


			}
		}
	}

	public function clearAnswerFormIdValue() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$PLANT_NUMBER = '20180420043459-545891699115738-1658770';

		$objectId = [
			'20180430130429-094341619638506-5695889', #ph013
			'20180430180443-092949374272492-1385655' #pn118
		];

		$answerForms = DB::collection('answerForm')
						->where('data.deletedAt','')
						->whereIn('data.parentAnswerFormId',$objectId)
						->pluck('data.objectId');
		if (!empty($answerForms)) {
			$answers = DB::collection('answer')
							->timeout(-1)
							->where('data.deletedAt','')
							->where('data.questionId','20180420050130-545893290063516-1424194')
							->whereIn('data.answerFormId',$answerForms)
							->pluck('data.answerFormIdValue');
			if (!empty($answers)) {
				$notAnswerForms = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId','20180420044238-545892158295872-1326596')
								->whereIn('data.parentAnswerFormId',$answerForms)
								->whereNotIn('data.objectId',$answers)
								->get();
				if (!empty($notAnswerForms)) {
					for ($i=0;$i<count($notAnswerForms);$i++) {
						$notAnswerForms[$i]['data']['updatedAt'] = $datenow;
						$notAnswerForms[$i]['data']['isoUpdatedAt'] = $isoDatenow;
						$notAnswerForms[$i]['data']['deletedAt'] = $datenow;
						$notAnswerForms[$i]['data']['deletedBy'] = $notAnswerForms[$i]['data']['updatedBy'];

						DB::collection('answerForm')
									->where('data.objectId',$notAnswerForms[$i]['data']['objectId'])
									->update($notAnswerForms[$i],['upsert'=>true]);

						$data[] = $notAnswerForms[$i]['data']['objectId'];
					}
					if (!empty($data)) {
						DB::collection('flatData')->whereIn('objectId',$data)->delete();
					}
					return "success ".count($notAnswerForms)." answerForm";
				} else {
					return 'ไม่มี AnswerFormIdValue ที่ลิ้งไม่ได้';
				}
			}
		} else {
			return 'ไม่มีข้อมูลเลขต้นของ objectId นี้';
		}
	}

	public function moveAnswerFormMacca() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		
		$TREE_NUMBER = '20180316002949-542852989581274-1195308';
		#Ans form “|พื้นที่ : สันโค้ง| Zone No.4 |”Created at “02 กรกฏาคม เวลา 10:27”
		$objectId02 = '20180702032730-552194850986209-1464189';
		#Ans Form “|พื้นที่ : สันโค้ง| Zone No.4 |”Created at - “19 กรกฏาคม เวลา 11:06”
		$objectId19 = '20180719040649-553666009725914-1237331';
		#“|พื้นที่ : สันโค้ง| Zone No.1 |” Created at “21 มิถุนายน เวลา 16:32”
		$objectIdZone1 = '20180621093252-551266372737381-1510320';
		$insertCheckFlat = [];
		$treeObjectId02 = [];
		$m = 0;
		for ($i=1;$i<=407;$i++) {
			$objectId = DB::collection('flatData')
								->where('parentAnswerFormId',$objectId02)
								->where($TREE_NUMBER, sprintf("%03d", $i))
								->get();
			if (!empty($objectId)) {
				foreach ($objectId as $objectIds) {
					$treeObjectId02[$m] = $objectIds['objectId'];
					$insertCheckFlat[$m]['data'] = [
						'objectId' => $objectIds['objectId'],
						'status' => 'update'
					];
					$m++;
				}
			}
		}

		if (!empty($treeObjectId02)) {
			$answerForms02 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->whereIn('data.objectId',$treeObjectId02)
							->update([
								'data.parentAnswerFormId' => $objectId19,
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);

			$answers02 = DB::collection('answer')
							->where('data.deletedAt','')
							->whereIn('data.answerFormIdValue',$treeObjectId02)
							->update([
								'data.answerFormId' => $objectId19,
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);	
			
			$answerForms19 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->where('data.objectId',$objectId19)
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);	

			$insertCheckFlat[]['data'] = [
				'objectId' => $objectId19,
				'status' => 'update'
			];

			DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);				
		}

		$insertCheckFlat = [];
		$treeObjectIdZone1 = [];
		$userId = '5adc85e03fd89dbc13c43818';

		$objectId = DB::collection('flatData')
							->where('parentAnswerFormId',$objectIdZone1)
							->pluck('objectId');
		$answerFormsZone1 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->where('data.objectId',$objectIdZone1)
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow,
							]);
		if (!empty($objectId)) {
			foreach ($objectId as $objectIds) { 
				$treeObjectIdZone1[] = $objectIds;
				$insertCheckFlat[]['data'] = [
					'objectId' => $objectIds,
					'status' => 'update'
				];
			}
		}

		if (!empty($treeObjectIdZone1)) {
			$answerForms02 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->whereIn('data.objectId',$treeObjectIdZone1)
							->update([
								'data.parentAnswerFormId' => $objectId02,
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow,
								'data.createdBy' => $userId,

							]);
			$answerForms02 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->whereIn('data.parentAnswerFormId',$treeObjectIdZone1)
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow,
								'data.createdBy' => $userId,
							]);

			$answers02 = DB::collection('answer')
							->where('data.deletedAt','')
							->whereIn('data.answerFormIdValue',$treeObjectIdZone1)
							->update([
								'data.answerFormId' => $objectId02,
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);	
			
			$answerForms19 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->where('data.objectId',$objectId02)
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);	

			$insertCheckFlat[]['data'] = [
				'objectId' => $objectId02,
				'status' => 'update'
			];

			DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);				
		}
	}

	public function moveAnswerFormMaccaNawutti() {
		$NAWUT_SITE = '20180314031543-542690143426476-1905201';
        $NAWUT_SITE1 = '20180404023329-544502009467115-1067742';
		$NAWUT_ZONE1_SITE1 = '20180404022543-544501543575448-1344883';
		$objectId1222 = '20180427065938-546505178175091-1950126'; #1/2/2.2
		$objectId1223 = '20180503050826-54701690699631-1012935'; #1/2/2.3
		$dateQuery = date('2018-05-03');
		$isoDateQuery = isoDateConvert($dateQuery);
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$insertCheckFlat = [];
		$objectIds = DB::collection('answerForm')
					->where('data.parentAnswerFormId',$objectId1222) 
					->whereRaw([
						'data.isoCreatedAt' => ['$gte' => $isoDateQuery]
					])->pluck('data.objectId');

		DB::collection('answerForm')
			->where('data.parentAnswerFormId',$objectId1222) 
			->where('data.deletedAt','')
			->whereRaw([
				'data.isoCreatedAt' => ['$gte' => $isoDateQuery]
			])->update([
				'data.parentAnswerFormId' => $objectId1223, 
				'data.updatedAt' => $datenow,
				'data.isoUpdatedAt' => $isoDatenow
			]);

		DB::collection('answer')
			->where('data.deletedAt','')
			->whereIn('data.answerFormIdValue',$objectIds)
			->update([
				'data.answerFormId' => $objectId1223,
				'data.updatedAt' => $datenow,
				'data.isoUpdatedAt' => $isoDatenow
			]);	

		DB::collection('answerForm')
			->where('data.objectId',$objectId1222) 
			->where('data.deletedAt','')
			->update([
				'data.updatedAt' => $datenow,
				'data.isoUpdatedAt' => $isoDatenow
			]);

		DB::collection('answerForm')
			->where('data.objectId',$objectId1223) 
			->where('data.deletedAt','')
			->update([
				'data.updatedAt' => $datenow,
				'data.isoUpdatedAt' => $isoDatenow
			]);

		for ($i=0;$i<count($objectIds);$i++) {
			$insertCheckFlat[$i]['data'] = [
				'objectId' => $objectIds[$i],
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}
		$insertCheckFlat[]['data'] = [
			'objectId' => $objectId1222,
			"objectType" => "answerForm",
			'status' => 'update'
		];
		$insertCheckFlat[]['data'] = [
			'objectId' => $objectId1223,
			"objectType" => "answerForm",
			'status' => 'update'
		];

		DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);

		echo "success";
	}

	public function deletedAnswerFormResearchOiltea() {
		$MASTER_FORMID = '20180317152059-542992859831745-1941555';
		$DETAILTREE_FORMID = '20180318002744-543025664027179-1857128';
		$RESULTTREE_FORMID = '20180317144912-54299095270044-1653996';
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$answerForms1 = DB::collection('answerForm')
						#->where('data.deletedAt','')
						->where('data.formId',$MASTER_FORMID);
		$answerForms1ObjectId = $answerForms1->pluck('data.objectId');
		$answerForms1Update = $answerForms1->delete();			

		$answers1 = DB::collection('answer')
					#->where('data.deletedAt','')
					->whereIn('data.answerFormId',$answerForms1ObjectId)
					->delete();

		DB::collection('flatData')->whereIn('objectId',$answerForms1ObjectId)->delete();

		$answerForms2 = DB::collection('answerForm')
						#->where('data.deletedAt','')
						->where('data.formId',$DETAILTREE_FORMID);
		$answerForms2ObjectId = $answerForms2->pluck('data.objectId');
		$answerForms2Update = $answerForms2->delete();		
		
		$answers2 = DB::collection('answer')
					#->where('data.deletedAt','')
					->whereIn('data.answerFormId',$answerForms2ObjectId)
					->delete();

		DB::collection('flatData')->whereIn('objectId',$answerForms2ObjectId)->delete();

		$answerForms3 = DB::collection('answerForm')
						#->where('data.deletedAt','')
						->where('data.formId',$RESULTTREE_FORMID);
		$answerForms3ObjectId = $answerForms3->pluck('data.objectId');				
		$answerForms3Update = $answerForms3->delete();		

		$answers3 = DB::collection('answer')
				#->where('data.deletedAt','')
				->whereIn('data.answerFormId',$answerForms3ObjectId)
				->delete();

		DB::collection('flatData')->whereIn('objectId',$answerForms3ObjectId)->delete();

	}

	public function clearMarkDeletedOilteaV2() {
		$masterObjectId = '20180430160403-015967450570183-1097376';
		$objectId = [
			'20180430160446-390175400416211-0280365',
			'20180608170602-084242457419791-2045079',
			'20180430160404-050358042644505-0580429'
		];

		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$checkFlatData = [];
		$answerForms = DB::collection('answerForm')
							->where('data.objectId',$masterObjectId)
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);
		
		$innerAnswerForms = DB::collection('answerForm')
						->whereIn('data.objectId',$objectId)
						->update([
							'data.deletedAt' => '',
							'data.deletedBy' => '',
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow
						]);
						
		$answers = DB::collection('answer')
						->whereIn('data.answerFormId',$objectId)
						->update([
							'data.deletedAt' => '',
							'data.deletedBy' => '',
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow
						]);	

		$answerFormIdValue = DB::collection('answer')
							->whereIn('data.answerFormIdValue',$objectId)
							->update([
								'data.deletedAt' => '',
								'data.deletedBy' => '',
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);
		
		foreach ($objectId as $objectIds) {
			$insertCheckFlat[]['data'] = [
				'objectId' => $objectIds,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}
			$insertCheckFlat[]['data'] = [
				'objectId' => $masterObjectId,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);

		echo "Success";
	}

	public function deletedPlantAnswerForm() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$userId = '59bb73483fd89d1c1e5aaae5';
		$objectId = [
			'20180531022003-549426003906002-1090671', #พื้นที่ 6/2/2.8
			'20180612053938-550474778339256-1764811', #้พื้นที่ 3
			'20180501071254-546851574932641-1729358'  #พื้นที่ 1/1/1.5
		];
		$markDeleted = [
			'data.deletedAt' => $datenow,
			'data.deletedBy' => $userId,
			#'data.deletedAt' => '',
			#'data.deletedBy' => '',
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow
		];
		$insertCheckFlat = [];
		$answerForms = DB::collection('answerForm')
						->whereIn('data.objectId',$objectId)
						->update($markDeleted);
		$answers = DB::collection('answer')
					->whereIn('data.answerFormId',$objectId)
					->update($markDeleted);

		$answerFormsLv1 = DB::collection('answerForm')
					->whereIn('data.parentAnswerFormId',$objectId);
		$answerFormsLv1ObjectId = $answerFormsLv1->pluck('data.objectId');
		$answerFormsLv1Update = $answerFormsLv1->update($markDeleted);
		$answersLv1 = DB::collection('answer')
					->whereIn('data.answerFormId',$answerFormsLv1ObjectId)
					->update($markDeleted);
		
		$answerFormsLv2 = DB::collection('answerForm')
					->whereIn('data.parentAnswerFormId',$answerFormsLv1ObjectId);
		$answerFormsLv2ObjectId = $answerFormsLv2->pluck('data.objectId');
		$answerFormsLv2Update = $answerFormsLv2->update($markDeleted);
		$answersLv2 = DB::collection('answer')
						->whereIn('data.answerFormId',$answerFormsLv2ObjectId)
						->update($markDeleted);
						
						
						
		foreach ($objectId as $objectIds) {
			$insertCheckFlat[]['data'] = [
				'objectId' => $objectIds,
				"objectType" => "answerForm",
				'status' => 'delete'
			];
		}
		foreach ($answerFormsLv1ObjectId as $answerFormLv1ObjectId) {
			$insertCheckFlat[]['data'] = [
				'objectId' => $answerFormLv1ObjectId,
				"objectType" => "answerForm",
				'status' => 'delete'
			];
		}
		foreach ($answerFormsLv2ObjectId as $answerFormLv2ObjectId) {
			$insertCheckFlat[]['data'] = [
				'objectId' => $answerFormLv2ObjectId,
				"objectType" => "answerForm",
				'status' => 'delete'
			];
		}

		DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);

		echo "Success";
	}

	public function insertTree() {
		
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$date2559 = date('2016-6-08 H:i:s');
		$isoDate2559 = isoDateConvert($date2559);

		$SETTINGS = [
			'ph159' => [
				'objectId' => '20180430140404-973146055791569-8617526', #2018-08-08
				'start' => 740,
				'end' => 740
			]
		];
		

		$MASTER_FORMID = '20180420042816-5458912969862-1630781';
		$INNER_TREE = '20180420050224-545893344686709-1048117';

		$LEVEL1_FORMID = '20180420043900-545891940380689-1758617';
		$TREE_NUMBER = '20180420043952-545891992032667-1260127';
		$INNER_DETAIL = '20180420050130-545893290063516-1424194';

		$LEVEL2_FORMID = '20180420044238-545892158295872-1326596';
		
		foreach ($SETTINGS as $setting) {
			$objectId = $setting['objectId'];
			$start = $setting['start'];
			$end = $setting['end'];
			$checkAnswerForms = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.objectId',$objectId)
								->first();
			$checkFlatData = [];
			$answers = [];
			$answerFormsLv1 = [];
			$answersLv1 = [];
			$innerAnswersLv1 = [];
			$answerFormsLv2 = [];
			$checkFlatData = [];

			if (!empty($checkAnswerForms)) {
				$userId = $checkAnswerForms['data']['createdBy'];
				for ($i=$start;$i<=$end;$i++) {
					$treeObjectId = generateObjectId();
					$checkFlatData[]['data'] = [
						'objectId' => $treeObjectId,
						"objectType" => "answerForm",
						'status' => 'insert'	
					];
					$answers[$i]['data'] = [
						"choiceId" => "", 
						"answerFormIdValue" => $treeObjectId, 
						"dateValue" => 0, 
						"deletedBy" => "", 
						"answerMasterListDetailId" => "", 
						"questionId" => $INNER_TREE, 
						"createdAt" => $datenow, 
						"orderIndex" => 0, 
						"objectType" => "answer", 
						"imagePath" => "", 
						"latitude" => null, 
						"thumbnailImagePath" => "", 
						"updatedBy" => $userId, 
						"deletedAt" => "", 
						"updatedAt" => $datenow, 
						"objectId" => generateObjectId(), 
						"longtitude" => null, 
						"answerFormId" => $objectId, 
						"doubleValue" => 0, 
						"createdBy" => $userId, 
						"integerValue" => 0, 
						"stringValue" => "", 
						"isoCreatedAt" => $isoDatenow, 
						"isoUpdatedAt" => $isoDatenow
					];

					$numberTree = sprintf("%'.04d", $i);
					$answerFormsLv1[$i]['data'] = [
						"createdAt" => $datenow, 
						"formId" => $LEVEL1_FORMID, 
						"objectType" => "answerForm", 
						"answerPreview" => "เลขที่ต้นชาน้ำมัน : $numberTree", 
						"createdAtQuestionFormVersion" => 1, 
						"updatedBy" => $userId, 
						"deletedAt" => "", 
						"updatedAt" => $datenow, 
						"objectId" => $treeObjectId, 
						"answerEnd" => $datenow, 
						"parentAnswerFormId" => $objectId, 
						"answerFormValue" => 0, 
						"answerStart" => $datenow, 
						"createdBy" => $userId, 
						"deletedBy" => "", 
						"isoCreatedAt" => $isoDatenow, 
						"isoUpdatedAt" => $isoDatenow
					];
					$answersLv1[$i]['data'] = [
						"choiceId" => "", 
						"answerFormIdValue" => "", 
						"dateValue" => 0, 
						"deletedBy" => "", 
						"answerMasterListDetailId" => "", 
						"questionId" => $TREE_NUMBER, 
						"createdAt" => $datenow, 
						"orderIndex" => 0, 
						"objectType" => "answer", 
						"imagePath" => "", 
						"latitude" => null, 
						"thumbnailImagePath" => "", 
						"updatedBy" => $userId, 
						"deletedAt" => "", 
						"updatedAt" => $datenow, 
						"objectId" => generateObjectId(), 
						"longtitude" => null, 
						"answerFormId" => $treeObjectId, 
						"doubleValue" => 0, 
						"createdBy" => $userId, 
						"integerValue" => 0, 
						"stringValue" => $numberTree, 
						"isoCreatedAt" => $isoDatenow, 
						"isoUpdatedAt" => $isoDatenow
					];

					$objectId2559 = generateObjectId();
					$innerAnswersLv1[$i]['data'] = [
						"choiceId" => "", 
						"answerFormIdValue" => $objectId2559, 
						"dateValue" => 0, 
						"deletedBy" => "", 
						"answerMasterListDetailId" => "", 
						"questionId" => $INNER_DETAIL, 
						"createdAt" => $date2559, 
						"orderIndex" => 0, 
						"objectType" => "answer", 
						"imagePath" => "", 
						"latitude" => null, 
						"thumbnailImagePath" => "", 
						"updatedBy" => $userId, 
						"deletedAt" => "", 
						"updatedAt" => $date2559, 
						"objectId" => generateObjectId(), 
						"longtitude" => null, 
						"answerFormId" => $treeObjectId,
						"doubleValue" => 0, 
						"createdBy" => $userId, 
						"integerValue" => 0, 
						"stringValue" => "", 
						"isoCreatedAt" => $isoDate2559, 
						"isoUpdatedAt" => $isoDate2559
					];
					
					$answerFormsLv2[$i]['data'] = [
						"createdAt" => $date2559, 
						"formId" => $LEVEL2_FORMID, 
						"objectType" => "answerForm", 
						"answerPreview" => "รายการตรวจ : ณ วันที่ %t", 
						"createdAtQuestionFormVersion" => 1, 
						"updatedBy" => $userId, 
						"deletedAt" => "", 
						"updatedAt" => $date2559, 
						"objectId" => $objectId2559, 
						"answerEnd" => $date2559, 
						"parentAnswerFormId" => $treeObjectId, 
						"answerFormValue" => 0, 
						"answerStart" => $date2559, 
						"createdBy" => $userId, 
						"deletedBy" => "", 
						"isoCreatedAt" => $isoDate2559, 
						"isoUpdatedAt" => $isoDate2559
					];
				}
			
				DB::collection('answerForm')
							->where('data.objectId',$objectId)
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);
				$checkFlatData[]['data'] = [
					'objectId' => $objectId,
					"objectType" => "answerForm",
					'status' => 'update'	
				];
				
				DB::collection('answer')->insert($answers, ['upsert' => true]);
				DB::collection('answerForm')->insert($answerFormsLv1, ['upsert' => true]);
				
				DB::collection('answer')->insert($answersLv1, ['upsert' => true]);
				
				DB::collection('answer')->insert($innerAnswersLv1, ['upsert' => true]);
				
				DB::collection('answerForm')->insert($answerFormsLv2, ['upsert' => true]);
				
				DB::collection('checkFlatData')->insert($checkFlatData, ['upsert' => true]);
			}
		}
		
		echo "success";
	}

	public function deletedTreeDup() {
		$dateQuery = isoDateConvert(date('2018-08-20 00:00:00'));
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$userId = \Auth::user()->_id;
		$TREE_NUMBER = '20180420043952-545891992032667-1260127';
		$SETTINGS = [
			/*'pn334' => [
				'objectId' => '20180430220414-638428783207585-1286463',
				'start' => '0782',
				'end' => '1010'
			],
			'pn335' => [
				'objectId' => '20180430210448-633251159045206-1526448',
				'start' => '0678',
				'end' => '1000'
			],
			'pn346' => [
				'objectId' => '20180430220412-172660615882303-0258089',
				'start' => '0865',
				'end' => '1127'
			],
			'pn330' => [
				'objectId' => '20180430220429-661084757506444-0590574',
				'start' => '1083',
				'end' => '1126'
			],
			'pn337' => [
				'objectId' => '20180430210434-844697251786913-7596948',
				'start' => '0281',
				'end' => '0900'
			],
			'pn352' => [
				'objectId' => '20180430220407-156635033292755-1681045',
				'start' => '1202',
				'end' => '1290'
			],
			'pn338' => [
				'objectId' => '20180430220425-977530553454020-9641009',
				'start' => '0839',
				'end' => '1107'
			],
			'pn343' => [
				'objectId' => '20180430220447-940275923390446-5458979',
				'start' => '0999',
				'end' => '1021'
			],
			'pn333' => [
				'objectId' => '20180430220437-468488454843098-8354684',
				'start' => '0690',
				'end' => '1075'
			],*/
			'pn345' => [
				'objectId' => '20180430220419-974355643774072-1426119',
				'start' => '0501',
				'end' => '1027'
			],
		];

		$markDeleted = [
			'data.deletedAt' => $datenow,
			'data.deletedBy' => $userId,
			#'data.deletedAt' => '',
			#'data.deletedBy' => '',
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow
		];
		$insertCheckFlat = [];
		foreach ($SETTINGS as $key => $setting) {
			$objectId = DB::collection('flatData')->where('parentAnswerFormId',$setting['objectId'])
					#->where('isoCreatedAt','<',$dateQuery)
					->whereBetween($TREE_NUMBER,[$setting['start'],$setting['end']])
					->pluck('objectId');
			/*if (empty($objectId)) {
				$objectId = DB::collection('flatData')->where('parentAnswerFormId',$setting['objectId'])
							->where('answerPreview',"")
							->pluck('objectId');
			}
			if (empty($objectId)) {
				$objectId = DB::collection('flatData')->where('parentAnswerFormId',$setting['objectId'])
							->whereBetween($TREE_NUMBER,[$setting['start'],$setting['end']])
							->pluck('objectId');
			}*/
			if (!empty($objectId)) {
				$answerForms = DB::collection('answerForm')
								->where('data.deletedAt','')
								->whereIn('data.objectId',$objectId);
				$answerFormsObjectId = $answerForms->pluck('data.objectId');
				$answerFormsUpdate = $answerForms->update($markDeleted);
				$answers = DB::collection('answer')
							->where('data.deletedAt','')
							->whereIn('data.answerFormId',$objectId)
							->update($markDeleted);
				$answerFormIdValue = DB::collection('answer')
									->where('data.deletedAt','')
									->whereIn('data.answerFormIdValue',$objectId)
									->update($markDeleted);
				$answerFormsLv1 = DB::collection('answerForm')
							->where('data.deletedAt','')
							->whereIn('data.parentAnswerFormId',$objectId);
				$answerFormsLv1ObjectId = $answerFormsLv1->pluck('data.objectId');
				$answerFormsLv1Update = $answerFormsLv1->update($markDeleted);
				$answersLv1 = DB::collection('answer')
							->where('data.deletedAt','')
							->whereIn('data.answerFormId',$answerFormsLv1ObjectId)
							->update($markDeleted);
				
				$answerForms = DB::collection('answerForm')
							->where('data.deletedAt','')
							->where('data.objectId',$setting['objectId'])
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);

				$insertCheckFlat[]['data'] = [
					'objectId' => $setting['objectId'],
					"objectType" => "answerForm",
					'status' => 'update'
				];	

				foreach ($answerFormsObjectId as $answerFormObjectId) {
					$insertCheckFlat[]['data'] = [
						'objectId' => $answerFormObjectId,
						"objectType" => "answerForm",
						'status' => 'delete'
					];
				}
				foreach ($answerFormsLv1ObjectId as $answerFormLv1ObjectId) {
					$insertCheckFlat[]['data'] = [
						'objectId' => $answerFormLv1ObjectId,
						"objectType" => "answerForm",
						'status' => 'delete'
					];
				}
			}
		}
		DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);

		echo "Success";
	}

	public function hardDeleteMainForm () {
		$MASTER_FORMID = '20180815074404-55601184433949-1329190';
		$dateStartQuery = isoDateConvert(date('2018-10-11 00:00:00'));
		$dateEndQuery = isoDateConvert(date('2018-10-12 23:59:59'));
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$answerForms1 = DB::collection('answerForm')
						->where('data.deletedAt','')
						->where('data.createdBy','59756d7e3fd89d9e62127c0d')
						/*->whereRaw([
                            'data.isoCreatedAt' => ['$gte' => $dateStartQuery, '$lt' => $dateEndQuery]
                        ])*/
						->where('data.formId',$MASTER_FORMID);

		$answerForms1ObjectId = $answerForms1->pluck('data.objectId');
		#$answerForms1Update = $answerForms1->delete();
		$answerForms1Update = $answerForms1->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow,
								'data.deletedAt' => $datenow,
								'data.deletedBy' => '59756d7e3fd89d9e62127c0d'
							]);
					

		$answers1 = DB::collection('answer')
					->where('data.deletedAt','')
					->whereIn('data.answerFormId',$answerForms1ObjectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => $datenow,
						'data.deletedBy' => '59756d7e3fd89d9e62127c0d'
					]);
					#->delete();

		DB::collection('flatData')->whereIn('objectId',$answerForms1ObjectId)->delete();
	}

	public function update () {
		$MASTER_FORMID = '20180815074404-55601184433949-1329190';
		$dateStartQuery = isoDateConvert(date('2018-10-17 00:00:00'));
		$dateEndQuery = isoDateConvert(date('2018-10-17 23:59:59'));
		$dateCreate = date('2018-10-10 07:00:00');
		$isoDateCreate = isoDateConvert($dateCreate);
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$answerForms1 = DB::collection('answerForm')
						->where('data.deletedAt','')
						->where('data.createdBy','5bc2c6f93fd89d9069f8d842')
						->whereRaw([
                            'data.isoCreatedAt' => ['$gte' => $dateStartQuery, '$lt' => $dateEndQuery]
                        ])
						->where('data.formId',$MASTER_FORMID);

		$answerForms1ObjectId = $answerForms1->pluck('data.objectId');
		$answerForms1Update = $answerForms1->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow,
								'data.createdAt' => $dateCreate,
								'data.isoCreatedAt' => $isoDateCreate
							]);
					

		$answers1 = DB::collection('answer')
					->where('data.deletedAt','')
					->whereIn('data.answerFormId',$answerForms1ObjectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.createdAt' => $dateCreate,
						'data.isoCreatedAt' => $isoDateCreate
					]);

		DB::collection('flatData')->whereIn('objectId',$answerForms1ObjectId)
								->update([
									'updatedAt' => $datenow,
									'isoUpdatedAt' => $isoDatenow,
									'createdAt' => $dateCreate,
									'isoCreatedAt' => $isoDateCreate
								]);
	}

	public function hardDeleteTruck () {
		$licensePlate = [
			'บท433ชร'
		];

		$truck = DB::collection('truck')
				->whereIn('licensePlate',$licensePlate);

		$truckId = $truck->pluck('objectId');
		$truckUpdate = $truck->delete();			

		$answers1 = DB::collection('transaction')
					->whereIn('truckId',$truckId)
					->delete();
	}

	public function updateTruck () {
		$dateStartQuery = isoDateConvert(date('2018-10-17 00:00:00'));
		$dateEndQuery = isoDateConvert(date('2018-10-17 23:59:59'));
		$dateCreate = date('2018-10-10 07:00:00');
		$isoDateCreate = isoDateConvert($dateCreate);
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);		

		$truck = DB::collection('truck')
						#->where('licensePlate','!=','บล3839')
						->whereRaw([
                            'isoCreatedAt' => ['$gte' => $dateStartQuery, '$lt' => $dateEndQuery]
                        ]);
	
		$truckId = $truck->pluck('objectId');
		$truckUpdate = $truck->update([
								'createdAt' => $dateCreate,
								'isoCreatedAt' => $isoDateCreate,
								'recevicedAt' => $dateCreate
							]);			

		$transactionUpdate = DB::collection('transaction')
							->whereIn('truckId',$truckId)
							->update([
								'createdAt' => $dateCreate,
								'isoCreatedAt' => $isoDateCreate,
								'purchaseDate' => $dateCreate
							]);	
	} 

	public function clearDeletedCoffee() {
		$dateStartQuery = isoDateConvert(date('2018-12-3 00:00:00'));
		$dateEndQuery = isoDateConvert(date('2018-12-4 23:59:59'));
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
							
		$answerForms = DB::collection('answerForm')
						->where('data.formId','20180815074404-55601184433949-1329190')
						->where('data.deletedAt','<>','')
						->whereRaw([
                            'data.isoCreatedAt' => ['$gte' => $dateStartQuery, '$lt' => $dateEndQuery]
						]);
		$answerFormsObjectId = $answerForms->pluck('data.objectId');
		$answerFormsUpdated = $answerForms->update([
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => '',
			'data.deletedBy' => ''
		]);

		$answers = DB::collection('answer')
					->whereIn('data.answerFormId',$answerFormsObjectId)
					#->get();
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => '',
						'data.deletedBy' => ''
					]);
		
		if (!empty($answerFormsObjectId)) {
			$insertCheckFlat = [];
			foreach ($answerFormsObjectId as $answerFormObjectId) {
				$insertCheckFlat[]['data'] = [
					'objectId' => $answerFormObjectId,
					"objectType" => "answerForm",
					'status' => 'insert'
				];
			}
			$insertCheckFlatData = DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);
			if ($insertCheckFlatData) {
				echo "success";
			}
		} else {
			echo "not have answerForms";
		}
	}

	public function clearMarkDeletedOiltea() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);

		$answerForms = DB::collection('answerForm')
						->where('data.objectId','20181203033730-56550105030795-1902592');

		$answerFormsObjectId = $answerForms->pluck('data.objectId');
		$answerFormsUpdate = $answerForms->update([
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => '',
			'data.deletedBy' => ''
		]);

		$answers = DB::collection('answer')
					->whereIn('data.answerFormId',$answerFormsObjectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => '',
						'data.deletedBy' => ''
					]);


		$innerAnswerForms = DB::collection('answerForm')
							->whereIn('data.parentAnswerFormId',$answerFormsObjectId);

		$innerAnswerFormsObjectId = $innerAnswerForms->pluck('data.objectId');
		$innerAnswerFormsUpdate = $innerAnswerForms->update([
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => '',
			'data.deletedBy' => ''
		]);

		$innerAnswers = DB::collection('answer')
					->whereIn('data.answerFormId',$innerAnswerFormsObjectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => '',
						'data.deletedBy' => ''
					]);

		$insertCheckFlat = [];

		if (!empty($answerFormsObjectId)) {
			foreach ($answerFormsObjectId as $answerFormObjectId) {
				$insertCheckFlat[]['data'] = [
					'objectId' => $answerFormObjectId,
					"objectType" => "answerForm",
					'status' => 'insert'
				];
			}
		}

		if (!empty($innerAnswerFormsObjectId)) {
			foreach ($innerAnswerFormsObjectId as $innerAnswerFormObjectId) {
				$insertCheckFlat[]['data'] = [
					'objectId' => $innerAnswerFormObjectId,
					"objectType" => "answerForm",
					'status' => 'insert'
				];
			}
		}
		
		DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);

		echo "success !";
	}
	
	public function dumpDataHuaisan () {
		#$dateNow = date('Y-n-d H:i:s');
		#$isoDateNow = isoDateConvert($dateNow);
		
		$MAIN_FORM_ID = '20171018011853-529982333425753-1281522';
		$VILLAGE_NAME_9 = '20171227091410-536058850007324-1248938';
		$VILLAGE_NAME_10 = '20180108065053-537087053740305-1394003';
		$VILLAGE_NAME_11 = '20180108065203-537087123424853-1460894';
		$VILLAGE_NAME_13 = '20180108065336-537087216001132-1338687';

		$answerForms = DB::collection('answerForm')
						#->where('data.objectId','20180204071626-539421386018034-1902741')
						->where('data.formId',$MAIN_FORM_ID)
						->where('data.deletedAt','')
						->project(['_id' => 0])
						#->limit(1)
						->get();
		if (!empty($answerForms)) {
			$answerFormsFlatData = [];
			for ($i=0;$i<count($answerForms);$i++) {
				$newObjectId = generateObjectId();
				$answers = DB::collection('answer')
								->where('data.answerFormId',$answerForms[$i]['data']['objectId'])
								->where('data.deletedAt','')
								->whereIn('data.questionId',
								[
									'20171227090843-536058523771856-1153138',
									'20171227091410-536058850007324-1248938',
									'20180108065053-537087053740305-1394003',
									'20180108065203-537087123424853-1460894',
									'20180108065336-537087216001132-1338687',
									'20171018012235-529982555211643-1456181',
									'20171227092039-536059239747812-1225418',
									'20171227092007-536059207588099-1989560',
									'20171227091939-536059179352616-1279542',	
									'20171018012023-529982423958244-1286303',						
									'20171018015800-529984680864742-1665374',
									'20171018050103-52999566357297-1001134',
								])
								->project(['_id' => 0])
								->get();
				$answerForms[$i]['data']['objectId'] = $newObjectId;
				#$createdAt = date('Y-n-d H:i:s');
				if (!empty($answers)) {
					for ($n=0;$n<count($answers);$n++) {
						if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_9) {
							if ($answers[$n]['data']['stringValue'] == "เมืองงามเหนือ") {
								$createdAt = date('2019-02-01 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "กอแอ") {
								$createdAt = date('2019-01-30 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "โป่งน้ำร้อน") {
								$createdAt = date('2019-01-31 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "ยะผ่า") {
								$createdAt = date('2019-02-09 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "หย่าเก๊อะ") {
								$createdAt = date('2019-02-09 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "สี่หลัง") {
								$createdAt = date('2019-02-08 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "อาเพียง") {
								$createdAt = date('2019-01-31 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							}
						} else if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_10) { 
							if ($answers[$n]['data']['stringValue'] == "ห้วยส้าน") {
								$createdAt = date('2019-01-23 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "ห้วยเต่า") {
								$createdAt = date('2019-01-25 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "ฮ้าฮก") {
								$createdAt = date('2019-01-21 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "บะหลา") {
								$createdAt = date('2019-01-29 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "หัวน้ำ") {
								$createdAt = date('2019-01-29 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							}
						} else if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_11) {
							if ($answers[$n]['data']['stringValue'] == "เล่าอัง") {
								$createdAt = date('2019-02-08 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} 
							/*else if ($answers[$n]['data']['stringValue'] == "หัวเมืองงาม") {
								$createdAt = date('2019-01-14 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							}*/
							else if ($answers[$n]['data']['stringValue'] == "สามหลัง") {
								$createdAt = date('2019-01-22 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "สุขฤทัย") {
								$createdAt = date('2019-01-28 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "สิงคโปร์") {
								$createdAt = date('2019-01-28 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "อาเทอ") {
								$createdAt = date('2019-02-06 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "ป่ากล้วย") {
								$createdAt = date('2019-02-11 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "แสนสุข") {
								$createdAt = date('2019-02-04 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "กลางนา") {
								$createdAt = date('2019-02-05 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "อาชู") {
								$createdAt = date('2019-02-06 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							}
						} else if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_13) { 
							if ($answers[$n]['data']['stringValue'] == "เมืองงามใต้") {
								$createdAt = date('2019-02-07 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "ห้วยป่าแขม") {
								$createdAt = date('2019-01-26 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							} else if ($answers[$n]['data']['stringValue'] == "สบงาม") {
								$createdAt = date('2019-01-25 01:00:00', strtotime($answerForms[$i]['data']['createdAt']));
							}
						}
					}

					$isoCreatedAt = isoDateConvert($createdAt);
					$answerForms[$i]['data']['createdAt'] = $createdAt;
					$answerForms[$i]['data']['updatedAt'] = $createdAt;
					$answerForms[$i]['data']['isoCreatedAt'] = $isoCreatedAt;
					$answerForms[$i]['data']['isoUpdatedAt'] = $isoCreatedAt;
					$answerForms[$i]['data']['answerStart'] = $createdAt;
					$answerForms[$i]['data']['answerEnd'] = $createdAt;
					for ($n=0;$n<count($answers);$n++) {
						$answers[$n]['data']['answerFormId'] = $newObjectId;
						$answers[$n]['data']['objectId'] = generateObjectId();
						$answers[$n]['data']['createdAt'] = $createdAt;
						$answers[$n]['data']['updatedAt'] = $createdAt;
						$answers[$n]['data']['isoCreatedAt'] = $isoCreatedAt;
						$answers[$n]['data']['isoUpdatedAt'] = $isoCreatedAt;

						if ($answers[$n]['data']['questionId'] == '20171018012235-529982555211643-1456181' ||
							$answers[$n]['data']['questionId'] == '20171227092039-536059239747812-1225418' ||
							$answers[$n]['data']['questionId'] == '20171227092007-536059207588099-1989560' ||
							$answers[$n]['data']['questionId'] == '20171227091939-536059179352616-1279542' ||
							$answers[$n]['data']['questionId'] == '20171018012023-529982423958244-1286303' ||
							$answers[$n]['data']['questionId'] == '20171227091410-536058850007324-1248938' ||
							$answers[$n]['data']['questionId'] == '20180108065053-537087053740305-1394003' ||
							$answers[$n]['data']['questionId'] == '20180108065203-537087123424853-1460894' ||
							$answers[$n]['data']['questionId'] == '20180108065336-537087216001132-1338687' ||
							$answers[$n]['data']['questionId'] == '20171227090843-536058523771856-1153138'
						) { 
							$answers[$n]['data']['adminLock'] = true;
						}

						if ($answers[$n]['data']['questionId'] == '20171018015800-529984680864742-1665374') { #1.
							$answerFormsInner = DB::collection('answerForm')
											->where('data.objectId',$answers[$n]['data']['answerFormIdValue'])
											->where('data.deletedAt','')
											->project(['_id' => 0])
											->get();
							if (!empty($answerFormsInner)) {
								$answerFormsInnerFlatData = [];
								$answers[$n]['data']['answerFormIdValue'] = generateObjectId();
								for ($m=0;$m<count($answerFormsInner);$m++) {
									$answerFormsInner[$m]['data']['parentAnswerFormId'] = $newObjectId;
									$answerFormsInner[$m]['data']['createdAt'] = $createdAt;
									$answerFormsInner[$m]['data']['updatedAt'] = $createdAt;
									$answerFormsInner[$m]['data']['isoCreatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['isoUpdatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['answerStart'] = $createdAt;
									$answerFormsInner[$m]['data']['answerEnd'] = $createdAt;

									$answersInner = DB::collection('answer')
													->where('data.deletedAt','')
													->where('data.answerFormId',$answerFormsInner[$m]['data']['objectId'])
													->whereIn('data.questionId',[
														'20171018013412-529983252169051-1245421',
														'20171018013913-529983553771016-1711143',
														'20171018014042-52998364274714-1939718',
														'20171018014304-529983784154603-1346302',
														'20171018014456-529983896854215-1406093',
														'20171018014719-529984039692584-1609407',
														'20171018014807-529984087874949-1012903',
														'20171018015015-529984215075921-1165469'														
													])
													->project(['_id' => 0])
													->get();
									if (!empty($answersInner)) {
										$answerFormsInner[$m]['data']['objectId'] = $answers[$n]['data']['answerFormIdValue'];
										for ($o=0;$o<count($answersInner);$o++) {
											$answersInner[$o]['data']['objectId'] = generateObjectId();
											$answersInner[$o]['data']['answerFormId'] = $answerFormsInner[$m]['data']['objectId'];
											$answersInner[$o]['data']['createdAt'] = $createdAt;
											$answersInner[$o]['data']['updatedAt'] = $createdAt;
											$answersInner[$o]['data']['isoCreatedAt'] = $isoCreatedAt;
											$answersInner[$o]['data']['isoUpdatedAt'] = $isoCreatedAt;

											if ($answersInner[$o]['data']['questionId'] == '20171018014807-529984087874949-1012903') {
												$answersInner[$o]['data']['doubleValue'] = $answersInner[$o]['data']['doubleValue'] + 1;
												$answersInner[$o]['data']['stringValue'] = strVal($answersInner[$o]['data']['doubleValue']);
												if ($answerFormsInner[$m]['data']['formId'] == '20171018013349-529983229201903-1958280') {
													$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
													$explode[1] = mb_substr($explode[1],0,27) . $answersInner[$o]['data']['doubleValue'] .". ";
													$implode = implode('|',$explode);
													$answerFormsInner[$m]['data']['answerPreview'] = $implode;
												} 
												
												/*else if ($answerFormsInner[$m]['data']['formId'] == '20180112080007-537436807047795-1673958') {
													$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
													$explode[0] = mb_substr($explode[0],0,25) . $answersInner[$o]['data']['doubleValue'] ."ปี. ";
													$implode = implode('|',$explode);
													$answerFormsInner[$m]['data']['answerPreview'] = $implode;
												} else if ($answerFormsInner[$m]['data']['formId'] == '20180111090516-537354316472906-1809823') {
													$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
													$explode[0] = mb_substr($explode[0],0,24) . $answersInner[$o]['data']['doubleValue'] .". ปี ";
													$implode = implode('|',$explode);
													$answerFormsInner[$m]['data']['answerPreview'] = $implode;
												}*/
											}
										}
										DB::collection('answer')->insert($answersInner, ['upsert' => true]);
									}
									$answerFormsInnerFlatData[]['data'] = [
										'objectId' => $answerFormsInner[$m]['data']['objectId'],
										"objectType" => "answerForm",
										'status' => 'insert'
									];
								}
								DB::collection('answerForm')->insert($answerFormsInner, ['upsert' => true]);
								DB::collection('checkFlatData')->insert($answerFormsInnerFlatData, ['upsert' => true]);
							}
						} if ($answers[$n]['data']['questionId'] == '20171018050103-52999566357297-1001134') { #2.
							$answerFormsInner = DB::collection('answerForm')
											->where('data.objectId',$answers[$n]['data']['answerFormIdValue'])
											->where('data.deletedAt','')
											->project(['_id' => 0])
											->get();
							if (!empty($answerFormsInner)) {
								$answerFormsInnerFlatData = [];
								$answers[$n]['data']['answerFormIdValue'] = generateObjectId();
								for ($m=0;$m<count($answerFormsInner);$m++) {
									$answerFormsInner[$m]['data']['parentAnswerFormId'] = $newObjectId;
									$answerFormsInner[$m]['data']['createdAt'] = $createdAt;
									$answerFormsInner[$m]['data']['updatedAt'] = $createdAt;
									$answerFormsInner[$m]['data']['isoCreatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['isoUpdatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['answerStart'] = $createdAt;
									$answerFormsInner[$m]['data']['answerEnd'] = $createdAt;

									$answersInner = DB::collection('answer')
													->where('data.deletedAt','')
													->where('data.answerFormId',$answerFormsInner[$m]['data']['objectId'])
													->whereIn('data.questionId',[
														'20180109065006-53717340634385-1581014',
														'20180121152641-53824120156103-1608361',
														'20180109065257-53717357774097-1107508',
														'20180109065339-537173619769491-1864850',
														'20180109065445-537173685024103-1118039',
														'20180109065548-537173748759386-1907307',
														'20180109065650-537173810430413-1300151'
													])
													->project(['_id' => 0])
													->get();
									if (!empty($answersInner)) {
										$answerFormsInner[$m]['data']['objectId'] = $answers[$n]['data']['answerFormIdValue'];
										$explodePreview = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
										if (!empty($explodePreview[3])) {
											unset($explodePreview[3]);
											if (!empty($explodePreview[4]) || $explodePreview[4] == '') {
												unset($explodePreview[4]);
											}

											$explodePreview = implode('|',$explodePreview) . "|";
											$answerFormsInner[$m]['data']['answerPreview'] = $explodePreview;
										}
										for ($o=0;$o<count($answersInner);$o++) {
											$answersInner[$o]['data']['objectId'] = generateObjectId();
											$answersInner[$o]['data']['answerFormId'] = $answerFormsInner[$m]['data']['objectId'];
											$answersInner[$o]['data']['createdAt'] = $createdAt;
											$answersInner[$o]['data']['updatedAt'] = $createdAt;
											$answersInner[$o]['data']['isoCreatedAt'] = $isoCreatedAt;
											$answersInner[$o]['data']['isoUpdatedAt'] = $isoCreatedAt;

											if ($answersInner[$o]['data']['questionId'] == '20180109065650-537173810430413-1300151') {
												$answersInner[$o]['data']['doubleValue'] = $answersInner[$o]['data']['doubleValue'] + 1;
												$answersInner[$o]['data']['stringValue'] = strVal($answersInner[$o]['data']['doubleValue']);
												/*if ($answerFormsInner[$m]['data']['formId'] == '20171018013349-529983229201903-1958280') {
													$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
													$explode[1] = mb_substr($explode[1],0,27) . $answersInner[$o]['data']['doubleValue'] .". ";
													$implode = implode('|',$explode);
													$answerFormsInner[$m]['data']['answerPreview'] = $implode;
												} 
												
												else if ($answerFormsInner[$m]['data']['formId'] == '20180112080007-537436807047795-1673958') {
													$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
													$explode[0] = mb_substr($explode[0],0,25) . $answersInner[$o]['data']['doubleValue'] ."ปี. ";
													$implode = implode('|',$explode);
													$answerFormsInner[$m]['data']['answerPreview'] = $implode;
												} else if ($answerFormsInner[$m]['data']['formId'] == '20180111090516-537354316472906-1809823') {
													$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
													$explode[0] = mb_substr($explode[0],0,24) . $answersInner[$o]['data']['doubleValue'] .". ปี ";
													$implode = implode('|',$explode);
													$answerFormsInner[$m]['data']['answerPreview'] = $implode;
												}*/
											} if ($answersInner[$o]['data']['questionId'] == '20180109065257-53717357774097-1107508') {
												if (strpos(mb_substr($answersInner[$o]['data']['stringValue'],0,3),"นาย") === 0) {
													$answersInner[$o]['data']['stringValue'] = mb_substr($answersInner[$o]['data']['stringValue'],3);
													$answersInner[]['data'] = [
														"choiceId" => "", 
														"answerFormIdValue" => "", 
														"dateValue" => 0, 
														"deletedBy" => "", 
														"answerMasterListDetailId" => "917540452885172164467833", 
														"questionId" => "20180121152641-53824120156103-1608361", 
														"createdAt" => $createdAt, 
														"orderIndex" => 0, 
														"objectType" => "answer", 
														"imagePath" => "", 
														"latitude" => null, 
														"thumbnailImagePath" => "", 
														"updatedBy" => $answersInner[$o]['data']['createdBy'], 
														"deletedAt" => "", 
														"updatedAt" => $createdAt, 
														"objectId" => generateObjectId(), 
														"longtitude" => null, 
														"answerFormId" => $answerFormsInner[$m]['data']['objectId'], 
														"doubleValue" => 0, 
														"createdBy" => $answersInner[$o]['data']['createdBy'], 
														"integerValue" => 0, 
														"stringValue" => "นาย", 
														"isoCreatedAt" => $isoCreatedAt, 
														"isoUpdatedAt" => $isoCreatedAt
													];
												}

												if (strpos(mb_substr($answersInner[$o]['data']['stringValue'],0,6),"นางสาว") === 0) {
													$answersInner[$o]['data']['stringValue'] = mb_substr($answersInner[$o]['data']['stringValue'],6);
													$answersInner[]['data'] = [
														"choiceId" => "", 
														"answerFormIdValue" => "", 
														"dateValue" => 0, 
														"deletedBy" => "", 
														"answerMasterListDetailId" => "067406183380505370596699", 
														"questionId" => "20180121152641-53824120156103-1608361", 
														"createdAt" => $createdAt, 
														"orderIndex" => 0, 
														"objectType" => "answer", 
														"imagePath" => "", 
														"latitude" => null, 
														"thumbnailImagePath" => "", 
														"updatedBy" => $answersInner[$o]['data']['createdBy'], 
														"deletedAt" => "", 
														"updatedAt" => $createdAt, 
														"objectId" => generateObjectId(), 
														"longtitude" => null, 
														"answerFormId" => $answerFormsInner[$m]['data']['objectId'], 
														"doubleValue" => 0, 
														"createdBy" => $answersInner[$o]['data']['createdBy'], 
														"integerValue" => 0, 
														"stringValue" => "นางสาว", 
														"isoCreatedAt" => $isoCreatedAt, 
														"isoUpdatedAt" => $isoCreatedAt
													];
												} else if (strpos(mb_substr($answersInner[$o]['data']['stringValue'],0,3),"นาง") === 0) {
													$answersInner[$o]['data']['stringValue'] = mb_substr($answersInner[$o]['data']['stringValue'],3);
													$answersInner[]['data'] = [
														"choiceId" => "", 
														"answerFormIdValue" => "", 
														"dateValue" => 0, 
														"deletedBy" => "", 
														"answerMasterListDetailId" => "677207114764226002274348", 
														"questionId" => "20180121152641-53824120156103-1608361", 
														"createdAt" => $createdAt, 
														"orderIndex" => 0, 
														"objectType" => "answer", 
														"imagePath" => "", 
														"latitude" => null, 
														"thumbnailImagePath" => "", 
														"updatedBy" => $answersInner[$o]['data']['createdBy'], 
														"deletedAt" => "", 
														"updatedAt" => $createdAt, 
														"objectId" => generateObjectId(), 
														"longtitude" => null, 
														"answerFormId" => $answerFormsInner[$m]['data']['objectId'], 
														"doubleValue" => 0, 
														"createdBy" => $answersInner[$o]['data']['createdBy'], 
														"integerValue" => 0, 
														"stringValue" => "นาง", 
														"isoCreatedAt" => $isoCreatedAt, 
														"isoUpdatedAt" => $isoCreatedAt
													];
												} else if (strpos(mb_substr($answersInner[$o]['data']['stringValue'],0,7),"เด็กชาย") === 0) {
													$answersInner[$o]['data']['stringValue'] = mb_substr($answersInner[$o]['data']['stringValue'],7);
													$answersInner[]['data'] = [
														"choiceId" => "", 
														"answerFormIdValue" => "", 
														"dateValue" => 0, 
														"deletedBy" => "", 
														"answerMasterListDetailId" => "105325796454012581059095", 
														"questionId" => "20180121152641-53824120156103-1608361", 
														"createdAt" => $createdAt, 
														"orderIndex" => 0, 
														"objectType" => "answer", 
														"imagePath" => "", 
														"latitude" => null, 
														"thumbnailImagePath" => "", 
														"updatedBy" => $answersInner[$o]['data']['createdBy'], 
														"deletedAt" => "", 
														"updatedAt" => $createdAt, 
														"objectId" => generateObjectId(), 
														"longtitude" => null, 
														"answerFormId" => $answerFormsInner[$m]['data']['objectId'], 
														"doubleValue" => 0, 
														"createdBy" => $answersInner[$o]['data']['createdBy'], 
														"integerValue" => 0, 
														"stringValue" => "เด็กชาย", 
														"isoCreatedAt" => $isoCreatedAt, 
														"isoUpdatedAt" => $isoCreatedAt
													];
												} else if (strpos(mb_substr($answersInner[$o]['data']['stringValue'],0,8),"เด็กหญิง") === 0) {
													$answersInner[$o]['data']['stringValue'] = mb_substr($answersInner[$o]['data']['stringValue'],8);
													$answersInner[]['data'] = [
														"choiceId" => "", 
														"answerFormIdValue" => "", 
														"dateValue" => 0, 
														"deletedBy" => "", 
														"answerMasterListDetailId" => "884450669993711933414687", 
														"questionId" => "20180121152641-53824120156103-1608361", 
														"createdAt" => $createdAt, 
														"orderIndex" => 0, 
														"objectType" => "answer", 
														"imagePath" => "", 
														"latitude" => null, 
														"thumbnailImagePath" => "", 
														"updatedBy" => $answersInner[$o]['data']['createdBy'], 
														"deletedAt" => "", 
														"updatedAt" => $createdAt, 
														"objectId" => generateObjectId(), 
														"longtitude" => null, 
														"answerFormId" => $answerFormsInner[$m]['data']['objectId'], 
														"doubleValue" => 0, 
														"createdBy" => $answersInner[$o]['data']['createdBy'], 
														"integerValue" => 0, 
														"stringValue" => "เด็กหญิง", 
														"isoCreatedAt" => $isoCreatedAt, 
														"isoUpdatedAt" => $isoCreatedAt
													];
												}
											}
										}
										DB::collection('answer')->insert($answersInner, ['upsert' => true]);
									}
									$answerFormsInnerFlatData[]['data'] = [
										'objectId' => $answerFormsInner[$m]['data']['objectId'],
										"objectType" => "answerForm",
										'status' => 'insert'
									];
								}
								DB::collection('answerForm')->insert($answerFormsInner, ['upsert' => true]);
								DB::collection('checkFlatData')->insert($answerFormsInnerFlatData, ['upsert' => true]);
							}
						}
						/*if ($answers[$n]['data']['questionId'] == '20171018151522-530032522811667-1796099') { #10.2
							$answerFormsInner = DB::collection('answerForm')
												->where('data.objectId',$answers[$n]['data']['answerFormIdValue'])
												->where('data.deletedAt','')
												->project(['_id' => 0])
												->get();
							if (!empty($answerFormsInner)) {
								$answerFormsInnerFlatData = [];
								$answers[$n]['data']['answerFormIdValue'] = generateObjectId();
								for ($m=0;$m<count($answerFormsInner);$m++) {
									$answerFormsInner[$m]['data']['parentAnswerFormId'] = $newObjectId;
									$answerFormsInner[$m]['data']['createdAt'] = $createdAt;
									$answerFormsInner[$m]['data']['updatedAt'] = $createdAt;
									$answerFormsInner[$m]['data']['isoCreatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['isoUpdatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['answerStart'] = $createdAt;
									$answerFormsInner[$m]['data']['answerEnd'] = $createdAt;

									$answersInner = DB::collection('answer')
													->where('data.deletedAt','')
													->where('data.answerFormId',$answerFormsInner[$m]['data']['objectId'])
													->whereIn('data.questionId',[
														'20171018150442-530031882435985-1292598',
														'20171018150820-530032100555924-1849083',
														'20171018150908-530032148131457-1260444',
														'20171018151001-530032201001984-1463207'
													])
													->project(['_id' => 0])
													->get();
									if (!empty($answersInner)) {
										$answerFormsInner[$m]['data']['objectId'] = $answers[$n]['data']['answerFormIdValue'];
										for ($o=0;$o<count($answersInner);$o++) {
											$answersInner[$o]['data']['objectId'] = generateObjectId();
											$answersInner[$o]['data']['answerFormId'] = $answerFormsInner[$m]['data']['objectId'];
											$answersInner[$o]['data']['createdAt'] = $createdAt;
											$answersInner[$o]['data']['updatedAt'] = $createdAt;
											$answersInner[$o]['data']['isoCreatedAt'] = $isoCreatedAt;
											$answersInner[$o]['data']['isoUpdatedAt'] = $isoCreatedAt;

											if ($answersInner[$o]['data']['questionId'] == '20171018150908-530032148131457-1260444') {
												$answersInner[$o]['data']['doubleValue'] = $answersInner[$o]['data']['doubleValue'] + 1;
												$answersInner[$o]['data']['stringValue'] = strVal($answersInner[$o]['data']['stringValue'] + 1);
												
												$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
												$explode[1] = mb_substr($explode[1],0,17) . $answersInner[$o]['data']['doubleValue'] .".0 ปี. ";
												$implode = implode('|',$explode);
												$answerFormsInner[$m]['data']['answerPreview'] = $implode;
											}
										}
										DB::collection('answer')->insert($answersInner, ['upsert' => true]);
									}
									$answerFormsInnerFlatData[]['data'] = [
										'objectId' => $answerFormsInner[$m]['data']['objectId'],
										"objectType" => "answerForm",
										'status' => 'insert'
									];
								}
								DB::collection('answerForm')->insert($answerFormsInner, ['upsert' => true]);
								DB::collection('checkFlatData')->insert($answerFormsInnerFlatData, ['upsert' => true]);
							}
						} if ($answers[$n]['data']['questionId'] == '20171018151622-530032582002423-1605287') { #10.3
							$answerFormsInner = DB::collection('answerForm')
												->where('data.objectId',$answers[$n]['data']['answerFormIdValue'])
												->where('data.deletedAt','')
												->project(['_id' => 0])
												->get();
							if (!empty($answerFormsInner)) {
								$answerFormsInnerFlatData = [];
								$answers[$n]['data']['answerFormIdValue'] = generateObjectId();
								for ($m=0;$m<count($answerFormsInner);$m++) {
									$answerFormsInner[$m]['data']['parentAnswerFormId'] = $newObjectId;
									$answerFormsInner[$m]['data']['createdAt'] = $createdAt;
									$answerFormsInner[$m]['data']['updatedAt'] = $createdAt;
									$answerFormsInner[$m]['data']['isoCreatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['isoUpdatedAt'] = $isoCreatedAt;
									$answerFormsInner[$m]['data']['answerStart'] = $createdAt;
									$answerFormsInner[$m]['data']['answerEnd'] = $createdAt;

									$answersInner = DB::collection('answer')
													->where('data.deletedAt','')
													->where('data.answerFormId',$answerFormsInner[$m]['data']['objectId'])
													->whereIn('data.questionId',[
														'20171018151830-530032710967677-1225318',
														'20171018152712-530033232904991-1703736',
														'20171018152415-530033055380208-1683248',
														'20171018152507-530033107990395-1465192'												
													])
													->project(['_id' => 0])
													->get();
									if (!empty($answersInner)) {
										$answerFormsInner[$m]['data']['objectId'] = $answers[$n]['data']['answerFormIdValue'];
										for ($o=0;$o<count($answersInner);$o++) {
											$answersInner[$o]['data']['objectId'] = generateObjectId();
											$answersInner[$o]['data']['answerFormId'] = $answerFormsInner[$m]['data']['objectId'];
											$answersInner[$o]['data']['createdAt'] = $createdAt;
											$answersInner[$o]['data']['updatedAt'] = $createdAt;
											$answersInner[$o]['data']['isoCreatedAt'] = $isoCreatedAt;
											$answersInner[$o]['data']['isoUpdatedAt'] = $isoCreatedAt;

											if ($answersInner[$o]['data']['questionId'] == '20171018152415-530033055380208-1683248') {
												$answersInner[$o]['data']['doubleValue'] = $answersInner[$o]['data']['doubleValue'] + 1;
												$answersInner[$o]['data']['stringValue'] = strVal($answersInner[$o]['data']['stringValue'] + 1);

												$explode = explode('|',$answerFormsInner[$m]['data']['answerPreview']);
												$explode[1] = mb_substr($explode[1],0,13) . $answersInner[$o]['data']['doubleValue'] .".0 ";
												$implode = implode('|',$explode);
												$answerFormsInner[$m]['data']['answerPreview'] = $implode;
											}
										}
										DB::collection('answer')->insert($answersInner, ['upsert' => true]);
									}
									$answerFormsInnerFlatData[]['data'] = [
										'objectId' => $answerFormsInner[$m]['data']['objectId'],
										"objectType" => "answerForm",
										'status' => 'insert'
									];
								}
								DB::collection('answerForm')->insert($answerFormsInner, ['upsert' => true]);
								DB::collection('checkFlatData')->insert($answerFormsInnerFlatData, ['upsert' => true]);
							}
						}*/
					}
					DB::collection('answer')->insert($answers, ['upsert' => true]);
				}
				$answerFormsFlatData[]['data'] = [
					'objectId' => $answerForms[$i]['data']['objectId'],
					"objectType" => "answerForm",
					'status' => 'insert'
				];
			}
			DB::collection('answerForm')->insert($answerForms, ['upsert' => true]);
			DB::collection('checkFlatData')->insert($answerFormsFlatData, ['upsert' => true]);

			echo "finish !";
		}
	}

	public function changeDateHuaisan() {
		$isoDateStartQuery = isoDateConvert(date('2019-01-01 00:00:00'));
		$isoDateEndQuery = isoDateConvert(date('2019-03-01 00:00:00'));
		
		$MAIN_FORM_ID = '20171018011853-529982333425753-1281522';
		$VILLAGE_NAME_9 = '20171227091410-536058850007324-1248938';
		$VILLAGE_NAME_10 = '20180108065053-537087053740305-1394003';
		$VILLAGE_NAME_11 = '20180108065203-537087123424853-1460894';
		$VILLAGE_NAME_13 = '20180108065336-537087216001132-1338687';
		$insertCheckFlat = [];
		$answers = DB::collection('answer')
				->where('data.deletedAt','')
				->whereRaw([
					'data.isoCreatedAt' => ['$gte' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
				])
				->whereIn('data.questionId',
				[
					$VILLAGE_NAME_9,
					$VILLAGE_NAME_10,
					$VILLAGE_NAME_11,
					$VILLAGE_NAME_13
				])
				->project(['_id' => 0])
				->get();

		if (!empty($answers)) {
			for ($n=0;$n<count($answers);$n++) {
				$createdAt = $answers[$n]['data']['createdAt'];
				if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_9) {
					if ($answers[$n]['data']['stringValue'] == "เมืองงามเหนือ") {
						//$createdAt = date('2019-2-01 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "กอแอ") {
						$createdAt = date('2019-1-30 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "โป่งน้ำร้อน") {
						//$createdAt = date('2019-1-31 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "ยะผ่า") {
						//$createdAt = date('2019-2-09 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "หย่าเก๊อะ") {
						//$createdAt = date('2019-2-09 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "สี่หลัง") {
						//$createdAt = date('2019-2-08 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "อาเพียง") {
						//$createdAt = date('2019-1-31 01:00:00');
					}
				} else if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_10) { 
					if ($answers[$n]['data']['stringValue'] == "ห้วยส้าน") {
						$createdAt = date('2019-1-28 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "ห้วยเต่า") {
						//$createdAt = date('2019-1-25 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "ฮ้าฮก") {
						$createdAt = date('2019-2-06 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "บะหลา") {
						$createdAt = date('2019-1-24 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "หัวน้ำ") {
						$createdAt = date('2019-1-24 01:00:00');
					}
				} else if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_11) {
					if ($answers[$n]['data']['stringValue'] == "เล่าอัง") {
						//$createdAt = date('2019-2-08 01:00:00');
					} 
					/*else if ($answers[$n]['data']['stringValue'] == "หัวเมืองงาม") {
						$createdAt = date('2019-01-14 01:00:00');
					}*/
					else if ($answers[$n]['data']['stringValue'] == "สามหลัง") {
						$createdAt = date('2019-1-22 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "สุขฤทัย") {
						$createdAt = date('2019-1-23 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "สิงคโปร์") {
						$createdAt = date('2019-1-23 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "อาเทอ") {
						$createdAt = date('2019-1-21 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "ป่ากล้วย") {
						//$createdAt = date('2019-2-11 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "แสนสุข") {
						//$createdAt = date('2019-2-04 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "กลางนา") {
						//$createdAt = date('2019-2-05 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "อาชู") {
						//$createdAt = date('2019-2-06 01:00:00');
					}
				} else if ($answers[$n]['data']['questionId'] == $VILLAGE_NAME_13) { 
					if ($answers[$n]['data']['stringValue'] == "เมืองงามใต้") {
						//$createdAt = date('2019-2-07 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "ห้วยป่าแขม") {
						//$createdAt = date('2019-1-26 01:00:00');
					} else if ($answers[$n]['data']['stringValue'] == "สบงาม") {
						//$createdAt = date('2019-1-25 01:00:00');
					}
				}

				$isoCreatedAt = isoDateConvert($createdAt);
				$answerForms = DB::collection('answerForm')
								->where('data.objectId',$answers[$n]['data']['answerFormId'])
								->where('data.deletedAt','');
				$answerFormsObjectId = $answerForms->pluck('data.objectId');

				$answerFormsUpdate = $answerForms->update([
					'data.createdAt' => $createdAt,
					'data.isoCreatedAt' => $isoCreatedAt,
					'data.updatedAt' => $createdAt,
					'data.isoUpdatedAt' => $isoCreatedAt
				]);

				$answerFormsLv1 = DB::collection('answerForm')
								->whereIn('data.parentAnswerFormId',$answerFormsObjectId)
								->where('data.deletedAt','');

				$answerFormsLv1ObjectId = $answerFormsLv1->pluck('data.objectId');
				$answerFormsLv1Update = $answerFormsLv1->update([
					'data.createdAt' => $createdAt,
					'data.isoCreatedAt' => $isoCreatedAt,
					'data.updatedAt' => $createdAt,
					'data.isoUpdatedAt' => $isoCreatedAt
				]);

				if (!empty($answerFormsObjectId)) {
					foreach ($answerFormsObjectId as $answerFormObjectId) {
						$insertCheckFlat[]['data'] = [
							'objectId' => $answerFormObjectId,
							"objectType" => "answerForm",
							'status' => 'update'
						];
					}
				}

				if (!empty($answerFormsLv1ObjectId)) {
					foreach ($answerFormsLv1ObjectId as $answerFormLv1ObjectId) {
						$insertCheckFlat[]['data'] = [
							'objectId' => $answerFormLv1ObjectId,
							"objectType" => "answerForm",
							'status' => 'update'
						];
					}
				}
			}

			DB::collection('checkFlatData')->insert($insertCheckFlat, ['upsert' => true]);

			echo "success !";
		}	
	}

	public function genAnswerFormPreview() {
		$isoDateStartQuery = isoDateConvert(date('2019-01-01 00:00:00'));
		$isoDateEndQuery = isoDateConvert(date('2019-03-01 00:00:00'));

		$answerForms = DB::collection('answerForm')
						->where('data.deletedAt','')
						->where('data.formId','20171018011853-529982333425753-1281522')
						->whereRaw([
							'data.isoCreatedAt' => ['$gte' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						])
						->project(['_id' => 0])
						->get();

		if (!empty($answerForms)) {
			for($i=0;$i<count($answerForms);$i++) {
				$explodePreview = [];
				$explodePreview = explode('|',$answerForms[$i]['data']['answerPreview']);
				if (!empty($explodePreview)) {
					unset($explodePreview[0]);
					$explodePreview = array_filter($explodePreview, function($value) { return $value !== ''; });
					$explodePreview = implode('|',$explodePreview) . '|';

					$answerForms[$i]['data']['answerPreview'] = $explodePreview;
					$insertAnswerForms = DB::collection('answerForm')
											->where('data.objectId',$answerForms[$i]['data']['objectId'])
											->update([
												'data.answerPreview' => $explodePreview,
											]);
				}		
			}
			echo "success";
		}
	}

	public function clearDataHuaisan() {
		$isoDateStartQuery = isoDateConvert(date('2019-02-01 00:00:00'));
		$isoDateEndQuery = isoDateConvert(date('2019-03-01 00:00:00'));
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$admin = '58fd6cc13fd89d8b529e4acf';
		$formsId = [
			'20171018011853-529982333425753-1281522',
			'20171018150417-530031857313801-1149113',
			'20171018151807-530032687034851-1034850',
			'20171018084856-530009336838907-1464943',
			'20171018091217-530010737462804-1442285',
			'20171018155422-530034862952831-1658091',
			'20171018013349-529983229201903-1958280',
			'20180109064534-537173134416346-1924310',
			'20171018051304-52999638480445-1516249',
			'20171226143041-535991441820083-1493338',
			'20171018065350-530002430985574-1934803',
			'20190119081722-569578642902188-1154990',
			'20190120081559-569664959707804-1767429',
			'20180104110732-536756852650904-1832681',
			'20180112080007-537436807047795-1673958',
			'20180111090516-537354316472906-1809823',
			'20190117133814-569425094478843-1173043',
			'20171018012731-529982851938354-1900067',
			'20171018012731-529982851938354-1900067'
		];

		$answerFormsCheckFlat = [];
		foreach ($formsId as $formId) {
			$answerForms = DB::collection('answerForm')
							#->where('data.objctId','20190123032628-569906788876034-1911448')
							->where('data.formId',$formId)
							->where('data.deletedAt','')
							->whereRaw([
								'data.isoCreatedAt' => ['$gte' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
							])
							->project(['_id' => 0])
							->pluck('data');
			if (!empty($answerForms)) {
				$questions = DB::collection('question')
								->where('data.deletedAt','')
								->where('data.formId',$formId)
								->orWhere('data.type',2)
								->orWhere('data.type',3)
								->orWhere('data.type',0)
								->orWhere('data.type',10)
								->pluck('data');
				if (!empty($questions)) {
					foreach ($questions as $question) {
						$questionConfigs = DB::collection('questionConfiguration')
										->where('data.deletedAt','')
										->where('data.objectId',$question['settingId'])
										->first();
						$maximumAnswer = $questionConfigs['data']['maximumAnswer'];
						if (!empty($questionConfigs)) {
							foreach ($answerForms as $answerForm) {
								$answers = DB::collection('answer')
											->where('data.deletedAt','')
											->where('data.answerFormId',$answerForm['objectId'])
											->where('data.questionId',$question['objectId'])
											->get();
								if ($question['type'] == 3 || $question['type'] == 10) {
									if (count($answers) > 1) {
										$answersDeleted = DB::collection('answer')
															->where('data.deletedAt','')
															->where('data.answerFormId',$answerForm['objectId'])
															->where('data.questionId',$question['objectId'])
															->orderBy('data.isoCreatedAt','DESC')
															->first();

										$answersDeletedAt = DB::collection('answer')->where('data.objectId',$answersDeleted['data']['objectId'])
															->update([
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow,
																'data.updatedBy' => $answerForm['createdBy'],
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $answerForm['createdBy']
															]);

										if ($answersDeletedAt) {
											$answerFormsUpdate = DB::Collection('answerForm')
																	->where('data.deletedAt','')
																	->where('data.objectId',$answerForm['objectId'])
																	->update([
																		'data.updatedAt' => $datenow,
																		'data.isoUpdatedAt' => $isoDatenow,
																	]);
											
											$mainAnswerForms = DB::Collection('answerForm')
																	->where('data.deletedAt','')
																	->where('data.objectId',$answerForm['parentAnswerFormId']);
											$mainAnswerFormsObjectId = $mainAnswerForms->pluck('data.objectId');
											$mainAnswerFormsUpdate = $mainAnswerForms->update([
												'data.updatedAt' => $datenow,
												'data.isoUpdatedAt' => $isoDatenow,
											]);
																	
											
											$answerFormsCheckFlat[]['data'] = [
												'objectId' => $answerForm['objectId'],
												"objectType" => "answerForm",
												'status' => 'update'
											];

											if (!empty($mainAnswerFormsObjectId)) {
												foreach ($mainAnswerFormsObjectId as $mainAnswerFormObjectId) {
													$answerFormsCheckFlat[]['data'] = [
														'objectId' => $mainAnswerFormObjectId,
														"objectType" => "answerForm",
														'status' => 'update'
													];
												}
											}
										}
									}
								} else if ($question['type'] == 2 || $question['type'] == 0) {
									if ($maximumAnswer > count($answers)) {
										$choiceId = DB::collection('answer')
													->where('data.deletedAt','')
													->where('data.answerFormId',$answerForm['objectId'])
													->where('data.questionId',$question['objectId'])
													->pluck('data.choiceId');
										$choiceId = array_filter($choiceId);
										$duplicateAnswers = array_count_values($choiceId);
										if (!empty($duplicateAnswers)) {
											foreach ($duplicateAnswers as $key => $duplicateAnswer) {
												if ($duplicateAnswer > 1) {
													$answersDeleted = DB::collection('answer')
																		->where('data.deletedAt','')
																		->where('data.answerFormId',$answerForm['objectId'])
																		->where('data.questionId',$question['objectId'])
																		->where('data.choiceId',$key)
																		->orderBy('data.isoCreatedAt','DESC')
																		->first();
																		
													$answersDeletedAt = DB::collection('answer')->where('data.objectId',$answersDeleted['data']['objectId'])
																		->update([
																			'data.updatedAt' => $datenow,
																			'data.isoUpdatedAt' => $isoDatenow,
																			'data.updatedBy' => $answerForm['createdBy'],
																			'data.deletedAt' => $datenow,
																			'data.deletedBy' => $answerForm['createdBy']
																		]);
													if ($answersDeletedAt) {
														$answerFormsUpdate = DB::Collection('answerForm')
																			->where('data.deletedAt','')
																			->where('data.objectId',$answerForm['objectId'])
																			->update([
																				'data.updatedAt' => $datenow,
																				'data.isoUpdatedAt' => $isoDatenow,
																			]);
				
														$mainAnswerForms = DB::Collection('answerForm')
																				->where('data.deletedAt','')
																				->where('data.objectId',$answerForm['parentAnswerFormId']);
														$mainAnswerFormsObjectId = $mainAnswerForms->pluck('data.objectId');
														$mainAnswerFormsUpdate = $mainAnswerForms->update([
															'data.updatedAt' => $datenow,
															'data.isoUpdatedAt' => $isoDatenow,
														]);
					
														$answerFormsCheckFlat[]['data'] = [
															'objectId' => $answerForm['objectId'],
															"objectType" => "answerForm",
															'status' => 'update'
														];
					
														if (!empty($mainAnswerFormsObjectId)) {
															foreach ($mainAnswerFormsObjectId as $mainAnswerFormObjectId) {
																$answerFormsCheckFlat[]['data'] = [
																	'objectId' => $mainAnswerFormObjectId,
																	"objectType" => "answerForm",
																	'status' => 'update'
																];
															}
														}
													}
												}
											}
										}
									} else if (count($answers) > $maximumAnswer) {
										$answersDeleted = DB::collection('answer')
															->where('data.deletedAt','')
															->where('data.answerFormId',$answerForm['objectId'])
															->where('data.questionId',$question['objectId'])
															->orderBy('data.isoCreatedAt','DESC')
															->limit($maximumAnswer)
															->pluck('data.objectId');

										$answersDeletedAt = DB::collection('answer')->whereIn('data.objectId',$answersDeleted)
															->update([
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow,
																'data.updatedBy' => $answerForm['createdBy'],
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $answerForm['createdBy']
															]);
										if ($answersDeletedAt) {
											$answerFormsUpdate = DB::Collection('answerForm')
																->where('data.deletedAt','')
																->where('data.objectId',$answerForm['objectId'])
																->update([
																	'data.updatedAt' => $datenow,
																	'data.isoUpdatedAt' => $isoDatenow,
																]);

											$mainAnswerForms = DB::Collection('answerForm')
																	->where('data.deletedAt','')
																	->where('data.objectId',$answerForm['parentAnswerFormId']);
											$mainAnswerFormsObjectId = $mainAnswerForms->pluck('data.objectId');
											$mainAnswerFormsUpdate = $mainAnswerForms->update([
												'data.updatedAt' => $datenow,
												'data.isoUpdatedAt' => $isoDatenow,
											]);

											$answerFormsCheckFlat[]['data'] = [
												'objectId' => $answerForm['objectId'],
												"objectType" => "answerForm",
												'status' => 'update'
											];

											if (!empty($mainAnswerFormsObjectId)) {
												foreach ($mainAnswerFormsObjectId as $mainAnswerFormObjectId) {
													$answerFormsCheckFlat[]['data'] = [
														'objectId' => $mainAnswerFormObjectId,
														"objectType" => "answerForm",
														'status' => 'update'
													];
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		
		if (!empty($answerFormsCheckFlat)) {
			$insertCheckFlat = [];
			$answerFormsCheckFlatData = array_column($answerFormsCheckFlat, 'data');
			$answerFormsCheckFlatObjectId = array_column($answerFormsCheckFlatData, 'objectId');
			$uniqueObjectIds = array_unique($answerFormsCheckFlatObjectId);
			foreach ($uniqueObjectIds as $uniqueObjectId) {
				$insertCheckFlat[]['data'] = [
					'objectId' => $uniqueObjectId,
					"objectType" => "answerForm",
					'status' => 'update'
				];
			}
			DB::collection('checkFlatData')->insert($insertCheckFlat);
		}

		echo "success";
	}

	public function clearInnerFormHuaisarn() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$shortPlantFormId = "20171018051304-52999638480445-1516249"; #"รายละเอียดการปลูกพืชระยะสั้น"
		$juniorPlantFormId = "20171226143041-535991441820083-1493338"; #พืชชนิดรอง
		$longPlantFormId = "20171018065350-530002430985574-1934803"; #"รายละเอียดการปลูกพืชยืนต้น"

		$questionCheck = "20171018050544-529995944954855-1466882"; #ครัวเรือนของคุณทำการปลูกพืชหรือไม่
		$formId = '20171018011853-529982333425753-1281522';

		$isoDateStartQuery = isoDateConvert(date('2019-01-01 00:00:00'));
		$isoDateEndQuery = isoDateConvert(date('2019-03-01 00:00:00'));
		
		$answerForms = DB::collection('flatData')
						->where('formId',$formId)
						->whereRaw([
							'isoCreatedAt' => ['$gt' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						])
						->project(['_id' => 0])
						->get();
		$answerFormsCheckFlat = [];
		foreach ($answerForms as $answerForm) {
			if (!empty($answerForm[$questionCheck])) {
				if (dataToValue($answerForm[$questionCheck]) == "ไม่ทำ") {
					$shortPlants = DB::collection('flatData')
									->where('parentAnswerFormId',$answerForm['objectId'])
									->where('formId',$shortPlantFormId)
									->get();
					$longPlants = DB::collection('flatData')
									->where('parentAnswerFormId',$answerForm['objectId'])
									->where('formId',$longPlantFormId)
									->get();
					
					if (!empty($shortPlants) || !empty($longPlants)) {
						if (!empty($shortPlants)) {
							foreach ($shortPlants as $shortPlant) {
								$juniorPlants = DB::collection('flatData')
												->where('parentAnswerFormId',$shortPlant['objectId'])
												->where('formId',$juniorPlantFormId)
												->get();
								
								if (!empty($juniorPlants)) {
									foreach ($juniorPlants as $juniorPlant) {
										$answersDeleted = DB::collection('answer')
															->where('data.deletedAt','')
															->where('data.answerFormId',$juniorPlant['objectId'])
															->update([
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $juniorPlant['createdBy'],
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow
															]);

										$answerFormsDeleted = DB::collection('answerForm')
															->where('data.deletedAt','')
															->where('data.objectId',$juniorPlant['objectId'])
															->update([
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $juniorPlant['createdBy'],
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow
															]);
										
										$answerFormsCheckFlat[]['data'] = [
											'objectId' => $juniorPlant['objectId'],
											"objectType" => "answerForm",
											'status' => 'delete'
										];					
									}
								}

								$answersFormIdValueDeleted = DB::collection('answer')
															->where('data.deletedAt','')
															->where('data.answerFormIdValue',$shortPlant['objectId'])
															->update([
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $shortPlant['createdBy'],
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow
															]);

								$answersDeleted = DB::collection('answer')
													->where('data.deletedAt','')
													->where('data.answerFormId',$shortPlant['objectId'])
													->update([
														'data.deletedAt' => $datenow,
														'data.deletedBy' => $shortPlant['createdBy'],
														'data.updatedAt' => $datenow,
														'data.isoUpdatedAt' => $isoDatenow
													]);

								$answerFormsDeleted = DB::collection('answerForm')
													->where('data.deletedAt','')
													->where('data.objectId',$shortPlant['objectId'])
													->update([
														'data.deletedAt' => $datenow,
														'data.deletedBy' => $shortPlant['createdBy'],
														'data.updatedAt' => $datenow,
														'data.isoUpdatedAt' => $isoDatenow
													]);

								$answerFormsCheckFlat[]['data'] = [
									'objectId' => $shortPlant['objectId'],
									"objectType" => "answerForm",
									'status' => 'delete'
								];
							}
						}

						if (!empty($longPlants)) {
							foreach ($longPlants as $longPlant) {
								$answersFormIdValueDeleted = DB::collection('answer')
															->where('data.deletedAt','')
															->where('data.answerFormIdValue',$longPlant['objectId'])
															->update([
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $longPlant['createdBy'],
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow
															]);

								$answersDeleted = DB::collection('answer')
													->where('data.deletedAt','')
													->where('data.answerFormId',$longPlant['objectId'])
													->update([
														'data.deletedAt' => $datenow,
														'data.deletedBy' => $longPlant['createdBy'],
														'data.updatedAt' => $datenow,
														'data.isoUpdatedAt' => $isoDatenow
													]);

								$answerFormsDeleted = DB::collection('answerForm')
													->where('data.deletedAt','')
													->where('data.objectId',$longPlant['objectId'])
													->update([
														'data.deletedAt' => $datenow,
														'data.deletedBy' => $longPlant['createdBy'],
														'data.updatedAt' => $datenow,
														'data.isoUpdatedAt' => $isoDatenow
													]);

								$answerFormsCheckFlat[]['data'] = [
									'objectId' => $longPlant['objectId'],
									"objectType" => "answerForm",
									'status' => 'delete'
								];	
							}
						}

						$answerFormsUpdated = DB::collection('answerForm')
												->where('data.deletedAt','')
												->where('data.objectId',$answerForm['objectId'])
												->update([
													'data.updatedAt' => $datenow,
													'data.isoUpdatedAt' => $isoDatenow
												]);
						$answerFormsCheckFlat[]['data'] = [
							'objectId' => $answerForm['objectId'],
							"objectType" => "answerForm",
							'status' => 'update'
						];

					}
				} else if (dataToValue($answerForm[$questionCheck]) == "ทำ") {
					$shortPlants = DB::collection('flatData')
									->where('parentAnswerFormId',$answerForm['objectId'])
									->where('formId',$shortPlantFormId)
									->get();
					if (!empty($shortPlants)) {
						foreach ($shortPlants as $shortPlant) {
							if (dataToValue($shortPlant['20171226042505-535955105441646-1726845']) == "ไม่ปลูก") {
								$juniorPlants = DB::collection('flatData')
												->where('parentAnswerFormId',$shortPlant['objectId'])
												->where('formId',$juniorPlantFormId)
												->get();
								if (!empty($juniorPlants)) {
									foreach ($juniorPlants as $juniorPlant) {
										$answersFormIdValueDeleted = DB::collection('answer')
																	->where('data.deletedAt','')
																	->where('data.answerFormIdValue',$juniorPlant['objectId'])
																	->update([
																		'data.deletedAt' => $datenow,
																		'data.deletedBy' => $shortPlant['createdBy'],
																		'data.updatedAt' => $datenow,
																		'data.isoUpdatedAt' => $isoDatenow
																	]);
										
										$answersDeleted = DB::collection('answer')
															->where('data.deletedAt','')
															->where('data.answerFormId',$juniorPlant['objectId'])
															->update([
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $juniorPlant['createdBy'],
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow
															]);

										$answerFormsDeleted = DB::collection('answerForm')
															->where('data.deletedAt','')
															->where('data.objectId',$juniorPlant['objectId'])
															->update([
																'data.deletedAt' => $datenow,
																'data.deletedBy' => $juniorPlant['createdBy'],
																'data.updatedAt' => $datenow,
																'data.isoUpdatedAt' => $isoDatenow
															]);
										
										$answerFormsCheckFlat[]['data'] = [
											'objectId' => $juniorPlant['objectId'],
											"objectType" => "answerForm",
											'status' => 'delete'
										];	
									}
								}
							}
						}
					}
				}
			}
		}

		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);

		echo "success";
	}

	public function updatedDate () {
		$isoDateStartQuery = isoDateConvert(date('2019-01-24 00:00:00'));
		$isoDateEndQuery = isoDateConvert(date('2019-03-01 00:00:00'));
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);

		$formId = [
			'20171018011853-529982333425753-1281522',
			'20171018150417-530031857313801-1149113',
			'20171018151807-530032687034851-1034850',
			'20171018084856-530009336838907-1464943',
			'20171018091217-530010737462804-1442285',
			'20171018155422-530034862952831-1658091',
			'20171018013349-529983229201903-1958280',
			'20180109064534-537173134416346-1924310',
			'20171018051304-52999638480445-1516249',
			'20171226143041-535991441820083-1493338',
			'20171018065350-530002430985574-1934803',
			'20190119081722-569578642902188-1154990',
			'20190120081559-569664959707804-1767429',
			'20180104110732-536756852650904-1832681',
			'20180112080007-537436807047795-1673958',
			'20180111090516-537354316472906-1809823',
			'20190117133814-569425094478843-1173043',
			'20171018012731-529982851938354-1900067',
			'20171018012731-529982851938354-1900067'
		];

		$answerForms = DB::collection('answerForm')
						->whereIn('data.formId',$formId)
						->where('data.deletedAt','')
						->whereRaw([
							'data.isoCreatedAt' => ['$gte' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						])
						->project(['_id' => 0])
						->get();
		if (!empty($answerForms)) {
			$answerFormsCheckFlat = [];
			for ($i=0;$i<count($answerForms);$i++) {
				$newDate = date('Y-n-d H:i:s', strtotime($answerForms[$i]['data']['updatedAt'] . " +1 minutes"));
				$answerForms[$i]['data']['updatedAt'] = $newDate;
				$answerForms[$i]['data']['isoUpdatedAt'] = isoDateConvert($newDate);
				$answerForms[$i]['data']['createdBy'] = "";
				
				$answerFormsUpdate = DB::collection('answerForm')
										->where('data.objectId',$answerForms[$i]['data']['objectId'])
										->update($answerForms[$i], ['upsert' => true]);

				$answerFormsCheckFlat[]['data'] = [
					'objectId' => $answerForms[$i]['data']['objectId'],
					"objectType" => "answerForm",
					'status' => 'update'
				];
			}

			if (!empty($answerFormsCheckFlat)) {
				DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
			}
		}
	}

	public function updateData() {
		$isoDateStartQuery = isoDateConvert(date('2019-01-21 00:00:00'));
		$isoDateEndQuery = isoDateConvert(date('2019-01-23 00:00:00'));
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
						
		$formId = '20171018011853-529982333425753-1281522';
		$SHORT_PLANT_FORMID = '20171018051304-52999638480445-1516249'; #พืชระยะสั้น
		$SHORT_SELL_PRODUCT = '20180111104941-537360581576882-1909821'; #ท่านมีการขายผลผลิตในปีที่ผ่านมาหรือไม่ 
		$SHORT_MANAGE_PRODUCT = '20190119070526-56957432685294-1169982'; #3.3.11 การจัดการผลผลิตที่ขายไม่ได้

		$SHORT_PLANT_FORMID1 = '20171226143041-535991441820083-1493338'; #พืชรอง
		$SHORT_SELL_PRODUCT1 = '20180111105120-537360680875216-1583946'; #ท่านมีการขายผลผลิตในปีที่ผ่านมาหรือไม่ 
		$SHORT_MANAGE_PRODUCT1 = '20190119071100-569574660306244-1265979'; #3.3.21 การจัดการผลผลิตที่ขายไม่ได้

		$LONG_PLANT_FORMID = '20171018065350-530002430985574-1934803'; #พืชยืนต้น
		$LONG_SELL_PRODUCT = '20180111110118-537361278317797-1093701'; #ท่านมีการขายผลผลิตในปีที่ผ่านมาหรือไม่ 
		$LONG_MANAGE_PRODUCT = '20190119071404-569574844427267-1946578'; #3.5.12 การจัดการผลผลิตที่ขายไม่ได้


		$answerForms = DB::collection('flatData')
						->where('formId',$formId)
						->whereRaw([
							'isoCreatedAt' => ['$gte' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						])
						->get();
	
		$answerFormsCheckFlat = [];
		if (!empty($answerForms)) {
			foreach ($answerForms as $answerForm) {
				$shortPlants = DB::collection('flatData')
								->where('formId',$SHORT_PLANT_FORMID)
								->where('parentAnswerFormId',$answerForm['objectId'])
								->get();
				
				if (!empty($shortPlants)) {
					foreach ($shortPlants as $shortPlant) {
						if (!empty($shortPlant[$SHORT_SELL_PRODUCT])) {
							$shortPlantSellProduct = dataToValue($shortPlant[$SHORT_SELL_PRODUCT]);
							if ($shortPlantSellProduct == 'ไม่มี') {
								if (!empty($shortPlant[$SHORT_MANAGE_PRODUCT])) {
									$answers = DB::collection('answer')
												->where('data.deletedAt','')
												->where('data.answerFormId',$shortPlant['objectId'])
												->where('data.questionId',$SHORT_MANAGE_PRODUCT)
												->update([
													'data.updatedAt' => $datenow,
													'data.isoUpdatedAt' => $isoDatenow,
													'data.deletedAt' => $datenow,
													'data.deletedBy' => $shortPlant['updatedBy']
												]);
									
									if ($answers == 1) {
										$answerFormsCheckFlat[]['data'] = [
											'objectId' => $shortPlant['objectId'],
											"objectType" => "answerForm",
											'status' => 'update'
										];
									}
								}
							}
						}

						$shortPlants1 = DB::collection('flatData')
											->where('formId',$SHORT_PLANT_FORMID1)
											->where('parentAnswerFormId',$shortPlant['objectId'])
											->get();
						if (!empty($shortPlants1)) {
							foreach ($shortPlants1 as $shortPlant1) {
								if (!empty($shortPlant1[$SHORT_SELL_PRODUCT1])) {
									$shortPlantSellProduct1 = dataToValue($shortPlant1[$SHORT_SELL_PRODUCT1]);
									if ($shortPlantSellProduct1 == 'ไม่มี') {
										if (!empty($shortPlant1[$SHORT_MANAGE_PRODUCT1])) {
											$answers = DB::collection('answer')
														->where('data.deletedAt','')
														->where('data.answerFormId',$shortPlant1['objectId'])
														->where('data.questionId',$SHORT_MANAGE_PRODUCT1)
														->update([
															'data.updatedAt' => $datenow,
															'data.isoUpdatedAt' => $isoDatenow,
															'data.deletedAt' => $datenow,
															'data.deletedBy' => $shortPlant1['updatedBy']
														]);
											if ($answers == 1) {
												$answerFormsCheckFlat[]['data'] = [
													'objectId' => $shortPlant1['objectId'],
													"objectType" => "answerForm",
													'status' => 'update'
												];
											}
										}
									}
								}
							}
						}
					}
				}

				$longPlants = DB::collection('flatData')
								->where('formId',$LONG_PLANT_FORMID)
								->where('parentAnswerFormId',$answerForm['objectId'])
								->get();
								
								
				if (!empty($longPlants)) {
					foreach ($longPlants as $longPlant) {
						if (!empty($longPlant[$LONG_SELL_PRODUCT])) {
							$longPlantSellProduct = dataToValue($longPlant[$LONG_SELL_PRODUCT]);
							if ($longPlantSellProduct == 'ไม่มี') {
								if (!empty($longPlant[$LONG_MANAGE_PRODUCT])) {
									$answers = DB::collection('answer')
												->where('data.deletedAt','')
												->where('data.answerFormId',$longPlant['objectId'])
												->where('data.questionId',$LONG_MANAGE_PRODUCT)
												->update([
													'data.updatedAt' => $datenow,
													'data.isoUpdatedAt' => $isoDatenow,
													'data.deletedAt' => $datenow,
													'data.deletedBy' => $longPlant['updatedBy']
												]);

									if ($answers == 1) {
										$answerFormsCheckFlat[]['data'] = [
											'objectId' => $longPlant['objectId'],
											"objectType" => "answerForm",
											'status' => 'update'
										];
									}
								}
							}
						}
					}
				}

				if (!empty($shortPlants) || !empty($longPlants)) {
					$answerFormsUpdate = DB::collection('answerForm')
											->where('data.deletedAt','')
											->where('data.objectId',$answerForm['objectId'])
											->update([
												'data.updatedAt' => $datenow,
												'data.isoUpdatedAt' => $isoDatenow,
											]);

					if ($answerFormsUpdate) {
						$answerFormsCheckFlat[]['data'] = [
							'objectId' => $answerForm['objectId'],
							"objectType" => "answerForm",
							'status' => 'update'
						];
					}
				}
			}
			if (!empty($answerFormsCheckFlat)) {
				DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
			}
		}

		echo "success";
	}
	
	public function jsonDumpData($formId) {
		$answerForms = DB::collection('answerForm')
						->where('data.deletedAt','')
						->where('data.formId',$formId)
						->skip(1794)
						->pluck('data');

		if (!empty($answerForms)) {
			for ($i=0;$i<count($answerForms);$i++) {
				$newAnswerForms = [];
				$innerForms = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.parentAnswerFormId',$answerForms[$i]['objectId']);

				$innerFrom = $innerForms->pluck('data');
				$objectIdInnerForms = $innerForms->pluck('data.objectId');
				
				$answers = DB::collection('answer')
							->where('data.deletedAt','')
							->where('data.answerFormId',$answerForms[$i]['objectId'])
							->pluck('data');

				$answersInnerForms = DB::collection('answer')
									->where('data.deletedAt','')
									->whereIn('data.answerFormId',$objectIdInnerForms)
									->pluck('data');

				$newAnswerForms[] = $answerForms[$i];

				if (!empty($innerFrom)) {
					foreach ($innerFrom as $innerFromObject) {
						$newAnswerForms[] = $innerFromObject;
					}
				}

				if (!empty($answers)) {
					foreach ($answers as $answer) {
						$newAnswerForms[] = $answer;
					}
				}

				if (!empty($answersInnerForms)) {
					foreach ($answersInnerForms as $answersInnerForm) {
						$newAnswerForms[] = $answersInnerForm;
					}
				}
			
				$data = json_encode( $newAnswerForms, JSON_UNESCAPED_UNICODE );
			
				$fileName = $answerForms[$i]['objectId'].".json";
				\File::put(storage_path('data/doitung/'.$fileName),$data);
				
			}
		}
		
		echo "success";
	}

	public function updatedAnswerStartEnd() {
		$formId = "20170303120328-507791008-920328-1259708";
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$answerFormsCheckFlat = [];
		$answerForms = DB::collection('answerForm')
						->where('data.deletedAt','')
						->where('data.formId',$formId)
						->whereRaw([
							'data.isoUpdatedAt' => [
								'$gte' => isoDateConvert(date('2019-03-29 00:00:00')),
							]
						])
						->pluck('data');

		if(!empty($answerForms)) {
			foreach ($answerForms as $answerForm) {
				$answerStart = DB::collection('answer')
							->where('data.deletedAt','')
							->where('data.answerFormId',$answerForm['objectId'])
							->where('data.createdBy','!=','')
							->orderBy('data.isoCreatedAt','ASC')
							->first();
	
				$answerEnd = DB::collection('answer')
							->where('data.deletedAt','')
							->where('data.answerFormId',$answerForm['objectId'])
							->orderBy('data.isoCreatedAt','DESC')
							->first();

				$answerFormUpdated = DB::collection('answerForm')
							->where('data.deletedAt','')
							->where('data.objectId',$answerForm['objectId'])
							->update([
								'data.answerStart' => $answerStart['data']['createdAt'],
								'data.answerEnd' => $answerEnd['data']['createdAt'],
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);

				if ($answerFormUpdated) {
					$answerFormsCheckFlat[]['data'] = [
						'objectId' => $answerForm['objectId'],
						"objectType" => "answerForm",
						'status' => 'update'
					];
				}
				$innerForms = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.parentAnswerFormId',$answerForm['objectId'])
								->pluck('data');
				
				if (!empty($innerForms)) {
					foreach ($innerForms as $innerForm) {
						$answerStart = DB::collection('answer')
									->where('data.deletedAt','')
									->where('data.answerFormId',$innerForm['objectId'])
									->where('data.createdBy','!=','')
									->orderBy('data.isoCreatedAt','ASC')
									->first();

						$answerEnd = DB::collection('answer')
									->where('data.deletedAt','')
									->where('data.answerFormId',$innerForm['objectId'])
									->orderBy('data.isoCreatedAt','DESC')
									->first();

						$innerFormUpdated = DB::collection('answerForm')
									->where('data.deletedAt','')
									->where('data.objectId',$innerForm['objectId'])
									->update([
										'data.answerStart' => $answerStart['data']['createdAt'],
										'data.answerEnd' => $answerEnd['data']['createdAt'],
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow
									]);	
									
						if ($innerFormUpdated) {
							$answerFormsCheckFlat[]['data'] = [
								'objectId' => $innerForm['objectId'],
								"objectType" => "answerForm",
								'status' => 'update'
							];
						}
					}
				}
			}
		}
		
		$answerForms = DB::collection('answerForm')
						->where('data.deletedAt','')
						->where('data.formId',$formId)
						->whereRaw([
							'data.isoUpdatedAt' => [
								'$gte' => isoDateConvert(date('2019-03-28 00:00:00')),
								'$lt' => isoDateConvert(date('2019-03-29 23:59:59'))
							]
						])
						->pluck('data');
		
		if (!empty($answerForms)) {
			foreach ($answerForms as $answerForm) {
				$answerFormUpdated = DB::collection('answerForm')
									->where('data.deletedAt','')
									->where('data.objectId',$answerForm['objectId'])
									->update([
										'data.answerStart' => '',
										'data.answerEnd' => '',
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow
									]);
				if ($answerFormUpdated) {
					$answerFormsCheckFlat[]['data'] = [
						'objectId' => $answerForm['objectId'],
						"objectType" => "answerForm",
						'status' => 'update'
					];
				}

				$innerForms = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.parentAnswerFormId',$answerForm['objectId'])
								->pluck('data');
				
				if (!empty($innerForms)) {
					foreach ($innerForms as $innerForm) {
						$innerFormUpdated = DB::collection('answerForm')
									->where('data.deletedAt','')
									->where('data.objectId',$innerForm['objectId'])
									->update([
										'data.answerStart' => '',
										'data.answerEnd' => '',
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow
									]);	
									
						if ($innerFormUpdated) {
							$answerFormsCheckFlat[]['data'] = [
								'objectId' => $innerForm['objectId'],
								"objectType" => "answerForm",
								'status' => 'update'
							];
						}
					}
				}
			}
		}
		
		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
		
		echo "success";
	}

	public function checkAnswerFormIdValue($page_num) {
		$formId = '20180420044238-545892158295872-1326596';
		$wrongAnswerForms = [];
        $startDate2561 = new \MongoDate(strtotime("2018-06-01 00:00:00"));
		$endDate2561 = new \MongoDate(strtotime("2019-03-31 00:00:00"));
		$startDate2560 = new \MongoDate(strtotime("2017-10-01 00:00:00"));
        $endDate2560 = new \MongoDate(strtotime("2018-05-01"));
		$page_size = 100000;
		$skips = $page_size * ($page_num - 1);
		$answerForms = DB::collection('answerForm')
						->where('data.formId',$formId)
						->whereRaw([
							'data.isoCreatedAt' => ['$gte' => $startDate2561, '$lt' => $endDate2561]
						])
						->where('data.deletedAt','')
						->orderBy('data.isoCreatedAt','ASC')
						->skip($skips)
						->take($page_size)
						->pluck('data');
		
		/*$answersId = DB::collection('answer')
					->whereIn('data.answerFormId',$answerFormId)
					->where('data.deletedAt','')
					->whereIn('data.createdBy',[
						"5c99b8b53fd89da729caf599",
						"5c99b8b53fd89da729caf597",
						"5c99b8b53fd89da729caf59d"
					])
					->pluck('data.answerFormId');*/
		
		/*if (!empty($answersId)) {
			$answerForms = DB::collection('answerForm')
							->whereIn('data.objectId',$answersId)
							->where('data.deletedAt',"")
							->pluck('data');*/
	
			if (!empty($answerForms)) {
				foreach ($answerForms as $answerForm) {
					$answers = DB::collection('answer')
								->where('data.answerFormIdValue',$answerForm['objectId'])
								->where('data.deletedAt','')
								->get();
					
					if (empty($answers)) {
						$wrongAnswerForms[] = $answerForm['objectId'];
					}
				}
	
				$uniques = array_unique($wrongAnswerForms);
				dd(count($uniques));
				/*$answerForms = DB::collection('answerForm')
								->where('data.formId',"20170303120328-507791008-920328-1259708")
								->whereIn('data.objectId',$uniques)
								->where('data.deletedAt','')
								->pluck('data');*/
				
				foreach ($uniques as $unique) {
					echo '"'.$unique.'",<br>';
				}		
			} else {
				echo "end";
			}
		//}

		/*if (!empty($answerForms)) {
			foreach ($answerForms as $answerForm) {
				$answers = DB::collection('answer')
							->where('data.answerFormIdValue',$answerForm['objectId'])
							->where('data.deletedAt','')
							->get();
				
				if (empty($answers)) {
					$wrongAnswerForms[] = $answerForm['createdBy'];
				}
			}
		}

		$uniques = array_unique($wrongAnswerForms);

		$users = DB::collection('users')
				->whereIn('_id',$uniques)
				->whereNull('deleted_at')
				->get();
		
		foreach ($users as $user) {
			echo $user['_id']." ".$user['firstname']." ".$user['lastname']."<br>";
		}*/
	}

	public function orderbyPlant() {
		$formId = "20180420042816-5458912969862-1630781";
		$plantId = "20180420043459-545891699115738-1658770";
		$date = date('Y-n-d H:i:s');
		$answerForms = DB::collection('flatData')
						->where('formId',$formId)
						->where($plantId, 'exists', true)
						->get();

		array_multisort(array_map(function($element) use ($plantId) {
			return strtolower(dataToValue($element[$plantId]));
		}, $answerForms), SORT_ASC, $answerForms);

		for ($i=0;$i<count($answerForms);$i++) {
			$datenow = date('Y-n-d H:i:s',strtotime("$date -$i seconds"));
			$isoDatenow = isoDateConvert($datenow);
			$answerForms[$i]['createdAt'] = $datenow;
			$answerForms[$i]['isoCreatedAt'] = $isoDatenow;

			$answerFormUpdated = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.objectId',$answerForms[$i]['objectId'])
								->update([
									'data.createdAt' => $datenow,
									'data.isoCreatedAt' => $isoDatenow,
									'data.updatedAt' => $datenow,
									'data.isoUpdatedAt' => $isoDatenow
								]);	
		}

		echo "Success !";
	}

	public function test() {
		$objectId = [
			'20180430220419-764351236240656-5510117'
		];

		$treeId = "20180420043952-545891992032667-1260127";
		$date = date('Y-n-d H:i:s');
		$answerForms = DB::collection('flatData')
						->whereIn('objectId',$objectId)
						->get();

		array_multisort(array_map(function($element) use ($treeId) {
			return strtolower(dataToValue($element[$treeId]));
		}, $answerForms), SORT_ASC, $answerForms);

		dd($answerForms);
		echo "Success !";
	}

	public function changeUser() {
		$answerFormsCheckFlat = [];
		$MC001 = "5cb80e3061431da66cc65d11";
		$MC002 = "5cb80e3061431da66cc65d12";
		$MC003 = "5cb80e3061431da66cc65d13";

		$MASTER_FORMID = "20180308032358-542172238187372-1989270";
		$INNER1_FORMID = "20180315064413-54278905336271-1503063";
		$INNER2_FORMID = "20180308034551-542173551916251-1791205";

		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);

		$navuttiObjectId = DB::collection('flatData')
						->where('formId',$MASTER_FORMID)
						->where('20180308032457-542172297844251-1326614',"นวุติ")
						->pluck('objectId');
		$navutti2ObjectId = DB::collection('flatData')
						->whereIn('parentAnswerFormId',$navuttiObjectId)
						->pluck('objectId');
		$navutti3ObjectId = DB::collection('flatData')
						->whereIn('parentAnswerFormId',$navutti2ObjectId)
						->pluck('objectId');

		$navutti = array_merge($navuttiObjectId,$navutti2ObjectId,$navutti3ObjectId);
		
		$navuttiUpdated = DB::collection('answerForm')
							->where('data.deletedAt','')
							->whereIn('data.objectId',$navutti)
							->update([
								'data.updatedBy' => $MC001,
								'data.createdBy' => $MC001,
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);

		$doidindangObjectId = DB::collection('flatData')
						->where('formId',$MASTER_FORMID)
						->where('20180308032457-542172297844251-1326614',"ดอยดินแดง")
						->pluck('objectId');
		$doidindang2ObjectId = DB::collection('flatData')
						->whereIn('parentAnswerFormId',$doidindangObjectId)
						->pluck('objectId');
		$doidindang3ObjectId = DB::collection('flatData')
						->whereIn('parentAnswerFormId',$doidindang2ObjectId)
						->pluck('objectId');

		$doidindang = array_merge($doidindangObjectId,$doidindang2ObjectId,$doidindang3ObjectId);

		$doidindangUpdated = DB::collection('answerForm')
							->where('data.deletedAt','')
							->whereIn('data.objectId',$doidindang)
							->update([
								'data.updatedBy' => $MC002,
								'data.createdBy' => $MC002,
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);

		$sunklongObjectId = DB::collection('flatData')
						->where('formId',$MASTER_FORMID)
						->where('20180308032457-542172297844251-1326614',"สันโค้ง")
						->pluck('objectId');

		$sunklong2ObjectId = DB::collection('flatData')
						->whereIn('parentAnswerFormId',$sunklongObjectId)
						->pluck('objectId');		
		$sunklong3ObjectId = DB::collection('flatData')
						->whereIn('parentAnswerFormId',$sunklong2ObjectId)
						->pluck('objectId');

		$sunklong = array_merge($sunklongObjectId,$sunklong2ObjectId,$sunklong3ObjectId);
	
		$sunklongUpdated = DB::collection('answerForm')
							->where('data.deletedAt','')
							->whereIn('data.objectId',$sunklong)
							->update([
								'data.updatedBy' => $MC003,
								'data.createdBy' => $MC003,
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow
							]);

		foreach ($navutti as $navuttis) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $navuttis,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}

		foreach ($doidindang as $doidindangs) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $doidindangs,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}

		foreach ($sunklong as $sunklongs) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $sunklongs,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}

		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
		
		echo "success";
	}

	public function addAnswer() {

		$INNER2_FORMID = "20180308034551-542173551916251-1791205";
		$questionId = "20181206160034-565804834272984-1548653";
		$choiceId = "20181206160303-565804983783795-1729763";
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$answers = [];
		$answerFormsCheckFlat = [];
		$answerForms = DB::collection('flatData')
					->where('updatedAt',"2019-5-31 06:45:51")
					->where('formId',$INNER2_FORMID)
					->where($questionId, 'exists', false)
					->get();

		if (!empty($answerForms)) {
			foreach ($answerForms as $answerForm) {
				$answers[]['data'] = [
					"choiceId" => $choiceId, 
					"answerFormIdValue" => "",
					"dateValue" => 0, 
					"deletedBy" => "", 
					"answerMasterListDetailId" => "", 
					"questionId" => $questionId, 
					"createdAt" => $datenow, 
					"orderIndex" => 0, 
					"objectType" => "answer", 
					"imagePath" => "", 
					"latitude" => null, 
					"thumbnailImagePath" => "", 
					"updatedBy" => $answerForm['createdBy'], 
					"deletedAt" => "", 
					"updatedAt" => $datenow, 
					"objectId" => generateObjectId(), 
					"longtitude" => null, 
					"answerFormId" => $answerForm['objectId'], 
					"doubleValue" => 0, 
					"createdBy" => $answerForm['createdBy'], 
					"integerValue" => 0, 
					"stringValue" => "อัพเดทข้อมูลต้น", 
					"isoCreatedAt" => $isoDatenow, 
					"isoUpdatedAt" => $isoDatenow, 
				];
			}

			/*$answerFormsCheckFlat[]['data'] = [
				'objectId' => $answerForm['objectId'],
				"objectType" => "answerForm",
				'status' => 'update'
			];*/
		}

		DB::collection('answer')->insert($answers);
		#DB::collection('checkFlatData')->insert($answerFormsCheckFlat);

		echo "success";
	}

	public function adminLock() {
		$MASTER_FORMID = "20180308032358-542172238187372-1989270";
		$INNER1_FORMID = "20180315064413-54278905336271-1503063";
		$INNER2_FORMID = "20180308034551-542173551916251-1791205";

		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$objectId = "20180531022003-549426003906002-1090671";
		$questionId = [
			'20180316002959-542852999349437-1189249',
			'20180308032457-542172297844251-1326614',
			'20180314031543-542690143426476-1905201',
			'20180404023329-544502009467115-1067742',
			'20180404022543-544501543575448-1344883',
			'20180404022701-544501621711328-1666935',
			'20180404022740-544501660335775-1677091',
			'20180613014543-550547143676435-1068222',
			'20180404023511-54450211116286-1723484',
			'20180404022911-544501751496183-1481870',
			'20180404022954-544501794569998-1887736',
			'20180404023014-544501814133134-1338568',
			'20180404023617-544502177384853-1644231',
			'20180404023043-544501843142699-1529066',
			'20180404023121-544501881350497-1878637',
			'20180314031630-542690190787234-1606882',
			'20180314035508-542692508625209-1481641',
			'20190427144856-578069336700724-1672013'
		];
		$answers = DB::collection('answer')
					->where('data.answerFormId',$objectId)
					->whereIn('data.questionId',$questionId)
					->where('data.deletedAt',"");
					/*->update([
						'data.adminLock' => true
					]);*/

		$answerFormsLv1 = DB::collection('answerForm')
							->where('data.deletedAt',"")
							->where('data.parentAnswerFormId',$objectId)
							->pluck('data.objectId');

		$answersLv1 = DB::collection('answer')
						->where('data.deletedAt',"")
						->whereIn('data.answerFormId',$answerFormsLv1)
						->whereIn('data.questionId',$questionId);
						/*->update([
							'data.adminLock' => true
						]);*/
		
		$answerFormsLv2 = DB::collection('answerForm')
							->where('data.deletedAt',"")
							->whereIn('data.parentAnswerFormId',$answerFormsLv1)
							->update([
								'data.adminLock' => true
							]);
	

		/*$navuttiObjectId = DB::collection('answerForm')
							->where('data.formId',$INNER1_FORMID)
							->where('data.createdBy','5cb80e3061431da66cc65d11')
							->where('data.deletedAt','')
							->pluck('data.objectId');

		$answers = DB::collection('answer')
							->timeout(-1)
							->whereIn('data.answerFormId',$navuttiObjectId)
							->where('data.questionId','20180316002949-542852989581274-1195308')
							->where('data.deletedAt','')
							->update([
								'data.adminLock' => false
							]);
							
		DB::collection('answer')
						->where('data.deletedAt','')
						->whereIn('data.questionId',[
							#'20180316002949-542852989581274-1195308',
							'20180316002959-542852999349437-1189249',
							'20180308032457-542172297844251-1326614',
							'20180314031543-542690143426476-1905201',
							'20180404023329-544502009467115-1067742',
							'20180404022543-544501543575448-1344883',
							'20180404022701-544501621711328-1666935',
							'20180404022740-544501660335775-1677091',
							'20180613014543-550547143676435-1068222',
							'20180404023511-54450211116286-1723484',
							'20180404022911-544501751496183-1481870',
							'20180404022954-544501794569998-1887736',
							'20180404023014-544501814133134-1338568',
							'20180404023617-544502177384853-1644231',
							'20180404023043-544501843142699-1529066',
							'20180404023121-544501881350497-1878637',
							'20180314031630-542690190787234-1606882',
							'20180314035508-542692508625209-1481641',
							'20190427144856-578069336700724-1672013'
						])
						->update([
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow,
							'data.adminLock' => true
						]);

		DB::collection('answerForm')
						->timeout(-1)
						->where('data.deletedAt','')
						->where('data.formId',$MASTER_FORMID)
						->update([
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow,
						]);

		DB::collection('answerForm')
						->timeout(-1)
						->where('data.deletedAt','')
						->where('data.formId',$INNER1_FORMID)
						->update([
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow,
						]);

		DB::collection('answerForm')
						->timeout(-1)
						->where('data.deletedAt','')
						->where('data.formId',$INNER2_FORMID)
						->update([
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow,
							'data.adminLock' => true
						]);*/

		echo "success";
	}

	public function updateCheckFlat() {
		$answerFormsCheckFlat = [];
		$objectId = [
			'1753',
			'1746',
			'1575',
			'1545',
			'1521',
			'1410',
			'1351',
			'1313',
			'1227',
			'1216',
			'1157',
			'1076',
			'1054',
			'1037',
			'968',
			'699',
			'658',
			'673',
			'560',
			'520',
			'497',
			'498',
			'408',
			'215',
			'200',
			'205',
			'1907',
			'185',
			'1826',
		];

		$innerFormsLv1ObjectId = DB::collection('answerForm')
								->whereIn('data.parentAnswerFormId',$objectId)
								->where('data.deletedAt','')
								->pluck('data.objectId');

		$innerFormsLv2ObjectId = DB::collection('answerForm')
								->whereIn('data.parentAnswerFormId',$innerFormsLv1ObjectId)
								->where('data.deletedAt','')
								->pluck('data.objectId');

		foreach ($objectId as $objectIds) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $objectIds,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}
		
		foreach ($innerFormsLv1ObjectId as $innerFormLv1ObjectId) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $innerFormLv1ObjectId,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}

		foreach ($innerFormsLv2ObjectId as $innerFormLv2ObjectId) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $innerFormLv2ObjectId,
				"objectType" => "answerForm",
				'status' => 'update'
			];
		}
		
		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);		

	}

	public function unMarkDeleted() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		#$isoDateStartQuery = isoDateConvert(date('2019-05-08 00:00:00'));
		#$isoDateEndQuery = isoDateConvert(date('2019-05-09 00:00:00'));
		$answerFormsCheckFlat = [];
		$objectId = "20180531022003-549426003906002-1090671";

		$updated = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => "",
			'data.deletedBy' => ""
		];

		$answerForms = DB::collection('answerForm')
						->where('data.objectId',$objectId)
						->where('data.deletedAt',"")
						/*->whereRaw([
							'data.isoUpdatedAt' => ['$gt' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						])*/
						->update($updated);

		$answerFormsLv1 = DB::collection('answerForm')
						->where('data.deletedAt',"")
						->where('data.parentAnswerFormId',$objectId);
						/*->whereRaw([
							'data.isoUpdatedAt' => ['$gt' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						]);*/
		$answerFormsLv1ObjectId = $answerFormsLv1->pluck('data.objectId');
		$answerFormsLv1Updated = $answerFormsLv1->update($updated);

		$answerFormsLv2 = DB::collection('answerForm')
						->where('data.deletedAt',"")
						->whereIn('data.parentAnswerFormId',$answerFormsLv1ObjectId);
						/*->whereRaw([
							'data.isoUpdatedAt' => ['$gt' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						]);*/
		$answerFormsLv2ObjectId = $answerFormsLv2->pluck('data.objectId');
		$answerFormsLv2Updated = $answerFormsLv2->update($updated);

		$answers = DB::collection('answer')
						->where('data.deletedAt',"")
						->where('data.answerFormId',$objectId)
						/*->whereRaw([
							'data.isoUpdatedAt' => ['$gt' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						]);*/
						->update($updated);

		$answersLv1 = DB::collection('answer')
						->where('data.deletedAt',"")
						->whereIn('data.answerFormId',$answerFormsLv1ObjectId)
						/*->whereRaw([
							'data.isoUpdatedAt' => ['$gt' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						]);*/
						->update($updated);

		$answersLv2 = DB::collection('answer')
						->where('data.deletedAt',"")
						->whereIn('data.answerFormId',$answerFormsLv2ObjectId)
						/*->whereRaw([
							'data.isoUpdatedAt' => ['$gt' => $isoDateStartQuery , '$lt' => $isoDateEndQuery ]
						]);*/
						->update($updated);

		$answerFormsCheckFlat[]['data'] = [
			'objectId' => $objectId,
			"objectType" => "answerForm",
			'status' => 'insert'
		];

		if (!empty($answerFormsLv1ObjectId)) {
			foreach ($answerFormsLv1ObjectId as $answerFormsLv1ObjectIds) {
				$answerFormsCheckFlat[]['data'] = [
					'objectId' => $answerFormsLv1ObjectIds,
					"objectType" => "answerForm",
					'status' => 'insert'
				];
			}
		}


		if (!empty($answerFormsLv2ObjectId)) {
			foreach ($answerFormsLv2ObjectId as $answerFormsLv2ObjectIds) {
				$answerFormsCheckFlat[]['data'] = [
					'objectId' => $answerFormsLv2ObjectIds,
					"objectType" => "answerForm",
					'status' => 'insert'
				];
			}
		}

		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
	}

	public function addAnswerFormIdValue($page_num) {
		$formId = '20180420044238-545892158295872-1326596';
		$wrongAnswerForms = [];
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
        $startDate2561 = new \MongoDate(strtotime("2018-06-01 00:00:00"));
		$endDate2561 = new \MongoDate(strtotime("2019-03-31 00:00:00"));
		$page_size = 100000;
		$skips = $page_size * ($page_num - 1);
		$updated = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow
		];
		$answerForms = DB::collection('answerForm')
						->where('data.formId',$formId)
						->whereRaw([
							'data.isoCreatedAt' => ['$gte' => $startDate2561, '$lt' => $endDate2561]
						])
						->where('data.deletedAt','')
						->orderBy('data.isoCreatedAt','ASC')
						->skip($skips)
						->take($page_size)
						->pluck('data');
	
		if (!empty($answerForms)) {
			foreach ($answerForms as $answerForm) {
				$answers = DB::collection('answer')
							->where('data.answerFormIdValue',$answerForm['objectId'])
							->where('data.deletedAt','')
							->get();

				if (empty($answers)) {
					$wrongAnswerForms[] = $answerForm;
				}
			}
	
			
			if (!empty($wrongAnswerForms)) {
				$answerFormIdValue = [];
				$answerFormsCheckFlat = [];
				foreach ($wrongAnswerForms as $wrongAnswerForm) {
					$answerFormIdValue[]['data'] = [
						"choiceId" => "",
						"answerFormIdValue" => $wrongAnswerForm['objectId'],
						"dateValue" => 0,
						"deletedBy" => "",
						"answerMasterListDetailId" => "",
						"questionId" => "20180420050130-545893290063516-1424194",
						"createdAt" => $wrongAnswerForm['createdAt'],
						"orderIndex" => 0,
						"objectType" => "answer",
						"imagePath" => "",
						"latitude" => null,
						"thumbnailImagePath" => "",
						"updatedBy" => $wrongAnswerForm['updatedBy'],
						"deletedAt" => "",
						"updatedAt" => $datenow,
						"objectId" => generateObjectId(),
						"longtitude" => null,
						"answerFormId" => $wrongAnswerForm['parentAnswerFormId'],
						"doubleValue" => 0,
						"createdBy" => $wrongAnswerForm['createdBy'],
						"integerValue" => 0,
						"stringValue" => "",
						"isoCreatedAt" => $wrongAnswerForm['isoCreatedAt'],
						"isoUpdatedAt" => $isoDatenow
					];
				}

				$objectId = array_column($wrongAnswerForms, 'objectId');
				$parentAnswerFormId = array_column($wrongAnswerForms, 'parentAnswerFormId');
				
				DB::collection('answer')->insert($answerFormIdValue);

				$answerForms = DB::collection('answerForm')
								->whereIn('data.objectId',$objectId)
								->update($updated);

				$answerFormsLv1 = DB::collection('answerForm')
								->whereIn('data.objectId',$parentAnswerFormId)
								->update($updated);

				if (!empty($objectId)) {
					foreach ($objectId as $objectIds) {
						$answerFormsCheckFlat[]['data'] = [
							'objectId' => $objectIds,
							"objectType" => "answerForm",
							'status' => 'insert'
						];
					}
				}


				if (!empty($parentAnswerFormId)) {
					foreach ($parentAnswerFormId as $parentAnswerFormIds) {
						$answerFormsCheckFlat[]['data'] = [
							'objectId' => $parentAnswerFormIds,
							"objectType" => "answerForm",
							'status' => 'insert'
						];
					}
				}

				DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
			}
		}
	}

	public function unmarkDelete() {
		$wrongAnswerForms = [];
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);

		$objectId = [
			'20180430210450-052943562636047-0230496',
			'20180430210450-525866027647082-7090694',
			'20180608170640-568911849924598-0522315'
		];

		$updated = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => "",
			'data.deletedBy' => "",
			#"data.adminLock" => true
		];

		foreach ($objectId as $objectIds) {
			DB::collection('answerForm')
							->where('data.objectId',$objectIds)
							->update($updated);

			DB::collection('answer')
							->where('data.answerFormId',$objectIds)
							->update($updated);

			DB::collection('answer')
							->where('data.answerFormIdValue',$objectIds)
							->update($updated);

			$answerFormsCheckFlat[]['data'] = [
					'objectId' => $objectIds,
					"objectType" => "answerForm",
					'status' => 'update'
				];
		}

		DB::collection('answerForm')
				->where('data.objectId',"20180430210448-633251159045206-1526448")
				->update($updated);

		$answerFormsCheckFlat[]['data'] = [
			'objectId' => "20180430210448-633251159045206-1526448",
			"objectType" => "answerForm",
			'status' => 'update'
		];
		
		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
	}

	public function switchDetailTree() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
        $startDate2562 = new \MongoDate(strtotime("2019-01-01 00:00:00"));
		$PLACETWODOTSEVEN = "20180531022003-549426003906002-1090671";
		$PLACETWODOTEIGHT = "20180601063652-54952781268103-1816339";
		$TREE_NUMBER = "20180316002949-542852989581274-1195308";
		$questionIdInner = "20180308040338-542174618782465-1392449";

		$answerForms7 = DB::collection('flatData')
						->where('parentAnswerFormId',$PLACETWODOTSEVEN)
						->where('20180316003408-542853248662776-1056353','exists',true)
						->orderBy($TREE_NUMBER,"ASC")
						->pluck('objectId');
				
		$answerForms8 = DB::collection('flatData')
						->where('parentAnswerFormId',$PLACETWODOTEIGHT)
						->where('20180316003408-542853248662776-1056353','exists',true)
						->orderBy($TREE_NUMBER,"ASC")
						->pluck('objectId');

		$answerForms7IdValue = DB::collection('answer')
					->where('data.deletedAt',"")
					->whereIn('data.answerFormId',$answerForms7)
					->where('data.questionId',"20180316003408-542853248662776-1056353")
					->whereRaw([
						'data.isoCreatedAt' => ['$gte' => $startDate2562]
					])
					->pluck('data.answerFormIdValue');		

		$answerForms8IdValue = DB::collection('answer')
					->where('data.deletedAt',"")
					->whereIn('data.answerFormId',$answerForms8)
					->where('data.questionId',"20180316003408-542853248662776-1056353")
					->whereRaw([
						'data.isoCreatedAt' => ['$gte' => $startDate2562]
					])
					->pluck('data.answerFormIdValue');
					
		
		for ($i=0;$i<count($answerForms7IdValue);$i++) {
			if (!empty($answerForms8[$i])) {
				$innerAnswerForms7Update = DB::collection('answerForm')
									->where('data.deletedAt',"")
									->where('data.objectId',$answerForms7IdValue[$i])
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.parentAnswerFormId' => $answerForms8[$i]
									]);

				$answer7Update = DB::collection('answer')
									->where('data.deletedAt',"")
									->where('data.answerFormIdValue',$answerForms7IdValue[$i])
									->where('data.questionId',"20180316003408-542853248662776-1056353")
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.answerFormId' => $answerForms8[$i]
									]);
			}
		}

		for ($i=0;$i<count($answerForms8IdValue);$i++) {
			if (!empty($answerForms7[$i])) {
				$innerAnswerForms8Update = DB::collection('answerForm')
									->where('data.deletedAt',"")
									->where('data.objectId',$answerForms8IdValue[$i])
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.parentAnswerFormId' => $answerForms7[$i]
									]);
				$answer8Update = DB::collection('answer')
									->where('data.deletedAt',"")
									->where('data.answerFormIdValue',$answerForms8IdValue[$i])
									->where('data.questionId',"20180316003408-542853248662776-1056353")
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.answerFormId' => $answerForms7[$i]
									]);
									
			}
		}

		if (!empty($answerForms7)) {
			$innerForms7Update = DB::collection('answerForm')
								->where('data.deletedAt',"")
								->whereIn('data.objectId',$answerForms7)
								->update([
									'data.updatedAt' => $datenow,
									'data.isoUpdatedAt' => $isoDatenow,
									'data.parentAnswerFormId' => $PLACETWODOTEIGHT
								]);
			$answerInner7Update = DB::collection('answer')
									->where('data.deletedAt',"")
									->whereIn('data.answerFormIdValue',$answerForms7)
									->where('data.questionId',$questionIdInner)
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.answerFormId' => $PLACETWODOTEIGHT
									]);		
		}

		if (!empty($answerForms8)) {
			$innerForms8Update = DB::collection('answerForm')
								->where('data.deletedAt',"")
								->whereIn('data.objectId',$answerForms8)
								->update([
									'data.updatedAt' => $datenow,
									'data.isoUpdatedAt' => $isoDatenow,
									'data.parentAnswerFormId' => $PLACETWODOTSEVEN
								]);

			$answerInner8Update = DB::collection('answer')
									->where('data.deletedAt',"")
									->whereIn('data.answerFormIdValue',$answerForms8)
									->where('data.questionId',$questionIdInner)
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.answerFormId' => $PLACETWODOTSEVEN
									]);
		}
		$answerFormsCheckFlat = [];

		foreach ($answerForms7 as $answerForm7) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $answerForm7,
				'status' => "update"
			];
		}

		foreach ($answerForms8 as $answerForm8) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $answerForm8,
				'status' => "update"
			];
		}

		foreach ($answerForms7IdValue as $answerForm7IdValue) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $answerForm7IdValue,
				'status' => "update"
			];
		}

		foreach ($answerForms8IdValue as $answerForm8IdValue) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $answerForm8IdValue,
				'status' => "update"
			];
		}

		$answerFormsCheckFlat[]['data'] = [
			'objectId' => $PLACETWODOTSEVEN,
			'status' => "update"
		];

		$answerFormsCheckFlat[]['data'] = [
			'objectId' => $PLACETWODOTEIGHT,
			'status' => "update"
		];

		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
	}
	
	public function unmarkDeleteTree($objectId) {
		#20180430210459-344371421280947-1579768
		#20180430170449-578041346940666-8213863
		
		$answerForms = DB::collection('answerForm')
						->where('data.objectId',$objectId)
						->first();

		
			$deletedAt = $answerForms['data']['deletedAt'];
			$parentAnswerFormId = $answerForms['data']['parentAnswerFormId'];

				$datenow = date('Y-n-d H:i:s');
				$isoDatenow = isoDateConvert($datenow);
				$answerFormsCheckFlat = [];

				DB::collection('answerForm')
					->where('data.deletedAt',"")
					->where('data.objectId',$parentAnswerFormId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow
					]);

				DB::collection('answer')
					->where('data.answerFormIdValue',$objectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => "",
						'data.deletedBy' => ""
					]);

				DB::collection('answerForm')
					->where('data.objectId',$objectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => "",
						'data.deletedBy' => ""
					]);

				DB::collection('answer')
					->where('data.answerFormId',$objectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => "",
						'data.deletedBy' => ""
					]);
				
				$innerForms = DB::collection('answerForm')
					->where('data.parentAnswerFormId',$objectId);
				
				$innerFormsObjectId = $innerForms->pluck('data.objectId');
				$innerFormsUpdate = $innerForms->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => "",
						'data.deletedBy' => ""
					]);

				DB::collection('answer')
					->whereIn('data.answerFormId',$innerFormsObjectId)
					->update([
						'data.updatedAt' => $datenow,
						'data.isoUpdatedAt' => $isoDatenow,
						'data.deletedAt' => "",
						'data.deletedBy' => ""
					]);

				$answerFormsCheckFlat[]['data'] = [
					'objectId' => $parentAnswerFormId,
					'status' => "insert"
				];

				$answerFormsCheckFlat[]['data'] = [
					'objectId' => $objectId,
					'status' => "insert"
				];

				if (!empty($innerFormsObjectId)) {
					foreach ($innerFormsObjectId as $innerFormObjectId) {
						$answerFormsCheckFlat[]['data'] = [
							'objectId' => $innerFormObjectId,
							'status' => "insert"
						];
					}
				}

				DB::collection('checkFlatData')->insert($answerFormsCheckFlat);

				return "success";
	}

	public function changeNumberTree() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$objectId = "20180702032730-552194850986209-1464189";
		$treeNumber = "20180316002949-542852989581274-1195308";
		$answerForms = DB::collection('flatData')
						->where('parentAnswerFormId',$objectId)
						->orderBy("isoCreatedAt","ASC")
						->get();
	
		if (!empty($answerForms)) {
			for ($i=1331;$i<count($answerForms);$i++) {
				if (!empty($answerForms[$i])) {
					$number = strval($i+1);
					$answerPreview = "เลขที่ต้น" ." : ". $number;

					$updateAnswers = DB::collection('answer')
									->where('data.deletedAt',"")
									->where('data.answerFormId',$answerForms[$i]['objectId'])
									->where('data.questionId',$treeNumber)
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.stringValue' => $number
									]);

					$updateAnswerForms = DB::collection('answerForm')
									->where('data.deletedAt',"")
									->where('data.objectId',$answerForms[$i]['objectId'])
									->update([
										'data.updatedAt' => $datenow,
										'data.isoUpdatedAt' => $isoDatenow,
										'data.answerPreview' => $answerPreview
									]);

					$answerFormsCheckFlat[]['data'] = [
						'objectId' => $answerForms[$i]['objectId'],
						'status' => "update"
					];
				}
			}

			$updateMainAnswerForms = DB::collection('answerForm')
							->where('data.deletedAt',"")
							->where('data.objectId',$objectId)
							->update([
								'data.updatedAt' => $datenow,
								'data.isoUpdatedAt' => $isoDatenow,
							]);

			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $objectId,
				'status' => "update"
			];

			DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
		}

		echo "success";
	}

	public function removeDeatailTree() {
		$formId = "20180420042816-5458912969862-1630781";
		$userId = "59bb71f63fd89d0e215aaadb";
		$adminId = "58fd6cc13fd89d8b529e4acf";
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$startDate2562 = new \MongoDate(strtotime("2019-04-01 00:00:00"));
		$objectIdRemoved = [];
		$objectIdUpdated = [];
		$answerFormsCheckFlat = [];
		$remove = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => $datenow,
			'data.deletedBy' => $adminId
		];

		$update = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
		];

		$answerForms = DB::collection('answerForm')
						->where('data.deletedAt',"")
						->where('data.formId',$formId)
						->where('data.createdBy',"59bb71f63fd89d0e215aaadb");	
		$answerFormId = $answerForms->pluck('data.objectId');
		

		$answerFormsLv1 = DB::collection('answerForm')
							->where('data.deletedAt',"")
							->whereIn('data.parentAnswerFormId',$answerFormId);
		$answerFormLv1Id = $answerFormsLv1->pluck('data.objectId');
		


		$answerFormsLv2 = DB::collection('answerForm')
							->where('data.deletedAt',"")
							->whereIn('data.parentAnswerFormId',$answerFormLv1Id)
							->whereRaw([
								'data.isoCreatedAt' => ['$gte' => $startDate2562]
							]);
		$answerFormLv2Id = $answerFormsLv2->pluck('data.objectId');

		$answerFormsLv3 = DB::collection('answerForm')
							->where('data.deletedAt',"")
							->whereIn('data.parentAnswerFormId',$answerFormLv2Id);
		$answerFormLv3Id = $answerFormsLv3->pluck('data.objectId');
		
		$answerFormsUpdate = $answerForms->update($update);
		$answerFormsLv1Update = $answerFormsLv1->update($update);

		$answerFormsLv2Update = $answerFormsLv2->update($remove);
		$answerFormsLv3Update = $answerFormsLv3->update($remove);
		
		$objectIdRemoved = array_merge($answerFormLv2Id,$answerFormLv3Id);

		$answerFormIdValueDelete = DB::collection('answer')
								->timeout(-1)
								->where('data.deletedAt',"")
								->whereIn('data.answerFormIdValue',$objectIdRemoved)
								->update($remove);

		$objectIdUpdated = array_merge($answerFormId,$answerFormLv1Id);

		foreach ($objectIdRemoved as $objectIdRemove) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $objectIdRemove,
				'status' => "delete"
			];
		}

		foreach ($objectIdUpdated as $objectIdUpdate) {
			$answerFormsCheckFlat[]['data'] = [
				'objectId' => $objectIdUpdate,
				'status' => "update"
			];
		}

		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
		
		echo "success";
	}

	public function adminUnLock() {
		$masterObjectId = "20180430220426-964752024693593-1743686"; #PN371
		$objectId = [
			"20180430220426-426464355113516-7041941", #379
			"20180430220426-283230920200054-0317820", #380
			"20180430220426-243766659680783-7319152", #381
			"20180430220426-154241883063081-4250232", #382
			"20180430220426-786178779929311-7621770", #383
			"20180430220426-622875659674228-1766816", #384
			"20180430220426-060469923480891-4201484", #385
			"20180430220426-478685332260276-6292853", #386
			"20180430220426-596573564919237-5832820"  #387
		];

		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);

		$answerForms = DB::collection('answerForm')
						->whereIn('data.parentAnswerFormId',$objectId)
						->where('data.deletedAt',"")
						->orderBy('data.isoCreatedAt',"ASC")
						->update([
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow,
							'data.adminLock' => false
						]);

		$answerForms = DB::collection('answerForm')
						->whereIn('data.objectId',$objectId)
						->where('data.deletedAt',"")
						->update([
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow,
						]);

		$mainForms = DB::collection('answerForm')
						->where('data.objectId',$masterObjectId)
						->where('data.deletedAt',"")
						->update([
							'data.updatedAt' => $datenow,
							'data.isoUpdatedAt' => $isoDatenow,
						]);
		
		echo "success";
	}

	public function orderbyTree() {
		$objectIds = [
			'20180430220426-964752024693593-1743686' #PN366
		];
		$answerFormsCheckFlat = [];
		$treeId = "20180420043952-545891992032667-1260127";
		$date = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($date);

		foreach ($objectIds as $objectId) {
			$answerForms = DB::collection('flatData')
							->where('parentAnswerFormId',$objectId)
							->get();

			if (!empty($answerForms)) {
				array_multisort(array_map(function($element) use ($treeId) {
					if (empty($element[$treeId])) {
						$element[$treeId] = "";
					}
					return strtolower(dataToValue($element[$treeId]));
				}, $answerForms), SORT_ASC, $answerForms);

				for ($i=0;$i<count($answerForms);$i++) {
					$updatedOrderIndex = DB::collection('answer')
										->where('data.answerFormIdValue',$answerForms[$i]['objectId'])
										->where('data.deletedAt',"")				
										->update([
											'data.updatedAt' => $date,
											'data.isoUpdatedAt' => $isoDatenow,
											'data.orderIndex' => $i
										]);
				}

				$answerForms = DB::collection('answerForm')
								->where('data.objectId',$objectId)
								->where('data.deletedAt',"")
								->update([
									'data.updatedAt' => $date,
									'data.isoUpdatedAt' => $isoDatenow
								]);
				
				// $answerFormsCheckFlat[]['data'] = [
				// 	"objectId" => $objectId, 
				// 	"objectType" => "answerForm", 
				// 	"status" => "update"
				// ];
				
			}
		}
		
		
		// DB::collection('checkFlatData')->insert($answerFormsCheckFlat);

		echo "Success !";
	}

	public function clearAnswers() {
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
		$TOP_BRANCH = '20180420044505-545892305313971-1194988'; #ผ่านการเสียบยอดพันธุ์ดีหรือไม่ (Type 2)
		$IDENTYFY_OUT = '20180627105116-55178947694238-1765190'; #ระบุสาเหตุที่เอาต้นชาน้ำมันออกไป (Type 0)
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$adminId = "58fd6cc13fd89d8b529e4acf";
		$remove = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => $datenow,
			'data.deletedBy' => $adminId
		];

		$update = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
		];
		
		// $gradesEmptyHoles = DB::collection('flatData')->Where(function($query) use ($GRADE_OF_TREE,$LEVEL2_FORMID) {
		// 	$query->where('formId', $LEVEL2_FORMID)
		// 		  ->Where(function($query) use ($GRADE_OF_TREE) {
		// 			$query->orWhere($GRADE_OF_TREE, "หลุมว่าง")
		// 				  ->orWhere($GRADE_OF_TREE, "ต้นตาย/เอาออก");
		// 		  });
		// })->Where(function($query) use (
		// 	$HEIGHT_TREE,
		// 	$DIAMETER,
		// 	$BRANCH_TREE,
		// 	$NATURE_SHAPE,
		// 	$OTHER_SHAPE,
		// 	$IMAGE_TREE,
		// 	$REPAIR_YEAR,
		// 	$TYPE_REPAIR,
		// 	$TOP_BRANCH,
		// 	$IDENTYFY_OUT ) {
		// 	$query->orWhere($HEIGHT_TREE, 'exists', true)
		// 		->orWhere($DIAMETER, 'exists', true)
		// 		->orWhere($BRANCH_TREE, 'exists', true)
		// 		->orWhere($NATURE_SHAPE, 'exists', true)
		// 		->orWhere($OTHER_SHAPE, 'exists', true)
		// 		->orWhere($IMAGE_TREE, 'exists', true)
		// 		->orWhere($REPAIR_YEAR, 'exists', true)
		// 		->orWhere($TYPE_REPAIR, 'exists', true)
		// 		->orWhere($TOP_BRANCH, 'exists', true)
		// 		->orWhere($IDENTYFY_OUT, 'exists', true);
		// })
		// ->get();
	
		// if (!empty($gradesEmptyHoles)) {
		// 	$answerFormsCheckFlat = [];
		// 	foreach ($gradesEmptyHoles as $gradesEmptyHole) {
		// 		$deletedAnswerForms = DB::collection('answerForm')
		// 								->where('data.objectId',$gradesEmptyHole['objectId'])
		// 								->where('data.deletedAt',"")
		// 								->update($update);
				
		// 		$deletedAnswers = DB::collection('answer')
		// 							->where('data.answerFormId',$gradesEmptyHole['objectId'])
		// 							->where('data.deletedAt',"")
		// 							->orWhere('data.questionId',$HEIGHT_TREE)
		// 							->orWhere('data.questionId',$DIAMETER)
		// 							->orWhere('data.questionId',$BRANCH_TREE)
		// 							->orWhere('data.questionId',$NATURE_SHAPE)
		// 							->orWhere('data.questionId',$OTHER_SHAPE)
		// 							->orWhere('data.questionId',$IMAGE_TREE)
		// 							->orWhere('data.questionId',$REPAIR_YEAR)
		// 							->orWhere('data.questionId',$TYPE_REPAIR)
		// 							->orWhere('data.questionId',$TOP_BRANCH)
		// 							->orWhere('data.questionId',$IDENTYFY_OUT)
		// 							->update($remove);
				
		// 		$answerFormsCheckFlat[]['data'] = [
		// 			'objectId' => $gradesEmptyHole['objectId'],
		// 			'status' => "update"
		// 		];
		// 	}

		// 	DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
		// }

		// $gradesTreeFixs = DB::collection('flatData')->Where(function($query) use ($GRADE_OF_TREE,$LEVEL2_FORMID) {
		// 	$query->where('formId', $LEVEL2_FORMID)
		// 		  ->Where(function($query) use ($GRADE_OF_TREE) {
		// 			$query->orWhere($GRADE_OF_TREE, "ปลูกซ่อม");
		// 		  });
		// })->Where(function($query) use (
		// 	$HEIGHT_TREE,
		// 	$DIAMETER,
		// 	$BRANCH_TREE,
		// 	$NATURE_SHAPE,
		// 	$OTHER_SHAPE,
		// 	$IMAGE_TREE,
		// 	$TOP_BRANCH,
		// 	$IDENTYFY_OUT ) {
		// 	$query->orWhere($HEIGHT_TREE, 'exists', true)
		// 		->orWhere($DIAMETER, 'exists', true)
		// 		->orWhere($BRANCH_TREE, 'exists', true)
		// 		->orWhere($NATURE_SHAPE, 'exists', true)
		// 		->orWhere($OTHER_SHAPE, 'exists', true)
		// 		->orWhere($TOP_BRANCH, 'exists', true)
		// 		->orWhere($IDENTYFY_OUT, 'exists', true);
		// })
		// ->get();

		// if (!empty($gradesTreeFixs)) {
		// 	$answerFormsCheckFlat = [];
		// 	foreach ($gradesTreeFixs as $gradesTreeFix) {
		// 		$deletedAnswerForms = DB::collection('answerForm')
		// 								->where('data.objectId',$gradesTreeFix['objectId'])
		// 								->where('data.deletedAt',"")
		// 								->update($update);
				
		// 		$deletedAnswers = DB::collection('answer')
		// 							->where('data.answerFormId',$gradesTreeFix['objectId'])
		// 							->where('data.deletedAt',"")
		// 							->orWhere('data.questionId',$HEIGHT_TREE)
		// 							->orWhere('data.questionId',$DIAMETER)
		// 							->orWhere('data.questionId',$BRANCH_TREE)
		// 							->orWhere('data.questionId',$NATURE_SHAPE)
		// 							->orWhere('data.questionId',$OTHER_SHAPE)
		// 							->orWhere('data.questionId',$TOP_BRANCH)
		// 							->orWhere('data.questionId',$IDENTYFY_OUT)
		// 							->update($remove);

		// 		$answerFormsCheckFlat[]['data'] = [
		// 			'objectId' => $gradesTreeFix['objectId'],
		// 			'status' => "update"
		// 		];
		// 	}

		// 	DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
		// }

		// $gradesNaturals = DB::collection('flatData')->Where(function($query) use ($GRADE_OF_TREE,$LEVEL2_FORMID) {
		// 	$query->where('formId', $LEVEL2_FORMID)
		// 		  ->Where(function($query) use ($GRADE_OF_TREE) {
		// 			$query->orWhere($GRADE_OF_TREE, "A1 : ลำต้นใหญ่ ให้ผลผลิตดี (>100)")
		// 				  ->orWhere($GRADE_OF_TREE, "A2 : ลำต้นไม่ใหญ่ ให้ผลผลิตดี (>100)")
		// 				  ->orWhere($GRADE_OF_TREE, "B1 : ลำต้นใหญ่ ให้ผลผลิตไม่ค่อยดี (50 - 99)")
		// 				  ->orWhere($GRADE_OF_TREE, "B2 : ลำต้นไม่ใหญ่ ให้ผลผลิตไม่ค่อยดี (50 - 99)")
		// 				  ->orWhere($GRADE_OF_TREE, "C1 : ลำต้นใหญ่  ให้ผลผลิต 1-49")
		// 				  ->orWhere($GRADE_OF_TREE, "C2 : ลำต้นไม่ใหญ่  ให้ผลผลิต 1-49")
		// 				  ->orWhere($GRADE_OF_TREE, "D1 : ลำต้นใหญ่ ไม่ให้ผลผลิต)")
		// 				  ->orWhere($GRADE_OF_TREE, "D2 : ลำต้นไม่ใหญ่ ไม่ให้ผลผลิต");
		// 		  });
		// })->Where(function($query) use ($REPAIR_YEAR,$TYPE_REPAIR,$IDENTYFY_OUT) {
		// 	$query->orWhere($REPAIR_YEAR, 'exists', true)
		// 		  ->orWhere($TYPE_REPAIR, 'exists', true)
		// 	      ->orWhere($IDENTYFY_OUT, 'exists', true);
		// })
		// ->get();

		// if (!empty($gradesNaturals)) {
		// 	$answerFormsCheckFlat = [];
		// 	foreach ($gradesNaturals as $gradesNatural) {
		// 		$deletedAnswerForms = DB::collection('answerForm')
		// 								->where('data.objectId',$gradesNatural['objectId'])
		// 								->where('data.deletedAt',"")
		// 								->update($update);

		// 		$deletedAnswers = DB::collection('answer')
		// 							->where('data.answerFormId',$gradesNatural['objectId'])
		// 							->where('data.deletedAt',"")
		// 							->orWhere('data.questionId',$REPAIR_YEAR)
		// 							->orWhere('data.questionId',$TYPE_REPAIR)
		// 							->orWhere('data.questionId',$IDENTYFY_OUT)
		// 							->update($remove);
	
		// 		$answerFormsCheckFlat[]['data'] = [
		// 			'objectId' => $gradesNatural['objectId'],
		// 			'status' => "update"
		// 		];
		// 	}

		// 	DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
		// }
	}

	// public function adminUnlockForms() {
	// 	$datenow = date('Y-n-d H:i:s');
	// 	$isoDatenow = isoDateConvert($datenow);
	// 	$PLACE = "20180308032457-542172297844251-1326614";
	// 	$TREE_NUMBER = "20180316002949-542852989581274-1195308";
	// 	$update = [
	// 		'data.updatedAt' => $datenow,
	// 		'data.isoUpdatedAt' => $isoDatenow,
	// 		'data.adminLock' => false
	// 	];
	// 	$sunkongs = DB::collection('flatData')
	// 				->where($PLACE,"สันโค้ง")
	// 				->pluck('objectId');
	
	// 	if (!empty($sunkongs)) {
	// 		foreach ($sunkongs as $sunkong) {
	// 			$innerFormsLv1 = DB::collection('answerForm')
	// 							->where('data.deletedAt',"")
	// 							->where('data.parentAnswerFormId',$sunkong)
	// 							->pluck('data.objectId');

	// 			if (!empty($innerFormsLv1)) {
	// 				foreach ($innerFormsLv1 as $innerFormLv1) {
	// 					$unlock = DB::collection('answer')
	// 									->where('data.deletedAt',"")
	// 									->where('data.answerFormId',$innerFormLv1)
	// 									->where('data.questionId',$TREE_NUMBER)
	// 									->update($update);

	// 					$updateInner = DB::collection('answerForm')
	// 							->where('data.deletedAt',"")
	// 							->where('data.objectId',$innerFormLv1)
	// 							->update([
	// 								'data.updatedAt' => $datenow,
	// 								'data.isoUpdatedAt' => $isoDatenow
	// 							]);
	// 				}

	// 				$updateMain = DB::collection('answerForm')
	// 								->where('data.deletedAt',"")
	// 								->where('data.objectId',$sunkong)
	// 								->update([
	// 									'data.updatedAt' => $datenow,
	// 									'data.isoUpdatedAt' => $isoDatenow
	// 								]);
	// 			}
	// 		}
	// 	}

	// 	echo "finish";
	// }

	// public function clearDupGrade() {
	// 	$datenow = date('Y-n-d H:i:s');
	// 	$isoDatenow = isoDateConvert($datenow);
	// 	$adminId = "58fd6cc13fd89d8b529e4acf";
	// 	$GRADE_OF_TREE = '20180420044320-545892200765139-1063742'; 
	// 	$objectIds = [
	// 		"20190608091300-581677980546172-1165932",
	// 		"20190617054859-582443339366298-1243925"
	// 	];
		
	// 	$remove = [
	// 		'data.updatedAt' => $datenow,
	// 		'data.isoUpdatedAt' => $isoDatenow,
	// 		'data.deletedAt' => $datenow,
	// 		'data.deletedBy' => $adminId
	// 	];

		
	// 	$update = [
	// 		'data.updatedAt' => $datenow,
	// 		'data.isoUpdatedAt' => $isoDatenow,
	// 	];

	// 	foreach ($objectIds as $objectId) {
	// 		$answers = DB::collection('answer')
	// 					->where('data.deletedAt',"")
	// 					->where('data.answerFormId',$objectId)
	// 					->where('data.questionId',$GRADE_OF_TREE)
	// 					->orderBy('data.isoCreatedAt','ASC')
	// 					->limit(1)
	// 					->update($remove);

	// 		$answerForms = DB::collection('answerForm')
	// 						->where('data.deletedAt',"")
	// 						->where('data.objectId',$objectId)
	// 						->update($update);

	// 		$answerFormsCheckFlat[]['data'] = [
	// 			'objectId' => $objectId,
	// 			'status' => "update"
	// 		];
	// 	}

	// 	DB::collection('checkFlatData')->insert($answerFormsCheckFlat);
	// }

	public function fixBreed() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$PLACE = '20180308032457-542172297844251-1326614';
        $NAWUT_SITE = '20180314031543-542690143426476-1905201';
		$NAWUT_SITE2 = '20180613014543-550547143676435-1068222';
		$BREED_TREE = '20180308034756-542173676472791-1401973';
		$TREE_NUMBER = "20180316002949-542852989581274-1195308";
		$answerFormsCheckFlat = [];
		$startdate2561 = new \MongoDate(strtotime("2018-06-01 00:00:00"));
		$enddate2561 = new \MongoDate(strtotime("2019-03-29 00:00:00"));
		$date2562 = new \MongoDate(strtotime("2019-05-01 00:00:00"));

		$nawuttis13 = DB::collection('flatData')
					->where($PLACE,"นวุติ")
					->where($NAWUT_SITE,"2")
					->Where($NAWUT_SITE2,"1.3")
					->pluck('objectId');
		
		if (!empty($nawuttis13)) {
			dd($nawuttis13);
			foreach ($nawuttis13 as $nawutti13) {
				$nawuttis13Inners = DB::collection('flatData')
									->where('parentAnswerFormId',$nawutti13)
									->whereIn($TREE_NUMBER,[
										"10","37","53","54","80","85","139","150","152"
									])
									->pluck('objectId');
				
				if (!empty($nawuttis13Inners)) {
					foreach ($nawuttis13Inners as $nawuttis13Inner) {
						$checkListAnswerForm2562 = DB::collection('answerForm')
											->where('data.deletedAt',"")
											->where('data.parentAnswerFormId',$nawuttis13Inner)
											->whereRaw([
												'data.isoCreatedAt' => ['$gte' => $date2562]
											])
											->first();
						
						if (count($checkListAnswerForm2562) > 0) {
							$breed2562 = DB::collection('answer')
										->where('data.deletedAt',"")
										->where('data.answerFormId',$checkListAnswerForm2562['data']['objectId'])
										->where('data.questionId',$BREED_TREE)
										->first();

							$checkListAnswerForm2561 = DB::collection('answerForm')
										->where('data.deletedAt',"")
										->where('data.parentAnswerFormId',$nawuttis13Inner)
										->whereRaw([
											'data.isoCreatedAt' => ['$gte' => $startdate2561, '$lt' => $enddate2561]
										])
										->first();
							
							if (count($checkListAnswerForm2561) > 0) {
								// $breed2562 = DB::collection('answer')
								// 				->where('data.deletedAt',"")
								// 				->where('data.answerFormId',$checkListAnswerForm2561['data']['objectId'])
								// 				->where('data.questionId',$BREED_TREE)
								// 				->update()

								// $checkListAnswerForm2561 = DB::collection('answerForm')
								// 				->where('data.deletedAt',"")
								// 				->where('data.objectId',$checkListAnswerForm2561['data']['objectId'])
								// 				->update()

								// $answerFormsCheckFlat[]['data'] = [
								// 	'objectId' => $checkListAnswerForm2561['data']['objectId'],
								// 	'status' => "update"
								// ];
							}
						}
					}
				}
			}
		}
	}

	public function fixShape() {
		$datenow = date('Y-n-d H:i:s');
		$isoDatenow = isoDateConvert($datenow);
		$adminId = "58fd6cc13fd89d8b529e4acf";
		$remove = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
			'data.deletedAt' => $datenow,
			'data.deletedBy' => $adminId
		];
		$update = [
			'data.updatedAt' => $datenow,
			'data.isoUpdatedAt' => $isoDatenow,
		];
		$formId = "20180420044238-545892158295872-1326596";
		$SHAPE = "20180420044654-545892414578524-1389900";

		$answerFormsCheckFlat = [];
		$objectIds = [
			"20190520045054-580020654028116-1715853",
			"20190520142652-580055212653678-1156483",
			"20190530023453-580876493696553-1571786",
			"20190528075854-580723134395433-1588351",
			"20190721125311-585406391359422-1699163",
			"20190721145204-58541352405191-1347122",
			"20190721144322-585413002769774-1708230",
			"20190721145109-585413469884068-1875326",
			"20190725082825-585736105788231-1970068",
			"20190727044407-585895447659984-1469699",
			"20190727031358-585890038327297-1726257",
			"20190727032640-585890800539893-1843942",
			"20190727122751-585923271367899-1887854",
			"20190727113627-585920187830407-1240056",
			"20190727113056-585919856489448-1241189",
			"20190727071228-58590434891385-1784434",
			"20190727071150-585904310213318-1186470",
			"20190727013223-585883943141469-1487437",
			"20190729091637-586084597440314-1216678",
			"20190729040430-58606587024241-1885464",
			"20190731103621-586262181576581-1337210",
			"20190731104058-586262458852739-1283465",
			"20190801062956-586333796275058-1143318",
			"20190801064737-586334857605747-1782181",
			"20190801063829-586334309672727-1930476",
			"20190801031827-586322307479914-1458283",
			"20190801034408-586323848629991-1890524",
			"20190802132743-586445263601047-1282457",
			"20190802132813-586445293869059-1604326",
			"20190802133007-586445407570856-1010137",
			"20190802131526-586444526345638-1438170",
			"20190802124434-586442674305166-1497032",
			"20190802130215-586443735203762-1110731",
			"20190802125848-58644352813124-1545026",
			"20190802124253-586442573985824-1687692",
			"20190802121953-586441193477183-1778619",
			"20190802122622-586441582505986-1527755",
			"20190802121247-586440767664709-1256398",
			"20190802123802-586442282927064-1417673",
			"20190803051615-586502175832425-1967361",
			"20190803042050-5864988505028-1803447",
			"20190804091334-586602814209567-1409329",
			"20190803132335-586531415171298-1563913",
			"20190803131023-586530623718367-1378707",
			"20190805035511-58667011176675-1635649",
			"20190805035603-58667016306815-1657687",
			"20190805032051-586668051793792-1729685",
			"20190729100846-586087726741716-1465176",
			"20190812075318-587289198440919-1079482",
			"20190818110840-587819320466651-1907380"
		];
		
		foreach ($objectIds as $objectId) {
			$answers = DB::collection('answer')
						->where('data.deletedAt',"")
						->where('data.answerFormId',$objectId)
						->where('data.questionId',$SHAPE)
						->orderBy('data.isoCreatedAt',"ASC")
						->first();

			$updateAnswers = DB::collection('answer')
							->where('data.deletedAt',"")
							->where('data.objectId',$answers['data']['objectId'])
							->update($remove);

			$answerForms = DB::collection('answerForm')
							->where('data.objectId',$objectId)
							->where('data.deletedAt',"")
							->update($update);
					
			$answerFormsCheckFlat[]['data'] = [
				"objectId" => $objectId, 
				"objectType" => "answerForm", 
				"status" => "update"
			];
		}

		DB::collection('checkFlatData')->insert($answerFormsCheckFlat);

		echo "success";
	}
}