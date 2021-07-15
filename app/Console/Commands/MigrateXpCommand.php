<?php

namespace App\Console\Commands;

use App\Domain\Experience\Commands\RegisterVideoCompletion;
use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Cache;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MigrateXpCommand extends Command
{
    protected $signature = 'xp:migrate {--user=}';

    public function handle()
    {
        $query = User::query()
            ->with(['completedVideos', 'experience'])
            ->where('xp_migrated', 0);

        if ($userId = $this->option('user')) {
            $query->where('id', $userId);
        }

        $query->get()->each(fn (User $user) => $this->migrateUser($user));
    }

    private function migrateUser(User $user): void
    {
        if (! $user->completedVideos) {
            $this->markMigrated($user);

            return;
        }

        // Only register completions before deploy
        $videos = $user->completedVideos
            ->reject(fn (Video $video) => $video->created_at >= Carbon::make('2021-07-15 09:00:00'));

        if ($videos->isEmpty()) {
            $this->markMigrated($user);

            return;
        }

        $this->comment("Migrating {$videos->count()} videos for user {$user->id}");

        $videos->each(function (Video $video) use ($user) {
            command(RegisterVideoCompletion::forUser($user, $video->id));
        });

        $this->markMigrated($user);
    }

    private function markMigrated(User $user): void
    {
        $user->update([
            'xp_migrated' => 1,
        ]);
    }
}
