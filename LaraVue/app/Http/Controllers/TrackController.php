<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::where('is_visible', true)->get();
        
        return Inertia::render('Tracks/Index', [
            'tracks' => $tracks,
        ]);
    }

    public function form()
    {
        return Inertia::render('Tracks/Form');
    }
}
