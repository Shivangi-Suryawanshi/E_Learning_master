<?php

namespace App\Http\Controllers\Admin;

use App\Chat;
use App\CompanyWorkforce;
use App\Course;
use App\Enroll;
use App\Message;
use App\MessageThread;
use App\Property;
use App\Settings;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MessageController extends Controller
{

    public function index()
    {

        $title = __t('message');
        $today = Carbon::now()->format('M d');
        $auth = Auth::user();
        if ($auth->user_type == "admin") {
            $users = User::where('users.id', '!=', Auth::user()->id)
                ->leftjoin('chats', 'chats.sender_id', 'users.id')
                ->select(
                    'users.name as name',
                    'users.id as id',
                    'users.user_type as user_type',
                    'chats.id as chat_id'
                )->orderBy('chats.id', 'desc')->groupBy('users.id')
                ->get();
        } elseif ($auth->user_type == "company") {
            $users = User::leftjoin('company_workforce', 'company_workforce.user_id', 'users.id')
                ->leftjoin('chats', 'chats.sender_id', 'users.id')
                ->select(
                    'users.name as name',
                    'users.id as id',
                    'users.user_type as user_type'
                )
                ->where([['company_workforce.company_id', $auth->id], ['users.user_type', 'student']])
                ->orWhere([['users.user_type', 'admin']])
                ->orderBy('chats.id', 'desc')->groupBy('users.id')->get();

            $contactor = CompanyWorkforce::join('users', 'users.id', 'company_workforce.user_id')
            ->join('users as contractorUser','contractorUser.id','company_workforce.company_id')
            ->leftjoin('chats', 'chats.sender_id', 'users.id')
            ->select(
                'users.name as name',
                'users.id as id',
                'users.user_type as user_type'
            )
      ->orderBy('users.id', 'desc')
            ->where('contractorUser.parent_company',$auth->id)
            ->orderBy('chats.id', 'desc')->groupBy('users.id')->get();
        } elseif ($auth->user_type =="student") {
            // dd($auth->id);
            $users = User::leftjoin('company_workforce', 'company_workforce.company_id', 'users.id')
            ->leftjoin('users as companyUser','companyUser.id','company_workforce.company_id')
                ->leftjoin('chats', 'chats.sender_id', 'users.id')
                ->select(
                    'users.name as name',
                    'users.id as id',
                    'users.user_type as user_type'
                    // 'companyUser.name as companyUserName',
                    // 'companyUser.parent_company as parent_company'
                )
                ->where('company_workforce.user_id', $auth->id)
                ->where('users.user_type', 'contractors')
                ->orWhere('users.user_type', 'admin')
                ->orderBy('chats.id', 'desc')->groupBy('users.id')->get();

                $parentCompany = User::
            leftjoin('company_workforce','company_workforce.company_id','users.id')
            ->leftjoin('users as parentCompany','parentCompany.id','users.parent_company')
                ->leftjoin('chats', 'chats.sender_id', 'users.id')
                ->select(
                    'users.name as name',
                    'users.id as id',
                    'users.user_type as user_type'
                )
                ->where('company_workforce.user_id', $auth->id)
                // ->where('users.user_type', 'contractor')
                // ->orWhere('users.user_type', 'admin')
                ->orderBy('chats.id', 'desc')->groupBy('parentCompany.id')->get();
                
                $student  = Course::join('enrolls','enrolls.course_id','courses.id')
                ->where([['enrolls.user_id',Auth::user()->id],['enrolls.status','success']])
                ->select('enrolls.*','courses.user_id as user_id')->groupBy('courses.user_id')->get();
                
                
        }
        elseif($auth->user_type == 'instructor' )
        {
            $users = User::
            leftjoin('instructor_trainers','instructor_trainers.trainer_user_id','users.id')
            ->select(
                'users.name as name',
                'users.id as id',
                'users.user_type as user_type',
                'users.profile_pic as profile_pic'
            )
            ->where('instructor_trainers.instructor_user_id',$auth->id)
            ->orWhere('users.user_type','admin')
            // ->where('users.user_type','trainer')
            ->get();
            $student  = Enroll::join('courses','courses.id','enrolls.course_id')
        ->where([['courses.user_id',Auth::user()->id],['enrolls.status','success']])
        ->select('enrolls.*')->get();
        }
        elseif($auth->user_type == "trainer")
        {
            $users = User::
            leftjoin('instructor_trainers','instructor_trainers.instructor_user_id','users.id')
            ->select(
                'users.name as name',
                'users.id as id',
                'users.user_type as user_type',
                'users.profile_pic as profile_pic'
            )
            ->where('instructor_trainers.trainer_user_id',$auth->id)
            ->orWhere('users.user_type','admin')
            // ->where('users.user_type','trainer')
            ->get();
            $student  = Enroll::join('courses','courses.id','enrolls.course_id')
            ->where([['courses.user_id',Auth::user()->id],['enrolls.status','success']])
            ->select('enrolls.*')->get();
        }
        $completeChats = Chat::get();

        if ($auth->user_type == 'admin') {
            return view('admin.chats.index')->with(['users' => $users, 'completeChats' => $completeChats, 'today' => $today, 'title' => $title]);
        } elseif ($auth->user_type == 'company') {
            
            return view('company.chats.index')->with(['users' => $users, 'completeChats' => $completeChats, 'today' => $today, 'title' => $title,'contactor'=>$contactor]);
        } elseif ($auth->user_type == 'student') {

            return view(theme('dashboard.chats.index'))->with(['users' => $users, 'completeChats' => $completeChats, 'today' => $today, 'title' => $title,'parentCompany'=>$parentCompany,'student'=>$student]);
        }
        elseif($auth->user_type == 'instructor' || $auth->user_type == "trainer") {
            
            return view(theme('dashboard.instuctor-chat.index'))->with(['student'=>$student,'users' => $users, 'completeChats' => $completeChats, 'today' => $today, 'title' => $title]);

        }
     
        // return view('admin.chats.index')->with(['users' => $users, 'completeChats' => $completeChats]);

    }

    public function getMessages(Request $request)
    {
        $title = __t('message');
        $userId = $request->get('r_userId');
        $updateIsRead = Chat::where([['sender_id', $userId], ['receiver_id', Auth::user()->id]])->get();
        if ($updateIsRead) {
            foreach ($updateIsRead as $isread) {
                $updateRead = Chat::find($isread->id);
                $updateRead->is_read = 1;
                $updateRead->save();
            }
        }
        $totalCountMsg = unreadMessages();
        if ($userId) {
            $user = User::find($userId);
            $chats = Chat::orderBy('id','ASC')->get();
            $returnHTML = view('admin.chats.chat_render', [
                'completeChats' => $chats,
                'auth' => Auth::user()->id,
                'receiverUserId' => $userId,
                'user' => $user
            ])->render();
            return response()->json(array('success' => true, 'returnHTML' => $returnHTML, 'receiver_id' => $userId, 'title' => $title, 'totalCountMsg' => $totalCountMsg));
            // return response()->json(array('success' => false, 'receiver_id' => $userId));
        }
    }

    public function sendMessage(Request $request)
    {
        // dd($request->all());
        $message = $request->get('message');
        $receiver_id = $request->get('receiver_id');
        $today = Carbon::now();
        $date = $today->format('Y-m-d');
        $time = $today->format('h:i a');
        // dd($date,$time);
        // $time = Carbon::now()->format('i:h')
        if ($message) {
            $chat = new Chat();
            $chat->sender_id  = Auth::user()->id;
            $chat->receiver_id = $receiver_id;
            $chat->message = $message;
            $chat->date = $date;
            $chat->time = $time;
            // $chat->chat_id = 'CH' . uniqid();
            $chat->save();
        }
    }
    public function searchUser(Request $request)
    {
        $keyword = $request->keywords;
        $auth = Auth::user();
        if ($auth->user_type == "admin") {

            $userSearch = User::where([['name', 'like', '%' . $keyword . '%'], ['users.id', '!=', $auth->id]])
                ->select('name', 'id')->get();
        } elseif ($auth->user_type == "company") {
            $userSearch = User::leftjoin('company_workforce', 'company_workforce.user_id', 'users.id')
                ->leftjoin('chats', 'chats.sender_id', 'users.id')
              ->select('users.name as name','users.id as id','users.user_type as user_type')
                ->where([
                    ['company_workforce.company_id', $auth->id],
                    ['users.user_type', 'student'],
                    ['users.name', 'like', '%' . $keyword . '%']
                ])
                ->orWhere([['users.user_type', 'admin']])
                ->orderBy('chats.id', 'desc')->groupBy('users.id')->get();

                //contactor search

            $contactorSearch = CompanyWorkforce::join('users', 'users.id', 'company_workforce.user_id')
            ->join('users as contractorUser','contractorUser.id','company_workforce.company_id')
            ->leftjoin('chats', 'chats.sender_id', 'users.id')
            ->select(
                'users.name as name',
                'users.id as id',
                'users.user_type as user_type'
            )
      ->orderBy('users.id', 'desc')
            ->where([['contractorUser.parent_company',$auth->id],
            ['users.name', 'like', '%' . $keyword . '%']])
            ->orderBy('chats.id', 'desc')->groupBy('users.id')->get();


        }
        elseif($auth->user_type =="instructor" || $auth->user_type == "trainer")
        {
            if($auth->user_type =="instructor")
            {
            $users = User::
            leftjoin('instructor_trainers','instructor_trainers.trainer_user_id','users.id')
            ->select(
                'users.name as name',
                'users.id as id',
                'users.user_type as user_type',
                'users.profile_pic as profile_pic'
            )
            ->where([['instructor_trainers.instructor_user_id',$auth->id],
            ['users.name', 'like', '%' . $keyword . '%']])
            ->orWhere('users.user_type','admin')
            // ->where('users.user_type','trainer')
            ->get();
            }
            if($auth->user_type == "trainer")
            {
                $users = User::
                leftjoin('instructor_trainers','instructor_trainers.instructor_user_id','users.id')
                ->select(
                    'users.name as name',
                    'users.id as id',
                    'users.user_type as user_type',
                    'users.profile_pic as profile_pic'
                )
                ->where([['instructor_trainers.trainer_user_id',$auth->id],
                ['users.name', 'like', '%' . $keyword . '%']])
                ->orWhere('users.user_type','admin')
                // ->where('users.user_type','trainer')
                ->get();
            }
            $student  = Enroll::join('courses','courses.id','enrolls.course_id')
        ->where([['courses.user_id',Auth::user()->id],['enrolls.status','success']])
        ->select('enrolls.*')->get();
            $returnHTML = view(theme('dashboard.instuctor-chat.search-result'), ['contactorSearch'=>$student,'userSearch' => $users, ])->render();
            return response()->json(array(
                'success' => true, 'returnHTML' => $returnHTML
    
            ));
        }
        $returnHTML = view('admin.chats.search-result', ['userSearch' => $userSearch,'contactorSearch'=>$contactorSearch])->render();
        return response()->json(array(
            'success' => true, 'returnHTML' => $returnHTML

        ));
    }
}
