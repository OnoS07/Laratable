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

        $user->name = $request->name;
        $user->introduction = $request->introduction;

        if($request->profile_img){
            $filename = $request->file('profile_img')->store('public'); // publicフォルダに保存
            $user->profile_img = str_replace('public/','',$filename); // 保存するファイル名からpublicを除外
        }
        
        $user->save();
        return redirect()->route('user.show', ['id' => $user]);
    }
}
