<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    public $timestamps = true;

    public function getUser() {
        return $this->hasOne('App\CompanyUser', 'company_id', 'id')->where('user_role',2)->first();
    }
}