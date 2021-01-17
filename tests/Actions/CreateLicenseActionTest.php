<?php

namespace Tests\Actions;

use App\Actions\CreateLicenseAction;
use App\Models\Purchase;
use App\Models\User;
use Tests\TestCase;

class CreateLicenseActionTest extends TestCase
{
    protected CreateLicenseAction $action;

    protected function setUp() : void
    {
        parent::setUp();

        $this->action = resolve(CreateLicenseAction::class);
    }

    /** @test */
    public function it_can_create_a_license()
    {
        $user = User::factory()->create();
        $purchase = Purchase::factory()->create();

        $license = $this->action->execute($user, $purchase);

        $this->assertNotNull($license->key);
        $this->assertTrue($license->expires_at->isNextYear());
        $this->assertTrue($license->user->is($user));
        $this->assertTrue($license->purchase->is($purchase));
    }
}
