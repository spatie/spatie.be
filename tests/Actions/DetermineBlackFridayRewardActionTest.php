<?php

use App\Actions\DetermineBlackFridayRewardAction;
use App\Enums\BlackFridayRewardType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->user = User::factory()->create();

    config()->set('black-friday.merch_discount_code', 'MERCH-DISCOUNT');
    config()->set('black-friday.next_purchase_discount_code', 'NEXT-PURCHASE-DISCOUNT');
});

it('will provide a random reward from the predefined pool if no codes or special prizes are available', function () {
    $users = User::factory()->count(10)->create();

    foreach ($users as $user) {
        $reward = app(DetermineBlackFridayRewardAction::class)->execute($user, 1);

        expect($reward->type)->toBeIn([
            BlackFridayRewardType::NextPurchaseDiscount,
        ]);

        expect($reward->code)->toBeIn(
            [ 'NEXT-PURCHASE-DISCOUNT']
        );

        assertDatabaseHas('bf24_redeemed_rewards', [
            'user_id' => $user->id,
            'day' => 1,
            'type' => $reward->type,
            'code' => $reward->code,
        ]);
    }
});

it('will provide the correct codes for non saas rewards', function () {
    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        User::factory()->create(),
        1,
        BlackFridayRewardType::NextPurchaseDiscount
    );

    expect($reward->code)->toBe('NEXT-PURCHASE-DISCOUNT');
});

it('will include a code when receiving a saas reward and then removes the code from the pool', function () {
    DB::table('bf24_codes_pool')->insert([
        'code' => 'test-code',
        'type' => BlackFridayRewardType::Mailcoach50Off,
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        $this->user,
        1,
        BlackFridayRewardType::Mailcoach50Off
    );

    expect($reward->type)->toBe(BlackFridayRewardType::Mailcoach50Off);
    expect($reward->code)->toEqual('test-code');

    assertDatabaseHas('bf24_redeemed_rewards', [
        'user_id' => $this->user->id,
        'day' => 1,
        'type' => $reward->type,
        'code' => 'test-code',
    ]);

    assertDatabaseCount('bf24_codes_pool', 0);
});

it('will use a non saas code reward when all saas codes are redeemed', function () {
    DB::table('bf24_codes_pool')->insert([
        'code' => 'test-code',
        'type' => BlackFridayRewardType::Mailcoach50Off,
    ]);

    app(DetermineBlackFridayRewardAction::class)->execute(
        $this->user,
        1,
        BlackFridayRewardType::Mailcoach50Off
    );

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        $anotherUser = User::factory()->create(),
        1,
        BlackFridayRewardType::Mailcoach50Off
    );

    expect($reward->type)->toBeIn([
        BlackFridayRewardType::NextPurchaseDiscount,
    ]);

    assertDatabaseHas('bf24_redeemed_rewards', [
        'user_id' => $this->user->id,
        'day' => 1,
        'type' => BlackFridayRewardType::Mailcoach50Off,
    ]);

    assertDatabaseHas('bf24_redeemed_rewards', [
        'user_id' => $anotherUser->id,
        'day' => 1,
        'type' => $reward->type,
    ]);
});

it('will always select a special reward when in range', function () {
    DB::table('bf24_rewards')->insert([
        'day' => 1,
        'type' => BlackFridayRewardType::FreeMerch,
        'available_at' => now()->subMinute(),
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        $this->user,
        1,
    );

    expect($reward->type)->toBe(BlackFridayRewardType::FreeMerch);

    assertDatabaseHas('bf24_redeemed_rewards', [
        'user_id' => $this->user->id,
        'day' => 1,
        'type' => BlackFridayRewardType::FreeMerch,
        'reward_id' => DB::table('bf24_rewards')->first()->id,
    ]);
});

it('will not select a special reward when already redeemed', function () {
    DB::table('bf24_rewards')->insert([
        'day' => 1,
        'type' => BlackFridayRewardType::FreeMerch,
        'available_at' => now()->subMinute(),
    ]);

    DB::table('bf24_redeemed_rewards')->insert([
        'user_id' => User::factory()->create()->id,
        'day' => 1,
        'type' => BlackFridayRewardType::FreeMerch,
        'reward_id' => DB::table('bf24_rewards')->first()->id,
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        $this->user,
        1,
    );

    expect($reward->type)->not()->toBe(BlackFridayRewardType::FreeMerch);

    assertDatabaseHas('bf24_redeemed_rewards', [
        'user_id' => $this->user->id,
        'day' => 1,
        'type' => $reward->type,
    ]);
});

it('will select one of the special rewards if multiple were still available', function () {
    DB::table('bf24_rewards')->insert([
        ['day' => 1, 'type' => BlackFridayRewardType::FreeMerch, 'available_at' => now()->subMinute()],
        ['day' => 1, 'type' => BlackFridayRewardType::FreeRay, 'available_at' => now()->subMinute()],
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        $this->user,
        1,
    );

    expect($reward->type)->toBeIn([
        BlackFridayRewardType::FreeMerch,
        BlackFridayRewardType::FreeRay,
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        User::factory()->create(),
        1,
    );

    expect($reward->type)->toBeIn([
        BlackFridayRewardType::FreeMerch,
        BlackFridayRewardType::FreeRay,
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        User::factory()->create(),
        1,
    );

    expect($reward->type)->not()->toBeIn([
        BlackFridayRewardType::FreeMerch,
        BlackFridayRewardType::FreeRay,
    ]);
});

it('will only select special rewards in range', function () {
    DB::table('bf24_rewards')->insert([
        'day' => 1,
        'type' => BlackFridayRewardType::FreeMerch,
        'available_at' => now()->addMinute(),
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        $this->user,
        1,
    );

    expect($reward->type)->not()->toBe(BlackFridayRewardType::FreeMerch);
});

it('will not select rewards in range within another day', function () {
    DB::table('bf24_rewards')->insert([
        'day' => 2,
        'type' => BlackFridayRewardType::FreeMerch,
        'available_at' => now()->subMinute(),
    ]);

    $reward = app(DetermineBlackFridayRewardAction::class)->execute(
        $this->user,
        1,
    );

    expect($reward->type)->not()->toBe(BlackFridayRewardType::FreeMerch);
});

it('is impossible to submit the same day twice', function () {
    $first = app(DetermineBlackFridayRewardAction::class)->execute($this->user, 1);

    $second = app(DetermineBlackFridayRewardAction::class)->execute($this->user, 1);

    expect($first->type)->toBe($second->type);
    expect($first->code)->toBe($second->code);

    assertDatabaseHas('bf24_redeemed_rewards', [
        'user_id' => $this->user->id,
        'day' => 1,
        'type' => $first->type,
        'code' => $first->code,
    ]);

    assertDatabaseCount('bf24_redeemed_rewards', 1);
});

it('is possible to get rewards for multiple days', function () {
    app(DetermineBlackFridayRewardAction::class)->execute($this->user, 1);
    app(DetermineBlackFridayRewardAction::class)->execute($this->user, 2);
    app(DetermineBlackFridayRewardAction::class)->execute($this->user, 3);
    app(DetermineBlackFridayRewardAction::class)->execute($this->user, 4);
    app(DetermineBlackFridayRewardAction::class)->execute($this->user, 5);

    assertDatabaseCount('bf24_redeemed_rewards', 5);
});
