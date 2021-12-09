<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = true;

    public function gettingUser(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    public function getCourse(){
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

//     public function getshortdescriptionAttribute($value){
//     $locale = App::getLocale();
//     $field = 'short_description_'.$locale;
//     $data = isset($this->$field)?$this->$field:$this->short_description_.$locale;
//     return $data;
// }
//     public function gettitleAttribute($value){
//     $locale = App::getLocale();
//     $field = 'title_'.$locale;
//     $data = isset($this->$field)?$this->$field:$this->title_.$locale;
//     return $data;
// }
   
}
