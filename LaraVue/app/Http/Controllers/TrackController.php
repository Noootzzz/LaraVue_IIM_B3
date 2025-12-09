<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function create()
    {
        return Inertia::render('Tracks/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255' ],
            'artist' => ['required', 'string', 'max:255' ],
            'image' => ['required', 'image' ],
            'audio' => ['required', 'file', 'extensions:mp3,wav' ],
        ]);

        $slug = 'trk-' . Str::uuid();
        $imagePath = $request->image->storeAs('tracks/images', $slug . '.' . $request->image->extension(), 'public');
        $audioPath = $request->audio->storeAs('tracks/audio', $slug . '.' . $request->audio->extension(), 'public');

        Track::create([
            'slug' => $slug,
            'title' => $request->title,
            'artist' => $request->artist,
            'image' => $imagePath,
            'audio' => $audioPath,
            'is_visible' => true,
            'play_count' => 0,
        ]);

        return redirect()->route('tracks.index')->with('success', 'Track created successfully.');
    }
}
