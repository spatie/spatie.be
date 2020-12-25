<?php

namespace Tests\Http;

use App\Models\Release;
use Tests\TestCase;

class ShowReleasesControllerTest extends TestCase
{
    /** @test */
    public function it_can_show_the_release_notes_of_a_product()
    {
        $release = Release::factory()->create();

        $this
            ->get(route('product.releaseNotes', $release->product))
            ->assertSuccessful()
            ->assertSee($release->version);
    }
}
