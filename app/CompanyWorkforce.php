<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyWorkforce extends Model
{
    use SoftDeletes ;
    protected $table = 'company_workforce';
    public $timestamps = true;

    public function assigned_courses(){
        return $this->hasMany('App\RequiredCourseWorkforce', 'user_id', 'user_id')->where('status',1);
    }

    // public function user_department(){
    //     return $this->hasOne('App\CompanyDepartment', 'id', 'department_id');
    // }

    public function workforce_departments(){
        return $this->hasMany('App\WorkforceDepartment', 'user_id', 'user_id')->where('status',1);
    }
    public function workforce_positions(){
        return $this->hasMany('App\WorkforcePosition', 'user_id', 'user_id')->where('status',1);
    }
    public function workforce_projects(){
        return $this->hasMany('App\WorkforceProject', 'user_id', 'user_id')->where('status',1);
    }

    public function workforceUser(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


}
