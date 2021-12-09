<?php

namespace App\Http\Controllers;

use App\AssignmentSubmission;
use App\Attachment;
use App\Category;
use App\Bidding;
use App\Review;
use App\Section;
use App\Content;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BiddingController extends Controller
{

    public function myBiddings(Request $request){
        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();

        if ($request->bulk_action_btn){
            if(config('app.is_demo')) return back()->with('error', __a('demo_restriction'));
        }

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)){
            $data = ['status' => $request->status];

            if ($request->status == 1){
                $data['published_at'] = $now;
            }

            Bidding::whereIn('id', $ids)->update($data);
            return back()->with('success', __a('bulk_action_success'));
        }
       

        $title = __a('pages');
        $biddings = Bidding::leftJoin('courses','bidding.course_id','courses.id')->where('courses.user_id',Auth::id())->where('bidding.status', '>', 0);
        if ($request->filter_status){
            $biddings = $biddings->whereStatus($request->filter_status);
        }
        if ($request->q){
            $biddings = $biddings->where('courses.title', 'LIKE', "%{$request->q}%");
        }

        if ($request->filter_by === 'popular'){
            $biddings = $biddings->where('is_popular', 1);
            $biddings = $biddings->orderBy('popular_added_at', 'desc');
        }elseif($request->filter_by === 'featured'){
            $biddings = $biddings->where('is_featured', 1);
            $biddings = $biddings->orderBy('featured_at', 'desc');
        }else{
            $biddings = $biddings->orderBy('bidding.updated_at', 'desc');
        }

        $biddings = $biddings->paginate(2);

        return view(theme('dashboard.my_biddings'), compact('biddings'));
    }

}
