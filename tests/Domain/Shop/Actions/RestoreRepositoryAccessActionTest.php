<?php

use App\Domain\Shop\Actions\RestoreRepositoryAccessAction;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Database\Factories\ReceiptFactory;
use Mockery\MockInterface;
use Tests\TestCase;

uses(TestCase::class);
use function now;
use function resolve;

beforeEach(function () {
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
});

it('restores repository access for a users assignments', function () {
    $this->purchase->purchasable->update([
        'repository_access' => 'spatie/spatie.be',
    ]);

    $this->action->execute($this->user);

    $this->apiSpy->shouldHaveReceived('inviteToRepo', [
        'riasvdv',
        'spatie/spatie.be',
    ])->once();

    expect($this->assignment->fresh()->has_repository_access)->toBeTrue();
});

it('does nothing when the purchasable has no repository', function () {
    $this->action->execute($this->user);

    $this->apiSpy->shouldNotHaveReceived('inviteToRepo');
    expect($this->assignment->fresh()->has_repository_access)->toBeFalse();
});

it('does nothing when the license is expired', function () {
    $this->purchase->purchasable->update([
        'repository_access' => 'spatie/spatie.be',
        'requires_license' => true,
    ]);

    $this->license->update(['expires_at' => now()->subDay()]);

    $this->action->execute($this->user);

    $this->apiSpy->shouldNotHaveReceived('inviteToRepo');
    expect($this->assignment->fresh()->has_repository_access)->toBeFalse();
});
