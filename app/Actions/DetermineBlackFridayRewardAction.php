<?php

namespace App\Actions;

use App\Data\BlackFridayRewardData;
use App\Enums\BlackFridayRewardType;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DetermineBlackFridayRewardAction
{
    public function execute(
        User $user,
        int $day,
        ?BlackFridayRewardType $predefinedRewardType = null,
    ): BlackFridayRewardData {
        $redeemedReward = BlackFridayRewardData::forUserAndDay($user, $day);

        if ($redeemedReward) {
            return $redeemedReward;
        }

        /** @var Collection<int, object{id: int, type: string}> $specialRewards */
        $specialRewards = DB::table('bf24_rewards')
            ->where('available_at', '<=', now())
            ->where('day', $day)
            ->whereNotExists(fn (Builder $query) => $query
                ->select(DB::raw(1))
                ->from('bf24_redeemed_rewards')
                ->whereColumn('bf24_rewards.id', 'bf24_redeemed_rewards.reward_id'))
            ->get();

        if ($specialRewards->isNotEmpty()) {
            $reward = $specialRewards->random();

            return $this->redeemReward(
                $user,
                $day,
                BlackFridayRewardType::from($reward->type),
                rewardId: $reward->id
            );
        }

        $rewardTypes = [
            BlackFridayRewardType::Flare50Off,
            BlackFridayRewardType::Mailcoach50Off,
            BlackFridayRewardType::NextPurchaseDiscount,
        ];

        /** @var BlackFridayRewardType $rewardType */
        $rewardType = $predefinedRewardType ?? Arr::random($rewardTypes);

        if (! $rewardType->requiresSaasCode()) {
            return $this->redeemNonSaasCodeReward($user, $day, $rewardType);
        }

        $code = $this->getSaasCode($rewardType);

        if ($code) {
            return $this->redeemReward($user, $day, $rewardType, code: $code);
        }

        return $this->redeemNonSaasCodeReward(
            $user,
            $day,
            Arr::random([BlackFridayRewardType::NextPurchaseDiscount])
        );
    }

    protected function redeemReward(
        User $user,
        int $day,
        BlackFridayRewardType $rewardType,
        ?int $rewardId = null,
        ?string $code = null
    ): BlackFridayRewardData {
        DB::table('bf24_redeemed_rewards')->insert([
            'user_id' => $user->id,
            'day' => $day,
            'type' => $rewardType,
            'reward_id' => $rewardId,
            'code' => $code,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return new BlackFridayRewardData(type: $rewardType, code: $code);
    }

    protected function redeemNonSaasCodeReward(
        User $user,
        int $day,
        BlackFridayRewardType $rewardType,
    ): BlackFridayRewardData {
        $code = match ($rewardType) {
            BlackFridayRewardType::NextPurchaseDiscount => config('black-friday.next_purchase_discount_code'),
            default => throw new \Exception('Invalid reward type'),
        };

        return $this->redeemReward($user, $day, $rewardType, code: $code);
    }

    protected function getSaasCode(BlackFridayRewardType $rewardType): ?string
    {
        $code = DB::table('bf24_codes_pool')
            ->select('id', 'code')
            ->where('type', $rewardType)
            ->first();

        if ($code === null) {
            return null;
        }

        DB::table('bf24_codes_pool')
            ->where('id', $code->id)
            ->delete();

        return $code->code;
    }
}
