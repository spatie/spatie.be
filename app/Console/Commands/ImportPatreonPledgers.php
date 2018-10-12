<?php

namespace App\Console\Commands;

use App\Models\Patreon;
use App\Services\Patreon\PatreonApi;
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

        $pledges = $this->api->pledges('795100');

        foreach ($pledges as $pledge) {
            if ($pledge->amount > 500) {
                Patreon::import($pledge->user);
            }
        }

        $this->info('All done!');
    }
}
