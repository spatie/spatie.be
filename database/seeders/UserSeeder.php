<?php

namespace Database\Seeders;

use App\Domain\Experience\Commands\RegisterPullRequest;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\Member;
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

        collect(Member::get())->pluck('name')->map(fn (string $name) => User::firstOrCreate([
            'email' => "${name}@spatie.be",
        ], [
            'name' => ucfirst($name),
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
        $randomPurchasables->each(function (Purchasable $purchasable) use ($user): void {
            $purchase = Purchase::factory()->create([
                'user_id' => $user->id,
                'purchasable_id' => $purchasable->id,
                'paddle_fee' => 0,
                'earnings' => 0,
                'quantity' => 1,
            ]);

            $assignment = PurchaseAssignment::create([
                'purchasable_id' => $purchasable->id,
                'user_id' => $user->id,
                'purchase_id' => $purchase->id,
                'has_repository_access' => false,
            ]);

            if ($purchasable->requires_license) {
                License::factory()->create([
                    'purchase_assignment_id' => $assignment->id,
                ]);
            }
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
