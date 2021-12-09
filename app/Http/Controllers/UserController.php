<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile($id){
        $user =  User::find($id);
        if ( ! $user){
            abort(404);
        }

        $title = $user->name;
        return view(theme('profile'), compact('user', 'title'));
    }

    public function review($id){
        $review = Review::find($id);
        $title ="";
        if(isset($review->user))
        {
            $title = 'Review by '. $review->user->name;

        }

        return view(theme('review'), compact('review', 'title'));
    }

    public function updateWishlist(Request $request){
        $course_id = $request->course_id;

        $user = Auth::user();
        if ( ! $user->wishlist->contains($course_id)){
            $user->wishlist()->attach($course_id);
            $response = ['success' => 1, 'state' => 'added'];
        }else{
            $user->wishlist()->detach($course_id);
            $response = ['success' => 1, 'state' => 'removed'];
        }

        $addedWishList = DB::table('wishlists')->where('user_id', $user->id)->pluck('course_id');

        $user->update_option('wishlists', $addedWishList);

        return $response;
    }



    public function changePassword(){
        $title = __a('change_password');
        return view('admin.change_password', compact('title'));
    }

    public function changePasswordPost(Request $request){
        if(config('app.is_demo')){
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'old_password'  => 'required',
            'new_password'  => 'required|confirmed',
            'new_password_confirmation'  => 'required',
        ];
        $this->validate($request, $rules);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        if(Auth::check()) {
            $logged_user = Auth::user();

            if(Hash::check($old_password, $logged_user->password)) {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();
                return redirect()->back()->with('success', __a('password_changed_msg'));
            }
            return redirect()->back()->with('error', __a('wrong_old_password'));
        }
    }


    public function users(Request $request){
       $userType = $request->filter_user_group ;
        $ids = (array) $request->bulk_ids;

        if ( is_array($ids) && in_array(1, $ids)){
            return back()->with('error', __a('admin_non_removable'));
        }

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)){
            User::whereIn('id', $ids )->update(['active_status' => $request->status]);
            return back()->with('success', __a('bulk_action_success'));
        }

        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)){
            if(config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

            User::whereIn('id', $ids )->delete();
            return back()->with('success', __a('bulk_action_success'));
        }

        $users = User::where('active_status',1);
        // ->where('user_type','!=','company');
        if ($request->q){
            $users = $users->where(function($q)use($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        if ($request->filter_user_group){
            $users = $users->where('user_type', $request->filter_user_group);
        }
        if ($request->filter_status){
            $users = $users->where('active_status', $request->filter_status);
        }


        $title = __a('users');
        $users = $users->orderBy('id', 'desc')->paginate(100);

        return view('admin.users.index', compact('title', 'users','userType'));
    }

    public function viewDetails(Request $request,$id)
    {
        $countries = \App\Country::get();
        $industries = \App\Industry::get();
        $occupations = \App\Occupation::get();
        $all_languages = \App\AllLanguage::where('active',1)->get();
       
        $checkCompany = \App\CompanyUser::where('user_id',$id)->first();
  
        if($checkCompany == null)
        {
            return redirect()->back();
        }

        $company = \App\Company::find($checkCompany->company_id);
      
        $companyLanguages = \App\CompanyLanguage::where('company_id',$company->id)->pluck('language_id')->toArray();
        $companyIndustries = \App\CompanyIndustry::where('company_id',$company->id)->pluck('industry_id')->toArray();
        $companyOccupations = \App\CompanyOccupation::where('company_id',$company->id)->pluck('occupation_id')->toArray();
        $contact_details = \App\CompanyContactDetail::where('company_id',$company->id)->first();
      
        return view('admin.users.view-details')->with([
            'company'=> $company,
            'countries' => $countries,
            'industries' => $industries,
            'occupations' => $occupations,
            'all_languages' => $all_languages,
            'contact_details' => $contact_details,
            'companyLanguages' => $companyLanguages,
            'companyIndustries' => $companyIndustries,
            'companyOccupations' => $companyOccupations,
            'id'=>$id
            ]);
    
    }

    public function statusChange(Request $request)
    {
        $id= $request->id ;
        $status= $request->status ;
        $user=User::find($id);
       
        if($status == 1)
        {
            $user->verification_status	= 1;
            $user->save();
            return response()->json([
                'status'=>true,
                'message'=>"Successfully Approved As Company Admin",
            ],200);
        } 
        elseif($status == 0)
        {
            $user->verification_status	= 0 ;
            $user->save();
            return response()->json([
                'status'=>true,
                'message'=>"Request Rejected",
            ],200);
        }
     
      
    
    }



}
