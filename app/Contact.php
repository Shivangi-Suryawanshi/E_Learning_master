<?php

namespace App;
use App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Contact extends Model
{
    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = ['name','email','phone','subject','message'];
    public function getskillAttribute($value){
    $locale = App::getLocale();
    $field = $locale.'_skill';
    $data = isset($this->$field)?$this->$field:$this->$locale._skill;
    return $data;
}

}
