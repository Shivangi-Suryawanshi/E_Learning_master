<?php

namespace App\Http\Controllers;

use App\Functionality;
use App\Package;
use App\PackageFunctionality;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackagesController extends Controller
{
    public function index()
    {
        $title = __t('Packages');
        $packages = Package::get();
        // dd($packages);
        return view(theme('dashboard.packages.index'), compact('title', 'packages'));
    }
    public function createForm()
    {
        $title = __t('Create Package');
        return view(theme('dashboard.packages.create'), compact('title'));
    }
    public function create(Request $request)
    {
// dd($request->all());
        $rules = [
            'title'      => 'required',
            'description' => 'required',
            'sale_price'=>'required',
            'regular_price'=>'required',
            'month'=>'required',
            'status'=>'required'
        ];
        $this->validate($request, $rules);

        // dd($request->all());
        $package = new Package();
        $package->title = $request->title ;
        $package->regular_price = $request->regular_price;
        $package->month = $request->month ;
        $package->sale_price =$request->sale_price ;
        $package->description = $request->description ; 
        $package->status = $request->status ;
        $package->save();

        return back()->with('success', __t('success_added_message'));

    }

    public function edit($id,Request $request)
    {
        $title = __t('Edit Package');
        $edit = Package::find($id);
        return view(theme('dashboard.packages.edit'), compact('title','edit'));
    }

    public function update($id,Request $request)
    {

        $rules = [
            'title'      => 'required',
            'description' => 'required',
            // 'sale_price'=>'required',
            // 'regular_price'=>'required',
            'month'=>'required'
        ];
        $this->validate($request, $rules);


        $package = Package::find($id);
        $package->title = $request->title ;
        $package->description = $request->description ; 
        $package->regular_price = $request->regular_price;
        $package->month = $request->month ;
        $package->sale_price =$request->sale_price ;
        $package->status = $request->status ;
        $package->save();
        return back()->with('success', __t('success_update_message'));
       
    }

    public function functionality(Request $request,$id)
    {
       
        $title = __t('Subscription');
        $package = Package::find($id);
        if($package->status == 0)
        {
            return redirect(url('admin/packages'));
        }
        $functionality = Functionality::get();
        $packageFunctionality = PackageFunctionality::where('package_id',$id)->get();
        if($packageFunctionality)
        {
            foreach($packageFunctionality as $fun)
            {
                if(empty($fun))
                {
                    return redirect()->back();
                }
            }
        }
        return view(theme('dashboard.packages.functionality'), compact('title','package','functionality','packageFunctionality'));
    }
    public function functionalityCreate(Request $request,$id)
    {
        // dd($request->all());
        $functionality = $request->functionality ;
     
        // $offerPrice = array_filter($request->offer_price);
      
        $totalCount = array_filter($request->total_count);
        // dd(count($totalCount ));
    //   if(count($totalCount)  ==0)
    //   {
    //     //   dd('ja');
    //     return back()->with('error', __t('Please Select Functionality'));

    //   }
        PackageFunctionality::where('package_id',$id)->delete();
        if($functionality)
        {
            foreach($functionality as $key  => $list)
            {
                
                    $packFunctionality = new PackageFunctionality();
                    $packFunctionality->functionality_id = $list ;
                    $packFunctionality->package_id = $id  ;
                    $packFunctionality->count = isset($totalCount[$key]) ? $totalCount[$key] : 0;
                    $packFunctionality->save();
                
            }
        }
        return back()->with('success', __t('subscription_plan'));

        
    }
    public function subscription()
    {

        $title = __t('Subscription List');
        $packageSubscription = Subscription::latest()->get();
        return view(theme('dashboard.packages.subscription-list'), compact('title','packageSubscription'));

    }
}
