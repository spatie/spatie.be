<?php

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Referrer;
use Illuminate\Support\Facades\Cookie;
use Spatie\TestTime\TestTime;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

it('can handle a referrer', function () {
    $purchasable = Purchasable::factory()->create();

    /** @var Referrer $referrer */
    $referrer = Referrer::factory()->create([
        'discount_percentage' => 23,
    ]);

    $this
        ->get(route('products.index') . "?referrer={$referrer->slug}")
        ->assertDontSee('-23%');

    $referrer->purchasables()->attach($purchasable);

    $this
        ->get(route('products.index') . "?referrer={$referrer->slug}")
        ->assertSee('-23%');

    $this
        ->get(route('products.show', $purchasable->product) . "?referrer={$referrer->slug}")
        ->assertSee('23%');

    $cookies = collect(Cookie::getQueuedCookies());

    expect($cookies->contains(function (SymfonyCookie $cookie) use ($referrer) {
        return $cookie->getName() === 'active-referrer-uuid' && $cookie->getValue() === $referrer->uuid;
    }))->toBeTrue();
});

it('will use the value set in the cookie', function () {
    $purchasable = Purchasable::factory()->create();

    /** @var Referrer $referrer */
    $referrer = Referrer::factory()->create([
        'discount_percentage' => 23,
    ]);

    $referrer->purchasables()->attach($purchasable);

    $this
        ->withCookie('active-referrer-uuid', $referrer->uuid)
        ->get(route('products.index'))
        ->assertSee('-23%');
});

it('will register the click', function () {
    TestTime::freeze();

    $referrer = Referrer::factory()->create();

    $this->get(route('products.index') . "?referrer={$referrer->slug}");

    $referrer = $referrer->refresh();
    expect($referrer->click_count)->toEqual(1);
    expect($referrer->last_clicked_at->timestamp)->toEqual(now()->timestamp);

    TestTime::addSecond();
    $this->get(route('products.index') . "?referrer={$referrer->slug}");

    $referrer = $referrer->refresh();
    expect($referrer->click_count)->toEqual(2);
    expect($referrer->last_clicked_at->timestamp)->toEqual(now()->timestamp);
});
