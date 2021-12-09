<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidding extends Model
{
    protected $table = 'biddings';
    public $timestamps = true;
    use SoftDeletes;
      protected $dates = ['deleted_at'];

      public function biddingRequestCourse()
      {
        return $this->belongsTo('App\Course','required_course_id','id');
      }
      public function companyDetails()
      {
        return $this->belongsTo('App\User','company_id','id');
      }
      public function couponCodeCheck()
      {
        return $this->hasOne('App\CouponCode','bidding_id','id');
      }
      public function instructorName()
      {
        return $this->belongsTo('App\User','updated_by','id');
      }
      // public function promocodeList()
      // {
      //   return $this->belongsTo('App\CouponCode','bidding_id','id');
      // }
}
