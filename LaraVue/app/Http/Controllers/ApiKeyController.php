<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    public function index()
    {
        return Inertia::render('ApiKeys/Index', [
            'apiKeys' => Auth::user()->apiKeys()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = $request->name;

        ApiKey::create([
            'user_id' => Auth::id(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(6), 
            'key' => Str::random(32), 
        ]);

        return redirect()->back();
    }

    public function edit(ApiKey $apiKey)
    {
        return Inertia::render('ApiKeys/Edit', [
            'apiKey' => $apiKey
        ]);
    }

    public function update(Request $request, ApiKey $apiKey)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $apiKey->update([
            'name' => $request->name,
        ]);

        return redirect()->route('api-keys.index');
    }

    public function destroy(ApiKey $apiKey)
    {        
        $apiKey->delete();

        return redirect()->route('api-keys.index');
    }
}