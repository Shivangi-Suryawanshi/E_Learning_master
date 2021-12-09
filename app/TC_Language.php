<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class TC_Language extends Model
{
   protected $table = 'tc_languages';
   public $timestamps = true;
}
