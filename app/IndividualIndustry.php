<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class IndividualIndustry extends Model
{
   protected $table = 'individual_industries';
   public $timestamps = true;
}
