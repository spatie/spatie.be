<?php

use App\Domain\Shop\Enums\PurchasableType;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\Series;
use App\Models\User;
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
