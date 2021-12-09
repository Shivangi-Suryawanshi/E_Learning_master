<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class RequiredCoursePosition extends Model
{
    protected $table = 'required_course_positions';
    public $timestamps = true;


    // public function expired_courses(){

    //     return $this->hasMany('App\RequiredCourseWorkforce', 
    //     'required_course_workforces.course_id', 'required_course_departments.course_id')
    //     ->where('status',1)->where('end_date','<', date("Y-m-d"));
    // }

    public function company_position(){
        return $this->hasOne('App\CompanyPosition', 'id', 'position_id')->where('status',1);
    }


}