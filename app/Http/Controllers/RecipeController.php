<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::all();
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
        $this->validate($request, Recipe::$rules);
        $recipe = Recipe::find($request->id);
        $recipe->title = $request->title;
        $recipe->introduction = $request->introduction;
        $recipe->amount = $recipe->amount;

        if($request->recipe_img){
            $filename = $request->file('recipe_img')->store('public'); // publicフォルダに保存
            $recipe->recipe_img = str_replace('public/','',$filename); // 保存するファイル名からpublicを除外
        }

        $recipe->save();
        return redirect()->route('recipe.show', ['id'=>$recipe]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
