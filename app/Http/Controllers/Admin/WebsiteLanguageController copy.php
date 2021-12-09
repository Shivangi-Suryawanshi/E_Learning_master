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
        dd('copy lang');
        $languages = ['en', 'ar'];
        $result_array = array();
        $key = array();
        // $pages = ['home_contents', 'authentication', 'home', 'profile', 'subscription', 'exam', 'notifications', 'errors', 'passwords','messages','months'];

       $pages = ['admin'];

        foreach ($pages as $key => $page) {
            foreach ($languages as $language) {
                App::setlocale($language);
                $result_array[$page][$language] = Lang::get($page);

                foreach ($result_array[$page][$language] as $key => $value) {
                    $results[$page][$key][$language] = $result_array[$page][$language][$key];
                }
            }
        }
        return view('admin.translations')->with(['translations' => $result_array, 'results' => $results, 'languages' => $languages]);
    }

    public function save_translations(Request $request)
    {

        if (count($request->all())) {
            $result_array = array();
            $page = $request->input('page');
            $key = $request->input('key');
            $value = $request->input('value');
            $value_ar = $request->input('value_ar');

            if ($value) {
                $code = 'en';
                App::setlocale($code);
                $result_array = Lang::get($page);
                $result_array[$key] = $value;
                $data = var_export($result_array, true);
                $data = preg_replace('/\s\s+/', "\n", $data);
                File::put(resource_path('lang') . '/' . $code . '/' . $page . '.php', "<?php\n return " . $data . ';');
            }
            if ($value_ar) {
                $code = 'ar';
                App::setlocale($code);
                $result_array = Lang::get($page);
                $result_array[$key] = $value_ar;
                $data = var_export($result_array, true);
                $data = preg_replace('/\s\s+/', "\n", $data);
                File::put(resource_path('lang') . '/' . $code . '/' . $page . '.php', "<?php\n return " . $data . ';');
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
