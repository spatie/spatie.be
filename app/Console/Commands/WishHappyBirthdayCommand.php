<?php

namespace App\Console\Commands;

use App\Models\Member;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\SlackAlerts\Facades\SlackAlert;

class WishHappyBirthdayCommand extends Command
{
    protected $signature = 'spatie:happy-birthday';

    protected int $ageFilter = 39;

    protected string $message = 'Congratulations %s on your %dth birthday! 🥳';

    protected string $filteredMessage = 'Congratulations %s! 🥳';

    public function handle(): void
    {
        $celebrators = $this->whoIsCelebratingToday();

        if ($celebrators->isEmpty()) {
            $this->info('No cake today!');

            return;
        }

        $celebrators->each(fn (Member $member) => $this->sendWishesTo($member));
    }

    private function whoIsCelebratingToday(): Collection
    {
        return Member::query()
            ->whereDay('birthday', CarbonImmutable::today()->day)
            ->whereMonth('birthday', CarbonImmutable::today()->month)
            ->get();
    }

    private function sendWishesTo(Member $member): void
    {
        $message = $this->ageFilter < $member->birthday?->age ? $this->filteredMessage : $this->message;
        $message = sprintf($message, $member->name(), $member->birthday?->age);

        SlackAlert::message($message);

        $this->info($message);
    }
}
