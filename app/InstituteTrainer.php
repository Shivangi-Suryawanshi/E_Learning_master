<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class InstituteTrainer extends Model
{
   protected $table = 'institute_trainers';
   public $timestamps = true;
   
     public function getUser() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
