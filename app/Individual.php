<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
   protected $table = 'individuals';
   public $timestamps = true;
}
