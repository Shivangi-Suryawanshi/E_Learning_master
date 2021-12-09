<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CoursePreview extends Model
{
    protected $table = 'course_preview';
    public $timestamps = true;

      public function gettitleAttribute($value){
    $locale = App::getLocale();
    $field = 'title_'.$locale;
    $data = isset($this->$field)?$this->$field:$this->title_.$locale;
    return $data;
}

}
