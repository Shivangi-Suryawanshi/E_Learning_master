<?php

namespace App;
use App;

use Illuminate\Database\Eloquent\Model;
//use willvincent\Rateable\Rateable;
use DB;

class FreeResource extends Model
{
    protected $table = 'free_resources';
    public $timestamps = true;

  //  use Rateable;

     public function getLanguages(){
        return $this->hasMany('App\FreeResourceLanguage', 'free_resource_id', 'id');
    }



   public function gettitleAttribute($value){
    $locale = App::getLocale();
    $field = 'title_'.$locale;
    $data = isset($this->$field)?$this->$field:$this->title_.$locale;
    return $data;
}

    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

        public function author()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }


   public function getshortdescAttribute($value){
    $locale = App::getLocale();
    $field = 'short_desc_'.$locale;
    $data = isset($this->$field)?$this->$field:$this->short_desc_.$locale;
    return $data;
}
     public function getdescriptionAttribute($value){
    $locale = App::getLocale();
    $field = 'description_'.$locale;
    $data = isset($this->$field)?$this->$field:$this->description_.$locale;
    return $data;
}
    

}
