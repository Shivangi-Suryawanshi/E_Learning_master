<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class CompanyRequiredCourse extends Model
{
    protected $table = 'company_required_courses';
    public $timestamps = true;

    public function required_course_departments(){
        return $this->hasMany('App\RequiredCourseDepartment', 'course_id', 'id')->where('status',1);
    }
    public function required_course_positions(){
        return $this->hasMany('App\RequiredCoursePosition', 'course_id', 'id')->where('status',1);
    }

    public function required_course_projects(){
        return $this->hasMany('App\RequiredCourseProject', 'course_id', 'id')->where('status',1);
    }

}
