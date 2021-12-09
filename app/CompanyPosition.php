<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPosition extends Model
{
    protected $table = 'company_positions';
    public $timestamps = true;
    use SoftDeletes;
}
