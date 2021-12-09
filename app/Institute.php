<?php

namespace App;

use App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
   protected $table = 'institutes';
   public $timestamps = true;

   public function getinstitutenameAttribute($value){
    $locale = App::getLocale();
    $field = $locale.'_institute_name';
    $data = isset($this->$field)?$this->$field:$this->$locale._institute_name;
    return $data;
}

public function getaboutinstituteAttribute($value){
    $locale = App::getLocale();
    $field = $locale.'_about_institute';
    $data = isset($this->$field)?$this->$field:$this->$locale._about_institute;
    return $data;
}

}
