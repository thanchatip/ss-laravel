<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Role;
use App\RoleCode;
use App\Masterdata;
use App\MasterdataItem;
use App\MasterdataSchema;
use DB;
use Hash;
use Log;
use Input;
use Excel;
use Carbon\Carbon;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
use Redirect;
use Cache;
use App\Masterlist;
use Session;
use App\Group;
use Response;
use Zipper;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', '-1');
class MasterDataController extends Controller
{
	public function index(){
        $masterdataObjectId = [];
        $masterdataIds = \Auth::user()->masterdata_ids;

        if (\Auth::user()->_id == '58fd6cc13fd89d8b529e4acf') {
            $masterdata = Masterdata::whereNull('deleted_at')->orderBy('created_at')->pluck('data');
        } else {
            if (!empty($masterdataIds)) {
                foreach ($masterdataIds as $masterdataId) {
                    $masterdataObjectId[] = $masterdataId['masterdata_id'];
                }
            }
            $masterdata = Masterdata::whereNull('deleted_at')->whereIn('data.objectId',$masterdataObjectId)->orderBy('created_at')->pluck('data');
        }

        return view('masterdata.index',compact('masterdata'));

	}

    public function mymasterdata () {
        $masterdata = Masterdata::whereNull('deleted_at')->where('data.createdBy',\Auth::user()->_id)->orderBy('_id','ASC')->pluck('data'); 
        return view('masterdata.mymasterdata',compact('masterdata'));
    }

    public function create(Request $request)
    {
        return view('masterdata.create');
    }

   	public function store(Request $request) {
        $this->validate($request, [
            'fileupload' => 'required'
        ]);

            $fileInput = $request->file('fileupload');
            
            $fileType = $fileInput->getClientOriginalExtension();
            $fileName = explode('.',$fileInput->getClientOriginalName())[0];
            $masterDataId = [];
            //$file = Excel::load($fileInput);
            $current = Carbon::now();
            $dateTime = dateFormatPattern($current);
            
            if ($fileType == "csv") {
                $reader = ReaderFactory::create(Type::CSV); 
            } else {
                $reader = ReaderFactory::create(Type::XLSX);
            }
            $reader->open($fileInput);
            
            foreach ($reader->getSheetIterator() as $sheet) {
                $masterdata = new Masterdata();
                $masterdata['data.objectType'] = 'masterdata';
                $masterdata['data.objectId'] = md5(uniqid(rand(), true));
                $masterdata['data.title'] = $sheet->getName();
                $masterdata['data.createdBy'] = \Auth::user()->_id;
                $masterdata['data.updatedBy'] = \Auth::user()->_id;
                $masterdata['data.createdAt'] = $dateTime;
                $masterdata['data.updatedAt'] = $dateTime;
                $masterdata['data.deletedAt'] = '';
                $masterdata['data.isoCreatedAt'] = new \MongoDate(strtotime($dateTime));
                $masterdata['data.isoUpdatedAt'] = new \MongoDate(strtotime($dateTime));
                $masterdata['data.version'] = 1;
                $masterdata['data.lastUpdate'] = 0;
                $masterDataId[] = $masterdata['data.objectId'];
                $data = [];
                $i=0;
                $orderBy = 1;
                $header = [];
                $data = [];
                foreach ($sheet->getRowIterator() as $row) {
                    if ($i == 0) {
                        foreach ($row as $rows) {
                            $header[md5(uniqid(rand(), true))] = $rows;
                        }
                        $masterdata['data.attribute'] = $header;

                        $data = array_combine(array_keys($header),$row);
   
                        foreach($data as $key => $value){
                            $schema = new MasterdataSchema();
                            $schema['masterdataId'] = $masterdata['data.objectId'];
                            $schema['attributeId'] = $key;
                            $schema['readable'] = $value;
                            $schema->save();
                        }
                        
                    } else {
                        $data = array_combine(array_keys($header),$row);
                        $masterdataitem = new Masterdataitem();
                        $masterdataitem['data.objectType'] = 'masterdataItem';
                        $masterdataitem['data.objectId'] = md5(uniqid(rand(), true));
                        $masterdataitem['data.masterDataId'] = $masterdata['data.objectId'];
                        $masterdataitem['data.orderIndex'] = $orderBy;
                        $masterdataitem['data.createdBy'] = \Auth::user()->_id;
                        $masterdataitem['data.updatedBy'] = \Auth::user()->_id;
                        $masterdataitem['data.createdAt'] = $dateTime;
                        $masterdataitem['data.updatedAt'] = $dateTime;
                        $masterdataitem['data.deletedAt'] = '';
                        $masterdataitem['data.isoUpdatedAt'] = new \MongoDate(strtotime($dateTime));
                        $masterdataitem['data.items'] = $data;
                        $masterdataitem->save();
                        $orderBy++;
                    }
                    $i++;
                }
                $masterdata->save();
            }
            $reader->close();

            #write new generate csv to cache
            $masteritemFind = DB::collection('masterdataitem')
                                ->where('data.masterDataId',$masterdata['data.objectId']);
            $masteritemFind = $masteritemFind->pluck('data');

            #find name of schema of masterData
            $attributeName = DB::collection('schema')
                                ->whereIn('attributeId',array_keys($masteritemFind[0]['items']));
            $attributeName = $attributeName->pluck('readable');
            

            $writer = WriterFactory::create(Type::CSV);
            $writer->openToFile(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));

            $writer->addRow(array_merge(array('id'=>'id'),array_keys($masteritemFind[0]['items'])));
            $writer->addRow(array_merge(array('id'=>'id'),$attributeName));

            foreach($masteritemFind as $item){
                $writer->addRow(array_merge(array($item['objectId']),array_values($item['items'])));
            }

            $writer->close();
       
            $files = glob(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));
            Zipper::make(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.zip'))
                    ->add($files)
                    ->close();
            \File::delete($files);

            $downloadPath = config('app.url').'/ss-webportal/storage/masterdata-csv'.'/'.$masterdata['data.objectId'].'.zip';
            $downloadPathInsert = DB::collection('masterdata')
                                    ->where('data.objectId',$masterdata['data.objectId'])
                                    ->update(array(
                                        'data.downloadPath' => $downloadPath), 
                                        ['upsert' => true]
                                    );


            //$data = $file->get();
            /*if ($data->getTitle() == '') {
                foreach ($data as $sheet) {
                    $attribute = $sheet->first()->keys()->toArray();
                    $masterdata = new Masterdata();
                    $masterdata['data.objectType'] = 'masterdata';
                    $masterdata['data.objectId'] = md5(uniqid(rand(), true));
                    $masterdata['data.title'] = $sheet->getTitle();
                    //$masterdata['data.downloadURL'] = 'https://mflf.io/ss/storage/masterdata-excel/'.$masterdata['data.title'].'.xls';
                    $masterdata['data.createdBy'] = \Auth::user()->_id;
                    $masterdata['data.updatedBy'] = \Auth::user()->_id;
                    $masterdata['data.createdAt'] = $dateTime;
                    $masterdata['data.updatedAt'] = $dateTime;
                    $masterdata['data.attribute'] = $attribute;
                    $masterdata->save();
                    $masterDataId[] = $masterdata['data.objectId'];

                    $orderBy = 1;
                    foreach ($sheet->toArray() as $result) {
                        $masterdataitem = new masterdataitem();
                        $masterdataitem['data.objectType'] = 'masterdataItem';
                        $masterdataitem['data.objectId'] = md5(uniqid(rand(), true));
                        $masterdataitem['data.masterDataId'] = $masterdata['data.objectId'];
                        $masterdataitem['data.orderIndex'] = $orderBy;
                        $masterdataitem['data.createdBy'] = \Auth::user()->_id;
                        $masterdataitem['data.updatedBy'] = \Auth::user()->_id;
                        $masterdataitem['data.createdAt'] = $dateTime;
                        $masterdataitem['data.updatedAt'] = $dateTime;
                        
                        foreach ($result as $key => $value) {
                            $masterdataitem['data.items.'.$key] = $result[$key];
                        }
                        $masterdataitem->save();
                        $orderBy++;
                    }
                }
            } else {
                $attributes = [];
                foreach ($data->first()->keys()->toArray() as $attribute) {
                    $filedId = md5(uniqid(rand(), true));
                    $attributes[$filedId] = $attribute;
                }
                $dataArrays = $data->toArray();
                $rowValue = [];
              
                $orderBy = 1;
                $masterdata = new Masterdata();
                $masterdata['data.objectType'] = 'masterdata';
                $masterdata['data.objectId'] = md5(uniqid(rand(), true));
                if ($fileType == "csv") {
                    $masterdata['data.title'] =  $fileName;
                } else {
                    $masterdata['data.title'] =  $data->getTitle();
                }
                //$masterdata['data.downloadURL'] = 'https://mflf.io/ss/storage/masterdata-excel/'.$masterdata['data.title'].'.xls';
                $masterdata['data.createdBy'] = \Auth::user()->_id;
                $masterdata['data.updatedBy'] = \Auth::user()->_id;
                $masterdata['data.createdAt'] = $dateTime;
                $masterdata['data.updatedAt'] = $dateTime;
                $masterdata['data.attribute'] = $attributes;
                $masterdata->save();
                $masterDataId[] = $masterdata['data.objectId'];
                foreach ($dataArrays as $dataArray) {
                    $rowValue = array_combine(array_keys($attributes),array_values($dataArray));
                    $masterdataitem = new masterdataitem();
                    $masterdataitem['data.objectType'] = 'masterdataItem';
                    $masterdataitem['data.objectId'] = md5(uniqid(rand(), true));
                    $masterdataitem['data.masterDataId'] = $masterdata['data.objectId'];
                    $masterdataitem['data.orderIndex'] = $orderBy;
                    $masterdataitem['data.createdBy'] = \Auth::user()->_id;
                    $masterdataitem['data.updatedBy'] = \Auth::user()->_id;
                    $masterdataitem['data.createdAt'] = $dateTime;
                    $masterdataitem['data.updatedAt'] = $dateTime;
                    $masterdataitem['data.items'] = $rowValue;
                    $masterdataitem->save();
                    $orderBy++;
                }
            }*/
            $user = User::where('_id', \Auth::user()->_id)->first();

            $user->masterdata()->attach([
                array(
                    'masterdata_id' => $masterdata['data.objectId'],
                    'masterdataRoleCode' => '8',
                    'updatedBy' => \Auth::user()->_id
                )
            ]);
    
            $masterdata->users()->attach([
                array(
                    'user_id' => \Auth::user()->_id,
                    'masterdataRoleCode' => '8',
                    'updatedBy' => \Auth::user()->_id
                )
            ]);
            $masterdata = Masterdata::whereIn('data.objectId',$masterDataId)->pluck('data');
            return view('masterdata.create',compact('masterdata'));
   	}

	    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkRolesMasterData = checkRolesMasterData($id);

        $masterdata = Masterdata::where('data.objectId',$id)->first();
        $items = $masterdata['data']['attribute'];

        return view('masterdata.show',compact('masterdata','items'));
    }

    public function destroy($masterdataId) {
        
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);

        $masterdata = Masterdata::where('data.objectId',$masterdataId)->first();
        $title = $masterdata['data']['title'];
        $masterdata->delete();
        $masterdataDeleted = Masterdata::where('data.objectId',$masterdataId)
                                        ->update(array(
                                            'data.deletedAt' => $dateTime,
                                        ));
        $masterdataItem = Masterdataitem::where('data.masterDataId',$masterdataId)->delete();

        return redirect()->route('masterdata.index')
            ->with('success','ลบ Master data '.'"'.$title.'"'.' เรียบร้อยแล้ว');
    }

    public function update(Request $request,$masterdataId) {
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        $result = [];
        $masterdata = Masterdata::where('data.objectId',$masterdataId)->first();
        $attributes = $masterdata['data']['attribute'];
        $masterdataItems = array_except($request->input(),['_method','_token']);
        if (!empty($masterdataItems)) {
            foreach ($masterdataItems as $key => $masterdataItem) {
                for ($i=0;$i<count($masterdataItem);$i++) {
                    if (is_numeric($masterdataItem[$i]) == true) {
                        $masterdataItem[$i] = floatVal($masterdataItem[$i]);
                    }
                }
                $result['data.updatedAt'] = $dateTime;
                $result['data.updatedBy'] = \Auth::user()->_id;
                $result['data.isoUpdatedAt'] = new \MongoDate(strtotime($dateTime));
                $value = array_combine(array_keys($attributes),$masterdataItem);
                $result['data.items'] = $value;
                $updated = Masterdataitem::where('data.objectId',$key)
                            ->update($result);

                $masterdataUpdate = Masterdata::where('data.objectId',$masterdataId)
                                    ->update(array(
                                        //'data.version'   => $masterdata['data']['version'] + 1,
                                        'data.lastUpdate'=> 0,
                                        'data.updatedAt' => $dateTime,
                                        'data.isoUpdatedAt' => new \MongoDate(strtotime($dateTime))
                                    ));
                $masteritemFindAll = DB::collection('masterdataitem')
                                    ->whereNull('deleted_at')
                                    ->where('data.masterDataId',$masterdataId);
                $masteritemFindAll = $masteritemFindAll->pluck('data');

                
                if(!empty($masteritemFindAll)){
                    #find name of schema of masterData
                    $attributeNameAll = DB::collection('schema')
                                        ->whereIn('attributeId',array_keys($masteritemFindAll[0]['items']));
                    $attributeNameAll = $attributeNameAll->pluck('readable');

                    $writer = WriterFactory::create(Type::CSV);
                    $writer->openToFile(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));
                    
                    $writer->addRow(array_merge(array('id'=>'id'),array_keys($masteritemFindAll[0]['items'])));
                    $writer->addRow(array_merge(array('id'=>'id'),$attributeNameAll));
      
                    foreach($masteritemFindAll as $item){  
                        $writer->addRow(array_merge(array($item['objectId']),array_values($item['items'])));
                    }
                    $writer->close();

                    $filesAll = glob(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));
                    Zipper::make(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.zip'))
                            ->add($filesAll)
                            ->close();
                    \File::delete($filesAll);

                    $downloadPath = config('app.url').'/ss-webportal/storage/masterdata-csv'.'/'.$masterdata['data.objectId'].'.zip';
                    $downloadPathInsert = DB::collection('masterdata')
                                ->where('data.objectId',$masterdata['data.objectId'])
                                ->update(array(
                                    'data.downloadPath' => $downloadPath), 
                                    ['upsert' => true]
                                );
                }

                #generate file only edit data
                #generate file : กรณีที่เก็บเฉพาะไฟล์แก้ไขเพื่อส่งให้เซอร์วิส ชื่อไฟล์เป็น masterdataId_version.zip
                #หากมีการแก้ไขให้เชคจาก query ว่ามี version ที่มากกว่าไหม ถ้ามากกว่าให้ลบไฟล์เดิมทิ้ง แล้ว generate ไฟล์ใหม่
                #write new generate csv to cache
                $masteritemFind = DB::collection('masterdataitem')
                                    ->whereNull('deleted_at')
                                    ->where('data.masterDataId',$masterdataId)
                                    ->where('data.isoUpdatedAt','>=',new \MongoDate(strtotime($dateTime)));
                $masteritemFind = $masteritemFind->pluck('data');

                
                if(!empty($masteritemFind)){
                    #find name of schema of masterData
                    $attributeName = DB::collection('schema')
                                        ->whereIn('attributeId',array_keys($masteritemFind[0]['items']));
                    $attributeName = $attributeName->pluck('readable');


                    $writer = WriterFactory::create(Type::CSV);
                    $writer->openToFile(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));

                    $writer->addRow(array_merge(array('id'=>'id'),array_keys($masteritemFind[0]['items'])));
                    $writer->addRow(array_merge(array('id'=>'id'),$attributeName));

                    foreach($masteritemFind as $item){
                        $writer->addRow(array_merge(array($item['objectId']),array_values($item['items'])));
                    }
                    $writer->close();
                    
                    $filesEdit = glob(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));
                    Zipper::make(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'_'.$masterdata['data.version'].'.zip'))
                            ->add($filesEdit)
                            ->close();
                    \File::delete($filesEdit);

                    $versionDownloadPath = config('app.url').'/ss-webportal/storage/masterdata-csv'.'/'.$masterdata['data.objectId'].'_'.$masterdata['data.version'].'.zip';
                    $versionDownloadPathInsert = DB::collection('masterdata')
                                ->where('data.objectId',$masterdata['data.objectId'])
                                ->update(array(
                                    'data.versionDownloadPath' => $versionDownloadPath), 
                                    ['upsert' => true]
                                );
                }
            }
        }
        return redirect()->back()->with('message', 'แก้ไข Master Data เรียบร้อยแล้ว');
    }

    public function editReccord(Request $request,$masterdataId) {

        $this->validate($request, [
            'fileupload' => 'required',
        ]);

        $fileInput = $request->file('fileupload');
        $fileType = $fileInput->getClientOriginalExtension();
        $fileName = explode('.',$fileInput->getClientOriginalName())[0];
        $masterDataId = [];

        $data = Excel::load($fileInput, 'UTF-8')->get();
        
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        $masterdata = Masterdata::where('data.objectId',$masterdataId)->first();
            
        $attribute = array_keys($masterdata['data']['attribute']);
        $heading = array_except($data->first()->keys()->toArray(),[0]);
        rsort($heading);
        rsort($attribute);
      
        $result = [];
        if ($heading == $attribute) {
            foreach ($data as $row => $value) {
                $result = [];
                $result['data.updatedAt'] = $dateTime;
                $result['data.isoUpdatedAt'] = new \MongoDate(strtotime($dateTime));
                $result['data.updatedBy'] = \Auth::user()->_id;
                foreach ($value as $key => $valueItem) {
                    if (count($value) == 1) {
                        /*foreach ($result['data.items'] as $keyResult => $resultItem) {
                            $result['data.items'][$keyResult] = null;
                        }
                        dd($result);*/
                        $masterdataItem = Masterdataitem::whereNull('deleted_at')->where('data.objectId',$value['id'])->delete();
                    } else {
                        if ($key != 'id') {
                            $result["data.items"][$key] = $value[$key];
                        }
                    }
                }
                    if (empty($value['id'])) {
                        if (!empty($result['data.items'])) {
                            $orderIndex = Masterdataitem::whereNull('deleted_at')->where('data.masterDataId',$masterdataId)->max('data.orderIndex');
                            $masterdataitem = new Masterdataitem();
                            $masterdataitem['data.objectType'] = 'masterdataItem';
                            $masterdataitem['data.objectId'] = md5(uniqid(rand(), true));
                            $masterdataitem['data.masterDataId'] = $masterdata['data.objectId'];
                            $masterdataitem['data.orderIndex'] = $orderIndex + 1;
                            $masterdataitem['data.createdBy'] = \Auth::user()->_id;
                            $masterdataitem['data.updatedBy'] = \Auth::user()->_id;
                            $masterdataitem['data.createdAt'] = $dateTime;
                            $masterdataitem['data.updatedAt'] = $dateTime;
                            $masterdataitem['data.deletedAt'] = '';
                            $masterdataitem['data.isoUpdatedAt'] = new \MongoDate(strtotime($dateTime));
                            $masterdataitem['data.items'] = $result['data.items'];
                            $masterdataitem->save();
                        }
                    } else if (!empty($value['id'])) {
                        $updated = Masterdataitem::where('data.objectId',$value['id'])
                                    ->update($result);
                    }
                                
                    $masterdataUpdate = Masterdata::where('data.objectId',$masterdataId)
                                        ->update(array(
                                            //'data.version'   => $masterdata['data']['version'] + 1,
                                            'data.lastUpdate'=> 0,
                                            'data.updatedAt' => $dateTime,
                                            'data.isoUpdatedAt' => new \MongoDate(strtotime($dateTime))
                                        ));

                    #generate new file all data
                    /*$file = storage_path().'/masterdata-csv/'.$masterdata['data']['objectId'].'.zip';
                      
                    $fileCsv = Excel::create($masterdata['data']['objectId'], function($excel) use($data) {
                        $excel->sheet('data', function($sheet) use($data) {
                            $sheet->fromArray($data);
                        });
                    })->store('csv', storage_path('masterdata-csv'));

                    $files = glob(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));

                    #ถ้ามีไฟล์เดิมอยู่ให้ลบทิ้งไปก่อน แล้ว generate ใหม่
                    if(file_exists($file)){
                        #delete .zip file 
                        \File::delete($file);
                        #generate new .zip file
                        Zipper::make(storage_path().'/masterdata-csv/'.$masterdata['data.objectId'].'.zip')
                                ->add($files)
                                ->close();
                        \File::delete($files);
                    
                    #ถ้าไม่มีไฟล์อยู่ให้ generate new file
                    }elseif(!file_exists($file)){
                        #generate new .zip file
                        Zipper::make(storage_path().'/masterdata-csv/'.$masterdata['data.objectId'].'.zip')
                                ->add($files)
                                ->close();
                        \File::delete($files);
                    }*/

                    $masteritemFindAll = DB::collection('masterdataitem')
                                        ->whereNull('deleted_at')
                                        ->where('data.masterDataId',$masterdataId);
                    $masteritemFindAll = $masteritemFindAll->pluck('data');

                    
                    if(!empty($masteritemFindAll)){
                        #find name of schema of masterData
                        $attributeNameAll = DB::collection('schema')
                                            ->whereIn('attributeId',array_keys($masteritemFindAll[0]['items']));
                        $attributeNameAll = $attributeNameAll->pluck('readable');

                        $writer = WriterFactory::create(Type::CSV);
                        $writer->openToFile(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));

                        $writer->addRow(array_merge(array('id'=>'id'),array_keys($masteritemFindAll[0]['items'])));
                        $writer->addRow(array_merge(array('id'=>'id'),$attributeNameAll));

                        foreach($masteritemFindAll as $item){
                            $writer->addRow(array_merge(array($item['objectId']),array_values($item['items'])));
                        }
                        $writer->close();

                        $filesAll = glob(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));
                        Zipper::make(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.zip'))
                                ->add($filesAll)
                                ->close();
                        \File::delete($filesAll);

                        $downloadPath = config('app.url').'/ss-webportal/storage/masterdata-csv'.'/'.$masterdata['data.objectId'].'.zip';
                        $downloadPathInsert = DB::collection('masterdata')
                                    ->where('data.objectId',$masterdata['data.objectId'])
                                    ->update(array(
                                        'data.downloadPath' => $downloadPath), 
                                        ['upsert' => true]
                                    );
                    }

                    #generate file only edit data
                    #generate file : กรณีที่เก็บเฉพาะไฟล์แก้ไขเพื่อส่งให้เซอร์วิส ชื่อไฟล์เป็น masterdataId_version.zip
                    #หากมีการแก้ไขให้เชคจาก query ว่ามี version ที่มากกว่าไหม ถ้ามากกว่าให้ลบไฟล์เดิมทิ้ง แล้ว generate ไฟล์ใหม่
                    #write new generate csv to cache
                    $masteritemFind = DB::collection('masterdataitem')
                                        ->whereNull('deleted_at')
                                        ->where('data.masterDataId',$masterdataId)
                                        ->where('data.isoUpdatedAt','>=',new \MongoDate(strtotime($dateTime)));
                    $masteritemFind = $masteritemFind->pluck('data');

                    
                    if(!empty($masteritemFind)){
                        #find name of schema of masterData
                        $attributeName = DB::collection('schema')
                                            ->whereIn('attributeId',array_keys($masteritemFind[0]['items']));
                        $attributeName = $attributeName->pluck('readable');


                        $writer = WriterFactory::create(Type::CSV);
                        $writer->openToFile(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));

                        $writer->addRow(array_merge(array('id'=>'id'),array_keys($masteritemFind[0]['items'])));
                        $writer->addRow(array_merge(array('id'=>'id'),$attributeName));

                        foreach($masteritemFind as $item){
                            $writer->addRow(array_merge(array($item['objectId']),array_values($item['items'])));
                        }
                        $writer->close();
                        
                        $filesEdit = glob(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'.csv'));
                        Zipper::make(storage_path('masterdata-csv/'.$masterdata['data.objectId'].'_'.$masterdata['data.version'].'.zip'))
                                ->add($filesEdit)
                                ->close();
                        \File::delete($filesEdit);

                        $versionDownloadPath = config('app.url').'/ss-webportal/storage/masterdata-csv'.'/'.$masterdata['data.objectId'].'_'.$masterdata['data.version'].'.zip';
                        $versionDownloadPathInsert = DB::collection('masterdata')
                                    ->where('data.objectId',$masterdata['data.objectId'])
                                    ->update(array(
                                        'data.versionDownloadPath' => $versionDownloadPath), 
                                        ['upsert' => true]
                                    );
                    }
                    
                    
            }
                       
            return redirect()->back()->with('message', 'แก้ไข Master Data เรียบร้อยแล้ว');
        } else {
            return Redirect::back()->withErrors(['โครงสร้างหรือคอลัมน์ไม่ตรงกับฐานข้อมูล']);
        }
    }

    public function checktitle(Request $request) {
        $dateTime = dateFormatPattern(Carbon::now());

        $titles = $request->title;
        foreach ($titles as $key => $title) {
            $data = [
                'data.title' => $title,
                'data.updatedAt' => $dateTime,
                'data.updatedBy' => \Auth::user()->_id
            ];

            $masterdata = Masterdata::where('data.objectId',$key)->update($data, ['upsert' => true]);
        }
        
        return redirect()->route('masterdata.index')
            ->with('success','สร้าง Master data '.'"'.implode(',',$titles).'"'.' เรียบร้อยแล้ว');
    }

    public function seachMasterdataItems(Request $request,$masterdataId) {
        $valueType = $request->valueType;
        $attribute = $request->attribute;
        $value = $request->value;
        if ($valueType == 'numeric') {
            $value = floatVal($value);
        }
        $masterdata = Masterdata::where('data.objectId',$masterdataId)->first();
        $masterdataItem = [];
        $attributes = $masterdata['data']['attribute'];
        if (!empty($attribute) && !empty($value)) {
            $masterdataItems = Masterdataitem::where('data.masterDataId',$masterdataId)
                                ->where("data.items.$attribute",$value)
                                ->whereNull('deleted_at')
                                ->orderBy('data.orderIndex','ASC')
                                ->paginate(100);
            $masterdataItem = $masterdataItems->pluck('data');
        }

        
        return view('masterdata.seach',compact('masterdata','items','masterdataItem','attributes'));
    }

    public function download($masterdataId) {
        $data = [];
        $masterdata = Masterdata::where('data.objectId',$masterdataId)->first();
        $masterdataItems = Masterdataitem::where('data.masterDataId',$masterdataId)
                            ->whereNull('deleted_at')
                            ->orderBy('data.orderIndex','ASC')
                            ->pluck('data');
        #$pathFile = storage_path().'/masterdata-csv'.'/'.$masterdataId . '.zip';
        #$Zip = Zipper::make($pathFile)->extractTo(storage_path().'/masterdata-unzip/');
        #$unZip = storage_path().'/masterdata-unzip/'.$masterdataId.'.csv';
        $headerExcel[] = 'id';

        $data[0]['id'] = 'id';
        $attributes = $masterdata['data']['attribute'];
        if (!empty($attributes)) {
            foreach ($attributes as $key => $attribute) {
                $headerExcel[] = $key;
                $data[0][$key] = $attribute;
            }
        } if (count($masterdataItems) > 0) {
            $i = 1;
            foreach ($masterdataItems as $masterdataItem) {
                $data[$i]['id'] = $masterdataItem['objectId'];
                foreach ($masterdataItem['items'] as $key => $value) {
                    $data[$i][$key] = $value;
                }
                $i++;
            }
        }
   
        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        $writer->openToBrowser($masterdata['data']['objectId'].'.xlsx');

        $writer->addRow($headerExcel);
        $rawData = $writer->getCurrentSheet();
        $sheet = $writer->getCurrentSheet();
        $sheet->setName($masterdata['data']['title']);  
        $writer->addRows($data);
        $writer->close();
        
        #if (file_exists($unZip)) {
            #$downloadExcel = Excel::load($unZip,'utf-8')->export('xlsx');
        #} else {
            #return Redirect::back()->withErrors(['File Dose Not Exit !']);
        #}
    }
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function access(Request $request , $masterdataId)
    {
        $masterdataRoleCodes = DB::Collection('roleCode')->where('typeRoleCode','masterdataRoleCode')->orderBy('_id','ASC')->get();
        $masterdata = DB::collection('masterdata')->where('data.objectId',$masterdataId)->pluck('data');
        $users = User::whereNull('deleted_at')->orderBy('_id','ASC')->get();
    
        return view('masterdata.access',compact('users','masterdataRoleCodes','masterdataId','masterdata' ));
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAccessPermission(Request $request, $masterDataId)
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
                   $masterdata = Masterdata::where('data.objectId',$masterDataId)->firstOrFail();
                   foreach($masterdata['user_ids'] as $masterdatum){
                       foreach($users as $user){
                           if($user['_id'] == $masterdatum['user_id']){
                               $userid[] = $user['_id'];
                           }
                       }
                   }
                   if(count($userid) > 0){
                       session::flash('message', "ผุ้ใช้นี้มีสิทธิ์ในมาสเตอร์ดาต้าแล้ว !");
                       return Redirect::back();                      
                   }
                   else{
                   #request role for update
                       $masterdataRoleCode = $request->input('masterdataRoleCode');
                       if($masterdataRoleCode != ''){
                           foreach ($users as $user) {
                               foreach($masterdata as $masterdatum){
                                   $user->masterdata()->attach([
                                       array(
                                           'masterdata_id' => $masterDataId,
                                           'masterdataRoleCode' => $masterdataRoleCode,
                                           'updatedBy' => \Auth::user()->_id
                                       )
                                   ]);

                                   $masterdata->users()->attach([
                                       array(
                                           'user_id' => $user->_id,
                                           'masterdataRoleCode' => $masterdataRoleCode,
                                           'updatedBy' => \Auth::user()->_id
                                       )
                                   ]);
                               }
                           }
                           return redirect('/masterdata/admin/access/'.$masterDataId)->with('success','เพิ่มผู้ใช้ '.$search.' สำเร็จแล้ว'); 
                       }
                       else{
                           session::flash('message', "กรุณาเลือกสิทธิ์ในการเข้าถึงมาสเตอร์ดาต้า");
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
    public function updateAccessPermission(Request $request, $masterDataId,$userId)
    {
        
        $users = User::where('_id',$userId)->firstOrFail();

        $masterdata = Masterdata::where('data.objectId',$masterDataId)->firstOrFail();

        #request role for update
        $masterdataRoleCode = $request->input('masterdataRoleCode');
        $roleCode = DB::collection('roleCode')->where('roleCode',$masterdataRoleCode)->first();
        $displayRoleCode = $roleCode['display_name'];

        $countMaster = count($masterdata->user_ids);
        $countUser = count($users->masterdata_ids);
            for($i=0; $i<$countUser; $i++){
                if($users['masterdata_ids'][$i]['masterdata_id'] == $masterDataId){
                    $users->masterdata()->detach($users['masterdata_ids'][$i]);

                    $users->masterdata()->attach([
                        array(
                            'masterdata_id' => $masterDataId,
                            'masterdataRoleCode' => $masterdataRoleCode,
                            'updatedBy' => \Auth::user()->_id
                        )
                    ]);
                }
            }   
            
            for($j=0; $j<$countMaster; $j++){
                if($masterdata['user_ids'][$j]['user_id'] == $userId){
                    $masterdata->users()->detach($masterdata['user_ids'][$j]);

                    $masterdata->users()->attach([
                        array(
                            'user_id' => $users->_id,
                            'masterdataRoleCode' => $masterdataRoleCode,
                            'updatedBy' => \Auth::user()->_id
                        )
                    ]);
                }
            }

            return redirect('/masterdata/admin/access/'.$masterDataId)->with('success','เปลี่ยนสิทธิ์ผู้ใช้ '.$users->prefix.$users->firstname.' '.$users->lastname.' เป็น '.$displayRoleCode.' เรียบร้อยแล้ว');

    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermission($masterDataId, $userId)
    {

        $masterdatas = Masterdata::where('data.objectId',$masterDataId)->firstOrFail();

        $users = User::where('_id',$userId)->firstOrFail();

        $countMaster = count($masterdatas->user_ids);
        $countUser = count($users->masterdata_ids);
            for($i=0; $i<$countUser; $i++){
                if($users['masterdata_ids'][$i]['masterdata_id'] == $masterDataId){
                    $users->masterdata()->detach($users['masterdata_ids'][$i]);
                }
            }   
            
            for($j=0; $j<$countMaster; $j++){
                if($masterdatas['user_ids'][$j]['user_id'] == $userId){
                    $masterdatas->users()->detach($masterdatas['user_ids'][$j]);
                }
            }

            return redirect('/masterdata/admin/access/'.$masterdatas['data']['objectId'])->with('success','ลบผู้ใช้ '.$users->prefix.$users->firstname.' '.$users->lastname.' ออกจากมาสเตอร์ดาต้าสำเร็จ');
    }

	public function export($id){
      	$masterdata = Masterdata::where('data.objectId',$id);
      	$masterdata = $masterdata->pluck('data.title');
      
    	$path = storage_path('masterdata-excel/'.$masterdata[0].'.xls');

        return response()->download($path);     
    }

    #groupaccess

    public function groupAccess (Request $request, $masterDataId) {
		$masterdata = Masterdata::where('data.objectId',$masterDataId)->pluck('data');
        $masterdataRoleCodes = DB::Collection('roleCode')->where('typeRoleCode','masterdataRoleCode')->orderBy('_id','ASC')->get();
		$groups = Group::whereNull('deleted_at')->orderBy('_id','ASC')->get();
		
		return view('masterdata.groupaccess',compact('groups','masterdataRoleCodes', 'masterDataId' ,'masterdata'));
	}

	public function groupStoreAccessPermission(Request $request, $masterDataId)
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
				$mastedata = Masterdata::where('data.objectId',$masterDataId)->firstOrFail();

				$groupid = [];
				if (!empty($mastedata['group_ids'])) {
					foreach($mastedata['group_ids'] as $mastedatum){
						foreach($groups as $group){
							if($group['_id'] == $mastedatum['group_id']){
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
					$masterdataRoleCode = $request->input('masterdataRoleCode');
					if($masterdataRoleCode != ''){
						foreach ($groups as $group) {
                            $mastedata->groups()->attach([
                                array(
                                    'group_id' => $group->_id,
                                    'masterdataRoleCode' => $masterdataRoleCode,
                                    'updatedBy' => \Auth::user()->_id
                                )
                            ]);
							$group->masterdata()->attach([
								array(
									'masterdata_id' => $masterDataId,
									'masterdataRoleCode' => $masterdataRoleCode,
									'updatedBy' => \Auth::user()->_id
								)
							]);
						}
						return redirect('/masterdata/admin/group/access/'.$masterDataId)->with('success','เพิ่มกลุ่ม '.$search.' สำเร็จแล้ว'); 
					}
					else{
						session::flash('message', "กรุณาเลือกสิทธิ์ในการเข้าถึงมาสเตอร์ดาต้า");
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

	public function groupUpdateAccessPermission(Request $request, $masterDataId,$groupId)
	{

		$groups = Group::where('_id',$groupId)->firstOrFail();

		$masterdata = Masterdata::where('data.objectId',$masterDataId)->firstOrFail();
		
	   #request role for update
		$masterdataRoleCode = $request->input('masterdataRoleCode');
		$countMaster = count($masterdata->group_ids);
        $countGroup = count($groups->masterdata_ids);
        
        for($i=0; $i<$countGroup; $i++){
            if($groups['masterdata_ids'][$i]['masterdata_id'] == $masterDataId){
                $groups->masterdata()->detach($groups['masterdata_ids'][$i]);

                $groups->masterdata()->attach([
                    array(
                        'masterdata_id' => $masterDataId,
                        'masterdataRoleCode' => $masterdataRoleCode,
                        'updatedBy' => \Auth::user()->_id
                    )
                ]);
            }
        }   
        
        for($j=0; $j<$countMaster; $j++){
            if($masterdata['group_ids'][$j]['group_id'] == $groupId){
                $masterdata->groups()->detach($masterdata['group_ids'][$j]);

                $masterdata->groups()->attach([
                    array(
                        'group_id' => $groups->_id,
                        'masterdataRoleCode' => $masterdataRoleCode,
                        'updatedBy' => \Auth::user()->_id
                    )
                ]);
            }
        }
        
		   //return redirect('/forms/admin/access/'.$formId)->with('success','Update permission successfully');
		return Redirect::back()->with('success','เปลี่ยนสิทธิ์การเข้าถึงมาสเตอร์ดาต้าของกลุ่ม '.$groups->name.' สำเร็จแล้ว');
	}

	public function groupDestroyPermission($masterDataId, $groupId)
	{

		$masterdata = Masterdata::where('data.objectId',$masterDataId)->firstOrFail();

		$groups = Group::where('_id',$groupId)->firstOrFail();

		$countMaster = count($masterdata->group_ids);
		$countGroup = count($groups->form_ids);

		for ($i=0; $i<$countGroup; $i++) {
			if ($groups['masterdata_ids'][$i]['masterdata_id'] == $masterDataId) {
				$groups->masterdata()->detach($groups['masterdata_ids'][$i]);
			}
		}   
		
		for ($j=0; $j<$countMaster; $j++) {
			if ($masterdata['group_ids'][$j]['group_id'] == $groupId) {
				$masterdata->groups()->detach($masterdata['group_ids'][$j]);
			}
		}

			//return redirect('/forms/admin/access/'.$forms['data']['objectId'])->with('success','Delete permission successfully');
		return Redirect::back()->with('success','ลบสิทธิ์ของกลุ่ม '.$groups->name.' เรียบร้อยแล้ว');
	}

}
