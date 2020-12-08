<?php

namespace Tests\Feature\HandleReferrer;

use App\Models\Purchasable;
use App\Models\Referrer;
use Illuminate\Support\Facades\Cookie;
use Spatie\TestTime\TestTime;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Tests\TestCase;

class HandleReferrerTest extends TestCase
{
    /** @test */
    public function it_can_handle_a_referrer()
    {
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

        $this->assertTrue($cookies->contains(function (SymfonyCookie $cookie) use ($referrer) {
            return $cookie->getName() === 'active-referrer-uuid' && $cookie->getValue() === $referrer->uuid;
        }));
    }

    /** @test */
    public function it_will_use_the_value_set_in_the_cookie()
    {
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
    }

    /** @test */
    public function it_will_register_the_click()
    {
        TestTime::freeze();

        $referrer = Referrer::factory()->create();

        $this->get(route('products.index') . "?referrer={$referrer->slug}");

        $referrer = $referrer->refresh();
        $this->assertEquals(1, $referrer->click_count);
        $this->assertEquals(now()->timestamp, $referrer->last_clicked_at->timestamp);

        TestTime::addSecond();
        $this->get(route('products.index') . "?referrer={$referrer->slug}");

        $referrer = $referrer->refresh();
        $this->assertEquals(2, $referrer->click_count);
        $this->assertEquals(now()->timestamp, $referrer->last_clicked_at->timestamp);
    }
}
