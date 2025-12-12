<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckApiKey;


Route::middleware(CheckApiKey::class)->get('/playlists', function (Request $request) {
    return $request->user()->playlists()->with('tracks')->get();
});