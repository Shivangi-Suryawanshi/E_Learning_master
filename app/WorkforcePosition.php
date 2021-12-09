<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkforcePosition extends Model
{
    use SoftDeletes ;
    protected $table = 'workforce_positions';
    public $timestamps = true;

    public function workforce_positions_data(){
        return $this->hasOne('App\CompanyPosition', 'id', 'position_id')->where('status',1);
    }


}