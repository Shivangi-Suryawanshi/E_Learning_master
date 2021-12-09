<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Page;
use App\HomePageSection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PageSection;
use App\PageSectionImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;


class CmsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1() {
     //   $pages = Page::all();
        return view('admin.pages.index');
    }

    public function cms_getdata(Request $request) {
        $pages = Page::orderBy('created_at', 'ASC');

        if($request->input('pageName')){
            $pages = $pages->where('title','like','%'.$request->input('pageName').'%');
        }

        $pages = $pages->get();
        return Datatables::of($pages)
                ->editColumn('id', function($model) {
                    return '<span class="si_no"></span> ';
                })


                ->editColumn('title_en', function($model) {
                    $title = $model->title_en;
                    if($model->status==1){
                        $title = '<a href="'.env('APP_URL').'/'.$model->slug.'" class="preview-btn" target="_blank">'.$title.'</a> ';
                    }
                    return $title;
                })


				->editColumn('created_at', function($model) {
					return $model->created_at!=null ? date('d F Y',strtotime($model->created_at)) : 'N/A';
                })


       
                 ->editColumn('status', function ($model) {
                if ($model->status == '1') {
                    return '<div class="pretty p-switch p-fill"><input type="checkbox" class="userStatus"  data-type="activate" id="' . $model->id . '" data-id="' . $model->id . '"  data-status="' . $model->status . '" checked onchange="changePageStatus(this,\'inactivate\')" ><div class="state p-success"><label></label></div></div>';
                } else {
                    return '<div class="pretty p-switch p-fill"><input type="checkbox"  class="userStatus"   data-type="inactivate" id="' . $model->id . '"  data-id="' . $model->id . '" data-status="' . $model->status . '"  onchange="changePageStatus(this,\'activate\')"><div class="state p-success"><label></label></div></div>';
                }
            })



				->editColumn('tblaction', function($model) {
                    // if(has_permission('Pages.edit')) {
                        return '<a href="' . url("pages/view/" . $model->id) . '"><i class="fa fa-edit"></i></a>';
                    // }else {
                    //     return '';
                    // }
                }) ->rawColumns(['id','title_en','status','created_at','tblaction'])
                ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $user = Auth::user();

        return view('admin.pages.create')->with('user', $user);
    }

    public function do_create(Request $request) {


        $user = Auth::user();

        $rules = array(
            'title_en' => 'required|min:2',
            'url_slug' => 'required|unique:pages,slug',
            'content_en' => 'required|min:2',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $pages = new Page();
            $pages->title_en = $request->input('title_en');
            $pages->title_ar = $request->input('title_ar');
            $pages->content_en = $request->input('content_en');
            $pages->content_ar = $request->input('content_ar');
            $pages->meta_title = $request->input('meta_title');
            $pages->meta_key = $request->input('meta_key');
            $pages->meta_description = $request->input('meta_desc');
            $pages->slug = $request->input('url_slug');
            $pages->status = $request->input('select_status');
            $pages->save();

            //Adding to activity table

            if ($pages->id) {
               

                return redirect()->back()->with(array('message' => 'Pages Successfully Added'));
            } else {
                return redirect()->back()->with(array('error' => 'Request Failed!'));
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($page_id) {

        $user = Auth::user();

        $data = Page::find($page_id);
   
        return view('admin.pages.page_view')->with(array('data' => $data, 'user' => $user));
    }

    public function edit($page_id, Request $request) {

     
           $user = Auth::user();
        if ($request->input('delete')) {
//            Code for deleting a page
            $page = Page::find($page_id);
            $page->delete();

            return redirect('pages')->with('user', $user);
        } else {
//        Code for editing the details of the page
            $rules = array(
                'title_en' => 'required|min:2',
                //'url_slug' => 'required|unique:pages,slug,'.$page_id,
                //'content_en' => 'required|min:2',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->passes()) {

                $page = Page::find($page_id);
                $page->title_en = $request->input('title_en');
                $page->title_ar = $request->input('title_ar');
                $page->content_en = '';
                $page->content_ar = '';
                $page->meta_key = $request->input('meta_key');
                $page->meta_description = $request->input('meta_desc');
                //$page->slug = $request->input('url_slug');
                $page->status = $request->input('select_status');
                $page->save();


                $pageSection = PageSection::where('page_id',$page->id)->get();

             
        
                if(count($pageSection)>0)
                {
                   
                foreach($request->content_en as $key => $content)
                {
                 $pageSection = PageSection::where('page_id',$page->id)->where('section_id',$key+1)->first();
                 $pageSection->page_id = $page->id;
                $pageSection->section_id = $key+1;
                $pageSection->content_en = $content;
                $pageSection->content_ar = $request->content_ar[$key];
                $pageSection->save();
                }
            }
           else{


                 $pageSection = new PageSection();
                $pageSection->page_id = $page->id;
                $pageSection->section_id = 1;
                $pageSection->content_en = $request->content_en[0];
                $pageSection->content_ar = $request->content_ar[0];
                $pageSection->save();
                   }


                if($pageSection)
                {
                 if($request->file('profile_file'))
                 {
                 foreach($request->file('profile_file') as $key => $img)
                 {
                $pageSectionImg = PageSectionImage::where('page_id',$page->id)->where('section_id',$key+1)->first();
                if($pageSectionImg)
                {
                $pageSectionImg->page_id = $page->id;
                $pageSectionImg->section_id = $key+1;
                $profile_pic_name  = uniqid() . '.' . $img->extension();
                $pageSectionImg->img = $profile_pic_name;
                $img->move(public_path('assets/page_images/'), $profile_pic_name);            
                $pageSectionImg->save();                                    
            }
                }
            }
                }

                //Adding to activity table

                if ($page->id) {
                    
                    return redirect()->back()->with(array('message' => 'Pages Successfully Updated'));
                }
            } else {
                return redirect()->back()->withErrors($validator)->with('user', $user);
            }
        }
    }

    public function show($slug) {
        $user = Auth::user();
        $data = Page::where('slug', $slug)->get();
        if ($data->count() > 0) {
            return view('page_display')->with(array('data' => $data, 'user' => $user));
        } else {
            return redirect('error')->with('user', $user);
        }
    }

    public function url_slug(Request $request) {
        if ($request->input('title')) {
            echo sanitize_url($request->input('title'));
        } else {
            echo NULL;
        }
    }

    ######### Home Page Sections ######### : start



 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function homeSectionIndex(Request $request){

      $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();

         if ($request->bulk_action_btn){
            if(config('app.is_demo')) return back()->with('error', __a('demo_restriction'));
        }

      if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)){
            $data = ['status' => $request->status];

        
            HomePageSection::whereIn('id', $ids)->update($data);
            return back()->with('success', __a('bulk_action_success'));
        }

        $freeResources = HomePageSection::paginate(20);
        // return view('admin.free_resources.index')->with('freeResources', $freeResources);
         return view('admin.pages.home_section_index')->with('freeResources', $freeResources);
    }




    // public function homeSectionIndex() {
    //     return view('admin.pages.home_section_index');
    // }

    public function homeSection_getdata(Request $request) {
        $pages = HomePageSection::orderBy('created_at', 'ASC');

        if($request->input('pageName')){
            $pages = $pages->where('title','like','%'.$request->input('pageName').'%');
        }

        $pages = $pages->get();
        return Datatables::of($pages)
                ->editColumn('id', function($model) {
                    return '<span class="si_no"></span> ';
                })


                ->editColumn('title_en', function($model) {
                    $title = $model->title_en;
                    if($model->status==1){
                        $title = '<a href="'.env('APP_URL').'/'.$model->slug.'" class="preview-btn" target="_blank">'.$title.'</a> ';
                    }
                    return $title;
                })


                ->editColumn('created_at', function($model) {
                    return $model->created_at!=null ? date('d F Y',strtotime($model->created_at)) : 'N/A';
                })


       
                 ->editColumn('status', function ($model) {
                if ($model->status == '1') {
                    return '<div class="pretty p-switch p-fill"><input type="checkbox" class="userStatus"  data-type="activate" id="' . $model->id . '" data-id="' . $model->id . '"  data-status="' . $model->status . '" checked onchange="changePageStatus(this,\'inactivate\')" ><div class="state p-success"><label></label></div></div>';
                } else {
                    return '<div class="pretty p-switch p-fill"><input type="checkbox"  class="userStatus"   data-type="inactivate" id="' . $model->id . '"  data-id="' . $model->id . '" data-status="' . $model->status . '"  onchange="changePageStatus(this,\'activate\')"><div class="state p-success"><label></label></div></div>';
                }
            })



                ->editColumn('tblaction', function($model) {
                    // if(has_permission('Pages.edit')) {
                        return '<a href="' . url("home-page-sections/view/" . $model->id) . '"><i class="fa fa-edit"></i></a>';
                    // }else {
                    //     return '';
                    // }
                }) ->rawColumns(['id','title_en','status','created_at','tblaction'])
                ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function homeSectionCreate() {

        $user = Auth::user();

        return view('admin.pages.home_section_create')->with('user', $user);
    }

    public function homeSectionDo_create(Request $request) {


        $user = Auth::user();

        $rules = array(
            'title_en' => 'required|min:2',
            'url_slug' => 'required|unique:pages,slug',
            
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $home = new \App\HomePageSection();
            $home->title_en = $request->input('title_en');
            $home->title_ar = $request->input('title_ar');
            $home->slug = $request->input('url_slug');
            $home->status = $request->input('select_status');
            $home->save();

            //Adding to activity table

            if ($home->id) {
               

                return redirect()->back()->with(array('message' => 'Pages Successfully Added'));
            } else {
                return redirect()->back()->with(array('error' => 'Request Failed!'));
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function homeSectionView($page_id) {

        //
        $user = Auth::user();

        $data = HomePageSection::find($page_id);
        return view('admin.pages.home_section_page_view')->with(array('data' => $data, 'user' => $user));
    }

    public function homeSectionEdit($page_id, Request $request) {
           $user = Auth::user();
        if ($request->input('delete')) {
//            Code for deleting a page
            $page = HomePageSection::find($page_id);
            $page->delete();

            return redirect('pages')->with('user', $user);
        } else {
//        Code for editing the details of the page
            $rules = array(
                'title_en' => 'required|min:2',
                //'url_slug' => 'required|unique:pages,slug,'.$page_id,
               
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->passes()) {
                $home = HomePageSection::find($page_id);
                $home->title_en = $request->input('title_en');
                $home->title_ar = $request->input('title_ar');
                $home->status = $request->input('select_status');
                $home->save();

                //Adding to activity table

                if ($home->id) {
                    
                    return redirect()->back()->with(array('message' => 'Pages Successfully Updated'));
                }
            } else {
                return redirect()->back()->withErrors($validator)->with('user', $user);
            }
        }
    }

    public function homeSectionShow($slug) {
        $user = Auth::user();
        $data = HomePageSection::where('slug', $slug)->get();
        if ($data->count() > 0) {
            return view('page_display')->with(array('data' => $data, 'user' => $user));
        } else {
            return redirect('error')->with('user', $user);
        }
    }

    public function homeSectionUrl_slug(Request $request) {
        if ($request->input('title')) {
            echo sanitize_url($request->input('title'));
        } else {
            echo NULL;
        }
    }







    ######### Home Page Sections ######### : end	
}
