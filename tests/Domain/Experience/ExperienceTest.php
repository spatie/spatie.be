<?php

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Support\Uuid\Uuid;
use Database\Seeders\AchievementSeeder;
use Spatie\EventSourcing\Commands\CommandBus;
use Tests\TestCase;



test('100 xp achievement', function () {
    (new AchievementSeeder())->run();

    $uuid = Uuid::new();

    $bus = app(CommandBus::class);

    foreach (range(1, 2) as $i) {
        $bus->dispatch(new AddExperience(
            $uuid,
            1,
            50,
        ));
    }

    $this->assertDatabaseHas(UserAchievementProjection::class, [
        'user_id' => 1,
        'slug' => '100-experience',
    ]);

    $this->assertDatabaseMissing(UserAchievementProjection::class, [
        'user_id' => 1,
        'slug' => '1000-experience',
    ]);
});
