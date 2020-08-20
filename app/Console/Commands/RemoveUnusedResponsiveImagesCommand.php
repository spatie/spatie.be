<?php

namespace App\Console\Commands;

use App\Models\Postcard;
use Illuminate\Console\Command;

class RemoveUnusedResponsiveImagesCommand extends Command
{
    protected $signature = 'postcard:remove-conversions';

    protected $description = 'Removes the thumb conversions';

    public function handle()
    {
        Postcard::each(function (Postcard $postcard ) {
            $postcard->clearMediaCollection('thumb');
        });
    }
}
