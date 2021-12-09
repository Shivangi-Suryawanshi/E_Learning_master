<?php
/**
 * Created by PhpStorm.
 * User: COMPUTER
 * Date: 3/26/2018
 * Time: 12:00 PM
 */

namespace App\Http\Controllers\Admin;


use App\Activity;
use App\AdminModule;
use App\Http\Controllers\Controller;
use App\PermissionRole;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
   
    /**
     * @return all roles
     */
    public function index()
    {
        $title = __a('roles');
        $roles = Role::all();
        return view('admin.roles.index',compact('roles','title'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createForm()
    {          
        $title = __a('role_create');    
        return view('admin.roles.create',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $v = Validator::make($request->all(), [
            'display_name' => 'required|min:3|max:50',
            'name' => 'required|min:3|max:50',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput($request->all());
        }
        $roles = new Role();
        $roles->display_name = $request->input('display_name');
        $roles->name = $request->input('name');
        $roles->save();

        /****************** Activity Adding ************/
        // $activity = new Activity();
        // $activity->user_id = Auth::id();
        // $activity->relation_id = $roles->id;
        // $activity->type = 'role';
        // $activity->activity = 'New role has be created by:';
        // $activity->save();

        return redirect()->back()->with('smessage', 'New role added.');
    }

    /**
     * @param $id
     * @return $this
     */
    public function updateForm($id)
    {
        $title = __a('role_update');
        $role = Role::find($id);
        $modules = AdminModule::get();
        return view('admin.roles.edit')->with(['role' => $role, 'modules' => $modules,'title'=>$title]);
    }

    public function update($id, Request $request){
        // dd($request->all());
        $v = Validator::make($request->all(), [
            'display_name' => 'required|min:3|max:50',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $roles = Role::find($id);
        $roles->display_name = $request->input('display_name');
        $roles->save();

        PermissionRole::where(['role_id' => $id])->delete();

        if($request->get('permissions')){
            foreach ($request->get('permissions') as $per){

                $permissionRole = new PermissionRole();
                $permissionRole->permission_id = $per;
                $permissionRole->role_id = $id;
                $permissionRole->save();
            }
        }

        /****************** Activity Adding ************/
        // $activity = new Activity();
        // $activity->user_id = Auth::id();
        // $activity->relation_id = $roles->id;
        // $activity->type = 'role';
        // $activity->activity = 'New role has been edited by:';
        // $activity->save();

        return redirect()->back()->with('smessage', 'New role added.');
    }
}