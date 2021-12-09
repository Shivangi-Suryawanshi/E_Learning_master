<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\WebsiteLanguage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class WebsiteLanguageController extends Controller
{

    public function translations()
    {
      
     
        $languages = ['en', 'ar'];
        $result_array = array();
        $key = array();
        // $pages = ['home_contents', 'authentication', 'home', 'profile', 'subscription', 'exam', 'notifications', 'errors', 'passwords','messages','months'];

       $pages = ['Home'];

        foreach ($pages as $key => $page) {
                 foreach ($languages as $language) { 

                App::setlocale($language);

              
                $text = File::getRequire(public_path('themes/traivis/languages') . '/' .$language.'.php');            

                $result_array[$page][$language] = $text;                        
        
                foreach ($result_array[$page][$language] as $key => $value) {
              
                    $results[$page][$key][$language] = $result_array[$page][$language][$key];
                  
                }
            }
        }
        return view('admin.translations')->with(['translations' => $result_array, 'results' => $results, 'languages' => $languages]);
    }

    public function save_translations(Request $request)
    {
//  dd($request->all());

        if (count($request->all())) {
            $result_array = array();
            $page = $request->input('page');
            $key = $request->input('key');
            $value = $request->input('value');
            $value_ar = $request->input('value_ar');

            if ($value) {
                
                // dd('hai');
                $code = 'en';
                App::setlocale($code);
                               
                $result_array = __t();
               
                $result_array[$key] = $value; 
                $data = var_export($result_array, true);
                $data = preg_replace('/\s\s+/', "\n", $data);

                          
                // File::put(public_path('lang') . '/' . $code . '/' . $page . '.php', "<?php\n return " . $data . ';');
                File::put(public_path('themes/traivis/languages') . '/' . 'en.php', "<?php\n return " . $data . ';');
         
            }
            if ($value_ar) {
                
                $code = 'ar';
                App::setlocale($code);
                $result_array = __t();
                $result_array[$key] = $value_ar;
                
                $data = var_export($result_array, true);
                $data = preg_replace('/\s\s+/', "\n", $data);                
                // dd(public_path('languages') . '/' . 'ar' . '/'  . '.php', "<?php\n return " . $data . ';');
                File::put(public_path('themes/traivis/languages') . '/' . 'ar.php', "<?php\n return " . $data . ';');
               
            }

            return response()->json([
                'success' => true,
                'msg' => 'content updated'], 200);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong!'], 400);
        }
    }
}
