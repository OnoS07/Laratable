<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cooking;
use App\Models\Recipe;

class CheckCooking
{
    public function handle($request, Closure $next)
    {
        $cooking = Cooking::find($request->id);
        $recipe = Recipe::find($cooking->recipe_id);
        if ($recipe->user != Auth::user()) {
            return redirect()->route('top.main');
        }
        return $next($request);
    }
}