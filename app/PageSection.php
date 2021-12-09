<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PageSection extends Model
{
    protected $table = 'page_section';
    public $timestamps = true;

 


  public function bannerImgs() {
        return $this->hasMany('App\Banner', 'cms_id', 'id');
    }

    public function getcontentAttribute($value){
    $locale = App::getLocale();
    $field = 'content_'.$locale;
    $data = isset($this->$field)?$this->$field:$this->content_.$locale;
    return $data;
}
    public function gettitleAttribute($value){
    $locale = App::getLocale();
    $field = 'title_'.$locale;
    $data = isset($this->$field)?$this->$field:$this->title_.$locale;
    return $data;
}
}
