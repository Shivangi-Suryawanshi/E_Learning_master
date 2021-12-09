<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CourseLanguage extends Model
{
    protected $table = 'course_languages';
    public $timestamps = true;

    public function getLanguage(){
        return $this->belongsTo('App\AllLanguage', 'language_id', 'id');
    }

}
