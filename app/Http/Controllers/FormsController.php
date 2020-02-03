<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Group;
use App\Form;
use App\AnswerForm;
use DB;
use Hash;
use Carbon\Carbon;
use Session;
use Redirect;
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;
use Zipper;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Answer;
use log;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', '-1');


class FormsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		$AuthForms = [];
		$forms = [];
		$data = [];
		
		$AuthForms = \Auth::user()->form_ids;
		$groupForms = \Auth::user()->group_ids;
		$search = $request['search'];
		$admin = \Auth::user()->firstname == 'admin';
		if (empty($AuthForms)) {
			$AuthForms = [];
		} if (empty($groupForms)) {
			$groupForms = [];
		}
		$roleCodes = DB::collection('roleCode')->where('type','form')->get();
		
		if (\Auth::user()->firstname == 'admin'){
            if ($search == null){
                $forms = DB::collection('form')->orderBy('_id','ASC');
            } else {
                $forms = DB::collection('form')
                    ->orWhere('data.title','like','%'.$search.'%')
                    ->orderBy('_id','ASC');
            }
			$forms = $forms->get();
		} else {
			if ($search == null){
				$forms = DB::collection('form')
							->where('user_ids.user_id', \Auth::user()->_id)
							->orwhereIn('group_ids.group_id',$groupForms)
							->orderBy('_id','ASC');
			} else {
				$forms = DB::collection('form')
						->where('user_ids.user_id', \Auth::user()->_id)
						->orwhereIn('group_ids.group_id',$groupForms)
						->where('data.title','like','%'.$search.'%')
						->orderBy('_id','ASC');
			}
			$forms = $forms->get();
		} 

		$i = 0;
		foreach ($forms as $form) {
			$questionFormRoleCode = [];
			$answerFormRoleCode = [];
			$data[$i] = [
				'objectId' => $form['data']['objectId'],
				'formDescription' => $form['data']['formDescription'],
				'title' => $form['data']['title'],
				'deletedBy' => $form['data']['deletedBy'],
				'questionForm' => '',
				'answerForm' => '',
			];
			if (!empty($form['user_ids'])) {
				foreach ($form['user_ids'] as $userIds) {
					if ($userIds['user_id'] == \Auth::user()->_id) {
						$questionFormRoleCode[] = $userIds['questionFormRoleCode'];
						$answerFormRoleCode[] = $userIds['answerFormRoleCode'];
					}
				}
			}
			if (!empty($form['group_ids'])) {
				foreach ($form['group_ids'] as $groupIds) {
					if (!empty($groupIds)) {
						foreach ($groupForms as $groupForm) {
							if ($groupIds['group_id'] == $groupForm) {
								$questionFormRoleCode[] = $groupIds['questionFormRoleCode'];
								$answerFormRoleCode[] = $groupIds['answerFormRoleCode'];
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
				$questionFormRoleCode = min($questionFormRoleCode);
			} if (!empty($answerFormRoleCode)) {
				$answerFormRoleCode = array_diff($answerFormRoleCode, array(null));
				$answerFormRoleCode = min($answerFormRoleCode);
			}

			foreach ($roleCodes as $roleCode) {
				if ($roleCode['roleCode'] == $questionFormRoleCode) {
					$data[$i]['questionForm'] = $roleCode['display_name'];
				}
				if ($roleCode['roleCode'] == $answerFormRoleCode) {
					$data[$i]['answerForm'] = $roleCode['display_name'];
				}
			}

			$i++;
		}

		return view('forms.index',compact('data','roleCodes'));
	}

	public function myForms (Request $request) {

		$AuthForms = [];
		$forms = [];
		$data = [];
		
		$AuthForms = \Auth::user()->form_ids;
		$groupForms = \Auth::user()->group_ids;
		$search = $request['search'];
		$admin = \Auth::user()->firstname == 'admin';
		if (empty($AuthForms)) {
			$AuthForms = [];
		} if (empty($groupForms)) {
			$groupForms = [];
		}
		$roleCodes = DB::collection('roleCode')->where('type','form')->get();
		
		$forms = DB::collection('form')->where('data.createdBy',\Auth::user()->_id)->orderBy('_id','ASC')->get();

		$i = 0;
		foreach ($forms as $form) {
			$questionFormRoleCode = [];
			$answerFormRoleCode = [];
			$data[$i] = [
				'objectId' => $form['data']['objectId'],
				'formDescription' => $form['data']['formDescription'],
				'title' => $form['data']['title'],
				'deletedBy' => $form['data']['deletedBy'],
				'questionForm' => '',
				'answerForm' => '',
			];
			if (!empty($form['user_ids'])) {
				foreach ($form['user_ids'] as $userIds) {
					if ($userIds['user_id'] == \Auth::user()->_id) {
						$questionFormRoleCode[] = $userIds['questionFormRoleCode'];
						$answerFormRoleCode[] = $userIds['answerFormRoleCode'];
					}
				}
			}
			if (!empty($form['group_ids'])) {
				foreach ($form['group_ids'] as $groupIds) {
					if (!empty($groupIds)) {
						foreach ($groupForms as $groupForm) {
							if ($groupIds['group_id'] == $groupForm) {
								$questionFormRoleCode[] = $groupIds['questionFormRoleCode'];
								$answerFormRoleCode[] = $groupIds['answerFormRoleCode'];
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
				$questionFormRoleCode = min($questionFormRoleCode);
			} if (!empty($answerFormRoleCode)) {
				$answerFormRoleCode = array_diff($answerFormRoleCode, array(null));
				$answerFormRoleCode = min($answerFormRoleCode);
			}

			foreach ($roleCodes as $roleCode) {
				if ($roleCode['roleCode'] == $questionFormRoleCode) {
					$data[$i]['questionForm'] = $roleCode['display_name'];
				}
				if ($roleCode['roleCode'] == $answerFormRoleCode) {
					$data[$i]['answerForm'] = $roleCode['display_name'];
				}
			}

			$i++;
		}

		return view('forms.index',compact('data','roleCodes'));

	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		$roles = Role::lists('display_name','_id');
		return view('users.create',compact('roles'));

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request,$id)
	{
		$countInnerForms = 0;
		$countMasterLists = 0;
		$form = DB::collection('form')->where('data.objectId',$id)->first();
		$users = User::Where('_id',$form['data']['createdBy'])->first();
		$formIds = \Auth::user()->form_ids;
		if (\Auth::user()->firstname == 'admin') {
			$rolesCode = 'admin';
		} else {
			$rolesCode = checkRoles($id);
		}

		$question = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$id);
		$questions = $question->pluck('data');

		$data = $this->filterInnerForm($questions,$countInnerForms,$countMasterLists);
		$countInnerForms = $data['countInnerForms'];
		$countMasterLists = $data['countMasterLists'];
		if (!empty($form['user_ids'])) {
			$countUserPermission = count($form['user_ids']);
		} else {
			$countUserPermission = 0;
		}
		if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2') {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->pluck('data');
				$answerFormDeleted = DB::collection('answerForm')
								->where('data.deletedAt','<>','')
								->where('data.formId',$id)
								->pluck('data');				
		}
		else if ($rolesCode['questionFormRoleCode'] != '0' || $rolesCode['answerFormRoleCode'] != '2') {   
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->where('data.createdBy',\Auth::user()->_id)
								->pluck('data');
				$answerFormDeleted = DB::collection('answerForm')
								->where('data.deletedAt','<>','')
								->where('data.formId',$id)
								->where('data.createdBy',\Auth::user()->_id)
								->pluck('data');
		}
		if(!empty($users)) {
			$form['data']['createdBy'] = $users['prefix'].$users['firstname'].' '.$users['lastname'];
		} else {
			$form['data']['createdBy'] = '';
		} 
		
		$countAnswerForm = count($answerForm);
		$countAnswerFormDeleted = count($answerFormDeleted);
		return view('forms.show',compact('form','countAnswerForm','countAnswerFormDeleted','countUserPermission','countInnerForms','countMasterLists'));
	}

	public function filterInnerForm ($question,$countInnerForms,$countMasterLists) {
		$questionInners = array_filter($question,
			function ($question) {
				return $question['type'] == 7;
			}
		);
		$masterlist = array_filter($question,
			function ($question) {
				return $question['masterListId'] != "";
			}
		);

		$countInnerForms += count($questionInners);
		$countMasterLists += count($masterlist);
		if(!empty($questionInners)) {
			foreach($questionInners as $questionInner) { 
				$questionObjects = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$questionInner['questionFormId'])->orderBy('data.orderIndex','ASC')->pluck('data');
				$questionInnerForms = array_filter($questionObjects,
					function ($questionObjects) {
						return $questionObjects['type'] == 7;
					}
				);
				$masterlistInner = array_filter($questionObjects,
					function ($questionObjects) {
						return $questionObjects['masterListId'] != "";
					}
				);
				$countMasterLists += count($masterlistInner);
				$countInnerForms += count($questionInnerForms);
				if(!empty($questionInnerForms)) {
					$this->filterInnerForm($questionObjects,$countInnerForms,$countMasterLists);
				}	
			}
		}	

		return $data = [
			'countMasterLists' => $countMasterLists,
			'countInnerForms' => $countInnerForms
		];
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

		$form = DB::collection('form')->where('data.objectId',$id);
		$form = $form->pluck('data');

		return view('forms.edit',compact('form'));

	}

	public function redelete($id){
		$form =  DB::collection('form')->where('data.objectId', $id)
		->update(array(
			'data.deletedBy' => '',
			'data.deletedAt' => '',
		));
		
		return redirect()->route('forms.index')
		->with('success','Restore Form successfully');
	}

	public function deleted(){

		$AuthForms = \Auth::user()->form_ids;

		$admin = \Auth::user()->firstname == 'admin';

		if($admin && empty($AuthForms)){
			$AuthForms = [];
		}

		if(\Auth::user()->firstname == 'admin'){
			$formsdel = DB::collection('form')->orderBy('_id','ASC')->pluck('data');

			foreach($formsdel as $form){
				if(!empty($form['deletedBy'])){
					$user = User::where('_id',$form['deletedBy'])->first();
					$forms[] = [
						'objectId' => $form['objectId'],
						'title' => $form['title'],
						'deletedAt' => $form['deletedAt'],
						'deletedBy' => $user['prefix'] . $user['firstname'] ." ". $user['lastname']
					];
				}
			}
		}elseif($AuthForms != null){
			foreach ($AuthForms as $AuthForm) {
				$formIds[] = $AuthForm['form_id'];
			}
			if ($form_ids = $AuthForm['form_id']){
				$formsdel = DB::collection('form')->whereIn('data.objectId', $formIds)->pluck('data');
				foreach($formsdel as $form){
					if(!empty($form['deletedBy'])){
						$user = User::where('_id',$form['deletedBy'])->first();
						$forms[] = [
							'objectId' => $form['objectId'],
							'title' => $form['title'],
							'deletedAt' => $form['deletedAt'],
							'deletedBy' => $user['prefix'] . $user['firstname'] ." ". $user['lastname']
						];
					}
				}   
			}
		}else if($AuthForms == null){
			$forms = [];
		}
		return view('forms.deleted',compact('forms','AuthForms'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{

		$this->validate($request, [
			'title' => 'required',
			'formDescription' => 'required'
		]);


		$input['title'] = $request->input('title');
		$input['version'] = $request->input('version');
		$input['formDescription'] = $request->input('formDescription');
		$input['previewExample'] = $request->input('previewExample');

		$form = DB::collection('form')
				->where( 'data.objectId',$id)
				->update(array('data'=>$input));

		return redirect()->route('forms.index')
		->with('success','Form updated successfully');

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{

		DB::collection('form')->where('data.objectId', $id)->delete();
		return redirect()->route('forms.index')
		->with('success','Form deleted successfully');

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $formId)
	{

		$search = $request->input('query');

		$users = User::where('firstname','LIKE','%' . $search .'%')
		->orWhere('lastname','LIKE','%' . $search .'%')
		->get();

		$forms = Form::where('data.objectId',$formId)->firstOrFail();

		#request role for update
		$questionFormRoleCode = $request->input('questionFormRoleCode');
		$answerFormRoleCode = $request->input('answerFormRoleCode');

		foreach ($users as $user) {

			if(empty($user['form_ids'])){

				$user->forms()->attach([
					array(
						'form_id' => $formId,
						'questionFormRoleCode' => $questionFormRoleCode,
						'answerFormRoleCode' => $answerFormRoleCode,
						'updatedBy' => \Auth::user()->_id
					)
				]);

				$forms->users()->attach([
					array(
						'user_id' => $user->_id,
						'questionFormRoleCode' => $questionFormRoleCode,
						'answerFormRoleCode' => $answerFormRoleCode,
						'updatedBy' => \Auth::user()->_id
					)
				]);

			}

			$countIndex = count($user['form_ids']);

			for($i=0; $i<$countIndex; $i++){

				if($user['form_ids'][$i]['form_id'] == $formId){

					$user->forms()->detach($user['form_ids'][$i]);

					$user->forms()->attach([
						array(
							'form_id' => $formId,
							'questionFormRoleCode' => $questionFormRoleCode,
							'answerFormRoleCode' => $answerFormRoleCode,
							'updatedBy' => \Auth::user()->_id
						)
					]);

					$forms->users()->detach($forms['user_ids'][$i]);

					$forms->users()->attach([
						array(
							'user_id' => $user->_id,
							'questionFormRoleCode' => $questionFormRoleCode,
							'answerFormRoleCode' => $answerFormRoleCode,
							'updatedBy' => \Auth::user()->_id
						)
					]);

				}elseif($user['form_ids'][$i]['form_id'] != $formId){

					$user->forms()->attach([
						array(
							'form_id' => $formId,
							'questionFormRoleCode' => $questionFormRoleCode,
							'answerFormRoleCode' => $answerFormRoleCode,
							'updatedBy' => \Auth::user()->_id
						)
					]);

					$forms->users()->attach([
						array(
							'user_id' => $user->_id,
							'questionFormRoleCode' => $questionFormRoleCode,
							'answerFormRoleCode' => $answerFormRoleCode,
							'updatedBy' => \Auth::user()->_id
						)
					]);

				}
			}
		}

		return redirect()->route('forms.index')
		->with('success','Form created successfully');

	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function autocomplete(Request $request)
    {
        $datas = Group::whereNull('deleted_at')->where("name","LIKE","%{$request->input('query')}%")->get();
		#->where('user_ids.user_id',\Auth::user()->_id)
        $data = null;
        
        foreach($datas as $idata){
                $data[] = $idata['name'];
        }
       
            return response()->json($data);
	}

	public function groupAccess (Request $request, $formId) {
		$form = DB::collection('form')->where('data.objectId',$formId);
		$formData = $form->pluck('data');
		
		$questionRoleCode = DB::collection('roleCode')->where('typeRoleCode','questionFormRoleCode')->orderBy('roleCode','ASC')->get();
		$answerRoleCode = DB::collection('roleCode')->where('typeRoleCode','answerFormRoleCode')->orderBy('roleCode','ASC')->get();

		$groups = Group::whereNull('deleted_at')->orderBy('_id','ASC')->get();
		
		
		return view('forms.groupaccess',compact('groups','questionRoleCode','answerRoleCode', 'formId' ,'formData'));
	}

	public function groupStoreAccessPermission(Request $request, $formId)
	{
		$search = $request->input('query');
		if(empty($search)){
			session::flash('message', "กรุณากรอกชื่อกลุ่ม !");
			return Redirect::back();            
		}
		else{
			$groups = Group::whereNull('deleted_at')->where('name',$search)->get();
			if(count($groups) > 0){
				$userid = [];
				$forms = Form::where('data.objectId',$formId)->firstOrFail();

				$groupid = [];
				if (!empty($forms['group_ids'])) {
					foreach($forms['group_ids'] as $form){
						foreach($groups as $group){
							if($group['_id'] == $form['group_id']){
								$groupid[] = $group['_id'];
							}
						}
					}
				}

				if(count($groupid) > 0){
					session::flash('message', "กลุ่มนี้มีสิทธิ์ในฟอร์มแล้ว !");
					return Redirect::back();                      
				}
				else{
				   #request role for update
					$questionFormRoleCode = $request->input('questionFormRoleCode');
					$answerFormRoleCode = $request->input('answerFormRoleCode');
					if($questionFormRoleCode != '' || $answerFormRoleCode != ''){
						foreach ($groups as $group) {
							foreach($forms as $form){
									$group->forms()->attach([
									   array(
										   'form_id' => $formId,
										   'questionFormRoleCode' => $questionFormRoleCode,
										   'answerFormRoleCode' => $answerFormRoleCode,
										   'updatedBy' => \Auth::user()->_id
									   )
								   ]);

								   	$forms->groups()->attach([
									   array(
										   'group_id' => $group->_id,
										   'questionFormRoleCode' => $questionFormRoleCode,
										   'answerFormRoleCode' => $answerFormRoleCode,
										   'updatedBy' => \Auth::user()->_id
									)
								]);
							}
						}
						return redirect('/forms/admin/group/access/'.$formId)->with('success','เพิ่มกลุ่ม '.$search.' สำเร็จแล้ว'); 
					}
					else{
						session::flash('message', "กรุณาเลือกสิทธิ์ในฟอร์คำถาม / สิทธิ์ในฟอร์มคำตอบ");
						 return Redirect::back();
					}
				}
		   }
		   else{
			   session::flash('message', "ไม่มีชื่อกลุ่มนี้");
			   return Redirect::back();                
		   }
	   }   
	}

	public function groupUpdateAccessQuestion(Request $request, $formId,$groupId)
	{

		$groups = Group::where('_id',$groupId)->firstOrFail();

		$forms = Form::where('data.objectId',$formId)->firstOrFail();
		
	   #request role for update
		$questionFormRoleCode = $request->input('questionFormRoleCode');
		$countForm = count($forms->group_ids);
		$countGroup = count($groups->form_ids);

		for($i=0; $i<$countGroup;$i++){
			if($groups['form_ids'][$i]['form_id'] == $formId){
				if($questionFormRoleCode == $groups['form_ids'][$i]['questionFormRoleCode']){
					if($groups['form_ids'][$i]['answerFormRoleCode'] == ''){
						$groups->forms()->detach($groups['form_ids'][$i]);
					}
					else{
						$groups->forms()->detach($groups['form_ids'][$i]);
						$groups->forms()->attach([
							array(
								'form_id' => $formId,
								'questionFormRoleCode' => '',
								'answerFormRoleCode' => $groups['form_ids'][$i]['answerFormRoleCode'],
								'updatedBy' => \Auth::user()->_id
							)
						]);
					}
				}
				else{
					$groups->forms()->detach($groups['form_ids'][$i]);
					$groups->forms()->attach([
						array(
							'form_id' => $formId,
							'questionFormRoleCode' => $questionFormRoleCode,
							'answerFormRoleCode' => $groups['form_ids'][$i]['answerFormRoleCode'],
							'updatedBy' => \Auth::user()->_id
						)
					]);                        
				}
			}
		}   
		
		for($j=0; $j<$countForm; $j++){
			if($forms['group_ids'][$j]['group_id'] == $groupId){
				if($questionFormRoleCode == $forms['group_ids'][$j]['questionFormRoleCode']){
					if($forms['group_ids'][$j]['answerFormRoleCode'] == ''){
						$forms->groups()->detach($forms['group_ids'][$j]);
					}
					else{
						$forms->groups()->detach($forms['group_ids'][$j]);
						$forms->groups()->attach([
							array(
								'group_id' => $groups->_id,
								'questionFormRoleCode' => '',
								'answerFormRoleCode' => $forms['group_ids'][$j]['answerFormRoleCode'],
								'updatedBy' => \Auth::user()->_id
							)
						]);
					}
				}
				else{
					$forms->groups()->detach($forms['group_ids'][$j]);
					$forms->groups()->attach([
						array(
							'group_id' => $groups->_id,
							'questionFormRoleCode' => $questionFormRoleCode,
							'answerFormRoleCode' => $forms['group_ids'][$j]['answerFormRoleCode'],
							'updatedBy' => \Auth::user()->_id
						)
					]);
				}
			}
		}
		   //return redirect('/forms/admin/access/'.$formId)->with('success','Update permission successfully');
		return Redirect::back()->with('success','เปลี่ยนสิทธิ์ในฟอร์มคำถามของกลุ่ม '.$groups->name.' สำเร็จแล้ว');
	}

	public function groupUpdateAccessAnswer(Request $request, $formId,$groupId)
	{
		$groups = Group::where('_id',$groupId)->firstOrFail();
		$forms = Form::where('data.objectId',$formId)->firstOrFail();
	  	#request role for update
		$answerFormRoleCode = $request->input('answerFormRoleCode');
		$countForm = count($forms->group_ids);
		$countGroup = count($groups->form_ids);
		for($i=0; $i<$countGroup; $i++){
			if($groups['form_ids'][$i]['form_id'] == $formId){
				if($answerFormRoleCode == $groups['form_ids'][$i]['answerFormRoleCode']){
					if($groups['form_ids'][$i]['questionFormRoleCode'] == ''){
						$groups->forms()->detach($groups['form_ids'][$i]);
					}
					else{
						$groups->forms()->detach($groups['form_ids'][$i]);
						$groups->forms()->attach([
							array(
								'form_id' => $formId,
								'questionFormRoleCode' => $groups['form_ids'][$i]['questionFormRoleCode'],
								'answerFormRoleCode' => '',
								'updatedBy' => \Auth::user()->_id
							)
						]);
					}
				}
				else{
					$groups->forms()->detach($groups['form_ids'][$i]);
					$groups->forms()->attach([
						array(
							'form_id' => $formId,
							'questionFormRoleCode' => $groups['form_ids'][$i]['questionFormRoleCode'],
							'answerFormRoleCode' => $answerFormRoleCode,
							'updatedBy' => \Auth::user()->_id
						)
					]);
				}
			}
		}   
		for($j=0;$j<$countForm; $j++){
			if($forms['group_ids'][$j]['group_id'] == $groupId){
				if($answerFormRoleCode == $forms['group_ids'][$j]['answerFormRoleCode']){
					if($forms['group_ids'][$j]['questionFormRoleCode'] == ''){
						$forms->groups()->detach($forms['group_ids'][$j]);
					}
					else{
						$forms->groups()->detach($forms['group_ids'][$j]);
						$forms->groups()->attach([
							array(
								'group_id' => $groups->_id,
								'questionFormRoleCode' => $forms['group_ids'][$j]['questionFormRoleCode'],
								'answerFormRoleCode' => '',
								'updatedBy' => \Auth::user()->_id
							)
						]);
					}
				}
				else{
					$forms->groups()->detach($forms['group_ids'][$j]);
					$forms->groups()->attach([
						array(
							'group_id' => $groups->_id,
							'questionFormRoleCode' => $forms['group_ids'][$j]['questionFormRoleCode'],
							'answerFormRoleCode' => $answerFormRoleCode,
							'updatedBy' => \Auth::user()->_id
						)
					]);
				}
			}
		}
		   //return redirect('/forms/admin/access/'.$formId)->with('success','Update permission successfully');
		   return Redirect::back()->with('success','เปลี่ยนสิทธิ์ในฟอร์มคำตอบของกลุ่ม '.$groups->name.' สำเร็จแล้ว');

	}

	public function groupDestroyPermission($formId, $groupId)
	{

		$forms = Form::where('data.objectId',$formId)->firstOrFail();

		$groups = Group::where('_id',$groupId)->firstOrFail();

		$countForm = count($forms->group_ids);
		$countGroup = count($groups->form_ids);

		for ($i=0; $i<$countGroup; $i++) {
			if ($groups['form_ids'][$i]['form_id'] == $formId) {
				$groups->forms()->detach($groups['form_ids'][$i]);
			}
		}   
		
		for ($j=0; $j<$countForm; $j++) {
			if ($forms['group_ids'][$j]['group_id'] == $groupId) {
				$forms->groups()->detach($forms['group_ids'][$j]);
			}
		}

			//return redirect('/forms/admin/access/'.$forms['data']['objectId'])->with('success','Delete permission successfully');
		return Redirect::back()->with('success','ลบสิทธิ์ของกลุ่ม '.$groups->name.' เรียบร้อยแล้ว');
	}

	public function access(Request $request , $formId)
	{
		$form = DB::collection('form')->where('data.objectId',$formId);
		$formData = $form->pluck('data');
		
		$questionRoleCode = DB::collection('roleCode')->where('typeRoleCode','questionFormRoleCode')->orderBy('roleCode','ASC')->get();
		$answerRoleCode = DB::collection('roleCode')->where('typeRoleCode','answerFormRoleCode')->orderBy('roleCode','ASC')->get();

		$users = User::whereNull('deleted_at')->orderBy('_id','ASC')->get();

		return view('forms.access',compact('users','questionRoleCode','answerRoleCode', 'formId' ,'formData'));
	}

	 /**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	
	public function storeAccessPermission(Request $request, $formId)
	{
	 	$search = $request->input('query');
	 	if(empty($search)){
	 		session::flash('message', "กรุณากรอกชื่อผู้ใช้ !");
	 		return Redirect::back();            
	 	}
	 	else{
			// Split each Name by Spaces
	 		$names = explode(" ", $search);
			// Search each Name Field for any specified Name
	 		$users = User::whereNull('deletedAt')->where(function($query) use ($names) {
	 			$query->whereIn('firstname', $names);
	 			$query->where(function($query) use ($names) {
	 				$query->whereIn('lastname', $names);
	 			});
	 		})->get();
	 		if(count($users) > 0){
					$userid = [];
					$forms = Form::where('data.objectId',$formId)->firstOrFail();
					foreach($forms['user_ids'] as $form){
						foreach($users as $user){
							if($user['_id'] == $form['user_id']){
								$userid[] = $user['_id'];
							}
						}
					}
					if(count($userid) > 0){
						session::flash('message', "ผุ้ใช้นี้มีสิทธิ์ในฟอร์มแล้ว !");
						return Redirect::back();                      
					}
					else{
					#request role for update
						$questionFormRoleCode = $request->input('questionFormRoleCode');
						$answerFormRoleCode = $request->input('answerFormRoleCode');
						if($questionFormRoleCode != '' || $answerFormRoleCode != ''){
							foreach ($users as $user) {
								foreach($forms as $form){
									$user->forms()->attach([
										array(
											'form_id' => $formId,
											'questionFormRoleCode' => $questionFormRoleCode,
											'answerFormRoleCode' => $answerFormRoleCode,
											'updatedBy' => \Auth::user()->_id
										)
									]);

									$forms->users()->attach([
										array(
											'user_id' => $user->_id,
											'questionFormRoleCode' => $questionFormRoleCode,
											'answerFormRoleCode' => $answerFormRoleCode,
											'updatedBy' => \Auth::user()->_id
										)
									]);
								}
							}
							return redirect('/forms/admin/access/'.$formId)->with('success','เพิ่มผู้ใช้ '.$search.' สำเร็จแล้ว'); 
						}
						else{
							session::flash('message', "กรุณาเลือกสิทธิ์ในฟอร์คำถาม / สิทธิ์ในฟอร์มคำตอบ");
							return Redirect::back();
						}
					}
			}
			else{
				session::flash('message', "ไม่มีชื่อผู้ใช้นี้");
				return Redirect::back();                
			}
		}   
	}

	 /**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	 public function updateAccessQuestion(Request $request, $formId,$userId)
	 {

	 	$users = User::where('_id',$userId)->firstOrFail();

	 	$forms = Form::where('data.objectId',$formId)->firstOrFail();

		#request role for update
	 	$questionFormRoleCode = $request->input('questionFormRoleCode');
	 	$countForm = count($forms->user_ids);
	 	$countUser = count($users->form_ids);

	 	for($i=0; $i<$countUser;$i++){
	 		if($users['form_ids'][$i]['form_id'] == $formId){
	 			if($questionFormRoleCode == $users['form_ids'][$i]['questionFormRoleCode']){
	 				if($users['form_ids'][$i]['answerFormRoleCode'] == ''){
	 					$users->forms()->detach($users['form_ids'][$i]);
	 				}
	 				else{
	 					$users->forms()->detach($users['form_ids'][$i]);
	 					$users->forms()->attach([
	 						array(
	 							'form_id' => $formId,
	 							'questionFormRoleCode' => '',
	 							'answerFormRoleCode' => $users['form_ids'][$i]['answerFormRoleCode'],
	 							'updatedBy' => \Auth::user()->_id
	 						)
	 					]);
	 				}
	 			}
	 			else{
	 				$users->forms()->detach($users['form_ids'][$i]);
	 				$users->forms()->attach([
	 					array(
	 						'form_id' => $formId,
	 						'questionFormRoleCode' => $questionFormRoleCode,
	 						'answerFormRoleCode' => $users['form_ids'][$i]['answerFormRoleCode'],
	 						'updatedBy' => \Auth::user()->_id
	 					)
	 				]);                        
	 			}
	 		}
	 	}   
	 	
	 	for($j=0; $j<$countForm; $j++){
	 		if($forms['user_ids'][$j]['user_id'] == $userId){
	 			if($questionFormRoleCode == $forms['user_ids'][$j]['questionFormRoleCode']){
	 				if($forms['user_ids'][$j]['answerFormRoleCode'] == ''){
	 					$forms->users()->detach($forms['user_ids'][$j]);
	 				}
	 				else{
	 					$forms->users()->detach($forms['user_ids'][$j]);
	 					$forms->users()->attach([
	 						array(
	 							'user_id' => $users->_id,
	 							'questionFormRoleCode' => '',
	 							'answerFormRoleCode' => $forms['user_ids'][$j]['answerFormRoleCode'],
	 							'updatedBy' => \Auth::user()->_id
	 						)
	 					]);
	 				}
	 			}
	 			else{
	 				$forms->users()->detach($forms['user_ids'][$j]);
	 				$forms->users()->attach([
	 					array(
	 						'user_id' => $users->_id,
	 						'questionFormRoleCode' => $questionFormRoleCode,
	 						'answerFormRoleCode' => $forms['user_ids'][$j]['answerFormRoleCode'],
	 						'updatedBy' => \Auth::user()->_id
	 					)
	 				]);
	 			}
	 		}
	 	}
			//return redirect('/forms/admin/access/'.$formId)->with('success','Update permission successfully');
	 	return Redirect::back()->with('success','Update permission successfully');
	 }

	 public function updateAccessAnswer(Request $request, $formId,$userId)
	 {

	 	$users = User::where('_id',$userId)->firstOrFail();

	 	$forms = Form::where('data.objectId',$formId)->firstOrFail();
		#request role for update
	 	$answerFormRoleCode = $request->input('answerFormRoleCode');
	 	$countForm = count($forms->user_ids);
	 	$countUser = count($users->form_ids);
	 	for($i=0; $i<$countUser; $i++){
	 		if($users['form_ids'][$i]['form_id'] == $formId){
	 			if($answerFormRoleCode == $users['form_ids'][$i]['answerFormRoleCode']){
	 				if($users['form_ids'][$i]['questionFormRoleCode'] == ''){
	 					$users->forms()->detach($users['form_ids'][$i]);
	 				}
	 				else{
	 					$users->forms()->detach($users['form_ids'][$i]);
	 					$users->forms()->attach([
	 						array(
	 							'form_id' => $formId,
	 							'questionFormRoleCode' => $users['form_ids'][$i]['questionFormRoleCode'],
	 							'answerFormRoleCode' => '',
	 							'updatedBy' => \Auth::user()->_id
	 						)
	 					]);
	 				}
	 			}
	 			else{
	 				$users->forms()->detach($users['form_ids'][$i]);
	 				$users->forms()->attach([
	 					array(
	 						'form_id' => $formId,
	 						'questionFormRoleCode' => $users['form_ids'][$i]['questionFormRoleCode'],
	 						'answerFormRoleCode' => $answerFormRoleCode,
	 						'updatedBy' => \Auth::user()->_id
	 					)
	 				]);
	 			}
	 		}
	 	}   
	 	for($j=0;$j<$countForm; $j++){
	 		if($forms['user_ids'][$j]['user_id'] == $userId){
	 			if($answerFormRoleCode == $forms['user_ids'][$j]['answerFormRoleCode']){
	 				if($forms['user_ids'][$j]['questionFormRoleCode'] == ''){
	 					$forms->users()->detach($forms['user_ids'][$j]);
	 				}
	 				else{
	 					$forms->users()->detach($forms['user_ids'][$j]);
	 					$forms->users()->attach([
	 						array(
	 							'user_id' => $users->_id,
	 							'questionFormRoleCode' => $forms['user_ids'][$j]['questionFormRoleCode'],
	 							'answerFormRoleCode' => '',
	 							'updatedBy' => \Auth::user()->_id
	 						)
	 					]);
	 				}
	 			}
	 			else{
	 				$forms->users()->detach($forms['user_ids'][$j]);
	 				$forms->users()->attach([
	 					array(
	 						'user_id' => $users->_id,
	 						'questionFormRoleCode' => $forms['user_ids'][$j]['questionFormRoleCode'],
	 						'answerFormRoleCode' => $answerFormRoleCode,
	 						'updatedBy' => \Auth::user()->_id
	 					)
	 				]);
	 			}
	 		}
	 	}
			//return redirect('/forms/admin/access/'.$formId)->with('success','Update permission successfully');
	 	return Redirect::back()->with('success','Update permission successfully');

	 }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroyPermission($formId, $userId)
	{

		$forms = Form::where('data.objectId',$formId)->firstOrFail();

		$users = User::where('_id',$userId)->firstOrFail();

		$countForm = count($forms->user_ids);
		$countUser = count($users->form_ids);
		for ($i=0; $i<$countUser; $i++) {
			if ($users['form_ids'][$i]['form_id'] == $formId) {
				$users->forms()->detach($users['form_ids'][$i]);
			}
		}   
		
		for ($j=0; $j<$countForm; $j++) {
			if ($forms['user_ids'][$j]['user_id'] == $userId) {
				$forms->users()->detach($forms['user_ids'][$j]);
			}
		}

			//return redirect('/forms/admin/access/'.$forms['data']['objectId'])->with('success','Delete permission successfully');
		return Redirect::back()->with('success','Delete permission successfully');
	}

	/*public function download($id){
		$form = DB::collection('form')->where('data.objectId',$id)->first();
		$formname = $form['data']['title'];
		$adminForm = \Auth::user()->form_ids;
		$admin = \Auth::user()->firstname == 'admin';
		$adminFormDetail = checkRoles($admin,$adminForm,$id);

		if ($admin || $adminFormDetail == '0' || $adminFormDetail == '2') {   
			$answerForm = DB::collection('answerForm')->where('data.deletedAt','')->where('data.formId',$form['data']['objectId'])->orderBy('data.updatedAt','DESC')->pluck('data.objectId');
		}
		else if ($adminFormDetail != '0' || $adminFormDetail != '2') {    
			$answerForm = DB::collection('answerForm')->where('data.deletedAt','')->where('data.formId',$form['data']['objectId'])->where('data.createdBy',\Auth::user()->_id)->orderBy('data.updatedAt','DESC')->pluck('data.objectId')->pluck('data.objectId');
		}
		
		$pathfile = DB::collection('answer')->Where(function($query)
	    {
	        $query->where('data.deletedAt','')
	        	->where('data.imagePath','<>','');
	    })->whereIn('data.answerFormId',$answerForm)->pluck('data.imagePath');

		if (!empty($pathfile)) {
			foreach ($pathfile as $pathfiles) {
				$files = glob(storage_path('images/'.$pathfiles));
				Zipper::make(storage_path($formname.'.zip'))->add($files)->close();
			}

			$downloadimg = storage_path($formname.'.zip');

			if (file_exists($downloadimg) == true) {
				return response()->download($downloadimg)->deleteFileAfterSend(true);
			}
			else {
				session::flash('message', "เกิดข้อผิดพลาดกับไฟล์บน server");
				return Redirect::back();           
			}
		}else {
			session::flash('message', "ไม่มีรูปของคำตอบ");
			return Redirect::back();
		}
	}

	public function Excelpage($id){
		$form = DB::collection('form')->where('data.objectId',$id);
		$form = $form->pluck('data');

		foreach($form as $key => $forms){
			$form = $forms['title'];
		}

		$pages = DB::collection('page')->whereNull('deletedAt')->where('data.formId',$id)->orderBy('data.orderIndex','ASC');
		$pages = $pages->pluck('data');

		$answerFormss = DB::collection('answerForm')->whereNull('deletedAt')->where('data.formId',$id);
		$answerFormss = $answerFormss->pluck('data');
		foreach($answerFormss as $answerFormes){
			$users = User::whereNull('deletedAt')->where('_id',$answerFormes['updatedBy'])->firstOrFail();
			$answerForm[] = array(  
				'createdAt' => $answerFormes['createdAt'],
				'createdBy' => $answerFormes['createdBy'],
				'updatedBy' => $answerFormes['updatedBy'],
				'answerPreview' => $answerFormes['answerPreview'],
				'updatedAt' => $answerFormes['updatedAt'],
				'objectId' => $answerFormes['objectId'],
				'nameuser' => $users['prefix'].$users['firstname'] ." ". $users['lastname']
			);
		}
		return
		Excel::create($form, function($excel) use ($answerForm, $pages)  {
			foreach($pages as $page){
				$excel->sheet($page['title'], function($sheet) use ($answerForm, $page){
					$question = DB::collection('question')->whereNull('deletedAt')->where('data.pageId',$page['objectId'])->orderBy('data.orderIndex','ASC');
					$question = $question->pluck('data');
					foreach($question as $questions){
						$quesid[] = $questions['objectId'];
					}
					$answers = DB::collection('answer')->whereNull('deletedAt')->whereIn('data.questionId',$quesid)->orderBy('data.orderIndex','ASC');
					$answers = $answers->pluck('data');
					foreach($answerForm as $answerForms){
						foreach($question as $questions){
							foreach($answers as $answer){
								if($answerForms['objectId'] == $answer['answerFormId']){
									if($answer['questionId'] == $questions['objectId']){
										$ans = question_type($answerForm,$question,$answers);
										$sheet->loadView('answerForms.showExcelpage', array('question' => $question, 'answers' => $ans,'answerForm' => $answerForm));
									}
								}
							}
						}
					}
				});
			}
		})->export('xls');
	}*/

	/*public function showPreviewExcel(Request $request,$id)
	{
		$startdate = $request['startdate'];
		$enddate = $request['enddate']; 

		return view('answerForms.showPreview',compact('id','startdate','enddate'));
	}

	public function showDataPreviewExcel(Request $request) {
		//$request['id'] = '20171018011853-529982333425753-1281522';
		if (!empty($request['startdate']) || !empty($request['enddate'])) {
	        $startdate = new \MongoDate(
	                            strtotime(date('Y-m-d 00:00:00', strtotime($request['startdate'])))
	                        );
	        $enddate = new \MongoDate(
	                            strtotime(date('Y-m-d 23:59:59', strtotime($request['enddate'])))
	                        );
        }
		ini_set('max_execution_time', 1200);
		ini_set('memory_limit', '-1');
		$adminForm = \Auth::user()->form_ids;
		$admin = \Auth::user()->firstname == 'admin';
		$adminFormDetail = checkRoles($admin,$adminForm,$request['id']);
		$forms = DB::collection('form')->where('data.objectId',$request['id'])->first();
		if ($admin || $adminFormDetail == '0' || $adminFormDetail == '2') {
			if (empty($request['startdate']) || empty($request['enddate'])) {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$request['id'])
								->orderBy('data.updatedAt','DESC');
			} else {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$request['id'])
								->whereBetween('data.isoUpdatedAt', array($startdate, $enddate))
								->orderBy('data.updatedAt','DESC');
			}
		}
		else if ($adminFormDetail != '0' || $adminFormDetail != '2') {   
			if (empty($request['startdate']) || empty($request['enddate'])) {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$request['id'])
								->where('data.createdBy',\Auth::user()->_id)
								->orderBy('data.updatedAt','DESC');
			} else {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$request['id'])
								->where('data.createdBy',\Auth::user()->_id)
								->whereBetween('data.isoUpdatedAt', array($startdate, $enddate))
								->orderBy('data.updatedAt','DESC');
			}
		}
		$answerForms = $answerForm->pluck('data');
		if(empty($answerForms)) {
			return $answerForms;
		}
		$answerFormObjectId = $answerForm->pluck('data.objectId');
		$question = DB::collection('question')
					->where('data.deletedAt','')
					->where('data.formId', $request['id'])
					->orderBy('data.orderIndex','ASC')
					->pluck('data');

		$pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$request['id'])->orderBy('data.orderIndex','ASC')->pluck('data');
		$questionToArray[] = 'วันที่บันทึก';
		$questionToArray[] = 'objectId';
		if($answerForms[0]['parentAnswerFormId'] != '') {
			$questionToArray[] = 'parentAnswerFormId';
		}	
		foreach ($pages as $page) {
			foreach ($question as $questions) {
				if ($page['objectId'] == $questions['pageId']) {
					$questionsOfForm[] = $questions;
					$questionToArray[] = $questions['title'];
				}
			}
		}
		$questionToArray[] = 'ผู้บันทึก';

		$answerformArrays[$forms['data']['title']]['answer'] = $this->answerToArray($answerForms,$questionsOfForm);
		$answerformArrays[$forms['data']['title']]['question'] = $questionToArray;
		$questionInners = array_filter($question,
			function ($question) {
				return $question['type'] == 7;
			}
		);
		if(!empty($questionInners)) {
			$answerformArray['innerForm'] = $this->innerFormPreview($question,$adminFormDetail,$admin,$answerFormObjectId);
			foreach($answerformArray['innerForm'] as $key => $value) {
				$answerformArrays[$key] = $value;
			}
		}
		//dd($answerformArrays);
		return $answerformArrays;
	}

	public function innerFormPreview ($question,$adminFormDetail,$admin,$answerFormObjectId) {
		$questionInners = array_filter($question,
			function ($question) {
				return $question['type'] == 7;
			}
		);
		if(!empty($questionInners)) {
			$i = 0;
			foreach($questionInners as $questionInner) { 
				$questionsOfForm = [];
				$questionsOfExcel = [];
				$questionObjects = DB::collection('question')->where('data.deletedAt','')->where('data.formId',$questionInner['questionFormId'])->orderBy('data.orderIndex','ASC')->pluck('data');
				$questionInnerForms = array_filter($questionObjects,
					function ($questionObjects) {
						return $questionObjects['type'] == 7;
					}
				);

				$parentAnswerForm = DB::Collection('answerForm')
									->where('data.deletedAt','')
									->whereIn('data.parentAnswerFormId',$answerFormObjectId)
									->orderBy('data.updatedAt','DESC');
				$parentAnswerFormObjects = $parentAnswerForm->pluck('data');
				$parentobjectId = $parentAnswerForm->pluck('data.objectId');

				$pages = DB::collection('page')
						->where('data.deletedAt','')
						->where('data.formId',$questionInner['questionFormId'])
						->orderBy('data.orderIndex','ASC')
						->pluck('data');
				$questionsOfExcel[] = 'วันที่บันทึก';
				$questionsOfExcel[] = 'objectId';
				$questionsOfExcel[] = 'parentAnswerFormId';
				foreach ($pages as $page) {
					foreach ($questionObjects as $questionObject) {
						if ($page['objectId'] == $questionObject['pageId']) {
							$questionsOfForm[] = $questionObject;
							$questionsOfExcel[] = $questionObject['title'];
						}
					}
				}
				$questionsOfExcel[] = 'ผู้บันทึก';
				$answerformArrays[$questionInner['title']]['answer'] = $this->answerToArray($parentAnswerFormObjects,$questionsOfForm);
				$answerformArrays[$questionInner['title']]['question'] = $questionsOfExcel;
				if(!empty($questionInnerForms)) {
					$answerformArray['innerForm'] = $this->innerFormPreview($questionObjects,$adminFormDetail,$admin,$answerFormObjectId);
					foreach($answerformArray['innerForm'] as $key => $value) {
						$answerformArrays[$key] = $value;
					}
				}	
			}
		}
		return $answerformArrays;	
	}*/

}    
