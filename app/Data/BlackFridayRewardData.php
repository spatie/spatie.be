<?php

namespace App\Data;

use App\Enums\BlackFridayRewardType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Wireable;

class BlackFridayRewardData implements Wireable
{
    public function __construct(
        public BlackFridayRewardType $type,
        public ?string $code = null,
        public bool $enteredRaffle = false,
    ) {
    }

    public static function forUserAndDay(User $user, int $day): ?self
    {
        $redeem = DB::table('bf24_redeemed_rewards')
            ->where('user_id', $user->id)
            ->where('day', $day)
            ->first();

        if (! $redeem) {
            return null;
        }

        return new BlackFridayRewardData(
            type: BlackFridayRewardType::from($redeem->type),
            code: $redeem->code,
            enteredRaffle: $redeem->entered_raffle,
        );
    }

    public function toLivewire(): array
    {
        return [
            'type' => $this->type->value,
            'code' => $this->code,
            'enteredRaffle' => $this->enteredRaffle,
        ];
    }

    public static function fromLivewire($value): self
    {
        return new BlackFridayRewardData(
            type: BlackFridayRewardType::from($value['type']),
            code: $value['code'],
            enteredRaffle: $value['enteredRaffle'],
        );
    }
}
