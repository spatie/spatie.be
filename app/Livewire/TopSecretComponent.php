<?php

namespace App\Livewire;

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

    public string $question = '';

    public string $answer = '';

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

        // TODO: Reward
    }

    public function render(): View
    {
        $this->question = DB::table('bf24_questions')
            ->where('day', $this->currentDay)
            ->first()
            ?->question;

        return view('front.pages.top-secret.index')
            ->layout('layout.blank', [
                'title' => 'Top Secret',
                'bodyClass' => 'bg-bf-dark-gray min-h-screen antialiased',
                'background' => '/backgrounds/bf-24-desk.jpg',
            ]);
    }
}
