<?php

namespace Tests\Actions;

use App\Actions\RestoreRepositoryAccessAction;
use App\Models\License;
use App\Models\Purchase;
use App\Models\PurchaseAssignment;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Database\Factories\ReceiptFactory;
use Mockery\MockInterface;
use Tests\TestCase;

class RestoreRepositoryAccessActionTest extends TestCase
{
    private MockInterface $apiSpy;

    private RestoreRepositoryAccessAction $action;

    private User $user;

    private License $license;

    private Purchase $purchase;

    private PurchaseAssignment $assignment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiSpy = $this->spy(GitHubApi::class);
        $this->action = resolve(RestoreRepositoryAccessAction::class);

        $this->user = User::factory()->create([
            'github_username' => 'riasvdv',
        ]);

        $this->purchase = Purchase::factory()->create([
            'user_id' => $this->user->id,
            'receipt_id' => ReceiptFactory::new()->create()->id,
        ]);

        $this->assignment = PurchaseAssignment::factory()->create([
            'purchase_id' => $this->purchase->id,
            'user_id' => $this->user->id,
            'purchasable_id' => $this->purchase->getPurchasables()->first()->id,
        ]);

        $this->license = License::factory()->create([
            'purchase_assignment_id' => $this->assignment->id,
            'expires_at' => now()->addYear(),
        ]);
    }

    /** @test * */
    public function it_restores_repository_access_for_a_users_assignments()
    {
        $this->purchase->purchasable->update([
            'repository_access' => 'spatie/spatie.be',
        ]);

        $this->action->execute($this->user);

        $this->apiSpy->shouldHaveReceived('inviteToRepo', [
            'riasvdv',
            'spatie/spatie.be',
        ])->once();

        $this->assertTrue($this->assignment->fresh()->has_repository_access);
    }

    /** @test * */
    public function it_does_nothing_when_the_purchasable_has_no_repository()
    {
        $this->action->execute($this->user);

        $this->apiSpy->shouldNotHaveReceived('inviteToRepo');
        $this->assertFalse($this->assignment->fresh()->has_repository_access);
    }

    /** @test * */
    public function it_does_nothing_when_the_license_is_expired()
    {
        $this->purchase->purchasable->update([
            'repository_access' => 'spatie/spatie.be',
            'requires_license' => true,
        ]);

        $this->license->update(['expires_at' => now()->subDay()]);

        $this->action->execute($this->user);

        $this->apiSpy->shouldNotHaveReceived('inviteToRepo');
        $this->assertFalse($this->assignment->fresh()->has_repository_access);
    }
}
