<?php

namespace App\Http\Controllers;

use App\Option;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionsController extends Controller
{


    /**
     * Update the specified resource in storage.
     * The options are created at the same time as the user, so we just need to update them
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Option::findOrFail($id)->update($request->all());
        return redirect()->back();
    }

}
