<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
   protected $table = 'packages';
   public $timestamps = true;
   public function packageFuctionality()
   {
      return $this->hasMany(PackageFunctionality::class);
   }
   
}
