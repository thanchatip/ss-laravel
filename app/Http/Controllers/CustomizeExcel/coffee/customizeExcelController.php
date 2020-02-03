<?php

namespace App\Http\Controllers\CustomizeExcel\coffee;

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
    public function index($formId) {
        
        $MASTER_FORM_ID = [
            '20180815074404-55601184433949-1329190',
            '20180907082343-558001423121236-1842136',
            '20181009031557-560747757666275-1177697'
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

        $forms[3] = $forms[1];
        $forms[3]['objectId'] = '1234';
        $forms[3]['title'] = 'รายงานสรุปการขนส่งกาแฟจากไร่';

        $forms[4] = $forms[1];
        $forms[4]['objectId'] = '12345';
        $forms[4]['title'] = 'รายงานเปรียบเทียบน้ำหนักการรับซื้อและโรงงาน';

        $forms[5] = $forms[0];
        $forms[5]['objectId'] = '123456';
        $forms[5]['title'] = 'privotรับซื้อกาแฟ_โรงงานรับเข้า';
    
        $baseUrl = config('app.ss_report');
        
        return view('report.coffee.index',compact('forms','baseUrl','rolesCode','masterForms'));        
	}

}