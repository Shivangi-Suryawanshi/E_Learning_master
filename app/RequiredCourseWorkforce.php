<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class RequiredCourseWorkforce extends Model
{
    protected $table = 'required_course_workforces';
    public $timestamps = true;

    public function course_assigned_to(){
        return $this->hasOne('App\CompanyWorkforce', 'id', 'user_id')->where('status',1);
    }
    public function purchaseWorkforces()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}