<?php

namespace App\Http\Controllers;

use App\Models\Playlist;

class MusicController
{
    public function __invoke()
    {
        $playlists = Playlist::query()->latest()->get();

        return view('front.pages.music.index', ['playlists' => $playlists]);
    }
}
