<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;

class TopSecretComponent extends Component
{
    #[Locked]
    public int $day = 1;

    public string $question = '';

    public string $answer = '';

    public bool $incorrect = false;

    public function mount(): void
    {
        $this->day = match(true) {
            now() > Date::create(2024, 11, 29) => 5,
            now() > Date::create(2024, 11, 28) => 4,
            now() > Date::create(2024, 11, 27) => 3,
            now() > Date::create(2024, 11, 26) => 2,
            now() > Date::create(2024, 11, 25) => 1,
            default => 1,
        };

        $this->question = DB::table('bf24_questions')
            ->where('day', $this->day)
            ->first()
            ?->question;
    }

    public function submitAnswer(): void
    {
        $this->incorrect = false;

        $answer = DB::table('bf24_questions')
            ->where('day', $this->day)
            ->first()
            ?->answer;

        if ($this->answer !== $answer) {
            $this->incorrect = true;

            return;
        }

        // TODO: Reward
    }

    public function render(): View
    {
        return view('front.pages.top-secret.index')
            ->layout('layout.blank', [
                'title' => 'Top Secret',
                'bodyClass' => 'bg-bf-dark-gray min-h-screen antialiased',
                'background' => '/backgrounds/bf-24-desk.jpg',
            ]);
    }
}
