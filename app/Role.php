<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'roles';
    public $timestamps = true;

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }

//    public function permissionRoles()
//    {
//        return $this->belongsToMany('App\PermissionRole', 'role_id', 'id');
//    }
}
