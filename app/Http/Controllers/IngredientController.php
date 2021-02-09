<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Recipe;

class IngredientController extends Controller
{
    public function edit(Request $request)
    {
        $recipe = Recipe::find($request->id);
        return view('ingredient.edit', ['recipe'=>$recipe]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Ingredient::$rules, [], ['content'=>'具材', 'amount'=>'分量']);
        $ingredient = Ingredient::find($request->id);
        $ingredient->content = $request->content;
        $ingredient->amount = $request->amount;
        if($ingredient->save()){
            session()->flash('flash_update', 'UPDATE !');
        }
        return redirect()->route('ingredient.edit', ['id'=>$ingredient->recipe_id]);
    }

    public function store(Request $request)
    {
        $recipe = Recipe::find($request->recipe_id);
        $this->validate($request, Ingredient::$rules, [], ['content'=>'具材', 'amount'=>'分量']);
        $ingredient = new Ingredient;
        $ingredient->recipe_id = $request->recipe_id;
        $ingredient->content = $request->content;
        $ingredient->amount = $request->amount;

        if($ingredient->save()){
            if($recipe->recipe_status == 'recipe'){
                $recipe->update(['recipe_status' => 'ingredient']);
            }elseif($recipe->recipe_status == 'empty' && isset($recipe->cookings)){
                $recipe->update(['recipe_status' => 'close']);
            }
        }

        return redirect()->route('ingredient.edit', ['id'=>$ingredient->recipe_id]);
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->recipe_id);
        $ingredient = Ingredient::find($request->id);
        $ingredients = Ingredient::where('recipe_id', $recipe);
        if($ingredient->delete()){
            if(empty($ingredients->first())){
                if($recipe->recipe_status == 'open' || $recipe->recipe_status == 'close'){
                    $recipe->update(['recipe_status' => 'empty']);
                    session()->flash('flash_notice', ' 材料が入力されていません。確認して下さい');
                }
            }
        }
        return redirect()->route('ingredient.edit', ['id'=>$recipe]);
    }
}

