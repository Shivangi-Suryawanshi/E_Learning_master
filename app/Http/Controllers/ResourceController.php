<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Company;
use App\FreeResource;
use App\User;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Response;
use Carbon;
use App\CompanyPosition;
use App\CompanyLanguage;
use App\CompanyIndustry;
use App\CompanyOccupation;


class ResourceController extends Controller{


  public function index(){

   if(Auth::check())
   {

    $freeResources = FreeResource::where('posted_by',Auth::user()->id)->paginate(20);
     //   return view('free_resources.index')->with('freeResources', $freeResources);
    return view(theme('dashboard.free_resources.index'),compact('freeResources'));
  }
}


public function getFreeResources(Request $request){



  $formData = $request->get('form_data');

  $params = array();
  parse_str($formData, $params);
  $valid_from = isset($params['starts_on']) ? $params['starts_on'] : '';

  $valid_to = isset($params['ends_on']) ? $params['ends_on'] : '';

  $status = isset($params['status']) ? (integer)($params['status']) : '';


  $list = FreeResource::whereNotNull('id');
  if ($valid_from) {
    $vfrom = Carbon\Carbon::parse($valid_from)->format('Y-m-d');
    $list = $list->where('created_at', '>=', $vfrom);
  }
  if ($valid_to) {
    $vto = Carbon\Carbon::parse($valid_to)->format('Y-m-d');
    $list = $list->where('created_at', '<=', $vto);
  }

  if (isset($params['status'])) {
    if ($params['status'] != '')
      $list = $list->where('status', $status);
  }
  $list = $list->get();

  $data = $list;
  return DataTables::of($data)

  ->editColumn('s#', function ($model) {
    return '<span class="si_no"></span> ';
  })
  ->editColumn('created_at', function ($model) {
    return Carbon\Carbon::parse($model->created_at)->format('d-M-Y');
  })
  ->editColumn('en_company_name', function ($model) {
    return $model->en_company_name;
                // return '<a style="cursor: pointer;"  class="user-title link adminuser-login" id="adminuser-login"  data-url="' . env('APP_URL') . '/profile"   data-user="' . $model->id . '" > ' . $model->title_en . '</a>';
  })

  ->editColumn('action', function ($model) {
    return "ff";
            //     $html = '';
            //   if(can('edit_company')){
            //     $html .= '<a href="'.url('free-resources/edit/'.$model->id).'" ><i class="fa fa-pencil-square-o ">&nbsp;&nbsp;</i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
            //    }
               // if(can('edit_company')){
               //     $html.= '<a href="#" class="delete-user" data-id="'.$model->id.'" title="Delete User"><i class="fa fa-trash-o"></i></a>';
               // }

                // if($html == ''){
                //     return 'No permission';
                // }
                // return $html;
  })
  ->rawColumns(['s#','en_company_name','website','en_position', 'status' ,'action'])
  ->make(true);
}

        /**
     * @return $this
     */
        public function createForm(){


          $skills = \App\Skill::get();
          $all_languages = \App\AllLanguage::where('active',1)->get();

        // return view('free_resources.create')->with([
        //     'skills' => $skills,
        //     'all_languages' => $all_languages
        //   ]);
          return view(theme('dashboard.free_resources.create'),compact('skills','all_languages'));
        }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){


      $data = $request->all();

      if($request->get('def_lan')=='en')
      {
        // $request->validate([
        //     'firstname' => 'required|min:2|max:200',
        //     'company_name_en' => 'required|min:2|max:200',
        //     'email' => 'required',

        //     ]);

        $rules = array(

          'title_en' => 'required|min:2|max:200',

        );
      }

      else
      {

        // $request->validate([
        //     'firstname' => 'required|min:2|max:200',
        //     'company_name_ar' => 'required|min:2|max:200',
        //     'email' => 'required',

        //     ]);

        $rules = array(

          'title_ar' => 'required|min:2|max:200',


        );

      }

      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
        return Response::json(['errors' => $validator->errors()]);
      } else {




        $free_resource = new \App\FreeResource();
        $free_resource->title_en = $request->get('title_en');
        $free_resource->title_ar = $request->get('title_ar');
        $free_resource->short_desc_en = $request->get('short_desc_en');
        $free_resource->short_desc_ar = $request->get('short_desc_ar');
        $free_resource->description_en = $request->get('main_desc_en');
        $free_resource->description_ar = $request->get('main_desc_ar');
        $free_resource->posted_by = Auth::user()->id;

        $main_image = $request->file('profile_file');

        if ($main_image) {
          $main_imageName = uniqid() . '.' . $main_image->extension();

          $free_resource->img = $main_imageName;

          $main_image->move(public_path('uploads/free_resources_images/'), $main_imageName);
        }



        $document = $request->file('document');

        if ($document) {
          $main_docName = uniqid() . '.' . $document->extension();

          $free_resource->document = $main_docName;
          $free_resource->doc_type = $document->extension();


          $document->move(public_path('uploads/free_resources_documents/'), $main_docName);
        }
        // $company->status = 1;
        $free_resource->save();

        foreach($request->get('skills') as $skill)
        {
          $lan = new \App\FreeResourceSkill();
          $lan->free_resource_id = $free_resource->id;
          $lan->skill_id = $skill;
          $lan->save();
        }
      }

      foreach($request->get('pre_language') as $prelan)
      {
        $lan = new \App\FreeResourceLanguage();
        $lan->free_resource_id = $free_resource->id;
        $lan->language_id = $prelan;
        $lan->save();
      }


      return response()->json(['status'=>true,'message'=> 'New Free Resource added.']);

    }


    public function updateForm($id){

      $skills = \App\Skill::get();
      $all_languages = \App\AllLanguage::where('active',1)->get();
      $free_resource = \App\FreeResource::where('posted_by',Auth::user()->id)->find($id);

      $selLanguages = \App\FreeResourceLanguage::where('free_resource_id',$free_resource->id)->pluck('language_id')->toArray();

      $selSkills = \App\FreeResourceSkill::where('free_resource_id',$free_resource->id)->pluck('skill_id')->toArray();

        // return view('free_resources.edit')->with([
        //    'skills' => $skills,
        //     'all_languages' => $all_languages,
        //     'free_resource' => $free_resource,
        //     'selLanguages' => $selLanguages,
        //     'selSkills' => $selSkills

        // ]);
      return view(theme('dashboard.free_resources.edit'),compact('skills','all_languages','free_resource','selLanguages','selSkills'));
    }

    public function update($id, Request $request){

      $data = $request->all();

      if($request->get('def_lan')=='en')
      {
        // $request->validate([
        //     'firstname' => 'required|min:2|max:200',
        //     'company_name_en' => 'required|min:2|max:200',
        //     'email' => 'required',

        //     ]);

        $rules = array(
         'title_en' => 'required|min:2|max:200',

       );
      }

      else
      {

        // $request->validate([
        //     'firstname' => 'required|min:2|max:200',
        //     'company_name_ar' => 'required|min:2|max:200',
        //     'email' => 'required',

        //     ]);

        $rules = array(
         'title_ar' => 'required|min:2|max:200',

       );

      }

      $validator = Validator::make($data, $rules);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($v->errors())->withInput($request->except('password'));
      }

      $free_resource = FreeResource::find($id);
      $free_resource->title_en = $request->get('title_en');
      $free_resource->title_ar = $request->get('title_ar');
      $free_resource->short_desc_en = $request->get('short_desc_en');
      $free_resource->short_desc_ar = $request->get('short_desc_ar');
      $free_resource->description_en = $request->get('main_desc_en');
      $free_resource->description_ar = $request->get('main_desc_ar');
         $free_resource->posted_by = Auth::user()->id;

      $main_image = $request->file('profile_file');

      if ($main_image) {
        $main_imageName = uniqid() . '.' . $main_image->extension();

        $free_resource->img = $main_imageName;

        $main_image->move(public_path('uploads/free_resources_images/'), $main_imageName);
      }



      $document = $request->file('document');

      if ($document) {
        $main_docName = uniqid() . '.' . $document->extension();

        $free_resource->document = $main_docName;
        $free_resource->doc_type = $document->extension();


        $document->move(public_path('uploads/free_resources_documents/'), $main_docName);
      }
        // $company->status = 1;
      $free_resource->save();


      $chkInd = \App\FreeResourceSkill::where('free_resource_id',$free_resource->id)->get();
      if(count($chkInd)>0){
        \App\FreeResourceSkill::where('free_resource_id',$free_resource->id)->delete();
      }
      foreach($request->get('skills') as $skill)
      {
        $lan = new \App\FreeResourceSkill();
        $lan->free_resource_id = $free_resource->id;
        $lan->skill_id = $skill;
        $lan->save();
      }



      $chkLan = \App\FreeResourceLanguage::where('free_resource_id',$free_resource->id)->get();
      if(count($chkLan)>0){
        \App\FreeResourceLanguage::where('free_resource_id',$free_resource->id)->delete();
      }

      foreach($request->get('pre_language') as $prelan)
      {
        $lan = new \App\FreeResourceLanguage();
        $lan->free_resource_id = $free_resource->id;
        $lan->language_id = $prelan;
        $lan->save();
      }






      /****************** Activity Adding ************/

      return response()->json(['status'=>true,'message'=> 'Free resource details updated.']);
    }


    public function changeCompanyStatus(Request $request)
    {
      $id = $request->get('id');
      $cstatus = $request->get('status');

      if (!empty($id)) {
        $record = \App\Company::find($id);
        $record->status = $cstatus;
        $record->save();
        if ($record->status == "1") {
          return response(['s' => true, 'msg' => 'activated'], 200);
        } else {
          return response(['s' => false, 'msg' => 'deactivated'], 200);
        }
      }
    }

    public function checkEmailvalid(Request $request)
    {
     $user = \App\User::all()->where('email', $request->get('email'))->first();
     if ($user) {

      return response(['s' => true, 'msg' => $request->get('email').' is already taken'], 200);
    } else {
      return response(['s' => false, 'msg' => 'Username is available'], 200);
    }
  }


  /** Login as company */
  public function userLogin(Request $request)
  {
    $id = $request->get('id');

    $company = \App\Company::find($id);



    $getUser = $company->getUser()->user_id;



    $user = \App\User::find($getUser);



    if ($user != null) {

            //  $user_key = $this->getToken(12, $user->id);

      $user_key = csrf_token();
             // dd($user_key);
    }
    $user->token = $user_key;
    $user->save();
    return env('COMPANY_URL') . '/loginas/' . $user_key;
  }

          /**
     * @param $length
     * @param $seed
     * @return string
     */
          private function getToken($length, $seed)
          {
            $token = "";
            $codeAlphabet = USER_KEY_ALPHA;
            $codeAlphabet .= USER_KEY_NUM;
        mt_srand($seed); // Call once. Good since $application_id is unique.
        for ($i = 0; $i < $length; $i++) {
          $token .= $codeAlphabet[mt_rand(0, strlen($codeAlphabet) - 1)];

        }
        return $token;
      }


    }
