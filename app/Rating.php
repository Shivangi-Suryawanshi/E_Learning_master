<?php

namespace App;
use App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Rating extends Model
{
    protected $table = 'ratings';
    public $timestamps = true;

    public function getUser(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
