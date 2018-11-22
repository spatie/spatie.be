<?php

namespace App\Console\Commands;

use App\Models\PatreonPledger;
use App\Services\Patreon\Patreon;
use App\Services\Patreon\Resources\Campaign;
use App\Services\Patreon\Resources\Pledge;
use App\Services\Patreon\Resources\Reward;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportPatreonPledgers extends Command
{
    protected $signature = 'import:patreon-pledgers';

    protected $description = 'Import pledgers from Patreon';

    /** @var \App\Services\Patreon\Patreon */
    protected $patreon;

    public function __construct(Patreon $patreon)
    {
        $this->patreon = $patreon;

        parent::__construct();
    }

    public function handle()
    {
        $this->info('Importing pledgers from Patreon...');

        $this->removePreviousPledgers();

        $campaigns = $this->patreon->campaigns();

        if ($campaigns->count() === 0) {
            throw new Exception("No Patreon campaigns found.");
        }

        $this->getPledges($campaigns->first())->each(function (Pledge $pledge) {
            PatreonPledger::import($pledge->user);
        });

        $this->info('All done!');
    }

    protected function getPledges(Campaign $campaign): Collection
    {
        $rewards = $this->getSuitableRewards($campaign);

        return $this->patreon->pledges($campaign->id)->filter(function (Pledge $pledge) use ($rewards) {
            return $rewards->contains(function (Reward $reward) use ($pledge) {
                return $reward->id === $pledge->rewardId;
            });
        });
    }

    protected function getSuitableRewards(Campaign $campaign): Collection
    {
        $minimalAmount = 5000;

        return $campaign->rewards->filter(function (Reward $reward) use ($minimalAmount) {
            return $reward->amount >= $minimalAmount;
        })->values();
    }

    protected function removePreviousPledgers()
    {
        PatreonPledger::query()->truncate();
    }
}
