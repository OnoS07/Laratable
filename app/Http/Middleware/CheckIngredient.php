<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;
use App\Models\Recipe;

class CheckIngredient
{
    public function handle($request, Closure $next)
    {
        $ingredient = Ingredient::find($request->id);
        $recipe = Recipe::find($ingredient->recipe_id);
        if ($recipe->user != Auth::user()) {
            return redirect()->route('top.main');
        }
        return $next($request);
    }
}
