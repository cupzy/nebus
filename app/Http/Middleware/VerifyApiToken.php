<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-TOKEN');
        $validToken = config('app.api_token');

        if ($token !== $validToken) {
            return response()->json(status: 401);
        }

        return $next($request);
    }
}
