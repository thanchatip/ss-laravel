<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ReportController extends Controller
{
    public function index($id) {
		$userId = \Auth::user()->_id;
		$reportLists = [
			'oiltea' => '20170923133340-527866420224209-1749826', #oiltea
			'huaisan' => '20171018011853-529982333425753-1281522', #huaisan
			'macca' => '20180308032358-542172238187372-1989270', #macca
			'oilteav2' => '20180420042816-5458912969862-1630781', #oilteav2
			'researchoiltea' => '20180317152059-542992859831745-1941555', #reseachOiltea,
			'forestSurvey' => '20181023133235-561994355978094-1544943'
		];
		
        $form = DB::collection('form')->where('data.objectId',$id)->first();
        $formIds = \Auth::user()->form_ids;
        
		if (\Auth::user()->firstname == 'admin') {
			$rolesCode = 'admin';
		} else {
			$rolesCode = checkRoles($id);
		}
	
        return view('report.index',compact('form','userId','rolesCode','reportLists'));
    }
}
