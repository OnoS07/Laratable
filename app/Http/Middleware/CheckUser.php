<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    public function handle($request, Closure $next)
    {
        if ($request->id != Auth::id()) {
            return redirect()->route('user.edit', ['id'=>Auth::id()]);
        }
        return $next($request);
    }
}
