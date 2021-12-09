<?php
/**
 * Created by PhpStorm.
 * User: COMPUTER
 * Date: 5/25/2018
 * Time: 2:42 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    public $timestamps = true;
}