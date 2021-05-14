<?php

namespace Database\Seeders;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    public function run(): void
    {
        Playlist::factory()
            ->count(3)
            ->state(new Sequence(
            [
                'name' => '#1: Late Nite Something',
                'spotify_url' => 'https://open.spotify.com/playlist/3PONMswLMDbeRdCEx4MOxO',
                'apple_music_url' => 'https://music.apple.com/be/playlist/corporate-melodies-1-late-night-something/pl.u-RmWDiP6A24',
            ],
            [
                'name' => '#2: My Opel Corsa',
                'spotify_url' => 'https://open.spotify.com/playlist/0rw7PsTmtm8PEfsF63lsF0',
                'apple_music_url' => 'https://music.apple.com/be/playlist/corporate-melodies-2-my-opel-corsa/pl.u-vmG3TYoaLr',
            ],
            [
                'name' => '#3: Belgian Wonders',
                'spotify_url' => 'https://open.spotify.com/playlist/6RoreKy23iKHj09TLfEoFr?si=c874a4fb0c2b4708',
                'apple_music_url' => 'https://music.apple.com/be/playlist/corporate-melodies-3-belgian-wonders/pl.u-RmZxCP6A24',
            ]
        ))->create();
    }
}
