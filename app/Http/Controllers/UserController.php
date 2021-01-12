<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = User::find($request -> id);
        return view('user.show', ['user' => $user]);
    }

    public function edit(Request $request)
    {
        $user = User::find($request -> id);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $form = $request->all();
        unset($form['_token']);
        $user->fill($form)->save();

        return redirect()->route('user.show', ['id' => $user->id]);
    }
}
