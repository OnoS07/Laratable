<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Comment;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::where('recipe_status', 'open')->get();
        return view('recipe.index', ['recipes' => $recipes]);
    }

    public function show(Request $request)
    {
        $recipe = Recipe::find($request->id);
        return view('recipe.show', ['recipe' => $recipe]);
    }

    public function edit(Request $request)
    {
        $recipe = Recipe::find($request->id);
        return view('recipe.edit', ['recipe' => $recipe]);
    }

    public function update(Request $request)
    {
        $recipe = Recipe::find($request->id);
        if($request->recipe_status){
            if($recipe->ingredients->isEmpty()){
                return redirect()->route('recipe.show', ['id'=>$recipe]);
            }elseif($recipe->cookings->isEmpty()){
                return redirect()->route('recipe.show', ['id'=>$recipe]);
            }else{
                $recipe->update(['recipe_status' => $request->recipe_status]);
                return redirect()->route('recipe.show', ['id'=>$recipe]);
            }
        }else{
            $this->validate($request, Recipe::$rules);
            $recipe->title = $request->title;
            $recipe->introduction = $request->introduction;
            $recipe->amount = $request->amount;
    
            if($request->recipe_img){
                $filename = $request->file('recipe_img')->store('public');
                $recipe->recipe_img = str_replace('public/','',$filename); 
            }
    
            $recipe->save();
            return redirect()->route('recipe.show', ['id'=>$recipe]);
        }
    }

    public function create(Request $request)
    {
        return view('recipe.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, Recipe::$rules);
        $recipe = new Recipe;
        $recipe->user_id = $request->user_id;
        $recipe->title = $request->title;
        $recipe->introduction = $request->introduction;
        $recipe->amount = $request->amount;

        if($request->recipe_img){
            $filename = $request->file('recipe_img')->store('public');
            $recipe->recipe_img = str_replace('public/','',$filename);
        }else{
            $recipe->recipe_img = "";
        }

        $recipe->save();
        return redirect()->route('ingredient.edit', ['id'=>$recipe]);
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->id)->delete();
        return redirect()->route('recipe.index');
    }
}
