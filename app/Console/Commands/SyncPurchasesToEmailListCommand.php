<?php

namespace App\Console\Commands;

use App\Actions\AddPurchasedTagsToEmailListSubscriberAction;
use App\Models\Purchase;
use Illuminate\Console\Command;

class SyncPurchasesToEmailListCommand extends Command
{
    protected $signature = 'sync-purchases-to-email-list';

    protected $description = 'Sync purchasables to email list';

    public function handle()
    {
        $this->info('Syncing purchasables to email list');

        Purchase::each(function (Purchase $purchase) {
            $this->comment("Processing purchase `{$purchase->id}`...");
            (new AddPurchasedTagsToEmailListSubscriberAction)->execute($purchase);
        });

        $this->info('All done!');
    }
}
