<?php
/**
 * Created by PhpStorm.
 * User: COMPUTER
 * Date: 3/26/2018
 * Time: 2:28 PM
 */

namespace App\Http\Controllers\Admin;


use App\Activity;
use App\AdminModule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Permission;

class ModuleController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = __a('module');
        $modules = AdminModule::get();
        return view('admin.modules.index')->with(['modules' => $modules,'title'=>$title]);
    }

    /**
     * @return $this
     */
    public function createForm()
    {
        $title = __a('module_create');
        $modules = AdminModule::get();
        return view('admin.modules.create')->with(['modules' => $modules,'title'=>$title]);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $r = array('name' => 'required', 'perifix' => 'required');

        $v = Validator::make($request->all(), $r);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput($request->all());
        }
        $adminModule = new AdminModule();
        $adminModule->type = 'parent';
        $adminModule->name = $request->get('name');
        $adminModule->perifix = $request->get('perifix');
        $adminModule->save();

        $permission_types = array('browse_', 'read_', 'edit_', 'add_', 'delete_');
        foreach ($permission_types as $type) {
            $permission = new Permission();
            $permission->key = $type . $adminModule->perifix;
            $permission->table_name = $adminModule->perifix;
            $permission->module_id = $adminModule->id;
            $permission->save();
        }

        /****************** Activity Adding ************/
        // $activity = new Activity();
        // $activity->user_id = Auth::id();
        // $activity->relation_id = $adminModule->id;
        // $activity->type = 'module';
        // $activity->activity = 'New module has been created by:';
        // $activity->save();

        return redirect()->back()->with('smessage', 'New module added.');
    }

    public function updateForm($id){
        $title = __a('module_edit');

        $module = AdminModule::find($id);
        return view('admin.modules.edit')->with(['module' => $module,'title'=>$title]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request){
        $r = array('name' => 'required');

        $v = Validator::make($request->all(), $r);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        $adminModule = AdminModule::find($id);
        $adminModule->name = $request->get('name');
        $adminModule->save();

        /****************** Activity Adding ************/
        // $activity = new Activity();
        // $activity->user_id = Auth::id();
        // $activity->relation_id = $adminModule->id;
        // $activity->type = 'module';
        // $activity->activity = 'New module has been edited by:';
        // $activity->save();

        return redirect()->back()->with('smessage', 'Module updated.');
    }
}