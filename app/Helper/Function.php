<?php

	use App\User;
	use App\Masterdata;
	use Carbon\Carbon;


	#convert ISODate
    function isoDateConvert($date) {
        $data = new \MongoDate(strtotime($date));
            return $data;
    }

	#dowload json file
	function downloadJson($data){
		#data เป็น set ของ array
		$fileName = time() . '-jsonPackage.json';
            \File::put(public_path($fileName),$data);
              return Response::download(public_path($fileName));
	}

	function generateRandomString($length = 24) {
    	$characters = '0123456789';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    		for ($i = 0; $i < $length; $i++) {
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		}
    	return $randomString;
	}

	function generateMasterDataCollection($length = 10) {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
    		for ($i = 0; $i < $length; $i++) {
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		}
    	return $randomString;
	}

	#change date format
	function changeDateFormat($data) {
		return date($data);
	}

	function dateFormatPattern($data) {
		return date('Y-m-d H:i:s',strtotime($data));
	}

	#นำ array มา merge เพื่อแสดงเป็น response
	function mergeResult($arrs = array()) {

        $list = array();

        foreach($arrs as $arr) {
            if(is_array($arr)) {
               	
                $list = array_merge($list, $arr);

			}
        }

        	return $list;

	}

	#map ข้อมูลที่ซ้ำกัน ให้แสดงเฉพาะ object นั้น
	function mapObject($data) {
		$arrayData = array_map('unserialize',array_unique(array_map('serialize',$data)));

			return $arrayData;
	}

	function findKeyId($id) {

		$form = DB::collection('form')->where('data.objectId',$id);

		$keyId = collect(DB::collection('form')->get())->keyBy('data.objectId');
		$keyId = $keyId->pluck('data.objectId');

		$answerFormFindObject = DB::collection('answerForm')
								->whereIn('data.formId',$keyId);
		$answerFormFindObject = $answerFormFindObject->pluck('data.objectId');

		$answerFindObject = DB::collection('answer')
							->whereIn('data.answerFormId', $answerFormFindObject)
							->get();


			return $answerFindObject;
	}

	

	function DateThai($strDate) {
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("d",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
			return "$strDay $strMonthThai $strYear $strHour:$strMinute น.";
	}

	function DateThaiNotTime($strDate) {
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("d",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
			return "$strDay $strMonthThai $strYear";
	}

	function TimeThai($strDate) {
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
			return "$strHour:$strMinute:$strSeconds น.";
	}

	function checkRoles($id) {
		$adminForm = \Auth::user()->form_ids;
		$questionFormRoleCode = [];
		$answerFormRoleCode = [];
		$roleCode['questionFormRoleCode'] = '';
		$roleCode['answerFormRoleCode']	= '';
	    if (!empty($adminForm)) {
	        foreach ($adminForm as $adminForms) {
	            if ($adminForms['form_id'] == $id) {
	                $questionFormRoleCode[] = $adminForms['questionFormRoleCode'];
					$answerFormRoleCode[] = $adminForms['answerFormRoleCode'];
	            }
	        }
		}
		
		$form = DB::collection('form')->where('data.objectId',$id)->first();
		$groupForms = \Auth::user()->group_ids;
		if (!empty($groupForms)) {
			foreach ($groupForms as $groupform) {
				if (!empty($form['group_ids'])) {
					foreach ($form['group_ids'] as $forms) {
						if ($forms['group_id'] == $groupform) {
							$questionFormRoleCode[] = $forms['questionFormRoleCode'];
							$answerFormRoleCode[] = $forms['answerFormRoleCode'];
						}
					}
				}
			}
		}
		$questionFormRoleCode = array_filter($questionFormRoleCode, function($value) {
			return ($value !== null && $value !== false && $value !== ''); 
		});
		$answerFormRoleCode = array_filter($answerFormRoleCode, function($value) {
			return ($value !== null && $value !== false && $value !== ''); 
		});

		if (!empty($questionFormRoleCode)) {
			$questionFormRoleCode = array_diff($questionFormRoleCode, array(null));
			$roleCode['questionFormRoleCode'] = min($questionFormRoleCode);
		}
		if (!empty($answerFormRoleCode)) {
			$answerFormRoleCode = array_diff($answerFormRoleCode, array(null));
			$roleCode['answerFormRoleCode'] = min($answerFormRoleCode);
		}

	    return $roleCode;
	}

	function checkRolesMasterData($id) {
		$masterdataIds = \Auth::user()->masterdata_ids;
		$masterdataRoleCodes = [];
		$roleCode = '';
	    if (!empty($masterdataIds)) {
	        foreach ($masterdataIds as $masterdataId) {
	            if ($masterdataId['masterdata_id'] == $id) {
	                $masterdataRoleCodes[] = $masterdataId['masterdataRoleCode'];
	            }
	        }
		}
		
		$masterdata = Masterdata::where('data.objectId',$id)->firstOrFail();
		$groupIds = \Auth::user()->group_ids;
		if (!empty($groupIds)) {
			foreach ($groupIds as $groupIds) {
				if (!empty($masterdata['group_ids'])) {
					foreach ($masterdata['group_ids'] as $masterdatum) {
						if ($masterdatum['group_id'] == $groupIds) {
							$masterdataRoleCodes[] = $masterdatum['masterdataRoleCode'];
						}
					}
				}
			}
		}

		$masterdataRoleCodes = array_filter($masterdataRoleCodes, function($value) {
			return ($value !== null && $value !== false && $value !== ''); 
		});

		if (!empty($masterdataRoleCodes)) {
			$masterdataRoleCodes = array_diff($masterdataRoleCodes, array(null));
			$roleCode = min($masterdataRoleCodes);
		}

	    return $roleCode;
	}
	
	function array_remove(array &$arr, $key) {
		if (array_key_exists($key, $arr)) {
				$val = $arr[$key];
				unset($arr[$key]);

			return $val;
		}

		return null;
	}

	function markDeleteInner($answerFormId,$activeQuestionId,$choiceId,$innerFormId){
		#set date time for update
        $current = Carbon::tomorrow();
        $date = date_format($current,"Y-n-d H:i:s");
        #เขียนลงไฟล์
        $strFileName = $activeQuestionId .".txt";
		$objFopen = fopen($strFileName, 'a');

        $answers = DB::collection('answer')
                    ->where('data.questionId',$activeQuestionId)
					->where('data.answerFormId',$answerFormId)
					->where('data.choiceId',$choiceId)
                    ->where('data.deletedAt','');
		$answers = $answers->pluck('data');
		
        if (count($answers) > 1) {
			fwrite($objFopen, 'คำตอบมีมากกว่า 1 : '.$answerFormId."\r\n");
        } elseif (count($answers) == 1) {
			
            $answer = DB::collection('answer')
                        ->where('data.questionId',$activeQuestionId)
                        ->where('data.answerFormId',$answerFormId)
                        ->where('data.deletedAt','')
						->first();
	
            if (!empty($answer)) {
                $innerAnswerForms = DB::collection('answerForm')
                                    ->where('data.parentAnswerFormId',$answerFormId)
                                    ->where('data.formId',$innerFormId)
                                    ->where('data.deletedAt','');
				$innerAnswerForms = $innerAnswerForms->pluck('data');
				
				
                foreach($innerAnswerForms as $innerAnswerForm){
					if($innerAnswerForm != null){
						fwrite($objFopen, '----------------------------------------------'."\r\n");
						fwrite($objFopen, 'answerFormId : '.$answerFormId."\r\n");
						fwrite($objFopen, 'activeQuestionId : '.$activeQuestionId."\r\n");
						fwrite($objFopen, 'choiceId : '.$choiceId."\r\n");
						fwrite($objFopen, 'innerFormId : '.$innerFormId."\r\n");
						fwrite($objFopen, 'innerAnswerFormId: '.$innerAnswerForm['objectId']."\r\n");
					}
					#TODO: Mark deletedAt inner answerForm - Have parentAnswerFormId
					$innerAnswerFormId = $innerAnswerForm['objectId'];

					$innerAnswerFormDeletedAt = DB::collection('answerForm')
                            ->where('data.objectId',$innerAnswerFormId)
                            ->update(array(
                                        'data.createdBy' => '59a83a563fd89d7622f9a7eb',
                                        'data.updatedBy' => '59a83a563fd89d7622f9a7eb',
                                        'data.deletedAt' => $date,
                                        'data.deletedBy' => $date,
                                        'data.updatedAt' => $date,
                                        'data.isoUpdatedAt' => isoDateConvert($date),
									));
					fwrite($objFopen, '** delete innerAnswerForm success : '.$innerAnswerFormId."\r\n");
					#TODO: Insert Check FlatData
					$checkFlatData = DB::collection('checkFlatData')
										->where('data.objectId', $innerAnswerFormId)
										->timeout(-1)
										->first();

							if(!isset($checkFlatData)){
								$checkFlatDataObj = array(
												'objectId' => $innerAnswerFormId,
												'objectType' => 'answerForm',
												'status' => 'delete'
											);

								DB::collection('checkFlatData')
									->timeout(-1)
									->insert([array('data'=> $checkFlatDataObj)]);
							}
					fwrite($objFopen, '** insert checkFlat success : '.$innerAnswerFormId."\r\n");
					#-------------------------------------------------------------------#
                    $innerAnswers = DB::collection('answer')
                                    ->where('data.answerFormId',$innerAnswerFormId)
                                    ->where('data.deletedAt','');
					$innerAnswers = $innerAnswers->pluck('data');
					
                    foreach($innerAnswers as $innerAnswer){
						if($innerAnswer != null){
							fwrite($objFopen, 'innerAnswers : '.$innerAnswer['objectId']."\r\n");
						}
						#TODO: Mark deletedAt innerForm
						$innerAnswerId = $innerAnswer['objectId'];

						$innerAnswerDeletedAt = DB::collection('answer')
                            ->where('data.objectId',$innerAnswerId)
                            ->update(array(
                                        'data.createdBy' => '59a83a563fd89d7622f9a7eb',
                                        'data.updatedBy' => '59a83a563fd89d7622f9a7eb',
                                        'data.deletedAt' => $date,
                                        'data.deletedBy' => $date,
                                        'data.updatedAt' => $date,
                                        'data.isoUpdatedAt' => isoDateConvert($date),
									));
					fwrite($objFopen, '** delete innerAnswer success : '.$innerAnswerId."\r\n");
					#-------------------------------------------------------------------#

                    }

                    #find answer ที่เป็นคำตอบของฟอร์มหลัก
                    $answerInnerList  = DB::collection('answer')
                                        ->where('data.answerFormId',$answerFormId)
                                        ->where('data.answerFormIdValue',$innerAnswerFormId)
                                        ->where('data.deletedAt','');
					$answerInnerList = $answerInnerList->pluck('data');
                    foreach($answerInnerList as $innerAnswer){
						if($answerInnerList != null){
							fwrite($objFopen, 'answerInnerList : '.$innerAnswer['objectId']."\r\n");
						}
						#TODO: Mark deleteAt answer
						$answerInnerListId = $innerAnswer['objectId'];
						
						$answerInnerListDeletedAt = DB::collection('answer')
                            ->where('data.objectId',$answerInnerListId)
                            ->update(array(
                                        'data.createdBy' => '59a83a563fd89d7622f9a7eb',
                                        'data.updatedBy' => '59a83a563fd89d7622f9a7eb',
                                        'data.deletedAt' => $date,
                                        'data.deletedBy' => $date,
                                        'data.updatedAt' => $date,
                                        'data.isoUpdatedAt' => isoDateConvert($date),
									));
					fwrite($objFopen, '** delete answerInnerList success : '.$answerInnerListId."\r\n");
					#-------------------------------------------------------------------#

                    }

                }

            }

        }


	}
	
	function dataToValue ($data) {
        if (gettype($data) != 'array') {
            return $data;
        } else {
            return implode(',', $data);
        }
    }

    function arrayToDouble ($data) {
        if (gettype($data) != 'array') {
            return $data;
        } else {
            $data = doubleval(implode(',', $data));
            return $data;
        }
    }

    function arrayToInt ($data) {
        if (gettype($data) != 'array') {
            return $data;
        } else {
            $data = intval(implode(',', $data));
            return $data;
        }
	}
	
	function generateObjectId() {
		$randomNumber = [];
		$randomNumber1 = [];
		for ($i=1;$i<=15;$i++) {
			$randomNumber[$i] = rand(0,9);
		}
		for ($i=1;$i<=7;$i++) {
			$randomNumber1[$i] = rand(0,9);
		}
		
		$datetime = date('YmdHms');
		$objectId = $datetime.'-'.implode($randomNumber).'-'.implode($randomNumber1);

		return $objectId;
	}

	function typeNumber($fields,$question) {
		$fieldDiffer = array_column(array_column($fields,'number'),$question['objectId']);
		$fieldLast = array_filter($fieldDiffer, function($value) {
			return ($value !== null && $value !== false && $value !== 0); 
		});
		return $fieldLast;
	}

	function typeChoice($fields,$question) {
		$mergeChoice = [];
		$fieldDiffer = array_column(array_column($fields,'choice'),$question['objectId']);
		for ($i=0;$i<count($fieldDiffer);$i++) {
			for($n=0;$n<count($fieldDiffer[$i]);$n++) {
				$mergeChoice[] = $fieldDiffer[$i][$n];
			}
		}
		return array_count_values($mergeChoice);
	}