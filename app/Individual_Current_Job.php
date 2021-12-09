<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Individual_Current_Job extends Model
{
   protected $table = 'individual_current_job_details';
   public $timestamps = true;
}
