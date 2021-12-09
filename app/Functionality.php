<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Functionality extends Model
{
    protected $table = 'functionalities';
    public $timestamps = true;


   public function packageFuctionalities($packageId,$functionalityId)
   {
      return $this->hasOne(PackageFunctionality::class)->where([['package_id',$packageId],['functionality_id',$functionalityId]])->first();
   }

}
