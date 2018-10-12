<?php

namespace App\Console\Commands;

use App\Models\Patreon;
use App\Services\Patreon\PatreonApi;
use App\Services\Patreon\Resources\Pledge;
use App\Services\Patreon\Resources\Reward;
use Illuminate\Console\Command;

class ImportPatreonPledgers extends Command
{
    protected $signature = 'import:patreon-pledgers';

    protected $description = 'Import pledgers from Patreon';

    /** @var \App\Services\Patreon\PatreonApi */
    protected $api;


    public function __construct(PatreonApi $api)
    {
        $this->api = $api;

        parent::__construct();
    }

    public function handle()
    {
        $this->info('Importing pledgers from Patreon...');

        $campagin = $this->api->campaigns()->first();

        $validRewards = $campagin->rewards->filter(function (Reward $reward) {
            return $reward->amount >= 5000;
        });

        $pledges = $this->api->pledges($campagin->id)->filter(function (Pledge $pledge) use ($validRewards) {
            return $validRewards->contains(function (Reward $reward) use ($pledge) {
                return $reward->id === $pledge->rewardId;
            });
        });

        foreach ($pledges as $pledge) {
            if ($pledge->amount > 500) {
                Patreon::import($pledge->user);
            }
        }

        $this->info('All done!');
    }
}
