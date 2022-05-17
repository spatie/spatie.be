<?php

namespace App\Http\Controllers;

use App\Models\Playlist;

class MusicController
{
    public function __invoke()
    {
        $playlists = Playlist::query()->orderByDesc('name')->get();

        return view('front.pages.blog.music', ['playlists' => $playlists]);
    }
}
