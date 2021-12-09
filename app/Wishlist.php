<?php

namespace App;
use App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Wishlist extends Model
{
    protected $table = 'wishlist';
    public $timestamps = true;

 public function getCourse(){
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }


}
