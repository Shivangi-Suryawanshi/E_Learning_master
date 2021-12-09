<?php

namespace App\Http\Controllers;

use App\LiveSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    public function index()
    {
        $title = __t('calandar');
        return view(theme('dashboard.calender.index'), compact('title'));
    }
    public function getList(Request $request)
    {
        $live = LiveSchedule::join('sections','sections.id','live_schedules.section_id')
        ->select(
                'live_schedules.id as id',
                'live_schedules.section_id as title',
                'live_schedules.event_date_time as start',
                'live_schedules.expiry_date_time as exipiry',
                'live_schedules.max_num_of_participate as max_no',
                'live_schedules.seat_available as seat_available',
                'sections.section_name as section_name'
            )->where('live_schedules.created_by',Auth::user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => "live schedule list",
            'events' => $live
        ]);
    }
}
