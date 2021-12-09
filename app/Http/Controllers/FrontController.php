<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Testimonial;
use App\Course;
use App\Functionality;
use App\Package;
use Session;

class FrontController extends Controller
{


  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {

    $testimonials = Testimonial::where('status', 1)->get();
    $courses = Course::where('status', 1)->limit(3)->get();
    $training_centers = \App\TrainingCenter::where('status', 1)->get();
    return view('home')->with(['testimonials' => $testimonials, 'courses' => $courses, 'training_centers' => $training_centers]);
  }

  public function changeLanguage($locale)
  {

    Session::put('locale', $locale);

    \App::setLocale($locale);

    return response()->json([
      'success' => true,
    ], 200);
  }

  public function enterprise()
  {

    return view('pages.enterprise');
  }

  public function downloadResourses(Request $request)
  {
    $title = __t('free_resourse');

    // $free_resources = \App\FreeResource::orderBy('id', 'DESC')->get();
          $all_languages = \App\AllLanguage::where('active',1)->get(); 
          $skills = \App\Skill::where('status',1)->get();
           // $categories = \App\Category::where('status',1)->where('category_id','!=',0)->get();
          $categories = \App\Category::parent()->with('sub_categories')->get();
          $per_page = $request->perpage ? $request->perpage : 9;

           $free_resources = \App\FreeResource::orderBy('id', 'DESC')->where('status',1);


            $free_resources = \App\FreeResource::leftJoin('free_resources_skills','free_resources.id','free_resources_skills.free_resource_id')
                                ->leftJoin('free_resources_languages','free_resources.id','free_resources_languages.free_resource_id')
                               
                                ->orderBy('free_resources.id', 'DESC')
                                ->select('free_resources.*','free_resources_languages.free_resource_id','free_resources.id as cid')
                                ->groupBy('free_resources.id')
                                ->where('free_resources.status',1);


          if($request->get('keyword'))
               {
                if(\App::getLocale()=='ar'){
                $free_resources =  $free_resources->where('free_resources.title_ar', 'like',  '%' . $request->get('keyword') . '%');
               }
               else
               {
                $free_resources =  $free_resources->where('free_resources.title_en', 'like',  '%' . $request->get('keyword') . '%');
               }
               }

               
               if($request->get('skills'))
               {
                $free_resources =  $free_resources->whereIn('free_resources_skills.skill_id', $request->get('skills'));
               }
              
                if($request->get('cats'))
               {
                //dd($request->get('cats'));
                $free_resources =  $free_resources->whereIn('free_resources.second_category_id', $request->get('cats'));
               }
                //dd($free_resources->get());

               

               if($request->get('selLan'))
               {

                 $free_resources =  $free_resources->whereIn('free_resources_languages.language_id', $request->get('selLan'));
               }              


              

            //dd($free_resources->get());
               $fr_count = count($free_resources->get());
          $free_resources = $free_resources->paginate($per_page);

           if ($request->ajax()) {

          
             $returnHTML = view('pages.resourse_render',['free_resources'=> $free_resources ])->render(); 
          return response()->json( array('success' => true, 
          'html'=>$returnHTML, 'free_resources'=>$free_resources, 'fr_count' => $fr_count,
      'title'=>$title
      ) );
        }


    return view('pages.download_resourse')->with([
      'free_resources' => $free_resources,
      'skills' => $skills,
      'all_languages' =>$all_languages,
      'categories' => $categories,
      'title'=>$title
    ]);
  }

  public function resourceDetail(Request $request, $id)
  {
    $rating = '';
    $free_resource = \App\FreeResource::find($id);
    $userId = \Auth::check() ? \Auth::user()->id : '';
    $freeResources = \App\FreeResource::where('id','!=',$free_resource->id)
     ->where('parent_category_id',$free_resource->parent_category_id)
     ->where('status',1)
     ->get();
    // $rating = \App\Rating::where('user_id', $userId)->where('type', 'resource')->where('post_id', $free_resource->id)->first();
    if ($free_resource) {
      return view('pages.resource_detail')->with([
        'free_resource' => $free_resource,
        'freeResources' => $freeResources
        // 'rating' => $rating
      ]);
    } else {
      abort(404);
    }
  }

  public function courseDetail(Request $request, $slug)
  {
    $rating = '';
    $course = \App\Course::where('status', 1)->where('slug', $slug)->first();
    $previews = \App\CoursePreview::where('course_id', $course->id)->get();
    $userId = \Auth::check() ? \Auth::user()->id : null;
    $rating = \App\Rating::where('user_id', $userId)->where('type', 'course')->where('post_id', $course->id)->first();

    if ($course) {
      $relatedCourses = \App\Course::where('status', 1)->where('course_category_id', $course->course_category_id)->where('slug', '!=', $slug)->orderBy('id', 'desc')->take(2)->get();

      return view('pages.course_detail')->with([
        'course' => $course,
        'rating' => $rating,
        'previews' => $previews,
        'relatedCourses' => $relatedCourses
      ]);
    } else {
      abort(404);
    }
  }

  public function login()
  {

    return view('pages.login');
  }


  public function signup()
  {

    return view('pages.signup');
  }

  public function viewPage(Request $request, $slug)
  {
    //dd($slug);
    $title = __t($slug);

    $banner = '';
    $testimonials = '';
    $checkPage = \App\Page::where('slug', $slug)->first();
    if ($checkPage) {
      $testimonials = Testimonial::where('status', 1)->get();
      $banner = \App\Banner::where('page_id', $checkPage->id)->first();
      $package = Package::limit(4)->where('status',1)->get();
      $function = Functionality::get();
      return view('pages.index')->with(['page' => $checkPage, 'banner' => $banner, 'testimonials' => $testimonials, 'package' => $package, 'title' => $title,'function'=>$function]);
    } else {
      abort(404);
    }
  }


  public function setRating(Request $request)
  {
    //dd($request->all());
    $userId = $request->get('user_id');
    $postId = $request->get('post_id');
    $type = $request->get('type');
    $rating = $request->get('rating');
    $review_title = $request->get('review_title');
    $review_text = $request->get('review_text');


    if ($userId && $postId && $type) {
      $chkRate = \App\Rating::where('user_id', $userId)->where('type', $type)->where('post_id', $postId)->first();
      if ($chkRate) {
        $chkRate->rating = $rating;
        $chkRate->user_id = $userId;
        $chkRate->post_id = $postId;
        $chkRate->rating = $rating;
        $chkRate->review_title = $review_title;
        $chkRate->review_text = $review_text;
        $chkRate->type = $type;
        $chkRate->save();
      } else {
        $chkRate = new \App\Rating();
        $chkRate->user_id = $userId;
        $chkRate->post_id = $postId;
        $chkRate->rating = $rating;
        $chkRate->review_title = $review_title;
        $chkRate->review_text = $review_text;
        $chkRate->type = $type;
        $chkRate->save();
      }
    }
  }
  public function listCourses(Request $request)
  {

    //dump($request->all());
    $courses = \App\Course::leftJoin('course_skills', 'courses.id', 'course_skills.course_id')
      ->leftJoin('course_languages', 'courses.id', 'course_languages.course_id')
      ->leftJoin('ratings', 'courses.id', 'ratings.post_id')
      ->orderBy('courses.id', 'DESC')
      ->select('courses.*', \DB::raw('avg( ratings.rating ) as avg_p'), 'course_languages.course_id', 'courses.id as cid')
      ->groupBy('courses.id')
      ->where('courses.status', 1);
    $skills = \App\Skill::where('status', 1)->get();
    $all_languages = \App\AllLanguage::where('active', 1)->get();

    //  dd($courses->get());
    if ($request->get('keyword')) {
      if (\App::getLocale() == 'ar') {
        $courses =  $courses->where('courses.title_ar', 'like',  '%' . $request->get('keyword') . '%');
      } else {
        $courses =  $courses->where('courses.title_en', 'like',  '%' . $request->get('keyword') . '%');
      }
    }

    if ($request->get('list_type') == 'free') {
      $courses =  $courses->where('courses.cost_per_person', '<=', 0);
    } else if ($request->get('list_type') == 'paid') {
      $courses =  $courses->where('courses.cost_per_person', '>', 0);
    }

    //   if($request->get('listing_variation')=='high_rated')
    // {
    //  $courses =  $courses->orderBy('AVG(ratings.rating)','desc');
    // }

    if ($request->get('skills')) {
      $courses =  $courses->whereIn('course_skills.skill_id', $request->get('skills'));
    }

    if ($request->get('learning_approach')) {
      $courses =  $courses->whereIn('courses.course_type', $request->get('learning_approach'));
    }

    if ($request->get('selLan')) {
      $courses =  $courses->whereIn('course_languages.language_id', $request->get('selLan'));
    }

    if ($request->get('rating') == 4) {
      $min_rating = 4;
      $max_rating = 4.9;

      $courses =  $courses->havingRaw('AVG(ratings.rating) >= ?', [$min_rating])
        ->havingRaw('AVG(ratings.rating) <= ?', [$max_rating]);
    } else if ($request->get('rating') == 3) {
      $min_rating = 3;
      $max_rating = 4.9;
      $courses =  $courses->havingRaw('AVG(ratings.rating) >= ?', [$min_rating])
        ->havingRaw('AVG(ratings.rating) <= ?', [$max_rating]);
    } else  if ($request->get('rating') == 2) {
      $min_rating = 2;
      $max_rating = 4.9;
      $courses =  $courses->havingRaw('AVG(ratings.rating) >= ?', [$min_rating])
        ->havingRaw('AVG(ratings.rating) <= ?', [$max_rating]);
    }


    if ($request->get('price') == 1) {
      $min_price = 1;
      $max_price = 50;
      $courses =  $courses->whereBetween('courses.cost_per_person', [$min_price, $max_price]);
    } else if ($request->get('price') == 2) {
      $min_price = 51;
      $max_price = 100;
      $courses =  $courses->whereBetween('courses.cost_per_person', [$min_price, $max_price]);
    } else if ($request->get('price') == 3) {
      $courses =  $courses->where('courses.cost_per_person', '');
    }

    $allCourses = $courses->get();


    $count = $courses->get()->count();
    $courses =  $courses->paginate(2);


    $allRatings = array();

    foreach ($allCourses as $key => $rating) {

      $rate = $rating->avg_p ? $rating->avg_p : 0;

      array_push($allRatings, (float)($rating->avg_p));
    }


    if ($request->ajax()) {

      // print_r($request->get('price'));


      //$count= $courses->count();


      //return view('pages.course_render', compact('courses','allRatings'));
      $returnHTML = view('pages.course_render', ['courses' => $courses])->render();
      return response()->json(array('success' => true, 'html' => $returnHTML, 'allRatings' => $allRatings, 'count' => $count, 'courses' => $courses));
    }

    // $courses =  $courses->paginate(2);
    return view('pages.courses')->with(['courses' => $courses, 'skills' => $skills, 'all_languages' => $all_languages, 'allRatings' => $allRatings, 'count' => $count]);
  }


  public function allCourseRating(Request $request)
  {
    //dd($request->all());
    //  if(Auth::check())
    //  {
    // $ratings = \App\Rating::where('post_id', $request->get('post_id'))->where('type','course')->where('user_id',Auth::user()->id)->get();
    //  }
    //  else
    //  {
    $ratings = \App\Rating::where('post_id', $request->get('post_id'))->where('type', 'course')->get();
    //}

    $allRatings = array();
    foreach ($ratings as $key => $rate) {
      array_push($allRatings, (float)($rate->rating));
    }
    //dd($allRatings);
    return $allRatings;
  }



  public function addToWishlist(Request $request)
  {
    $id = $request->get('id');
    $userId = Auth::check() ? Auth::user()->id : null;

    if (!empty($id)) {
      $record = \App\Wishlist::where('course_id', $id)->where('user_id', Auth::user()->id)->first();

      if ($record) {
        $record->delete();
        return response()->json(array('success' => true, 'status' => 'remove'));
      } else {
        $wish = new \App\Wishlist();
        $wish->course_id = $id;
        $wish->user_id = $userId;
        $wish->save();
        return response()->json(array('success' => true, 'status' => 'add'));
      }
    }
  }

  public function packageId(Request $request, $id)
  {
    // dd($request->all());
    $title = __t('Subscription');
    $packages = Package::whereId($id)->limit(3)->first();
    return view('pages.subscription',compact('packages','title'));
  }
  public function contact(Request  $request)
  {
  //   $rules = [
  //     'name'  => 'required',
  //     'email'  => 'required',
  // ];
  // $this->validate($request, $rules);
    Contact::create($request->all());
    return redirect()->back()->with('message', 'Success');
    // dd($request->all());
  }

  // public funct
}
