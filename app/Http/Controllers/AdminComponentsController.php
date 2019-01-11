<?php

namespace App\Http\Controllers;

use App\Component;
use App\Http\Requests\GeneralFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminComponentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $components = Component::all();
        return view('admin.components.index', compact('components'));
    }

    /**
     * Store a newly created resource in storage.
     * Limit the number to 100 to avoid to have a too big table
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralFormRequest $request)
    {
        if(Component::all()->count() <= 100){
            $component = Component::create($request->all());
            Session::flash('created_component_success', 'The component : ' . $component->name . ' has been created.');
        } else {
            Session::flash('created_component_failed', 'You can\'t create more than 100 components, delete some components before trying again');
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
        $component = Component::findOrFail($id);
        return view('admin.components.edit', compact('component'));
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
        $component = Component::findOrFail($id);
        $component->update($request->all());
        Session::flash('component_updated', 'The component : ' . $component->name .' is updated.');

        return redirect('/admin/components');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $component = Component::findOrFail($id)->delete();
        Session::flash('component_deleted', 'The component : ' . $component->name .' is deleted.');
        $component->delete();
        return redirect('/admin/components');
    }
}
