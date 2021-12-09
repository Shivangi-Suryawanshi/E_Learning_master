<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFunctionality extends Model
{
    protected $table = 'subscription_functionalities';
    public $timestamps = true;  
    public function functionality()
    {
        return $this->belongsTo(Functionality::class ,'functionality_id');
    }
}
