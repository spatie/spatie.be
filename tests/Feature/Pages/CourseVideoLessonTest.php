<?php

use App\Models\Enums\LessonDisplayEnum;
use App\Models\Lesson;
use App\Models\Series;
use App\Models\Video;
use App\Services\Vimeo\Vimeo;

it('renders a free video lesson without download links', function () {
    $vimeo = $this->mock(Vimeo::class);
    $vimeo->shouldNotReceive('getVideo');

    $series = Series::factory()->create([
        'title' => 'Free course',
        'slug' => 'free-course',
    ]);

    $video = Video::withoutEvents(fn () => Video::factory()->create([
        'vimeo_id' => '123456',
        'hash' => 'private-hash',
        'title' => 'Free lesson',
        'description' => 'A free video lesson.',
        'downloadable' => true,
    ]));

    $lesson = Lesson::create([
        'content_type' => $video->getMorphClass(),
        'content_id' => $video->id,
        'series_id' => $series->id,
        'title' => 'Free lesson',
        'slug' => 'free-lesson',
        'display' => LessonDisplayEnum::FREE,
    ]);

    $this
        ->get(route('courses.show', [$series, $lesson]))
        ->assertSuccessful()
        ->assertSee('id="player"', false)
        ->assertSee('player.vimeo.com/video/123456?h=private-hash', false)
        ->assertDontSee('Download video')
        ->assertDontSee('>HD</a>', false)
        ->assertDontSee('>SD</a>', false);
});
