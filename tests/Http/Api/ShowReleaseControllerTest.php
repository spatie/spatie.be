<?php

namespace Tests\Http\Api;

use App\Models\Release;
use Tests\TestCase;

class ShowReleaseControllerTest extends TestCase
{
    private Release $release;

    public function setUp(): void
    {
        parent::setUp();

        $this->release = Release::factory()->create([
            'released' => true,
            'notes' => '## Version 0.0.1',
            'version' => '0.0.1',
        ]);
    }

    /** @test */
    public function it_can_show_release_notes_for_a_released_release()
    {
        $response = $this
            ->get("/api/releases/{$this->release->product->id}/0.0.1")
            ->assertSuccessful()
            ->json();

        $this->assertEquals('<h2>Version 0.0.1</h2>' . PHP_EOL, $response['notes']);
    }

    /** @test */
    public function it_will_return_404_when_requesting_a_non_existent_version()
    {
        $this
            ->get("/api/releases/{$this->release->product->id}/0.0.2")
            ->assertNotFound();
    }

    /** @test */
    public function it_will_return_404_when_requesting_a_non_released_version()
    {
        $this->release->update(['released' => false]);

        $this
            ->get("/api/releases/{$this->release->product->id}/0.0.1")
            ->assertNotFound();
    }

    /** @test */
    public function it_will_automatically_generated_a_html_version_of_the_notes()
    {
        $this->release->update(['notes' => '## Title']);

        $this->assertEquals('<h2>Title</h2>' . PHP_EOL, $this->release->refresh()->notes_html);
    }
}
