<?php
if (!function_exists('can')) {
    function can($key) {
         if(Illuminate\Support\Facades\Auth::check()){
            
            $roleId = Illuminate\Support\Facades\Auth::user()->role;

             $data = \App\Libraries\PermissionClass::getInstance($roleId);
            
            return $data->can($key);
        }
        return false;
    }
}

if (!function_exists('module_permission')) {

    function module_permission($module)
    {
        if($module == ''){
            return true;
        }
        if (\Illuminate\Support\Facades\Auth::check()) {
            $roleId = \Illuminate\Support\Facades\Auth::user()->role;

            $data = \App\Libraries\PermissionClass::getInstance($roleId);
            return $data->modulePermission($module);
        }
        return true;
    }
}