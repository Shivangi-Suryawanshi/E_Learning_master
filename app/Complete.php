<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complete extends Model
{
    protected $guarded = [];
    protected $dates = ['completed_at'];
    public $timestamps = false;

    public function completedUser()
    {
      
        return $this->belongsTo('App\User','user_id','id');
    }
    public function completedCourse()
    {
        return $this->hasOne('App\Course','id','completed_course_id');
    }
   
}
