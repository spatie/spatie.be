<?php

namespace App\Console\Commands;

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

        dd($this->api->campaigns());

        $this->info('All done!');
    }
}
