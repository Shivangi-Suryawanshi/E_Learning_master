<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class IndividualOccupation extends Model
{
   protected $table = 'individual_occupations';
   public $timestamps = true;
}
