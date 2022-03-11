<?php

use App\Domain\Experience\Commands\AddExperience;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\User;
use App\Support\Uuid\Uuid;
use Database\Seeders\AchievementSeeder;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use Spatie\EventSourcing\Commands\CommandBus;

test('100 xp achievement', function () {
    User::factory()->create();

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

    assertDatabaseHas(UserAchievementProjection::class, [
        'user_id' => 1,
        'slug' => '100-experience',
    ]);

    assertDatabaseMissing(UserAchievementProjection::class, [
        'user_id' => 1,
        'slug' => '1000-experience',
    ]);
});
