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
        if($cooking->save()){
            session()->flash('flash_update', 'UPDATE !');
        }
        return redirect()->route('cooking.edit', ['id'=>$cooking->recipe_id]);
    }

    public function store(Request $request)
    {
        $recipe = Recipe::find($request->recipe_id);
        $this->validate($request, Cooking::$rules);
        $cooking = new Cooking;
        $cooking->recipe_id = $request->recipe_id;
        $cooking->content = $request->content;

        if($cooking->save()){
            if($recipe->recipe_status == 'ingredient'){
                $recipe->update(['recipe_status' => 'cooking']);
            }elseif($recipe->recipe_status == 'empty' && isset($recipe->ingredients)){
                $recipe->update(['recipe_status' => 'close']);
            }
        }

        return redirect()->route('cooking.edit', ['id'=>$cooking->recipe_id]);
    }

    public function destroy(Request $request)
    {
        $recipe = Recipe::find($request->recipe_id);
        $cooking = Cooking::find($request->id);
        if($cooking->delete()){
            if(empty($recipe->cookings->first())){
                if($recipe->recipe_status == 'open' || $recipe->recipe_status == 'close'){
                    $recipe->update(['recipe_status' => 'empty']);
                    session()->flash('flash_notice', '作り方が入力されていません。確認して下さい');
                }
            }
        }
        return redirect()->route('cooking.edit', ['id'=>$recipe]);
    }
}

