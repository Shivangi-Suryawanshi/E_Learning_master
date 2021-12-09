<?php

namespace App\Http\Controllers;

use App\Category;
use App\Testimonial;
use App\Course;
use App\User;
use App\Post;
use App\TC_Language;
use App\TR_Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $title = __t('home_page_title');
        $new_courses = Course::publish()->orderBy('created_at', 'desc')->take(12)->get();
        $featured_courses = Course::publish()->whereIsFeatured(1)->orderBy('featured_at', 'desc')->take(6)->get();
        $popular_courses = Course::publish()->whereIsPopular(1)->orderBy('popular_added_at', 'desc')->take(3)->get();
        $posts = Post::post()->publish()->take(3)->get();
        $testimonials = Testimonial::where('status',1)->get();

        return view(theme('index'), compact('title', 'new_courses', 'featured_courses', 'popular_courses', 'posts','testimonials'));
    }

    public function courses(Request $r){
        // dd($r->all());
        $title = __t('courses');
        $freeResource = $r->free_resource ;
        $categories = Category::parent()->with('sub_categories')->get();
        $topics = Category::whereCategoryId($r->category)->get();

        $courses = Course::query()
        ->where( function ($q) use($freeResource)
    {
        if($freeResource != "")
        {
            $q->where([['price_plan','free'],['user_id',1]]);
        }
    });
        $courses = $courses->publish();

        if ($r->path() === 'featured-courses'){
            $title = __t('featured_courses');
            $courses = $courses->where('is_featured', 1);
        }elseif ($r->path() === 'popular-courses'){
            $title = __t('popular_courses');
            $courses = $courses->where('is_popular', 1);
        }

        if ($r->q){
            $courses = $courses->where('title', 'LIKE', "%{$r->q}%");
        }
        if ($r->category){
            $courses = $courses->where('second_category_id', $r->category);
        }
        if ($r->topic){
            $courses = $courses->where('category_id', $r->topic);
        }
        if ($r->level && ! in_array(0, $r->level)){
            $courses = $courses->whereIn('level', $r->level);
        }
        if ($r->price){
            $courses = $courses->whereIn('price_plan', $r->price);
        }
        if ($r->rating){
            $courses = $courses->where('rating_value','>=', $r->rating);
        }
        //live section
        if($r->level_section)
        {
            $courses = $courses->join('sections','sections.course_id','courses.id')
            ->whereIn('sections.section_type',$r->level_section)->groupBy('courses.id');

        }


        /**
         * Find by Video Duration
         */
        if ($r->video_duration === '0_2'){
            $durationEnd = (60 * 60 * 3) - 1; //02:59:59
            $courses = $courses->where('total_video_time','<=', $durationEnd);
        }elseif ($r->video_duration === '3_5'){
            $durationStart = (60 * 60 * 3) ;
            $durationEnd = (60 * 60 * 6) -1;
            $courses = $courses->whereBetween('total_video_time',[$durationStart, $durationEnd]);
        }elseif ($r->video_duration === '6_10'){
            $durationStart = (60 * 60 * 6) ;
            $durationEnd = (60 * 60 * 11) -1;
            $courses = $courses->whereBetween('total_video_time',[$durationStart, $durationEnd]);
        }elseif ($r->video_duration === '11_20'){
            $durationStart = (60 * 60 * 11) ;
            $durationEnd = (60 * 60 * 21) -1;
            $courses = $courses->whereBetween('total_video_time',[$durationStart, $durationEnd]);
        }elseif ($r->video_duration === '21'){
            $durationStart = (60 * 60 * 21) ;
            $courses = $courses->where('total_video_time', '>=', $durationStart);
        }

        switch ($r->sort){
            case 'most-reviewed' :
                $courses = $courses->orderBy('rating_count', 'desc');
                break;
            case 'highest-rated' :
                $courses = $courses->orderBy('rating_value', 'desc');
                break;
            case 'newest' :
                $courses = $courses->orderBy('published_at', 'desc');
                break;
            case 'price-low-to-high' :
                $courses = $courses->orderBy('price', 'asc');
                break;
            case 'price-high-to-low' :
                $courses = $courses->orderBy('price', 'desc');
                break;
            default:

                if ($r->path() === 'featured-courses'){
                    $courses = $courses->orderBy('featured_at', 'desc');
                }elseif ($r->path() === 'popular-courses'){
                    $courses = $courses->orderBy('popular_added_at', 'desc');
                }
                else{
                    $courses = $courses->orderBy('created_at', 'desc');
                }
        }

        $per_page = $r->perpage ? $r->perpage : 12;
        $courses = $courses->paginate($per_page);
    
        return view(theme('courses'), compact('title', 'courses', 'categories', 'topics'));
    }

    public function clearCache(){
        Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        if (function_exists('exec')){
            exec('rm ' . storage_path('logs/*'));
        }
        $this->rrmdir(storage_path('logs/'));

        return redirect(route('home'));
    }

    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        $this->rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            //rmdir($dir);
        }
    }


     public function userProfile(Request $r,$id){
     
      if($id)
      {
        $user = User::find($id);
        $per_page = $r->perpage ? $r->perpage : 10;
        $courses = Course::whereUserId($user->id)->paginate($per_page);
        $traininCenterLaganguages = TC_Language::where('user_id',$id)->pluck('language_id')->toArray();
        $trainerLaganguages = TR_Language::where('user_id',$id)->pluck('language_id')->toArray();

        // dd($traininCenterLaganguages);
        //$myCourses = Course::whereUserId($user->id)->get();
        return view(theme('user_profile'), compact('user','courses','traininCenterLaganguages','trainerLaganguages'));
      }
     }

}
