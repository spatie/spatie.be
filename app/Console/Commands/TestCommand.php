<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test-ray';

    protected $description = 'Command description';

    public function handle()
    {
        ray('Greetings from the remote server');
    }
}
