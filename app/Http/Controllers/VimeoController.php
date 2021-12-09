<?php

namespace App\Http\Controllers;
use App\Activity;
use App\Section;
use App\Content;
use App\User;
use App\VimeoVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Vimeo\Laravel\Facades\Vimeo;

class VimeoController extends Controller
{

    public function index(){
        /*$vds = Vimeo::request('/me/videos', ['per_page' => 1], 'GET');
    	echo "<pre>";
    	print_r($vds);*/
        $userid = Auth::user()->id;
        $videos = VimeoVideo::where('created_by',$userid)
                 ->where('status',1)
                 ->orderby('id','desc')->get();
        

        return view(theme('dashboard.vimeo.vimeo_manager'))->with(array('videos' => $videos));
    }


    public function postVimeoUploadsApi(Request $request){
        $rules = [
            'title'  => 'required',
            'video'  => 'required',
        ];
        $this->validate($request, $rules);
// dd($request->all());
        $file = $request->file('video');
        // dd($file);
        // $filename = $file->getClientOriginalName();
        // $path = public_path().'/temp/';
        // $vdofile = $file->move($path, $filename);
// dd($filename);

        $response = Vimeo::upload($file,
            ['name' => $request->input('title')
            ]
        );
      
        $resArr = explode("/",$response);
        $video_code = $resArr[2];
        
        $video  = new VimeoVideo();
        $video->title  = $request->input('title');
        $video->code   = $video_code;
        $video->created_by   = Auth::user()->id;
        $video->created_at   = date('Y-m-d H:i:s');
        $video->save();
        return redirect('dashboard/vimeo-manager');

    }

}
