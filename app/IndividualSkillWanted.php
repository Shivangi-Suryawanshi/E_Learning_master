<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class IndividualSkillWanted extends Model
{
   protected $table = 'individual_skills_wanted';
   public $timestamps = true;
}
