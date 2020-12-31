<?php

namespace Tests\Feature\Api;

use App\Http\Api\Controllers\Activations\UpdateCurrentVersionController;
use App\Models\Activation;
use Tests\TestCase;

class UpdateCurrentVersionControllerTest extends TestCase
{
    /** @test */
    public function it_can_update_the_current_version()
    {
        $activation = Activation::factory()->create();
        $versionNumber = '1.2.3';

        $this
            ->post(action(UpdateCurrentVersionController::class, $activation->uuid), [
                'current_version' => $versionNumber,
            ])
            ->assertSuccessful();

        $this->assertEquals($versionNumber, $activation->refresh()->current_version);
    }
}
