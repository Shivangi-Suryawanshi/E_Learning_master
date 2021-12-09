<?php

namespace App;
use App;

use Illuminate\Database\Eloquent\Model;
use DB;

class AllLanguage extends Model
{
    protected $table = 'all_languages';
    public $timestamps = true;

    public function getlanguageAttribute($value){
    $locale = App::getLocale();
    $field = $locale.'_language';
    $data = isset($this->$field)?$this->$field:$this->$locale._language;
    return $data;
}

}
