<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use App\Testimonial;
use App\AmenityConsumption;
use App\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use File;
use Carbon\Carbon;

class TestimonialController extends Controller
{
  public function index(Request $request)
  {
   
   $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();

         if ($request->bulk_action_btn){
            if(config('app.is_demo')) return back()->with('error', __a('demo_restriction'));
        }

      if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)){
            $data = ['status' => $request->status];

        
            Testimonial::whereIn('id', $ids)->update($data);
            return back()->with('success', __a('bulk_action_success'));
        }

        $freeResources = Testimonial::paginate(20);

   return view('admin.testimonials.index')->with('freeResources', $freeResources);


 }
 public function get_testimonial_data(Request $request)
 {

  $list = Testimonial::get();
  $data = $list;
  return Datatables::of($data)
  ->editColumn('s#', function ($model) {
    return '<span class="si_no"></span> ';
  })
   ->editColumn('title_en', function ($model) {
   return $model->title_en;
 })

      ->editColumn('title_ar', function ($model) {
   return $model->title_ar;
 })
 ->editColumn('status', function ($model) {
                if ($model->status == '1') {
                  return
                  '<div class="pretty p-switch p-fill">
                  <input type="checkbox" class="userStatus" data-type="activate" id="' . $model->id . '" data-id="' . $model->id . '"  data-status="' . $model->status . '" checked onchange="changeTestimonialStatus(this,\'inactivate\')" >
                  <div class="state p-success">
                  <label></label>
                  </div>
                  </div>';
                } else {
                  return
                  '<div class="pretty p-switch p-fill">
                  <input type="checkbox"  class="userStatus" data-type="inactivate" id="' . $model->id . '"  data-id="' . $model->id . '" data-status="' . $model->status . '"  onchange="changeTestimonialStatus(this,\'activate\')">
                  <div class="state p-success">
                  <label></label>
                  </div>
                  </div>';
                }
              })
  ->editColumn('action', function ($model) {
      $html = '';
        if(can('edit_testimonials')){
      $html .=  ' <a href="' . url('testimonials/edit/' . $model->id) . '" type="" class="fa fa-pencil-square-o" title="Edit"></a>';
      }      
                if($html == ''){
                    return 'No permission';
                }
                return $html;

  })
  
  ->rawColumns(['s#','title','status','action'])
  ->make(true);
}

public function view_testimonial($id) {
   
  $testimonial = Testimonial::find($id);
  return view('admin.testimonials.view')->with(array('testimonial' => $testimonial)); 

}


public function create_form() {


  return view('admin.testimonials.create')->with([

 ]);
}



public function create(Request $request) {


   $rules = array(
            'name_en' => 'required',
             'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
      
                  

        );
   $messages = array(
  //'document.required' => 'Please select an image',
   );
  $v = Validator::make($request->all(),$rules,$messages);

  if ($v->passes()) {

      $adimg = new Testimonial();      
      $adimg->title_en = $request->input('name_en');
      $adimg->description_en = $request->input('description_en');
       $adimg->position_en = $request->input('position_en');
      $adimg->position_ar = $request->input('position_ar');
       $adimg->title_ar = $request->input('name_ar');
      $adimg->description_ar = $request->input('description_ar');
      $main_image = $request->file('profile_file');


      if ($main_image) {
        $main_imageName = uniqid() . '.' . $main_image->extension();

        $adimg->img = $main_imageName;

        $main_image->move(public_path('testimonial_images/'), $main_imageName);
      } 
      $adimg->save();

 



    return redirect()->back()->with('message', 'Testimonials added successfully.');
 
} else {
 return redirect()->back()->withErrors($v->errors());
}
}
public function deleteTestimonial(Request $request)
{
  $id = $request->get('id');
  if (!empty($id)) {
    $obj = Testimonial::find($id);
    //delete from folder
    $img_path = public_path('testimonial_images').'/'.$obj->img;
    unlink($img_path);

    
    $obj->delete();
    return redirect()->back()->with('message', 'Deleted successfully.');
  } else {
    return redirect()->back()->with('message', 'No item selected');
  }
}
public function editTestimonial($id) {
  $testimonials = \App\Testimonial::find($id);
 
  return view('admin.testimonials.edit')->with([
   'testimonials' => $testimonials
 ]);

}
public function updateTestimonial(Request $request, $id) {


   $rules = array(
            'name_en' => 'required',
             'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
      
                  

        );
   $messages = array(
  //'document.required' => 'Please select an image',
   );
  $v = Validator::make($request->all(),$rules,$messages);

  if ($v->passes()) {

      $adimg =  \App\Testimonial::find($id);      
      $adimg->title_en = $request->input('name_en');
      $adimg->description_en = $request->input('description_en');
       $adimg->position_en = $request->input('position_en');
      $adimg->position_ar = $request->input('position_ar');
       $adimg->title_ar = $request->input('name_ar');
      $adimg->description_ar = $request->input('description_ar');
      $main_image = $request->file('profile_file');
   

      if ($main_image) {
        $main_imageName = uniqid() . '.' . $main_image->extension();

        $adimg->img = $main_imageName;

        $main_image->move(public_path('testimonial_images/'), $main_imageName);
      } 
      $adimg->save();

 



    return redirect()->back()->with('message', 'Testimonials updated successfully.');
 
} else {
 return redirect()->back()->withErrors($v->errors());
}
}


public function checkCertification(Request $request){
  $id = $request->get('id');  
  if (!empty($id)) {
    $count = Certification::where('domain_id',$id)->count();
    return response(['s' => true, 'count' => $count], 200);
  }

}


public function testimonialMedia(Request $request)
{

  $path = storage_path('tmp/uploads');

  if (!file_exists($path)) {
    mkdir($path, 0777, true);
  }

  $file = $request->file('file');

  $name = uniqid() . '_' . trim($file->getClientOriginalName());


  $file->move($path, $name);

  return response()->json([
    'name'          => $name,
    'original_name' => $file->getClientOriginalName(),
  ]);
}



public function changeTestimonialStatus(Request $request)
{
  $id = $request->get('id');
  $cstatus = $request->get('status');

  if (!empty($id)) {
    $record = \App\Testimonial::find($id);
    $record->status = $cstatus;
    $record->save();
    if ($record->status == "1") {
      return response(['s' => true, 'msg' => 'activated'], 200);
    } else {
      return response(['s' => false, 'msg' => 'deactivated'], 200);
    }
  }
}



}
