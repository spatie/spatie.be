<?php

namespace Database\Seeders;

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\ExperienceAggregateRoot;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\License;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use App\Support\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UserSeeder extends Seeder
{
    private Collection|array $achievements;

    public function run(): void
    {
        $this->achievements = Achievement::all();

        collect(config('team.members'))->map(fn (string $name) => User::create([
            'name' => ucfirst($name),
            'email' => "${name}@spatie.be",
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]))->each(function (User $user): void {
            $randomPurchasables = Purchasable::query()->inRandomOrder()->take(random_int(0, 5))->get();

            $this->createPurchases($user, $randomPurchasables);

            $this->addPullRequests($user);

            $this->createAchievements($user);
        });
    }

    protected function createPurchases(User $user, Collection $randomPurchasables): void
    {
        $randomPurchasables->each(function (Purchasable $purchase) use ($user): void {
            if ($purchase->requires_license) {
                License::factory()->create([
                    'purchasable_id' => $purchase->id,
                    'user_id' => $user->id,
                ]);
            }

            Purchase::factory()->create([
                'user_id' => $user->id,
                'purchasable_id' => $purchase->id,
                'paddle_fee' => 0,
                'earnings' => 0,
                'quantity' => 1,
                'has_repository_access' => false,
            ]);
        });
    }

    protected function addPullRequests(User $user)
    {
        foreach (range(1, random_int(5, 10)) as $i) {
            command(RegisterPullRequest::forUser($user, "PR #{$i}"));
        }
    }

    protected function createAchievements(User $user)
    {
        // We're manually creating projections here, just to have some dummy data that we can style
        $this->achievements
            ->random(random_int(1, $this->achievements->count()))
            ->each(function (Achievement $achievement) use ($user) {
                UserAchievementProjection::new()->writeable()->create([
                    'uuid' => Uuid::new(),
                    'achievement_id' => $achievement->id,
                    'user_id' => $user->id,
                    'slug' => $achievement->slug,
                    'description' => $achievement->description,
                    'title' => $achievement->title,
                ]);
            });
    }
}
