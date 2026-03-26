<?php

namespace Database\Seeders;

use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Paddle\Receipt;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'like', 'freek%')->first() ?? User::first();

        if (! $user) {
            return;
        }

        $products = Product::with('purchasablesWithoutRenewals')->get();

        foreach ($products->take(3) as $index => $product) {
            $purchasable = $product->purchasablesWithoutRenewals->first();

            if (! $purchasable) {
                continue;
            }

            $paidAt = now()->subMonths($index + 1)->subDays($index * 5);

            $receipt = Receipt::create([
                'billable_id' => $user->id,
                'billable_type' => $user->getMorphClass(),
                'checkout_id' => fake()->uuid(),
                'order_id' => (string) fake()->numberBetween(10000000, 99999999),
                'amount' => number_format($purchasable->price_in_usd_cents / 100, 2),
                'tax' => number_format($purchasable->price_in_usd_cents / 100 * 0.21, 2),
                'currency' => 'EUR',
                'quantity' => 1,
                'receipt_url' => 'https://my.paddle.com/receipt/' . fake()->numberBetween(10000000, 99999999) . '/' . fake()->uuid(),
                'paid_at' => $paidAt,
            ]);

            Purchase::create([
                'user_id' => $user->id,
                'purchasable_id' => $purchasable->id,
                'receipt_id' => $receipt->id,
                'paddle_webhook_payload' => '{}',
                'paddle_fee' => '0',
                'earnings' => number_format($purchasable->price_in_usd_cents / 100, 2),
                'quantity' => 1,
            ]);
        }
    }
}
