<?php

use App\Filament\Resources\Content\PlaylistResource\Pages\EditPlaylist;
use App\Filament\Resources\Courses\SeriesResource\Pages\EditSeries;
use App\Models\Playlist;
use App\Models\Series;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('medialibrary');
    Storage::fake('local');

    $this->actingAsSpatie();
});

it('stores uploaded playlist images on the media library disk', function () {
    $playlist = Playlist::factory()->create();

    Livewire::test(EditPlaylist::class, ['record' => $playlist->getRouteKey()])
        ->fillForm(['image' => UploadedFile::fake()->image('cover.png')])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($playlist->refresh()->getFirstMedia()->disk)->toBe('medialibrary');
});

it('stores uploaded series images on the media library disk', function () {
    $series = Series::factory()->create();

    Livewire::test(EditSeries::class, ['record' => $series->getRouteKey()])
        ->fillForm(['image' => UploadedFile::fake()->image('cover.png')])
        ->call('save');

    expect($series->refresh()->getFirstMedia('image')->disk)->toBe('medialibrary');
});
