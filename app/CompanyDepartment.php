<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    protected $table = 'company_departments';
    public $timestamps = true;

    public function total_courses(){
        return $this->hasMany('App\RequiredCourseDepartment', 'department_id', 'id')
        ->where('status',1);
    }
    // public function department_workforces(){
    //     return $this->hasMany('App\CompanyWorkforce', 'department_id', 'id')
    //     ->where('status',1);
    // }



}
