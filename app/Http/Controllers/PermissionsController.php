<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use DB;

class PermissionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $permissions = Permission::orderBy('name','ASC')->paginate(20);

        return view('permissions.index',compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 5);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

	    return view('permissions.create');

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
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
        ]);


        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->type = $request->input('type');
        $permission->createdBy = \Auth::user()->_id;
        $permission->save();

        return redirect()->route('permissions.index')
                ->with('success','Permission created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $permission = Permission::find($id);

        return view('permissions.show',compact('permission'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $permission = Permission::find($id);

        return view('permissions.edit',compact('permission'));

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
            'display_name' => 'required',
            'description' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->type = $request->input('type');
        $permission->updatedBy = \Auth::user()->_id;
        $permission->save();

        return redirect()->route('permissions.index')
               ->with('success','Permission updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissions = Permission::where('_id',$id)->first();
        $permissions->delete();
        $permissions->roles()->sync([]);
        return redirect()->route('permissions.index')
               ->with('success','Permission deleted successfully');
    }

}