<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordFormRequest;
use App\Option;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    /**
     * This is not admin, we just need to show the user information to the user
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $option = Option::where('user_id',$user->id)->first();
        return view ('users.user.show', compact('user', 'option'));
    }


    /**
     *
     *
     * Update the specified resource in storage.
     * The user can update is password
     * The options are done by the OptionsController
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PasswordFormRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = array();

        if (Hash::check($request['current_password'], $user->password)) {
            $data['password'] = Hash::make($request['password']);
            $user->update($data);
            Session::flash('password_changed', 'The password is changed.');
        } else {
            Session::flash('password_changed_failed', 'The password was not changed.');
        }

        return redirect()->back();
    }
}
