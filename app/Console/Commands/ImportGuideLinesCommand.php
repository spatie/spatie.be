<?php

namespace App\Console\Commands;

use App\Guidelines\ResolveGuidelinesAction;
use Illuminate\Console\Command;

class ImportGuideLinesCommand extends Command
{
    public $signature = 'guidelines:import';

    public function handle(): void
    {
        $this->info('Importing guidelines...');

        resolve(ResolveGuidelinesAction::class)->execute(refresh: true);

        $this->info('All done!');
    }
}
