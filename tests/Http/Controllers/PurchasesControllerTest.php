<?php

use App\Domain\Shop\Enums\PurchasableType;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\Series;
use App\Models\User;
use App\Services\Mailcoach\MailcoachApi;
use Database\Factories\ReceiptFactory;
use Illuminate\Support\Str;

function createPurchasesPagePurchasable(
    string $productTitle,
    string $purchasableTitle,
    string $type = PurchasableType::TYPE_UNLIMITED_DOMAINS,
): Purchasable {
    $product = Product::factory()->create([
        'title' => $productTitle,
        'slug' => Str::slug($productTitle),
        'maximum_activation_count' => 1,
    ]);

    return Purchasable::factory()->create([
        'product_id' => $product->id,
        'title' => $purchasableTitle,
        'type' => $type,
    ]);
}

function createPurchasesPagePurchase(User $buyer, Purchasable $purchasable, string $receiptUrl = 'https://example.com/receipt'): Purchase
{
    $receipt = ReceiptFactory::new()
        ->for($buyer, 'billable')
        ->create(['receipt_url' => $receiptUrl]);

    return Purchase::factory()->create([
        'user_id' => $buyer->id,
        'purchasable_id' => $purchasable->id,
        'receipt_id' => $receipt->id,
    ]);
}

function assignPurchasesPagePurchase(Purchase $purchase, Purchasable $purchasable, User $user): PurchaseAssignment
{
    return PurchaseAssignment::factory()->create([
        'purchase_id' => $purchase->id,
        'purchasable_id' => $purchasable->id,
        'user_id' => $user->id,
    ]);
}

it('shows a self-assigned application as usable access only', function () {
    $user = User::factory()->create();
    $purchasable = createPurchasesPagePurchasable('Ray', 'Ray license');
    $purchase = createPurchasesPagePurchase($user, $purchasable);
    $assignment = assignPurchasesPagePurchase($purchase, $purchasable, $user);
    License::factory()->create(['purchase_assignment_id' => $assignment->id]);

    $this
        ->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertSee('Applications')
        ->assertSee('Ray')
        ->assertSee('Bought by you')
        ->assertDontSee('Assigned to others');
});

it('shows externally bought access assigned to the user with purchaser context', function () {
    $user = User::factory()->create();
    $buyer = User::factory()->create(['email' => 'external-buyer@example.com']);
    $purchasable = createPurchasesPagePurchasable('Mailcoach', 'Only the videos', PurchasableType::TYPE_VIDEOS);
    $series = Series::factory()->create(['title' => 'Mailcoach videos']);
    $purchasable->series()->attach($series);
    $purchase = createPurchasesPagePurchase($buyer, $purchasable);
    assignPurchasesPagePurchase($purchase, $purchasable, $user);

    $this
        ->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertSee('Courses')
        ->assertSee('Mailcoach')
        ->assertSee('Assigned by external-buyer@example.com')
        ->assertDontSee('Assigned to others');
});

it('shows user-owned purchases assigned to another user separately from usable access', function () {
    $user = User::factory()->create();
    $recipient = User::factory()->create(['email' => 'recipient@example.com']);
    $purchasable = createPurchasesPagePurchasable('Mailcoach', 'Single domain');
    $purchase = createPurchasesPagePurchase($user, $purchasable, 'https://example.com/mailcoach-receipt');
    assignPurchasesPagePurchase($purchase, $purchasable, $recipient);

    $this
        ->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertDontSee('Applications')
        ->assertSee('Assigned to others')
        ->assertSee('Mailcoach')
        ->assertSee('Single domain')
        ->assertSee('recipient@example.com')
        ->assertSee('Download receipt');
});

it('shows mixed multi-seat purchases as usable access and lists the other recipient', function () {
    $user = User::factory()->create(['email' => 'buyer@example.com']);
    $recipient = User::factory()->create(['email' => 'recipient@example.com']);
    $purchasable = createPurchasesPagePurchasable('Mailcoach', 'Unlimited domains');
    $purchase = createPurchasesPagePurchase($user, $purchasable);
    $userAssignment = assignPurchasesPagePurchase($purchase, $purchasable, $user);
    assignPurchasesPagePurchase($purchase, $purchasable, $recipient);
    License::factory()->create(['purchase_assignment_id' => $userAssignment->id]);

    $this
        ->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertSee('Applications')
        ->assertSee('Bought by you')
        ->assertSee('Assigned to others')
        ->assertSee('recipient@example.com');
});

it('distinguishes between no purchases and purchases that are only assigned away', function () {
    $user = User::factory()->create();

    $this
        ->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertSee('No purchases yet');

    $recipient = User::factory()->create(['email' => 'recipient@example.com']);
    $purchasable = createPurchasesPagePurchasable('Mailcoach', 'Single domain');
    $purchase = createPurchasesPagePurchase($user, $purchasable);
    assignPurchasesPagePurchase($purchase, $purchasable, $recipient);

    $this
        ->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertDontSee('No purchases yet')
        ->assertSee('Your purchases are assigned to other accounts')
        ->assertSee('Assigned to others');
});

it('keeps renewal guidance on products with expired repository licenses', function (?string $gitHubUsername, bool $hadRepositoryAccess) {
    $user = User::factory()->create(['github_username' => $gitHubUsername]);
    $purchasable = createPurchasesPagePurchasable('Media Library Pro', 'One application');
    $purchasable->update([
        'repository_access' => 'spatie/laravel-medialibrary-pro',
        'requires_license' => true,
    ]);
    $purchase = createPurchasesPagePurchase($user, $purchasable);
    $assignment = assignPurchasesPagePurchase($purchase, $purchasable, $user);
    $assignment->update(['has_repository_access' => $hadRepositoryAccess]);
    License::factory()->create([
        'purchase_assignment_id' => $assignment->id,
        'expires_at' => now()->subDay(),
    ]);

    $this->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertSee('Renew your license to restore GitHub repository access.')
        ->assertDontSee('GitHub repositories')
        ->assertDontSee('https://github.com/spatie/laravel-medialibrary-pro');
})->with([
    [null, false],
    [null, true],
    ['connected-user', false],
    ['connected-user', true],
]);

it('offers reconnection on purchases and profile after disconnecting a GitHub account', function () {
    $user = User::factory()->create(['github_id' => '12345', 'github_username' => 'connected-user']);
    $purchasable = createPurchasesPagePurchasable('Mailcoach', 'Single domain');
    $purchasable->update([
        'repository_access' => 'spatie/laravel-mailcoach',
        'requires_license' => true,
    ]);
    $purchase = createPurchasesPagePurchase($user, $purchasable);
    $assignment = assignPurchasesPagePurchase($purchase, $purchasable, $user);
    $assignment->update(['has_repository_access' => true]);
    License::factory()->create(['purchase_assignment_id' => $assignment->id]);
    $this->mock(MailcoachApi::class)->shouldReceive('getSubscriber')->with($user->email)->andReturnNull();

    $this->actingAs($user)
        ->get(route('github-disconnect'))
        ->assertRedirect(route('profile'));

    expect($user->fresh())->github_id->toBeNull()->github_username->toBeNull();

    $this->get(route('purchases'))
        ->assertOk()
        ->assertSee('Connect to GitHub')
        ->assertSee('https://github.com/spatie/laravel-mailcoach')
        ->assertDontSee('Connected as connected-user');

    $this->get(route('profile'))
        ->assertOk()
        ->assertSee('Connect to GitHub')
        ->assertSee(route('github-login'))
        ->assertDontSee('Disconnect from GitHub');
});

it('shows account-wide GitHub actions and secure two-factor guidance once for multiple products', function (?string $gitHubUsername, bool $hadRepositoryAccess, string $message) {
    $user = User::factory()->create(['github_username' => $gitHubUsername]);
    $purchasable = createPurchasesPagePurchasable('Media Library Pro', 'One application');
    $purchasable->update([
        'repository_access' => 'spatie/laravel-medialibrary-pro',
        'requires_license' => true,
    ]);
    $purchase = createPurchasesPagePurchase($user, $purchasable);
    $assignment = assignPurchasesPagePurchase($purchase, $purchasable, $user);
    $assignment->update(['has_repository_access' => $hadRepositoryAccess]);
    License::factory()->create([
        'purchase_assignment_id' => $assignment->id,
        'expires_at' => now()->addYear(),
    ]);
    $secondPurchasable = createPurchasesPagePurchasable('Mailcoach', 'Single domain');
    $secondPurchasable->update(['repository_access' => 'spatie/laravel-mailcoach']);
    $secondPurchase = createPurchasesPagePurchase($user, $secondPurchasable, 'https://example.com/mailcoach-receipt');
    $secondAssignment = assignPurchasesPagePurchase($secondPurchase, $secondPurchasable, $user);
    License::factory()->create(['purchase_assignment_id' => $secondAssignment->id]);

    $response = $this->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertSee($message)
        ->assertSeeInOrder(['GitHub account', 'Applications'])
        ->assertSee('Accept any pending GitHub repository invitations to activate access.')
        ->assertSee('remove SMS authentication')
        ->assertSee('GitHub security settings')
        ->assertSee('https://github.com/spatie/laravel-medialibrary-pro')
        ->assertSee('https://github.com/spatie/laravel-mailcoach')
        ->assertDontSee('Renew your license to restore GitHub repository access.');

    $gitHubLoginUrl = route('github-login');
    expect(substr_count($response->getContent(), "href=\"{$gitHubLoginUrl}\""))->toBe(1);
    expect(substr_count($response->getContent(), 'remove SMS authentication'))->toBe(1);

    if ($gitHubUsername) {
        $response->assertSeeText("Connected as {$gitHubUsername}");
    }
})->with([
    [null, false, 'Connect to GitHub'],
    ['connected-user', false, 'Retry repository access'],
    ['connected-user', true, 'Retry repository access'],
]);

it('uses an eligible older assignment when the newest assignment has expired', function (bool $hasRepositoryAccess) {
    $user = User::factory()->create(['github_username' => 'connected-user']);
    $purchasable = createPurchasesPagePurchasable('Media Library Pro', 'One application');
    $purchasable->update([
        'repository_access' => 'spatie/laravel-medialibrary-pro',
        'requires_license' => true,
    ]);
    $purchase = createPurchasesPagePurchase($user, $purchasable);
    $activeAssignment = assignPurchasesPagePurchase($purchase, $purchasable, $user);
    $activeAssignment->update(['has_repository_access' => $hasRepositoryAccess, 'created_at' => now()->subYear()]);
    License::factory()->create(['purchase_assignment_id' => $activeAssignment->id]);
    $expiredAssignment = assignPurchasesPagePurchase($purchase, $purchasable, $user);
    $expiredAssignment->update(['has_repository_access' => ! $hasRepositoryAccess]);
    License::factory()->create([
        'purchase_assignment_id' => $expiredAssignment->id,
        'expires_at' => now()->subDay(),
    ]);

    $this->actingAs($user)
        ->get(route('purchases'))
        ->assertOk()
        ->assertSee('GitHub repositories')
        ->assertSee('Retry repository access')
        ->assertDontSee('Renew your license to restore GitHub repository access.')
        ->assertDontSee('Connect to GitHub to get access to the repository');
})->with([true, false]);
