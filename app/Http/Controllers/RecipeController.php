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
        
        if(empty($recipe->ingredients->first())){
            session()->flash('flash_ingredient', '材料がまだ入力されていません。確認して下さい');
        }
        if(empty($recipe->cookings->first())){
            session()->flash('flash_cooking', '作り方がまだ入力されていません。確認して下さい');
        }

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
            if(empty($recipe->ingredients->first())){
                return redirect()->route('recipe.show', ['id'=>$recipe]);
                session()->flash('flash_ingredient', '材料が入力されていないため投稿できません。確認して下さい');
            }elseif(empty($recipe->cookings->first())){
                return redirect()->route('recipe.show', ['id'=>$recipe]);
                session()->flash('flash_cooking', '作り方が入力されていないため投稿できません。確認して下さい');
            }else{
                $recipe->update(['recipe_status' => $request->recipe_status]);
                return redirect()->route('recipe.show', ['id'=>$recipe]);
                session()->flash('flash_create', 'YOUR RECIPE RELEASE !');
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
    
            if($recipe->save()){
                session()->flash('flash_create', 'UPDATE !');
            }
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

        if($recipe->save()){
            session()->flash('flash_create', 'NEW RECIPE CREATE !' );
            return redirect()->route('ingredient.edit', ['id'=>$recipe]);
        }

        return view('recipe.create');
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->id)->delete();
        return redirect()->route('recipe.index');
    }
}
