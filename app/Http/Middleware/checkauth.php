<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class checkauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   public function handle(Request $request, Closure $next)
{
    // Define the expected API token
    $expectedApiToken = '6QFOPCCPJ6C7YAJO317ILNQCRE64TA9Q';
    
    // Check if the API token is present and matches the expected token
    if ($request->input('api_token') !== $expectedApiToken) {
        return response()->json(['error' => 'Not Found'], 404);
    }

    // Continue to the next middleware or controller action
    return $next($request);
}
}
