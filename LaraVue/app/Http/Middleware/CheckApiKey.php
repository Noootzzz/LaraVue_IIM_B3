<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;

class CheckApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('x-api-key');

        if (!$key) {
            return response()->json(['message' => 'Clé API manquante (x-api-key header required)'], 401);
        }

        $apiKey = ApiKey::where('key', $key)->first();

        if (!$apiKey) {
            return response()->json(['message' => 'Clé API invalide'], 403);
        }

        $request->setUserResolver(function () use ($apiKey) {
            return $apiKey->user;
        });

        return $next($request);
    }
}