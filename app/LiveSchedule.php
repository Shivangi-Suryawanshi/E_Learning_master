<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveSchedule extends Model
{
    protected $table = 'live_schedules';
    protected $timestamp =true;
    public function section()
    {
        return $this->belongsTo('App\Section','section_id','id');
    }
    public function liveSectionUser()
    {
        return $this->hasMany(LiveScheduleUser::class);
    }
}
