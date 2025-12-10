<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    //Trait
    use HasFactory;

    // protected $table = 'tracks';
    protected $fillable = [
        'slug',
        'title',
        'artist',
        'image',
        'audio',
        'is_visible',
        'play_count',
    ];
    
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)->withPivot('play_count')->withTimestamps();
    }
}
