<?php

namespace App\Http\Controllers\CustomizeExcel\forestSurvey;

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

class customizeExcelController extends Controller
{
    public function index() {
        $formId = '20181023133235-561994355978094-1544943';
        $MASTER_FORM_ID = [
            '20181023133235-561994355978094-1544943'
        ];
        
        $userId = \Auth::user()->_id;
        $masterForms = DB::collection('form')->where('data.objectId',$formId)->first();
        $forms = DB::collection('form')->whereIn('data.objectId',$MASTER_FORM_ID)->pluck('data');
        $formIds = \Auth::user()->form_ids;

        foreach ($forms as $key => $masterFormId) {
            if (\Auth::user()->firstname == 'admin') {
                $forms[$key]['rolesCode'] = 'admin';
            } else {
                $forms[$key]['rolesCode'] = checkRoles($masterFormId['objectId']);
            }
        }
    
        $baseUrl = config('app.ss_report');
        
        return view('report.forestSurvey.index',compact('forms','baseUrl','rolesCode','masterForms'));        
	}

}