<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->path() == 'api/admin/login') {
            return $next($request);
        }
        if (!Auth::check()) {
            return response()->json([
                'msg' => 'You are not allowed for access this route',
                'url' => $request->path()
            ], 403);
        }
        $user = Auth::user();
        if ($user->role->isAdmin == 4) {
            return response()->json([
                'msg' => 'You are not allowed for access this route'
            ], 403);
        }
        return $next($request);
    }
}
