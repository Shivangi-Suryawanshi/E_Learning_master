<?php

namespace App\Http\Controllers;

use App\Functionality;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FunctionalityController extends Controller
{
    public function index()
    {
        $title = __t('Functionalities');
        $functioalities = Functionality::get();
        // dd($functioalities);
        return view(theme('dashboard.functionalities.index'), compact('title', 'functioalities'));
    }
    public function createForm()
    {
        $title = __t('Create Functionalities');
        return view(theme('dashboard.functionalities.create'), compact('title'));
    }
    public function create(Request $request)
    {

        $rules = [
            'title'      => 'required',
            'description' => 'required',
        ];
        $this->validate($request, $rules);

        // dd($request->all());
        $function = new Functionality();
        $function->title = $request->title ;
        $function->description = $request->description ; 
        $function->save();

        return back()->with('success', __t('success_added_message'));

    }

    public function edit($id,Request $request)
    {
       
        $title = __t('Edit Functionalities');
        $edit = Functionality::find($id);
       
        return view(theme('dashboard.functionalities.edit'), compact('title','edit'));
    }

    public function update($id,Request $request)
    {

        $rules = [
            'title'      => 'required',
            'description' => 'required',
        ];
        $this->validate($request, $rules);


        $function = Functionality::find($id);
        $function->title = $request->title ;
        $function->description = $request->description ; 
        $function->save();
        return back()->with('success', __t('success_update_message'));
       
    }
}
