<?php
namespace App\Http\Controllers\CustomizeExcel\huaisan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\Flatdata;
use Carbon\Carbon;
use Session;
use Redirect;
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use App\Http\Controllers\CustomizeExcel\huaisan\QuestionIdConfig;

ini_set('mongo.long_as_object', 1);
ini_set('max_execution_time', 1200);
ini_set('memory_limit', '-1');

class SummaryController extends Controller 
{
	public function index(){
		$MASTER_FORM_ID = '20171018011853-529982333425753-1281522';

		$userId = \Auth::user()->_id;
        $forms = DB::collection('form')->where('data.objectId',$MASTER_FORM_ID)->pluck('data');
        $formIds = \Auth::user()->form_ids;

		if (\Auth::user()->firstname == 'admin') {
			$rolesCode = 'admin';
		} else {
			$rolesCode = checkRoles($MASTER_FORM_ID);
		}
		$baseUrl = config('app.ss_report');
		return view('report.huaisan.index',compact('forms','baseUrl','rolesCode'));
	}
}
?>