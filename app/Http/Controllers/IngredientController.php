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
}
