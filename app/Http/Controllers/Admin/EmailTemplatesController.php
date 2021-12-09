<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Company;
use App\User;
use App\Activity;
use App\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmailTemplatesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('ha');
        //   Auth::loginUsingId(1);
        $template = EmailTemplates::where('is_show',1)->orderBy('updated_at', 'asc')->get();

        return view('admin.email_template.email_templates', compact('template'));
    }
    public function getEmailtemplatesData(Request $request)
    {

        $data = \App\EmailTemplates::where('is_show',1)->orderBy('updated_at', 'asc')->get();
        return Datatables::of($data)

            ->editColumn('s#', function ($model) {
                return '<span class="si_no"></span> ';
            })
            ->editColumn('title', function ($model) {
                return $model->title;
            })

            ->editColumn('to', function ($model) {
                return $model->to;
            })

            ->editColumn('subject', function ($model) {
                return $model->subject;
            })

            ->editColumn('action', function ($model) {
                return '<a href="' . url('email_templates/edit/' . $model->id) . '" type="" class="act-sp" title="View"><i class="fas fa-edit"></i></a> ';
            })

            ->rawColumns(['s#', 'title', 'to', 'subject', 'action'])
            ->make(true);
    }

    public function email_template($id)
    {
        $template = \App\EmailTemplates::find($id);
        return view('admin.email_template.email_template')->with('template', $template);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_form()
    {
        return view('admin.email_template.email_templates_create');
    }

    public function create(Request $request)
    {
        $rules = array(
            'title' => 'required|min:2',
            'subject' => 'required|min:2',
            'content' => 'required|min:2',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $emailTemplates = new EmailTemplates();
            $emailTemplates->title = $request->input('title');
            $emailTemplates->to = $request->input('to');
            $emailTemplates->subject = $request->input('subject');
            $emailTemplates->email_body = $request->input('content');
            $emailTemplates->created_by = Auth::user()->id;
            $emailTemplates->save();
            return redirect()->back()->with('message', 'Data added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function edit_form($id)
    {
        $templateDetails = EmailTemplates::find($id);
        return view('admin.email_template.edit')->with('template_details', $templateDetails);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $v = Validator::make($request->all(), [
            'subject' => 'required',
            'content' => 'required|min:2',
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {

            $emailTemplates = EmailTemplates::find($id);
            $emailTemplates->to = $request->input('to');
            $emailTemplates->subject = $request->input('subject');
            $emailTemplates->email_body = $request->input('content');
            $emailTemplates->created_by = Auth::user()->id;
            $emailTemplates->save();
            return redirect()->back()->with('message', 'Data updated successfully.');
        }
    }

    public function delete(Request $request)
    {

        if (count($request->input('ids')) >= 1) {
            foreach ($request->input('ids') as $id) {
                EmailTemplates::where(array('id' => $id))->delete();
            }
            return redirect()->back()->with('message', 'Deleted successfully.');
        } else {
            return redirect()->back()->with('message', 'No item selected.');
        }
    }
}
