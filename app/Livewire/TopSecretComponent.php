<?php

namespace App\Livewire;

use Arr;
use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;

class TopSecretComponent extends Component
{
    #[Locked]
    public int $currentDay = 1;

    #[Locked]
    public array $days;

    public ?string $question = '';

    public string $answer = '';

    public ?string $reward = '';

    public function mount(): void
    {
        $this->days = [
            1 => Date::create(2024, 11, 25),
            2 => Date::create(2024, 11, 26),
            3 => Date::create(2024, 11, 27),
            4 => Date::create(2024, 11, 28),
            5 => Date::create(2024, 11, 29),
        ];

        $this->currentDay = collect($this->days)->search(function (CarbonInterface $date) {
            return now()->between($date->startOfDay(), $date->endOfDay());
        }) ?: 1;
    }

    public function setDay(int $currentDay): void
    {
        if (! isset($this->days[$currentDay])) {
            return;
        }

        /*if ($this->days[$day]->isFuture()) {
            return;
        }*/

        $this->currentDay = $currentDay;
    }

    public function submitAnswer(): void
    {
        $answer = DB::table('bf24_questions')
            ->where('day', $this->currentDay)
            ->first()
            ?->answer;

        if ($this->answer !== $answer) {
            $this->answer = 'This is the wrong solution.';

            return;
        }

        Auth::user()->flag("bf-day-{$this->currentDay}");

        /**
         * 20% discount on your next purchase on spatie.be
         * 30% discount on merchandise on our Merch Store
         * 50% off on Mailcoach and Flare plans
         * Free Spatie merchandise
         * Free yearly licenses for Ray
         */

        $reward = Arr::random([
            'next_purchase_discount',
            'merch_discount',
            '50_off_mailcoach',
            '50_off_flare',
            'free_merch', // 10 / day
            'free_ray', // x / day
        ]);

        DB::table('bf24_rewards')->insert([
            'user_id' => Auth::user()->id,
            'day' => $this->currentDay,
            'reward' => $reward,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // TODO: Actual rewards
    }

    public function render(): View
    {
        $this->question = DB::table('bf24_questions')
            ->where('day', $this->currentDay)
            ->first()
            ?->question;

        $this->reward = DB::table('bf24_rewards')
            ->where('day', $this->currentDay)
            ->where('user_id', Auth::user()->id ?? null)
            ->first()
            ?->reward;

        return view('front.pages.top-secret.index')
            ->layout('layout.blank', [
                'title' => 'Top Secret',
                'bodyClass' => 'bg-bf-dark-gray min-h-screen overflow-hidden antialiased',
                'background' => '/backgrounds/bf-24-desk.jpg',
            ]);
    }
}
