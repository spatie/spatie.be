<?php

namespace Tests\Http\Api;

use App\Domain\Shop\Models\License;
use Tests\TestCase;

class ShowLicenseControllerTest extends TestCase
{
    /** @test */
    public function it_can_show_a_license()
    {
        $license = License::factory()->create();

        $this
            ->get("/api/license/{$license->key}")
            ->assertJsonFragment([
                'expires_at' => $license->expires_at->timestamp,
            ]);
    }

    /** @test */
    public function it_will_return_404_for_a_non_existing_license()
    {
        $this
            ->get("/api/license/non-existing-key")
            ->assertNotFound();
    }
}
