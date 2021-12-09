<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CouponCode extends Authenticatable
{
    use Notifiable;
      protected $table = 'coupon_code';
    public $timestamps = true;

    public function couponCourse()
    {
      return $this->belongsTo(Course::class,'required_course_id');
    }


}
