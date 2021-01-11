<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function home(Request $request)
    {
        return view('top.main');
    }

    public function about(Request $request){
        return view('top.about');
    }
}
