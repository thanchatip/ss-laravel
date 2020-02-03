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

class ProfileController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $id = \Auth::id();
        
        $user = User::find($id);
        $adminGroup = \Auth::user()->group_ids;

        if(!empty($user['group_ids'])){
            foreach($user['group_ids'] as $groupId){
                $groups = Group::where('_id',$groupId)->get();
            }
        }elseif(empty($user['group_ids'])){
            //$groups[] = null;
            $groups = Group::where('group_ids',$adminGroup)->paginate(10);
        }
            return view('profiles.show',compact('user','groups'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = \Auth::id();

        $user = User::find($id);

            return view('profiles.edit',compact('user'));

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = \Auth::id();

        $this->validate($request, [
            'firstname' => 'required|regex:/^\S*$/u',
            'lastname' => 'required|regex:/^\S*$/u',
        ]);

        $input = $request->all();

        $user = DB::collection('users')->where('_id',$id)->update($input);

            return redirect()->action('ProfileController@show');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset()
    {
        $id = \Auth::id();

        $user = User::find($id);

            return view('profiles.resetPassword',compact('user'));

    }

    public function resetPassword(Request $request)
    {
        $id = \Auth::id();

        $this->validate($request, [
            'password' => 'same:confirm-password',
        ]);


        $input = $request->all();

        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }


        $user = DB::collection('users')->where('_id',$id)->update($input);

            return redirect()->action('ProfileController@show');

    }

}