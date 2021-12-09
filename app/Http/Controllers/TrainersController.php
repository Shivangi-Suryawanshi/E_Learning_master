<?php

namespace App\Http\Controllers;

use App\InstructorTrainer;
use App\User;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainersController extends Controller
{

    public function index()
    {
        $title = __t('trainers');
        $trainer = User::join('instructor_trainers', 'instructor_trainers.trainer_user_id', 'users.id')
            ->where([['instructor_trainers.instructor_user_id', Auth::user()->id], ['instructor_trainers.request_status', 1]])
            ->orderBy('users.id', 'DESC')->get();
        return view(theme('dashboard.trainers.index'), compact('title', 'trainer'));
    }
    public function requestedTrainer()
    {
        $title = __t('Trainers request');

        return view(theme('dashboard.trainers.request'), compact('title'));
    }
    public function searchTrainer(Request $request)
    {
        $rules = [
            'search' => 'required|email'
        ];
        $this->validate($request, $rules);
        $search = $request->search;

        $otherUser = User::where('email', $search)->where('user_type', '!=', 'trainer')->first();
        $user = User::where('email', $search)->where('user_type', 'trainer')->first();

        if ($user) {
            $view = view(theme('dashboard.trainers.search-result'), compact('user'));
            $html = $view->render();
            return response()->json([
                'html' => $html,
                'status' => true,

            ], 200);
        } elseif ($otherUser) {
            $view = view(theme('dashboard.trainers.other-user-search-result'));
            $html = $view->render();
            return response()->json([
                'html' => $html,
                'status' => true

            ], 200);
        } else {
            return response()->json([
                'message' => no_data(null, null, 'my-5'),
                'status' => false
            ], 200);
        }
    }

    public function requestAnotherTrainer(Request $request)
    {
        $id = $request->id;
        $auth = Auth::user();
        $instTrainer = new  InstructorTrainer();
        $instTrainer->instructor_user_id = Auth::user()->id;
        $instTrainer->trainer_user_id = $id;
        $instTrainer->request_status = 0;
        $instTrainer->save();
        //notification to requested trainer
        $user = $id ;
        $notification = "You have new class request from training center $auth->name " ;
        $model = "request-to-another-trainer";
        $model_id = $instTrainer->id ;
        userNotification($user, $notification, $model_id, $model) ;
       

        return response()->json([
            'status' => true,
            'message' => "successfull requested"
        ], 200);
    }
}
