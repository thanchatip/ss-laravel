<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Group;
use DB;
use Hash;
use Input;
use Session;
use Redirect;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class UsersController extends Controller
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
            if ($search == null){
                $users = User::whereNull('deleted_at')->orderBy('_id','ASC')->paginate(25);
            } else {
                $users = User::where('code','like','%'.$search.'%')
                    ->orWhere('firstname','like','%'.$search.'%')
                    ->orWhere('lastname','like','%'.$search.'%')
                    ->orWhere('email','like','%'.$search.'%')
                    ->orderBy('_id','ASC')
                    ->whereNull('deleted_at')
                    ->paginate(25);
                    
            }
            $groups = Group::whereNull('deleted_at')->get();

            $adminGroup = [];
            return view('users.index',compact('users','groups','adminGroup'));
        } elseif (empty(\Auth::user()->group_ids)) {
            if ($search == null) {
                $users = User::whereNull('deleted_at')->where('_id',\Auth::user()->_id)->paginate(25);
                $groups[] = null;
            } else {
               $users = User::whereNull('deleted_at')->where('_id',\Auth::user()->_id)->paginate(25);
                $groups[] = null;
            }
            return view('users.index',compact('users','groups','adminGroup'));
        } else {
            $idgroup = \Auth::user()->group_ids;
            $adminGroup = [];
            foreach ($idgroup as $idgroups) {
                $groups_id[] = Group::whereNull('deleted_at')->where('_id',$idgroups)->get();
            }
            foreach ($groups_id as $key) {
                foreach ($key as $value) {
                    $adminGroup[] = $value['_id'];
                }
            }      
            if ($search == null && !empty($adminGroup)) {
                $users = User::whereNull('deleted_at')->whereIn('group_ids',$adminGroup)->paginate(25);
            } else if ($search == null && empty($adminGroup)) {
                $users = User::whereNull('deleted_at')->where('_id',\Auth::user()->_id)->paginate(25);
            } else {
                $users = User::where('code','like','%'.$search.'%')
                    ->orWhere('firstname','like','%'.$search.'%')
                    ->orWhere('lastname','like','%'.$search.'%')
                    ->orWhere('email','like','%'.$search.'%')
                    ->WhereIn('group_ids',$adminGroup)
                    ->orderBy('_id','ASC')
                    ->whereNull('deleted_at')
                    ->paginate(25);
            }
            $groups = Group::whereNull('deleted_at')->get();
            return view('users.index',compact('users','groups','adminGroup'));
            
        }     
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::where('type' ,'')->lists('display_name','_id');
        $prefix = DB::collection('prefix')->lists('name' , 'name');
            return view('users.create',compact('roles','prefix'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'prefix' => 'required',
            'firstname' => 'required|regex:/^\S*$/u',
            'lastname' => 'required|regex:/^\S*$/u',
            'code' => 'required',
            'password' => 'required|same:confirm-password',
            'email' => 'required|unique:users,email',
            'allowCreateForm' => 'required|',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['allowCreateForm'] = intval($input['allowCreateForm']);
        //$user = DB::collection('users')->insert($input);
        $user = User::create($input);

        if (!empty($request->input('roles'))) {
            foreach ($request->input('roles') as $key => $value) {
                $user->attachRole($value);
            }
        }

        return redirect()->route('users.index')
            ->with('success','User '.$input['firstname']." ".$input['lastname'].' created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);
        if (\Auth::user()->firstname == 'admin') {
            $groupids = $user['group_ids'];
            if (!empty($user['group_ids'])) {
                $groups =   Group::whereNull('deleted_at')
                            ->whereIn('_id',$groupids)
                            ->get();
                $forms  =   DB::collection('form');
                $forms  =   $forms->pluck('data');

                $questionRoleCode = DB::collection('roleCode')
                                    ->where('typeRoleCode','questionFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();
                $answerRoleCode   = DB::collection('roleCode')
                                    ->where('typeRoleCode','answerFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();


            } elseif(empty($user['group_ids'])) {
                $groups = [];
                $forms = DB::collection('form');
                $forms = $forms->pluck('data');

                $questionRoleCode = DB::collection('roleCode')
                                    ->where('typeRoleCode','questionFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();
                $answerRoleCode   = DB::collection('roleCode')
                                    ->where('typeRoleCode','answerFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();

            }
        } else {
            $groupids = \Auth::user()->group_ids;
            if(!empty($groupids)){
                $groups =   Group::whereNull('deleted_at')
                            ->whereIn('_id',$groupids)
                            ->get();
                $forms  = DB::collection('form');
                $forms  = $forms->pluck('data');

                $questionRoleCode = DB::collection('roleCode')
                                    ->where('typeRoleCode','questionFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();
                $answerRoleCode   = DB::collection('roleCode')
                                    ->where('typeRoleCode','answerFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();

            } elseif(empty($groupds)) {
                $groups = [];
                $forms = DB::collection('form');
                $forms = $forms->pluck('data');
                
                $questionRoleCode = DB::collection('roleCode')
                                    ->where('typeRoleCode','questionFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();
                $answerRoleCode   = DB::collection('roleCode')
                                    ->where('typeRoleCode','answerFormRoleCode')
                                    ->orderBy('roleCode','ASC')
                                    ->get();

            }
        }
        return view('users.show',compact('user','groups','forms','questionRoleCode','answerRoleCode'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::find($id);

        $roles = Role::where('type','')->lists('display_name','_id');
        $userRole = $user->roles->lists('_id','_id')->toArray();

        $group = Group::whereNull('deleted_at')->get();
        $userGroups = DB::table('groups')
            ->where('user_ids.user_id',$id)
            ->lists('_id','_id');

            return view('users.edit',compact('user','userRole','roles','userGroups','group'));

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
            'firstname' => 'required|regex:/^\S*$/u',
            'lastname' => 'required|regex:/^\S*$/u',
            'password' => 'same:confirm-password',
        ]);

        $input = $request->all();
        $input['allowCreateForm'] = intval($input['allowCreateForm']);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        if (!empty($request->input('roles'))) {
            foreach ($request->input('roles') as $key => $value) {
                $user->attachRole($value);
            }
            foreach ($user->role_ids as $roles) {
                if (!in_array($roles,$request->input('roles'))) {
                    $user->detachRole($roles);
                }
            }
        } else {
            foreach ($user->role_ids as $roles) {
                $user->detachRole($roles);
            }
        }

        $groups = $request->input('group');
        $trueid = []; $falseid = [];
        if (!empty($user->group_ids)) {
            if (empty($groups)) {
                foreach ($user->group_ids as $userGroup) {
                    $groups = Group::where('_id',$userGroup)->firstOrFail();
                    $countgroup = count($groups['user_ids']);
                    for ($i=0; $i<$countgroup; $i++) {
                        if ($groups['user_ids'][$i]['user_id'] == $id) {
                            $groups->users()->detach($groups['user_ids'][$i]);
                        }               
                    } 
                }
            } else {
                foreach ($groups as $groupid) {
                    if (in_array($groupid,$user->group_ids)) {
                        $trueid[] = $groupid;
                    }
                    else {
                        $falseid[] = $groupid;
                    }
                }

                if (!empty($falseid)) {
                    foreach ($falseid as $falseids) {
                        $group = Group::find($falseids);
                        $group->users()->attach([
                            'user_id' => $id,
                            'status' => '0'
                        ]);
                    }
                    $groupdetech = [];
                    foreach ($user->group_ids as $userid) {
                        if (!in_array($userid,$groups)) {
                            $groupdetech[] = $userid;
                        }
                    }
                    if (!empty($groupdetech)) {
                        foreach ($groupdetech as $groupdetechs) {
                            $groups = Group::where('_id',$groupdetechs)->firstOrFail();
                            $countgroup = count($groups['user_ids']);
                            for ($i=0; $i<$countgroup; $i++) {
                                if ($groups['user_ids'][$i]['user_id'] == $id) {
                                    $groups->users()->detach($groups['user_ids'][$i]);
                                }               
                            }                
                        }
                    }            
                } else if (empty($falseid)) {
                    $groupdetech = [];
                    foreach ($user->group_ids as $userid) {
                        if (!in_array($userid,$groups)) {
                            $groupdetech[] = $userid;
                        }
                    }
                    if (!empty($groupdetech)) { 
                        foreach ($groupdetech as $groupdetechs) {
                            $groups = Group::where('_id',$groupdetechs)->firstOrFail();
                            $countgroup = count($groups['user_ids']);
                            for ($i=0; $i<$countgroup; $i++) {
                                if ($groups['user_ids'][$i]['user_id'] == $id) {
                                    $groups->users()->detach($groups['user_ids'][$i]);
                                }               
                            }                
                        }
                    }
                }
                
                if (!empty($request->input('roles'))) {
                    $user->roles()->sync([]);
                    foreach ($request->input('roles') as $key => $value) {
                        $user->attachRole($value);
                    }
                }
            }
        } else{
            if (empty($groups)) {
                if (empty($user->group_ids)) {
                    $user->group_ids = [];
                }
                foreach ($user->group_ids as $userGroup) {
                    $groups = Group::where('_id',$userGroup)->firstOrFail();
                    $countgroup = count($groups['user_ids']);
                    for ($i=0; $i<$countgroup; $i++) {
                        if ($groups['user_ids'][$i]['user_id'] == $id) {
                            $groups->users()->detach($groups['user_ids'][$i]);
                        }               
                    } 
                }
            } else {
                foreach ($groups as $groupsid) {
                    $group = Group::find($groupsid);
                    $group->users()->attach([
                        'user_id' => $id,
                        'status' => '0'
                    ]);
                }
            }         
        }

        return redirect()->route('users.index')
                ->with('success','User '.$user->firstname." ".$user->lastname.' updated successfully');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if ($id == \Auth::user()->_id) {
            Session::flash('message', "Can't Remove Yourself");
                                return Redirect::back();
        } else {
            $user = User::where('_id',$id)->firstOrFail();

            /*for($i=0;$i<count($user['role_ids']);$i++){
                $user->roles()->detach($user['role_ids'][$i]);
            }

            for($i=0;$i<count($user['group_ids']);$i++){
                $groups = Group::where('_id',$user['group_ids'][$i])->firstOrFail();
                for($n=0;$n<count($groups['user_ids']);$n++){
                    if($groups['user_ids'][$n]['user_id'] == $id){
                        $groups->users()->detach($groups['user_ids'][$n]);
                    }
                }
            }*/
            $user->delete();
            return redirect()->route('users.index')
            ->with('success','User '.$user->firstname." ".$user->firstname.' deleted successfully'); 
        }
   
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;
        $header = array();
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
        fclose($handle);
        }

        return $data;
    }
    
    public function export(){
         
        if (\Auth::user()->firstname == 'admin') {
            $adminGroup = [];
            $users = User::whereNull('deleted_at')->orderBy('_id','ASC')->get();
            $groups = Group::whereNull('deleted_at')->get();
        } elseif (empty(\Auth::user()->group_ids)) {
            $users = User::whereNull('deleted_at')->where('_id',\Auth::user()->_id)->get();
            $groups[] = null;
        } else {
            $idgroup = \Auth::user()->group_ids;
            $adminGroup = [];
            foreach ($idgroup as $idgroups) {
                $groups_id[] = Group::whereNull('deleted_at')->where('_id',$idgroups)->get();
            }
            foreach ($groups_id as $key) {
                foreach ($key as $value) {
                    $adminGroup[] = $value['_id'];
                }
            }      
            if (!empty($adminGroup)) {
                $users = User::whereNull('deleted_at')->whereIn('group_ids',$adminGroup)->get();
            } else if (empty($adminGroup)) {
                $users = User::whereNull('deleted_at')->where('_id',\Auth::user()->_id)->get();
            }
            $groups = Group::whereNull('deleted_at')->get();
        }
        $current = Carbon::now();
        $dateTime = dateFormatPattern($current);
        Excel::create($dateTime, function($excel) use ($users,$groups,$adminGroup)  {
            $excel->sheet('test', function($sheet) use ($users,$groups,$adminGroup){
                        $sheet->loadView('users.showexcel', array('users' => $users, 'groups' => $groups, 'adminGroup' => $adminGroup));
                });       
        })->export('xls');
    }

    public function importCsv()
    {
        /*$file = \Input::file('usersImport');
        $reader = Excel::load($file->getRealPath()
        return \Redirect::to('users')->with('message', 'Import CSV');*/
        if(Input::hasFile('usersImport')){
            $path = Input::file('usersImport')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    if (count($value) > 0) {                 
                        $groups = Group::whereNull('deleted_at')->where('name',$value->group)->first();
                        $roles = Role::whereNull('deleted_at')->where('name',$value->role)->first();
                        $user = new User;
                        $user->prefix = $value->prefix;
                        $user->firstname = $value->firstname;
                        $user->lastname = $value->lastname;
                        $user->code = strval($value->code);
                        $user->email = strval($value->email);
                        $user->password = Hash::make(strval($value->password));
                        $user->department = $value->department;
                        $user->position = $user->position;
                        $user->allowCreateForm = 0;
                        $user->save();
                        
                        if (count($roles) > 0) {
                            $user->attachRole($roles->_id);
                        } if (count($groups) > 0) {
                            $groups->users()->attach([
                                'user_id' => $user->_id,
                                'status' => '0'
                            ]);
                        }
                    }
                }
                Session::flash('message', "Import Success");
                    return Redirect::back();
            } else {
                Session::flash('message', "Error");
                            return Redirect::back();
            }
        }
    }

    public function testimport(){
        if(Input::hasFile('usersImport')){
            $path = Input::file('usersImport')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){
                $role = Role::get();
                $prefix = DB::collection('prefix')->get();
                foreach($prefix as $prefixs){
                    foreach ($data as $key => $value){
                        if($prefixs['name'] == $value->prefix){
                            $userimport[] = [
                                'prefix' => $value->prefix,
                                'firstname' => $value->firstname,
                                'lastname' => $value->lastname,
                                'code' => $value->code,
                                'email' => $value->email,
                                'password' => $value->password,
                                'role' => 
                                explode(",", (str_replace('_', ' ', strtolower($value->role))))

                            ];
                        }
                    }
                }////end foreach($prefix as $prefixs){
                
                if(count($userimport) != count($data)-1){
                    Session::flash('message', "Check Prefix");
                                return Redirect::back();
                }
                else{
                    foreach($userimport as $userimports){
                        foreach($userimports['role'] as $rolename){
                            foreach($role as $roles){
                                if($roles['name'] == $rolename){
                                    echo $userimports['firstname'] ." ". $roles['name']. "<br>";
                                }
                            }
                        }
                    }
                }
            }///////end if(!empty($data) && $data->count())
        }
    }
}