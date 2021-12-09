<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Individual_Preferred_Job extends Model
{
   protected $table = 'individual_prefered_job_details';
   public $timestamps = true;
}
