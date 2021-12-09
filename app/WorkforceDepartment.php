<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkforceDepartment extends Model
{
    use SoftDeletes  ;
    protected $table = 'workforce_departments';
    public $timestamps = true;

    public function workforce_department_data(){
        return $this->hasOne('App\CompanyDepartment', 'id', 'department_id')->where('status',1);
    }

    public function total_courses(){
        return $this->hasMany('App\RequiredCourseDepartment', 'department_id', 'department_id')
        ->where('status',1);
    }

}