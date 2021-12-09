<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class IndividualTopSkill extends Model
{
   protected $table = 'individual_top_skills';
   public $timestamps = true;
}
