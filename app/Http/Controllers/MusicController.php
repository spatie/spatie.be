<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Playlist;
use Illuminate\Support\Str;

class MusicController
{
    public function __invoke(): View
    {
        $playlists = Playlist::query()->get()->sortByDesc(
            // Take number from "#123: The Playlist Title"
            fn (Playlist $playlist) => (int) Str::of($playlist->name)
                ->after('#')
                ->before(':')
                ->toString()
        );

        return view('front.pages.blog.music', ['playlists' => $playlists]);
    }
}
