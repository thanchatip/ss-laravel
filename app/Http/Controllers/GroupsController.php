<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Group;
use App\Role;
use DB;
use Hash;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class GroupsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = \Request::get('search');
        if (\Auth::user()->firstname == 'admin') {
            if($search == null){
                $data = Group::orderBy('_id','ASC')->paginate(10);
            }else{
                $data = Group::where('name','like','%'.$search.'%')
                    ->orderBy('_id','ASC')
                    ->paginate(10);
            }
        }elseif($adminGroup = \Auth::user()->group_ids){
            if($search == null){
                $data = Group::whereIn('_id',$adminGroup)->paginate(10);
            }else{
                $data = Group::whereNull('deleted_at')->where('name','like','%'.$search.'%')
                    ->whereIn('_id',$adminGroup)
                    ->orderBy('_id','ASC')
                    ->paginate(10);
            }
        }elseif(empty($adminGroup)){
            $data = [];
        }
            return view('groups.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = User::whereNull('deleted_at')->get();

	        return view('groups.create',compact('user','role'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $authid = \Auth::user()->_id;

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);


        $roles = Role::where('display_name','User')->get();

        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->createdBy = \Auth::user()->_id;
        $group->save();
             
        #owner group
        $group->users()->attach([
            'user_id' => $authid,
            'status' => '1'
        ]);

        return redirect()->route('groups.index')
                ->with('success','Group created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $authid = \Auth::user()->_id;
        $group = Group::find($id);
        
        if($admin = \Auth::user()->firstname == 'admin') {
            $status = 1;
        }
        
        if(!empty($group->user_ids)){
            foreach($group->user_ids as $key){
                if($key['user_id'] == $authid && $key['status'] == "0"){
                    $status = 0;
                }
                elseif($key['user_id'] == $authid && $key['status'] == "1"){
                    $status = 1;
                }
            }
        }
        $users = Group::where('_id',$id)->with('users')->get();
        return view('groups.show',compact('users','group','status'));
    }
    


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $group = Group::find($id);
        $user = User::all();
        $role = Role::where('type', '!=' ,'form')->lists('display_name','_id');

        $userGroups = DB::table('users')
            ->where('group_ids',$id)
            ->lists('_id','_id');


            return view('groups.edit',compact('group','user','userGroups','role'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser($id,$groupid){

        $user = User::find($id);
            return view('groups.edituser',compact('user','groupid'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'same:confirm-password',
        ]);


        $input = $request->all();

        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);

            return redirect('groups')
                ->with('success','User updated successfully');

    }

    public function adduser(Request $request, $id){
        $this->validate($request, [
            'username' => 'required',
        ]); 

        $groups = Group::where('_id',$id)->firstOrFail();
        
        $username = $request->input('username');
        // Split each Name by Spaces
        $names = explode(" ", $username);

        // Search each Name Field for any specified Name
        $users = User::whereNull('deleted_at')
                ->where(function($query) use ($names) {
                    $query->whereIn('firstname', $names);
                $query->where(function($query) use ($names) {
                    $query->whereIn('lastname', $names);
            });
        })->first();

        if (count($users) > 0) {
            $groups->users()->attach(['user_id' => $users['_id'],'status' => '0']);   
            return redirect('/groups/'.$id)->with('success','add user successfully');
        } else {
            return redirect('/groups/'.$id)->with('danger','ไม่มี user อยู่ในระบบ');
        }
    }

    public function updatepermission(Request $request,$groupid){

        $groups = Group::where('_id',$groupid)->firstOrFail();
        $countgroup = count($groups['user_ids']);
        for($i=0; $i<$countgroup; $i++){
            if($groups['user_ids'][$i]['user_id'] == $request['userid']){
                $groups->users()->detach($groups['user_ids'][$i]);
                if($request->input('permission') == '0'){  
                    $groups->users()->attach([
                            'user_id' => $request['userid'],
                            'status' => '1',
                    ]);
                }else{
                    $groups->users()->attach([
                            'user_id' => $request['userid'],
                            'status' => '0',
                    ]);
                }
            }               
        }
        return redirect('/groups/'.$groupid)->with('success','successfully');
    }

    public function deleteuser($userid,$groupid){
        $groups = Group::where('_id',$groupid)->first();
        $groups->users()->detach([$userid]);
        $groups->users()->detach([ 'user_id' => $userid]);

        return redirect('/groups/'.$groupid)->with('success','Delete User successfully');
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

        $group = DB::collection('groups')->where('_id',$id)->update(array('name'=>$request->input('name')));

        $group = Group::find($id);
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->updatedBy = \Auth::user()->_id;
        $group->save();

        /*$users = $request->input('user');
        $roles = $request->input('role');

        $group->users()->sync($users);

        //Just Work!!
        foreach ($users as $key => $value) {
            $user = User::where('_id', '=', $value)->first();

            if(!empty($users)){
                if (!empty($roles)) {
                    foreach ($roles as $key => $value) {
                        $user->attachRole($value);
                    }
                }
            }
        }*/

        return redirect()->route('groups.index')
               ->with('success','Group updated successfully');

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $groups = Group::where('_id',$id)->firstOrFail();
        /*$countgroup = count($groups['user_ids']);
        for($i=0; $i<$countgroup; $i++){
            $groups->users()->detach($groups['user_ids'][$i]['user_id']); 
        }*/
        $groups->delete();
        return redirect()->route('groups.index')->with('success','Group deleted successfully');
    }


    public function importCsv($id)
    {
        $file = \Input::file('usersImport');
        $userArr = csvToArray($file);

        //dd($userArr);

        #step: insert user ลง db collection ('users')
        for ($i = 0; $i < count($userArr); $i++){
            #step: access group
            $group = Group::find($id);
            
            #defalut role
            $roles = Role::where('display_name','User')->get();

            #step: generate email, password
            $email[$i] = 'oiltea'.$i.'@mflf.io';
            $userArr[$i] = array_merge($userArr[$i], array('email' => $email[$i]),array('password' => Hash::make($userArr[$i]['code'])));
            $user = DB::collection('users')->insert($userArr[$i]);
            $users = User::where('code',$userArr[$i]['code'])->get();
            
            #step: access status 0,1 admin or user
            foreach($users as $userid){
                $group->users()->attach([
                            'user_id' => $userid->id,
                            'status' => '0'
                ]);
                foreach ($roles as $role) {
                    $userid->attachRole($role['_id']);
                }
            }

            
        }
        return \Redirect::to('users')->with('message', 'Import CSV');
    }

    public function export($id){

        
        $group = Group::whereNull('deleted_at')->where('_id',$id)->get();
        $group_id = $group->pluck('user_ids');
        foreach($group_id as $group_ids){
            foreach($group_ids as $groupid){
                $groupids[] = $groupid['user_id'];
            }
        }
        $user = User::whereNull('deleted_at')->whereIn('_id',$groupids)->get();
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        Excel::create("กลุ่ม".$group[0]['name']." ".$dateTime, function($excel) use ($user,$group)  {
            $excel->sheet('ข้อมูลผู้ใช้', function($sheet) use ($user,$group){
                        $sheet->loadView('groups.showexcel', array('users' => $user, 'groups' => $group));
                });       
        })->export('xls');
    }
}