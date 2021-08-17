<?php

namespace Tests\Domain\Shop\Actions;

use App\Domain\Shop\Actions\CreateLicenseAction;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchaseAssignment;
use Tests\TestCase;
use function resolve;

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
        $assignment = PurchaseAssignment::factory()->create();

        $license = $this->action->execute($assignment);

        $this->assertNotNull($license->key);
        $this->assertTrue($license->expires_at->isNextYear());
        $this->assertTrue($license->assignment->is($assignment));
    }

    /** @test */
    public function it_can_create_a_license_for_lifetime_purchases()
    {
        $assignment = PurchaseAssignment::factory()->create([
            'purchasable_id' => Purchasable::factory()->create([
                'is_lifetime' => true,
            ])->id,
        ]);

        $license = $this->action->execute($assignment);

        $this->assertNotNull($license->key);
        $this->assertSame(2038, $license->expires_at->year);
    }
}
