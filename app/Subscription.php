<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    protected $table = 'subscriptions';
    public $timestamps = true;  

    public function packages()
    {
        return $this->belongsTo(Package::class,'package_id');
    }
    public function functionality()
    {
        return $this->hasMany(SubscriptionFunctionality::class);
    }
}
