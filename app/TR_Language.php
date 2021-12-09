<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class TR_Language extends Model
{
   protected $table = 'tr_languages';
   public $timestamps = true;
}
