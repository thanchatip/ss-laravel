<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Group;
use DB;
use Hash;
use Carbon\Carbon;
use Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\FormsController;
use Input;
use log;

class AnswerFormsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
		if (Input::has('dateRange')) {
			$dateRange = explode('-',$request->input('dateRange'));
			
			$startDate = preg_replace('/\s+/', '', $dateRange[0]);
			$endDate = preg_replace('/\s+/', '', $dateRange[1]);
		} else {
			$startDate = null;
			$endDate = null;
		}

		$data = [
			'dateRange' => $request->input('dateRange'),
			'typedate' => $request->input('typedate'),
			'preview' => $request->input('preview')
		];

		$startdate = new \MongoDate(
						strtotime(date('Y-m-d 00:00:00', strtotime($startDate)))
					);
		$enddate = new \MongoDate(
						strtotime(date('Y-m-d 23:59:59', strtotime($endDate)))
					);

		$form = DB::collection('form')->where('data.objectId',$id)->first();

		if (\Auth::user()->firstname == 'admin') {
			$rolesCode = 'admin';
		} else {
			$rolesCode = checkRoles($id);
		}

		$userId = \Auth::user()->_id;
		if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2') {
			if (!empty($startDate) && !empty($endDate) && !empty($request['preview'])) {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->whereBetween($request->input('typedate'), array($startdate, $enddate))
								->where('data.answerPreview','like','%'.$request['preview'].'%')
								->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');				
			} else if(!empty($startDate) && !empty($endDate)) {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->whereBetween($request->input('typedate'), array($startdate, $enddate))
								->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');
								
			} else if (!empty($request['preview'])) {
                $answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
                    			->orWhere('data.answerPreview','like','%'.$request['preview'].'%')
                    			->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');
			} else {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');
			}
		}
		else if ($rolesCode['questionFormRoleCode'] != '0' || $rolesCode['answerFormRoleCode'] != '2') {   
			if (!empty($startDate) && !empty($endDate) && !empty($request['preview'])) {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->where('data.createdBy',\Auth::user()->_id)
								->whereBetween($request->input('typedate'), array($startdate, $enddate))
								->where('data.answerPreview','like','%'.$request['preview'].'%')
								->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');				
			} else if(!empty($startDate) && !empty($endDate)) {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->where('data.createdBy',\Auth::user()->_id)
								->whereBetween($request->input('typedate'), array($startdate, $enddate))
								->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');
								
			} else if (!empty($request['preview'])) {
                $answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->where('data.createdBy',\Auth::user()->_id)
                    			->orWhere('data.answerPreview','like','%'.$request['preview'].'%')
                    			->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');
			} else {
				$answerForm = DB::collection('answerForm')
								->where('data.deletedAt','')
								->where('data.formId',$id)
								->where('data.createdBy',\Auth::user()->_id)
								->orderBy('data.isoCreatedAt','DESC')
								->pluck('data');
			}
		}

		for($i=0;$i<count($answerForm);$i++){
			$users = User::Where('_id',$answerForm[$i]['createdBy'])->first();
			if(!empty($users)) {
					$answerForm[$i]['createdBy'] = $users['prefix'].$users['firstname'].' '.$users['lastname'];
			} else {
				$answerForm[$i]['createdBy'] = '';
			} 
		}

		$users = User::Where('_id',$form['data']['createdBy'])->first();
		if(!empty($users)) {
			$form['data']['createdBy'] = $users['prefix'].$users['firstname'].' '.$users['lastname'];
		} else {
			$form['data']['createdBy'] = '';
		} 

		$answerForm = $this->paginate($answerForm,25);
		return view('answerForms.index',compact('form','answerForm','id','data','rolesCode','userId'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {

        return view('answerForms.create');

    }*/


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'password' => 'required|same:confirm-password',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        if (!empty($request->input('roles'))) {
            foreach ($request->input('roles') as $key => $value) {
                $user->attachRole($value);
            }
        }

        return redirect()->route('users.index')
            ->with('success','User created successfully');

    }*/


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $id ,$formId)
    {

        $answerForms = DB::collection('answerForm')->where('data.objectId',$id);
        $answerForms = $answerForms->pluck('data');

        $pages = DB::collection('page')->where('data.deletedAt','')->where('data.formId',$formId)->orderBy('data.orderIndex','ASC')->pluck('data');

        $questions = DB::collection('question')->where('data.formId',$formId)->orderBy('data.orderIndex', 'ASC');
        $questions = $questions->pluck('data');
        
        $answers = $this->answerToString($id,$questions);
        $pages = $this->paginate($pages,1);
 
        for($i=0;$i<count($answerForms);$i++){
			$users = User::Where('_id',$answerForms[$i]['createdBy'])->first();
			if(!empty($users)) {
				$answerForms[$i]['createdBy'] = $users['prefix'].$users['firstname'].' '.$users['lastname'];
			} else {
				$answerForms[$i]['createdBy'] = '';
			}	
		}
            return view('answerForms.show',compact('answerForms', 'answers', 'questions','pages','data','formId','$id'));
    }


	public function paginate($items,$perPage)
	{
		if(empty($items)) {
			$items = [];
		}

		$pageStart = \Request::get('page', 1);
		// Start displaying items from this number;
		$offSet = ($pageStart * $perPage) - $perPage; 

		// Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);
   
		return new LengthAwarePaginator($itemsForCurrentPage, count($items), $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
	}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {

        $answerForm = DB::collection('answerForm')->where('data.objectId',$id);
        $answerForm = $answerForm->pluck('data');

            return view('answerForms.edit',compact('answerForm'));

    }*/


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required',
            'formDescription' => 'required'
        ]);


        $input['title'] = $request->input('title');
        $input['version'] = $request->input('version');
        $input['formDescription'] = $request->input('formDescription');
        $input['previewExample'] = $request->input('previewExample');


        //$form = DB::collection('form')->where('data.objectId',$id);

        $form = DB::collection('form')
                  ->where( 'data.objectId',$id)
                  ->update(array('data'=>$input));




        //$form->update($input['data']);

            return redirect()->route('forms.index')
                ->with('success','Form updated successfully');

    }*/


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy($id)
    {

        DB::collection('form')->where('data.objectId', $id)->delete();
            return redirect()->route('forms.index')
                ->with('success','Form deleted successfully');

    }*/


	public function answerToString($answerFormId,$sortedQuestion) {
        $answerValue = [];
			$answers = DB::collection('answer')
						->where('data.deletedAt','')
						->where('data.answerFormId',$answerFormId)
						->pluck('data');
			$questionCount = count($sortedQuestion);
			if ($questionCount > 0) {
				for ($q=0;$q<$questionCount;$q++) {
					$questionId = $sortedQuestion[$q]['objectId'];
					$answersOfQuestion = array_filter($answers,
						function ($answers) use ($questionId) {
							return $answers['questionId'] == $questionId;
						}
					);

					$sortedAnswer = array_values(array_sort($answersOfQuestion, function ($value) {
						return $value['orderIndex'];
                    }));
					$answerCount = count($sortedAnswer);
					if ($answerCount > 0) {
						if ($sortedQuestion[$q]['type'] == 0) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['stringValue'];
							}
						} else if ($sortedQuestion[$q]['type'] == 1) {
							$config = DB::collection('questionConfiguration')
										->where('data.objectId',$sortedQuestion[$q]['settingId'])
										->first();
							for ($i=0;$i<$answerCount;$i++) {
								if ($config['data']['allowDecimal'] == false) {
									$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['doubleValue'];
								}
								elseif($config['data']['allowDecimal'] == true) {
									$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['doubleValue'];
								}
							}
						} else if ($sortedQuestion[$q]['type'] == 2 || 
							$sortedQuestion[$q]['type'] == 15 || 
							$sortedQuestion[$q]['type'] == 3 || 
							$sortedQuestion[$q]['type'] == 12) {
							for ($i=0;$i<$answerCount;$i++) {
								$choice = DB::collection('choice')
									->where('data.questionId',$sortedQuestion[$q]['objectId'])
									->where('data.objectId',$sortedAnswer[$i]['choiceId'])
								->first();
								if (!empty($choice)){
									if ($choice['data']['type'] == 0) {
										$answerValue[$sortedQuestion[$q]['objectId']][] = $choice['data']['title'];
									} else if($choice['data']['type'] == 1) {
										$answerValue[$sortedQuestion[$q]['objectId']][] = $choice['data']['title'] ." | ". $sortedAnswer[$i]['stringValue'];
									}
								}
							}
						} else if ($sortedQuestion[$q]['type'] == 4) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['stringValue'];
							}
						} else if ($sortedQuestion[$q]['type'] == 5) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['doubleValue'];
							}
						} else if ($sortedQuestion[$q]['type'] == 6) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['dateValue'];
							}
						} else if ($sortedQuestion[$q]['type'] == 7) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['answerFormIdValue'];
							}
						} else if ($sortedQuestion[$q]['type'] == 8) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['AnswerText'];
							}
						} else if ($sortedQuestion[$q]['type'] == 9) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['AnswerNumber'];
							}
						} else if ($sortedQuestion[$q]['type'] == 10) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['stringValue'];
							}
						} else if ($sortedQuestion[$q]['type'] == 11) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['runningNumberList'];
							}
						} else if ($sortedQuestion[$q]['type'] == 13) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['doubleValue'];
							}
						} else if ($sortedQuestion[$q]['type'] == 14) {
							for ($i=0;$i<$answerCount;$i++) {
								$answerValue[$sortedQuestion[$q]['objectId']][] = $sortedAnswer[$i]['imagePath'];
							}
						}
					}
                }
            }
    
		return $answerValue;        
	}
    
}