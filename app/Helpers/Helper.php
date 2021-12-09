<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getRangeArray')) {
    function getRangeArray($min, $max)
    {
        $length = 0;
        $min = roundMinValue($min);

        if ($max >= 0 && $max <= 50) {
            $max = 50;
            $length = 10;
        } elseif ($max > 50 && $max <= 100) {
            $max = 100;
            $length = 10;
        } elseif ($max > 100 && $max <= 150) {
            $max = 150;
            $length = 10;
        } elseif ($max > 150 && $max <= 500) {
            $max = 500;
            $length = 50;
        } elseif ($max > 500 && $max <= 1000) {
            $max = 1000;
            $length = 100;
        } elseif ($max > 1000 && $max <= 1500) {
            dd(strlen(round($max)));
            $max = 1500;
            $length = 100;
        } elseif ($max > 1500 && $max <= 5000) {
            $max = 5000;
            $length = 500;
        } elseif ($max > 5000 && $max <= 10000) {
            $max = 10000;
            $length = 1000;
        } elseif ($max > 10000 && $max <= 15000) {
            $max = 15000;
            $length = 1000;
        } elseif ($max > 15000 && $max <= 50000) {
            $max = 50000;
            $length = 5000;
        } elseif ($max > 50000 && $max <= 100000) {
            $max = 100000;
            $length = 10000;
        }

        $ranges = range($min, $max, $length);
        $rang_arr = [];
        for ($i = 0; $i < count($ranges); $i++) {
            if (isset($ranges[$i + 1])) {
                $rang_arr[$i] = $ranges[$i] . '-' . $ranges[$i + 1];
            }
        }
        return $rang_arr;
    }
}

if (!function_exists('roundMinValue')) {
    function roundMinValue($val)
    {
        if ($val >= 0 && $val < 50) {
            return 0;
        } elseif ($val >= 50 && $val < 100) {
            return 50;
        } elseif ($val >= 100 && $val < 150) {
            return 100;
        } elseif ($val >= 150 && $val < 500) {
            return 150;
        } elseif ($val >= 500 && $val < 1000) {
            return 500;
        } elseif ($val >= 1000 && $val < 1500) {
            return 1000;
        } elseif ($val >= 1500 && $val < 5000) {
            return 1500;
        } elseif ($val >= 5000 && $val < 10000) {
            return 5000;
        } elseif ($val >= 10000 && $val < 15000) {
            return 10000;
        } elseif ($val >= 15000 && $val < 50000) {
            return 15000;
        } elseif ($val >= 50000 && $val < 100000) {
            return 50000;
        }
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $data = \App\Libraries\SettingClass::getSetting($key);
        return $data;
    }
}

if (!function_exists('getSettingDescription')) {
    function getSettingDescription($key)
    {
        $data = \App\Libraries\SettingClass::getSettingDescription($key);
        return $data;
    }
}

if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;

    }
}
if(!function_exists('getActivecategories')){
    function getActiveCategories(){
        return $categories = App\Models\Category::where('status', 1)->get();
    }
}

if(!function_exists('avgRatings')){
    function avgRatings($post_id,$type){
        $value = $categories = App\Rating::where('post_id', $post_id)->where('type', $type)->avg('rating');
        if($value == null){
            return 0 ;
        } else{
        return $value;
        }
    }
}

if (!function_exists('checkWishlist')) {

    function checkWishlist($id) {

      if(Auth::check())
      {
         $wish_check = \App\Wishlist::where('course_id', $id)->where('user_id',Auth::user()->id)->first();
        if($wish_check) {
            return true;
        } else {
            return false;
        }
      }
      else
      {
        return false;
      }
       
       
    }

}


if(!function_exists('totalRatings')){
    function totalRatings($post_id,$type){
        return $categories = App\Rating::where('post_id', $post_id)->where('type', $type)->get();
    }
}

if(!function_exists('getUploads')){
    function getUploads($course_id){
        return $categories = App\CourseUpload::where('course_id', $course_id)->get();
    }
}


if(!function_exists('totalCourses')){
    function totalCourses(){
        return $categories = App\Course::where('status', 1)->count();
    }
}

if(!function_exists('totalCompanies')){
    function totalCompanies(){
        return $categories = App\Company::where('status', 1)->count();
    }
}

if(!function_exists('totalTrainers')){
    function totalTrainers(){
        return $categories = App\User::where('user_type','trainer')->count();
    }
}


if(!function_exists('checkPurchase')){
    function checkPurchase($user_id,$course_id){
        return $categories = App\Order::where('user_id', $user_id)->where('course_id', $course_id)->first();
    }
}


if(!function_exists('getRating')){
    function getRating($user_id,$post_id){
        return $categories = App\Rating::where('user_id', $user_id)->where('post_id', $post_id)->first();
    }
}


if(!function_exists('getMenuItem')){
    function getMenuItem($id){
        return $categories = App\MenuItem::where('id', $id)->first();
    }
}

if(!function_exists('getLanguage')){
    function getLanguage($id){
        return $categories = App\AllLanguage::where('id', $id)->first();
    }
}


if(!function_exists('getInstitute')){
    function getInstitute($id){
        return $categories = App\Institute::where('id', $id)->first();
    }
}



if(!function_exists('chkBidding')){
    function chkBidding($id,$company_id){
        return $categories = App\Bidding::where('course_id', $id)->where('company_id', $company_id)->first();
    }
}



if(!function_exists('getHomeBanner')){
    function getHomeBanner($slug){
        return $categories = App\HomePageSection::where('slug', $slug)->first();
    }
}


if(!function_exists('getHomeBannerImg')){
    function getHomeBannerImg($id){
        return $categories = App\HomeBanner::where('page_id', $id)->first();
    }
}



if(!function_exists('getAllLanguage')){
    function getAllLanguage($id){
        return $categories = App\AllLanguage::where('id', $id)->first();
    }
}


if(!function_exists('getPageSection')){
    function getPageSection($item,$section){
        return $categories = App\Page::where('menu_item_id', $item)->where('menu_section_id', $section)->first();
    }
}

if(!function_exists('getMenuSection')){
    function getMenuSection($id){
        return $categories = App\MenuSection::where('id', $id)->first();
    }
}


if (!function_exists('getCompanyCount')) {

    function getCompanyCount() {
      $subCat= \App\Company::count();           
      return $subCat;
    }
  
  }



if (!function_exists('get_image')) {

 function get_image($db_path, $dimension = 'default') {
     $file_path = pathinfo($db_path);
     $output = "";
     $dir_name = $file_path['dirname'];
     $base_name = $file_path['basename'];
     $extension = $file_path['extension'];
     $file_name = $file_path['filename'];
     $image_sizes = Config::get('constants.image_sizes');
     $key_exist = array_key_exists($dimension, $image_sizes);

     if ($key_exist) {
         $size = $image_sizes[$dimension];
         $width = $size[0];
         $height = $size[1];
         $allowed = true;
     } else {
         $allowed = false;
     }
     if ($allowed) {
         $destination_img_name = $dir_name . '/' . $file_name . '-' . $width . 'x' . $height . '.' . $extension;
         $output = url('media/original/') . '/' . $destination_img_name;
         return $output;
     }
 }

}

  if (! function_exists('str_slug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string  $language
     * @return string
     */
    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }
}

/* Used in : training matrix structure*/
if (!function_exists('company_positions')) {
    function company_positions() {
        $company_id = Session::get('company_id');
        $optnList   = '';
        $optionArr = \App\CompanyPosition::select('id','position_en','position_ar')
                    ->where('company_id',$company_id)->get();
        foreach($optionArr as $option){
            $optnList .= "<option value=".$option->id.">".$option->position_en."</option>";
        }       
        return $optionArr;
    }
}
  
/* Used in : training matrix structure*/
if (!function_exists('company_departments')) {
    function company_departments() {
        $company_id = Session::get('company_id');
        $optnList   = '';
        $optionArr = \App\CompanyDepartment::where('company_id',$company_id)
                    ->select('id','en_department','ar_department')->get();
        foreach($optionArr as $option){
            $optnList .= "<option value=".$option->id.">".$option->en_department."</option>";
        }       
        return $optnList;
    }
}
/* Used in : training matrix structure*/
if (!function_exists('company_projects')) {
    function company_projects() {
        $company_id = Session::get('company_id');
        $optnList   = '';
        $optionArr = \App\CompanyProject::where('company_id',$company_id)
                    ->select('id','en_project','ar_project')->get();
        foreach($optionArr as $option){
            $optnList .= "<option value=".$option->id.">".$option->en_project."</option>";
        }       
        return $optnList;
    }
}
/* Used in : */
if (!function_exists('all_languages')) {
    function all_languages() {
        $dataArr = \App\AllLanguage::where('active',1)->get();
        return $dataArr;
    }
}
/* Used in : */
if (!function_exists('industries')) {
    function industries() {
        $dataArr = \App\Industry::where('status',1)->get();
        return $dataArr;
    }
}

if (!function_exists('getUserData')) {
    function getUserData($id) {
        $user = \App\User::find($id);
        return $user;
    }
}

