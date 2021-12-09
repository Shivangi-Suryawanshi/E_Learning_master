<?php
/**
 * Created by PhpStorm.
 * User: COMPUTER
 * Date: 3/26/2018
 * Time: 4:09 PM
 */

namespace App\Libraries;

use App\Permission;
use Illuminate\Support\Facades\Auth;
use App\AdminModule;
use App\Role;

class PermissionClass
{
    protected static $_modules = [];
    protected static $_per = [];
    protected static $_instance = null;

    private function __construct($roleId)
    {
        self::$_modules = AdminModule::leftJoin('permissions', 'admin_modules.id', '=', 'permissions.module_id')->leftJoin('permission_role', 'permissions.id', '=', 'permission_role.permission_id')->where(['permission_role.role_id' => $roleId])->select('admin_modules.perifix')->whereNotNull('permission_role.permission_id')->groupBy('admin_modules.perifix')->pluck('admin_modules.perifix')->toArray();

        $role = Role::find($roleId);
        self::$_per = $role->permissions->pluck('key')->toArray();
    }

    public static function getInstance($roleId){
        if(self::$_instance === null)
            self::$_instance = new self($roleId);

        return self::$_instance;
    }

    public static function can($key) {
        if(in_array($key, self::$_per)){
            return true;
        }
        return false;
    }

    public static function modulePermission($module) {
        if(in_array($module, self::$_modules)){            
            return true;
        }
        return false;
    }
}