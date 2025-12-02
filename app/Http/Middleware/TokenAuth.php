<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization'); // Ambil token dari header

        if (!$token) {
            return response()->json(['message' => 'Token diperlukan'], 401);
        }

        $token = str_replace('Bearer ', '', $token);
        $realToken = "2y10Q71xkKprwaAZLzn0vhVnuepOFZoauSQokJqhJhPLlWpETCX8daNwa";

        if ($token != $realToken) {
            return response()->json(['message' => 'Token tidak valid'], 401);
        }

        return $next($request);
    }
}
