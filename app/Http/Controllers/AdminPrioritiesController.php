<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralFormRequest;
use App\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminPrioritiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $priorities = Priority::all();
        return view('admin.priorities.index', compact('priorities'));
    }

    /**
     * Store a newly created resource in storage.
     * Limit max to 10
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralFormRequest $request)
    {
        if(Priority::all()->count() <= 10){
            $priority = Priority::create($request->all());
            Session::flash('created_priority_success', 'The component : ' . $priority->name . ' has been created.');
        } else {
            Session::flash('created_priority_failed', 'You can\'t create more than 10 priorities, delete some priorities before trying again');
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
        $priority = Priority::findOrFail($id);
        return view('admin.priorities.edit', compact('priority'));
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
        $priority = Priority::findOrFail($id);
        $priority->update($request->all());
        Session::flash('priority_updated', 'The priority : ' . $priority->name .' is updated.');
        return redirect('/admin/priorities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $priority = Priority::findOrFail($id);

        Session::flash('priority_deleted', 'The component : ' . $priority->name .' has been deleted.');

        $priority->delete();
        return redirect('/admin/priorities');
    }
}
