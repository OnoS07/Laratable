<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Recipe;
use App\Models\RecipeTag;
use App\Http\Requests\RecipeRequest;
use App\Services\RecipeService;

class RecipeController extends Controller
{
    public function __construct(RecipeService $service)
    {
        $this->service = $service;    
    }

    public function index(Request $request)
    {
        if($request->search_tag){
            $tag = $request->search_tag;
            return view('recipe.index', $this->service->TagRecipeIndex($tag));
        }elseif($request->search_word){
            $word = $request->input('search_word');
            return view('recipe.index', $this->service->SearchRecipeIndex($word));
        }else{
            return view('recipe.index', $this->service->RecipeIndex());
        }
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

        if($recipe->user_id != Auth::id()){
            $recipe->view_count = $recipe->view_count += 1;
            $recipe->update(['view_count' => $recipe->view_count]);
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

    public function store(RecipeRequest $request)
    {
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
            if($request->tag_names){
                $tags = Str::of($request->tag_names)->explode(',');
                foreach($tags as $tag){
                    $recipe_tag = New RecipeTag;
                    $recipe_tag->recipe_id = $recipe->id;
                    $recipe_tag->tag_name = $tag;
                    $recipe_tag->save();
                }
            }
            session()->flash('flash_create', 'NEW RECIPE CREATE !' );
            return redirect()->route('ingredient.edit', ['id'=>$recipe]);
        }else{
            return view('recipe.create');
        }
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->id)->delete();
        return redirect()->route('recipe.index');
    }
}
