<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModule extends Model {

    protected $table = 'admin_modules';
    public $timestamps = true;

    public function getSubmodule(){
        return $this->hasMany('App\AdminModule', 'parent_id' );
    }

    public function permissions(){
        return $this->hasMany('App\Permission', 'module_id', 'id');
    }
}
