<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralFormRequest;
use App\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminIssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::paginate(10);
        return view('admin.issues.index', compact('issues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralFormRequest $request)
    {
        if(Issue::all()->count() <= 100){
            $issue = Issue::create($request->all());
            Session::flash('created_issues_success', 'The issue : ' . $issue->name . ' has been created.');
        } else {
            Session::flash('created_issues_failed', 'You can\'t create more than 100 issues, delete some issues before trying again');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = Issue::findOrFail($id);
        return view('admin.issues.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GeneralFormRequest $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $issue->update($request->all());
        Session::flash('issue_updated', 'The issue : ' . $issue->name .' is updated.');

        return redirect('/admin/issues');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        Session::flash('issue_deleted', 'The issue : ' . $issue->name .' is deleted.');
        $issue->delete();
        return redirect('/admin/issues');
    }
}
