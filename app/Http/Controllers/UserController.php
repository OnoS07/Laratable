<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Recipe;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = User::find($request -> id);
        $recipes = Recipe::where('user_id', Auth::id())->get();
        $open_recipes = Recipe::where('recipe_status', 'open')->get();
        $close_recipes = Recipe::where('recipe_status', '!=', 'open')->get();
        
        return view('user.show', ['user' => $user, 'recipes'=>$recipes, 'open_recipes'=>$open_recipes, 'close_recipes'=>$close_recipes]);
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
        
        if($user->save()){
            session()->flash('flash_update', 'PROFILE UPDATE ! ');
        }
        return redirect()->route('user.show', ['id' => $user]);
    }
}
