<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Individual_Language extends Model
{
   protected $table = 'individual_languages';
   public $timestamps = true;
}
