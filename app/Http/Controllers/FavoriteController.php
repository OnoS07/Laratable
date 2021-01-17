<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Recipe;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $favorite = new Favorite;
        $favorite->recipe_id = $request->recipe_id;
        $favorite->user_id = $request->user_id;
        $favorite->save();

        $recipe = Recipe::find($request->recipe_id);
        return redirect()->route('recipe.show', ['id'=>$recipe]);
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->recipe_id);
        $favorite = Favorite::where('recipe_id', $recipe->id)->where('user_id', Auth::id())->first();
        $favorite->delete();
        return redirect()->route('recipe.show', ['id'=>$recipe]);
    }   
}
