<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\Product;
use App\Models\Purchasable;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Laravel\Paddle\Receipt;

class ImportPurchasesFromExternalDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:purchases {db}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import purchases from an external DB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $purchases = DB::connection($this->argument('db'))
            ->table('purchases')
            ->leftJoin('users', 'purchases.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.id', '=', 'purchases.product_id');

        if (Schema::connection($this->argument('db'))->hasTable('licenses')) {
            $purchases = $purchases->leftJoin('licenses', 'licenses.id', '=', 'purchases.license_id');
        }

        $purchases = $purchases->select(
            'purchases.*',
            DB::raw('users.email as user_email'),
            DB::raw('users.password as user_password'),
            DB::raw('users.name as user_name'),
            DB::raw('users.github_username as user_github_username'),
            DB::raw('users.github_id as user_github_id'),
            DB::raw('users.created_at as user_created_at'),
            DB::raw('products.paddle_product_id as product_paddle_id'),
            DB::raw('products.name as product_name'),
            DB::raw('products.type as product_type'),
        );

        if (Schema::connection($this->argument('db'))->hasTable('licenses')) {
            $purchases = $purchases->addSelect([
                DB::raw('licenses.uuid as license_uuid'),
                DB::raw('licenses.domain as license_domain'),
                DB::raw('licenses.key as license_key'),
                DB::raw('licenses.expires_at as license_expires_at'),
                DB::raw('licenses.created_at as license_created_at'),
            ]);
        }

        $purchases = $purchases->get();

        $this->getOutput()->progressStart(count($purchases));

        foreach ($purchases as $purchase) {
            /** @var User $user */
            $user = User::firstOrCreate([
                'email' => $purchase->user_email,
            ], [
                'name' => $purchase->user_name,
                'password' => $purchase->user_password,
                'github_username' => $purchase->user_github_username,
                'github_id' => $purchase->user_github_id,
                'created_at' => $purchase->user_created_at,
            ]);

            $purchasable = Purchasable::query()
                ->where('title', $purchase->product_name)
                ->where('paddle_product_id', $purchase->product_paddle_id)
                ->first();

            if (! $purchasable) {
                $product = Product::firstOrCreate([
                    'title' => $purchase->product_name,
                ], [
                    'description' => '',
                    'url' => '',
                    'action_url' => '',
                    'action_label' => '',
                    'slug' => Str::slug($purchase->product_name),
                ]);

                $purchasable = Purchasable::create([
                    'paddle_product_id' => $purchase->product_paddle_id,
                    'product_id' => $product->id,
                    'title' => $purchase->product_name,
                    'description' => '',
                    'type' => $purchase->product_type,
                ]);
            }

            if (isset($purchase->license_key) && $purchase->license_key) {
                $license = License::create([
                    'user_id' => $user->id,
                    'purchasable_id' => $purchasable->id,
                    'key' => $purchase->license_key,
                    'expires_at' => $purchase->license_expires_at,
                    'created_at' => $purchase->license_created_at,
                ]);
            }

            if (isset($purchase->paddle_webhook_payload)) {
                $payload = json_decode($purchase->paddle_webhook_payload ?? $purchase->paddle_response, true);
            } else {
                $payload = json_decode($purchase->paddle_response, true);
                $payload = array_merge($payload['order'], [
                    'checkout_id' => $payload['checkout']['checkout_id'],
                    'sale_gross' => $payload['order']['total'],
                    'payment_tax' => $payload['order']['total_tax'],
                    'quantity' => 1,
                    'event_time' => Carbon::parse($payload['order']['completed']['date'], 'UTC'),
                ]);
            }

            $receipt = Receipt::firstOrCreate([
                'order_id' => $payload['order_id'],
            ], [
                'billable_id' => $user->id,
                'billable_type' => $user->getMorphClass(),
                'paddle_subscription_id' => $payload['subscription_id'] ?? null,
                'checkout_id' => $payload['checkout_id'],
                'amount' => $payload['sale_gross'],
                'tax' => $payload['payment_tax'],
                'currency' => $payload['currency'],
                'quantity' => (int) $payload['quantity'],
                'receipt_url' => $payload['receipt_url'],
                'paid_at' => Carbon::createFromFormat('Y-m-d H:i:s', $payload['event_time'], 'UTC'),
                'created_at' => $purchase->created_at,
                'updated_at' => $purchase->updated_at,
            ]);

            Purchase::create([
                'user_id' => $user->id,
                'purchasable_id' => $purchasable->id,
                'license_id' => isset($license) ? $license->id : null,
                'receipt_id' => $receipt->id,
                'created_at' => $purchase->created_at,
                'updated_at' => $purchase->updated_at,
                'paddle_webhook_payload' => $payload,
                'paddle_fee' => $payload['fee'] ?? 0,
                'earnings' => $payload['earnings'] ?? 0, // Cannot check earnings for these
            ]);

            $this->getOutput()->progressAdvance(1);
        }

        $this->getOutput()->progressFinish();
    }
}
