<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class InstituteUser extends Model
{
   protected $table = 'institute_users';
   public $timestamps = true;
}
