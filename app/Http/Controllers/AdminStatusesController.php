<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralFormRequest;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        return view('admin.statuses.index', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralFormRequest $request)
    {

        if(Status::all()->count() <= 10){
            $status = Status::create($request->all());
            Session::flash('created_status_success', 'The status : ' . $status->name . ' has been created.');
        } else {
            Session::flash('created_status_failed', 'You can\'t create more than 10 statuses, delete some statuses before trying again');
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
        $status = Status::findOrFail($id);
        return view('admin.statuses.edit', compact('status'));
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
        $status = Status::findOrFail($id);
        $status->update($request->all());
        Session::flash('status_updated', 'The status : ' . $status->name .' is updated.');
        return redirect('/admin/statuses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        Session::flash('status_deleted', 'The status : ' . $status->name .' is deleted.');
        $status->delete();
        return redirect('/admin/statuses');
    }
}
