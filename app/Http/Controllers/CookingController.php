<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cooking;
use App\Models\Recipe;

class CookingController extends Controller
{
    public function edit(Request $request)
    {
        $recipe = Recipe::find($request->id);
        return view('cooking.edit', ['recipe'=>$recipe]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Cooking::$rules);
        $cooking = Cooking::find($request->id);
        $cooking->content = $request->content;
        $cooking->save();
        return redirect()->route('cooking.edit', ['id'=>$cooking->recipe_id]);
    }

    public function store(Request $request)
    {
        $this->validate($request, Cooking::$rules);
        $cooking = new Cooking;
        $cooking->recipe_id = $request->recipe_id;
        $cooking->content = $request->content;
        $cooking->save();
        return redirect()->route('cooking.edit', ['id'=>$cooking->recipe_id]);
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->recipe_id);
        $cooking = Cooking::find($request->id)->delete();
        return redirect()->route('cooking.edit', ['id'=>$recipe]);
    }
}

