<?php

namespace Tests\Actions;

use App\Actions\CreateLicenseAction;
use App\Models\Purchasable;
use App\Models\User;
use Tests\TestCase;

class CreateLicenseActionTest extends TestCase
{
    private CreateLicenseAction $action;

    protected function setUp() : void
    {
        parent::setUp();

        $this->action = resolve(CreateLicenseAction::class);
    }

    /** @test */
    public function it_can_create_a_license()
    {
        $user = factory(User::class)->create();
        $purchasable = factory(Purchasable::class)->create();

        $license = $this->action->execute($user, $purchasable);

        $this->assertNotNull($license->key);
        $this->assertTrue($license->expires_at->isNextYear());
        $this->assertTrue($license->user->is($user));
        $this->assertTrue($license->purchasable->is($purchasable));
    }
}
