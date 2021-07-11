<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sheets\Sheets;

class ImportGuideLinesCommand extends Command
{
    public $signature = 'guidelines:import';

    public function handle()
    {
        $this->info('Importing guidelines...');

        $pages = app(Sheets::class)->collection('guidelines')->all()->sortBy('weight');

        cache()->store('guidelines')->forever('guidelines', $pages);

        $this->info('All done!');
    }
}
