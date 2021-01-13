<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class TopController extends Controller
{
    public function main()
    {
        $recipes = Recipe::inRandomOrder()->take(3)->get();
        return view('top.main', ['recipes'=>$recipes]);
    }

    public function about()
    {
        return view('top.about');
    }
}
