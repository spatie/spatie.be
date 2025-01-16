<?php

namespace App\Livewire;

use App\Actions\DetermineBlackFridayRewardAction;
use App\Data\BlackFridayRewardData;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;

class TopSecretComponent extends Component
{
    #[Locked]
    public int $currentDay = 1;

    #[Locked]
    public array $days;

    public array $completedDays = [];

    #[Locked]
    public ?string $question = '';

    #[Locked]
    public ?string $hint = '';

    public string $answer = '';

    #[Locked]
    public ?BlackFridayRewardData $reward = null;

    public bool $showReward = false;

    public bool $showHint = false;

    public bool $showInput = false;

    public function mount(): void
    {
        $current = CarbonImmutable::parse(config('black-friday.start_date'));

        foreach (range(1, 5) as $day) {
            $this->days[$day] = $current;
            $current = $current->addDay();
        }

        $this->currentDay = collect($this->days)->search(function (CarbonInterface $date) {
            return now()->between($date->startOfDay(), $date->endOfDay());
        }) ?: 1;
    }

    public function setDay(int $currentDay): void
    {
        if (! isset($this->days[$currentDay])) {
            return;
        }

        if ($this->days[$currentDay]->isFuture()) {
            return;
        }

        $this->currentDay = $currentDay;
        $this->answer = '';
        $this->question = '';
        $this->showInput = false;
    }

    public function submitAnswer(): void
    {
        $questionRow = DB::table('bf24_questions')
            ->where('day', $this->currentDay)
            ->firstOrFail();

        if (strcasecmp($this->answer, $questionRow?->answer) !== 0) {
            $this->answer = '';
            $this->hint = $questionRow->hint;
            $this->showHint = true;

            return;
        }

        if ($this->days[$this->currentDay]->endOfDay()->isPast()) {
            $this->answer = 'This is the correct solution, but the time has run out.';

            return;
        }

        if ($this->days[$this->currentDay]->startOfDay()->isFuture()) {
            $this->answer = 'This is the correct solution, but this challenge is not yet open.';

            return;
        }

        $this->reward = app(DetermineBlackFridayRewardAction::class)->execute(
            Auth::user(),
            $this->currentDay
        );

        $this->showReward = true;
    }

    public function enterRaffle(): void
    {
        if ($this->days[$this->currentDay]->endOfDay()->isPast() || $this->days[$this->currentDay]->startOfDay()->isFuture()) {
            return;
        }

        if ($this->reward === null) {
            return;
        }

        DB::table('bf24_redeemed_rewards')
            ->where('user_id', Auth::id())
            ->where('day', $this->currentDay)
            ->update(['entered_raffle' => true]);
    }

    public function render(): View
    {
        $questionRow = DB::table('bf24_questions')
            ->where('day', $this->currentDay)
            ->first();

        $this->question = $questionRow?->question;

        $this->reward = Auth::user()
            ? BlackFridayRewardData::forUserAndDay(Auth::user(), $this->currentDay)
            : null;

        $this->completedDays = DB::table('bf24_redeemed_rewards')
            ->where('user_id', Auth::id())
            ->pluck('day')
            ->toArray();

        if ($this->reward || $this->days[$this->currentDay]->endOfDay()->isPast()) {
            $this->answer = $questionRow->answer;
        }

        return view('front.pages.top-secret.index')
            ->layout('layout.blank', [
                'title' => 'Top Secret',
                'bodyClass' => 'bg-bf-gray min-h-screen antialiased',
                'image' => '/backgrounds/bf-24-desk.jpg',
                'ogImage' => asset('/images/og-image-topsecret.jpg'),
            ]);
    }
}
