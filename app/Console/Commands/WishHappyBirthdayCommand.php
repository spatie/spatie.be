<?php

namespace App\Console\Commands;

use App\ValueObjects\TeamMember;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\SlackAlerts\Facades\SlackAlert;

class WishHappyBirthdayCommand extends Command
{
    protected $signature = 'spatie:happy-birthday';

    protected int $ageFilter = 40;

    protected string $message = 'Congratulations %s on your %dth birthday! 🥳';

    protected string $filteredMessage = 'Congratulations %s! 🥳';

    public function handle(): void
    {
        $celebrators = $this->whoIsCelebratingToday();

        if ($celebrators->isEmpty()) {
            $this->info('No cake today!');

            return;
        }

        $celebrators->each(fn (TeamMember $member) => $this->sendWishesTo($member));
    }

    private function whoIsCelebratingToday(): Collection
    {
        return collect(config('team.members'))
            ->map(fn (array $member) => TeamMember::make($member))
            ->filter(fn (TeamMember $member) => $member->isBirthday());
    }

    private function sendWishesTo(TeamMember $member): void
    {
        $message = $this->ageFilter < $member->age() ? $this->filteredMessage : $this->message;
        $message = sprintf($message, $member->name(), $member->age());

        SlackAlert::message($message);

        $this->info($message);

    }
}
