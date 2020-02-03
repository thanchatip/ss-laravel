<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Group;
use App\Masterlist;
use App\Masterlistitem;
use DB;
use Hash;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Input;
use Session;
use Redirect;


class MasterlistsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {

        $AuthMasterlists = \Auth::user()->masterlist_ids;
   
        if (\Auth::user()->firstname == 'admin') {
            $masterlists    =  DB::collection('masterlist')
                                ->whereNull('deleted_at')
                                ->orderBy('_id','ASC')
                                ->paginate(10);
        } elseif ($AuthMasterlists != null){

            foreach ($AuthMasterlists as $AuthMasterlist) {
                $masterListIds[] = $AuthMasterlist['masterList_id'];
            }

            if ($masterlist_ids = $AuthMasterlist['masterList_id']){
                $masterlists    = DB::collection('masterlist')
                                    ->whereNull('deleted_at')
                                    ->whereIn('data.objectId', $masterListIds)
                                    ->paginate(10);
            }
    
        }elseif(empty($AuthMasterlists)){
            $masterlists = [];
        }

            return view('masterlists.index',compact('masterlists','AuthMasterlists'))
                    ->with('i', ($request->input('page', 1) - 1) * 10);
    
    }

    public function importmasterlist() {
        return view('masterlists.import');
    }

    public function import() {

        $path = Input::file('masterlistfile')->getRealPath();
        $data = Excel::load($path, function($reader) {}, 'UTF-8')->get();

        foreach ($data as $key => $value) {
                $current    = Carbon::now();
                $dateTime   = dateFormatPattern($current);
            if (empty($value['title']) && empty($value['description']) && empty($value['item'])) {
                Session::flash('message', "Import Error");
                    return Redirect::back();
            } else {
                if(!empty($value->title)){
                    $masterlist                     = new Masterlist();
                    $masterlist['data.objectType']  = 'masterlist';
                    $masterlist['data.objectId']    = generateRandomString();
                    $masterlist['data.title']       = $value->title;
                    $masterlist['data.description'] = $value->description;
                    $masterlist['data.createdBy']   = \Auth::user()->_id;
                    $masterlist['data.createdAt']   = $dateTime;
                    $masterlist['data.updatedAt']   = $dateTime;
                    $masterlist['data.isoUpdatedAt']= isoDateConvert($dateTime);
                    $masterlist->save();
                
                    $user = User::where('_id', \Auth::user()->_id)->first();
                    $user->masterlists()->attach([
                            array(
                                'masterList_id'      => $masterlist['data.objectId'],
                                'masterlistRoleCode' => '5'
                            )
                        ]);
                    $masterlist->users()->attach([
                            array(
                                'user_id' => \Auth::user()->_id,
                                'masterlistRoleCode' => '5'
                            )
                        ]);

                    $items                      = new Masterlistitem();
                    $items['data.objectType']   = 'masterlistitem';
                    $items['data.objectId']     = generateRandomString();
                    $items['data.title']        = $value->item;
                    $items['data.createdBy']    = \Auth::user()->_id;
                    $items['data.createdAt']    = $dateTime;
                    $items['data.updatedAt']    = $dateTime;
                    $items['data.isoUpdatedAt'] = isoDateConvert($dateTime);
                    $items['data.masterListId'] = $masterlist['data.objectId'];
                    $items->save();

                } else {
                    
                    $items                      = new Masterlistitem();
                    $items['data.objectType']   = 'masterlistitem';
                    $items['data.objectId']     = generateRandomString();
                    $items['data.title']        = $value->item;
                    $items['data.createdBy']    = \Auth::user()->_id;
                    $items['data.createdAt']    = $dateTime;
                    $items['data.updatedAt']    = $dateTime;
                    $items['data.isoUpdatedAt'] = isoDateConvert($dateTime);
                    $items['data.masterListId'] = $masterlist['data.objectId'];
                    $items->save();
                }
            }
        }
          return back()->with('success','Import Success');    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('masterlists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

          $this->validate($request, [
            'title' => 'required',
            'items' => 'required'
          ]);
        
        $current    = Carbon::now();
        $dateTime   = dateFormatPattern($current);

        $masterlist = new Masterlist();
        $masterlist['data.objectType']  = 'masterlist';
        $masterlist['data.objectId']    = generateRandomString();
        $masterlist['data.title']       = $request->input('title');
        $masterlist['data.description'] = $request->input('description');
        $masterlist['data.createdBy']   = \Auth::user()->_id;
        $masterlist['data.createdAt']   = $dateTime;
        $masterlist['data.updatedAt']   = $dateTime;
        $masterlist['data.isoUpdatedAt']= isoDateConvert($dateTime);
        $masterlist->save();

        $user       = User::where('_id', \Auth::user()->_id)->first();

        $user->masterlists()->attach([
                    array(
                        'masterList_id' => $masterlist['data.objectId'],
                        'masterlistRoleCode' => '5'
                    )
                ]);

        $masterlist->users()->attach([
                    array(
                        'user_id' => \Auth::user()->_id,
                        'masterlistRoleCode' => '5'
                    )
                ]);
        $i = 0;
        foreach($request->input('items') as $key => $value){
            $items  = new Masterlistitem();
            $items['data.objectType']   = 'masterlistitem';
            $items['data.objectId']     = generateRandomString();
            $items['data.title']        = $value;
            $items['data.createdBy']    = \Auth::user()->_id;
            $items['data.createdAt']    = $dateTime;
            $items['data.updatedAt']    = $dateTime;
            $items['data.isoUpdatedAt'] = isoDateConvert($dateTime);
            $items['data.masterListId'] = $masterlist['data.objectId'];
            $items['data.orderIndex']   = $i;
            $items->save();
            $i++;
        }

        return redirect()->route('masterlists.index')
                ->with('success','Masterlist created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $masterlists    = DB::collection('masterlist')
                            ->where('data.objectId',$id)
                            ->get();
        
        $items          = DB::collection('masterlistitem')
                            ->where('data.masterListId',$id)
                            ->get();
        
        $userMasterlists= DB::collection('users')
                            ->where('masterlist_ids.masterList_id', $id)
                            ->get();
        
            return view('masterlists.show',compact('masterlists','items','id','userMasterlists'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) { 

        $masterlists    = Masterlist::where('data.objectId',$id);
        $items          = Masterlistitem::where('data.masterListId','=',$id);
        $masterlists    = $masterlists->pluck('data');
        $items          = $items->pluck('data');

            return view('masterlists.edit',compact('masterlists','items'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id) {

        $current    = Carbon::now();
        $dateTime   = dateFormatPattern($current);
        
        $masterlists=  Masterlist::where('data.objectId', $id)
                        ->update(array(
                            'data.title'        => $request->input('title'),
                            'data.description'  => $request->input('description'),
                            'data.updatedBy'    => \Auth::user()->_id,
                            'data.updatedAt'    => $dateTime,
                            'data.isoUpdatedAt' => isoDateConvert($dateTime)
                        ));

        return redirect()->route('masterlists.index')
               ->with('success','Masterlist updated successfully'); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $masterlist = Masterlist::where('data.objectId',$id);
        $masterlist->delete();
        $items      = Masterlistitem::where('masterListId',$id);
        $items->delete();
            return redirect()->route('masterlists.index')
                    ->with('success','Masterlist and Masterlist Items deleted successfully');
    }

    public function updateitem(Request $request,$id) {
        $items      = Masterlistitem::whereNull('deleted_at')
                        ->where('data.masterListId',$id)
                        ->get();

        $current    = Carbon::now();
        $dateTime   = dateFormatPattern($current);

        $i = count($items);
        foreach($request->input('items') as $key => $value) {
            $items  = new Masterlistitem();
            $items['data.objectType']   = 'masterlistitem';
            $items['data.objectId']     = generateRandomString();
            $items['data.title']        = $value;
            $items['data.createdBy']    = \Auth::user()->_id;
            $items['data.createdAt']    = $dateTime;
            $items['data.updatedAt']    = $dateTime;
            $items['data.isoUpdatedAt'] = isoDateConvert($dateTime);
            $items['data.masterListId'] = $id;
            $items['data.orderIndex']   = $i;
            $items->save();
            $i++;
        }
        return redirect()->route('masterlists.show',$id)
               ->with('success','Inert Items successfully');
    }
    
    public function deleteitems($id,$idmasterlist) {
        $current    = Carbon::now();
        $dateTime   = dateFormatPattern($current);
        $markDeletedAt = Masterlistitem::where('data.objectId',$id)
                            ->update(array(
                                'data.updatedAt'    => $dateTime,
                                'data.isoUpdatedAt' => isoDateConvert($dateTime),
                                'data.deletedAt'    => $dateTime
                            ));
        $items  = Masterlistitem::where('data.objectId',$id);
        $items->delete();
        
        return redirect()->route('masterlists.show',$idmasterlist)
                ->with('success','Delete Items successfully'); 
    }
    
    public function showitem($id,$idmasterlist) {
        $items = Masterlistitem::where('data.objectId',$id);
        $items = $items->pluck('data');
        return view('masterlists.showitems',compact('id','idmasterlist','items'));
    }

    public function fixitems($id,$idmasterlist,Request $request) {
        $current    = Carbon::now();
        $dateTime   = dateFormatPattern($current);
        $items      = Masterlistitem::where('data.objectId', $id)
                        ->update(array(
                            'data.title'        => $request->input('title'),
                            'data.updatedAt'    => $dateTime,
                            'data.isoUpdatedAt' => isoDateConvert($dateTime)
                        ));
        $list       = Masterlist::where('data.objectId', $idmasterlist)
                        ->update(array(
                            'data.updatedAt'    => $dateTime,
                            'data.isoUpdatedAt' => isoDateConvert($dateTime)
                        ));

          return redirect()->route('masterlists.show',$idmasterlist)
                 ->with('success','Item updated successfully'); 
      }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function access(Request $request , $masterListId) {

        $search             = \Request::get('search');
        $masterlistRoleCode = DB::Collection('roleCode')
                                ->where('typeRoleCode','masterlistRoleCode')
                                ->orderBy('roleCode','ASC')
                                ->get();
        $masterlists        = DB::collection('masterlist')
                                ->where('data.objectId',$masterListId);
        $masterlists        = $masterlists->pluck('data');

            if ($search == null) {
                $users      = User::whereNull('deleted_at')
                                ->orderBy('_id','ASC')
                                ->get();
            } else {
                $users      = User::whereNull('deleted_at')
                                ->where('code','like','%'.$search.'%')
                                ->orWhere('firstname','like','%'.$search.'%')
                                ->orWhere('lastname','like','%'.$search.'%')
                                ->orWhere('email','like','%'.$search.'%')
                                ->orderBy('_id','ASC')
                                ->get();
            }
        
            return view('masterlists.access',compact('users','masterlistRoleCode','masterListId','masterlists' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAccessPermission(Request $request, $masterListId) {
        
    	$search = $request->input('query');
    	if (empty($search)) {
    		session::flash('message', "Please Input Name !");
    		    return Redirect::back();            
    	} else {
        // Split each Name by Spaces
    		$names  =   explode(" ", $search);
        // Search each Name Field for any specified Name
            $users  =   User::whereNull('deletedAt')
                            ->where(function($query) use ($names) {
    		            	    $query->whereIn('firstname', $names);
    			                $query->where(function($query) use ($names) {
    				                $query->whereIn('lastname', $names);
    			                });
    		            })->get();
    		if (count($users) > 0) {
            /*Session::flash('message', "HAVE NO USERS");
            return Redirect::back();*/
            $userid         = [];
            $masterlists    = Masterlist::where('data.objectId',$masterListId)->firstOrFail();

            foreach ($masterlists['user_ids'] as $masterlist) {
            	foreach ($users as $user) {
            		if ($user['_id'] == $masterlist['user_id']) {
            			$userid[] = $user['_id'];
            		}
            	}
            }
            if(count($userid) > 0) {
            	session::flash('message', "User นี้มีสิทธิ์ในลิสต์แล้ว");
            	    return Redirect::back();                      
            } else {
            #request role for update
            	$masterlistRoleCode     = $request->input('masterlistRoleCode');
            	if($masterlistRoleCode != ''){
            		foreach ($users as $user) {
            			foreach ($masterlists as $masterlist) {
            				$user->masterlists()->attach([
            					array(
            						'masterList_id' => $masterListId,
            						'masterlistRoleCode' => $masterlistRoleCode,
            						'updatedBy' => \Auth::user()->_id
            					)
            				]);

            				$masterlists->users()->attach([
            					array(
            						'user_id' => $user->_id,
            						'masterlistRoleCode' => $masterlistRoleCode,
            						'updatedBy' => \Auth::user()->_id
            					)
            				]);
            			}
            		}
            		return redirect('/masterlists/admin/access/'.$masterListId)->with('success','Add User successfully');
            	} else {
            		session::flash('message', "Please Select Masterlist Role");
            		return Redirect::back();
            	}
            }
          } else{
          	session::flash('message', "Don't Have Users");
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
    public function updateAccessPermission(Request $request, $masterListId,$userId) {

        $users          = User::where('_id',$userId)->firstOrFail();

        $masterlists    = Masterlist::where('data.objectId',$masterListId)->firstOrFail();

        #request role for update
        $masterlistRoleCode = $request->input('masterlistCode');


        $countMaster    = count($masterlists->user_ids);
        $countUser      = count($users->masterlist_ids);
            for($i=0; $i<$countUser; $i++){
                if($users['masterlist_ids'][$i]['masterList_id'] == $masterListId){
                    $users->masterlists()->detach($users['masterlist_ids'][$i]);

                    $users->masterlists()->attach([
                        array(
                            'masterList_id' => $masterListId,
                            'masterlistRoleCode' => $masterlistRoleCode,
                            'updatedBy' => \Auth::user()->_id
                        )
                    ]);
                }
            }   
            
            for($j=0; $j<$countMaster; $j++){
                if($masterlists['user_ids'][$j]['user_id'] == $userId){
                    $masterlists->users()->detach($masterlists['user_ids'][$j]);

                    $masterlists->users()->attach([
                        array(
                            'user_id' => $users->_id,
                            'masterlistRoleCode' => $masterlistRoleCode,
                            'updatedBy' => \Auth::user()->_id
                        )
                    ]);
                }
            }

            return redirect('/masterlists/admin/access/'.$masterListId)->with('success','Update permission successfully');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request) {
        
        $datas  = User::whereNull('deleted_at')
                    ->where("firstname","LIKE","%{$request->input('query')}%")
                    ->get();

        $data   = null;
        
        foreach($datas as $idata){
            $data[] = $idata['firstname'].' '.$idata['lastname'];
        }
       
            return response()->json($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermission($masterListId, $userId) {

        $masterlists    = Masterlist::where('data.objectId',$masterListId)->firstOrFail();

        $users          = User::where('_id',$userId)->firstOrFail();

        $countMaster    = count($masterlists->user_ids);
        $countUser      = count($users->masterlist_ids);
            for($i=0; $i<$countUser; $i++){
                if($users['masterlist_ids'][$i]['masterList_id'] == $masterListId){
                    $users->masterlists()->detach($users['masterlist_ids'][$i]);
                }
            }   
            
            for($j=0; $j<$countMaster; $j++){
                if($masterlists['user_ids'][$j]['user_id'] == $userId){
                    $masterlists->users()->detach($masterlists['user_ids'][$j]);
                }
            }

            return redirect('/masterlists/admin/access/'.$masterlists['data']['objectId'])->with('success','Delete permission successfully');
    }

    public function export($id) {
      $masterlist       = Masterlist::where('data.objectId',$id);
      $masterlist       = $masterlist->pluck('data');
      
      $masterlistitem   = Masterlistitem::where('data.masterListId',$id);
      $masterlistitem   = $masterlistitem->pluck('data');
        foreach($masterlistitem as $masterlistitems){
            $masterlistitemnew[] =  array(
                                        'title' => $masterlistitems['title'],
                                        'createdAt' => $masterlistitems['createdAt'],
                                        'updatedAt' => $masterlistitems['updatedAt']
                                );
        }
            return  Excel::create($masterlist[0]['title'], function($excel) use ($masterlistitemnew,$masterlist) {
                        $excel->sheet($masterlist[0]['title'], function($sheet) use ($masterlistitemnew,$masterlist) {
                            $sheet->fromArray($masterlistitemnew);
                        });
                    })->export('xls');        
    }
}