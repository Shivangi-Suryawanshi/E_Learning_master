<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected  $table = "enrolls";
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
