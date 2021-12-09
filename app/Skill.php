<?php

namespace App;
use App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Skill extends Model
{
    protected $table = 'skills';
    public $timestamps = true;

    public function getskillAttribute($value){
    $locale = App::getLocale();
    $field = $locale.'_skill';
    $data = isset($this->$field)?$this->$field:$this->$locale._skill;
    return $data;
}

}
