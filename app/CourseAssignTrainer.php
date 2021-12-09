<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseAssignTrainer extends Model
{
    protected $table = 'course_assign_trainers';
    public $timestamps = true;

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
