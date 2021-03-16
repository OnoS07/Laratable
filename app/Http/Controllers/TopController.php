<?php

namespace App\Http\Controllers;

use App\Services\TopService;

class TopController extends Controller
{
    public function __construct(TopService $service)
    {
        $this->service = $service;    
    }

    public function main()
    {
        return view('top.main', $this->service->TopRecipeIndex());
    }

    public function about()
    {
        return view('top.about');
    }
}
