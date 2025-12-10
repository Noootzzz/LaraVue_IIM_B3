<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistRequest;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::withCount('tracks')->get();

        return Inertia::render('Playlists/Index', [
            'playlists' => $playlists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tracks = Track::where('is_visible', true)->get();

        return Inertia::render('Playlists/Create', [
            'tracks' => $tracks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaylistRequest $request)
    {
        $tracks = Track::whereIn('slug', $request->tracks)->where('is_visible', true)->get();

        if(count($request->tracks) !== $tracks->count() ) {
            throw ValidationException::withMessages([
                'tracks' => 'One or more selected tracks are invalid.',
            ]);
        }

        $playlist = Playlist::create([
            'title' => $request->title,
            'slug' => 'ply-' . Str::uuid(),
            'user_id' => $request->user()->id,
        ]);

        $playlist->tracks()->attach($tracks->pluck('id'));

        return redirect()->route('playlists.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        $playlist->load('tracks');
        
        return Inertia::render('Playlists/Show', [
            'playlist' => $playlist,
        ]);
    }

    public function addTrack(Request $request, Playlist $playlist)
    {
        $request->validate([
            'track_id' => ['required', 'exists:tracks,id'],
        ]);

        $playlist->tracks()->syncWithoutDetaching($request->track_id);

        return back();
    }

    public function removeTrack(Playlist $playlist, string $trackId)
    {
        $playlist->tracks()->detach($trackId);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        $playlist->load('tracks');
        $tracks = Track::where('is_visible', true)->get();

        return Inertia::render('Playlists/Edit', [
            'playlist' => $playlist,
            'tracks' => $tracks,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlaylistRequest $request, Playlist $playlist)
    {
        $tracks = Track::whereIn('slug', $request->tracks)->where('is_visible', true)->get();

        if(count($request->tracks) !== $tracks->count() ) {
            throw ValidationException::withMessages([
                'tracks' => 'One or more selected tracks are invalid.',
            ]);
        }

        $playlist->title = $request->title;
        $playlist->save();
        
        $playlist->tracks()->sync($tracks->pluck('id'));

        return redirect()->route('playlists.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();

        return redirect()->back();
    }
}
