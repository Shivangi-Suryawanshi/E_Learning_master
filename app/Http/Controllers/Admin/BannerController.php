<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Carbon\Carbon;
use App\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;

class BannerController extends Controller
{
  
//category start

public function bannerIndex()
{   
 return view('admin.banners.index');
}
public function getBannerData(Request $request)
{

  $data = \App\Banner::orderBy('updated_at','asc')->get();
  return Datatables::of($data)

  ->editColumn('s#', function ($model) {
    return '<span class="si_no"></span> ';
  })
  ->editColumn('name', function ($model) {
 return $model->getPage ? $model->getPage->title_en : '';
 })

  ->editColumn('status', function ($model) {
    if ($model->status == '1') {
      return
      '<div class="pretty p-switch p-fill">
      <input type="checkbox" class="userStatus" data-type="activate" id="' . $model->id . '" data-id="' . $model->id . '"  data-status="' . $model->status . '" checked onchange="changeDirectoryCategoryStatus(this,\'inactivate\')" >
      <div class="state p-success">
      <label></label>
      </div>
      </div>';
    } else {
      return
      '<div class="pretty p-switch p-fill">
      <input type="checkbox"  class="userStatus" data-type="inactivate" id="' . $model->id . '"  data-id="' . $model->id . '" data-status="' . $model->status . '"  onchange="changeDirectoryCategoryStatus(this,\'activate\')">
      <div class="state p-success">
      <label></label>
      </div>
      </div>';
    }
  })
  ->editColumn('created_date', function ($model) {
   return $model->created_at!=null ? date('d F Y',strtotime($model->created_at)) : 'N/A';
 })

  ->editColumn('action', function ($model) {
    return '<a href="' . url('banner-images/edit/' . $model->id) . '" type="" class="act-sp" title="Edit"><i class="fas fa-edit"></i></a> ';
  })
  
  ->rawColumns(['s#','name','status','action'])
  ->make(true);
}

public function createBanner() {

  $pages = \App\Page::where('status',1)->get();
  return view('admin.banners.create')->with(['pages' => $pages]);
}

public function saveBanner(Request $request) {

  $rules = array(
    'title_en' => 'required|min:2',
  );

  $validator = Validator::make($request->all(), $rules);
  if ($validator->passes()) {


    $keel = new \App\Banner();
    $keel->page_id = $request->input('sel_page');
    $keel->title_en = $request->input('title_en');
    $keel->title_ar = $request->input('title_ar');
    $keel->content_en = $request->input('content_en');
    $keel->content_ar = $request->input('content_ar');
    $keel->slug = $this->createBannerSlug($request->input('title_en'));
    $main_image = $request->file('profile_file');

    if ($main_image) {
      $main_imageName = uniqid() . '.' . $main_image->extension();

      $keel->logo = $main_imageName;

      $main_image->move(public_path('banners/'), $main_imageName);
    }
    $keel->save();
    return redirect()->back()->with(array('message' => 'Category Successfully Added'));

  }
  else {
    return redirect()->back()->withErrors($validator)->withInput();
  }



}


public function editBanner($id) {

  $type = \App\Banner::find($id);

  $pages = \App\Page::where('status',1)->get();

  return view('admin.banners.edit')->with([
    'type' => $type,
    'pages' => $pages
  ]);
}

public function updateBanner(Request $request, $id) {

  $v = Validator::make($request->all(), [
    'title_en' => 'required',

  ]);

  if ($v->fails()) {
    return redirect()->back()->withErrors($v->errors());
  } else {

    $keel = \App\Banner::find($id);
    $keel->page_id = $request->input('sel_page');
     $keel->title_en = $request->input('title_en');
    $keel->title_ar = $request->input('title_ar');
    $keel->content_en = $request->input('content_en');
    $keel->content_ar = $request->input('content_ar');
    $main_image = $request->file('profile_file');
        if ($main_image) {
      $main_imageName = uniqid() . '.' . $main_image->extension();

      $keel->logo = $main_imageName;

      $main_image->move(public_path('banners/'), $main_imageName);
    }
    $keel->save();
    return redirect()->back()->with('message', 'Banner updated successfully.');
  }
}

public function createBannerSlug($title, $id = 0)
{
        // Normalize the title
  $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
  $allSlugs = $this->getRelatedDirectoryCategorySlugs($slug, $id);

        // If we haven't used it before then we are all good.
  if (! $allSlugs->contains('slug', $slug)){
    return $slug;
  }

        // Just append numbers like a savage until we find not used.
  for ($i = 1; $i <= 10; $i++) {
    $newSlug = $slug.'-'.$i;
    if (! $allSlugs->contains('slug', $newSlug)) {
      return $newSlug;
    }
  }

  throw new \Exception('Can not create a unique slug');
}

protected function getRelatedDirectoryCategorySlugs($slug, $id = 0)
{
  return \App\Banner::select('slug')->where('slug', 'like', $slug.'%')
  ->where('id', '<>', $id)
  ->get();
}

public function changeBannerStatus(Request $request)
{
  $id = $request->get('id');
  $cstatus = $request->get('status');

  if (!empty($id)) {
    $record = \App\Banner::find($id);
    $record->status = $cstatus;
    $record->save();
    if ($record->status == "1") {
      return response(['s' => true, 'msg' => 'activated'], 200);
    } else {
      return response(['s' => false, 'msg' => 'deactivated'], 200);
    }
  }
}

// category end



////// HOME PAGE BANNERS ////////////

public function homeBannerIndex(Request $request)
{   

  $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();

         if ($request->bulk_action_btn){
            if(config('app.is_demo')) return back()->with('error', __a('demo_restriction'));
        }

      if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)){
            $data = ['status' => $request->status];

        
            HomeBanner::whereIn('id', $ids)->update($data);
            return back()->with('success', __a('bulk_action_success'));
        }

        $freeResources = HomeBanner::paginate(20);
        // return view('admin.free_resources.index')->with('freeResources', $freeResources);
         return view('admin.home_banners.index')->with('freeResources', $freeResources);



}
public function homeGetBannerData(Request $request)
{

  $data = \App\HomeBanner::orderBy('updated_at','asc')->get();
  return Datatables::of($data)

  ->editColumn('s#', function ($model) {
    return '<span class="si_no"></span> ';
  })
  ->editColumn('name', function ($model) {
   return $model->getPage->title_en;
 })

  ->editColumn('status', function ($model) {
    if ($model->status == '1') {
      return
      '<div class="pretty p-switch p-fill">
      <input type="checkbox" class="userStatus" data-type="activate" id="' . $model->id . '" data-id="' . $model->id . '"  data-status="' . $model->status . '" checked onchange="changeDirectoryCategoryStatus(this,\'inactivate\')" >
      <div class="state p-success">
      <label></label>
      </div>
      </div>';
    } else {
      return
      '<div class="pretty p-switch p-fill">
      <input type="checkbox"  class="userStatus" data-type="inactivate" id="' . $model->id . '"  data-id="' . $model->id . '" data-status="' . $model->status . '"  onchange="changeDirectoryCategoryStatus(this,\'activate\')">
      <div class="state p-success">
      <label></label>
      </div>
      </div>';
    }
  })
  ->editColumn('created_date', function ($model) {
   return $model->created_at!=null ? date('d F Y',strtotime($model->created_at)) : 'N/A';
 })

  ->editColumn('action', function ($model) {
    return '<a href="' . url('home-banner-images/edit/' . $model->id) . '" type="" class="act-sp" title="Edit"><i class="fas fa-edit"></i></a> ';
  })
  
  ->rawColumns(['s#','name','status','action'])
  ->make(true);
}

public function homeCreateBanner() {

  $pages = \App\HomePageSection::where('status',1)->get();

  return view('admin.home_banners.create')->with(['pages' => $pages]);
}

public function homeSaveBanner(Request $request) {

  $rules = array(
    'title_en' => 'required|min:2',
  );

  $validator = Validator::make($request->all(), $rules);
  if ($validator->passes()) {


    $keel = new \App\HomeBanner();
    $keel->page_id = $request->input('sel_page');
    $keel->title_en = $request->input('title_en');
    $keel->title_ar = $request->input('title_ar');
    $keel->short_desc_en = $request->input('short_content_en');
    $keel->short_desc_ar = $request->input('short_content_ar');
    $keel->content_en = $request->input('content_en');
    $keel->content_ar = $request->input('content_ar');
    $keel->slug = $this->createBannerSlug($request->input('title_en'));
    $main_image = $request->file('profile_file');

    if ($main_image) {
      $main_imageName = uniqid() . '.' . $main_image->extension();

      $keel->logo = $main_imageName;

      $main_image->move(public_path('home_banners/'), $main_imageName);
    }
    $keel->save();
    return redirect()->back()->with(array('message' => 'Banner Successfully Added'));

  }
  else {
    return redirect()->back()->withErrors($validator)->withInput();
  }



}


public function homeEditBanner($id) {

  $type = \App\HomeBanner::find($id);

  $pages = \App\HomePageSection::where('status',1)->get();

  return view('admin.home_banners.edit')->with([
    'type' => $type,
    'pages' => $pages
  ]);
}

public function homeUpdateBanner(Request $request, $id) {

 // dd($request->input('content_en'));

  $v = Validator::make($request->all(), [
    'title_en' => 'required',

  ]);

  if ($v->fails()) {
    return redirect()->back()->withErrors($v->errors());
  } else {

    $keel = \App\HomeBanner::find($id);
    $keel->page_id = $request->input('sel_page');
     $keel->title_en = $request->input('title_en');
    $keel->title_ar = $request->input('title_ar');
    $keel->short_desc_en = $request->input('short_content_en');
    $keel->short_desc_ar = $request->input('short_content_ar');
    $keel->content_en = $request->input('content_en');
    $keel->content_ar = $request->input('content_ar');
    $main_image = $request->file('profile_file');
        if ($main_image) {
      $main_imageName = uniqid() . '.' . $main_image->extension();

      $keel->logo = $main_imageName;

      $main_image->move(public_path('home_banners/'), $main_imageName);
    }
    $keel->save();
    return redirect()->back()->with('message', 'Banner updated successfully.');
  }
}

public function homeCreateBannerSlug($title, $id = 0)
{
        // Normalize the title
  $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
  $allSlugs = $this->getRelatedDirectoryCategoryOneSlugs($slug, $id);

        // If we haven't used it before then we are all good.
  if (! $allSlugs->contains('slug', $slug)){
    return $slug;
  }

        // Just append numbers like a savage until we find not used.
  for ($i = 1; $i <= 10; $i++) {
    $newSlug = $slug.'-'.$i;
    if (! $allSlugs->contains('slug', $newSlug)) {
      return $newSlug;
    }
  }

  throw new \Exception('Can not create a unique slug');
}

protected function getRelatedDirectoryCategoryOneSlugs($slug, $id = 0)
{
  return \App\HomeBanner::select('slug')->where('slug', 'like', $slug.'%')
  ->where('id', '<>', $id)
  ->get();
}

public function changeHomeBannerStatus(Request $request)
{
  $id = $request->get('id');
  $cstatus = $request->get('status');

  if (!empty($id)) {
    $record = \App\HomeBanner::find($id);
    $record->status = $cstatus;
    $record->save();
    if ($record->status == "1") {
      return response(['s' => true, 'msg' => 'activated'], 200);
    } else {
      return response(['s' => false, 'msg' => 'deactivated'], 200);
    }
  }
}

// category end


}
